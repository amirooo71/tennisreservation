<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model {

	protected $guarded = [];

	protected $with = [ 'partTime' ];

	protected $appends = [ 'is_full_paid' ];

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

	public function addPartTime( $data ) {
		return $this->partTime()->create( $data );
	}

	public function getIsFullPaidAttribute() {
		return $this->is_paid && optional( $this->partTime )->is_paid;
	}

}
