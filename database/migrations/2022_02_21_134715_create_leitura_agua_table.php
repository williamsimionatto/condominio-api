<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeituraAguaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leitura_agua', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('condominio')->unsigned();
            $table->date('dataleitura');
            $table->date('datavencimento');
            $table->timestamps();
        });

        Schema::table('leitura_agua', function (Blueprint $table) {
            $table->foreign('condominio')->references('id')->on('condominio');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('leitura_agua');
    }
}
