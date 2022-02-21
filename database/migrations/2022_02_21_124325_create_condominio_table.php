<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCondominioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('condominio', function (Blueprint $table) {
            $table->id()->unsigned();
            $table->string('name');
            $table->string('cnpj');
            $table->double('condominio2quartos');
            $table->double('condominio3quartos');
            $table->double('condominiosalacomercial');
            $table->double('valoragua');
            $table->double('valorsalaofestas');
            $table->double('valorlimpezasalaofestas');
            $table->double('valormudanca');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('condominio');
    }
}
