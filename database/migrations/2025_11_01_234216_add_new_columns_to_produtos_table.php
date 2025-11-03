<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('produtos', function (Blueprint $table) {
            $table->string('cod_loja', 50)->nullable()->after('id');
            $table->string('cod_forne', 50)->nullable()->after('cod_loja');
            $table->decimal('preco_compra', 10, 2)->nullable()->after('descricao');
            $table->decimal('preco_venda', 10, 2)->nullable()->after('preco_compra');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('produtos', function (Blueprint $table) {
            $table->dropColumn(['cod_loja', 'cod_forne', 'preco_compra', 'preco_venda']);
        });
    }
};
