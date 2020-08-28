<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coach extends Model {
	protected $guarded = [];

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function bookings() {
		return $this->hasMany( Booking::class );
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function partTimeBookings() {
		return $this->hasMany( PartTimeBooking::class );
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasOne
	 */
	public function balance() {
		return $this->hasOne( CoachBalance::class );
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function debt() {
		return $this->hasMany( Debtor::class );
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function credit() {
		return $this->hasMany( Creditor::class );
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function payments() {

		return $this->hasMany( Payment::class );
	}

	/**
	 * @return mixed
	 */
	public function calculateCoachDebt() {

		$bookings = $this->bookings()->where( 'is_canceled', '=', false )->where( 'is_paid', '=', false );

		$partTimeAmount = $bookings->get()->reduce( function ( $carry, $item ) {
			return $carry + ( $item->partTime ? $item->partTime->amount : 0 );
		} );

		$debt = $this->debt->where( 'is_paid', '=', false )->sum( 'amount' );

		$credit = $this->credit->where( 'is_refunded', '=', false )->sum( 'amount' );

		return ( $bookings->sum( 'amount' ) + $partTimeAmount + $debt ) - ( $credit + optional($this->balance)->amount );
	}

    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

}
