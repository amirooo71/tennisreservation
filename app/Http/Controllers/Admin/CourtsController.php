<?php

namespace App\Http\Controllers\Admin;

use App\Club;
use App\Court;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CourtsController extends Controller {

	/**
	 * @param Club $club
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index( Club $club ) {

		return view( 'admin.courts.index', compact( 'club' ) );
	}


	/**
	 * @param Club $club
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function create( Club $club ) {

		return view( 'admin.courts.create', compact( 'club' ) );
	}

	/**
	 * @param Club $club
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function store( Club $club ) {

		$data = $this->getValidateData();

		$club->addCourt( $data );

		flash('اطلاعات زمین تنیس با موفقیت ذخیره شد.','success');

		return redirect()->route( 'admin.courts.index', [ 'club' => $club ] );

	}

	/**
	 * @param Club $club
	 * @param Court $court
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function edit( Club $club, Court $court ) {

		return view( 'admin.courts.edit', compact( 'club', 'court' ) );
	}

	/**
	 * @param Club $club
	 * @param Court $court
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function update( Club $club, Court $court ) {

		$data = $this->getValidateDataOnUpdate($court);

		$court->update( $data );

		flash('اطلاعات زمین تنیس با موفقیت ویرایش شد.','success');

		return redirect()->route( 'admin.courts.index', compact( 'club' ) );
	}

	/**
	 * @param Club $club
	 * @param Court $court
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 * @throws \Exception
	 */
	public function delete( Club $club, Court $court ) {

		$court->delete();

		flash('زمین تنیس با موفقیت حذف شد.','success');

		return redirect()->route( 'admin.courts.index', compact( 'club' ) );
	}

	/**
	 * @return array
	 */
	private function getValidateData(): array {
		$data = \request()->validate( [
			'name'  => 'required|unique:courts,name',
			'type'  => 'required',
			'price' => 'required|numeric',
		] );


		$data['is_indoor'] = \request()->has( 'is_indoor' );
		$data['is_center'] = \request()->has( 'is_center' );

		return $data;
	}

	/**
	 * @param $court
	 *
	 * @return array
	 */
	private function getValidateDataOnUpdate($court): array {
		$data = \request()->validate( [
			'name'  => 'required|unique:courts,name,' . $court->id,
			'type'  => 'required',
			'price' => 'required|numeric',
		] );


		$data['is_indoor'] = \request()->has( 'is_indoor' );
		$data['is_center'] = \request()->has( 'is_center' );

		return $data;
	}

}
