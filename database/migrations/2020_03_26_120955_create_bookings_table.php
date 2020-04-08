<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create( 'bookings', function ( Blueprint $table ) {
			$table->bigIncrements( 'id' );
			$table->unsignedBigInteger( 'owner_id' )->nullable();
			$table->unsignedBigInteger( 'court_id' );
			$table->date( 'date' );
			$table->time( 'time' );
			$table->string( 'renter_name' );
			$table->boolean( 'is_canceled' )->default( false );
			$table->boolean( 'is_paid' )->default( false );
			$table->string( 'partner_name' )->nullable();
			$table->time( 'start_time' )->nullable();
			$table->time( 'end_time' )->nullable();
			$table->boolean( 'is_part_time' )->default( false );
			$table->unique( [ 'date', 'time' ] );
			$table->timestamps();

			$table->foreign( 'court_id' )->references( 'id' )->on( 'courts' )->onDelete( 'cascade' );

		} );
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists( 'bookings' );
	}
}
