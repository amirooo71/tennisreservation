<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StatisticsController extends BaseController {

	public function revenue() {

		return view('admin.statistics.revenue');

	}

}
