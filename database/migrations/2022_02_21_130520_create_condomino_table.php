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
            $table->string('apartamento');
            $table->string('name');
            $table->string('cpf');
            $table->integer('numeroquartos');
            $table->string('sindico', 1)->default('N');
            $table->string('tipo', 1)->default('A');
            $table->string('ativo', 1)->default('S');
            $table->timestamps();

            $table->unique(['apartamento', 'condominio', 'cpf', 'ativo']);
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
