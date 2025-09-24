<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('itens_venda', function (Blueprint $table) {
            $table->id();
            $table->foreignId('venda_id')->constrained('vendas');
            $table->foreignId('produto_id')->constrained('produtos');
            $table->integer('quantidade');
            $table->decimal('preco_unitario', 10, 2);
            $table->decimal('subtotal', 10, 2);
            $table->timestamps();
        });
    }

    public function down()
    {

        if (Schema::hasTable('itens_venda')) {
            Schema::table('itens_venda', function (Blueprint $table) {
                $table->dropConstrainedForeignId('venda_id');
                $table->dropConstrainedForeignId('produto_id');
            });

            Schema::dropIfExists('item_vendas');
        }
    }
};