<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produto;
use App\Models\Fornecedor;
use Illuminate\Support\Facades\DB;

class ControleProduto extends Controller
{
    public function index() 
    {
        $search = request('search');
        $status = request('status');
        // Visualização sempre agrupada agora (removido parâmetro agrupar)

        // ATUALIZAR STATUS AUTOMATICAMENTE antes de listar
        $this->verificarEAtualizarStatusEstoque();

        // Query base - apenas produtos ativos (A) ou baixo estoque (B)
        $query = Produto::whereIn('status', ['A', 'B']);

        // Filtro por status
        if ($status) {
            $query->where('status', $status);
        }

        // Busca
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nome', 'like', '%'.$search.'%')
                  ->orWhere('descricao', 'like', '%'.$search.'%')
                  ->orWhere('cod_barra', 'like', '%'.$search.'%');
            });
        }

        // Buscar todos os produtos que atendem aos filtros
        $todosProdutos = $query->with('fornecedor')->get();

        // Agrupar por cod_barra e pegar o último produto de cada grupo
        $produtos = $todosProdutos->groupBy('cod_barra')->map(function($grupo) {
            // Pegar o último produto cadastrado do grupo (maior ID)
            $ultimoProduto = $grupo->sortByDesc('id')->first();
            // Adicionar o total de itens do grupo
            $ultimoProduto->total_estoque = $grupo->count();
            return $ultimoProduto;
        })->values();

        // Ordenar por status
        $produtos = $produtos->sortBy(function($produto) {
            return match($produto->status) {
                'B' => 1,
                'A' => 2,
                default => 3
            };
        })->values();

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
                'cod_barra' => 'nullable|string|max:50',
                'preco_compra' => 'nullable|numeric|min:0',
                'preco_venda' => 'required|numeric|min:0',
                'quantidade_compra' => 'required|integer|min:1',
                'estoque_minimo' => 'required|integer|min:0',
                'fornecedor_id' => 'required|exists:fornecedors,id'
            ]);

            DB::beginTransaction();
            
            $quantidadeCompra = $request->quantidade_compra;
            $produtosCriados = 0;

            // Criar N registros de produtos baseado na quantidade_compra
            for ($i = 0; $i < $quantidadeCompra; $i++) {
                $produto = Produto::create([
                    'nome' => $request->nome,
                    'descricao' => $request->descricao,
                    'cod_barra' => $request->cod_barra,
                    'preco_compra' => $request->preco_compra,
                    'preco_venda' => $request->preco_venda,
                    'quantidade_compra' => 1, // Cada registro representa 1 unidade
                    'estoque_minimo' => $request->estoque_minimo,
                    'fornecedor_id' => $request->fornecedor_id,
                    'status' => 'A'
                ]);

                $produtosCriados++;
            }

            // Atualizar o nome, preco_venda e estoque_minimo de todos os produtos com mesmo cod_barra
            if ($request->cod_barra) {
                Produto::where('cod_barra', $request->cod_barra)
                    ->update([
                        'nome' => $request->nome,
                        'preco_venda' => $request->preco_venda,
                        'estoque_minimo' => $request->estoque_minimo
                    ]);
            }

            DB::commit();

            // Verificar e atualizar status após cadastrar novos produtos
            $this->verificarEAtualizarStatusEstoque();

            return redirect()->route('produtos.index')
                ->with('success', "{$produtosCriados} produto(s) cadastrado(s) com sucesso!");

        } catch (\Exception $e) {
            DB::rollBack();
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
            'cod_barra' => 'nullable|string|max:50',
            'preco_compra' => 'nullable|numeric|min:0',
            'preco_venda' => 'required|numeric|min:0',
            'quantidade_compra' => 'required|integer|min:0',
            'estoque_minimo' => 'required|integer|min:0',
            'fornecedor_id' => 'required|exists:fornecedors,id',
            'status' => 'required|in:A,B,I'
        ]);

        try {
            $produto = Produto::findOrFail($id);
            $produto->update($request->all());

            // Atualizar o nome, preco_venda e estoque_minimo de todos os produtos com mesmo cod_barra
            if ($produto->cod_barra) {
                Produto::where('cod_barra', $produto->cod_barra)
                    ->where('id', '!=', $produto->id) // Não atualizar o próprio produto novamente
                    ->update([
                        'nome' => $produto->nome,
                        'preco_venda' => $produto->preco_venda,
                        'estoque_minimo' => $produto->estoque_minimo
                    ]);
            }

            // Verificar e atualizar status de todos os produtos com mesmo cod_barra
            $this->verificarEAtualizarStatusEstoque();

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

            // Verificar e atualizar status dos produtos restantes com mesmo cod_barra
            $this->verificarEAtualizarStatusEstoque();

            return redirect()->route('produtos.index')
                ->with('success', 'Produto marcado como inativo com sucesso!');
        } catch (\Exception $e) {
            return redirect()->route('produtos.index')
                ->with('error', 'Erro ao desativar o produto: ' . $e->getMessage());
        }
    }

    /**
     * Verifica e atualiza o status de todos os produtos baseado no estoque total
     * - Se total de produtos (A+B) <= estoque_minimo: muda todos para 'B' (Baixo Estoque)
     * - Se total de produtos (A+B) > estoque_minimo: muda todos 'B' para 'A' (Ativo)
     */
    private function verificarEAtualizarStatusEstoque()
    {
        // Buscar todos os produtos (Ativos ou Baixo Estoque) agrupados por cod_barra
        $produtosAgrupados = Produto::whereIn('status', ['A', 'B'])
            ->select('cod_barra', 'estoque_minimo', DB::raw('COUNT(*) as total_estoque'))
            ->groupBy('cod_barra', 'estoque_minimo')
            ->get();

        foreach ($produtosAgrupados as $grupo) {
            if ($grupo->total_estoque <= $grupo->estoque_minimo) {
                // Estoque BAIXO: Mudar TODOS (A ou B) para status 'B'
                Produto::where('cod_barra', $grupo->cod_barra)
                    ->whereIn('status', ['A', 'B'])
                    ->update(['status' => 'B']);
            } else {
                // Estoque SUFICIENTE: Mudar todos 'B' para 'A'
                Produto::where('cod_barra', $grupo->cod_barra)
                    ->where('status', 'B')
                    ->update(['status' => 'A']);
            }
        }
    }

    private function atualizarStatusEstoque(Produto $produto)
    {
        if ($produto->quantidade_compra <= $produto->estoque_minimo && $produto->status === 'A') {
            $produto->update(['status' => 'B']); // Baixo Estoque
        } elseif ($produto->quantidade_compra > $produto->estoque_minimo && $produto->status === 'B') {
            $produto->update(['status' => 'A']); // Voltar para Ativo
        }
    }
}
