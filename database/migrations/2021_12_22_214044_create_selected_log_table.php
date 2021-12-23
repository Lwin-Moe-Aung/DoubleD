<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSelectedLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('selected_log', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('morning_first_select', 100)->nullable();
            $table->string('mfs_stock_id', 100)->nullable();
            $table->string('morning_second_select', 100)->nullable();
            $table->string('mss_stock_id', 100)->nullable();
            // $table->string('morning_selected_stock', 100)->nullable();
            $table->dateTime('morning_ss_time', 0)->nullable();

            $table->string('evening_first_select', 100)->nullable();
            $table->string('efs_stock_id', 100)->nullable();
            $table->string('evening_second_select', 100)->nullable();
            $table->string('ess_stock_id', 100)->nullable();
            // $table->string('evening_selected_stock', 100)->nullable();
            $table->dateTime('evening_ss_time', 0)->nullable();

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
        Schema::dropIfExists('selected_log');
    }
}
