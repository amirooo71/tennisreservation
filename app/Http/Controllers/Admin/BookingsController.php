<?php

namespace App\Http\Controllers\Admin;

use App\Booking;
use App\Club;
use App\Court;
use App\Http\Controllers\Controller;
use App\PartTimeBooking;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BookingsController extends Controller {

	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index() {

		$club = auth()->user()->club();

		$clubOpeningHours = $this->getOpeningHours( $club );

		return view( 'admin.bookings.index', compact( 'club', 'clubOpeningHours' ) );
	}

	/**
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function store() {

		$data = \request()->validate( [
			'court_id'     => 'required',
			'renter_name'  => 'required',
			'date'         => 'required',
			'time'         => 'required',
			'is_part_time' => 'required',
			'owner_id'     => 'nullable',
			'start_time'   => 'nullable',
			'end_time'     => 'nullable',
			'partner_name' => 'nullable',
		] );

		$book = Booking::create( $data );

		return response()->json( [ 'msg' => 'زمین با موفقیت رزرو شد', 'book' => $book ] );

	}

	/**
	 * @param Booking $booking
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function cancel( Booking $booking ) {

		if ( ! $booking ) {
			return response()->json( 'Not found' );
		}

		if ( $booking->partTime ) {

			$booking->update( [ 'is_canceled' => true ] );

			$booked = Booking::create( [
				'court_id'     => $booking->court->id,
				'renter_name'  => $booking->partTime->renter_name,
				'date'         => $booking->date,
				'time'         => $booking->partTime->remain_time,
				'is_part_time' => true,
				'start_time'   => $booking->end_time ? $booking->end_time : null,
				'end_time'     => $booking->start_time ? $booking->start_time : null,
				'owner_id'     => $booking->partTime->owner_id,
				'partner_name' => $booking->partner_name,
				'is_paid'      => $booking->is_paid,
			] );

			$booking->partTime->delete();

			return response()->json( [ 'msg' => 'رزرو با موفقیت کنسل شد', 'booked' => $booked ] );

		}

		$booking->update( [ 'is_canceled' => true ] );

		return response()->json( [ 'msg' => 'رزرو با موفقیت کنسل شد', 'booked' => null ] );

	}

	/**
	 * @param Booking $booking
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function paid( Booking $booking ) {

		if ( ! $booking ) {
			return response()->json( 'Not found' );
		}

		$booking->update( [ 'is_paid' => true ] );

		return response()->json( [ 'msg' => 'هزینه با موفقیت دریافت شد', 'booked' => $booking ] );
	}

	/**
	 * @param $club
	 *
	 * @return array
	 */
	private function getOpeningHours( $club ): array {

		$diffHours = Carbon::parse( $club->opening_time )->diffInHours( $club->closing_time );

		$startHour = Carbon::parse( $club->opening_time )->format( 'H:i' );

		$clubOpeningHours = [ $startHour ];

		for ( $i = 0; $i < $diffHours; $i ++ ) {

			$updatedTime = Carbon::parse( $startHour )->addHour()->format( 'H:i' );

			$clubOpeningHours[] = $updatedTime;

			$startHour = $updatedTime;

		}

		return $clubOpeningHours;
	}

	public function getHours() {

		$club = auth()->user()->club();

		$data = $this->getOpeningHours( $club );

		return $data;
	}

}
