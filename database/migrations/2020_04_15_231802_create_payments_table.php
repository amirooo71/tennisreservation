<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create( 'payments', function ( Blueprint $table ) {
			$table->bigIncrements( 'id' );
			$table->unsignedBigInteger( 'coach_id' )->nullable();
			$table->unsignedBigInteger( 'booking_id' )->nullable();
			$table->unsignedBigInteger( 'part_time_booking_id' )->nullable();
			$table->double( 'amount' );
			$table->boolean( 'is_coach_paid' )->default( false );
			$table->timestamps();
		} );
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists( 'payments' );
	}
}
