@extends('layout')

@section('cabecalho')
    Produtos
@endsection

@section('conteudo')
<a href="/buscar/adicionar" class="btn btn-dark mb-2">adicionar</a>

<table class="table" border='1'>
    <tr>
        <td>ID</td>
        <td>Nome</td>
        <td>Codigo de barra</td>
        <td>Valor de Venda</td>
        <td>Categoria</td>
        <td>Custo Medio</td>
        <td>Estoque Disponivel</td>
        <td>Estoque Maximo</td>
        <td>Estoque Minimo</td>
        <td>Origem Produto</td>
        <td>NCM</td>
        <td>CEST</td>
        <td>Unidade de Medida</td>
        <td>Editar/Deletar</td>
    </tr>
    <tr>
        @foreach ($produto as $produto)
        <tr>
            <td>{{$produto['id']}}</td>
            <td>{{ $produto->nome}}</td>
            <td>{{ $produto->cod_barra}}</td>
            <td>{{ $produto->valor_venda}}</td>
            <td>{{ $produto->categoria}}</td>
            <td>{{ $produto->custo_medio}}</td>
            <td>{{ $produto->estoque_disponivel}}</td>
            <td>{{ $produto->estoque_max}}</td>
            <td>{{ $produto->estoque_min}}</td>
            <td>{{ $produto->origem_produto}}</td>
            <td>{{ $produto->ncm}}</td>
            <td>{{ $produto->cest}}</td>
            <td>{{ $produto->unidade_medida}}</td>
            <td>
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <a href="/buscar/edit/{{$produto->id}}"class="btn btn-outline-success" type="button">Editar</a>
                    <form action="/buscar/{{$produto->id}}" method="POST">
                        @csrf
                        @method('DELETE')
                    <button class="btn btn-outline-danger" type="submit">Deletar</button>
                    </form>
                </div>
            </td>
        </tr>
        @endforeach
    </tr>
</table>
@endsection()
        
