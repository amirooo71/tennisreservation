<?php

namespace App;

use Hekmatinasser\Verta\Verta;
use Illuminate\Database\Eloquent\Model;

class Coach extends Model
{
    protected $guarded = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function partTimeBookings()
    {
        return $this->hasMany(PartTimeBooking::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function debt()
    {
        return $this->hasMany(Debtor::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function credit()
    {
        return $this->hasMany(Creditor::class);
    }

    /**
     * @return int|mixed
     */
    public function deptLessonMinutes()
    {

        $bookingMinutes = $this->bookings()
            ->where('is_canceled', '=', false)
            ->where('is_paid', '=', false)
            ->sum('duration');

        $partTimeBookingMinutes = $this->partTimeBookings()
            ->where('is_canceled', '=', false)
            ->where('is_paid', '=', false)
            ->sum('duration');

        return $partTimeBookingMinutes + $bookingMinutes;

    }

    /**
     * @return int|mixed
     */
    public function deptLessonCount()
    {

        $bookingMinutes = $this->bookings()
            ->where('is_canceled', '=', false)
            ->where('is_paid', '=', false)
            ->count();

        $partTimeBookingMinutes = $this->partTimeBookings()
            ->where('is_canceled', '=', false)
            ->where('is_paid', '=', false)
            ->count();

        return $partTimeBookingMinutes + $bookingMinutes;

    }

    /**
     * @return int|mixed
     */
    public function todayLessonHours()
    {
        return $this->bookings()->where('date', Verta::now()->format('Y-n-j'))->where('is_canceled',false)->count();
    }

    public function totalLearningCount(){

        $bookingMinutes = $this->bookings()
            ->where('is_canceled', '=', false)
            ->count();

        $partTimeBookingMinutes = $this->partTimeBookings()
            ->where('is_canceled', '=', false)
            ->count();

        return $partTimeBookingMinutes + $bookingMinutes;

    }

    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

}
