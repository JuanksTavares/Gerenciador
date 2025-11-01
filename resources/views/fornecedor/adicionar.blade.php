@extends('layout')
<title>Cadastrar Fornecedor</title>
<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <i class="bi bi-person-plus"></i> {{ __('Cadastrar Novo Fornecedor') }}
            </h2>
            <a href="{{ route('fornecedores.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 transition-colors shadow-md">
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
                <div class="p-6 bg-gradient-to-r from-indigo-50 to-purple-100 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800">
                        <i class="bi "></i> Informações do Fornecedor
                    </h3>
                    <p class="text-sm text-gray-600 mt-1">Preencha os dados do novo fornecedor</p>
                </div>

                <div class="p-8">
                    <form action="{{ route('fornecedores.store') }}" method="POST" id="formFornecedor" class="space-y-6">
                        @csrf

                        <!-- Nome do Fornecedor -->
                        <div>
                            <label for="nome" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="bi"></i>Nome do Fornecedor <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="text" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all" 
                                id="nome" 
                                name="nome" 
                                required 
                                minlength="3" 
                                maxlength="100"
                                placeholder="Ex: Padaria Central Ltda"
                            >
                            <p class="text-xs text-gray-500 mt-1">Mínimo 3 caracteres, máximo 100</p>
                        </div>

                        <!-- Grid 2 colunas -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- CPF/CNPJ -->
                            <div>
                                <label for="cnpj" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="bi bi-card-text text-indigo-600 mr-2"></i>CPF/CNPJ <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all" 
                                    id="cnpj" 
                                    name="cnpj" 
                                    required
                                    placeholder="000.000.000-00 ou 00.000.000/0000-00"
                                    maxlength="18"
                                >
                                <p class="text-xs text-gray-500 mt-1">Apenas números</p>
                            </div>

                            <!-- Telefone -->
                            <div>
                                <label for="telefone" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="bi bi-telephone text-indigo-600 mr-2"></i>Telefone <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all" 
                                    id="telefone" 
                                    name="telefone" 
                                    required
                                    placeholder="(00) 00000-0000"
                                    maxlength="15"
                                >
                                <p class="text-xs text-gray-500 mt-1">Com DDD</p>
                            </div>
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="bi bi-envelope text-indigo-600 mr-2"></i>E-mail <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="email" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all" 
                                id="email" 
                                name="email" 
                                required
                                placeholder="contato@fornecedor.com.br"
                            >
                            <p class="text-xs text-gray-500 mt-1">E-mail para contato e comunicações</p>
                        </div>

                        <!-- Botões -->
                        <div class="flex items-center justify-end gap-3 pt-6 border-t border-gray-200">
                            <a href="{{ route('fornecedores.index') }}" class="px-6 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors font-medium">
                                <i class="bi bi-x-circle mr-2"></i>Cancelar
                            </a>
                            <button 
                                type="submit" 
                                class="px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-lg hover:from-indigo-700 hover:to-purple-700 transition-all shadow-lg font-medium"
                            >
                                <i class="bi bi-check-circle mr-2"></i>Salvar Fornecedor
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Card de Informações -->
            <div class="mt-6 bg-gradient-to-r from-blue-50 to-cyan-50 border border-blue-200 rounded-lg p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="flex items-start gap-3">
                        <div class="bg-blue-100 rounded-full p-2 mt-1">
                            <i class="bi bi-shield-check text-blue-600 text-xl"></i>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-800 text-sm">Dados Seguros</p>
                            <p class="text-xs text-gray-600">Informações protegidas</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="bg-green-100 rounded-full p-2 mt-1">
                            <i class="bi bi-lightning-charge text-green-600 text-xl"></i>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-800 text-sm">Cadastro Rápido</p>
                            <p class="text-xs text-gray-600">Poucos campos necessários</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="bg-purple-100 rounded-full p-2 mt-1">
                            <i class="bi bi-arrow-repeat text-purple-600 text-xl"></i>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-800 text-sm">Fácil Edição</p>
                            <p class="text-xs text-gray-600">Altere quando precisar</p>
                        </div>
                    </div>
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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('formFornecedor');
            
            // Máscaras usando jQuery Mask
            $('#cnpj').mask('00.000.000/0000-00', {
                onKeyPress: function(val, e, field, options) {
                    const masks = ['000.000.000-000', '00.000.000/0000-00'];
                    const mask = (val.replace(/\D/g, '').length <= 11) ? masks[0] : masks[1];
                    $('#cnpj').mask(mask, options);
                }
            });

            $('#telefone').mask('(00) 00000-0000');

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

                // Validação de e-mail
                const emailField = document.getElementById('email');
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (emailField.value && !emailRegex.test(emailField.value)) {
                    isValid = false;
                    emailField.classList.add('border-red-500');
                    alert('Por favor, insira um e-mail válido');
                }

                if (!isValid) {
                    event.preventDefault();
                    if (isValid !== false || emailField.classList.contains('border-red-500')) {
                        alert('Por favor, preencha todos os campos obrigatórios (*)');
                    }
                }
            });

            // Remove erro ao preencher
            const allInputs = form.querySelectorAll('input');
            allInputs.forEach(input => {
                input.addEventListener('input', function() {
                    this.classList.remove('border-red-500');
                    this.classList.add('border-gray-300');
                });
            });
        });
    </script>
</x-app-layout>