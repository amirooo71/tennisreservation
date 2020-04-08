<?php

namespace App\Http\Controllers\Admin;

use App\Booking;
use App\Http\Controllers\Controller;
use App\PartTimeBooking;
use Illuminate\Http\Request;

class PartTimeBookingsController extends Controller {

	/**
	 * @param Booking $booking
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function store( Booking $booking ) {

		$data = $this->getValidateData( $booking );

		$forceBook = $booking->addPartTime( $data );

		$book = PartTimeBooking::where( [ 'id' => $forceBook->id ] )->first();

		return response()->json( [ 'msg' => 'part time was added', 'book' => $book ] );

	}

	public function pay( PartTimeBooking $partTimeBooking ) {

		$partTimeBooking->update( [ 'is_paid' => true ] );

		return response()->json( [ 'msg' => 'هزینه با موفقیت دریافت شد', 'partTimeBooked' => $partTimeBooking ] );

	}

	public function cancel( PartTimeBooking $partTimeBooking ) {

		$partTimeBooking->delete();

		return response()->json( [ 'msg' => 'هزینه با موفقیت دریافت شد', 'partTimeBooked' => null ] );
	}

	/**
	 * @param Booking $booking
	 *
	 * @return array
	 */
	private function getValidateData( Booking $booking ): array {

		$data = request()->validate( [
			'renter_name'  => 'required',
			'remain_time'  => 'required',
			'owner_id'     => 'nullable',
			'partner_name' => 'nullable',
		] );

		$data['booking_id'] = $booking->id;

		return $data;
	}
}
