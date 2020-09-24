<?php

namespace App\Http\Controllers\Admin;

use App\Coach;
use App\Creditor;
use App\Debtor;
use App\Http\Controllers\Controller;
use App\Player;
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
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function playersDebtList()
    {
        $players = Player::paginate(30);

        return view('admin.financial.players_debt_list', compact('players'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function creditors()
    {
        $creditors = Creditor::where(['is_refunded' => false])->paginate(30);

        return view('admin.financial.creditors', compact('creditors'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function debtors()
    {
        $debtors = Debtor::where(['is_paid' => false])->paginate(30);

        return view('admin.financial.debtors', compact('debtors'));
    }

    /**
     * @param Debtor $debtor
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function debtorPaid(Debtor $debtor)
    {

        \request()->validate(['paid' => 'required']);

        $debtor->update(['is_paid' => true]);

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

            flash('مربی مورد نظر هزینه تمام جلسات را پرداخت کرده است.', 'info');

            return back();

        }

        return view('admin.financial.coach_pay_form', compact('coach'));

    }

    /**
     * @param Player $player
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function playerPayForm(Player $player)
    {
        return view('admin.financial.player_pay_form', compact('player'));
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
     * @param Player $player
     * @return \Illuminate\Http\RedirectResponse
     */
    public function syncPlayerBalance(Player $player)
    {
        if ($player->balance) {

            $bookings = $player->lessons()
                ->where('is_canceled', false)
                ->where('is_paid', false)
                ->take($player->balance->amount)
                ->get();

            $bookings->each(function ($booking) use ($player) {
                $booking->update(['is_paid' => true]);
                $player->balance()->decrement('amount');
            });

            if ($bookings->count() !== $player->balance->amount) {
                $mustPayBookings = $player->lessons()
                    ->where('is_canceled', true)
                    ->where('is_paid', false)
                    ->where('must_pay', true)
                    ->take($player->balance->amount - $bookings->count())->get();

                $mustPayBookings->each(function ($booking) use ($player) {
                    $booking->update(['is_paid' => true]);
                    $player->balance()->amount()->decerement();
                    $player->balance()->decrement('amount');
                });
            }

        } else {

        }

        flash('success', 'بروزرسانی با موفقیت انجام شد');
        return back();
    }

    /**
     * @param Player $player
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storePlayerPay(Player $player)
    {
        $data = \request()->validate(['amount' => 'required|numeric|min:1']);

        if (!$player->balance) {
            $player->balance()->create(['amount' => (int)$data['amount']]);
        } else {
            $player->balance()->update(['amount' => $player->balance->amount + (int)$data['amount']]);
        }

        $bookings = $player->lessons()
            ->where('is_canceled', false)
            ->where('is_paid', false)
            ->take($data['amount'])
            ->get();

        $bookings->each(function ($booking) use ($player) {
            $booking->update(['is_paid' => true]);
            $player->balance()->decrement('amount');
        });

        if ($bookings->count() !== $data['amount']) {
            $mustPayBookings = $player->lessons()
                ->where('is_canceled', true)
                ->where('is_paid', false)
                ->where('must_pay', true)
                ->take($data['amount'] - $bookings->count())->get();

            $mustPayBookings->each(function ($booking) use ($player) {
                $booking->update(['is_paid' => true]);
                $player->balance()->amount()->decerement();
                $player->balance()->decrement('amount');
            });
        }

        flash('تعداد جلسات پرداختی با موفقیت از حساب شاگرد کاسته شد.', 'success');

        return back();
    }

    /**
     * @param Player $player
     * @return \Illuminate\Http\RedirectResponse
     */
    public function reducePlayerBalance(Player $player)
    {

        $data = \request()->validate(['amount' => 'required|numeric|min:1']);

        if ($player->balance) {
            $player->balance()->update(['amount' => $player->balance->amount - (int)$data['amount']]);
        } else {
            $player->balance()->create(['amount' => 0 - (int)$data['amount']]);
        }

        flash('تعداد جلسات با موفقیت ویرایش شد', 'success');

        return back();
    }
}
