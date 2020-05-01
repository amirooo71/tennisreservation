<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coach extends Model {
	protected $guarded = [];

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function bookings() {
		return $this->hasMany( Booking::class );
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function partTimeBookings() {
		return $this->hasMany( PartTimeBooking::class );
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasOne
	 */
	public function balance() {
		return $this->hasOne( CoachBalance::class );
	}

	/**
	 * @return mixed
	 */
	public function debtAmount() {

		if ( $this->balance ) {
			return $this->balance->balance;
		}


		$bookings = $this->bookings()->where( 'is_canceled', '=', false )->where( 'is_paid', '=', false );

		$partTimeAmount = $bookings->get()->reduce( function ( $carry, $item ) {
			return $carry + ( $item->partTime ? $item->partTime->amount : 0 );
		} );


		return $bookings->sum( 'amount' ) + $partTimeAmount;
	}

}
