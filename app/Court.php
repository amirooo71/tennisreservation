<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Court extends Model {
	protected $guarded = [];

	protected $appends = ['bookingDates'];

	private $date = null;

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

	/**
	 * @return \Illuminate\Database\Eloquent\Collection
	 */
	public function getBookingDatesAttribute( ) {

		return $this->bookings()->where( [ 'date' => $this->getBookingDate(),'is_canceled' => false ] )->get();
	}

	/**
	 * @param $date
	 */
	public function setBookingDate( $date ) {

		$this->date = $date;
	}

	/**
	 * @return null
	 */
	public function getBookingDate() {
		return $this->date ?? Carbon::now()->toDateString();
	}

}
