<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class LeituraAguaPeriod extends Migration {
    public function up() {
        Schema::table('leitura_agua', function (Blueprint $table) {
            $table->unsignedBigInteger('period_id')->nullable();
        });

        Schema::table('leitura_agua', function (Blueprint $table) {
            $table->foreign('period_id')->references('id')->on('periods');
        });
    }

    public function down() {
        Schema::table('leitura_agua', function (Blueprint $table) {
            $table->dropForeign(['period_id']);
        });

        Schema::table('leitura_agua', function (Blueprint $table) {
            $table->dropColumn('period_id');
        });
    }
}
