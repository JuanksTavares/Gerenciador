@extends('layout')
<title>Cadastrar Fornecedor</title>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Cadastrar Fornecedor') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                  <form action="{{ route('fornecedores.store') }}" method="POST" id="formFornecedor" class="needs-validation" novalidate>
                    @csrf
                    <div class="mb-3">
                        <label for="nome" class="form-label">Nome do Fornecedor</label>
                        <input type="text" class="form-control" id="nome" name="nome" required minlength="3" maxlength="100">
                        <div class="invalid-feedback">
                            O nome do fornecedor é obrigatório e deve ter entre 3 e 100 caracteres.
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="cnpj" class="form-label">CPF/CNPJ</label>
                        <input type="text" class="form-control" id="cnpj" name="cnpj" required>
                        <div class="invalid-feedback">
                            Digite um CPF ou CNPJ válido.
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                        <div class="invalid-feedback">
                            Digite um email válido.
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="telefone" class="form-label">Telefone</label>
                        <input type="text" class="form-control" id="telefone" name="telefone" required pattern="\(\d{2}\) \d{4,5}-\d{4}">
                        <div class="invalid-feedback">
                            Digite um telefone válido ((XX) XXXX-XXXX ou (XX) XXXXX-XXXX).
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Salvar</button>
                </form>

                <script src="https://cdnjs.cloudflare.com/ajax/libs/cleave.js/1.6.0/cleave.min.js"></script>
                <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const form = document.getElementById('formFornecedor');

                    // Máscara para CPF/CNPJ
                    new Cleave('#cnpj', {
                        delimiters: ['.', '.', '/', '-'],
                        blocks: [2, 3, 3, 4, 2],
                        numericOnly: true
                    });

                    // Máscara para telefone
                    new Cleave('#telefone', {
                        delimiters: ['(', ')', ' ', '-'],
                        blocks: [0, 2, 5, 4],
                        numericOnly: true
                    });

                    // Validação do email em tempo real
                    const emailInput = document.getElementById('email');
                    emailInput.addEventListener('input', function() {
                        const isValid = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(this.value);
                        if (isValid) {
                            this.classList.remove('is-invalid');
                            this.classList.add('is-valid');
                        } else {
                            this.classList.remove('is-valid');
                            this.classList.add('is-invalid');
                        }
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

                <style>
                .is-valid {
                    border-color: #198754;
                    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 8'%3e%3cpath fill='%23198754' d='M2.3 6.73L.6 4.53c-.4-1.04.46-1.4 1.1-.8l1.1 1.4 3.4-3.8c.6-.63 1.6-.27 1.2.7l-4 4.6c-.43.5-.8.4-1.1.1z'/%3e%3c/svg%3e");
                    background-repeat: no-repeat;
                    background-position: right calc(0.375em + 0.1875rem) center;
                    background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
                }

                .is-invalid {
                    border-color: #dc3545;
                    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23dc3545'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23dc3545' stroke='none'/%3e%3c/svg%3e");
                    background-repeat: no-repeat;
                    background-position: right calc(0.375em + 0.1875rem) center;
                    background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
                }
                </style>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>