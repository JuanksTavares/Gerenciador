@extends('layout')

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
                  <form method = "post" class="row g-3 needs-validation" novalidate>
    
                      @csrf

                      <div class="form-group">
                          <label for="nome">Nome Produto</label>
                          <input type="text" class="form-control" name="nome" id="nome"required>

                          <label for="Cod_barra">Codigo de Barra</label>
                          <input type="text" class="form-control" name="Cod_barra" id="Cod_barra">

                          <label for="Valor_venda">Valor de Venda</label>
                          <div class="input-group mb-3">
                            <span class="input-group-text">R$</span>
                            <input type="text" class="form-control" name="Valor_venda" id="Valor_venda">
                          </div>

                          <label for="Custo_medio">Custo Medio</label>
                          <div class="input-group mb-3">
                            <span class="input-group-text">R$</span>
                            <input type="text" class="form-control" name="Custo_medio" id="Custo_medio">
                          </div>

                          <label for="Categoria">Categoria para classificação do produto</label>
                          <input type="text" class="form-control" name="Categoria" id="Categoria">

                          <label for="Estoque">Estoque Disponivel</label>
                          <input type="text" class="form-control" name="Estoque" id="Estoque">

                          <label for="Estoque_min">Estoque Minino</label>
                          <input type="text" class="form-control" name="Estoque_min" id="Estoque_min">

                          <label for="Estoque_max">Estoque Maximo</label>
                          <input type="text" class="form-control" name="Estoque_max" id="Estoque_max">

                          <label for="Origem">Origem do Produto</label>
                          <input type="text" class="form-control" name="Origem" id="Origem">
                      </div>
                      <button class="btn btn-outline-success">Salvar</button>
                  </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>