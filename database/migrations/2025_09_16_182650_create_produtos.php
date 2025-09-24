<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('produtos', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 100);
            $table->text('descricao')->nullable();
            $table->decimal('preco', 10, 2);
            $table->integer('quantidade_estoque')->default(0);
            $table->integer('estoque_minimo')->default(0);
            // $table->string('status', 2)->default('AT'); // AT = Ativo, TB = Estoque Baixo e DS = desativado
            $table->foreignId('fornecedor_id')->constrained('fornecedors');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('produtos');
    }
};