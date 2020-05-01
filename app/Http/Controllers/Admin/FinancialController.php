<?php

namespace App\Http\Controllers\Admin;

use App\Coach;
use App\Creditor;
use App\Debtor;
use App\Http\Controllers\Controller;
use App\Payment;
use Illuminate\Http\Request;

class FinancialController extends BaseController {

	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function coachesDebt() {

		$coaches = Coach::all();

		return view( 'admin.financial.coaches_debt', compact( 'coaches' ) );
	}


	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function creditors() {

		$creditors = Creditor::where( [ 'is_refunded' => false ] )->paginate( 30 );

		return view( 'admin.financial.creditors', compact( 'creditors' ) );
	}

	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function debtors() {

		$debtors = Debtor::where( [ 'is_paid' => false ] )->paginate( 30 );

		return view( 'admin.financial.debtors', compact( 'debtors' ) );
	}

	public function payments() {

		$payments = Payment::paginate( 30 );

		return view( 'admin.financial.payments', compact( 'payments' ) );

	}

	/**
	 * @param Debtor $debtor
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function debtorPaid( Debtor $debtor ) {

		$data = \request()->validate( [ 'amount' => 'required|numeric' ] );

		$debtor->update( [ 'is_paid' => true, 'amount' => $data['amount'] ] );

		Payment::create( [
			'booking_id'           => optional( $debtor->booked )->id,
			'part_time_booking_id' => optional( $debtor->partTimeBooked )->id,
			'amount'               => $data['amount']
		] );

		flash( 'عملیات با موفقیت انجام شد', 'success' );

		return redirect()->route( 'admin.debtors.index' );

	}

	/**
	 * @param Creditor $creditor
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function refundCreditorMoney( Creditor $creditor ) {

		$creditor->update( [ 'is_refunded' => true ] );

		flash( 'عملیات با موفقیت انجام شد.', 'success' );

		return redirect()->route( 'admin.creditors.index' );

	}

	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function coachPayForm() {

		return view( 'admin.financial.coach_pay_form' );

	}

	public function storeCoachPay() {

	}

}
