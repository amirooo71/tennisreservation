<?php

namespace App\Http\Controllers\Admin;

use App\Booking;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class CoachesController extends Controller {

	/**
	 * @return mixed
	 */
	public function getCoaches() {

		return User::where( [ 'is_coach' => true ] )->get();
	}

	/**
	 * @return mixed
	 */
	public function getBookings() {

		$bookings = Booking::where( [
			'owner_id' => \request( 'owner_id' ),
			'date'     => \request( 'date' ),
			'court_id' => \request( 'court_id' )
		] )->get();

		return $bookings;
	}

}
