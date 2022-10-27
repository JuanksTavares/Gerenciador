<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venda;
use App\Models\Caixa;

class Controlevendas extends Controller
{
    public function index() {

        
        
        $venda = Venda::all();
        

        return view('Vendas.indexvenda');
    }
}


