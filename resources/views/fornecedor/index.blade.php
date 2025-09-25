@extends('layout')
<title>Fornecedor</title>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Fornecedor') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-1">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    
                    <nav class="navbar bg-light">
                        <div class="container-fluid">
                            <a href="/fornecedores/adicionar" class="btn btn-outline-dark">cadastrar</a>
                            <form class="d-flex" role="search" action="{{ route('fornecedores.index') }}" method="GET">
                                <input class="form-control me-2" type="search" placeholder="Buscar fornecedor..." 
                                       aria-label="Search" name="search" value="{{ $search ?? '' }}">
                                <button class="btn btn-outline-dark" type="submit">Buscar</button>
                            </form>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if ($search)
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                                Resultados para: "{{ $search }}" 
                                ({{ $fornecedores->count() }} {{ Str::plural('resultado', $fornecedores->count()) }})
                            </h2>
                            <a href="{{ route('fornecedores.index') }}" class="btn btn-outline-dark">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                                    <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z"/>
                                </svg>
                                Limpar busca
                            </a>
                        </div>
                    @endif

                    <!-- Tabela de Fornecedores -->
                    <div>
                        <table class="table">
                            
                            <tr>
                               <td>ID</td>
                                <td>Nome</th>
                                <td>Documento</th>
                                <td>Telefone</th>
                                <td>Email</th>
                                <td>Ações</th>
                            </tr>
                            <tr>
                                @forelse($fornecedores as $fornecedor)
                                <tr>
                                    <td >{{ $fornecedor->id }}</td>
                                    <td >{{ $fornecedor->nome }}</td>
                                    <td>
                                        {{ $fornecedor->tipo_documento }}: {{ $fornecedor->cnpj_formatado }}
                                    </td>
                                    <td >{{ $fornecedor->telefone_formatado }}</td>
                                    <td >{{ $fornecedor->email }}</td>
                                    <td >
                                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                            <a href="{{ route('fornecedores.edit', $fornecedor->id) }}" class="btn btn-outline-success btn-sm me-1">Editar</a>
                                            <form action="{{ route('fornecedores.destroy', $fornecedor->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir este fornecedor?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-outline-danger btn-sm" type="submit">Deletar</button>
                                            </form>
                                    
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-2 border text-center">Nenhum fornecedor encontrado.</td>
                                </tr>
                                @endforelse
                            </tr>
                        </table>
                    </div>
                     <!-- <a href="/fornecedores" class="btn btn-dark mb-2">Voltar</a>  --> 
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
