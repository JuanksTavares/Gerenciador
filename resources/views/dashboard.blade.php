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
                          <label for="nome">Nome Produto</label>
                          <input type="text" class="form-control" name="nome" id="nome"required>
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
                            
                    </div>
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
                                    <td>produtovalor_venda</td>
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
