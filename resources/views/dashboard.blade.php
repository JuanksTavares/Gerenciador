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
                            <h3 class="text-sm font-medium text-gray-500">Vendas do Mês</h3>
                            <p class="text-2xl font-bold text-gray-900">R$ 44.444,00</p>
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
                            <h3 class="text-sm font-medium text-gray-500">Lucratividade</h3>
                            <p class="text-2xl font-bold text-gray-900">R$ 0.000,00</p>
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
                            <a href="{{ route('caixa.index') }}" class="w-full flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
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
                        <div class="space-y-3">
                            <div class="flex justify-between items-center">
                                <span class="text-sm font-medium">Bala</span>
                                <span class="text-sm text-gray-500">1.234 unidades</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm font-medium">Gelo</span>
                                <span class="text-sm text-gray-500">987 unidades</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm font-medium">Chocolate</span>
                                <span class="text-sm text-gray-500">765 unidades</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Coluna 2: Gráfico e Relatório -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Gráfico de Vendas Mensais -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Vendas Mensais (Últimos 6 meses)</h3>
                        <div class="h-64 flex items-end justify-between">
                            <!-- Barras do gráfico (simplificado) -->
                            <div class="flex-1 mx-1 flex flex-col items-center">
                                <div class="w-full bg-blue-500 rounded-t" style="height: 60%"></div>
                                <span class="text-xs mt-2">1 Mês</span>
                            </div>
                            <div class="flex-1 mx-1 flex flex-col items-center">
                                <div class="w-full bg-blue-500 rounded-t" style="height: 80%"></div>
                                <span class="text-xs mt-2">2 Mês</span>
                            </div>
                            <div class="flex-1 mx-1 flex flex-col items-center">
                                <div class="w-full bg-blue-500 rounded-t" style="height: 45%"></div>
                                <span class="text-xs mt-2">3 Mês</span>
                            </div>
                            <div class="flex-1 mx-1 flex flex-col items-center">
                                <div class="w-full bg-blue-500 rounded-t" style="height: 70%"></div>
                                <span class="text-xs mt-2">4 Mês</span>
                            </div>
                            <div class="flex-1 mx-1 flex flex-col items-center">
                                <div class="w-full bg-blue-500 rounded-t" style="height: 90%"></div>
                                <span class="text-xs mt-2">5 Mês</span>
                            </div>
                            <div class="flex-1 mx-1 flex flex-col items-center">
                                <div class="w-full bg-blue-500 rounded-t" style="height: 75%"></div>
                                <span class="text-xs mt-2">6 Mês</span>
                            </div>
                        </div>
                    </div>

                    <!-- Gerar Relatório -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Gerar Relatório</h3>
                        <form class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Tipo de Relatório:</label>
                                <select class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                    <option>Geral</option>
                                    <option>Financeiro</option>
                                    <option>Estoque</option>
                                    <option>Vendas</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Período:</label>
                                <select class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                    <option>1 Mês</option>
                                    <option>3 Meses</option>
                                    <option>6 Meses</option>
                                    <option>1 Ano</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Formato:</label>
                                <select class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                    <option>PDF</option>
                                    <option>Excel</option>
                                    <option>CSV</option>
                                </select>
                            </div>
                            <div class="flex items-end">
                                <button type="submit" class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                    Download
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
</x-app-layout>