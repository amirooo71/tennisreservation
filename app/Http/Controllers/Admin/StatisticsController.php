<?php

namespace App\Http\Controllers\Admin;

use App\Booking;
use App\Http\Controllers\Controller;
use App\Payment;
use Carbon\Carbon;
use Hekmatinasser\Verta\Verta;
use Illuminate\Http\Request;

class StatisticsController extends BaseController {


	public function revenue() {

		return view( 'admin.statistics.revenue' );
	}

	public function revenueWeekly() {

		$revenue = Payment::where( 'created_at', '>=', Carbon::now()->startOfWeek() )->get()->groupBy( function ( $val ) {
			return Verta::parse( $val->created_at )->formatWord( 'l' );
		} )->map( function ( $month ) {
			return $month->sum( 'amount' );
		} );


		return [ 'labels' => $revenue->keys(), 'data' => $revenue->values() ];

	}


	public function revenueMonthly() {

		$revenue = Payment::where( 'created_at', '>=', Carbon::now()->startOfMonth() )->get()->groupBy( function ( $val ) {
			return Verta::parse( $val->created_at )->format( 'dS' );
		} )->map( function ( $month ) {
			return $month->sum( 'amount' );
		} );


		return [ 'labels' => $revenue->keys(), 'data' => $revenue->values() ];

	}

	public function revenueAnnually() {

		$revenue = Payment::where( 'created_at', '>=', Carbon::now()->startOfYear() )->get()->groupBy( function ( $val ) {
			return Verta::parse( $val->created_at )->format( 'F' );
		} )->map( function ( $month ) {
			return $month->sum( 'amount' );
		} );


		return [ 'labels' => $revenue->keys(), 'data' => $revenue->values() ];

	}

}
