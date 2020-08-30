<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    protected $guarded = [];

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
     * @return int
     */
    public function deptLessonsCount()
    {
        return $this->lessons()->where('is_paid', false)->where('is_canceled', false)->count();
    }

    /**
     * @return int
     */
    public function paidLessonsCount()
    {
        return $this->lessons()->where('is_paid', true)->where('is_canceled', false)->count();
    }

    /**
     * @return int|mixed
     */
    public function deptLessonMinutes()
    {
        return $this->lessons()->where('is_paid', false)->where('is_canceled', false)->sum('duration');
    }

    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }
}
