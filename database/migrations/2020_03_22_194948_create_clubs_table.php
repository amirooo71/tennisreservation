<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClubsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create( 'clubs', function ( Blueprint $table ) {
			$table->bigIncrements( 'id' );
			$table->unsignedBigInteger( 'owner_id' );
			$table->string( 'name' );
			$table->integer( 'courts_count' );
			$table->time( 'opening_time' );
			$table->time( 'closing_time' );
			$table->integer( 'cancellation_time' );
			$table->text( 'description' )->nullable();
			$table->timestamps();

			$table->foreign( 'owner_id' )->references( 'id' )->on( 'users' )->onDelete( 'cascade' );
		} );
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists( 'clubs' );
	}
}
