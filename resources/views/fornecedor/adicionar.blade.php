@extends('layout')
<title>Cadastrar Fornecedor</title>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Cadastrar Fornecedor') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                  <form action="{{ route('fornecedores.store') }}" method="POST" id="formFornecedor" class="needs-validation" novalidate>
                    @csrf
                    <div class="mb-3">
                        <label for="nome" class="form-label">Nome do Fornecedor</label>
                        <input type="text" class="form-control" id="nome" name="nome" required minlength="3" maxlength="100">
                        <div class="invalid-feedback">
                            O nome do fornecedor é obrigatório e deve ter entre 3 e 100 caracteres.
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="cnpj" class="form-label">CPF/CNPJ</label>
                        <input type="text" class="form-control" id="cnpj" name="cnpj" required>
                        <div class="invalid-feedback">
                            Digite um CPF ou CNPJ válido.
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>

                    <div class="mb-3">
                        <label for="telefone" class="form-label">Telefone</label>
                        <input type="text" class="form-control" id="telefone" name="telefone" required >
                    </div>

                    <button type="submit" class="btn btn-primary">Salvar</button>
                </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>