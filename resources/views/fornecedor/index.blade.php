@extends('layout')
<title>Fornecedores</title>
<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Gestão de Fornecedores') }}
            </h2>
            <a href="/fornecedores/adicionar" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 transition-colors shadow-md">
                <i class="bi bi-plus-circle mr-2"></i> Cadastrar Fornecedor
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

            <!-- Card de Busca -->
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg border border-gray-200 mb-6">
                <div class="p-6 bg-gradient-to-r from-indigo-50 to-indigo-100 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">
                        <i class="bi bi-search text-indigo-600"></i> Buscar Fornecedor
                    </h3>
                    
                    <form action="{{ route('fornecedores.index') }}" method="GET" class="flex gap-2">
                        <input class="flex-1 rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200" 
                               type="search" 
                               placeholder="Buscar por nome, documento ou email..." 
                               name="search" 
                               value="{{ $search ?? '' }}">
                        <button class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors shadow-md" type="submit">
                            <i class="bi bi-search"></i> Buscar
                        </button>
                        @if($search)
                            <a href="{{ route('fornecedores.index') }}" 
                               class="px-6 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors shadow-md">
                                <i class="bi bi-x-circle"></i> Limpar
                            </a>
                        @endif
                    </form>

                    @if ($search)
                        <div class="mt-4 p-3 bg-white rounded-lg border border-indigo-200">
                            <div class="flex items-center gap-2 text-sm">
                                <i class="bi bi-info-circle text-indigo-600"></i>
                                <span class="text-gray-700">
                                    Busca: <strong>"{{ $search }}"</strong> | 
                                    <strong>{{ $fornecedores->count() }}</strong> {{ Str::plural('fornecedor', $fornecedores->count()) }} encontrado(s)
                                </span>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Tabela de Fornecedores -->
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg border border-gray-200">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">
                        <i class="bi bi-list-ul text-gray-600"></i> Lista de Fornecedores
                    </h3>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nome</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Documento</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Telefone</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($fornecedores as $fornecedor)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="text-sm font-medium text-gray-900">#{{ $fornecedor->id }}</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ $fornecedor->nome }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">
                                                <span class="font-medium">{{ $fornecedor->tipo_documento }}:</span> 
                                                {{ $fornecedor->cnpj_formatado }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">
                                                <i class="bi bi-telephone text-gray-400"></i> {{ $fornecedor->telefone_formatado }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-600">
                                                <i class="bi bi-envelope text-gray-400"></i> {{ $fornecedor->email }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <div class="flex justify-end gap-2">
                                                <a href="{{ route('fornecedores.edit', $fornecedor->id) }}" 
                                                   class="px-3 py-1 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors shadow-sm">
                                                    <i class="bi bi-pencil"></i> Editar
                                                </a>
                                                <form action="{{ route('fornecedores.destroy', $fornecedor->id) }}" method="POST" 
                                                      onsubmit="return confirm('Tem certeza que deseja excluir este fornecedor?')" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="px-3 py-1 bg-red-600 text-white rounded-md hover:bg-red-700 transition-colors shadow-sm" type="submit">
                                                        <i class="bi bi-trash"></i> Deletar
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-8 text-center">
                                            <div class="flex flex-col items-center justify-center text-gray-400">
                                                <i class="bi bi-inbox" style="font-size: 3rem;"></i>
                                                <p class="mt-3 text-sm font-medium">Nenhum fornecedor encontrado</p>
                                                <p class="text-xs">Cadastre um novo fornecedor para começar</p>
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