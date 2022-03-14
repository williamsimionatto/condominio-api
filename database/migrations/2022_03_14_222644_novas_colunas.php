<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class NovasColunas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('leitura_agua_valores', function (Blueprint $table) {
            $table->decimal('valorcondominio', 10, 2)->nullable();
            $table->integer('qtdusosalao')->nullable()->default(0);
            $table->integer('qtdlimpezasalao')->nullable()->default(0);
            $table->integer('qtdmudanca')->nullable()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('leitura_agua_valores');
    }
}
