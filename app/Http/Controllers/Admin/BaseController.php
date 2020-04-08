<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Hekmatinasser\Verta\Verta;

class BaseController extends Controller {

	/**
	 * @return bool
	 */
	protected function isDatePast(): bool {

		$currentFormatDate = Verta::now()->format( 'Y-n-j' );

		return Verta::parse( $currentFormatDate )->gt( Verta::parse( request( 'date' ) ) ) && Verta::parse( $currentFormatDate )->notEqualTo( Verta::parse( request( 'date' ) ) );


	}

}