@extends('layout')
<title>Editar Fornecedor</title>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar') }}
        </h2>
    </x-slot>
    <form action="{{ route('fornecedores.update', $fornecedor->id) }}"method = "post" class="row g-3 needs-validation" novalidate>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-1">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                            <label for="nome">Nome Fornecedor</label>
                            <input type="text" class="form-control" name="nome" id="nome" value="{{ old('nome', $fornecedor->nome) }}" required>

                            <label for="cnpj">CNPJ</label>
                            <input type="text" class="form-control" name="cnpj" id="cnpj" value="{{ old('cnpj', $fornecedor->cnpj) }}">

                            <label for="telefone">Telefone</label>
                            <input type="text" class="form-control" name="telefone" id="telefone" value="{{ old('telefone', $fornecedor->telefone) }}">

                            <label for="email">Email</label>
                            <input type="text" class="form-control" name="email" id="email" value="{{ old('email', $fornecedor->email) }}">
                            
                        </div>
                      <button class="btn btn-outline-success">Salvar</button>
                  </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
