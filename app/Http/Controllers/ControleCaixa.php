<?php

namespace App\Http\Controllers;

use App\Models\Venda;
use App\Models\Produto;
use App\Models\ItemVenda;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ControleCaixa extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $searchTerm = $request->input('search');
        $produtos = collect();
        
        // Buscar produtos se houver termo de busca
        if ($searchTerm) {
            $produtosQuery = Produto::whereIn('status', ['A', 'B']) // produtos ativos ou baixo estoque
                ->where(function($query) use ($searchTerm) {
                    $query->where('nome', 'like', '%' . $searchTerm . '%')
                          ->orWhere('cod_loja', 'like', '%' . $searchTerm . '%');
                })
                ->orderBy('nome')
                ->get();
            
            // Agrupar por cod_loja
            $produtos = $produtosQuery->groupBy('cod_loja')->map(function($grupo) {
                // Pegar o último produto cadastrado do grupo
                $produto = $grupo->sortByDesc('id')->first();
                // Adicionar total de itens disponíveis
                $produto->total_disponivel = $grupo->count();
                return $produto;
            })->values();
        }
        
        $carrinho = Session::get('carrinho', []);
        
        return view('caixa.index', compact('produtos', 'carrinho', 'searchTerm'));
    }

    public function adicionarItemCarrinho(Request $request)
    {
        try {
            $produto = Produto::findOrFail($request->produto_id);
            
            // Verificar se o produto está ativo ou baixo estoque
            if (!in_array($produto->status, ['A', 'B'])) {
                return redirect()->back()->with('error', 'Este produto não está disponível para venda.');
            }

            $quantidade = $request->quantidade ?? 1;
            
            // Contar quantos produtos ativos/baixo estoque existem com mesmo cod_loja
            $estoqueDisponivel = Produto::where('cod_loja', $produto->cod_loja)
                ->whereIn('status', ['A', 'B'])
                ->count();
            
            // Verificar quantos já estão no carrinho
            $carrinho = Session::get('carrinho', []);
            $quantidadeNoCarrinho = 0;
            
            // Buscar se já existe produto com mesmo cod_loja no carrinho
            foreach ($carrinho as $item) {
                $itemProduto = Produto::find($item['id']);
                if ($itemProduto && $itemProduto->cod_loja === $produto->cod_loja) {
                    $quantidadeNoCarrinho += $item['quantidade'];
                }
            }
            
            $totalSolicitado = $quantidadeNoCarrinho + $quantidade;
            
            // Verificar estoque
            if ($totalSolicitado > $estoqueDisponivel) {
                return redirect()->back()->with('error', 'Estoque insuficiente. Disponível: ' . ($estoqueDisponivel - $quantidadeNoCarrinho));
            }

            if (isset($carrinho[$produto->id])) {
                $carrinho[$produto->id]['quantidade'] += $quantidade;
                $carrinho[$produto->id]['subtotal'] = $carrinho[$produto->id]['quantidade'] * $produto->preco_venda;
            } else {
                $carrinho[$produto->id] = [
                    'id' => $produto->id,
                    'nome' => $produto->nome,
                    'cod_loja' => $produto->cod_loja,
                    'preco' => $produto->preco_venda,
                    'quantidade' => $quantidade,
                    'subtotal' => $produto->preco_venda * $quantidade
                ];
            }

            Session::put('carrinho', $carrinho);

            return redirect()->route('caixa.index')->with('success', 'Produto adicionado ao carrinho!');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao adicionar produto: ' . $e->getMessage());
        }
    }

    public function removerItemCarrinho($id)
    {
        $carrinho = Session::get('carrinho', []);

        if (isset($carrinho[$id])) {
            unset($carrinho[$id]);
            Session::put('carrinho', $carrinho);
            return redirect()->route('caixa.index')->with('success', 'Produto removido do carrinho!');
        }

        return redirect()->route('caixa.index')->with('error', 'Produto não encontrado no carrinho!');
    }

    public function alterarQuantidadeItem(Request $request, $id)
    {
        $carrinho = Session::get('carrinho', []);
        
        if (isset($carrinho[$id])) {
            $quantidade = $request->quantidade;
            
            if ($quantidade < 1) {
                unset($carrinho[$id]);
                Session::put('carrinho', $carrinho);
                return redirect()->route('caixa.index')->with('success', 'Produto removido do carrinho!');
            }
            
            // Atualizar quantidade
            $carrinho[$id]['quantidade'] = $quantidade;
            $carrinho[$id]['subtotal'] = $carrinho[$id]['preco'] * $quantidade;
            
            Session::put('carrinho', $carrinho);
            return redirect()->route('caixa.index')->with('success', 'Quantidade atualizada!');
        }
        
        return redirect()->route('caixa.index')->with('error', 'Produto não encontrado no carrinho!');
    }

    public function limparCarrinho()
    {
        Session::forget('carrinho');
        return redirect()->route('caixa.index')->with('success', 'Carrinho limpo!');
    }

    public function storeVenda(Request $request)
    {
        DB::beginTransaction();

        try {
            $carrinho = Session::get('carrinho', []);
            
            if (empty($carrinho)) {
                return redirect()->back()->with('error', 'Carrinho vazio!');
            }

            // Verificar se o usuário existe na tabela users
            $user = Auth::user();
            if (!$user) {
                throw new \Exception('Usuário não autenticado');
            }

            // Calcular total
            $totalVenda = array_sum(array_column($carrinho, 'subtotal'));

            // Criar venda
            $venda = new Venda();
            $venda->data_venda = now(); // Isso garante que será salvo como DateTime
            $venda->valor_total = $totalVenda;
            $venda->forma_pagamento = $request->forma_pagamento;
            $venda->parcelas = $request->forma_pagamento === 'CR' ? ($request->parcelas ?? 1) : 1;
            $venda->usuario_id = $user->id;
            $venda->status = 'RE';
            $venda->save();

            // Adicionar itens da venda
            foreach ($carrinho as $item) {
                $quantidadeVendida = $item['quantidade'];
                
                // Buscar produtos disponíveis com mesmo cod_loja
                $produtosDisponiveis = Produto::where('cod_loja', $item['cod_loja'])
                    ->whereIn('status', ['A', 'B'])
                    ->orderBy('id', 'asc') // Vender os mais antigos primeiro
                    ->limit($quantidadeVendida)
                    ->get();
                
                if ($produtosDisponiveis->count() < $quantidadeVendida) {
                    throw new \Exception('Estoque insuficiente para ' . $item['nome']);
                }
                
                // Marcar cada produto individual como VENDIDO
                foreach ($produtosDisponiveis as $produtoVendido) {
                    ItemVenda::create([
                        'venda_id' => $venda->id,
                        'produto_id' => $produtoVendido->id,
                        'quantidade' => 1, // Cada registro representa 1 unidade vendida
                        'preco_unitario' => $item['preco'],
                        'subtotal' => $item['preco']
                    ]);
                    
                    // Mudar status do produto para VENDIDO
                    $produtoVendido->update(['status' => 'V']);
                }
            }

            // Limpar carrinho
            Session::forget('carrinho');

            DB::commit();

            return redirect()->route('caixa.historico')->with('success', 'Venda realizada com sucesso! Nº ' . $venda->id);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Erro ao processar venda: ' . $e->getMessage());
        }
    }

    public function historico()
    {
        $query = Venda::with('usuario')  // Carrega o relacionamento com usuário
            ->orderBy('created_at', 'desc');  // Ordena por data mais recente

        // Filtro por status
        if (request('status')) {
            $query->where('status', request('status'));
        }

        // Busca
        if (request('search')) {
            $search = request('search');
            $query->where(function($q) use ($search) {
                $q->whereHas('usuario', function($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%');
                })
                ->orWhere('forma_pagamento', 'like', '%' . $search . '%');
            });
        }

        $vendas = $query->get();

        return view('caixa.historico', compact('vendas'));
    }

    public function show($id)
    {
        $venda = Venda::with(['itens.produto', 'usuario'])->findOrFail($id);

        return view('caixa.detalhes', compact('venda'));
    }

    public function cancelarVenda($id)
    {
        try {
            DB::beginTransaction();
            
            // Busca a venda com seus itens
            $venda = Venda::with('itens.produto')->findOrFail($id);
            
            // Verifica se a venda já está cancelada
            if ($venda->status === 'CA') {
                return redirect()->back()->with('error', 'Esta venda já está cancelada.');
            }

            // Retorna os produtos ao estoque (mudando status de V para A)
            foreach ($venda->itens as $item) {
                $produto = Produto::find($item->produto_id);
                if ($produto && $produto->status === 'V') {
                    // Voltar produto para status ATIVO
                    $produto->update(['status' => 'A']);
                }
            }

            // Atualiza o status da venda
            $venda->status = 'CA';
            $venda->save();

            DB::commit();
            return redirect()->route('caixa.historico')
                ->with('success', 'Venda #' . $venda->id . ' cancelada com sucesso! Produtos retornaram ao estoque.');
            
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Erro ao cancelar venda: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Erro ao cancelar a venda: ' . $e->getMessage());
        }
    }

    public function detalhesVenda($id)
    {
        $venda = Venda::with(['itens.produto', 'usuario'])
            ->findOrFail($id);
        
        return view('caixa.detalhes-venda', compact('venda'));
    }

    

}