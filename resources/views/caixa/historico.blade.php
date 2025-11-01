@extends('layout')
<title>Histórico de Vendas</title>
<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <i class="bi bi-clock-history"></i> {{ __('Histórico de Vendas') }}
            </h2>
            <a href="{{ route('caixa.index') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 transition-colors shadow-md">
                <i class="bi bi-cash-register mr-2"></i> Voltar ao Caixa
            </a>
        </div>
    </x-slot>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Mensagens -->
            @if(session('success'))
                <div class="mb-4 bg-green-50 border-l-4 border-green-500 p-4 rounded-md shadow-sm">
                    <div class="flex items-center">
                        <i class="bi bi-check-circle-fill text-green-500 text-xl mr-3"></i>
                        <p class="text-green-700 font-medium">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 bg-red-50 border-l-4 border-red-500 p-4 rounded-md shadow-sm">
                    <div class="flex items-center">
                        <i class="bi bi-exclamation-circle-fill text-red-500 text-xl mr-3"></i>
                        <p class="text-red-700 font-medium">{{ session('error') }}</p>
                    </div>
                </div>
            @endif

            <!-- Card de Filtros e Busca -->
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg border border-gray-200 mb-6">
                <div class="p-6 bg-gradient-to-r from-purple-50 to-purple-100 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">
                        <i class="bi bi-funnel text-purple-600"></i> Filtros e Busca
                    </h3>
                    
                    <div class="flex flex-col md:flex-row gap-4 items-end">
                        <!-- Busca -->
                        <div class="flex-1">
                            <form action="{{ route('caixa.historico') }}" method="GET" class="flex gap-2">
                                @if(request('status'))
                                    <input type="hidden" name="status" value="{{ request('status') }}">
                                @endif
                                <input class="flex-1 rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200" 
                                       type="search" 
                                       placeholder="Buscar por funcionário ou ID da venda..." 
                                       name="search" 
                                       value="{{ request('search') }}">
                                <button class="px-6 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors shadow-md" type="submit">
                                    <i class="bi bi-search"></i> Buscar
                                </button>
                            </form>
                        </div>
                        
                        <!-- Filtros de Status -->
                        <div class="flex gap-2">
                            <a href="{{ route('caixa.historico', ['status' => 'RE']) }}" 
                               class="px-4 py-2 rounded-lg font-medium transition-colors shadow-sm {{ request('status') == 'RE' ? 'bg-green-600 text-white' : 'bg-white text-green-600 border border-green-600 hover:bg-green-50' }}">
                                <i class="bi bi-check-circle"></i> Realizadas
                            </a>
                            <a href="{{ route('caixa.historico', ['status' => 'CA']) }}" 
                               class="px-4 py-2 rounded-lg font-medium transition-colors shadow-sm {{ request('status') == 'CA' ? 'bg-red-600 text-white' : 'bg-white text-red-600 border border-red-600 hover:bg-red-50' }}">
                                <i class="bi bi-x-circle"></i> Canceladas
                            </a>
                            @if(request('status') || request('search'))
                                <a href="{{ route('caixa.historico') }}" 
                                   class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors shadow-md">
                                    <i class="bi bi-x-circle"></i> Limpar
                                </a>
                            @endif
                        </div>
                    </div>

                    <!-- Info de filtros aplicados -->
                    @if (request('search') || request('status'))
                        <div class="mt-4 p-3 bg-white rounded-lg border border-purple-200">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2 text-sm">
                                    <i class="bi bi-info-circle text-purple-600"></i>
                                    <span class="text-gray-700">
                                        @if(request('search'))
                                            Busca: <strong>"{{ request('search') }}"</strong>
                                        @endif
                                        @if(request('status'))
                                            @if(request('search')) | @endif
                                            Status: 
                                            @if(request('status') == 'RE')
                                                <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs font-semibold">Realizadas</span>
                                            @elseif(request('status') == 'CA')
                                                <span class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-xs font-semibold">Canceladas</span>
                                            @endif
                                        @endif
                                        | <strong>{{ $vendas->count() }}</strong> {{ Str::plural('venda', $vendas->count()) }} encontrada(s)
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Tabela de Vendas -->
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg border border-gray-200">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">
                        <i class="bi bi-list-ul text-gray-600"></i> Histórico de Vendas
                    </h3>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Data/Hora</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Forma Pagamento</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Valor Total</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Funcionário</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($vendas as $venda)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="text-sm font-medium text-gray-900">#{{ $venda->id }}</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">
                                                <div class="font-medium">{{ $venda->created_at->format('d/m/Y') }}</div>
                                                <div class="text-gray-500">{{ $venda->created_at->format('H:i:s') }}</div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">
                                                @switch($venda->forma_pagamento)
                                                    @case('DI')
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                            <i class="bi bi-cash mr-1"></i> Dinheiro
                                                        </span>
                                                        @break
                                                    @case('CR')
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                            <i class="bi bi-credit-card mr-1"></i> Crédito
                                                        </span>
                                                        @if($venda->parcelas > 1)
                                                            <div class="text-xs text-gray-600 mt-1">{{ $venda->parcelas }}x de R$ {{ number_format($venda->valor_total / $venda->parcelas, 2, ',', '.') }}</div>
                                                        @endif
                                                        @break
                                                    @case('DE')
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                                            <i class="bi bi-credit-card-2-front mr-1"></i> Débito
                                                        </span>
                                                        @break
                                                    @case('PI')
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                                            <i class="bi bi-qr-code mr-1"></i> PIX
                                                        </span>
                                                        @break
                                                    @default
                                                        {{ $venda->forma_pagamento }}
                                                @endswitch
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-semibold text-green-600">R$ {{ number_format($venda->valor_total, 2, ',', '.') }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($venda->status == 'RE')
                                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                    <i class="bi bi-check-circle mr-1"></i> Realizada
                                                </span>
                                            @else
                                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                    <i class="bi bi-x-circle mr-1"></i> Cancelada
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-8 w-8">
                                                    <div class="h-8 w-8 rounded-full bg-gray-200 flex items-center justify-center">
                                                        <i class="bi bi-person text-gray-600"></i>
                                                    </div>
                                                </div>
                                                <div class="ml-3">
                                                    <div class="text-sm font-medium text-gray-900">{{ $venda->usuario->name }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <div class="flex justify-end gap-2">
                                                <a href="{{ route('caixa.venda.detalhes', $venda->id) }}" 
                                                   class="px-3 py-1 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors shadow-sm">
                                                    <i class="bi bi-eye"></i> Detalhes
                                                </a>
                                                @if($venda->status == 'RE')
                                                    <form action="{{ route('caixa.cancelar.venda', $venda->id) }}" 
                                                          method="POST" 
                                                          onsubmit="return confirm('Tem certeza que deseja cancelar esta venda?')" class="inline">
                                                        @csrf
                                                        <button class="px-3 py-1 bg-red-600 text-white rounded-md hover:bg-red-700 transition-colors shadow-sm" type="submit">
                                                            <i class="bi bi-x-circle"></i> Cancelar
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-6 py-8 text-center">
                                            <div class="flex flex-col items-center justify-center text-gray-400">
                                                <i class="bi bi-inbox" style="font-size: 3rem;"></i>
                                                <p class="mt-3 text-sm font-medium">Nenhuma venda encontrada</p>
                                                <p class="text-xs">Realize vendas no caixa para visualizá-las aqui</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
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

    <!-- Script para auto-fechar os alertas -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                const alerts = document.querySelectorAll('.bg-green-50, .bg-red-50');
                alerts.forEach(function(alert) {
                    alert.style.transition = 'opacity 0.5s';
                    alert.style.opacity = '0';
                    setTimeout(() => alert.remove(), 500);
                });
            }, 5000);
        });
    </script>
</x-app-layout>