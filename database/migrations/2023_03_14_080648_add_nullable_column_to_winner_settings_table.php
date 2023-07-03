<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNullableColumnToWinnerSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('winner_settings', function (Blueprint $table) {
            $table->integer('no_winners')->default(0)->change();
            $table->integer('winner_out_of')->default(0)->change();
            $table->string('start_date_time')->nullable()->change();
            $table->string('end_date_time')->nullable()->change();
            $table->string('start_date');
            $table->string('end_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('winner_settings', function (Blueprint $table) {
            //
        });
    }
}
