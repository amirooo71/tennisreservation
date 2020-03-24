<?php

namespace App\Http\Controllers\Admin;

use App\Club;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ClubsController extends Controller {

	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function create() {
		return view( 'admin.clubs.create' );
	}

	/**
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function store() {

		$data = \request()->validate( [
			'name'         => 'required',
			'description'  => 'required',
			'courts_count' => 'required',
		] );

		$club = Club::create( $data );

		return redirect()->route( 'admin.courts.index', [ 'club' => $club ] );

	}
}
