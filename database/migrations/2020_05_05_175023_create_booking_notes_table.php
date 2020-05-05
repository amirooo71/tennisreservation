<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingNotesTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create( 'booking_notes', function ( Blueprint $table ) {
			$table->bigIncrements( 'id' );
			$table->unsignedBigInteger( 'user_id' );
			$table->string( 'date' );
			$table->string( 'time' );
			$table->text( 'description' );
			$table->timestamps();
		} );
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists( 'booking_notes' );
	}
}
