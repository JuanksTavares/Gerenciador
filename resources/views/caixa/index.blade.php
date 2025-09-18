<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Caixa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
</head>
<body>
    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Caixa') }}
            </h2>
        </x-slot>

        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- Mensagens -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- Busca -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-4">
                    <div class="p-4 bg-white border-b border-gray-200">
                        <form method="GET" action="{{ route('caixa.index') }}">
                            <div class="row">
                                <div class="col-md-8">
                                    <label class="form-label">Buscar Produto</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="search" placeholder="Digite o nome do produto" value="{{ $searchTerm ?? '' }}">
                                        <button class="btn btn-outline-secondary" type="submit">
                                            <i class="bi bi-search"></i> Buscar
                                        </button>
                                    </div>
                                </div>
                                
                                <div class="col-md-4">
                                    <div class="row">
                                        <div class="col-6">
                                            <label>Total Itens:</label>
                                            <input type="text" class="form-control text-center" readonly value="{{ $carrinho ? array_sum(array_column($carrinho, 'quantidade')) : 0 }}">
                                        </div>
                                        <div class="col-6">
                                            <label>Total R$:</label>
                                            <input type="text" class="form-control text-center text-success" readonly value="{{ number_format($carrinho ? array_sum(array_column($carrinho, 'subtotal')) : 0, 2, ',', '.') }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Produtos Encontrados -->
                @if(isset($produtos) && $produtos->count() > 0)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-4">
                        <div class="p-4 bg-white border-b border-gray-200">
                            <h5>Produtos Encontrados</h5>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Nome</th>
                                            <th>Preço</th>
                                            <th>Estoque</th>
                                            <th>Ação</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($produtos as $produto)
                                            <tr>
                                                <td>{{ $produto->nome }}</td>
                                                <td>R$ {{ number_format($produto->preco, 2, ',', '.') }}</td>
                                                <td>{{ $produto->quantidade_estoque }}</td>
                                                <td>
                                                    <form method="POST" action="{{ route('caixa.carrinho.adicionar') }}">
                                                        @csrf
                                                        <input type="hidden" name="produto_id" value="{{ $produto->id }}">
                                                        <div class="input-group input-group-sm" style="width: 150px;">
                                                            <input type="number" class="form-control" name="quantidade" value="1" min="1" max="{{ $produto->quantidade_estoque }}">
                                                            <button class="btn btn-primary" type="submit">
                                                                <i class="bi bi-cart-plus"></i>
                                                            </button>
                                                        </div>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @elseif(isset($searchTerm) && $searchTerm != '')
                    <div class="alert alert-info mb-4">
                        Nenhum produto encontrado para "{{ $searchTerm }}"
                    </div>
                @endif

                <!-- Carrinho -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-4">
                    <div class="p-4 bg-white border-b border-gray-200">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5>Itens do Carrinho</h5>
                            @if($carrinho && count($carrinho) > 0)
                                <form method="POST" action="{{ route('caixa.carrinho.limpar') }}">
                                    @csrf
                                    <button class="btn btn-sm btn-outline-danger" type="submit" onclick="return confirm('Tem certeza?')">
                                        <i class="bi bi-trash"></i> Limpar
                                    </button>
                                </form>
                            @endif
                        </div>
                        
                        @if($carrinho && count($carrinho) > 0)
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Produto</th>
                                            <th>Preço</th>
                                            <th>Quantidade</th>
                                            <th>Subtotal</th>
                                            <th>Ação</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($carrinho as $id => $item)
                                            <tr>
                                                <td>{{ $item['nome'] }}</td>
                                                <td>R$ {{ number_format($item['preco'], 2, ',', '.') }}</td>
                                                <td>
                                                    <form method="POST" action="{{ route('caixa.carrinho.alterar', $id) }}" class="d-inline">
                                                        @csrf
                                                        <div class="input-group input-group-sm" style="width: 120px;">
                                                            <input type="number" class="form-control" name="quantidade" value="{{ $item['quantidade'] }}" min="1">
                                                            <button class="btn btn-outline-primary" type="submit">
                                                                <i class="bi bi-arrow-clockwise"></i>
                                                            </button>
                                                        </div>
                                                    </form>
                                                </td>
                                                <td>R$ {{ number_format($item['subtotal'], 2, ',', '.') }}</td>
                                                <td>
                                                    <form method="POST" action="{{ route('caixa.carrinho.remover', $id) }}" class="d-inline">
                                                        @csrf
                                                        <button class="btn btn-sm btn-danger" type="submit">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-4 text-muted">
                                <i class="bi bi-cart-x" style="font-size: 2rem;"></i>
                                <p class="mt-2">Nenhum produto no carrinho</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Pagamento -->
                @if($carrinho && count($carrinho) > 0)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-4 bg-white border-b border-gray-200">
                            <h5 class="mb-3">Finalizar Venda</h5>
                            <form method="POST" action="{{ route('caixa.venda.store') }}">
                                @csrf
                                @php
                                    $totalVenda = array_sum(array_column($carrinho, 'subtotal'));
                                @endphp
                                
                                <div class="row">
                                    <div class="col-md-3 mb-3">
                                        <label>Forma de Pagamento:</label>
                                        <select class="form-control" name="forma_pagamento" required>
                                            <option value="DI">Dinheiro</option>
                                            <option value="CR">Cartão de Crédito</option>
                                            <option value="DE">Cartão de Débito</option>
                                            <option value="PI">PIX</option>
                                        </select>
                                    </div>
                                    
                                    <!-- Apenas para exibição (não envia para o banco) -->
                                    <div class="col-md-2 mb-3">
                                        <label>Parcelas:</label>
                                        <select class="form-control" name="parcelas_display" disabled>
                                            @for($i = 1; $i <= 12; $i++)
                                                <option value="{{ $i }}">{{ $i }}x</option>
                                            @endfor
                                        </select>
                                    </div>
                                    
                                    <div class="col-md-2 mb-3">
                                        <label>Total:</label>
                                        <input type="text" class="form-control text-center" readonly value="R$ {{ number_format($totalVenda, 2, ',', '.') }}">
                                        <input type="hidden" name="total_venda" value="{{ $totalVenda }}">
                                    </div>
                                    
                                    <!-- Apenas para exibição (não envia para o banco) -->
                                    <div class="col-md-3 mb-3">
                                        <label>Valor Recebido:</label>
                                        <div class="input-group">
                                            <span class="input-group-text">R$</span>
                                            <input type="text" class="form-control" name="valor_recebido_display" value="{{ number_format($totalVenda, 2, ',', '') }}" disabled>
                                        </div>
                                    </div>
                                    
                                    <!-- Apenas para exibição (não envia para o banco) -->
                                    <div class="col-md-2 mb-3">
                                        <label>Troco:</label>
                                        <input type="text" class="form-control text-center text-info" readonly value="R$ 0,00">
                                    </div>
                                </div>
                                
                                <div class="row mt-4">
                                    <div class="col-12">
                                        <button class="btn btn-success btn-lg me-2" type="submit">
                                            <i class="bi bi-check-lg"></i> Finalizar Venda
                                        </button>
                                        <a href="{{ route('caixa.historico') }}" class="btn btn-info btn-lg">
                                            <i class="bi bi-clock-history"></i> Histórico
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </x-app-layout>
</body>
</html>