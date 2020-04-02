<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePartTimeBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('part_time_bookings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('owner_id')->nullable();
            $table->unsignedBigInteger('booking_id');
            $table->string('renter_name');
	        $table->boolean( 'is_canceled' )->default( false );
	        $table->boolean( 'is_paid' )->default( false );
	        $table->string( 'partner_name' )->nullable();
	        $table->time( 'remain_time' )->nullable();
            $table->timestamps();

	        $table->foreign( 'booking_id' )->references( 'id' )->on( 'bookings' )->onDelete( 'cascade' );

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('part_time_bookings');
    }
}