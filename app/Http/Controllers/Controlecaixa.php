<?php

namespace App\Http\Controllers;

use App\Models\Caixa;
use App\Models\Venda;
use App\Models\Produto;
use App\Models\ProdutoVenda;
use Illuminate\Http\Request;


class Controlecaixa extends Controller
{
    // function __construct(){
    //     $this->middleware('auth');
    // }

    public function index(){
        
        // $pedidos = Caixa::where([
        //     'status' =>'RE',
        //     'user_id' => Auth::id()
        // ])->get();
        $pedidos= Caixa::all();
        $produtos = Produto::all();
        
        return view('dashboard', compact('pedidos', 'produtos'));
    }

    public function busca(){
        

        $search = request('busca');

        if($search){
            $produto = Produto::where([
                ['nome', 'like', '%'.$search.'%'] && ['Cod_barra', 'like', '%'.$search.'%']
            ])->get();

        }else{
            $produto = Produto::all();
            return view('produto.adicionar');
        }
    }

    public function adicionar(){

    }

    public function store(Request $request) {
        dd($request);
        $vendas = Caixa::create([

            'valor_total' => $request->total,
            'forma_pagamento' => $request->pagamento,
            'parcelas' => $request->parcelas,
            'parcelas_valor' => $request->parcelas,
            'data_venda'=> date("Y-m-d"),     

        ]);
        
        $produto = ProdutoVenda::create([
            'produto'=> $request->itemproduto,     
            'quantidade'=> $request->quantidade_itens,     
            'id_venda'=> $vendas->id,     
            'data_venda'=> date("Y-m-d"),     
        ]);
        $produtos = Produto::all();
        
        return view('dashboard', compact('produtos'));
        // return

    }

    public function data(){
        return date('Y-m-d');
    }

    public function show($id){

        $produto = Produto::findOrFail($id);

    }

    public function additens(){

        if (!isset($_SESSION['venda']) ||empty($_SESSION['venda'])) {
            return;
        }

        $status = false;
        $meioDePagamento = $this->post->data()->forma_pagamento;
        $dataCompensacao = '0000-00-00';

        /**
         * Gera um código unico de venda que será usado em todos os registros desse Loop
        */
        $codigoVenda = uniqid(rand(), true).date('s').date('d.m.Y');

        $valorRecebido = formataValorMoedaParaGravacao($this->post->data()->valor_recebido);
        $troco = formataValorMoedaParaGravacao($this->post->data()->troco);

        foreach ($_SESSION['venda'] as $produto) {
            $dados = [
                'id_usuario' => $this->idUsuario,
                'id_meio_pagamento' => $meioDePagamento,
                'data_compensacao' => $dataCompensacao,
                'id' => $produto['id'],
                'preco' => $produto['preco'],
                'quantidade' => $produto['quantidade'],
                'valor' => $produto['total'],
                'codigo_venda' => $codigoVenda
            ];

            if ( ! empty($valorRecebido) && ! empty($troco)) {
                $dados['valor_recebido'] = $valorRecebido;
                $dados['troco'] = $troco;
            }

            $venda = new Venda();
            try {
                $venda = $venda->save($dados);
                $status = true;

                unset($_SESSION['venda']);

            } catch (\Exception $e) {
                dd($e->getMessage());
            }
        }

        echo json_encode(['status' => $status]);
    
    }

}
