<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PartTimeBooking extends Model {

	protected $guarded = [];

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function booking() {
		return $this->belongsTo( Booking::class );
	}


}
