<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <i class="bi bi-cash-register"></i> {{ __('Sistema de Caixa') }}
            </h2>
            <a href="{{ route('caixa.historico') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                <i class="bi bi-clock-history mr-2"></i> Histórico
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

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Coluna Esquerda: Busca e Produtos -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Card de Busca -->
                    <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg border border-gray-200">
                        <div class="p-6 bg-gradient-to-r from-blue-50 to-blue-100 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">
                                <i class="bi bi-search text-blue-600"></i> Buscar Produto
                            </h3>
                            <form method="GET" action="{{ route('caixa.index') }}">
                                <div class="flex gap-2">
                                    <input type="text" class="flex-1 rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200" name="search" placeholder="Digite o nome ou código do produto..." value="{{ $searchTerm ?? '' }}" autofocus>
                                    <button class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors shadow-md" type="submit">
                                        <i class="bi bi-search"></i> Buscar
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Produtos Encontrados -->
                    @if(isset($produtos) && $produtos->count() > 0)
                        <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg border border-gray-200">
                            <div class="p-6 bg-white">
                                <h3 class="text-lg font-semibold text-gray-800 mb-4">
                                    <i class="bi bi-box-seam text-green-600"></i> Produtos Encontrados ({{ $produtos->count() }})
                                </h3>
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produto</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Preço</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estoque</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Adicionar</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @foreach($produtos as $produto)
                                                <tr class="hover:bg-gray-50 transition-colors">
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="text-sm font-medium text-gray-900">{{ $produto->nome }}</div>
                                                        @if($produto->cod_loja)
                                                            <div class="text-xs text-gray-500">Cód: {{ $produto->cod_loja }}</div>
                                                        @endif
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="text-sm font-semibold text-green-600">R$ {{ number_format($produto->preco_venda, 2, ',', '.') }}</div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $produto->total_disponivel > 10 ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                                            {{ $produto->total_disponivel }} un.
                                                        </span>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <form method="POST" action="{{ route('caixa.carrinho.adicionar') }}" class="flex gap-2">
                                                            @csrf
                                                            <input type="hidden" name="produto_id" value="{{ $produto->id }}">
                                                            <input type="number" class="w-20 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200" name="quantidade" value="1" min="1" max="{{ $produto->total_disponivel }}">
                                                            <button class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors shadow-sm" type="submit">
                                                                <i class="bi bi-cart-plus"></i>
                                                            </button>
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
                        <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-md shadow-sm">
                            <div class="flex items-center">
                                <i class="bi bi-info-circle-fill text-blue-500 text-xl mr-3"></i>
                                <p class="text-blue-700">Nenhum produto encontrado para "<strong>{{ $searchTerm }}</strong>"</p>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Coluna Direita: Carrinho e Pagamento -->
                <div class="lg:col-span-1 space-y-6">
                    <!-- Resumo do Carrinho -->
                    <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg border border-gray-200">
                        <div class="p-6 bg-gradient-to-r from-green-50 to-green-100 border-b border-gray-200">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-lg font-semibold text-gray-800">
                                    <i class="bi bi-cart3 text-green-600"></i> Carrinho
                                </h3>
                                @if($carrinho && count($carrinho) > 0)
                                    <form method="POST" action="{{ route('caixa.carrinho.limpar') }}">
                                        @csrf
                                        <button class="text-red-600 hover:text-red-800 text-sm font-medium transition-colors" type="submit" onclick="return confirm('Tem certeza que deseja limpar o carrinho?')">
                                            <i class="bi bi-trash"></i> Limpar
                                        </button>
                                    </form>
                                @endif
                            </div>
                            
                            <!-- Totalizadores -->
                            <div class="grid grid-cols-2 gap-4">
                                <div class="bg-white rounded-lg p-3 shadow-sm">
                                    <p class="text-xs text-gray-500 mb-1">Total Itens</p>
                                    <p class="text-2xl font-bold text-gray-800">{{ $carrinho ? array_sum(array_column($carrinho, 'quantidade')) : 0 }}</p>
                                </div>
                                <div class="bg-white rounded-lg p-3 shadow-sm">
                                    <p class="text-xs text-gray-500 mb-1">Total</p>
                                    <p class="text-2xl font-bold text-green-600">R$ {{ number_format($carrinho ? array_sum(array_column($carrinho, 'subtotal')) : 0, 2, ',', '.') }}</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="p-6">
                            @if($carrinho && count($carrinho) > 0)
                                <div class="space-y-3 max-h-96 overflow-y-auto">
                                    @foreach($carrinho as $id => $item)
                                        <div class="bg-gray-50 rounded-lg p-4 border border-gray-200 hover:shadow-md transition-shadow">
                                            <div class="flex justify-between items-start mb-2">
                                                <h4 class="font-medium text-gray-800 text-sm">{{ $item['nome'] }}</h4>
                                                <form method="POST" action="{{ route('caixa.carrinho.remover', $id) }}" class="inline">
                                                    @csrf
                                                    <button class="text-red-500 hover:text-red-700 transition-colors" type="submit">
                                                        <i class="bi bi-x-circle-fill"></i>
                                                    </button>
                                                </form>
                                            </div>
                                            <div class="flex items-center justify-between">
                                                <div class="text-xs text-gray-600">
                                                    <span>R$ {{ number_format($item['preco'], 2, ',', '.') }}</span>
                                                </div>
                                                <form method="POST" action="{{ route('caixa.carrinho.alterar', $id) }}" class="flex items-center gap-2">
                                                    @csrf
                                                    <input type="number" class="w-16 text-center rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200 text-sm" name="quantidade" value="{{ $item['quantidade'] }}" min="1">
                                                    <button class="text-blue-600 hover:text-blue-800 transition-colors" type="submit">
                                                        <i class="bi bi-check-circle-fill"></i>
                                                    </button>
                                                </form>
                                            </div>
                                            <div class="mt-2 pt-2 border-t border-gray-300">
                                                <p class="text-sm font-semibold text-gray-800">Subtotal: <span class="text-green-600">R$ {{ number_format($item['subtotal'], 2, ',', '.') }}</span></p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-8 text-gray-400">
                                    <i class="bi bi-cart-x" style="font-size: 3rem;"></i>
                                    <p class="mt-3 text-sm">Carrinho vazio</p>
                                    <p class="text-xs">Adicione produtos para iniciar</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Pagamento -->
                    @if($carrinho && count($carrinho) > 0)
                        <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg border border-gray-200">
                            <div class="p-6 bg-gradient-to-r from-purple-50 to-purple-100 border-b border-gray-200">
                                <h3 class="text-lg font-semibold text-gray-800">
                                    <i class="bi bi-credit-card text-purple-600"></i> Finalizar Venda
                                </h3>
                            </div>
                            <div class="p-6">
                                <form method="POST" action="{{ route('caixa.venda.store') }}">
                                    @csrf
                                    @php
                                        $totalVenda = array_sum(array_column($carrinho, 'subtotal'));
                                    @endphp
                                    
                                    <div class="space-y-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Forma de Pagamento</label>
                                            <select id="formaPagamento" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200" name="forma_pagamento" required>
                                                <option value="DI">💵 Dinheiro</option>
                                                <option value="CR">💳 Cartão de Crédito</option>
                                                <option value="DE">💳 Cartão de Débito</option>
                                                <option value="PI">📱 PIX</option>
                                            </select>
                                        </div>
                                        
                                        <div id="parcelasContainer" style="display: none;">
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Parcelas</label>
                                            <select id="parcelasSelect" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200" name="parcelas">
                                                @for($i = 1; $i <= 12; $i++)
                                                    <option value="{{ $i }}">{{ $i }}x de R$ {{ number_format($totalVenda / $i, 2, ',', '.') }}</option>
                                                @endfor
                                            </select>
                                        </div>
                                        
                                        <div class="bg-gradient-to-r from-green-50 to-green-100 rounded-lg p-4 border border-green-200">
                                            <div class="flex justify-between items-center">
                                                <span class="text-sm font-medium text-gray-700">TOTAL A PAGAR:</span>
                                                <span class="text-2xl font-bold text-green-600">R$ {{ number_format($totalVenda, 2, ',', '.') }}</span>
                                            </div>
                                            <input type="hidden" name="total_venda" value="{{ $totalVenda }}">
                                        </div>
                                        
                                        <div class="flex gap-4 items-end">
                                            <div class="flex-1" style="max-width: 200px;">
                                                <label class="block text-sm font-medium text-gray-700 mb-2">Valor Recebido</label>
                                                <div class="flex">
                                                    <span class="inline-flex items-center px-3 rounded-l-lg border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">R$</span>
                                                    <input type="text" 
                                                           id="valorRecebido"
                                                           class="w-full rounded-r-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200" 
                                                           placeholder="0,00"
                                                           value="{{ number_format($totalVenda, 2, ',', '') }}">
                                                </div>
                                            </div>
                                            
                                            <div class="flex-1" style="max-width: 180px;">
                                                <label class="block text-sm font-medium text-gray-700 mb-2">Troco</label>
                                                <div class="flex items-center px-3 bg-blue-50 border border-blue-200 rounded-lg" style="height: 42px;">
                                                    <span id="trocoDisplay" class="text-sm font-semibold text-blue-600">R$ 0,00</span>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <button class="w-full py-4 bg-gradient-to-r from-green-500 to-green-600 text-white font-bold rounded-lg hover:from-green-600 hover:to-green-700 transition-all shadow-lg transform hover:scale-105" type="submit">
                                            <i class="bi bi-check-circle-fill mr-2"></i> FINALIZAR VENDA
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endif
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
        
        /* Scrollbar customizada */
        .overflow-y-auto::-webkit-scrollbar {
            width: 6px;
        }
        
        .overflow-y-auto::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        
        .overflow-y-auto::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 10px;
        }
        
        .overflow-y-auto::-webkit-scrollbar-thumb:hover {
            background: #555;
        }
        
        /* Efeito hover suave */
        button, a {
            transition: all 0.2s ease-in-out;
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Função para formatar valor para moeda brasileira
        function formatarMoeda(valor) {
            return valor.toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
        }

        // Função para converter string de moeda para número
        function converterParaNumero(valorString) {
            if (!valorString) return 0;
            // Remove tudo exceto números e vírgula
            let numero = valorString.replace(/[^\d,]/g, '');
            // Substitui vírgula por ponto
            numero = numero.replace(',', '.');
            return parseFloat(numero) || 0;
        }

        // Calcular troco quando o valor recebido mudar
        document.addEventListener('DOMContentLoaded', function() {
            const valorRecebidoInput = document.getElementById('valorRecebido');
            const trocoDisplay = document.getElementById('trocoDisplay');
            const totalVenda = {{ $totalVenda ?? 0 }};
            
            // Controle de exibição de parcelas
            const formaPagamento = document.getElementById('formaPagamento');
            const parcelasContainer = document.getElementById('parcelasContainer');
            const parcelasSelect = document.getElementById('parcelasSelect');
            
            if (formaPagamento && parcelasContainer) {
                formaPagamento.addEventListener('change', function() {
                    if (this.value === 'CR') {
                        parcelasContainer.style.display = 'block';
                        parcelasSelect.required = true;
                    } else {
                        parcelasContainer.style.display = 'none';
                        parcelasSelect.required = false;
                        parcelasSelect.value = '1';
                    }
                });
            }

            if (valorRecebidoInput && trocoDisplay) {
                // Função para calcular e atualizar o troco
                function calcularTroco() {
                    const valorRecebido = converterParaNumero(valorRecebidoInput.value);
                    const troco = valorRecebido - totalVenda;
                    
                    if (troco >= 0) {
                        trocoDisplay.textContent = 'R$ ' + formatarMoeda(troco);
                        trocoDisplay.classList.remove('text-red-600');
                        trocoDisplay.classList.add('text-blue-600');
                    } else {
                        trocoDisplay.textContent = 'R$ ' + formatarMoeda(Math.abs(troco));
                        trocoDisplay.classList.remove('text-blue-600');
                        trocoDisplay.classList.add('text-red-600');
                    }
                }

                // Formatar o input enquanto o usuário digita
                valorRecebidoInput.addEventListener('input', function(e) {
                    let valor = e.target.value;
                    
                    // Remove tudo exceto números e vírgula
                    valor = valor.replace(/[^\d,]/g, '');
                    
                    // Garante apenas uma vírgula
                    const partes = valor.split(',');
                    if (partes.length > 2) {
                        valor = partes[0] + ',' + partes.slice(1).join('');
                    }
                    
                    // Limita casas decimais a 2
                    if (partes.length === 2 && partes[1].length > 2) {
                        valor = partes[0] + ',' + partes[1].substring(0, 2);
                    }
                    
                    e.target.value = valor;
                    calcularTroco();
                });

                // Calcular troco inicial
                calcularTroco();
            }
        });
    </script>
</x-app-layout>