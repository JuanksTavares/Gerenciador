<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ControleProduto; // Nome corrigido
use App\Http\Controllers\ControleCaixa;   // Nome corrigido
use App\Http\Controllers\ControleVendas;  // Nome corrigido
use App\Http\Controllers\ControleFornecedor;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

require __DIR__.'/auth.php';

// Rotas Públicas (se houver)
// ...

// Rotas Protegidas por Autenticação
Route::middleware('auth')->group(function() {
    
    // Dashboard Principal
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // ========== ROTAS DE PRODUTOS ==========
    Route::prefix('produtos')->name('produtos.')->group(function() {
        Route::get('/', [ControleProduto::class, 'index'])->name('index');
        Route::get('/adicionar', [ControleProduto::class, 'adicionar'])->name('adicionar');
        Route::post('/adicionar', [ControleProduto::class, 'store'])->name('store');
        Route::get('/edit/{id}', [ControleProduto::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [ControleProduto::class, 'update'])->name('update');
        Route::delete('/{id}', [ControleProduto::class, 'destroy'])->name('destroy');
        Route::get('/buscar', [ControleProduto::class, 'index'])->name('buscar');
    });

    // ========== ROTAS DE CAIXA ==========
    // Rotas de caixa
    Route::prefix('caixa')->name('caixa.')->group(function() {
        Route::get('/', [ControleCaixa::class, 'index'])->name('index');
        Route::post('/venda', [ControleCaixa::class, 'storeVenda'])->name('venda.store');
        Route::post('/carrinho/adicionar', [ControleCaixa::class, 'adicionarItemCarrinho'])->name('carrinho.adicionar');
        Route::post('/carrinho/remover/{id}', [ControleCaixa::class, 'removerItemCarrinho'])->name('carrinho.remover');
        Route::post('/carrinho/alterar/{id}', [ControleCaixa::class, 'alterarQuantidadeItem'])->name('carrinho.alterar');
        Route::post('/carrinho/limpar', [ControleCaixa::class, 'limparCarrinho'])->name('carrinho.limpar');
        Route::get('/historico', [ControleCaixa::class, 'historico'])->name('historico');
        Route::get('/caixa/venda/{id}', [ControleCaixa::class, 'show'])->name('venda.show');
        Route::get('/caixa/venda/{id}/cancelar', [ControleCaixa::class, 'show'])->name('venda.cancelar');
        

    });

    // ========== ROTAS DE VENDAS ==========
    Route::prefix('vendas')->name('vendas.')->group(function() {
        Route::get('/', [ControleVendas::class, 'index'])->name('index');
        // Adicione outras rotas de vendas conforme necessário
    });

    // ========== ROTAS DE FORNECEDORES ==========
    Route::prefix('fornecedores')->name('fornecedores.')->group(function() {
    Route::get('/', [ControleFornecedor::class, 'index'])->name('index');
    Route::get('/adicionar', [ControleFornecedor::class, 'adicionar'])->name('adicionar');
    Route::post('/adicionar', [ControleFornecedor::class, 'store'])->name('store');
    Route::get('/{id}', [ControleFornecedor::class, 'show'])->name('show');
    Route::get('/edit/{id}', [ControleFornecedor::class, 'edit'])->name('edit');
    Route::put('/update/{id}', [ControleFornecedor::class, 'update'])->name('update');
    Route::delete('/{id}', [ControleFornecedor::class, 'destroy'])->name('destroy');
    Route::get('/api/fornecedores', [ControleFornecedor::class, 'apiFornecedores'])->name('api.fornecedores');
    });
});

// ========== ROTA DE FALLBACK ==========
Route::fallback(function () {
    return redirect()->route('dashboard');
});