<?php

namespace App\Http\Controllers\Admin;

use App\Booking;
use App\Club;
use App\Court;
use App\Http\Controllers\Controller;
use App\Payment;
use Carbon\Carbon;
use Hekmatinasser\Verta\Verta;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class DashboardController extends BaseController {

	public function index() {

		if ( ! Club::first() ) {

			return redirect()->route( 'admin.clubs.index' );

		}

		$courts = Court::all();

		$bookings = Booking::today();

		$canceled = Booking::today( true );

		$bookingMinutes = $bookings->sum( 'duration' ) + $bookings->partTimeMinutes();

		$canceledMinutes = $canceled->sum( 'duration' ) + $canceled->partTimeMinutes();

		$paids = Payment::where( 'created_at', '>=', Carbon::today() )->sum( 'amount' );

		if ( $courts->count() ) {

			$bookingPercent = $this->calculatePercentage( $bookings, $courts );

			$canceledPercent = $this->calculatePercentage( $canceled, $courts );

			$paidPercent = $this->calculatePaidPercentage( $paids, $courts );

		}

		return view( 'admin.dashboard.index', compact( 'courts','paids', 'bookingPercent', 'canceledPercent', 'paidPercent', 'bookingMinutes', 'canceledMinutes' ) );

	}

	/**
	 * @param $query
	 * @param $courts
	 *
	 * @return float|int
	 */
	private function calculatePercentage( $query, $courts ) {
		return round( $query->count() * 100 / ( Club::first()->opening_hours * $courts->count() ) );
	}

	/**
	 * @param $paids
	 * @param $courts
	 *
	 * @return float|int
	 */
	private function calculatePaidPercentage( $paids, $courts ) {
		return round( $paids * 100 / ( $courts->sum( 'price' ) * $courts->count() ) );
	}
}
