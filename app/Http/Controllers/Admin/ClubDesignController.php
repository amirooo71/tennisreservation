<?php

namespace App\Http\Controllers\Admin;

use App\Club;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ClubDesignController extends Controller {

	/**
	 * @param Club $club
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index( Club $club ) {

		return view( 'admin.clubDesign.index', compact( 'club' ) );
	}
}
