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
                    <div>
                            
                    </div>
                    <div>
                        <div>
                        <table class="table" >
                            <tr>
                                <td>Produto</td>
                                <td>Preco</td>
                                <td>Qtd</td>
                                <td>SubTotal</td>
                                <td>Adicionar/Tirar</td>
                            </tr>
                            <tr>
                                <tr>
                                    <td>produto id</td>
                                    <td>produto nome</td>
                                    <td>Quantidade</td>
                                    <td>produtovalor_venda</td>
                                    <td>
                                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                            
                                                @csrf
                                                @method('DELETE')
                                            <button class="btn btn-outline-danger" type="submit">Deletar</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            </tr>
                        </table>
                        </div>
                        <div>

                        </div>
                    </div>
                    <div>
                        vendas feitas
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
