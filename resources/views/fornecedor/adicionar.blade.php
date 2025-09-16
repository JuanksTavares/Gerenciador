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
                  <form method = "post" class="row g-3 needs-validation" novalidate>
    
                        @csrf

                        <div class="form-group">
                            <label for="nome">Nome Fornecedor</label>
                            <input type="text" class="form-control" name="nome" id="nome"required>

                            <label for="cnjp">CNPJ</label>
                            <input type="number" class="form-control" name="cnjp" id="cnjp">

                            <label for="telefone">Telefone</label>
                            <input type="number" class="form-control" name="telefone" id="telefone">

                            <label for="email">Email</label>
                            <input type="text" class="form-control" name="email" id="email">
                            
                        </div>
                      <button class="btn btn-outline-success">Salvar</button>
                  </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>