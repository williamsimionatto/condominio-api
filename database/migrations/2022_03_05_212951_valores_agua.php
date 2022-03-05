<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ValoresAgua extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('leitura_agua_valores', function (Blueprint $table) {
            $table->decimal('taxaboleto', 10, 2)->nullable();
            $table->decimal('taxabasicaagua', 10, 2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('leitura_agua_valores', function (Blueprint $table) {
            //
        });
    }
}
