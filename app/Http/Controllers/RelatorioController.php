<?php

namespace App\Http\Controllers;

use App\Models\Venda;
use App\Models\Produto;
use App\Models\ItemVenda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class RelatorioController extends Controller
{
    public function gerar(Request $request)
    {
        $request->validate([
            'tipo' => 'required|in:geral,financeiro,estoque,vendas',
            'periodo' => 'required|in:1,3,6,12',
            'formato' => 'required|in:pdf,excel,csv'
        ]);

        $tipo = $request->tipo;
        $periodo = (int)$request->periodo;
        $formato = $request->formato;

        // Calcular data inicial baseada no período
        $dataInicio = Carbon::now()->subMonths($periodo)->startOfDay();
        $dataFim = Carbon::now()->endOfDay();

        // Gerar dados conforme o tipo de relatório
        $dados = $this->gerarDadosRelatorio($tipo, $dataInicio, $dataFim);

        // Gerar relatório no formato solicitado
        return $this->gerarArquivo($dados, $tipo, $periodo, $formato);
    }

    private function gerarDadosRelatorio($tipo, $dataInicio, $dataFim)
    {
        switch ($tipo) {
            case 'geral':
                return $this->relatorioGeral($dataInicio, $dataFim);
            case 'financeiro':
                return $this->relatorioFinanceiro($dataInicio, $dataFim);
            case 'estoque':
                return $this->relatorioEstoque();
            case 'vendas':
                return $this->relatorioVendas($dataInicio, $dataFim);
            default:
                return [];
        }
    }

    private function relatorioGeral($dataInicio, $dataFim)
    {
        $totalVendas = Venda::where('status', 'RE')
            ->whereBetween('data_venda', [$dataInicio, $dataFim])
            ->sum('valor_total');

        $quantidadeVendas = Venda::where('status', 'RE')
            ->whereBetween('data_venda', [$dataInicio, $dataFim])
            ->count();

        $produtosAtivos = Produto::where('status', 'A')->count();
        $produtosBaixoEstoque = Produto::where('status', 'B')->count();

        $vendasPorDia = Venda::where('status', 'RE')
            ->whereBetween('data_venda', [$dataInicio, $dataFim])
            ->selectRaw('DATE(data_venda) as data, SUM(valor_total) as total, COUNT(*) as quantidade')
            ->groupBy('data')
            ->orderBy('data', 'desc')
            ->get();

        $produtosMaisVendidos = DB::table('itens_venda')
            ->join('produtos', 'itens_venda.produto_id', '=', 'produtos.id')
            ->join('vendas', 'itens_venda.venda_id', '=', 'vendas.id')
            ->where('vendas.status', 'RE')
            ->whereBetween('vendas.data_venda', [$dataInicio, $dataFim])
            ->select('produtos.nome', DB::raw('SUM(itens_venda.quantidade) as total_vendido'), DB::raw('SUM(itens_venda.subtotal) as valor_total'))
            ->groupBy('produtos.id', 'produtos.nome')
            ->orderByDesc('total_vendido')
            ->take(10)
            ->get();

        return [
            'tipo' => 'Relatório Geral',
            'periodo' => Carbon::parse($dataInicio)->format('d/m/Y') . ' até ' . Carbon::parse($dataFim)->format('d/m/Y'),
            'resumo' => [
                'total_vendas' => $totalVendas,
                'quantidade_vendas' => $quantidadeVendas,
                'ticket_medio' => $quantidadeVendas > 0 ? $totalVendas / $quantidadeVendas : 0,
                'produtos_ativos' => $produtosAtivos,
                'produtos_baixo_estoque' => $produtosBaixoEstoque,
            ],
            'vendas_por_dia' => $vendasPorDia,
            'produtos_mais_vendidos' => $produtosMaisVendidos,
        ];
    }

    private function relatorioFinanceiro($dataInicio, $dataFim)
    {
        $vendas = Venda::where('status', 'RE')
            ->whereBetween('data_venda', [$dataInicio, $dataFim])
            ->orderBy('data_venda', 'desc')
            ->get();

        $totalVendas = $vendas->sum('valor_total');

        $vendasPorFormaPagamento = Venda::where('status', 'RE')
            ->whereBetween('data_venda', [$dataInicio, $dataFim])
            ->selectRaw('forma_pagamento, COUNT(*) as quantidade, SUM(valor_total) as total')
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

        $vendasPorMes = Venda::where('status', 'RE')
            ->whereBetween('data_venda', [$dataInicio, $dataFim])
            ->selectRaw('YEAR(data_venda) as ano, MONTH(data_venda) as mes, SUM(valor_total) as total, COUNT(*) as quantidade')
            ->groupBy('ano', 'mes')
            ->orderBy('ano', 'desc')
            ->orderBy('mes', 'desc')
            ->get();

        return [
            'tipo' => 'Relatório Financeiro',
            'periodo' => Carbon::parse($dataInicio)->format('d/m/Y') . ' até ' . Carbon::parse($dataFim)->format('d/m/Y'),
            'total_vendas' => $totalVendas,
            'vendas' => $vendas,
            'vendas_por_forma_pagamento' => $vendasPorFormaPagamento,
            'vendas_por_mes' => $vendasPorMes,
        ];
    }

    private function relatorioEstoque()
    {
        $produtos = Produto::orderBy('nome')->get();
        
        $totalProdutos = $produtos->count();
        $produtosAtivos = $produtos->where('status', 'A')->count();
        $produtosBaixoEstoque = $produtos->where('status', 'B')->count();
        $produtosInativos = $produtos->where('status', 'I')->count();

        $valorTotalEstoque = $produtos->where('status', 'A')->sum(function($produto) {
            return $produto->preco * $produto->quantidade_estoque;
        });

        return [
            'tipo' => 'Relatório de Estoque',
            'periodo' => 'Atual - ' . Carbon::now()->format('d/m/Y H:i'),
            'resumo' => [
                'total_produtos' => $totalProdutos,
                'produtos_ativos' => $produtosAtivos,
                'produtos_baixo_estoque' => $produtosBaixoEstoque,
                'produtos_inativos' => $produtosInativos,
                'valor_total_estoque' => $valorTotalEstoque,
            ],
            'produtos' => $produtos,
        ];
    }

    private function relatorioVendas($dataInicio, $dataFim)
    {
        $vendas = Venda::with(['itens.produto'])
            ->where('status', 'RE')
            ->whereBetween('data_venda', [$dataInicio, $dataFim])
            ->orderBy('data_venda', 'desc')
            ->get();

        $totalVendas = $vendas->sum('valor_total');
        $quantidadeVendas = $vendas->count();
        $ticketMedio = $quantidadeVendas > 0 ? $totalVendas / $quantidadeVendas : 0;

        $produtosMaisVendidos = DB::table('itens_venda')
            ->join('produtos', 'itens_venda.produto_id', '=', 'produtos.id')
            ->join('vendas', 'itens_venda.venda_id', '=', 'vendas.id')
            ->where('vendas.status', 'RE')
            ->whereBetween('vendas.data_venda', [$dataInicio, $dataFim])
            ->select('produtos.nome', DB::raw('SUM(itens_venda.quantidade) as total_vendido'), DB::raw('SUM(itens_venda.subtotal) as valor_total'))
            ->groupBy('produtos.id', 'produtos.nome')
            ->orderByDesc('total_vendido')
            ->take(10)
            ->get();

        return [
            'tipo' => 'Relatório de Vendas',
            'periodo' => Carbon::parse($dataInicio)->format('d/m/Y') . ' até ' . Carbon::parse($dataFim)->format('d/m/Y'),
            'resumo' => [
                'total_vendas' => $totalVendas,
                'quantidade_vendas' => $quantidadeVendas,
                'ticket_medio' => $ticketMedio,
            ],
            'vendas' => $vendas,
            'produtos_mais_vendidos' => $produtosMaisVendidos,
        ];
    }

    private function gerarArquivo($dados, $tipo, $periodo, $formato)
    {
        $nomeArquivo = 'relatorio_' . $tipo . '_' . $periodo . 'meses_' . date('Y-m-d_His');

        switch ($formato) {
            case 'pdf':
                return $this->gerarPDF($dados, $nomeArquivo);
            case 'excel':
                return $this->gerarExcel($dados, $nomeArquivo);
            case 'csv':
                return $this->gerarCSV($dados, $nomeArquivo);
            default:
                return redirect()->back()->with('error', 'Formato não suportado');
        }
    }

    private function gerarPDF($dados, $nomeArquivo)
    {
        $pdf = Pdf::loadView('relatorios.pdf', $dados);
        return $pdf->download($nomeArquivo . '.pdf');
    }

    private function gerarExcel($dados, $nomeArquivo)
    {
        // Implementação básica para Excel usando CSV com separador de tab
        return $this->gerarCSV($dados, $nomeArquivo, "\t", '.xls');
    }

    private function gerarCSV($dados, $nomeArquivo, $delimiter = ',', $extensao = '.csv')
    {
        $headers = [
            'Content-Type' => 'text/csv; charset=utf-8',
            'Content-Disposition' => 'attachment; filename="' . $nomeArquivo . $extensao . '"',
        ];

        $callback = function() use ($dados, $delimiter) {
            $file = fopen('php://output', 'w');
            
            // BOM para UTF-8
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            // Cabeçalho do relatório
            fputcsv($file, [$dados['tipo']], $delimiter);
            fputcsv($file, ['Período: ' . $dados['periodo']], $delimiter);
            fputcsv($file, [''], $delimiter);

            // Conteúdo específico por tipo
            if (isset($dados['vendas'])) {
                fputcsv($file, ['ID', 'Data', 'Forma Pagamento', 'Valor Total', 'Status'], $delimiter);
                foreach ($dados['vendas'] as $venda) {
                    $formaPagamento = match($venda->forma_pagamento) {
                        'DI' => 'Dinheiro',
                        'CR' => 'Crédito',
                        'DE' => 'Débito',
                        'PI' => 'PIX',
                        default => 'Outros'
                    };
                    fputcsv($file, [
                        $venda->id,
                        Carbon::parse($venda->data_venda)->format('d/m/Y H:i'),
                        $formaPagamento,
                        'R$ ' . number_format($venda->valor_total, 2, ',', '.'),
                        $venda->status
                    ], $delimiter);
                }
            } elseif (isset($dados['produtos'])) {
                fputcsv($file, ['ID', 'Nome', 'Preço', 'Estoque', 'Status'], $delimiter);
                foreach ($dados['produtos'] as $produto) {
                    fputcsv($file, [
                        $produto->id,
                        $produto->nome,
                        'R$ ' . number_format($produto->preco, 2, ',', '.'),
                        $produto->quantidade_estoque,
                        $produto->status
                    ], $delimiter);
                }
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
