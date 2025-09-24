<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('relatorios', function (Blueprint $table) {
            $table->id();
            $table->string('tipo', 50);
            $table->date('periodo');
            $table->text('dados');
            $table->foreignId('usuario_id')->constrained('users'); // Alterado de 'usuarios' para 'users'
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::table('relatorios', function (Blueprint $table) {
            $table->dropForeign(['usuario_id']);
        });
        
        Schema::dropIfExists('relatorios');
    }
};