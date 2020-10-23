<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    protected $guarded = [];

    protected $appends = ['fullName'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function fixes()
    {
        return $this->hasMany(FixBooking::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function lessons()
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function balance()
    {
        return $this->hasOne(PlayerBalance::class);
    }

    /**
     * @return int
     */
    public function mustPayForCanceledCount()
    {
        return $this->lessons()
            ->where('must_pay', true)
            ->where('is_paid', false)
            ->where('is_canceled', true)->count();
    }

    /**
     * @return int|mixed
     */
    public function mustPayForCanceledMinutes()
    {
        return $this->lessons()
            ->where('must_pay', true)
            ->where('is_paid', false)
            ->where('is_canceled', true)
            ->sum('duration');
    }

    /**
     * @return int
     */
    public function deptLessonsCount()
    {
        return $this->lessons()
                ->where('is_paid', false)
                ->where('is_canceled', false)->count() + $this->mustPayForCanceledCount();
    }

    /**
     * @return int
     */
    public function paidLessonsCount()
    {
        return $this->lessons()->where('is_paid', true)->where('is_canceled', false)->count() + $this->mustPayForCanceledCount();
    }

    /**
     * @return int|mixed
     */
    public function deptLessonMinutes()
    {
        return $this->lessons()
                ->where('is_paid', false)
                ->where('is_canceled', false)->sum('duration') + $this->mustPayForCanceledMinutes();
    }

    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }
}
