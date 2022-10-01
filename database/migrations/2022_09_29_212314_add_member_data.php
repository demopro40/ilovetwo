<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMemberData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('member_data', function (Blueprint $table) {
            $table->string('age')->nullable();
            $table->string('job')->nullable();
            $table->string('height')->nullable();
            $table->string('weight')->nullable();
            $table->string('income')->nullable();
            $table->string('o_age')->nullable()->comment('要求年齡');
            $table->string('o_job')->nullable()->comment('要求職業');
            $table->string('o_height')->nullable()->comment('要求身高');
            $table->string('o_weight')->nullable()->comment('要求體重');
            $table->string('o_income')->nullable()->comment('要求收入');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('member_data', function (Blueprint $table) {
            $table->dropColumn('age');
            $table->dropColumn('job');
            $table->dropColumn('height');
            $table->dropColumn('weight');
            $table->dropColumn('income');
            $table->dropColumn('o_age');
            $table->dropColumn('o_job');
            $table->dropColumn('o_height');
            $table->dropColumn('o_weight');
            $table->dropColumn('o_income');
        });
    }
}
