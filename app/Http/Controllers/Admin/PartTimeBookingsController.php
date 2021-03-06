<?php

namespace App\Http\Controllers\Admin;

use App\Booking;
use App\Club;
use App\Creditor;
use App\Debtor;
use App\PartTimeBooking;
use Hekmatinasser\Verta\Verta;

class PartTimeBookingsController extends BaseController {

	/**
	 * @param Booking $booking
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function store( Booking $booking ) {

		$data = $this->getValidateData( $booking );

		if ( $booking->partTime ) {
			return response()->json( [ 'msg' => 'زمین رزرو شده است' ], 422 );
		}

		if ( $this->isDatePast( $booking ) ) {
			return response()->json( [ 'msg' => 'تاریخ رزرو گذشته است' ], 422 );
		}

		$freshBook = $booking->addPartTime( $data );

		$book = PartTimeBooking::where( [ 'id' => $freshBook->id ] )->first();

		return response()->json( [ 'msg' => 'رزرو با موفقیت انجام شد', 'book' => $book ] );

	}

	/**
	 * @param PartTimeBooking $partTimeBooking
	 *
	 * @return \Illuminate\Http\JsonResponse
	 * @throws \Exception
	 */
	public function delete( PartTimeBooking $partTimeBooking ) {

		$partTimeBooking->delete();

		return response()->json( [ 'msg' => 'رزرو با موفقیت حذف شد', 'partTimeBooked' => null ] );
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


		if ( $partTimeBooking->is_paid ) {
			return response()->json( [ 'msg' => 'پرداخت شده است' ], 422 );
		}

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


		if ( $partTimeBooking->is_canceled ) {
			return response()->json( [ 'msg' => 'کنسل شده است' ] );
		}


		if ( request()->has( 'chargeDebtor' ) ) {
			Debtor::create( [
				'part_time_booking_id' => $partTimeBooking->id,
				'coach_id'             => $partTimeBooking->coach_id,
				'name'                 => $partTimeBooking->renter_name,
				'amount'               => $this->calculateAmountByDurationTime( $partTimeBooking ),
			] );
		}

		if ( request()->has( 'chargeCreditor' ) ) {
			Creditor::create( [
				'booking_id' => $partTimeBooking->id,
				'coach_id'   => $partTimeBooking->coach_id,
				'name'       => $partTimeBooking->renter_name,
				'amount'     => $this->calculateAmountByDurationTime( $partTimeBooking ),
			] );
		}

		$partTimeBooking->update( [ 'is_canceled' => true ] );

		return response()->json( [ 'msg' => 'با موفقیت کنسل شد', 'partTimeBooked' => null ] );
	}

	/**
	 * @param PartTimeBooking $partTimeBooking
	 *
	 * @return array
	 */
	public function isValidTimeForPartTimeCanceling( PartTimeBooking $partTimeBooking ) {

		$cancellationTime = Club::first()->cancellation_time;

		$booking = $partTimeBooking->booking;

		$validTime = Verta::parse( $booking->date . ' ' . $booking->time )->subHours( $cancellationTime );

		$now = Verta::now();

		return [ 'isValidTime' => $now->lt( $validTime ) ? 1 : 0 ];

	}

	/**
	 * @param Booking $booking
	 *
	 * @return array
	 */
	private function getValidateData( Booking $booking ): array {

		$data = request()->validate( [
			'renter_name'  => 'required',
			'start_at'     => 'required',
			'coach_id'     => 'nullable',
			'partner_name' => 'nullable',
		] );

		$data['booking_id'] = $booking->id;
		$data['duration']   = $this->calculateDuration( $booking );
		$data['amount']     = ( $this->calculateDuration( $booking ) / 60 ) * $booking->court->price;

		return $data;
	}

	/**
	 * @param Booking $booking
	 *
	 * @return mixed|null
	 */
	private function calculateDuration( Booking $booking ) {

		$duration = null;

		if ( $booking->is_part_time ) {

			if ( $booking->start_time ) {

				$time     = explode( ':', $booking->start_time );
				$duration = $time[1];

			} else {

				$time      = explode( ':', $booking->end_time );
				$durations = [
					15 => 45,
					30 => 30,
					45 => 15,
				];
				$duration  = $durations[ $time[1] ];
			}
		}

		return $duration;
	}

	/**
	 * @param PartTimeBooking $partTimeBooking
	 *
	 * @return float|int
	 */
	private function calculateAmountByDurationTime( PartTimeBooking $partTimeBooking ) {
		$multipy = [
			15 => 1,
			30 => 2,
			45 => 3,
			60 => 4,
		];

		$price = ( $partTimeBooking->booking->court->price * $multipy[ $partTimeBooking->duration ] ) / 4;

		return $price;
	}


	protected function isDatePast( Booking $booking ): bool {

		$currentFormatDate = Verta::now()->format( 'Y-n-j' );

		return Verta::parse( $currentFormatDate )->gt( Verta::parse( request( 'date' ) ) ) ||
		       Verta::parse( $booking->date . ' ' . $booking->time )->lt( Verta::now()->subMinutes( date( 'i' ) )->subSeconds( date( 's' ) ) );


	}

}
