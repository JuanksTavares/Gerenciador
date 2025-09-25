@extends('layout')
<title>Vendas</title>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Histórico de Vendas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-1">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    
                    <!-- Filtros e Busca -->
                    <div class="container-fluid mb-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex gap-2">
                                <a href="{{ route('caixa.historico', ['status' => 'RE']) }}" 
                                   class="btn {{ request('status') == 'RE' ? 'btn-success' : 'btn-outline-success' }}">
                                    Vendas Realizadas
                                </a>
                                <a href="{{ route('caixa.historico', ['status' => 'CA']) }}" 
                                   class="btn {{ request('status') == 'CA' ? 'btn-danger' : 'btn-outline-danger' }}">
                                    Vendas Canceladas
                                </a>
                                @if(request('status'))
                                    <a href="{{ route('caixa.historico') }}" class="btn btn-outline-dark">
                                        Limpar Filtro
                                    </a>
                                @endif
                            </div>
                            
                            <form class="d-flex" action="{{ route('caixa.historico') }}" method="GET">
                                @if(request('status'))
                                    <input type="hidden" name="status" value="{{ request('status') }}">
                                @endif
                                <input type="search" name="search" class="form-control me-2" 
                                       placeholder="Buscar por funcionário ou forma de pagamento" 
                                       value="{{ request('search') }}">
                                <button class="btn btn-outline-dark" type="submit">Buscar</button>
                            </form>
                        </div>
                    </div>

                    <!-- Filtros Ativos -->
                    
                </div>
            </div>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    @if(request('search') || request('status'))
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                                @if(request('search'))
                                    Busca: "{{ request('search') }}"
                                @endif
                                @if(request('status'))
                                    @if(request('search')) | @endif
                                    Status: 
                                    @if(request('status') == 'RE')
                                        <span class="badge bg-success">Realizadas</span>
                                    @elseif(request('status') == 'CA')
                                        <span class="badge bg-danger">Canceladas</span>
                                    @endif
                                @endif
                                ({{ $vendas->count() }} {{ Str::plural('venda', $vendas->count()) }})
                            </h2>
                            <a href="{{ route('caixa.historico') }}" class="btn btn-outline-dark">
                                Limpar filtros
                            </a>
                        </div>
                    @endif
                    <!-- Tabela de Vendas -->
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Data</th>
                                <th>Horário</th>
                                <th>Forma de pagamento</th>
                                <th>Valor Total</th>
                                <th>Status</th>
                                <th>Funcionário</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($vendas as $venda)
                                <tr>
                                    <td>{{ $venda->id }}</td>
                                    <td>{{ $venda->created_at->format('d/m/Y') }}</td>
                                    <td>{{ $venda->created_at->format('H:i:s') }}</td>
                                    <td>{{ $venda->forma_pagamento }}</td>
                                    <td>R$ {{ number_format($venda->valor_total, 2, ',', '.') }}</td>
                                    <td>
                                        @if($venda->status == 'RE')
                                            <span class="badge bg-success">Realizada</span>
                                        @else
                                            <span class="badge bg-danger">Cancelada</span>
                                        @endif
                                    </td>
                                    <td>{{ $venda->usuario->name }}</td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('caixa.venda.detalhes', $venda->id) }}" 
                                               class="btn btn-sm btn-outline-primary">
                                                Detalhes
                                            </a>
                                            @if($venda->status == 'RE')
                                                <form action="{{ route('caixa.cancelar.venda', $venda->id) }}" 
                                                      method="POST" 
                                                      onsubmit="return confirm('Tem certeza que deseja cancelar esta venda?')">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                                        Cancelar
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">Nenhuma venda encontrada.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>