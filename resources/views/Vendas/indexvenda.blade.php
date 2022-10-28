@extends('layout')
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Vendas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-1">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    
                    <nav class="navbar bg-light">
                        <div class="container-fluid">
                            <a href="/dashboard" class="btn btn-dark mb-2">adicionar</a>
                            <form class="d-flex" role="search" action = "/vendas" method = "GET">
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
                        Buscando por : <a href="/vendas" class="btn btn-outline-dark"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16"><path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z"/></svg>{{$search}}</a>
                    </h2>
                    @endif
                    <table class="table" >
                        <tr>
                            <td>ID</td>
                            
                            <td>Data</td>
                            <td>Valor</td>
                            <td>Forma de Pagamento</td>
                            <td>Parcelas</td>
                            <td>Produtos</td>
                        </tr>
                        <tr>
                            @foreach ($venda as $vendas)
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>
                                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                        <a href="/vendas/lista{{$produtos_vendidos->id_vendas}}"class="btn btn-outline-success" type="button">Lista de Produtos</a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tr>
                    </table>
                    <a href="/vendas" class="btn btn-dark mb-2">Voltar</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>