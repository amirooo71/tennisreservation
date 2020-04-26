<?php

namespace App\Http\Controllers\Admin;

use App\Booking;
use App\Coach;
use App\User;

class CoachesController extends BaseController {

	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index() {

		$coaches = Coach::paginate( 30 );

		return view( 'admin.coaches.index', compact( 'coaches' ) );
	}

	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function create() {

		return view( 'admin.coaches.create' );
	}

	/**
	 * @param Coach $coach
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function edit( Coach $coach ) {

		return view( 'admin.coaches.edit', compact( 'coach' ) );
	}

	/**
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function store() {

		$data = request()->validate( [
			'first_name' => 'required|',
			'last_name'  => 'required',
			'gender'     => 'required',
		] );

		Coach::create( $data );

		flash( 'اطلاعات مربی با موفقیت ذخیره شد.', 'success' );

		return redirect()->route( 'admin.coaches.index' );

	}

	/**
	 * @param Coach $coach
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function update( Coach $coach ) {

		$data = request()->validate( [
			'first_name' => 'required|',
			'last_name'  => 'required',
			'gender'     => 'required',
		] );

		$coach->update( $data );

		flash( 'اطلاعات مربی با موفقیت ویرایش شد.', 'success' );

		return redirect()->route( 'admin.coaches.index' );

	}

	/**
	 * @param Coach $coach
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 * @throws \Exception
	 */
	public function delete( Coach $coach ) {

		$coach->delete();

		flash( 'اطلاعات مربی با موفقیت حذف شد.', 'success' );

		return redirect()->route( 'admin.coaches.index' );
	}


	/**
	 * @return mixed
	 */
	public function getCoaches() {

		return User::where( [ 'is_coach' => true ] )->get();
	}

	/**
	 * @return mixed
	 */
	public function getBookings() {

		$bookings = Booking::where( [
			'owner_id' => \request( 'owner_id' ),
			'date'     => \request( 'date' ),
			'court_id' => \request( 'court_id' )
		] )->get();

		return $bookings;
	}

}
