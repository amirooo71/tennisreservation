<?php

namespace App\Http\Controllers\Admin;

use App\Booking;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;

class GroupBookingsController extends Controller {

	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index() {
		return view( 'admin.group_bookings.index' );
	}

	public function store() {

		$this->validateData();

		$from = \request( 'from' );
		$to   = \request( 'to' );

		foreach ( $this->getBookingHours( $from, $to ) as $hour ) {

			Booking::create( [
				'court_id'   => \request( 'court_id' ),
				'renter_name' => \request( 'renter_name' ),
				'date'       => \request( 'date' ),
				'time'       => $hour,
				'duration'   => 60,
				'owner_id' => \request('owner_id')
			] );

		}

		return response()->json( [ 'msg' => 'was added successfully' ] );


	}

	private function getBookingHours( $from, $to ) {

		$diffHours = Carbon::parse( $from )->diffInHours( $to );

		$begin = Carbon::parse( $from )->format( 'H:i' );

		$bookingHours = [ $begin ];

		for ( $i = 0; $i < $diffHours; $i ++ ) {

			$nextHour = Carbon::parse( $begin )->addHour()->format( 'H:i' );

			$bookingHours[] = $nextHour;

			$begin = $nextHour;

		}

		return $bookingHours;
	}

	private function validateData(): void {
		\request()->validate( [
			'court_id'     => 'required',
			'renter_name'  => 'required',
			'date'         => 'required',
			'to'           => 'required',
			'from'         => 'required',
			'owner_id'     => 'nullable',
		] );
	}

}
