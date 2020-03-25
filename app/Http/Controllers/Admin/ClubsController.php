<?php

namespace App\Http\Controllers\Admin;

use App\Club;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class ClubsController extends Controller {

	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index() {

		$club = auth()->user()->club();

		return view( 'admin.clubs.index', compact( 'club' ) );
	}

	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function create() {

		if ( auth()->user()->club() ) {

			flash( 'شما در حال حاضر یک کلاب تعریف شده دارید و امکان اضافه کردن کلاب جدید وجود ندارد.', 'info' );

			return redirect()->route( 'admin.clubs.index' );
		}

		return view( 'admin.clubs.create' );
	}

	/**
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function store() {

		if ( auth()->user()->club() ) {
			abort( 403 );
		}

		$data = $this->getValidateData();

		Club::create( $data );

		flash( 'کلاب با موفقیت تعریف شد و امکانات سیستم برای شما فعال شد.', 'success' );

		return redirect()->route( 'admin.clubs.index' );

	}

	/**
	 * @param Club $club
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function edit( Club $club ) {

		return view( 'admin.clubs.edit', compact( 'club' ) );

	}

	/**
	 * @param Club $club
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function update( Club $club ) {

		$data = $this->getValidateData();

		$club->update( $data );

		flash( 'اطلاعات کلاب با موفقیت ویرایش شد.', 'success' );

		return redirect()->route( 'admin.clubs.index' );

	}

	/**
	 * @param Club $club
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 * @throws \Exception
	 */
	public function delete( Club $club ) {

		$club->delete();

		flash( 'اطلاعات کلاب با موفقیت حدف شد.', 'success' );

		return redirect()->route( 'admin.clubs.index' );
	}

	/**
	 * @return array
	 */
	private function getValidateData(): array {
		$data = \request()->validate( [
			'name'         => 'required',
			'description'  => 'required',
			'courts_count' => 'required',
			'opening_time' => 'required',
			'closing_time' => 'required',
		] );

		$data['owner_id'] = auth()->id();

		return $data;
	}

}
