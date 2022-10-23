@extends('layout')
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Caixa') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="form-group">
                        <label for="nome">Buscar Produto</label>
                        <input type="text" class="form-control" name="nome" placeholder="Buscar produto por: nome ou codigo de barra" id="nome"required>
                        
                    </div>
                    <meta name="csrf-token" content="{{ csrf_token() }}">
                    <div class="md-col-12">
                        <form id="vendaForm" method="post">
                            {{csrf_field()}}
                            <div id="topaste"></div>
                            <div class="row">
                                
                                <div class="col-md-2 col-md-offset-6">
                                    <label>Total de itens:</label>
                                    <input id="item_total" class="form-control"/>
                                </div>
                                <div class="col-md-2 ">
                                    <label>Total:</label>
                                    <input id="total"  data-mask="000.000,00" data-mask-reverse="true" class="form-control"/>
                                </div>
                                <div class="col-md-2 col-md-offset-2">
                                    <label>Desconto:</label>
                                    <input id="desconto" oninput="$(this).trigger('change');" data-mask="000%" data-mask-reverse="true" name="desconto" class="form-control"/>
                                </div>
                                <div class="col-md-2 ">
                                    <label>Pagamento:</label>
                                    <select id="pagamento" name="pagamento" class="form-control">
                                        <option value="DI">Dinheiro</option>
                                        <option value="CR">Crédito</option>
                                        <option value="DE">Débito</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label>Parcelas:</label>
                                <select id="parcelas" name="parcelas" class="form-control"readonly="readonly">
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
                                    <input id="valor_parcelas" name="valor_parcelas"  data-mask="000.000,00" data-mask-reverse="true" class="form-control"/>
                                </div>
                                <div class="col-md-2">
                                    <label>Total a pagar:</label>
                                    <input id="total_pagar" data-mask="000.000,00" data-mask-reverse="true" name="total" class="form-control"/>
                                </div> 
                                
                                <div class="col-md-2 ">
                                    <label>Dinheiro:</label>
                                    <input id="dinheiro" name="dinheiro" data-mask="000.000,00"  oninput="$(this).trigger('change');" data-mask-reverse="true"class="form-control" readonly/>
                                </div>
                                <div class="col-md-2 col-md-offset-2">
                                    <label>Valor recebido:</label>
                                    <input id="val_recebido" data-mask="000.000,00" data-mask-reverse="true" name="valor_dinheiro" class="form-control"/>
                                </div>
                                <div class="col-md-2">
                                    <label>Troco:</label>
                                    <input id="troco" data-mask="000.000,00" data-mask-reverse="true" name="troco" class="form-control" readonly/>
                                </div>
                            </div>
                            <button class="btn btn-success" type="submit">Enviar</button>
                        </form>
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
                        <table class="table" >
                            <tr>
                                <td>Produto</td>
                                <td>Preco</td>
                                <td>Qtd</td>
                                <td>SubTotal</td>
                                <td>Excluir</td>
                            </tr>
                            <tr>
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
                            </tr>
                        </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>  
</x-app-layout>
