<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SortCondominos extends Migration {
    public function up() {
        Schema::table('condomino', function (Blueprint $table) {
            $table->integer('position')->nullable()->default(1)->unique();
        });
    }

    public function down()    {
        Schema::table('condomino', function (Blueprint $table) {
            $table->dropColumn('position');
        });
    }
}
