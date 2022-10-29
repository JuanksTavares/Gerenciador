<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venda;
use App\Models\Caixa;

class Controlevendas extends Controller
{
    public function index() {

        $search = request('search');

        if($search){
            $venda = Venda::where([
                ['data_venda', 'like', '%'.$search.'%']
            ])->get();

        }else{
            $venda = Venda::all();
            return view('Vendas.indexvenda', [
                'venda' => $venda,
                'search' => $search
            ]);
        }
    }
    
}


