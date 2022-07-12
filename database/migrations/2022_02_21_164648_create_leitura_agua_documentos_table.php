<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateLeituraAguaDocumentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leitura_agua_documentos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('leitura_agua_valores');
            $table->string('nomearquivo');
            $table->string('tipoanexo');
            $table->integer('tamanho');
            $table->binary('arquivo');
            $table->timestamps();
        });

        DB::statement("ALTER TABLE leitura_agua_documentos MODIFY COLUMN arquivo LONGBLOB");

        Schema::table('leitura_agua_documentos', function (Blueprint $table) {
            $table->foreign('leitura_agua_valores')->references('id')->on('leitura_agua_valores');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('leitura_agua_documentos');
    }
}
