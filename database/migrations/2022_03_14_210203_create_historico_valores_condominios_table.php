<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistoricoValoresCondominiosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('historico_valores_condominios', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('leitura');
            $table->double('condominio2quartos');
            $table->double('condominio3quartos');
            $table->double('condominiosalacomercial');
            $table->double('valoragua');
            $table->double('valorsalaofestas');
            $table->double('valorlimpezasalaofestas');
            $table->double('valormudanca');
            $table->timestamps();
        });

        Schema::table('historico_valores_condominios', function (Blueprint $table) {
            $table->foreign('id')->references('id')->on('leitura_agua');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('historico_valores_condominios');
    }
}
