<?php
/**
 * Created by PhpStorm.
 * User: boorak
 * Date: 4/27/20
 * Time: 4:58 PM
 */

namespace App\Traits;


use Hekmatinasser\Verta\Verta;

trait ShamsiTimestamps {

	public function getCreatedAtAttribute( $value ) {

		return Verta::instance( $value )->formatDatetime();
	}

	public function getUpdatedAtAttribute( $value ) {

		return Verta::instance( $value )->formatDatetime();
	}

}