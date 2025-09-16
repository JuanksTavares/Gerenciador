@extends('layout')
<title>Estoque</title>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Buscar') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-1">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    
                    <nav class="navbar bg-light">
                        <div class="container-fluid">
                            <a href="/buscar/adicionar" class="btn btn-dark mb-2">adicionar</a>
                            <form class="d-flex" role="search" action = "/buscar" method = "GET">
                                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name = "search">
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
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        Buscando por : {{$search}}
                    </h2>
                    @endif
                    <table class="table" >
                        <tr>
                            <td>ID</td>
                            <td>Nome</td>
                            <td>Codigo de barra</td>
                            <td>Valor de Venda</td>
                            <td>Categoria</td>
                            <td>Custo Medio</td>
                            <td>Estoque Disponivel</td>
                            <td>Estoque Maximo</td>
                            <td>Estoque Minimo</td>
                            <td>Origem Produto</td>
                            <td>NCM</td>
                            <td>CEST</td>
                            <td>Unidade de Medida</td>
                            <td>Editar/Deletar</td>
                        </tr>
                        <tr>
                            @forelse ($produtos as $produto)
                            <tr>
                                <td>{{$produto['id']}}</td>
                                <td>{{ $produto->nome}}</td>
                                <td>{{ $produto->cod_barra}}</td>
                                <td>{{ $produto->valor_venda}}</td>
                                <td>{{ $produto->categoria}}</td>
                                <td>{{ $produto->custo_medio}}</td>
                                <td>{{ $produto->estoque_disponivel}}</td>
                                <td>{{ $produto->estoque_max}}</td>
                                <td>{{ $produto->estoque_min}}</td>
                                <td>{{ $produto->origem_produto}}</td>
                                <td>{{ $produto->ncm}}</td>
                                <td>{{ $produto->cest}}</td>
                                <td>{{ $produto->unidade_medida}}</td>
                                <td>
                                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                        <a href="/buscar/edit/{{$produto->id}}"class="btn btn-outline-success" type="button">Editar</a>
                                        <form action="/buscar/{{$produto->id}}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                        <button class="btn btn-outline-danger" type="submit">Deletar</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-4 py-2 border text-center">Nenhum produto encontrado.</td>
                            </tr>
                            @endforelse
                        </tr>
                    </table>
                    <a href="/buscar" class="btn btn-dark mb-2">Voltar</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>