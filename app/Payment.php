<?php

namespace App;

use App\Traits\ShamsiTimestamps;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model {

	use ShamsiTimestamps;

	protected $guarded = [];

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function booked() {
		return $this->belongsTo( Booking::class ,'booking_id');
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function partTimeBooked() {
		return $this->belongsTo( PartTimeBooking::class ,'part_time_booking_id');
	}

}
