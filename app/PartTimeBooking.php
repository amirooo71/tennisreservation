<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PartTimeBooking extends Model {

	protected $guarded = [];

	public function booking() {
		return $this->belongsTo( Booking::class );
	}


}
