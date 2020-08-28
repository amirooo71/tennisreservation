<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FixBooking extends Model {
	protected $guarded = [];

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function court() {
		return $this->belongsTo( Court::class );
	}

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
	public function coach(){
	    return $this->belongsTo(Coach::class);
    }
}
