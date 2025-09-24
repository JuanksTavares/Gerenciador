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
        'data_venda',           
        'valor_total',
        'forma_pagamento',
        'usuario_id',
        'status'
    ];

    protected $casts = [
        'data' => 'datetime',
        'valor_total' => 'decimal:2',
    ];

    protected $dates = [
        'data_venda',
        'created_at',
        'updated_at'
    ];


    public function itens()
    {
        return $this->hasMany(ItemVenda::class);
    }

    public function usuario()
    {
        // Ou se for 'users'
        return $this->belongsTo(User::class, 'usuario_id');
    }
    
    public function getDataVendaFormattedAttribute()
    {
        return $this->data_venda ? \Carbon\Carbon::parse($this->data_venda)->format('d/m/Y H:i') : '-';
    }
}