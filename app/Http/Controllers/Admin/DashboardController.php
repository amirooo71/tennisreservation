<?php

namespace App\Http\Controllers\Admin;

use App\Booking;
use App\Club;
use App\Court;
use App\Http\Controllers\Controller;
use App\Player;
use Carbon\Carbon;
use Hekmatinasser\Verta\Verta;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class DashboardController extends BaseController
{

    private $debtPlayers = [];

    public function index()
    {

        if (!Club::first()) {

            return redirect()->route('admin.clubs.index');

        }

        $courts = Court::all();

        $bookings = Booking::today();

        $canceled = Booking::today(true);

        $bookingMinutes = $bookings->sum('duration') + $bookings->partTimeBookedMinutes();

        $canceledMinutes = $canceled->sum('duration') + $canceled->partTimeBookedMinutes();

        if ($courts->count()) {

            $bookingPercent = $this->calculatePercentage($bookings, $courts);

            $canceledPercent = $this->calculatePercentage($canceled, $courts);

        }

        return view('admin.dashboard.index', compact('courts', 'bookingPercent', 'canceledPercent', 'bookingMinutes', 'canceledMinutes'));

    }

    /**
     * @param $query
     * @param $courts
     *
     * @return float|int
     */
    private function calculatePercentage($query, $courts)
    {
        return round($query->count() * 100 / (Club::first()->opening_hours * $courts->count()));
    }

}
