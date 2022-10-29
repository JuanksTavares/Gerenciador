<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdutoVenda extends Model
{
    use HasFactory;
    protected $table = 'produto_vendido';


    protected $guarded = [];

    protected $fillable = [
        'produto',
        'quantidade',
        'id_venda',
        'data_venda',
    ];
    public $timestamps = false;

}
