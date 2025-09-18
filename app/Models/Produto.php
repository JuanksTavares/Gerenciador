<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    protected $table = 'produtos';
    protected $except = [
    'produtos/*' // ← Adicione esta linha
    ];

    protected $fillable = [
        'nome',
        'descricao',
        'preco',
        'quantidade_estoque',
        'estoque_minimo',
        'fornecedor_id',
    ];

    // Remova esta linha se sua tabela tem created_at e updated_at
    public $timestamps = false;

    public function fornecedor()
    {
        return $this->belongsTo(Fornecedor::class);
    }
}