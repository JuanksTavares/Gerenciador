<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $tipo }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
            padding: 20px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 3px solid #3b82f6;
        }
        
        .header h1 {
            color: #1e40af;
            font-size: 24px;
            margin-bottom: 10px;
        }
        
        .header p {
            color: #6b7280;
            font-size: 14px;
        }
        
        .resumo {
            background-color: #f3f4f6;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        
        .resumo h2 {
            color: #1e40af;
            font-size: 16px;
            margin-bottom: 10px;
        }
        
        .resumo-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
        }
        
        .resumo-item {
            background-color: white;
            padding: 10px;
            border-radius: 5px;
            border-left: 3px solid #3b82f6;
        }
        
        .resumo-item label {
            display: block;
            color: #6b7280;
            font-size: 11px;
            margin-bottom: 5px;
        }
        
        .resumo-item span {
            font-size: 16px;
            font-weight: bold;
            color: #1e40af;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            margin-bottom: 20px;
        }
        
        table thead {
            background-color: #3b82f6;
            color: white;
        }
        
        table th {
            padding: 10px;
            text-align: left;
            font-size: 12px;
        }
        
        table td {
            padding: 8px;
            border-bottom: 1px solid #e5e7eb;
            font-size: 11px;
        }
        
        table tbody tr:nth-child(even) {
            background-color: #f9fafb;
        }
        
        .section-title {
            color: #1e40af;
            font-size: 16px;
            font-weight: bold;
            margin-top: 20px;
            margin-bottom: 10px;
            padding-bottom: 5px;
            border-bottom: 2px solid #3b82f6;
        }
        
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 2px solid #e5e7eb;
            text-align: center;
            color: #6b7280;
            font-size: 10px;
        }
        
        .text-success {
            color: #10b981;
            font-weight: bold;
        }
        
        .text-right {
            text-align: right;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ $tipo }}</h1>
        <p>{{ $periodo }}</p>
        <p>Gerado em: {{ \Carbon\Carbon::now()->format('d/m/Y H:i:s') }}</p>
    </div>

    @if(isset($resumo))
        <div class="resumo">
            <h2>Resumo</h2>
            <div class="resumo-grid">
                @foreach($resumo as $key => $value)
                    <div class="resumo-item">
                        <label>{{ ucfirst(str_replace('_', ' ', $key)) }}</label>
                        <span>
                            @if(str_contains($key, 'total') || str_contains($key, 'valor') || str_contains($key, 'ticket'))
                                R$ {{ number_format($value, 2, ',', '.') }}
                            @else
                                {{ $value }}
                            @endif
                        </span>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    @if(isset($vendas) && $vendas->count() > 0)
        <h3 class="section-title">Detalhamento de Vendas</h3>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Data</th>
                    <th>Forma Pagamento</th>
                    <th>Valor Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($vendas as $venda)
                    <tr>
                        <td>#{{ $venda->id }}</td>
                        <td>{{ \Carbon\Carbon::parse($venda->data_venda)->format('d/m/Y H:i') }}</td>
                        <td>
                            @switch($venda->forma_pagamento)
                                @case('DI') Dinheiro @break
                                @case('CR') Crédito @break
                                @case('DE') Débito @break
                                @case('PI') PIX @break
                                @default Outros
                            @endswitch
                        </td>
                        <td class="text-success">R$ {{ number_format($venda->valor_total, 2, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    @if(isset($produtos) && $produtos->count() > 0)
        <h3 class="section-title">Produtos em Estoque</h3>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Preço</th>
                    <th>Estoque</th>
                    <th>Status</th>
                    <th>Valor Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($produtos as $produto)
                    <tr>
                        <td>#{{ $produto->id }}</td>
                        <td>{{ $produto->nome }}</td>
                        <td>R$ {{ number_format($produto->preco, 2, ',', '.') }}</td>
                        <td>{{ $produto->quantidade_estoque }}</td>
                        <td>
                            @switch($produto->status)
                                @case('A') Ativo @break
                                @case('B') Baixo Estoque @break
                                @case('I') Inativo @break
                                @default -
                            @endswitch
                        </td>
                        <td class="text-success">R$ {{ number_format($produto->preco * $produto->quantidade_estoque, 2, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    @if(isset($produtos_mais_vendidos) && $produtos_mais_vendidos->count() > 0)
        <h3 class="section-title">Produtos Mais Vendidos</h3>
        <table>
            <thead>
                <tr>
                    <th>Produto</th>
                    <th>Quantidade Vendida</th>
                    <th>Valor Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($produtos_mais_vendidos as $produto)
                    <tr>
                        <td>{{ $produto->nome }}</td>
                        <td>{{ $produto->total_vendido }} unidades</td>
                        <td class="text-success">R$ {{ number_format($produto->valor_total, 2, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    @if(isset($vendas_por_forma_pagamento))
        <h3 class="section-title">Vendas por Forma de Pagamento</h3>
        <table>
            <thead>
                <tr>
                    <th>Forma de Pagamento</th>
                    <th>Quantidade</th>
                    <th>Valor Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($vendas_por_forma_pagamento as $forma)
                    <tr>
                        <td>{{ $forma->nome }}</td>
                        <td>{{ $forma->quantidade }}</td>
                        <td class="text-success">R$ {{ number_format($forma->total, 2, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    @if(isset($vendas_por_dia) && $vendas_por_dia->count() > 0)
        <h3 class="section-title">Vendas por Dia</h3>
        <table>
            <thead>
                <tr>
                    <th>Data</th>
                    <th>Quantidade</th>
                    <th>Valor Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($vendas_por_dia as $dia)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($dia->data)->format('d/m/Y') }}</td>
                        <td>{{ $dia->quantidade }} vendas</td>
                        <td class="text-success">R$ {{ number_format($dia->total, 2, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    @if(isset($vendas_por_mes) && $vendas_por_mes->count() > 0)
        <h3 class="section-title">Vendas por Mês</h3>
        <table>
            <thead>
                <tr>
                    <th>Mês/Ano</th>
                    <th>Quantidade</th>
                    <th>Valor Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($vendas_por_mes as $mes)
                    <tr>
                        <td>{{ str_pad($mes->mes, 2, '0', STR_PAD_LEFT) }}/{{ $mes->ano }}</td>
                        <td>{{ $mes->quantidade }} vendas</td>
                        <td class="text-success">R$ {{ number_format($mes->total, 2, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <div class="footer">
        <p>Sistema de Gerenciamento - Relatório gerado automaticamente</p>
    </div>
</body>
</html>
