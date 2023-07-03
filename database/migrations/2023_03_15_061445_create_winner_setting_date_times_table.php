<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWinnerSettingDateTimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('winner_setting_date_times', function (Blueprint $table) {
            $table->id();
            $table->integer('winner_setting_date_id');
            $table->string('start_time');
            $table->string('end_time');
            $table->integer('no_winners');
            $table->integer('winner_out_of');
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
        Schema::dropIfExists('winner_setting_date_times');
    }
}
