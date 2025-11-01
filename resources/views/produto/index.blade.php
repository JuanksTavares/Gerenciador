@extends('layout')
<title>Estoque de Produtos</title>
<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <i class="bi bi-box-seam"></i> {{ __('Gestão de Estoque') }}
            </h2>
            <a href="/produtos/adicionar" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 transition-colors shadow-md">
                <i class="bi bi-plus-circle mr-2"></i> Adicionar Produto
            </a>
        </div>
    </x-slot>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Mensagens de Sucesso e Erro -->
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

            @if($errors->any())
                <div class="mb-4 bg-red-50 border-l-4 border-red-500 p-4 rounded-md shadow-sm">
                    <div class="flex items-start">
                        <i class="bi bi-exclamation-circle-fill text-red-500 text-xl mr-3 mt-1"></i>
                        <div>
                            <p class="text-red-700 font-medium mb-2">Por favor, corrija os seguintes erros:</p>
                            <ul class="list-disc list-inside text-red-600 text-sm">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Card de Filtros e Busca -->
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg border border-gray-200 mb-6">
                <div class="p-6 bg-gradient-to-r from-blue-50 to-blue-100 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">
                        <i class="bi bi-funnel text-blue-600"></i> Filtros e Busca
                    </h3>
                    
                    <div class="flex flex-col md:flex-row gap-4 items-end">
                        <!-- Busca -->
                        <div class="flex-1">
                            <form action="{{ route('produtos.index') }}" method="GET" class="flex gap-2">
                                <input class="flex-1 rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200" 
                                       type="search" 
                                       placeholder="Buscar produto por nome..." 
                                       name="search" 
                                       value="{{ $search ?? '' }}">
                                @if(request('status'))
                                    <input type="hidden" name="status" value="{{ request('status') }}">
                                @endif
                                <button class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors shadow-md" type="submit">
                                    <i class="bi bi-search"></i> Buscar
                                </button>
                            </form>
                        </div>
                        
                        <!-- Filtros de Status -->
                        <div class="flex gap-2">
                            <a href="{{ route('produtos.index', ['status' => 'A']) }}" 
                               class="px-4 py-2 rounded-lg font-medium transition-colors shadow-sm {{ request('status') == 'A' ? 'bg-green-600 text-white' : 'bg-white text-green-600 border border-green-600 hover:bg-green-50' }}">
                                <i class="bi bi-check-circle"></i> Ativos
                            </a>
                            <a href="{{ route('produtos.index', ['status' => 'B']) }}" 
                               class="px-4 py-2 rounded-lg font-medium transition-colors shadow-sm {{ request('status') == 'B' ? 'bg-yellow-500 text-white' : 'bg-white text-yellow-600 border border-yellow-500 hover:bg-yellow-50' }}">
                                <i class="bi bi-exclamation-triangle"></i> Baixo Estoque
                            </a>
                            @if(request('status') || $search)
                                <a href="{{ route('produtos.index') }}" 
                                   class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors shadow-md">
                                    <i class="bi bi-x-circle"></i> Limpar
                                </a>
                            @endif
                        </div>
                    </div>

                    <!-- Info de filtros aplicados -->
                    @if ($search || request('status'))
                        <div class="mt-4 p-3 bg-white rounded-lg border border-blue-200">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2 text-sm">
                                    <i class="bi bi-info-circle text-blue-600"></i>
                                    <span class="text-gray-700">
                                        @if($search)
                                            Busca: <strong>"{{ $search }}"</strong>
                                        @endif
                                        @if(request('status'))
                                            @if($search) | @endif
                                            Status: 
                                            @if(request('status') == 'A')
                                                <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs font-semibold">Ativos</span>
                                            @elseif(request('status') == 'B')
                                                <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs font-semibold">Baixo Estoque</span>
                                            @endif
                                        @endif
                                        | <strong>{{ $produtos->count() }}</strong> {{ Str::plural('produto', $produtos->count()) }} encontrado(s)
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            <!-- Tabela de Produtos -->
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg border border-gray-200">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">
                        <i class="bi bi-list-ul text-gray-600"></i> Lista de Produtos
                    </h3>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produto</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Preço</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estoque</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estoque Mín.</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fornecedor</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($produtos as $produto)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="text-sm font-medium text-gray-900">#{{ $produto->id }}</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ $produto->nome }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-semibold text-green-600">R$ {{ number_format($produto->preco, 2, ',', '.') }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="text-sm font-semibold {{ $produto->quantidade_estoque <= $produto->estoque_minimo ? 'text-red-600' : 'text-gray-900' }}">
                                                {{ $produto->quantidade_estoque }} un.
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="text-sm text-gray-600">{{ $produto->estoque_minimo }} un.</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($produto->status === 'B')
                                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                    <i class="bi bi-exclamation-triangle mr-1"></i> Baixo Estoque
                                                </span>
                                            @elseif($produto->status === 'A')
                                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                    <i class="bi bi-check-circle mr-1"></i> Ativo
                                                </span>
                                            @else
                                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                    <i class="bi bi-x-circle mr-1"></i> Inativo
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="text-sm text-gray-600">{{ $produto->fornecedor->nome ?? 'N/A' }}</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <div class="flex justify-end gap-2">
                                                <button 
                                                    onclick="mostrarDescricao('{{ $produto->nome }}', '{{ addslashes($produto->descricao ?? 'Sem descrição') }}')"
                                                    class="px-3 py-1 bg-purple-600 text-white rounded-md hover:bg-purple-700 transition-colors shadow-sm"
                                                    title="Ver descrição">
                                                    <i class="bi bi-info-circle"></i> Descrição
                                                </button>
                                                <a href="{{ route('produtos.edit', $produto->id) }}" 
                                                   class="px-3 py-1 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors shadow-sm">
                                                    <i class="bi bi-pencil"></i> Editar
                                                </a>
                                                <form action="{{ route('produtos.destroy', $produto->id) }}" method="POST" 
                                                      onsubmit="return confirm('Tem certeza que deseja deletar este produto?')" class="inline">
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
                                        <td colspan="8" class="px-6 py-8 text-center">
                                            <div class="flex flex-col items-center justify-center text-gray-400">
                                                <i class="bi bi-inbox" style="font-size: 3rem;"></i>
                                                <p class="mt-3 text-sm font-medium">Nenhum produto encontrado</p>
                                                <p class="text-xs">Tente ajustar seus filtros ou adicione um novo produto</p>
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

    <!-- Modal de Descrição -->
    <div id="modalDescricao" class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden items-center justify-center z-50 p-4" onclick="fecharModal(event)">
        <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full animate-fadeIn" onclick="event.stopPropagation()">
            <div class="p-6 bg-gradient-to-r from-purple-50 to-purple-100 border-b border-gray-200 rounded-t-2xl">
                <div class="flex items-center justify-between">
                    <h3 class="text-xl font-bold text-gray-800">
                        <i class="bi bi-info-circle text-purple-600 mr-2"></i>
                        <span id="modalTitulo">Descrição do Produto</span>
                    </h3>
                    <button onclick="fecharModal()" class="text-gray-500 hover:text-gray-700 transition-colors">
                        <i class="bi bi-x-lg text-2xl"></i>
                    </button>
                </div>
            </div>
            <div class="p-6">
                <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                    <p id="modalConteudo" class="text-gray-700 whitespace-pre-line"></p>
                </div>
            </div>
            <div class="p-6 bg-gray-50 border-t border-gray-200 rounded-b-2xl flex justify-end">
                <button onclick="fecharModal()" class="px-6 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors shadow-md">
                    <i class="bi bi-check-circle mr-2"></i>Fechar
                </button>
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
        
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: scale(0.95);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }
        
        .bg-white {
            animation: slideIn 0.3s ease-out;
        }
        
        .animate-fadeIn {
            animation: fadeIn 0.3s ease-out;
        }
        
        /* Efeito hover suave */
        button, a {
            transition: all 0.2s ease-in-out;
        }
    </style>

    <!-- Scripts do Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>

    <!-- Script para auto-fechar os alertas após 5 segundos -->
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

        // Função para mostrar descrição no modal
        function mostrarDescricao(nome, descricao) {
            document.getElementById('modalTitulo').textContent = nome;
            document.getElementById('modalConteudo').textContent = descricao || 'Sem descrição disponível';
            document.getElementById('modalDescricao').classList.remove('hidden');
            document.getElementById('modalDescricao').classList.add('flex');
        }

        // Função para fechar modal
        function fecharModal(event) {
            if (!event || event.target.id === 'modalDescricao') {
                document.getElementById('modalDescricao').classList.add('hidden');
                document.getElementById('modalDescricao').classList.remove('flex');
            }
        }

        // Fechar modal com tecla ESC
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                fecharModal();
            }
        });
    </script>
</x-app-layout>