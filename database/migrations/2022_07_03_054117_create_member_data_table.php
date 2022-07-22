<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMemberDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member_data', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('username')->unique();
            $table->string('identity')->unique();
            $table->string('phone')->unique();
            $table->string('email')->unique();
            $table->string('gender');
            $table->string('consultant')->nullable();
            $table->string('data_url')->nullable();
            $table->string('data_url_simple')->nullable();
            $table->string('plan')->nullable();
            $table->string('live_place')->nullable();
            $table->string('birth_place')->nullable();
            $table->string('record')->nullable();
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
        Schema::dropIfExists('member_data');
    }
}
