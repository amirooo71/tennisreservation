<?php

namespace App\Http\Controllers\Admin;

use App\Club;
use Carbon\Carbon;

class ClubsController extends BaseController
{

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {

        $club = Club::first();

        return view('admin.clubs.index', compact('club'));
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function create()
    {

        if (Club::first()) {

            flash('شما در حال حاضر یک کلاب تعریف شده دارید و امکان اضافه کردن کلاب جدید وجود ندارد.', 'info');

            return redirect()->route('admin.clubs.index');
        }

        return view('admin.clubs.create');
    }

    /**
     * @param Club $club
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Club $club)
    {

        return view('admin.clubs.edit', compact('club'));

    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store()
    {


        if (Club::first()) {
            abort(403);
        }

        $data = $this->getValidateData();

        Club::create($data);

        flash('کلاب با موفقیت تعریف شد و امکانات سیستم برای شما فعال شد.', 'success');

        return redirect()->route('admin.clubs.index');

    }

    /**
     * @param Club $club
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Club $club)
    {

        $data = $this->getValidateData();

        $club->update($data);

        flash('اطلاعات کلاب با موفقیت ویرایش شد.', 'success');

        return redirect()->route('admin.clubs.index');

    }

    /**
     * @param Club $club
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function delete(Club $club)
    {

        $club->delete();

        flash('اطلاعات کلاب با موفقیت حدف شد.', 'success');

        return redirect()->route('admin.clubs.index');
    }

    /**
     * @return array
     */
    private function getValidateData(): array
    {

        $data = \request()->validate([
            'name' => 'required|string|min:3',
            'courts_count' => 'required|numeric|min:1|max:100',
            'opening_time' => 'required',
            'closing_time' => 'required',
            'cancellation_time' => 'required',
            'fix_amount' => 'required',
            'description' => 'nullable',
        ]);

        $data['opening_hours'] = Carbon::parse($data['opening_time'])->diffInHours(Carbon::parse($data['closing_time'])->addHour());

        $data['owner_id'] = auth()->id();

        return $data;
    }

}
