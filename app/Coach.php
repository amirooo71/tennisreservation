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

}
