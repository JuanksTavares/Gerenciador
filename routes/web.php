<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controleproduto;
use App\Http\Controllers\Controlecaixa;
use App\Http\Controllers\Controlevendas;

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

Route::group(['middleware' => 'auth'], function(){
    
        // Tela Buscar e adicionar produto
        Route::get('/buscar', [Controleproduto::class, 'index'])->name('index');
        Route::get('/buscar/adicionar', [Controleproduto::class, 'adicionar'])->name('adicionar');
        Route::post('/buscar/adicionar', [Controleproduto::class, 'store'])->name('store');
        Route::delete('/buscar/{id}', [Controleproduto::class, 'destroy'])->name('destroy');
        Route::get('/buscar/edit/{id}', [Controleproduto::class, 'edit'])->name('edit');
        Route::put('/buscar/update/{id}', [Controleproduto::class, 'update'])->name('update');
 
    
    
    
        Route::get('/dashboard', [Controlecaixa::class,'index'])->name('dashboard');
        // Route::get('/dashboard', function () {
        //     return view('dashboard');
        // })->name('dashboard');
        Route::get('/carrinho', [Controlecaixa::class,'index'])->name('caixa.index');

        Route::post('/dashboard', [Controlecaixa::class,'store'])->name('caixa.store');


        //Tela Venda
         Route::get('/vendas',[Controlevendas::class,'index'])->name('venda.index');
});

require __DIR__.'/auth.php';

