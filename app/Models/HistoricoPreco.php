<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoricoPreco extends Model
{
    use HasFactory;

    protected $table = 'historico_precos';

    protected $fillable = [
        'produto_id',
        'cod_barra',
        'data_alteracao',
        'preco_anterior',
        'preco_novo',
        'preco_compra',
        'quantidade_comprada',
        'observacao'
    ];
}
