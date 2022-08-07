<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Doctors extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctors', function(Blueprint $table)
		{$table->increments('id');$table->char('name',100);$table->char('address',250);
        });

        DB::table('doctors')->insert(['name' => "Dr Brick Wall",'address' => "23 Orchard Lane Dedham, MA 02026"]);
        DB::table('doctors')->insert(['name' => "Dr Ether",'address' => "405 Aspen St. Prattville, AL 36067"]);
        DB::table('doctors')->insert(['name' => "Dr Tranquilli ",'address' => "8500 New Street Tampa, FL 33604"]);
        DB::table('doctors')->insert(['name' => "Dr Chloe",'address' => "99 Grove Street Lake Zurich, IL 60047"]);
        DB::table('doctors')->insert(['name' => "Dr Trepman",'address' => "9044 Nicolls Court Framingham, MA 01701"]);
        DB::table('doctors')->insert(['name' => "Dr Tony",'address' => "3 Indian Summer St. Brunswick, GA 31525"]);
        DB::table('doctors')->insert(['name' => "Dr Jhon",'address' => "970 Rockland Drive Baldwin Park, CA 91706"]);
        DB::table('doctors')->insert(['name' => "Dr Derek",'address' => "87 High Ave.Santa Ana, CA 92707"]);
        DB::table('doctors')->insert(['name' => "Dr Scott",'address' => "65 Piper CourtPittsburg, CA 94565"]);
        DB::table('doctors')->insert(['name' => "Dr Ketty",'address' => "5 E. Durham StreetSan Jose, CA 95116"]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('doctors');
    }
}
