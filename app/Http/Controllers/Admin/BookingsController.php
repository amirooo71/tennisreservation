<?php

namespace App\Http\Controllers\Admin;

use App\Booking;
use App\Club;
use App\Court;
use App\Creditor;
use App\Debtor;
use App\Payment;
use Hekmatinasser\Verta\Verta;

class BookingsController extends BaseController {

	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index() {

		if ( request()->query( 'date' ) ) {
			$date = request()->query( 'date' );
		} else {
			$date = Verta::now()->format( 'Y-n-j' );
		}

		$club = Club::first();

		$courts = $this->getAllCourtBookingsByDate( $date );

		$openingHours = $club->openingHours();

		return view( 'admin.bookings.index', compact( 'openingHours', 'courts', 'date' ) );
	}

	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function canceled() {

		$canceled = Booking::where( 'is_canceled', '=', true )->paginate( 30 );

		return view( 'admin.bookings.canceled', compact( 'canceled' ) );

	}

	/**
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function store() {

		$data = $this->getValidateData();

		if ( $this->isAlreadyBooked() ) {
			return response()->json( [ 'msg' => 'این زمین رزرو شده است' ], 422 );
		}

		if ( $this->isDatePast() ) {
			return response()->json( [ 'msg' => 'تاریخ رزرو گذشته است' ], 422 );
		}

		$book = Booking::create( $data );

		return response()->json( [ 'msg' => 'زمین با موفقیت رزرو شد', 'book' => $book ] );

	}

	/**
	 * @param Booking $booking
	 *
	 * @return \Illuminate\Http\JsonResponse
	 * @throws \Exception
	 */
	public function delete( Booking $booking ) {

		if ( $booking->partTime ) {

			$booked = $this->bookingWithPartTime( $booking );

			$booking->delete();

			return response()->json( [ 'msg' => 'رزرو با موفقیت حذف شد', 'booked' => $booked ] );

		}

		$booking->delete();

		return response()->json( [ 'msg' => 'رزرو با موفقیت حذف شد', 'booked' => null ] );

	}

	/**
	 * @param Booking $booking
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function cancel( Booking $booking ) {

		if ( $booking->is_canceled ) {
			return response()->json( [ 'msg' => 'کنسل شده است' ], 422 );
		}

		if ( request()->has( 'chargeDebtor' ) ) {
			Debtor::create( [
				'booking_id' => $booking->id,
				'name'       => $booking->renter_name,
				'amount'     => $this->calculateAmountByDurationTime( $booking ),
			] );
		}

		if ( request()->has( 'chargeCreditor' ) ) {
			Creditor::create( [
				'booking_id' => $booking->id,
				'name'       => $booking->renter_name,
				'amount'     => $this->calculateAmountByDurationTime( $booking ),
			] );
		}

		if ( $booking->partTime ) {

			$booking->update( [ 'is_canceled' => true ] );

			$booked = $this->bookingWithPartTime( $booking );

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
	public function pay( Booking $booking ) {

		request()->validate( [
			'price' => 'required:numeric'
		] );

		if ( $booking->is_paid ) {
			return response()->json( [ 'msg' => 'پرداخت شده است' ], 422 );
		}

		Payment::create( [
			'booking_id' => $booking->id,
			'amount'     => request( 'price' ),
		] );

		$booking->update( [ 'is_paid' => true ] );

		return response()->json( [ 'msg' => 'هزینه با موفقیت دریافت شد', 'booked' => $booking ] );
	}

	/**
	 * @return mixed
	 */
	public function getHours() {

		$club = auth()->user()->club();

		$data = $this->getOpeningHours( $club );

		return $data;
	}

	/**
	 * @param Booking $booking
	 *
	 * @return array
	 */
	public function isValidTimeForCanceling( Booking $booking ) {

		$cancellationTime = Club::first()->cancellation_time;

		$validTime = Verta::parse( $booking->date . ' ' . $booking->time )->subHours( $cancellationTime );

		$now = Verta::now();

		return [ 'isValidTime' => $now->lt( $validTime ) ? 1 : 0 ];

	}

	/**
	 * @return mixed
	 */
	public function getCourtBookings() {

		return Booking::where(
			[
				'court_id'    => request( 'courtId' ),
				'date'        => request( 'date' ),
				'is_canceled' => false
			] )->get();
	}


	/**
	 * @return array
	 */
	private function getValidateData(): array {

		$data = \request()->validate( [
			'court_id'     => 'required',
			'renter_name'  => 'required',
			'date'         => 'required',
			'time'         => 'required',
			'is_part_time' => 'required',
			'duration'     => 'required',
			'coach_id'     => 'nullable',
			'start_time'   => 'nullable',
			'end_time'     => 'nullable',
			'partner_name' => 'nullable',
		] );

		return $data;
	}

	/**
	 * @param Booking $booking
	 *
	 * @return mixed
	 */
	private function bookingWithPartTime( Booking $booking ) {

		$booked = Booking::create( [
			'court_id'     => $booking->court->id,
			'renter_name'  => $booking->partTime->renter_name,
			'date'         => $booking->date,
			'time'         => $booking->partTime->start_at,
			'is_part_time' => true,
			'start_time'   => $booking->end_time ? $booking->end_time : null,
			'end_time'     => $booking->start_time ? $booking->start_time : null,
			'coach_id'     => $booking->partTime->coach_id,
			'partner_name' => $booking->partner_name,
			'is_paid'      => $booking->is_paid,
			'duration'     => $booking->partTime->duration,
		] );

		return $booked;
	}

	/**
	 * @return mixed
	 */
	private function isAlreadyBooked() {
		return Booking::where( [
			'date'        => request( 'date' ),
			'time'        => request( 'time' ),
			'court_id'    => request( 'court_id' ),
			'is_canceled' => false,
		] )->first();
	}

	/**
	 * @param $date
	 *
	 * @return mixed
	 */
	private function getAllCourtBookingsByDate( $date ) {

		$courts = Court::with( [
			'bookings' => function ( $query ) use ( $date ) {
				$query->where( [ 'date' => $date, 'is_canceled' => false ] );
			}
		] )->get();

		return $courts;
	}


	/**
	 * @param Booking $booking
	 *
	 * @return float|int
	 */
	private function calculateAmountByDurationTime( Booking $booking ) {

		if ( $booking->is_paid ) {
			return $booking->payment->amount;
		}

		$multipy = [
			15 => 1,
			30 => 2,
			45 => 3,
			60 => 4,
		];

		$price = ( $booking->court->price * $multipy[ $booking->duration ] ) / 4;

		return $price;
	}

	/**
	 * @return bool
	 */
	private function isDatePast(): bool {

		$currentFormatDate = Verta::now()->format( 'Y-n-j' );

		return Verta::parse( $currentFormatDate )->gt( Verta::parse( request( 'date' ) ) ) ||
		       Verta::parse( request( 'date' ) . ' ' . request( 'time' ) )->lt( Verta::now()->subMinutes( date( 'i' ) )->subSeconds( date( 's' ) ) );


	}


}
