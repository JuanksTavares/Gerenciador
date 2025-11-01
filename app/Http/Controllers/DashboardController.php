<?php

namespace App\Http\Controllers;

use App\Models\Venda;
use App\Models\Produto;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Vendas do dia
        $vendasHoje = Venda::whereDate('data_venda', Carbon::today())
            ->where('status', 'RE')
            ->get();

        $totalVendasHoje = $vendasHoje->sum('valor_total');
        $quantidadeVendasHoje = $vendasHoje->count();

        // Vendas dos últimos 7 dias
        $vendasMes = Venda::where('status', 'RE')
            ->whereDate('data_venda', '>=', Carbon::now()->subDays(30))
            ->sum('valor_total');

        // Produtos com estoque baixo (status B)
        $produtosBaixoEstoque = Produto::where('status', 'B')
            ->count();

        // Total de produtos ativos (status A)
        $produtosAtivos = Produto::where('status', 'A')
            ->count();

        // Produtos mais vendidos
        $produtosMaisVendidos = DB::table('itens_venda')
            ->join('produtos', 'itens_venda.produto_id', '=', 'produtos.id')
            ->join('vendas', 'itens_venda.venda_id', '=', 'vendas.id')
            ->where('vendas.status', 'RE')
            ->select('produtos.nome', DB::raw('SUM(itens_venda.quantidade) as total_vendido'))
            ->groupBy('produtos.id', 'produtos.nome')
            ->orderByDesc('total_vendido')
            ->take(5)
            ->get();

        // Formas de pagamento mais utilizadas
        $formasPagamento = Venda::where('status', 'RE')
            ->select('forma_pagamento', DB::raw('COUNT(*) as total'))
            ->groupBy('forma_pagamento')
            ->get()
            ->map(function ($item) {
                $item->nome = match($item->forma_pagamento) {
                    'DI' => 'Dinheiro',
                    'CR' => 'Crédito',
                    'DE' => 'Débito',
                    'PI' => 'PIX',
                    default => 'Outros'
                };
                return $item;
            });

        // Vendas dos últimos 6 meses para o gráfico
        $vendasPorMes = [];
        $mesesLabels = [];
        
        for ($i = 5; $i >= 0; $i--) {
            $mes = Carbon::now()->subMonths($i);
            $mesInicio = $mes->copy()->startOfMonth();
            $mesFim = $mes->copy()->endOfMonth();
            
            $totalMes = Venda::where('status', 'RE')
                ->whereBetween('data_venda', [$mesInicio, $mesFim])
                ->sum('valor_total');
            
            $vendasPorMes[] = number_format($totalMes, 2, '.', '');
            $mesesLabels[] = ucfirst($mes->locale('pt_BR')->isoFormat('MMM/YY'));
        }

        // Dados para o gráfico de pizza (produtos mais vendidos)
        $produtosLabels = $produtosMaisVendidos->pluck('nome')->toArray();
        $produtosQuantidades = $produtosMaisVendidos->pluck('total_vendido')->toArray();

        return view('dashboard', compact(
            'totalVendasHoje',
            'quantidadeVendasHoje',
            'vendasMes',
            'produtosBaixoEstoque',
            'produtosAtivos',
            'produtosMaisVendidos',
            'formasPagamento',
            'vendasPorMes',
            'mesesLabels',
            'produtosLabels',
            'produtosQuantidades'
        ));
    }
}
