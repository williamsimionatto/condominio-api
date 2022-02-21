<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeituraAguaValoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leitura_agua_valores', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('leitura_agua');
            $table->unsignedBigInteger('condomino');
            $table->unsignedBigInteger('consumo');
            $table->double('condominio2quartos');
            $table->double('condominio3quartos');
            $table->double('condominiosalacomercial');
            $table->double('valoragua');
            $table->double('valorsalaofestas');
            $table->double('valorlimpezasalaofestas');
            $table->double('valormudanca');
            $table->timestamps();
        });

        Schema::table('leitura_agua_valores', function (Blueprint $table) {
            $table->foreign('leitura_agua')->references('id')->on('leitura_agua');
            $table->foreign('condomino')->references('id')->on('condomino');
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
