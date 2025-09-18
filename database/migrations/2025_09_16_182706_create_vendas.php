<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('vendas', function (Blueprint $table) {
            $table->id();
            $table->datetime('data_venda');
            $table->decimal('valor_total', 10, 2);
            $table->string('forma_pagamento', 2);
            $table->integer('parcelas')->default(1);
            $table->decimal('valor_recebido', 10, 2)->default(0);
            $table->decimal('troco', 10, 2)->default(0);
            $table->foreignId('usuario_id')->constrained('users');
            $table->string('status', 2)->default('RE'); // RE=Realizada, CA=Cancelada
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('vendas');
    }
};