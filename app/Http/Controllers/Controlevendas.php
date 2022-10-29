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
            $venda = Caixa::where([
                ['data_venda', 'like', '%'.$search.'%']
            ])->get();

        }else{
            $venda = Caixa::all();
            return view('Vendas.indexvenda', [
                'venda' => $venda,
                'search' => $search
            ]);
        }
    }
    
}


