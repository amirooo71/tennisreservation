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

		$bookings = Booking::where( 'date', '=', Verta::now()->format( 'Y-n-j' ) )->where( 'is_canceled', '=', false )->sum( 'duration' );

		$canceled = Booking::where( 'date', '=', Verta::now()->format( 'Y-n-j' ) )->where( 'is_canceled', '=', true )->sum( 'duration' );

		$paids = Payment::where( 'created_at', '>=', Carbon::now() )->sum( 'amount' );

		$bookingCount  = Booking::where( 'date', '=', Verta::now()->format( 'Y-n-j' ) )->where( 'is_canceled', '=', false )->count();
		$canceledCount = Booking::where( 'date', '=', Verta::now()->format( 'Y-n-j' ) )->where( 'is_canceled', '=', true )->count();

		if ( $courts->count() ) {

			$bookingPercent = $bookingCount * 100 / ( Club::first()->opening_hours * $courts->count() );

			$canceledPercent = $canceledCount * 100 / ( Club::first()->opening_hours * $courts->count() );

			$paidPercent = $paids * 100 / ( $courts->sum( 'price' ) * $courts->count() );

		} else {

			$bookingPercent = 0;

			$canceledPercent = 0;

			$paidPercent = 0;
		}


//		return Booking::whereHas( 'coach', function ( Builder $query ) {
//			return $query->where( 'date', '=', Verta::now()->format( 'Y-n-j' ) );
//		} )->get();


		return view( 'admin.dashboard.index', compact( 'courts', 'bookings', 'canceled', 'paids', 'bookingPercent', 'canceledPercent', 'paidPercent' ) );

	}
}
