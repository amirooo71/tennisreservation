<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Court extends Model {
	protected $guarded = [];

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function club() {
		return $this->belongsTo( Club::class );
	}


}
