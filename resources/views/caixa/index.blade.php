@extends('layout')
<title>Caixa</title>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Caixa') }}
        </h2>
    </x-slot>
    <form id="vendaForm" method="post">

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <meta name="csrf-token" content="{{ csrf_token() }}">
                        <div class="md-col-12">
                            {{csrf_field()}}
                            <div class="form-group col-md-4">
                                <label id="search_vendas" for="exampleDataList" class="form-label">Busca</label>
                                <input class="form-control" list="datalistOptions" id="itemproduto" name="itemproduto[]" placeholder="buscar nome" onChange={get_data()}>
                                <datalist id="datalistOptions">
                                    @foreach ($produtos as $produto )
                                    <option value="{{$produto->nome}}|R$ {{$produto->valor_venda}}" label="{{$produto->nome}}">{{$produto->nome}} dsadasdas</option>
                                    @endforeach
                                </datalist>
                            </div>
                            <div id="topaste"></div>
                            <div class="row">

                                <div class="col-md-2 col-md-offset-6">
                                    <label>Total de itens:</label>
                                    <input id="item_total" name="quantidade_itens" class="form-control" />
                                </div>
                                <div class="col-md-2 ">
                                    <label>Total:</label>
                                    <input id="valor_total" name="total_itens" data-mask="000.000,00" data-mask-reverse="true" class="form-control" />
                                </div>
                                <div class="col-md-2 ">
                                    <label>Pagamento:</label>
                                    <select id="forma_pagamento" name="pagamento" class="form-control">
                                        <option value="DI">Dinheiro</option>
                                        <option value="CR">Crédito</option>
                                        <option value="DE">Débito</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label>Parcelas:</label>
                                    <select id="parcelas" name="parcelas" class="form-control" readonly="readonly">
                                        <option value="1">1x</option>
                                        <option value="2">2x</option>
                                        <option value="3">3x</option>
                                        <option value="4">4x</option>
                                        <option value="5">5x</option>
                                        <option value="6">6x</option>
                                        <option value="7">7x</option>
                                        <option value="8">8x</option>
                                        <option value="9">9x</option>
                                        <option value="10">10x</option>
                                        <option value="11">11x</option>
                                        <option value="12">12x</option>

                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label>Valor da parcela:</label>
                                    <input id="valor_parcelas" name="valor_parcelas" data-mask="000.000,00" data-mask-reverse="true" class="form-control" />
                                </div>
                                <div class="col-md-2">
                                    <label>Total a pagar:</label>
                                    <input id="total_pagar" data-mask="000.000,00" data-mask-reverse="true" name="total" class="form-control" />
                                </div>

                                <div class="col-md-2 col-md-offset-2">
                                    <label>Valor recebido:</label>
                                    <input id="val_recebido" data-mask="000.000,00" data-mask-reverse="true" name="valor_dinheiro" class="form-control" />
                                </div>
                                <div class="col-md-2">
                                    <label>Troco:</label>
                                    <input id="troco" data-mask="000.000,00" data-mask-reverse="true" name="troco" class="form-control" readonly />
                                </div>
                            </div>
                            <button class="btn btn-success" type="submit">Enviar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">

                        <div>
                            <div>
                                <table class="table" id="table_produto">
                                    <tr>
                                        <td>Produto</td>
                                        <td>Preco</td>
                                        <td>Qtd</td>
                                        <td>SubTotal</td>
                                        <td>Excluir</td>
                                    </tr>
                                    <tr>
                                        <!-- @foreach ($produtos as $produto)
                                <tr>
                                    <td>produto id</td>
                                    <td>produto nome</td>
                                    <td>
                                        <input type="int" class="form-control" name="quantidade" id="quantidade"required>
                                    </td>
                                    <td>produto valor_venda</td>
                                    <td>
                                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                                @csrf
                                                @method('DELETE')
                                            <button class="btn btn-outline-danger" type="submit"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16"><path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z"/></svg></button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach -->
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <div>
                        <div>
                            <table class="table">
                                <tr>
                                    <td>id</td>
                                    <td>data</td>
                                    <td>Valor Total</td>
                                    <td>Forma de Pagamento</td>
                                    <td>Itens</td>
                                </tr>
                                <tr>
                                    @foreach ($pedidos as $pedido)
                                <tr>
                                    <td>{{$pedido->id_venda}}</td>
                                    <td>{{$pedido->data_venda}}</td>
                                    <td>{{$pedido->valor_total}}</td>
                                    <td>{{$pedido->forma_pagamento}}</td>
                                    <!-- <td>link para os itens</td> -->
                                </tr>
                                @endforeach
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        var input_valor_total = document.getElementsByName('valor_produto_total[]');

        function get_data() {
            var val = document.getElementById("itemproduto").value;

            if (val == "" || val == undefined) {
                return;
            }

            var valor = val.split("|");
            var produto = valor[0]
            var valor_produto = valor[1].replace('R$ ', '');

            var table = document.getElementById("table_produto");
            var row = table.insertRow(-1);
            var index_row = row.rowIndex - 2
            var cell1 = row.insertCell(0);
            var cell2 = row.insertCell(1);
            var cell3 = row.insertCell(2);
            var cell4 = row.insertCell(3);
            var cell5 = row.insertCell(4);

            cell1.innerHTML = `<input name="produto[]" value="${produto}" readonly>`;
            cell2.innerHTML = `<input name="valor_produto[]" value="${valor_produto}" readonly>`;
            cell3.innerHTML = `<input type="number" class="form-control" name="quantidade[]" onchange="updateInput(this.value,${index_row})" value="1" required>`
            cell4.innerHTML = `<input name="valor_produto_total[]" value="${valor_produto}">`;
            cell5.innerHTML = '<button class="btn btn-outline-danger">Deletar</button>';

            this.atualizarValorTotal();
        }

        function updateInput(numero, index_valor) {
            console.info;(index_valor)
            var input_valor = document.getElementsByName('valor_produto[]');
            var input_valor_total = document.getElementsByName('valor_produto_total[]');
            var valor_produto = parseInt(input_valor[index_valor].innerText)
            var valor_final_produto = valor_produto * numero
            input_valor_total[index_valor].innerText = valor_final_produto
            this.atualizarValorTotal();
        }

        function atualizarValorTotal() {
            var input_valor_total = document.getElementsByName('valor_produto_total[]');
            const valorTotalArray = [...input_valor_total];
            var somaProdutos = valorTotalArray.map(valor => parseInt(valor.value)).reduce(function(soma, i) {
                return soma + i;
            });

            var quantidade_total = document.getElementsByName('quantidade[]');
            const quantidadeArray = [...quantidade_total];
            var somaQuantidades = quantidadeArray.map(valor => parseInt(valor.value)).reduce(function(soma, i) {
                return soma + i;
            });

            var quantidade = document.getElementById('item_total');
            var total = document.getElementById('valor_total');
            var total_pagar = document.getElementById('total_pagar');
            quantidade.value = somaQuantidades
            total.value = somaProdutos
            total_pagar.value = somaProdutos
        }
    </script>
</x-app-layout>