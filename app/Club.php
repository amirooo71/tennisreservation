<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Club extends Model {

	protected $guarded = [];

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function courts() {
		return $this->hasMany( Court::class );
	}

	/**
	 * @param $data
	 */
	public function addCourt( $data ) {
		$this->courts()->create( $data );
	}

	/**
	 * @return array
	 */
	public function openingHours() {

		$diffHours = Carbon::parse( $this->opening_time )->diffInHours( $this->closing_time );

		$openHour = Carbon::parse( $this->opening_time )->format( 'H:i' );

		$openingHours = [ $openHour ];

		for ( $i = 0; $i < $diffHours; $i ++ ) {

			$nextHour = Carbon::parse( $openHour )->addHour()->format( 'H:i' );

			$openingHours[] = $nextHour;

			$openHour = $nextHour;

		}

		return $openingHours;
	}
}
