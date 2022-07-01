<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InactiveCondomino extends Migration {
    public function up(){
        Schema::table('condomino', function (Blueprint $table) {
            $table->timestamp('inactive_at')->nullable();
        });
    }

    public function down() {
        Schema::table('condomino', function (Blueprint $table) {
            $table->dropColumn('inactive_at');
        });
    }
}
