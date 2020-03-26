<?php

namespace App\Http\Controllers\Admin;

use App\Booking;
use App\Club;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BookingsController extends Controller {

	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index() {

		$club = auth()->user()->club();

		$diffHours = Carbon::parse( $club->opening_time )->diffInHours( $club->closing_time );

		$startHour = Carbon::parse( $club->opening_time )->format( 'H:i' );

		$clubOpeningHours = [ $startHour ];

		for ( $i = 0; $i < $diffHours; $i ++ ) {

			$updatedTime = Carbon::parse( $startHour )->addHour()->format( 'H:i' );

			$clubOpeningHours[] = $updatedTime;

			$startHour = $updatedTime;

		}

		return view( 'admin.bookings.index', compact( 'club', 'clubOpeningHours' ) );
	}

	public function store() {

		$data = \request()->validate( [
			'court_id'    => 'required',
			'renter_name' => 'required',
			'date'        => 'required',
			'time'        => 'required',
		] );

		Booking::create( $data );

		return response()->json( [ 'msg' => 'زمین با موفقیت رزرو شد' ] );

	}
}
