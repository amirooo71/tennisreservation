<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class CoachesController extends Controller {

	/**
	 * @return mixed
	 */
	public function getCoaches() {

		return User::where( [ 'is_coach' => true ] )->get();
	}

}
