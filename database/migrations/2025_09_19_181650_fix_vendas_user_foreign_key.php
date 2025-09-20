<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // Desabilitar verificação de foreign keys temporariamente
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // Remover a constraint existente
        Schema::table('vendas', function (Blueprint $table) {
            $table->dropForeign(['usuario_id']);
        });
        
        // Adicionar nova constraint apontando para users
        Schema::table('vendas', function (Blueprint $table) {
            $table->foreign('usuario_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
        });
        
        // Reabilitar verificação de foreign keys
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    public function down()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        Schema::table('vendas', function (Blueprint $table) {
            $table->dropForeign(['usuario_id']);
        });
        
        // Se quiser reverter para usuarios (não recomendado)
        // $table->foreign('usuario_id')
        //       ->references('id')
        //       ->on('usuarios')
        //       ->onDelete('cascade');
        
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
};