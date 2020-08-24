<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCoachToFixBookings extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fix_bookings', function (Blueprint $table) {
            $table->string('renter_name')->nullable()->change();
            $table->unsignedBigInteger('coach_id')->nullable();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fix_bookings', function (Blueprint $table) {
            //
        });
    }

}
