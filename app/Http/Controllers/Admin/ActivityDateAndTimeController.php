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

		$date = $this->getBeginDate();

		$dates = [ $this->dateSerializer( $date ) ];

		for ( $i = 1; $i < $weekDays; $i ++ ) {

			$newDate = $date->addDay( 1 );

			$dates[] = $this->dateSerializer( $newDate );

		}

		return [ 'week' => $dates, 'endOfWeek' => $date->format( 'Y-n-j' ) ];

	}

	/**
	 * @return mixed
	 */
	public function hours() {
		return Club::first()->openingHours();
	}

	/**
	 * @param $date
	 *
	 * @return array
	 */
	public function dateSerializer( $date ) {
		return [
			'date'         => $date->format( 'Y-m-j' ),
			'readableDay'  => $date->formatWord( 'l' ),
			'readableDate' => $date->formatWord( 'dS F' ),
		];
	}


	private function getBeginDate() {

		if ( request()->has( 'nextWeek' ) ) {

			$date = Verta::parse( request( 'endOfWeek' ) )->addDay( 1 );

		} elseif ( request()->has( 'prevWeek' ) ) {

			$date = Verta::parse( request( 'endOfWeek' ) )->subDays( 13 );

		} else {

			$date = Verta::now();

		}

		return $date;
	}
}
