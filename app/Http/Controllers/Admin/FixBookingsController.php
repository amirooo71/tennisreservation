<?php

namespace App\Http\Controllers\Admin;

use App\Club;
use App\FixBooking;
use App\Http\Controllers\Controller;
use Hekmatinasser\Verta\Verta;
use Illuminate\Http\Request;

class FixBookingsController extends Controller
{

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {

        $fixBookings = FixBooking::paginate(30);

        return view('admin.fix_bookings.index', compact('fixBookings'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {

        $club = Club::first();

        $courts = $club->courts;

        $openingHours = $club->openingHours();

        return view('admin.fix_bookings.create', compact('openingHours', 'courts'));
    }

    /**
     * @param FixBooking $fixBooking
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(FixBooking $fixBooking)
    {


        $club = Club::first();

        $courts = $club->courts;

        $openingHours = $club->openingHours();

        return view('admin.fix_bookings.edit', compact('fixBooking', 'openingHours', 'courts'));
    }

    /**
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function store()
    {
        $data = $this->getValidateDate();

        if ($this->isBooked()) {

            if (\request()->wantsJson()) {
                return response()->json(['msg' => 'در این روز و ساعت رزرو فیکسی دیگری است.'], 422);
            }

            flash('در این روز و ساعت رزرو فیکسی دیگری است.', 'danger');

            return back();
        }

        $booked = FixBooking::create($data);

        if (\request()->wantsJson()) {
            return response()->json(['msg' => 'رزرو فیکسی با موفقیت ذخیره شد', 'booked' => $booked]);
        }

        flash('رزرو با موفقیت ثبت شد', 'success');

        return redirect()->route('admin.fix_bookings.index');
    }

    /**
     * @param FixBooking $fixBooking
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(FixBooking $fixBooking)
    {

        $data = $this->getValidateDate();

        if ($this->isCurrentFixBooked($fixBooking)) {

            $fixBooking->update($data);

        } else {

            if ($this->isBooked()) {
                flash('در این روز و ساعت رزرو فیکسی دیگری است.', 'danger');

                return back();
            }


            $fixBooking->update($data);

        }


        flash('رزرو با موفقیت ویرایش شد', 'success');

        return redirect()->route('admin.fix_bookings.index');

    }

    /**
     * @param FixBooking $fixBooking
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function delete(FixBooking $fixBooking)
    {

        $fixBooking->delete();

        flash('رزرو با موفقیت حذف شد', 'success');

        return redirect()->route('admin.fix_bookings.index');

    }

    /**
     * @return array
     */
    private function getValidateDate(): array
    {
        $data = \request()->validate([
            'court_id' => 'required',
            'renter_name' => 'required_without:coach_id',
            'coach_id' => 'required_without:renter_name',
            'day' => 'required',
            'time' => 'required',
            'partner_name' => 'nullable',
        ]);

        return $data;
    }

    /**
     * @return mixed
     */
    private function isBooked()
    {
        return FixBooking::where('day', \request()->input('day'))
            ->where('time', \request()->input('time'))
            ->where('court_id', \request()->input('court_id'))
            ->first();
    }

    /**
     * @param FixBooking $fixBooking
     *
     * @return bool
     */
    private function isCurrentFixBooked(FixBooking $fixBooking): bool
    {
        return $fixBooking->day === \request()->input('day') && $fixBooking->time === \request()->input('time') && $fixBooking->court_id === \request()->input('court_id');
    }
}
