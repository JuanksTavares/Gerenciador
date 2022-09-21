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
}
