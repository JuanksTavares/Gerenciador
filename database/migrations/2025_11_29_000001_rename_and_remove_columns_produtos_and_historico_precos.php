<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Produtos: rename cod_loja -> cod_barra, drop cod_forne
        Schema::table('produtos', function (Blueprint $table) {
            if (Schema::hasColumn('produtos', 'cod_loja')) {
                $table->renameColumn('cod_loja', 'cod_barra');
            }
            if (Schema::hasColumn('produtos', 'cod_forne')) {
                $table->dropColumn('cod_forne');
            }
        });

        // Historico_precos: rename cod_loja -> cod_barra
        if (Schema::hasTable('historico_precos')) {
            Schema::table('historico_precos', function (Blueprint $table) {
                if (Schema::hasColumn('historico_precos', 'cod_loja')) {
                    $table->renameColumn('cod_loja', 'cod_barra');
                }
            });
        }
    }

    public function down(): void
    {
        // Reverse operations
        Schema::table('produtos', function (Blueprint $table) {
            if (Schema::hasColumn('produtos', 'cod_barra')) {
                $table->renameColumn('cod_barra', 'cod_loja');
            }
            // Cannot restore cod_forne data; recreate nullable column
            if (!Schema::hasColumn('produtos', 'cod_forne')) {
                $table->string('cod_forne', 50)->nullable();
            }
        });

        if (Schema::hasTable('historico_precos')) {
            Schema::table('historico_precos', function (Blueprint $table) {
                if (Schema::hasColumn('historico_precos', 'cod_barra')) {
                    $table->renameColumn('cod_barra', 'cod_loja');
                }
            });
        }
    }
};