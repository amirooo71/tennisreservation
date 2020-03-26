<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Court extends Model {
	protected $guarded = [];

	protected $appends = ['bookingsDate'];

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
	public function getBookingsDateAttribute( ) {

		return $this->bookings()->where( [ 'date' => $this->getBookingsDate() ] )->get();
	}

	/**
	 * @param $date
	 */
	public function setBookingsDate( $date ) {

		$this->date = $date;
	}

	/**
	 * @return null
	 */
	public function getBookingsDate() {
		return $this->date ?? Carbon::now()->toDateString();
	}

}
