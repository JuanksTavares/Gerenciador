@extends('layout')
<title>Adicionar Produto</title>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Adicionar') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                  <form method="POST" action="{{ route('produtos.store') }}" class="row g-3 needs-validation" novalidate>
                    
                    @csrf

                        <div class="form-group">
                            <label for="nome">Nome Produto</label>
                            <input type="text" class="form-control" name="nome" id="nome"required>

                            <label for="preco">Preco</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text">R$</span>
                                <input type="number" class="form-control" name="preco" id="preco">
                            </div>

                            <label for="quantidade_estoque">Quantidade Estoque</label>
                            <input type="number" class="form-control" name="quantidade_estoque" id="quantidade_estoque">
                            
                            <label for="estoque_minimo">Estoque Minino</label>
                            <input type="number" class="form-control" name="estoque_minimo" id="estoque_minimo">

                            <label for="fornecedor_id">Fornecedor</label>
                            <select class="form-control" name="fornecedor_id" id="fornecedor_id" required>
                                <option value="">Selecione um fornecedor</option>
                                @foreach($fornecedores as $fornecedor)
                                    <option value="{{ $fornecedor->id }}">{{ $fornecedor->nome }}</option>
                                @endforeach
                            </select>
                            <label for="descricao">Descricao</label>
                            <input type="text" class="form-control" name="descricao" id="descricao"required>
                        </div>
                        <button class="btn btn-outline-success">Salvar</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>