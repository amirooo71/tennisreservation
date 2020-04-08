<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Court extends Model {
	protected $guarded = [];



	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function club() {
		return $this->belongsTo( Club::class );
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function bookings() {
		return $this->hasMany( Booking::class );
	}


}
