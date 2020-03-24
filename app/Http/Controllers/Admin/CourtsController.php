<?php

namespace App\Http\Controllers\Admin;

use App\Club;
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


		$data = \request()->validate( [
			'name'  => 'required',
			'type'  => 'required',
			'price' => 'required',
		] );


		$data['is_indoor'] = \request()->has( 'is_indoor' );
		$data['is_center'] = \request()->has( 'is_center' );


		$club->addCourt( $data );

		return redirect()->route('admin.courts.index',['club' => $club]);

	}

}
