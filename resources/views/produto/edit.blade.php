@extends('layout')
<title>Editar Produtos</title>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar') }}
        </h2>
    </x-slot>
    <form action="{{ route('produtos.update',$produto->id)}}"method = "post" class="row g-3 needs-validation" novalidate>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-1">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @csrf
                    @method('PUT')
                    
                    <div class="form-group">
                        <label for="nome">Nome*</label>
                        <input type="text" class="form-control" name="nome" id="nome" value="{{ old('nome', $produto->nome) }}" required>

                        <label for="preco">Preco</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text">R$</span>
                            <input type="number" class="form-control" name="preco" id="preco" value="{{ old('preco', $produto->preco) }}">
                        </div>

                        <div class="mb-4">
                            <label for="descricao">Descrição</label>
                            <textarea name="descricao" id="descricao" 
                                class="form-control">{{ old('descricao', $produto->descricao) }}</textarea>
                        </div>

                          <label for="quantidade_estoque">Estoque Disponivel</label>
                          <input type="number" class="form-control" name="quantidade_estoque" id="quantidade_estoque" value="{{ old('quantidade_estoque', $produto->quantidade_estoque) }}">
                          
                          <label for="estoque_minimo">Estoque Minino</label>
                          <input type="number" class="form-control" name="estoque_minimo" id="estoque_minimo" value="{{ old('estoque_minimo', $produto->estoque_minimo) }}">

                        <div>
                            <label for="fornecedor_id">Fornecedor*</label>
                            <select name="fornecedor_id" id="fornecedor_id" 
                                    class="form-control" required>
                                <option value="">Selecione um fornecedor</option>
                                @foreach($fornecedores as $fornecedor)
                                    <option value="{{ $fornecedor->id }}" {{ $produto->fornecedor_id == $fornecedor->id ? 'selected' : '' }}>
                                        {{ $fornecedor->nome }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="status">Status</label>
                            <select name="status" id="status" class="form-control" required>
                                <option value="A" {{ $produto->status == 'A' ? 'selected' : '' }}>Ativo</option>
                                <option value="B" {{ $produto->status == 'B' ? 'selected' : '' }}>Baixo Estoque</option>
                                <option value="I" {{ $produto->status == 'I' ? 'selected' : '' }}>Inativo</option>
                            </select>
                        </div>
                      </div>
                      <button class="btn btn-outline-success">Salvar</button>
                  </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
