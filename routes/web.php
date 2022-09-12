<?php

use Illuminate\Support\Facades\Route;

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
    Route::get('/dashboard/buscar', [Controleproduto::class, 'index'])->name('index');
    Route::get('/buscar/adicionar', [Controleproduto::class, 'adicionar'])->name('adicionar');
    Route::post('/buscar/adicionar', [Controleproduto::class, 'store']);
    Route::delete('/buscar/{id}', [Controleproduto::class, 'destroy']);
    Route::get('/buscar/edit/{id}', [Controleproduto::class, 'edit']);
    Route::put('/buscar/update/{id}', [Controleproduto::class, 'update']);
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

require __DIR__.'/auth.php';

