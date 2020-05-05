<?php

namespace App\Http\Controllers\Admin;

use App\Club;
use App\FixBooking;
use App\Http\Controllers\Controller;
use Hekmatinasser\Verta\Verta;
use Illuminate\Http\Request;

class FixBookingsController extends Controller {

	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index() {

		$fixBookings = FixBooking::paginate( 30 );

		return view( 'admin.fix_bookings.index', compact( 'fixBookings' ) );
	}

	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function create() {

		$openingHours = Club::first()->openingHours();

		return view( 'admin.fix_bookings.create', compact( 'openingHours' ) );
	}

	/**
	 * @param FixBooking $fixBooking
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function edit( FixBooking $fixBooking ) {

		$openingHours = Club::first()->openingHours();

		return view( 'admin.fix_bookings.edit', compact( 'fixBooking', 'openingHours' ) );
	}

	/**
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function store() {

		$data = $this->getValidateDate();

		FixBooking::create( $data );

		flash( 'رزرو با موفقیت ثبت شد', 'success' );

		return redirect()->route( 'admin.fix_bookings.index' );
	}

	/**
	 * @param FixBooking $fixBooking
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function update( FixBooking $fixBooking ) {

		$data = $this->getValidateDate();

		$fixBooking->update( $data );

		flash( 'رزرو با موفقیت ویرایش شد', 'success' );

		return redirect()->route( 'admin.fix_bookings.index' );

	}

	/**
	 * @param FixBooking $fixBooking
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 * @throws \Exception
	 */
	public function delete( FixBooking $fixBooking ) {

		$fixBooking->delete();

		flash( 'رزرو با موفقیت حذف شد', 'success' );

		return redirect()->route( 'admin.fix_bookings.index' );

	}

	/**
	 * @return array
	 */
	private function getValidateDate(): array {
		$data = \request()->validate( [
			'renter_name'  => 'required',
			'day'          => 'required',
			'time'         => 'required',
			'partner_name' => 'nullable',
		] );

		return $data;
	}
}
