<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddWinnerSettingIdColumnToWinnerSettingDateTimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('winner_setting_date_times', function (Blueprint $table) {
            $table->integer('winner_setting_id');
            $table->integer('winner_setting_date_id')->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('winner_setting_date_times', function (Blueprint $table) {
            //
        });
    }
}
