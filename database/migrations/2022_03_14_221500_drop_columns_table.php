<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropColumnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('leitura_agua_valores', function (Blueprint $table) {
            $table->dropColumn('condominio2quartos');
            $table->dropColumn('condominio3quartos');
            $table->dropColumn('condominiosalacomercial');
            $table->dropColumn('valoragua');
            $table->dropColumn('valorsalaofestas');
            $table->dropColumn('valorlimpezasalaofestas');
            $table->dropColumn('valormudanca');
            $table->dropColumn('taxaboleto');
            $table->dropColumn('taxabasicaagua');
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
