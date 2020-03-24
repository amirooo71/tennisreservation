<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Club extends Model {

	protected $guarded = [];

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function courts() {
		return $this->hasMany( Court::class );
	}

	/**
	 * @param $data
	 */
	public function addCourt( $data ) {
		$this->courts()->create( $data );
	}
}
