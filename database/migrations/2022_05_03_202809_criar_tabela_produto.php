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
        Schema::create('Produtos', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->float('cod_barra');
            $table->float('valor_venda');
            $table->float('custo_medio');
            $table->float('estoque_disponivel');
            $table->float('estoque_max');
            $table->float('estoque_min');
            $table->string('origem_produto');
            $table->float('ncm');
            $table->string('cest');
            $table->string('unidade_medida');
            $table->string('categoria');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('Produtos');
    }
};
