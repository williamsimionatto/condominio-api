<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCondominoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('condomino', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('condominio')->unsigned();
            $table->bigInteger('apartamento');
            $table->string('nome');
            $table->string('cpf');
            $table->string('sindico', 1)->default('N');
            $table->string('tipo', 1)->default('A');
            $table->integer('numeroquartos');
            $table->timestamps();

            $table->unique(['apartamento', 'condominio']);
        });

        Schema::table('condomino', function (Blueprint $table) {
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
        Schema::dropIfExists('condomino');
    }
}
