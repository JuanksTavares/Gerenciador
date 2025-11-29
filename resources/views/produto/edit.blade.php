@extends('layout')
<title>Editar Produto</title>
<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <i class="bi bi-pencil-square"></i> {{ __('Editar Produto') }}
            </h2>
            <a href="{{ route('produtos.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 transition-colors shadow-md">
                <i class="bi bi-arrow-left mr-2"></i> Voltar
            </a>
        </div>
    </x-slot>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Card Principal -->
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg border border-gray-200">
                <div class="p-6 bg-gradient-to-r from-blue-50 to-blue-100 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">
                                <i class="bi bi-box-seam text-blue-600"></i> Editar Produto #{{ $produto->id }}
                            </h3>
                            <p class="text-sm text-gray-600 mt-1">Atualize as informações do produto</p>
                        </div>
                        <div class="text-right">
                            <span class="text-xs text-gray-500">Última atualização:</span>
                            <p class="text-sm font-medium text-gray-700">{{ $produto->updated_at ? $produto->updated_at->format('d/m/Y H:i') : 'N/A' }}</p>
                        </div>
                    </div>
                </div>

                <div class="p-8">
                    <form action="{{ route('produtos.update', $produto->id) }}" method="POST" id="formProduto" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- Nome do Produto -->
                        <div>
                            <label for="nome" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="bi bi-tag text-blue-600 mr-2"></i>Nome do Produto <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="text" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" 
                                id="nome" 
                                name="nome" 
                                value="{{ old('nome', $produto->nome) }}"
                                required 
                                minlength="3" 
                                maxlength="100"
                            >
                        </div>

                        <!-- Grid 2 colunas - Códigos -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Código de Barra -->
                            <div>
                                <label for="cod_barra" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="bi bi-upc-scan text-blue-600 mr-2"></i>Código de Barra
                                </label>
                                <input 
                                    type="text" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" 
                                    id="cod_barra" 
                                    name="cod_barra" 
                                    value="{{ old('cod_barra', $produto->cod_barra) }}"
                                    maxlength="50"
                                    placeholder="Ex: 7891234567890"
                                >
                            </div>
                        </div>

                        <!-- Grid 3 colunas - Preços -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Preço de Compra -->
                            <div>
                                <label for="preco_compra" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="bi bi-cart-check text-blue-600 mr-2"></i>Preço de Compra (R$)
                                </label>
                                <div class="relative">
                                    <span class="absolute left-3 top-3 text-gray-500">R$</span>
                                    <input 
                                        type="number" 
                                        class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" 
                                        id="preco_compra" 
                                        name="preco_compra" 
                                        value="{{ old('preco_compra', $produto->preco_compra) }}"
                                        min="0.01" 
                                        step="0.01"
                                    >
                                </div>
                            </div>

                            <!-- Preço de Venda -->
                            <div>
                                <label for="preco_venda" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="bi bi-cash-coin text-blue-600 mr-2"></i>Preço de Venda (R$) <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <span class="absolute left-3 top-3 text-gray-500">R$</span>
                                    <input 
                                        type="number" 
                                        class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" 
                                        id="preco_venda" 
                                        name="preco_venda" 
                                        value="{{ old('preco_venda', $produto->preco_venda) }}"
                                        required
                                        min="0.01" 
                                        step="0.01"
                                    >
                                </div>
                            </div>
                        </div>

                        <!-- Grid 2 colunas -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Fornecedor -->
                            <div>
                                <label for="fornecedor_id" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="bi bi-people text-blue-600 mr-2"></i>Fornecedor <span class="text-red-500">*</span>
                                </label>
                                <select 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" 
                                    id="fornecedor_id" 
                                    name="fornecedor_id" 
                                    required
                                >
                                    <option value="">Selecione</option>
                                    @foreach($fornecedores as $fornecedor)
                                        <option value="{{ $fornecedor->id }}" {{ $produto->fornecedor_id == $fornecedor->id ? 'selected' : '' }}>
                                            {{ $fornecedor->nome }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Status -->
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="bi bi-toggle-on text-blue-600 mr-2"></i>Status <span class="text-red-500">*</span>
                                </label>
                                <select 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" 
                                    id="status" 
                                    name="status" 
                                    required
                                >
                                    <option value="A" {{ $produto->status == 'A' ? 'selected' : '' }}>Ativo</option>
                                    <option value="B" {{ $produto->status == 'B' ? 'selected' : '' }}>Baixo Estoque</option>
                                    <option value="I" {{ $produto->status == 'I' ? 'selected' : '' }}>Inativo</option>
                                </select>
                            </div>
                        </div>

                        <!-- Grid 2 colunas - Estoques -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Quantidade de Compra -->
                            <div>
                                <label for="quantidade_compra" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="bi bi-box text-blue-600 mr-2"></i>Quantidade de Compra <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    type="number" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" 
                                    id="quantidade_compra" 
                                    name="quantidade_compra" 
                                    value="{{ old('quantidade_compra', $produto->quantidade_compra) }}"
                                    required 
                                    min="0"
                                >
                            </div>

                            <!-- Estoque Mínimo -->
                            <div>
                                <label for="estoque_minimo" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="bi bi-exclamation-triangle text-yellow-600 mr-2"></i>Estoque Mínimo <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    type="number" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" 
                                    id="estoque_minimo" 
                                    name="estoque_minimo" 
                                    value="{{ old('estoque_minimo', $produto->estoque_minimo) }}"
                                    required 
                                    min="0"
                                >
                            </div>
                        </div>

                        <!-- Descrição -->
                        <div>
                            <label for="descricao" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="bi bi-text-paragraph text-blue-600 mr-2"></i>Descrição
                            </label>
                            <textarea 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" 
                                id="descricao" 
                                name="descricao" 
                                rows="4"
                                placeholder="Descrição do produto..."
                            >{{ old('descricao', $produto->descricao) }}</textarea>
                        </div>

                        <!-- Botões -->
                        <div class="flex items-center justify-end gap-3 pt-6 border-t border-gray-200">
                            <a href="{{ route('produtos.index') }}" class="px-6 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors font-medium">
                                <i class="bi bi-x-circle mr-2"></i>Cancelar
                            </a>
                            <button 
                                type="submit" 
                                class="px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-lg hover:from-blue-700 hover:to-blue-800 transition-all shadow-lg font-medium"
                            >
                                <i class="bi bi-save mr-2"></i>Salvar Alterações
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
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
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('formProduto');
            
            // Validação do preço em tempo real
            const precoCompraInput = document.getElementById('preco_compra');
            const precoVendaInput = document.getElementById('preco_venda');
            
            [precoCompraInput, precoVendaInput].forEach(input => {
                if (input) {
                    input.addEventListener('input', function() {
                        if (this.value < 0) {
                            this.value = 0;
                        }
                    });
                }
            });

            // Validação das quantidades em tempo real
            const qtyInputs = document.querySelectorAll('input[type="number"]');
            qtyInputs.forEach(input => {
                input.addEventListener('input', function() {
                    if (this.value < 0) {
                        this.value = 0;
                    }
                });
            });

            // Calcula margem de lucro automaticamente
            if (precoCompraInput && precoVendaInput) {
                const calcularMargem = () => {
                    const compra = parseFloat(precoCompraInput.value) || 0;
                    const venda = parseFloat(precoVendaInput.value) || 0;
                    
                    if (compra > 0 && venda > 0) {
                        const margem = ((venda - compra) / compra * 100).toFixed(2);
                        const cor = margem > 0 ? 'text-green-600' : 'text-red-600';
                        
                        // Adiciona indicador de margem se não existir
                        let margemDiv = document.getElementById('margem-lucro');
                        if (!margemDiv) {
                            margemDiv = document.createElement('div');
                            margemDiv.id = 'margem-lucro';
                            margemDiv.className = 'mt-2 text-sm font-medium col-span-3';
                            precoVendaInput.parentElement.parentElement.parentElement.appendChild(margemDiv);
                        }
                        
                        margemDiv.innerHTML = `<span class="${cor}"><i class="bi bi-graph-up mr-1"></i>Margem de lucro: ${margem}%</span>`;
                    }
                };
                
                precoCompraInput.addEventListener('input', calcularMargem);
                precoVendaInput.addEventListener('input', calcularMargem);
                
                // Calcula na inicialização se houver valores
                calcularMargem();
            }

            // Validação antes do envio
            form.addEventListener('submit', function(event) {
                let isValid = true;
                const requiredFields = form.querySelectorAll('[required]');
                
                requiredFields.forEach(field => {
                    if (!field.value) {
                        isValid = false;
                        field.classList.add('border-red-500');
                        field.classList.remove('border-gray-300');
                    } else {
                        field.classList.remove('border-red-500');
                        field.classList.add('border-gray-300');
                    }
                });

                if (!isValid) {
                    event.preventDefault();
                    alert('Por favor, preencha todos os campos obrigatórios (*)');
                }
            });

            // Remove erro ao preencher
            const allInputs = form.querySelectorAll('input, select, textarea');
            allInputs.forEach(input => {
                input.addEventListener('input', function() {
                    this.classList.remove('border-red-500');
                    this.classList.add('border-gray-300');
                });
            });
        });
    </script>
</x-app-layout>
