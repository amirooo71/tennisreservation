<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourtsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create( 'courts', function ( Blueprint $table ) {

			$table->bigIncrements( 'id' );
			$table->unsignedBigInteger( 'club_id' );
			$table->string( 'name' );
			$table->string( 'type' );
			$table->double('price');
			$table->boolean( 'is_indoor' );
			$table->boolean( 'is_center' );
			$table->timestamps();

			$table->foreign( 'club_id' )->references( 'id' )->on( 'clubs' )->onDelete( 'cascade' );

		} );
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists( 'courts' );
	}
}
