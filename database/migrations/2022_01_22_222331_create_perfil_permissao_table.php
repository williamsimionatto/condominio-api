<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePerfilPermissaoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('perfilpermisao', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('perfil');
            $table->unsignedBigInteger('permissao');
            $table->string('consultar', 1)->default('N');
            $table->string('inserir', 1)->default('N');
            $table->string('alterar', 1)->default('N');
            $table->string('excluir', 1)->default('N');
            $table->timestamps();
        });

        Schema::table('perfilpermisao', function (Blueprint $table) {
            $table->foreign('perfil')->references('id')->on('perfil');
            $table->foreign('permissao')->references('id')->on('permissao');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('perfilpermisao');
    }
}
