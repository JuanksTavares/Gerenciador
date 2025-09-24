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
                            {{ $vendas->links() }}
                            <a href="{{ route('caixa.index') }}" class="btn btn-dark mb-2">Voltar para o Caixa</a>
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
                    <table class="table">
                                <tr>
                                    <th>ID</th>
                                    <th>Data</th>
                                    <th>Valor Total</th>
                                    <th>Status</th>
                                    <th>Ações</th>
                                </tr>
                                @forelse($vendas as $venda)
                                <tr>
                                    <td>{{ $venda->id }}</td>
                                    <td>{{ \Carbon\Carbon::parse($venda->data_venda)->format('d/m/Y H:i') }}</td>
                                    <td>R$ {{ number_format($venda->valor_total, 2, ',', '.') }}</td>
                                    <td>{{ $venda->status === 'RE' ? 'Realizada' : 'Cancelada' }}</td>
                                    <td>
                                        <a href="{{ route('caixa.venda.detalhes', $venda->id) }}" 
                                        class="btn btn-info btn-sm">
                                            Detalhes
                                        </a>
                                        @if($venda->status !== 'CA')
                                            <form action="{{ route('caixa.cancelar.venda', $venda->id) }}" 
                                                method="POST" 
                                                style="display: inline;">
                                                @csrf
                                                <button type="submit" 
                                                        class="btn btn-danger btn-sm" 
                                                        onclick="return confirm('Tem certeza que deseja cancelar esta venda?')">
                                                    Cancelar
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-2 border text-center">Nenhum produto encontrado.</td>
                                </tr>
                                @endforelse
                    </table>
                    <!-- <div>
                        {{ $vendas->links() }}
                        <a href="{{ route('caixa.index') }}" class="btn btn-dark mb-2">
                            Voltar para o Caixa
                        </a>
                    </div> -->
                </div>
            </div>
        </div>
    </div>
</x-app-layout>