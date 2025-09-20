@extends('layout')
<title>Vendas</title>
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
                    <table class="table" >
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Data</th>
                                    <th>Valor Total</th>
                                    <th>Forma Pagamento</th>
                                    <th>Itens</th>
                                    <th>Funcionário</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($vendas as $venda)
                                <tr>
                                    <td>{{ $venda->id }}</td>
                                    <td>{{ $venda->data_venda ? $venda->data_venda->format('d/m/Y H:i') : '-' }}</td>

                                    <td>R$ {{ number_format($venda->valor_total, 2, ',', '.') }}</td>
                                    <td>
                                        @switch($venda->forma_pagamento)
                                            @case('DI') Dinheiro @break
                                            @case('CR') Crédito @break
                                            @case('DE') Débito @break
                                            @case('PI') PIX @break
                                            @default {{ $venda->forma_pagamento }}
                                        @endswitch
                                        @if($venda->parcelas > 1)
                                            ({{ $venda->parcelas }}x)
                                        @endif
                                    </td>
                                    <td>{{ $venda->itens->sum('quantidade') }}</td>
                                    <td>{{ $venda->usuario->name }}</td>
                                    <td>
                                        <a href="{{ route('caixa.venda.show', $venda->id) }}" 
                                           class="btn btn-sm btn-info">Detalhes</a>
                                        @if($venda->status == 'RE')
                                        <form action="{{ route('caixa.venda.cancelar', $venda->id) }}" 
                                              method="POST" style="display: inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-danger" 
                                                    onclick="return confirm('Cancelar esta venda?')">
                                                Cancelar
                                            </button>
                                        </form>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center">Nenhuma venda encontrada</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                        {{ $vendas->links() }}
                    
                    <a href="{{ route('caixa.index') }}" class="btn btn-dark mb-2">
                        Voltar para o Caixa
                    </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>