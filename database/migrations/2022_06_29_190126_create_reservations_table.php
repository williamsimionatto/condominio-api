<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservationsTable extends Migration {
    public function up() {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('condomino_id');
            $table->unsignedBigInteger('common_area_id');
            $table->date('date');
            $table->timestamps();
        });

        Schema::table('reservations', function (Blueprint $table) {
            $table->foreign('condomino_id')->references('id')->on('condomino');
            $table->foreign('common_area_id')->references('id')->on('common_areas');
        });
    }

    public function down() {
        Schema::dropIfExists('reservations');
    }
}
