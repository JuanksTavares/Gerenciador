<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venda extends Model
{
    use HasFactory;
    
    protected $table = 'vendas';
    
    // Apenas as colunas que existem na tabela
    protected $fillable = [
        'data',           // Nome correto da coluna
        'valor_total',
        'forma_pagamento',
        'usuario_id',
        'status'
    ];

    protected $casts = [
        'data' => 'datetime',
        'valor_total' => 'decimal:2',
    ];


    public function itens()
    {
        return $this->hasMany(ItemVenda::class, 'venda_id');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
}