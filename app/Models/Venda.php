<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venda extends Model
{
    protected $table = 'produto_vendido';

    protected $guarded = [];

    protected $fillable = [
        'id_venda',
        'produto',
        'quantidade',
        'data_venda'
    ];
}
