<?php

namespace App\Http\Controllers\Admin;

use App\Club;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ClubsController extends Controller {

	public function index() {

		$club = auth()->user()->clubs->first();

		return view( 'admin.clubs.index', compact( 'club' ) );
	}

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
			'opening_time' => 'required',
			'closing_time' => 'required',
		] );

		$data['owner_id'] = auth()->id();

		$club = Club::create( $data );

		return redirect()->route( 'admin.courts.index', [ 'club' => $club ] );

	}
}
