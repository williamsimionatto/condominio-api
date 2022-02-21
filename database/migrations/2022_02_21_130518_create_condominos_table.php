<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCondominosTable extends Migration
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
            $table->bigInteger('apartamento');
            $table->bigInteger('condomino');
            $table->string('nome');
            $table->string('cpf');
            $table->string('sindico', 1)->default('N');
            $table->string('tipo', 1)->default('A');
            $table->integer('numeroquartos');
            $table->timestamps();

            $table->unique(['apartamento', 'condomino']);
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
