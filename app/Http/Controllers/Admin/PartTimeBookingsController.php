<?php

namespace App\Http\Controllers\Admin;

use App\Booking;
use App\PartTimeBooking;
use App\Payment;

class PartTimeBookingsController extends BaseController {

	/**
	 * @param Booking $booking
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function store( Booking $booking ) {

		$data = $this->getValidateData( $booking );

		if ( $this->isDatePast() ) {
			return response()->json( [ 'msg' => 'تاریخ رزرو گذشته است' ], 422 );
		}

		$forceBook = $booking->addPartTime( $data );

		$book = PartTimeBooking::where( [ 'id' => $forceBook->id ] )->first();

		return response()->json( [ 'msg' => 'part time was added', 'book' => $book ] );

	}

	/**
	 * @param PartTimeBooking $partTimeBooking
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function pay( PartTimeBooking $partTimeBooking ) {


		request()->validate( [
			'price' => 'required:numeric'
		] );

		Payment::create( [
			'part_time_booking_id' => $partTimeBooking->id,
			'amount'               => request( 'price' )
		] );

		$partTimeBooking->update( [ 'is_paid' => true ] );

		return response()->json( [ 'msg' => 'هزینه با موفقیت دریافت شد', 'partTimeBooked' => $partTimeBooking ] );

	}

	/**
	 * @param PartTimeBooking $partTimeBooking
	 *
	 * @return \Illuminate\Http\JsonResponse
	 * @throws \Exception
	 */
	public function cancel( PartTimeBooking $partTimeBooking ) {

		$partTimeBooking->update( [ 'is_canceled' => true ] );

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
