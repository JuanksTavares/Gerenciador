<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemProduto extends Model
{
    use HasFactory;

    protected $fillable = [
        'produto_id',
        'codigo_unico',
        'status',
        'data_entrada',
        'data_saida'
    ];

    protected $casts = [
        'data_entrada' => 'datetime',
        'data_saida' => 'datetime'
    ];

    public function produto()
    {
        return $this->belongsTo(Produto::class);
    }
}
