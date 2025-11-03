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
        Schema::create('item_produtos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('produto_id')->constrained('produtos')->onDelete('cascade');
            $table->string('codigo_unico', 100)->unique(); // Código único para cada item
            $table->string('status', 20)->default('disponivel'); // disponivel, vendido, defeituoso
            $table->timestamp('data_entrada')->nullable();
            $table->timestamp('data_saida')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_produtos');
    }
};
