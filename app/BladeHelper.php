<?php

namespace App;


class BladeHelper {

	public static function toPersianNumbers( $string, $formatNumber = false ) {

		if ($formatNumber) {
			$string =  number_format($string);
		}

		$farsi_array   = array( "۰", "۱", "۲", "۳", "۴", "۵", "۶", "۷", "۸", "۹" );
		$english_array = array( "0", "1", "2", "3", "4", "5", "6", "7", "8", "9" );

		$persian_number = str_replace( $english_array, $farsi_array, $string );

		return $persian_number;
	}

	public static function toHours( $time, $format = '%02d:%02d' ) {
		if ( $time < 1 ) {
			return;
		}
		$hours   = floor( $time / 60 );
		$minutes = ( $time % 60 );

		return self::toPersianNumbers( sprintf( $format, $hours, $minutes ) );
	}

}