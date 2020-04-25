<?php

namespace App\Http\Controllers\Admin;

use App\Club;
use Hekmatinasser\Verta\Verta;

class ActivityDateAndTimeController extends BaseController {

	/**
	 * @return array
	 */
	public function dates() {

		$weekDays = 7;

		$now = Verta::now();

		$dates = [
			[
				'date'     => $now->format( 'Y-m-j' ),
				'readableDay' => $now->formatWord('l'),
				'readableDate' => $now->formatWord('dS F')
			]
		];

		for ( $i = 1; $i < $weekDays; $i ++ ) {

			$newDate = $now->addDay( 1 );

			$dates[] = [
				'date'     => $newDate->format( 'Y-m-j' ),
				'readableDay' => $newDate->formatWord('l'),
				'readableDate' => $newDate->formatWord('dS F'),
			];

		}

		return $dates;

	}

	/**
	 * @return mixed
	 */
	public function hours() {
		return Club::first()->openingHours();
	}
}
