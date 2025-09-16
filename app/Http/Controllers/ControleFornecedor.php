<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fornecedor;
use Illuminate\Support\Facades\Validator;

class ControleFornecedor extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $search = request('search');

        if ($search) {
            $fornecedores = Fornecedor::where('nome', 'like', '%'.$search.'%')
                ->orWhere('cnpj', 'like', '%'.$search.'%')
                ->orWhere('email', 'like', '%'.$search.'%')
                ->get();
        } else {
            $fornecedores = Fornecedor::all();
        }

        return view('fornecedor.index', compact('fornecedores', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function adicionar()
    {
        return view('fornecedor.adicionar');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validação dos dados
        $validator = Validator::make($request->all(), [
            'nome' => 'required|string|max:100',
            'cnpj' => 'required|string|max:18|unique:fornecedors,cnpj',
            'telefone' => 'nullable|string|max:15',
            'email' => 'required|email|max:100|unique:fornecedors,email',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        Fornecedor::create($request->all());

        return redirect()->route('fornecedores.index')
            ->with('success', 'Fornecedor cadastrado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $fornecedor = Fornecedor::with('produtos')->findOrFail($id);
        return view('fornecedor.show', compact('fornecedor'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $fornecedor = Fornecedor::findOrFail($id);
        return view('fornecedor.edit', compact('fornecedor'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $fornecedor = Fornecedor::findOrFail($id);

        // Validação dos dados
        $validator = Validator::make($request->all(), [
            'nome' => 'required|string|max:100',
            'cnpj' => 'required|string|max:18|unique:fornecedors,cnpj,'.$fornecedor->id,
            'telefone' => 'nullable|string|max:15',
            'email' => 'required|email|max:100|unique:fornecedors,email,'.$fornecedor->id,
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $fornecedor->update($request->all());

        return redirect()->route('fornecedores.index')
            ->with('success', 'Fornecedor atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $fornecedor = Fornecedor::findOrFail($id);
        
        // Verificar se o fornecedor tem produtos associados
        if ($fornecedor->produtos()->count() > 0) {
            return redirect()->route('fornecedores.index')
                ->with('error', 'Não é possível excluir o fornecedor pois existem produtos associados.');
        }

        $fornecedor->delete();

        return redirect()->route('fornecedores.index')
            ->with('success', 'Fornecedor excluído com sucesso!');
    }

    /**
     * API - Listar fornecedores para select
     */
    public function apiFornecedores(Request $request)
    {
        $fornecedores = Fornecedor::select('id', 'nome')
            ->when($request->has('search'), function($query) use ($request) {
                $query->where('nome', 'like', '%'.$request->search.'%');
            })
            ->get();

        return response()->json($fornecedores);
    }
}