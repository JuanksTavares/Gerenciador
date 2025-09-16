<?php

namespace App\Http\Controllers;

use App\Models\Caixa;
use App\Models\Venda;
use App\Models\Produto;
use App\Models\ItemVenda;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ControleCaixa extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        try {
            // Buscar vendas com status 'RE' (Realizada) do usuário logado
            $vendas = Venda::with(['itens', 'usuario'])
                ->where('status', 'RE')
                ->where('usuario_id', Auth::id())
                ->get();
                
        } catch (\Illuminate\Database\QueryException $e) {
            $vendas = collect();
            Log::error('Erro ao buscar vendas: ' . $e->getMessage());
        }

        $produtos = Produto::all();
        return view('caixa', compact('vendas', 'produtos'));
    }

    public function buscarProdutos(Request $request)
    {
        $search = $request->input('busca');

        if ($search) {
            $produtos = Produto::where('nome', 'like', '%' . $search . '%')
                ->orWhere('codigo_barras', 'like', '%' . $search . '%')
                ->get();
        } else {
            $produtos = Produto::all();
        }

        return response()->json($produtos);
    }

    public function storeVenda(Request $request)
    {
        // Validação dos dados
        $request->validate([
            'produtos' => 'required|array',
            'produtos.*.id' => 'required|exists:produtos,id',
            'produtos.*.quantidade' => 'required|integer|min:1',
            'valor_total' => 'required|numeric|min:0',
            'forma_pagamento' => 'required|string|max:20',
            'parcelas' => 'nullable|integer|min:1'
        ]);

        try {
            // Iniciar transação
            \DB::beginTransaction();

            // Criar a venda
            $venda = Venda::create([
                'data' => now(),
                'valor_total' => $request->valor_total,
                'status' => 'RE', // Realizada
                'forma_pagamento' => $request->forma_pagamento,
                'usuario_id' => Auth::id(),
                'parcelas' => $request->parcelas ?? 1
            ]);

            // Adicionar itens da venda
            foreach ($request->produtos as $item) {
                $produto = Produto::findOrFail($item['id']);
                
                // Criar item da venda
                ItemVenda::create([
                    'quantidade' => $item['quantidade'],
                    'preco_unitario' => $produto->preco,
                    'subtotal' => $item['quantidade'] * $produto->preco,
                    'venda_id' => $venda->id,
                    'produto_id' => $produto->id
                ]);

                // Atualizar estoque
                $produto->decrement('quantidade_estoque', $item['quantidade']);
            }

            // Commit da transação
            \DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Venda realizada com sucesso!',
                'venda_id' => $venda->id
            ]);

        } catch (\Exception $e) {
            // Rollback em caso de erro
            \DB::rollBack();
            Log::error('Erro ao processar venda: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Erro ao processar venda: ' . $e->getMessage()
            ], 500);
        }
    }

    public function adicionarItemCarrinho(Request $request)
    {
        $request->validate([
            'produto_id' => 'required|exists:produtos,id',
            'quantidade' => 'required|integer|min:1'
        ]);

        $produto = Produto::findOrFail($request->produto_id);

        // Verificar estoque
        if ($produto->quantidade_estoque < $request->quantidade) {
            return response()->json([
                'success' => false,
                'message' => 'Estoque insuficiente. Disponível: ' . $produto->quantidade_estoque
            ], 400);
        }

        // Adicionar ao carrinho (session)
        $carrinho = session()->get('carrinho', []);

        if (isset($carrinho[$produto->id])) {
            $carrinho[$produto->id]['quantidade'] += $request->quantidade;
        } else {
            $carrinho[$produto->id] = [
                'id' => $produto->id,
                'nome' => $produto->nome,
                'preco' => $produto->preco,
                'quantidade' => $request->quantidade,
                'subtotal' => $produto->preco * $request->quantidade
            ];
        }

        session()->put('carrinho', $carrinho);

        return response()->json([
            'success' => true,
            'carrinho' => $carrinho,
            'total_itens' => count($carrinho),
            'total_venda' => array_sum(array_column($carrinho, 'subtotal'))
        ]);
    }

    public function removerItemCarrinho(Request $request)
    {
        $carrinho = session()->get('carrinho', []);

        if (isset($carrinho[$request->produto_id])) {
            unset($carrinho[$request->produto_id]);
            session()->put('carrinho', $carrinho);
        }

        return response()->json([
            'success' => true,
            'carrinho' => $carrinho,
            'total_itens' => count($carrinho),
            'total_venda' => array_sum(array_column($carrinho, 'subtotal'))
        ]);
    }

    public function limparCarrinho()
    {
        session()->forget('carrinho');
        
        return response()->json([
            'success' => true,
            'message' => 'Carrinho limpo com sucesso!'
        ]);
    }

    public function obterCarrinho()
    {
        $carrinho = session()->get('carrinho', []);
        
        return response()->json([
            'carrinho' => $carrinho,
            'total_itens' => count($carrinho),
            'total_venda' => array_sum(array_column($carrinho, 'subtotal'))
        ]);
    }

    public function show($id)
    {
        $venda = Venda::with(['itens.produto', 'usuario'])->findOrFail($id);
        return view('caixa.detalhes-venda', compact('venda'));
    }

    public function cancelarVenda($id)
    {
        try {
            \DB::beginTransaction();

            $venda = Venda::findOrFail($id);
            
            // Restaurar estoque dos produtos
            foreach ($venda->itens as $item) {
                $produto = $item->produto;
                $produto->increment('quantidade_estoque', $item->quantidade);
            }

            // Cancelar venda
            $venda->update(['status' => 'CA']); // Cancelada

            \DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Venda cancelada com sucesso!'
            ]);

        } catch (\Exception $e) {
            \DB::rollBack();
            Log::error('Erro ao cancelar venda: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Erro ao cancelar venda: ' . $e->getMessage()
            ], 500);
        }
    }
}