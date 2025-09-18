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

        if($search) {
            $produtos = Produto::with('fornecedor')
                ->where('nome', 'like', '%'.$search.'%')
                ->get();
        } else {
            $produtos = Produto::with('fornecedor')->get();
        }

        return view('produto.index', [
            'produtos' => $produtos,
            'search' => $search
        ]);
    }

    public function adicionar()
    {
        $fornecedores = Fornecedor::all();
        return view('produto.adicionar', compact('fornecedores'));
    }

    public function store(Request $request) 
    {
        // Validação dos dados
        $request->validate([
            'nome' => 'required|string|max:100',
            'descricao' => 'nullable|string',
            'preco' => 'required|numeric|min:0',
            'quantidade_estoque' => 'required|integer|min:0',
            'estoque_minimo' => 'required|integer|min:0',
            'fornecedor_id' => 'required|exists:fornecedors,id'
        ]);
        
        // Criação do produto
        $produto = Produto::create([
            'nome' => $request->nome,
            'descricao' => $request->descricao, // ← Adicione esta linha
            'preco' => $request->preco,
            'quantidade_estoque' => $request->quantidade_estoque,
            'estoque_minimo' => $request->estoque_minimo,
            'fornecedor_id' => $request->fornecedor_id
        ]);

        return redirect()->route('produtos.index')
            ->with('success', 'Produto cadastrado com sucesso!');
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
        // Validação
        $request->validate([
            'nome' => 'required|string|max:100',
            'descricao' => 'nullable|string',
            'preco' => 'required|numeric|min:0',
            'quantidade_estoque' => 'required|integer|min:0',
            'estoque_minimo' => 'required|integer|min:0',
            'fornecedor_id' => 'required|exists:fornecedors,id'
        ]);

        // Atualização
        $produto = Produto::findOrFail($id);
        $produto->update([
            'nome' => $request->nome,
            'descricao' => $request->descricao, // ← Adicione esta linha
            'preco' => $request->preco,
            'quantidade_estoque' => $request->quantidade_estoque,
            'estoque_minimo' => $request->estoque_minimo,
            'fornecedor_id' => $request->fornecedor_id
        ]);

        return redirect()->route('produtos.index')
            ->with('success', 'Produto atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $produto = Produto::findOrFail($id);
        
        // Verificar se o produto está em vendas antes de excluir
        // if ($produto->itensVenda()->exists()) {
        //     return redirect()->route('produtos.index')
        //         ->with('error', 'Não é possível excluir o produto pois está associado a vendas.');
        // }
        
        $produto->delete();

        return redirect()->route('produtos.index')
            ->with('success', 'Produto excluído com sucesso!');
    }
}

// No método store


// No método update
