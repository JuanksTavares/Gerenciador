<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('dashboard_configs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usuario_id')->constrained('users'); // Corrigido para referenciar 'users'
            $table->json('configuracoes');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::table('dashboard_configs', function (Blueprint $table) {
            $table->dropForeign(['usuario_id']);
        });
        
        Schema::dropIfExists('dashboard_configs');
    }
};