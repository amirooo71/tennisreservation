<?php

namespace App\Http\Controllers\Admin;

use App\Coach;
use App\CoachBalance;
use App\Creditor;
use App\Debtor;
use App\Http\Controllers\Controller;
use App\Payment;
use Illuminate\Http\Request;

class FinancialController extends BaseController
{

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function coachesDebtList()
    {

        $coaches = Coach::paginate(30);

        return view('admin.financial.coaches_debt_list', compact('coaches'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function creditors()
    {

        $creditors = Creditor::where(['is_refunded' => false])->whereDoesntHave('coach')->paginate(30);

        return view('admin.financial.creditors', compact('creditors'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function debtors()
    {

        $debtors = Debtor::where(['is_paid' => false])->whereDoesntHave('coach')->paginate(30);

        return view('admin.financial.debtors', compact('debtors'));
    }

    public function payments()
    {

        $payments = Payment::paginate(30);

        return view('admin.financial.payments', compact('payments'));

    }

    /**
     * @param Debtor $debtor
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function debtorPaid(Debtor $debtor)
    {

        $data = \request()->validate(['amount' => 'required|numeric']);

        $debtor->update(['is_paid' => true, 'amount' => $data['amount']]);

        Payment::create([
            'booking_id' => optional($debtor->booked)->id,
            'part_time_booking_id' => optional($debtor->partTimeBooked)->id,
            'amount' => $data['amount']
        ]);

        flash('عملیات با موفقیت انجام شد', 'success');

        return redirect()->route('admin.debtors.index');

    }

    /**
     * @param Creditor $creditor
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function refundCreditorMoney(Creditor $creditor)
    {

        $creditor->update(['is_refunded' => true]);

        flash('عملیات با موفقیت انجام شد.', 'success');

        return redirect()->route('admin.creditors.index');

    }

    /**
     * @param Coach $coach
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function coachPayForm(Coach $coach)
    {


        if (!$coach->deptLessonCount()) {

            flash('مربی مورد هزینه تمام جلسات را پرداخت کرده است.', 'info');

            return back();

        }

        return view('admin.financial.coach_pay_form', compact('coach'));

    }

    /**
     * @param Coach $coach
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeCoachPay(Coach $coach)
    {

        $data = \request()->validate(['amount' => 'required|numeric|min:1']);


        if ((integer)$data['amount'] !== $coach->deptLessonCount()) {

            flash('تعداد جلسات وارد شده برابر با تعداد جلسات  بدهی مربی نیست.', 'warning');

            return back();

        }

        $bookings = $coach->bookings()->where('is_canceled', false)->where('is_paid', false)->take($data['amount'])->get();

        $bookings->each(function ($booking) {
            $booking->update(['is_paid' => true]);
        });

        $coach->partTimeBookings()->each(function ($booking) {
            $booking->update(['is_paid' => true]);
        });

        flash('تعداد جلسات پرداختی با موفقیت از حساب مربی کاسته شد.', 'success');

        return redirect()->route('admin.financial.coaches_debt_list');

    }

    /**
     * @param Coach $coach
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function increaseCoachBalance(Coach $coach)
    {

        \request()->validate(['amount' => 'required|numeric|min:1']);

        $coach->balance->update(['amount' => $coach->balance->amount - \request('amount')]);

        flash('افزایش حساب با موفقیت انجام شد.', 'success');

        return redirect()->back();

    }

}
