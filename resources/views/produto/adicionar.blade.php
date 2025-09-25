@extends('layout')
<title>Adicionar Produto</title>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Adicionar') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                  <form action="{{ route('produtos.store') }}" method="POST" id="formProduto" class="needs-validation" novalidate>
                    @csrf
                    <div class="mb-3">
                        <label for="nome" class="form-label">Nome do Produto</label>
                        <input type="text" class="form-control" id="nome" name="nome" required minlength="3" maxlength="100">
                        <div class="invalid-feedback">
                            O nome do produto é obrigatório e deve ter entre 3 e 100 caracteres.
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="preco" class="form-label">Preço</label>
                        <input type="number" class="form-control" id="preco" name="preco" required min="0" step="0.01">
                        <div class="invalid-feedback">
                            O preço deve ser maior que zero.
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="quantidade_estoque" class="form-label">Quantidade em Estoque</label>
                        <input type="number" class="form-control" id="quantidade_estoque" name="quantidade_estoque" required min="0">
                        <div class="invalid-feedback">
                            A quantidade em estoque deve ser maior ou igual a zero.
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="estoque_minimo" class="form-label">Estoque Mínimo</label>
                        <input type="number" class="form-control" id="estoque_minimo" name="estoque_minimo" required min="0">
                        <div class="invalid-feedback">
                            O estoque mínimo deve ser maior ou igual a zero.
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="fornecedor_id" class="form-label">Fornecedor</label>
                        <select class="form-control" id="fornecedor_id" name="fornecedor_id" required>
                            <option value="">Selecione um fornecedor</option>
                            @foreach($fornecedores as $fornecedor)
                                <option value="{{ $fornecedor->id }}">{{ $fornecedor->nome }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback">
                            Selecione um fornecedor.
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="descricao" class="form-label">Descrição</label>
                        <textarea class="form-control" id="descricao" name="descricao" rows="3"></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">Salvar</button>
                </form>

                <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const form = document.getElementById('formProduto');
                    
                    // Validação do preço em tempo real
                    const precoInput = document.getElementById('preco');
                    precoInput.addEventListener('input', function() {
                        if (this.value < 0) {
                            this.value = 0;
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

                    // Validação antes do envio
                    form.addEventListener('submit', function(event) {
                        if (!form.checkValidity()) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    });
                });
                </script>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>