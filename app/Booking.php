<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model {

	protected $guarded = [];

	protected $with = [ 'partTime' ];

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasOne
	 */
	public function partTime() {
		return $this->hasOne( PartTimeBooking::class );
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function court() {
		return $this->belongsTo( Court::class );
	}

}
