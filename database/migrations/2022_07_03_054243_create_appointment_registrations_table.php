<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppointmentRegistrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointment_registrations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('username');
            $table->string('type');
            $table->string('chat_option')->nullable();
            $table->string('restaurant')->nullable();
            $table->longText('datetime')->nullable();
            $table->string('appointment_user');
            $table->longText('appointment_respond')->nullable();
            $table->longText('appointment_result')->nullable();
            $table->longText('message')->nullable();
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
        Schema::dropIfExists('appointment_registrations');
    }
}
