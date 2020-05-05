<?php

namespace App\Http\Controllers\Admin;

use App\Booking;
use App\Court;
use Carbon\Carbon;
use Hekmatinasser\Verta\Verta;

class WeekBookingsController extends BaseController {

	private $pastHours = 0;

	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index() {
		return view( 'admin.week_bookings.index' );
	}

	/**
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function store() {

		$this->validateData();

		if ( $this->getBookingsCourt() ) {
			return response()->json( [ 'msg' => 'Has booking' ], 422 );
		}

		$from = \request( 'from' );
		$to   = \request( 'to' );

		foreach ( $this->getBookingHours( $from, $to ) as $hour ) {

			if ( ! $this->isDatePast( $hour ) ) {

				Booking::create( [
					'court_id'    => \request( 'court_id' ),
					'renter_name' => \request( 'renter_name' ),
					'date'        => \request( 'date' ),
					'time'        => $hour,
					'duration'    => 60,
					'coach_id'    => \request( 'coach_id' ),
					'amount'      => Court::find( request( 'court_id' ) )->price,
				] );

			} else {
				$this->pastHours ++;

				return response()->json( [ 'msg' => 'تاریخ گذشته است' ], 422 );
			}

		}

		return response()->json( [ 'msg' => 'was added successfully' . ' Past ' . $this->pastHours ] );


	}

	/**
	 * @param $from
	 * @param $to
	 *
	 * @return array
	 */
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
			'court_id'    => 'required',
			'renter_name' => 'required',
			'date'        => 'required',
			'to'          => 'required',
			'from'        => 'required',
			'owner_id'    => 'nullable',
		] );
	}

	private function getBookingsCourt() {
		return Booking::where(
			[
				'court_id'    => request( 'court_id' ),
				'date'        => request( 'date' ),
				'is_canceled' => false
			] )->get()->count();
	}

	private function isDatePast( $time ): bool {

		$currentFormatDate = Verta::now()->format( 'Y-n-j' );

		return Verta::parse( $currentFormatDate )->gt( Verta::parse( request( 'date' ) ) ) ||
		       Verta::parse( request( 'date' ) . ' ' . $time )->lt( Verta::now() );


	}

}
