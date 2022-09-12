<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    protected $table = 'produtos';

    protected $guarded = [];

    protected $fillable = [
        'nome',
        'cod_barra',
        'valor_venda',
        'custo_medio',
        'estoque_disponivel',
        'estoque_max',
        'estoque_min',
        'origem_produto',
        'ncm',
        'cest',
        'unidade_medida',
        'categoria'
    ];
}

