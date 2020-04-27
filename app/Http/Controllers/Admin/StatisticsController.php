<?php

namespace App\Http\Controllers\Admin;

use App\Booking;
use App\Http\Controllers\Controller;
use App\Payment;
use Carbon\Carbon;
use Hekmatinasser\Verta\Verta;
use Illuminate\Http\Request;

class StatisticsController extends BaseController {

	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function revenue() {

		return view( 'admin.statistics.revenue' );
	}

	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function bookings() {

		return view( 'admin.statistics.bookings' );
	}

	/**
	 * @return array
	 */
	public function revenueWeekly() {

		$revenue = Payment::where( 'created_at', '>=', Verta::now()->startWeek() )->get()->groupBy( function ( $val ) {
			return Verta::parse( $val->created_at )->formatWord( 'l' );
		} )->map( function ( $month ) {
			return $month->sum( 'amount' );
		} );


		return [ 'labels' => $revenue->keys(), 'data' => $revenue->values() ];

	}

	/**
	 * @return array
	 */
	public function revenueMonthly() {

		$revenue = Payment::where( 'created_at', '>=', Verta::now()->startMonth() )->get()->groupBy( function ( $val ) {
			return Verta::parse( $val->created_at )->format( 'dS' );
		} )->map( function ( $month ) {
			return $month->sum( 'amount' );
		} );


		return [ 'labels' => $revenue->keys(), 'data' => $revenue->values() ];

	}

	/**
	 * @return array
	 */
	public function revenueAnnually() {

		$revenue = Payment::where( 'created_at', '>=', Verta::now()->startYear() )->get()->groupBy( function ( $val ) {
			return Verta::parse( $val->created_at )->format( 'F' );
		} )->map( function ( $month ) {
			return $month->sum( 'amount' );
		} );


		return [ 'labels' => $revenue->keys(), 'data' => $revenue->values() ];

	}

}
