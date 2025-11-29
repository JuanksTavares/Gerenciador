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
        if (!Schema::hasTable('historico_precos')) {
            Schema::create('historico_precos', function (Blueprint $table) {
                $table->id();
                // Estrutura mínima original (colunas adicionais já são tratadas em outras migrações)
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historico_precos');
    }
};
