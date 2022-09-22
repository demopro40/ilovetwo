<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePushFactorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('push_factors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('username');
            $table->string('age')->nullable();
            $table->string('job')->nullable();
            $table->string('height')->nullable();
            $table->string('weight')->nullable();
            $table->string('income')->nullable();
            $table->string('o_age')->nullable();
            $table->string('o_job')->nullable();
            $table->string('o_height')->nullable();
            $table->string('o_weight')->nullable();
            $table->string('o_income')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('push_factors');
    }
}
