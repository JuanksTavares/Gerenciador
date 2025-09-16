@extends('layout')
<title>Estoque</title>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Estoque') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-1">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    
                    <nav class="navbar bg-light">
                        <div class="container-fluid">
                            <a href="/produtos/adicionar" class="btn btn-dark mb-2">adicionar</a>
                            <form class="d-flex" role="search" action = "/buscar" method = "GET">
                                <input class="form-control me-2" type="search" placeholder="Buscar por nome" aria-label="Search" name = "search">
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
                        Filtrado por : <a href="/buscar" class="btn btn-outline-dark"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16"><path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z"/></svg>{{$search}}</a>
                    </h2>
                    @endif
                    <table class="table" >
                        <tr>
                            <td>ID</td>
                            <td>Nome</td>
                            <td>Preco</td>
                            <td>Estoque Disponivel</td>
                            <td>Estoque Minimo</td>
                            <td>Origem Produto</td>
                            <td>Editar/Deletar</td>
                        </tr>
                        <tr>
                            @forelse ($produtos as $produto)
                            <tr>
                                <td>{{$produto['id']}}</td>
                                <td>{{ $produto->nome}}</td>
                                <td>{{ $produto->preco}}</td>
                                <td>{{ $produto->quantidade_estoque}}</td>
                                <td>{{ $produto->estoque_minimo}}</td>
                                <td>{{ $produto->fornecedor_id}}</td>
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
                    <!--  <a href="/buscar" class="btn btn-dark mb-2">Voltar</a>  -->
                </div>
            </div>
        </div>
    </div>
</x-app-layout>