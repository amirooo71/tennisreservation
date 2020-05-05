<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFixBookingsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create( 'fix_bookings', function ( Blueprint $table ) {
			$table->bigIncrements( 'id' );
			$table->unsignedBigInteger( 'court_id' );
			$table->string( 'renter_name' );
			$table->string( 'day' );
			$table->string( 'time' );
			$table->string( 'partner_name' )->nullable();
			$table->unique( [ 'day', 'time','court_id' ] );
			$table->timestamps();
		} );
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists( 'fix_bookings' );
	}
}
