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
            $produtos = Produto::where('quantidade_estoque', '>', 0)
                ->where('status', 'A', 'B') // produtos ativos
                ->where(function($query) use ($searchTerm) {
                    $query->where('nome', 'like', '%' . $searchTerm . '%');
                })
                ->orderBy('nome')
                ->get();
        }
        
        $carrinho = Session::get('carrinho', []);
        
        return view('caixa.index', compact('produtos', 'carrinho', 'searchTerm'));
    }

    public function adicionarItemCarrinho(Request $request)
    {
        try {
            $produto = Produto::findOrFail($request->produto_id);
            
            // Verificar se o produto está ativo
            if ($produto->status !== 'A') {
                return redirect()->back()->with('error', 'Este produto não está disponível para venda.');
            }

            $quantidade = $request->quantidade ?? 1;
            
            // Verificar estoque
            if ($produto->quantidade_estoque < $quantidade) {
                return redirect()->back()->with('error', 'Estoque insuficiente. Disponível: ' . $produto->quantidade_estoque);
            }

            $carrinho = Session::get('carrinho', []);

            if (isset($carrinho[$produto->id])) {
                $carrinho[$produto->id]['quantidade'] += $quantidade;
                $carrinho[$produto->id]['subtotal'] = $carrinho[$produto->id]['quantidade'] * $produto->preco;
            } else {
                $carrinho[$produto->id] = [
                    'id' => $produto->id,
                    'nome' => $produto->nome,
                    'preco' => $produto->preco,
                    'quantidade' => $quantidade,
                    'subtotal' => $produto->preco * $quantidade
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
            $venda->usuario_id = $user->id;
            $venda->status = 'RE';
            $venda->save();

            // Adicionar itens da venda
            foreach ($carrinho as $item) {
                $produto = Produto::find($item['id']);
                
                if ($produto) {
                    ItemVenda::create([
                        'venda_id' => $venda->id,
                        'produto_id' => $item['id'],
                        'quantidade' => $item['quantidade'],
                        'preco_unitario' => $item['preco'],
                        'subtotal' => $item['subtotal']
                    ]);

                    // Atualizar estoque
                    $produto->decrement('quantidade_estoque', $item['quantidade']);

                    // Verificar e atualizar status baseado no estoque
                    if ($produto->quantidade_estoque <= $produto->estoque_minimo) {
                        $produto->update(['status' => 'B']); // B = Baixo Estoque
                    } elseif ($produto->quantidade_estoque > $produto->estoque_minimo) {
                        $produto->update(['status' => 'A']); // A = Ativo
                    }
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
        $vendas = Venda::with(['itens.produto', 'usuario'])
            ->orderBy('data_venda', 'desc')
            ->paginate(10);
            
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

            // Retorna os produtos ao estoque
            foreach ($venda->itens as $item) {
                $produto = Produto::find($item->produto_id);
                if ($produto) {
                    $produto->quantidade_estoque += $item->quantidade;
                    $produto->save();

                    // Verificar e atualizar status baseado no estoque
                    if ($produto->quantidade_estoque <= $produto->estoque_minimo) {
                        $produto->update(['status' => 'B']); // B = Baixo Estoque
                    } elseif ($produto->quantidade_estoque > $produto->estoque_minimo) {
                        $produto->update(['status' => 'A']); // A = Ativo
                    }
                }
            }

            // Atualiza o status da venda
            $venda->status = 'CA';
            $venda->save();

            DB::commit();
            return redirect()->route('caixa.historico')
                ->with('success', 'Venda #' . $venda->id . ' cancelada com sucesso!');
            
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