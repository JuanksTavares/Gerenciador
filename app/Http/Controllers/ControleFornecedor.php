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
            $fornecedores = Fornecedor::where(function($query) use ($search) {
                $query->where('nome', 'like', '%'.$search.'%')
                      ->orWhere('cnpj', 'like', '%'.$search.'%')
                      ->orWhere('email', 'like', '%'.$search.'%')
                      ->orWhere('telefone', 'like', '%'.$search.'%');
            })->get();
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
        // Remove caracteres especiais do documento
        $documento = preg_replace('/[^0-9]/', '', $request->cnpj);
        
        // Determina se é CPF ou CNPJ baseado no tamanho
        $tipoDocumento = strlen($documento) === 11 ? 'CPF' : 'CNPJ';
        
        // Regras de validação
        $rules = [
            'nome' => 'required|string|max:100',
            'cnpj' => [
                'required',
                'string',
                function ($attribute, $value, $fail) {
                    $clean = preg_replace('/[^0-9]/', '', $value);
                    $length = strlen($clean);
                    
                    if ($length !== 11 && $length !== 14) {
                        $fail('O documento deve ser um CPF (11 dígitos) ou CNPJ (14 dígitos) válido.');
                    }
                    
                    if ($length === 11 && !$this->validaCPF($clean)) {
                        $fail('O CPF informado não é válido.');
                    }
                    
                    if ($length === 14 && !$this->validaCNPJ($clean)) {
                        $fail('O CNPJ informado não é válido.');
                    }
                },
                'unique:fornecedors,cnpj'
            ],
            'telefone' => 'nullable|string|max:15',
            'email' => 'required|email|max:100|unique:fornecedors,email',
        ];

        $messages = [
            'cnpj.required' => 'O campo CPF/CNPJ é obrigatório',
            'cnpj.unique' => 'Este CPF/CNPJ já está cadastrado',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

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

    // Adicione estas funções de validação
    private function validaCPF($cpf) {
        // Remove caracteres especiais
        $cpf = preg_replace('/[^0-9]/', '', $cpf);
        
        // Verifica se tem 11 dígitos
        if (strlen($cpf) != 11) {
            return false;
        }
        
        // Verifica se todos os dígitos são iguais
        if (preg_match('/^(\d)\1+$/', $cpf)) {
            return false;
        }
        
        // Validação do primeiro dígito verificador
        $soma = 0;
        for ($i = 0; $i < 9; $i++) {
            $soma += ($cpf[$i] * (10 - $i));
        }
        $resto = $soma % 11;
        $dv1 = ($resto < 2) ? 0 : 11 - $resto;
        if ($cpf[9] != $dv1) {
            return false;
        }
        
        // Validação do segundo dígito verificador
        $soma = 0;
        for ($i = 0; $i < 10; $i++) {
            $soma += ($cpf[$i] * (11 - $i));
        }
        $resto = $soma % 11;
        $dv2 = ($resto < 2) ? 0 : 11 - $resto;
        
        return ($cpf[10] == $dv2);
    }

    private function validaCNPJ($cnpj) {
        // Remove caracteres especiais
        $cnpj = preg_replace('/[^0-9]/', '', $cnpj);
        
        // Verifica se tem 14 dígitos
        if (strlen($cnpj) != 14) {
            return false;
        }
        
        // Verifica se todos os dígitos são iguais
        if (preg_match('/^(\d)\1+$/', $cnpj)) {
            return false;
        }
        
        // Validação do primeiro dígito verificador
        $soma = 0;
        $multiplicador = 5;
        for ($i = 0; $i < 12; $i++) {
            $soma += $cnpj[$i] * $multiplicador;
            $multiplicador = ($multiplicador == 2) ? 9 : $multiplicador - 1;
        }
        $resto = $soma % 11;
        $dv1 = ($resto < 2) ? 0 : 11 - $resto;
        if ($cnpj[12] != $dv1) {
            return false;
        }
        
        // Validação do segundo dígito verificador
        $soma = 0;
        $multiplicador = 6;
        for ($i = 0; $i < 13; $i++) {
            $soma += $cnpj[$i] * $multiplicador;
            $multiplicador = ($multiplicador == 2) ? 9 : $multiplicador - 1;
        }
        $resto = $soma % 11;
        $dv2 = ($resto < 2) ? 0 : 11 - $resto;
        
        return ($cnpj[13] == $dv2);
    }
}