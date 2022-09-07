<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppointmentListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointment_lists', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('username');
            $table->longText('appointment_username')->nullable();
            $table->longText('appointment_user_new')->nullable();
            $table->longText('appointment_user_latest')->nullable();
            $table->longText('appointment_user_excluded')->nullable();
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
        Schema::dropIfExists('appointment_lists');
    }
}
