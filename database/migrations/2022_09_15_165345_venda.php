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
            $table->float('valor_total');
            $table->String('forma_pagamento');
            $table->float('parcelas');
            $table->float('valor_parcelas');
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
