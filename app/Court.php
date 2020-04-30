<?php

namespace App;

use Carbon\Carbon;
use Hekmatinasser\Verta\Verta;
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

	/**
	 * @return mixed
	 */
	public function todayBookedMinutes() {
		return $this->bookings()
		            ->where( 'date', '=', Verta::now()->format( 'Y-n-j' ) )
		            ->where( 'is_canceled', '=', false )->sum( 'duration' ) + $this->bookings()->partTimeBookedMinutes();
	}

	/**
	 * @return Model|null|object|static
	 */
	public function isPlaying() {

		$beginHour = Verta::now()->subMinutes( date( 'i' ) )->subSeconds( date( 's' ) );

		return $this->bookings()
		            ->where( 'date', '=', Verta::now()->format( 'Y-n-j' ) )
		            ->where( 'time', '=', $beginHour->formatTime() )
		            ->where( 'is_canceled', '=', false )
		            ->first();

	}


}
