@extends('layout')
<title>Detalhes da Venda #{{ $venda->id }}</title>
<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <i class="bi bi-receipt"></i> {{ __('Detalhes da Venda #' . $venda->id) }}
            </h2>
            <a href="{{ route('caixa.historico') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 transition-colors shadow-md">
                <i class="bi bi-arrow-left mr-2"></i> Voltar ao Histórico
            </a>
        </div>
    </x-slot>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Card de Informações da Venda -->
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg border border-gray-200 mb-6">
                <div class="p-6 bg-gradient-to-r from-blue-50 to-blue-100 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">
                        <i class="bi bi-info-circle text-blue-600"></i> Informações da Venda
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- Card Data e Hora -->
                        <div class="bg-white rounded-lg p-4 shadow-sm border border-blue-200">
                            <div class="flex items-center mb-2">
                                <i class="bi bi-calendar-event text-blue-600 text-xl mr-2"></i>
                                <p class="text-sm text-gray-500 font-medium">Data e Hora</p>
                            </div>
                            <p class="text-lg font-bold text-gray-800">{{ \Carbon\Carbon::parse($venda->data_venda)->format('d/m/Y') }}</p>
                            <p class="text-sm text-gray-600">{{ \Carbon\Carbon::parse($venda->data_venda)->format('H:i:s') }}</p>
                        </div>

                        <!-- Card Status -->
                        <div class="bg-white rounded-lg p-4 shadow-sm border border-blue-200">
                            <div class="flex items-center mb-2">
                                <i class="bi bi-flag text-blue-600 text-xl mr-2"></i>
                                <p class="text-sm text-gray-500 font-medium">Status</p>
                            </div>
                            @if($venda->status === 'RE')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-green-100 text-green-800">
                                    <i class="bi bi-check-circle mr-2"></i> Realizada
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-red-100 text-red-800">
                                    <i class="bi bi-x-circle mr-2"></i> Cancelada
                                </span>
                            @endif
                        </div>

                        <!-- Card Funcionário -->
                        <div class="bg-white rounded-lg p-4 shadow-sm border border-blue-200">
                            <div class="flex items-center mb-2">
                                <i class="bi bi-person text-blue-600 text-xl mr-2"></i>
                                <p class="text-sm text-gray-500 font-medium">Funcionário</p>
                            </div>
                            <p class="text-lg font-bold text-gray-800">{{ $venda->usuario->name }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                        <!-- Card Forma de Pagamento -->
                        <div class="bg-white rounded-lg p-4 shadow-sm border border-blue-200">
                            <div class="flex items-center mb-2">
                                <i class="bi bi-credit-card text-blue-600 text-xl mr-2"></i>
                                <p class="text-sm text-gray-500 font-medium">Forma de Pagamento</p>
                            </div>
                            <div>
                                @switch($venda->forma_pagamento)
                                    @case('DI')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-green-100 text-green-800">
                                            <i class="bi bi-cash mr-2"></i> Dinheiro
                                        </span>
                                        @break
                                    @case('CR')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-blue-100 text-blue-800">
                                            <i class="bi bi-credit-card mr-2"></i> Crédito
                                        </span>
                                        @if($venda->parcelas > 1)
                                            <div class="mt-2">
                                                <p class="text-sm text-gray-700">
                                                    <span class="font-semibold">{{ $venda->parcelas }}x</span> de 
                                                    <span class="font-semibold text-green-600">R$ {{ number_format($venda->valor_total / $venda->parcelas, 2, ',', '.') }}</span>
                                                </p>
                                            </div>
                                        @endif
                                        @break
                                    @case('DE')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-purple-100 text-purple-800">
                                            <i class="bi bi-credit-card-2-front mr-2"></i> Débito
                                        </span>
                                        @break
                                    @case('PI')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-indigo-100 text-indigo-800">
                                            <i class="bi bi-qr-code mr-2"></i> PIX
                                        </span>
                                        @break
                                @endswitch
                            </div>
                        </div>

                        <!-- Card Valor Total -->
                        <div class="bg-white rounded-lg p-4 shadow-sm border border-green-200">
                            <div class="flex items-center mb-2">
                                <i class="bi bi-cash-stack text-green-600 text-xl mr-2"></i>
                                <p class="text-sm text-gray-500 font-medium">Valor Total</p>
                            </div>
                            <p class="text-2xl font-bold text-green-600">R$ {{ number_format($venda->valor_total, 2, ',', '.') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabela de Produtos -->
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg border border-gray-200">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">
                        <i class="bi bi-box-seam text-gray-600"></i> Produtos da Venda
                    </h3>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produto</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Quantidade</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Preço Unit.</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($venda->itens as $item)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10">
                                                    <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                                                        <i class="bi bi-box text-blue-600"></i>
                                                    </div>
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">{{ $item->produto->nome }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                                {{ $item->quantidade }} un.
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right">
                                            <div class="text-sm text-gray-900">R$ {{ number_format($item->preco_unitario, 2, ',', '.') }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right">
                                            <div class="text-sm font-semibold text-green-600">R$ {{ number_format($item->subtotal, 2, ',', '.') }}</div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="bg-gradient-to-r from-green-50 to-green-100">
                                <tr>
                                    <td colspan="3" class="px-6 py-4 text-right">
                                        <span class="text-lg font-bold text-gray-800">TOTAL:</span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <span class="text-2xl font-bold text-green-600">R$ {{ number_format($venda->valor_total, 2, ',', '.') }}</span>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Animações suaves */
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .bg-white {
            animation: slideIn 0.3s ease-out;
        }
        
        /* Efeito hover suave */
        button, a {
            transition: all 0.2s ease-in-out;
        }
    </style>

    <!-- Scripts do Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
</x-app-layout>