<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Debtor extends Model {
	protected $guarded = [];

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function coach() {
		return $this->belongsTo( Coach::class );
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function booked() {
		return $this->belongsTo( Booking::class, 'booking_id' );
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function partTimeBooked() {
		return $this->belongsTo( PartTimeBooking::class, 'part_time_booking_id' );
	}

}
