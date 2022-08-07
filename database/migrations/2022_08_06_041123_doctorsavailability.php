<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Doctorsavailability extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctors_availability', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('doctor_id');
            $table->enum('days', ['1', '2', '3', '4', '5', '6', '7'])->comment('monday','tuesday','wednesday','thursday','friday','saturday','subday');
            $table->boolean('open_status');
            $table->time('start_time');
            $table->time('end_time');
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('doctors_availability');
    }
}
