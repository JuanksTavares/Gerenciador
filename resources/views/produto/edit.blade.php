@extends('layout')

@section('cabecalho')
Editar Produtos
@endsection
  
@section('conteudo')
<form action="/buscar/update/{{$produto->id}}"method = "post" class="row g-3 needs-validation" novalidate>

  @csrf
  @method('PUT')

  <div class="form-group">
      <label for="nome">Nome Produto</label>
      <input type="text" class="form-control" name="nome" id="nome" value="{{$produto->nome}}">

      <label for="Cod_barra">Codigo de Barra</label>
      <input type="text" class="form-control" name="Cod_barra" id="Cod_barra" value="{{$produto->cod_barra}}">

      <label for="Valor_venda">Valor de Venda</label>
      <div class="input-group mb-3">
        <span class="input-group-text">R$</span>
        <input type="text" class="form-control" name="Valor_venda" id="Valor_venda" value="{{$produto->valor_venda}}">
      </div>

      <label for="Custo_medio">Custo Medio</label>
      <div class="input-group mb-3">
        <span class="input-group-text">R$</span>
        <input type="text" class="form-control" name="Custo_medio" id="Custo_medio" value="{{$produto->custo_medio}}">
      </div>

      <label for="Categoria">Categoria para classificação do produto</label>
      <input type="text" class="form-control" name="Categoria" id="Categoria" value="{{$produto->categoria}}">

      <label for="Estoque">Estoque Disponivel</label>
      <input type="text" class="form-control" name="Estoque" id="Estoque" value="{{$produto->estoque_disponivel}}">

      <label for="Estoque_min">Estoque Minino</label>
      <input type="text" class="form-control" name="Estoque_min" id="Estoque_min" value="{{$produto->estoque_min}}">

      <label for="Estoque_max">Estoque Maximo</label>
      <input type="text" class="form-control" name="Estoque_max" id="Estoque_max" value="{{$produto->estoque_max}}">

      <label for="Origem">Origem do Produto</label>
      <input type="text" class="form-control" name="Origem" id="Origem" value="{{$produto->origem_produto}}">

      <label for="NCM">NCM(nomenclatura Común do Mercosul)</label>
      <input type="text" class="form-control" name="NCM" id="NCM" value="{{$produto->ncm}}">

      <label for="CEST">CEST(Cod.Especificador da Substituição Tributária)</label>
      <input type="text" class="form-control" name="CEST" id="CEST" value="{{$produto->cest}}">

      <label for="Unidade">Unidade de Medido</label>
      <input type="text" class="form-control" name="Unidade" id="Unidade" value="{{$produto->unidade_medida}}">
  </div>
  <button class="btn btn-outline-success">Salvar</button>
</form>

@endsection
