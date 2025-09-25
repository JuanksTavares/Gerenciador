<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produto;
use App\Models\Fornecedor;

class ControleProduto extends Controller
{
    public function index() 
    {
        $search = request('search');
        $status = request('status');

        $query = Produto::with('fornecedor'); // Carrega o relacionamento com fornecedor

        // Filtro por status
        if ($status) {
            $query->where('status', $status);
        }

        // Busca
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nome', 'like', '%'.$search.'%')
                  ->orWhere('descricao', 'like', '%'.$search.'%')
                  ->orWhereHas('fornecedor', function($q) use ($search) {
                      $q->where('nome', 'like', '%'.$search.'%');
                  });
            });
        }

        // Ordenação
        $query->orderByRaw("CASE 
            WHEN status = 'B' THEN 1
            WHEN status = 'A' THEN 2
            ELSE 3
        END");

        $produtos = $query->get();

        return view('produto.index', compact('produtos', 'search'));
    }

    public function adicionar()
    {
        $fornecedores = Fornecedor::all();
        return view('produto.adicionar', compact('fornecedores'));
    }

    public function store(Request $request) 
    {
        try {
            // Validação dos dados
            $request->validate([
                'nome' => 'required|string|max:100',
                'descricao' => 'nullable|string',
                'preco' => 'required|numeric|min:0',
                'quantidade_estoque' => 'required|integer|min:0',
                'estoque_minimo' => 'required|integer|min:0',
                'fornecedor_id' => 'required|exists:fornecedors,id',
                'status' => 'required|in:A,B,I'
            ]);
            
            // Criação do produto
            $produto = Produto::create([
                'nome' => $request->nome,
                'descricao' => $request->descricao,
                'preco' => $request->preco,
                'quantidade_estoque' => $request->quantidade_estoque,
                'estoque_minimo' => $request->estoque_minimo,
                'fornecedor_id' => $request->fornecedor_id,
                'status' => $request->status ?? 'A'
            ]);

            // Verifica o status do estoque
            if ($produto->quantidade_estoque <= $produto->estoque_minimo) {
                $produto->update(['status' => 'B']);
            }

            return redirect()->route('produtos.index')
                ->with('success', 'Produto cadastrado com sucesso!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erro ao cadastrar produto: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function edit($id)
    {
        $produto = Produto::findOrFail($id);
        $fornecedores = Fornecedor::all();
        
        return view('produto.edit', [
            'produto' => $produto,
            'fornecedores' => $fornecedores
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nome' => 'required|string|max:100',
            'descricao' => 'nullable|string',
            'preco' => 'required|numeric|min:0',
            'quantidade_estoque' => 'required|integer|min:0',
            'estoque_minimo' => 'required|integer|min:0',
            'fornecedor_id' => 'required|exists:fornecedors,id',
            'status' => 'required|in:A,B,I'
        ]);

        try {
            $produto = Produto::findOrFail($id);
            $produto->update($request->all());

            // Verificar e atualizar status baseado no estoque
            if ($produto->quantidade_estoque <= $produto->estoque_minimo) {
                $produto->update(['status' => 'B']); // B = Baixo Estoque
            } elseif ($produto->quantidade_estoque > $produto->estoque_minimo) {
                $produto->update(['status' => 'A']); // A = Ativo
            }

            return redirect()->route('produtos.index')
                ->with('success', 'Produto atualizado com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erro ao atualizar produto: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy($id)
    {
        $produto = Produto::findOrFail($id);
        
        try {
            $produto->update([
                'status' => 'I'  // Marca como inativo ao invés de deletar
            ]);

            return redirect()->route('produtos.index')
                ->with('success', 'Produto marcado como inativo com sucesso!');
        } catch (\Exception $e) {
            return redirect()->route('produtos.index')
                ->with('error', 'Erro ao desativar o produto: ' . $e->getMessage());
        }
    }

    private function atualizarStatusEstoque(Produto $produto)
    {
        if ($produto->quantidade_estoque <= $produto->estoque_minimo && $produto->status === 'A') {
            $produto->update(['status' => 'B']); // Baixo Estoque
        } elseif ($produto->quantidade_estoque > $produto->estoque_minimo && $produto->status === 'B') {
            $produto->update(['status' => 'A']); // Voltar para Ativo
        }
    }
}
