<?php

namespace App\Http\Controllers\Admin;

use App\Booking;
use App\Http\Controllers\Controller;
use App\PartTimeBooking;
use Illuminate\Http\Request;

class PartTimeBookingsController extends Controller {
	public function store( Booking $booking ) {

		$data = request()->validate( [
			'renter_name'  => 'required',
			'remain_time'         => 'required',
			'owner_id'     => 'nullable',
			'partner_name' => 'nullable',
		] );

		$data['booking_id'] = $booking->id;

		$book = PartTimeBooking::create( $data );

		return response()->json( [ 'msg' => 'part time was added', 'book' => $book ] );

	}
}
