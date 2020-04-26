<?php

namespace App\Http\Controllers\Admin;

use App\Creditor;
use App\Debtor;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FinancialController extends BaseController {

	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function creditors() {

		$creditors = Creditor::paginate( 30 );

		return view( 'admin.financial.creditors', compact( 'creditors' ) );
	}

	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function debtors() {

		$debtors = Debtor::paginate( 30 );

		return view( 'admin.financial.debtors', compact( 'debtors' ) );
	}
}
