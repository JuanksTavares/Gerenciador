<?php

namespace App\Http\Controllers;

use App\Models\Caixa;
use App\Models\Venda;
use Illuminate\Http\Request;


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
        

        $search = request('busca');

        if($search){
            $produto = Produto::where([
                ['nome', 'like', '%'.$search.'%'] and ['Cod_barra', 'like', '%'.$search.'%']
            ])->get();

        }else{
            $produto = Produto::all();
            return view('produto.adicionar');
        }
    }

    public function adicionar(){

    }

    public function store(Request $request) {

        $vendas = Caixa::create([
            'valor_total' => $request -> $valor_total,
            'forma_pagamento' => $request-> $forma_pagamento,
            'parcelas' => $request-> $parcelas,
            'valor_parcelas' => $request-> $parcelas_valor,
            'data_venda' => $request -> $data_venda

            

        ]);

        $produto_vendido = Venda::create([

            'produto' => $request -> $produto,
            'quantidade' => $request -> $quantidade, 
            'data_venda' => $request -> $data_venda

        ]);


    }

    public function data(){
        return date('Y-m-d');
    }
}
