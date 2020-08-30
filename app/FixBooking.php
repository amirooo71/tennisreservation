<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FixBooking extends Model
{

    protected $guarded = [];

    protected $appends = ['court_name', 'coach_name'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function court()
    {
        return $this->belongsTo(Court::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function coach()
    {
        return $this->belongsTo(Coach::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function player(){
        return $this->belongsTo(Player::class);
    }

    /**
     * @return string
     */
    public function getCoachNameAttribute()
    {
        if($this->coach){
            return $this->coach->first_name . ' ' . $this->coach->last_name;
        }
    }

    /**
     * @return mixed
     */
    public function getCourtNameAttribute()
    {
        return $this->court->name;
    }
}
