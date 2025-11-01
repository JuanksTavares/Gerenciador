@extends('layout')
@section('title', 'Dashboard')
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Cards de Métricas -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                <!-- Vendas do Mês -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-200">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-blue-100 text-blue-600 mr-4">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-gray-500">Vendas de Hoje</h3>
                            <p class="text-2xl font-bold text-gray-900">R$ {{ $totalVendasHoje }}</p>
                        </div>
                    </div>
                </div>

                <!-- Produtos em Estoque -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-200">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-green-100 text-green-600 mr-4">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-gray-500">Produtos Ativos</h3>
                            <p class="text-2xl font-bold text-gray-900">{{ $produtosAtivos }}</p>
                        </div>
                    </div>
                </div>

                <!-- Produtos com Estoque Baixo -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-200">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-yellow-100 text-yellow-600 mr-4">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-gray-500">Produtos com Baixo Estoque</h3>
                            <p class="text-2xl font-bold text-gray-900">{{ $produtosBaixoEstoque }}</p>
                        </div>
                    </div>
                </div>

                <!-- Lucratividade -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-200">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-purple-100 text-purple-600 mr-4">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-gray-500">Vendas do Ultimo Mês</h3>
                            <p class="text-2xl font-bold text-gray-900">R$ {{ $vendasMes }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Grid Principal -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Coluna 1: Ações Rápidas -->
                <div class="lg:col-span-1 space-y-6">
                    <!-- Ações Rápidas -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Ações Rápidas</h3>
                        <div class="space-y-3">
                            <a href="{{ route('caixa.index') }}" class="w-full flex items-center justify-center px-4 py-2 wborder border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Nova Venda
                            </a>
                            <a href="{{ route('produtos.adicionar') }}" class="w-full flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                Cadastrar Produto
                            </a>
                            <a href="{{ route('fornecedores.adicionar') }}" class="w-full flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Cadastrar Fornecedor
                            </a>
                            <a href="{{ route('produtos.index') }}" class="w-full flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-gray-600 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                Consultar Estoque
                            </a>
                        </div>
                    </div>

                    <!-- Produtos Mais Vendidos -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Produtos Mais Vendidos</h3>
                        <div class="h-64 flex items-center justify-center">
                            <canvas id="produtosMaisVendidosChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Coluna 2: Gráfico e Relatório -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Gráfico de Vendas Mensais -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Vendas Mensais (Últimos 6 meses)</h3>
                        <div class="h-64">
                            <canvas id="vendasMensaisChart"></canvas>
                        </div>
                    </div>

                    <!-- Gerar Relatório -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Gerar Relatório</h3>
                        <form method="POST" action="{{ route('relatorios.gerar') }}" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @csrf
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Tipo de Relatório:</label>
                                <select name="tipo" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                                    <option value="geral">Geral</option>
                                    <option value="financeiro">Financeiro</option>
                                    <option value="estoque">Estoque</option>
                                    <option value="vendas">Vendas</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Período:</label>
                                <select name="periodo" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                                    <option value="1">1 Mês</option>
                                    <option value="3">3 Meses</option>
                                    <option value="6">6 Meses</option>
                                    <option value="12">1 Ano</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Formato:</label>
                                <select name="formato" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                                    <option value="pdf">PDF</option>
                                    <option value="excel">Excel</option>
                                    <option value="csv">CSV</option>
                                </select>
                            </div>
                            <div class="flex items-end">
                                <button type="submit" class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                    <i class="bi bi-download"></i> Download
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .bg-blue-100 { background-color: #dbeafe; }
        .bg-green-100 { background-color: #dcfce7; }
        .bg-yellow-100 { background-color: #fef9c3; }
        .bg-purple-100 { background-color: #f3e8ff; }
        
        .text-blue-600 { color: #2563eb; }
        .text-green-600 { color: #16a34a; }
        .text-yellow-600 { color: #ca8a04; }
        .text-purple-600 { color: #9333ea; }
    </style>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Gráfico de Vendas Mensais (Barras)
            const ctx = document.getElementById('vendasMensaisChart');
            
            if (ctx) {
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: @json($mesesLabels),
                        datasets: [{
                            label: 'Vendas (R$)',
                            data: @json($vendasPorMes),
                            backgroundColor: 'rgba(59, 130, 246, 0.8)',
                            borderColor: 'rgba(59, 130, 246, 1)',
                            borderWidth: 1,
                            borderRadius: 5,
                            hoverBackgroundColor: 'rgba(37, 99, 235, 0.9)',
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: true,
                                position: 'top',
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        let label = context.dataset.label || '';
                                        if (label) {
                                            label += ': ';
                                        }
                                        label += 'R$ ' + parseFloat(context.parsed.y).toLocaleString('pt-BR', {
                                            minimumFractionDigits: 2,
                                            maximumFractionDigits: 2
                                        });
                                        return label;
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    callback: function(value) {
                                        return 'R$ ' + value.toLocaleString('pt-BR', {
                                            minimumFractionDigits: 2,
                                            maximumFractionDigits: 2
                                        });
                                    }
                                },
                                grid: {
                                    color: 'rgba(0, 0, 0, 0.05)',
                                }
                            },
                            x: {
                                grid: {
                                    display: false
                                }
                            }
                        }
                    }
                });
            }

            // Gráfico de Produtos Mais Vendidos (Pizza)
            const ctxPizza = document.getElementById('produtosMaisVendidosChart');
            
            if (ctxPizza) {
                new Chart(ctxPizza, {
                    type: 'pie',
                    data: {
                        labels: @json($produtosLabels),
                        datasets: [{
                            label: 'Quantidade Vendida',
                            data: @json($produtosQuantidades),
                            backgroundColor: [
                                'rgba(59, 130, 246, 0.8)',   // Azul
                                'rgba(16, 185, 129, 0.8)',   // Verde
                                'rgba(245, 158, 11, 0.8)',   // Amarelo/Laranja
                                'rgba(139, 92, 246, 0.8)',   // Roxo
                                'rgba(236, 72, 153, 0.8)',   // Rosa
                            ],
                            borderColor: [
                                'rgba(59, 130, 246, 1)',
                                'rgba(16, 185, 129, 1)',
                                'rgba(245, 158, 11, 1)',
                                'rgba(139, 92, 246, 1)',
                                'rgba(236, 72, 153, 1)',
                            ],
                            borderWidth: 2,
                            hoverOffset: 10
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: true,
                                position: 'bottom',
                                labels: {
                                    padding: 15,
                                    font: {
                                        size: 12
                                    }
                                }
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        let label = context.label || '';
                                        if (label) {
                                            label += ': ';
                                        }
                                        label += context.parsed + ' unidades';
                                        
                                        // Calcular porcentagem
                                        const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                        const percentage = ((context.parsed / total) * 100).toFixed(1);
                                        label += ' (' + percentage + '%)';
                                        
                                        return label;
                                    }
                                }
                            }
                        }
                    }
                });
            }
        });
    </script>
</x-app-layout>