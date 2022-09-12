@extends('layout')

@section('cabecalho')
Adicionar Produtos
@endsection
  
@section('conteudo')
<form method = "post" class="row g-3 needs-validation" novalidate>
    
    @csrf

    <div class="form-group">
        <label for="nome">Nome Produto</label>
        <input type="text" class="form-control" name="nome" id="nome"required>
        <div class="valid-feedback">
          Looks good!
        </div>

        <label for="Cod_barra">Codigo de Barra</label>
        <input type="text" class="form-control" name="Cod_barra" id="Cod_barra">

        <label for="Valor_venda">Valor de Venda</label>
        <div class="input-group mb-3">
          <span class="input-group-text">R$</span>
          <input type="text" class="form-control" name="Valor_venda" id="Valor_venda">
        </div>

        <label for="Custo_medio">Custo Medio</label>
        <div class="input-group mb-3">
          <span class="input-group-text">R$</span>
          <input type="text" class="form-control" name="Custo_medio" id="Custo_medio">
        </div>

        <label for="Categoria">Categoria para classificação do produto</label>
        <input type="text" class="form-control" name="Categoria" id="Categoria">

        <label for="Estoque">Estoque Disponivel</label>
        <input type="text" class="form-control" name="Estoque" id="Estoque">

        <label for="Estoque_min">Estoque Minino</label>
        <input type="text" class="form-control" name="Estoque_min" id="Estoque_min">

        <label for="Estoque_max">Estoque Maximo</label>
        <input type="text" class="form-control" name="Estoque_max" id="Estoque_max">

        <label for="Origem">Origem do Produto</label>
        <input type="text" class="form-control" name="Origem" id="Origem">

        <label for="NCM">NCM(nomenclatura Común do Mercosul)</label>
        <input type="text" class="form-control" name="NCM" id="NCM">

        <label for="CEST">CEST(Cod.Especificador da Substituição Tributária)</label>
        <input type="text" class="form-control" name="CEST" id="CEST">

        <label for="Unidade">Unidade de Medido</label>
        <input type="text" class="form-control" name="Unidade" id="Unidade">
    </div>
    <button class="btn btn-outline-success">Salvar</button>
</form>

@endsection
