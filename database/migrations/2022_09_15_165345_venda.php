<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Venda', function (Blueprint $table) {
            $table->id('id_venda');
            $table->string('nome_produto');
            $table->float('Quantidade');
            $table->float('valor');
            $table->float('forma_pagamento');
            $table->timestamps('data_venda');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('Venda');
    }
};
