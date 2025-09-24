@extends('layout')
<title>Detalhes da Venda #{{ $venda->id }}</title>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detalhes da Venda #' . $venda->id) }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="mb-6">
                    <h3 class="text-lg font-semibold mb-4">Informações da Venda</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p><strong>Data:</strong> {{ \Carbon\Carbon::parse($venda->data_venda)->format('d/m/Y H:i') }}</p>
                            <p><strong>Status:</strong> {{ $venda->status === 'RE' ? 'Realizada' : 'Cancelada' }}</p>
                            <p><strong>Funcionário:</strong> {{ $venda->usuario->name }}</p>
                        </div>
                        <div>
                            <p><strong>Forma de Pagamento:</strong> 
                                @switch($venda->forma_pagamento)
                                    @case('DI')
                                        Dinheiro
                                        @break
                                    @case('CR')
                                        Crédito
                                        @break
                                    @case('DE')
                                        Débito
                                        @break
                                    @case('PI')
                                        PIX
                                        @break
                                @endswitch
                            </p>
                            <p><strong>Valor Total:</strong> R$ {{ number_format($venda->valor_total, 2, ',', '.') }}</p>
                            @if($venda->parcelas > 1)
                                <p><strong>Parcelas:</strong> {{ $venda->parcelas }}x</p>
                            @endif
                        </div>
                    </div>
                </div>

                <div>
                    <h3 class="text-lg font-semibold mb-4">Produtos</h3>
                    <table class="min-w-full">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="px-4 py-2">Produto</th>
                                <th class="px-4 py-2">Quantidade</th>
                                <th class="px-4 py-2">Preço Unitário</th>
                                <th class="px-4 py-2">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($venda->itens as $item)
                            <tr>
                                <td class="border px-4 py-2">{{ $item->produto->nome }}</td>
                                <td class="border px-4 py-2 text-center">{{ $item->quantidade }}</td>
                                <td class="border px-4 py-2 text-right">R$ {{ number_format($item->preco_unitario, 2, ',', '.') }}</td>
                                <td class="border px-4 py-2 text-right">R$ {{ number_format($item->subtotal, 2, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="bg-gray-100">
                                <td colspan="3" class="border px-4 py-2 text-right"><strong>Total:</strong></td>
                                <td class="border px-4 py-2 text-right"><strong>R$ {{ number_format($venda->valor_total, 2, ',', '.') }}</strong></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="mt-6">
                    <a href="{{ route('caixa.historico') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                        Voltar
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>