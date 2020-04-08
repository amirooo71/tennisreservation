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

		$club = Club::first();

		$partTimeMinutes = unserialize( $club->part_time_minutes );

		return view( 'admin.clubs.index', compact( 'club', 'partTimeMinutes' ) );
	}

	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function create() {

		if ( Club::first() ) {

			flash( 'شما در حال حاضر یک کلاب تعریف شده دارید و امکان اضافه کردن کلاب جدید وجود ندارد.', 'info' );

			return redirect()->route( 'admin.clubs.index' );
		}

		return view( 'admin.clubs.create' );
	}

	/**
	 * @param Club $club
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function edit( Club $club ) {

		$partTimeMinutes = collect( unserialize( $club->part_time_minutes ) );

		return view( 'admin.clubs.edit', compact( 'club', 'partTimeMinutes' ) );

	}

	/**
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function store() {


		if ( Club::first() ) {
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
			'name'              => 'required|string|min:3',
			'courts_count'      => 'required|numeric|min:1|max:100',
			'opening_time'      => 'required',
			'closing_time'      => 'required',
			'cancellation_time' => 'required',
			'description'       => 'nullable',
			'part_time_minutes' => 'nullable',
		] );

		if ( \request( 'part_time_minutes' ) ) {
			$data['part_time_minutes'] = serialize( $data['part_time_minutes'] );
		} else {
			$data['part_time_minutes'] = null;
		}

		$data['owner_id'] = auth()->id();

		return $data;
	}

}
