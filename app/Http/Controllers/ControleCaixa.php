<?php

namespace App\Http\Controllers;

use App\Models\Venda;
use App\Models\Produto;
use App\Models\ItemVenda;
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

            // Calcular total
            $totalVenda = array_sum(array_column($carrinho, 'subtotal'));

            // Criar venda - APENAS COM AS COLUNAS QUE EXISTEM NA TABELA
            $venda = Venda::create([
                'data' => now(),
                'valor_total' => $totalVenda,
                'forma_pagamento' => $request->forma_pagamento,
                'usuario_id' => Auth::id(),
                'status' => 'RE'
            ]);

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

}