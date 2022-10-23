<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use app\Models\Caixa;

class Controlecaixa extends Controller
{
    function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        
        $pedidos = Caixa::where([
            'status' =>'RE',
            'user_id' => Auth::id()
        ])->get();

        return view (caixa.index, compact('pedidos'));

    }

    public function busca(){
        

        $search = request('search');

        if($search){
            $produto = Produto::where([
                ['nome', 'like', '%'.$search.'%'] and ['Cod_barra', 'like', '%'.$search.'%']
            ])->get();

        }else{
            $produto = Produto::all();
        }
    }

    public function store(Request $request) {

        $vendas = Venda::create([
            'id_venda' => $request -> $id_venda,
            'lista_produtos' => $request -> $lista_produtos,
            'valor_total' => $request -> $valor_total,
            'forma_pagamento' => $request-> $forma_pagamento,
            

            

        ]);


    }

    public function data(){
        return date('Y-m-d');
    }
}
