<?php

namespace App;

use App\Traits\ShamsiTimestamps;
use Hekmatinasser\Verta\Verta;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model {

	use ShamsiTimestamps;

	protected $guarded = [];

	protected $with = [ 'partTime' ];

	protected $appends = [ 'is_full_paid' ];

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasOne
	 */
	public function partTime() {
		return $this->hasOne( PartTimeBooking::class )->where( [ 'is_canceled' => false ] );
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function court() {
		return $this->belongsTo( Court::class );
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasOne
	 */
	public function payment() {
		return $this->hasOne( Payment::class );
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function coach() {
		return $this->belongsTo( Coach::class );
	}

	/**
	 * @param $data
	 *
	 * @return Model
	 */
	public function addPartTime( $data ) {
		return $this->partTime()->create( $data );
	}

	/**
	 * @return bool
	 */
	public function getIsFullPaidAttribute() {
		return $this->is_paid && optional( $this->partTime )->is_paid;
	}

	/**
	 * @param $query
	 * @param bool $canceled
	 *
	 * @return mixed
	 */
	public function scopeToday( $query, $canceled = false ) {

		return $query->where( 'date', '=', Verta::now()->format( 'Y-n-j' ) )->where( 'is_canceled', '=', $canceled );

	}

	/**
	 * @param $query
	 *
	 * @return int
	 */
	public function scopePartTimeMinutes( $query ) {
		return (int) $query->get()->reduce( function ( $carry, $item ) {
			return $carry + ( $item->partTime ? $item->partTime->duration : 0 );
		} );
	}


}
