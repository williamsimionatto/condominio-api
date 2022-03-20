<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Sindico extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('historico_valores_condominios', function (Blueprint $table) {
            $table->bigInteger('sindico')->unsigned()->nullable();
        });

        Schema::table('historico_valores_condominios', function (Blueprint $table) {
            $table->foreign('sindico')->references('id')->on('condomino');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('historico_valores_condominios', function (Blueprint $table) {
            $table->dropForeign('historico_valores_condominios_sindico_foreign');
            $table->dropColumn('sindico');
        });
    }
}
