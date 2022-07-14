<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCashFlowsTable extends Migration {
    public function up() {
        Schema::create('cash_flows', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('period_id');
            $table->string('type');
            $table->string('description');
            $table->decimal('amount', 10, 2);
            $table->date('date');
            $table->timestamps();
        });

        Schema::table('cash_flows', function (Blueprint $table) {
            $table->foreign('period_id')->references('id')->on('periods');
        });
    }

    public function down() {
        Schema::dropIfExists('cash_flows');
    }
}
