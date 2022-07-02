<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Period extends Migration {
    public function up() {
        Schema::create('periods', function (Blueprint $table) {
            $table->id();
            $table->date('start_date');
            $table->date('end_date');
            $table->string('status', 1)->default('A');
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('periods');
    }
}
