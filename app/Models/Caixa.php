<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Caixa extends Model
{
    protected $table = 'vendas';

    protected $guarded = [];

    protected $fillable = [
        'id_venda',
        'valor_total',
        'forma_pagamento',
        'parcelas',
        'parcelas_valor',
        'data_venda'
    ];

    public $timestamps = false;
}
