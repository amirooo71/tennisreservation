<?php

namespace App\Providers;

use App\Club;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider {
	/**
	 * Register any application services.
	 *
	 * @return void
	 */
	public function register() {
		//
	}

	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot() {

//		View::share( 'club', Club::first() );

		Blade::directive( 'faNum', function ( $arguments ) {

			list( $num, $format ) = explode( ',', $arguments );

			return "<?php echo App\FaNumber::toPersianNumbers($num,$format); ?>";
		} );

		Blade::directive( 'toHours', function ( $minutes ) {
			return "<?php echo App\FaNumber::toHours($minutes); ?>";
		} );

	}
}
