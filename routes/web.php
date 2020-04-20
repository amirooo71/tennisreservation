<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get( '/', function () {
	return view( 'welcome' );
} );


Route::get( '/playground', function () {

	$b = \App\Booking::find( 62 );

	$now        = \Hekmatinasser\Verta\Facades\Verta::now();
	$bookedTime = \Hekmatinasser\Verta\Facades\Verta::parse( $b->date . ' ' . $b->time );


	dd( $now->lt( $bookedTime->subHours( 12 ) ) );


} );


Auth::routes();

Route::get( '/home', 'HomeController@index' )->name( 'home' );

Route::middleware( [ 'auth' ] )->prefix( 'admin' )->group( function () {

	Route::get( 'dashboard', 'Admin\DashboardController@index' )->name( 'admin.dashboard.index' );

	Route::get( 'clubs', 'Admin\ClubsController@index' )->name( 'admin.clubs.index' );
	Route::get( 'clubs/create', 'Admin\ClubsController@create' )->name( 'admin.clubs.create' );
	Route::get( 'clubs/{club}/edit', 'Admin\ClubsController@edit' )->name( 'admin.clubs.edit' );
	Route::post( 'clubs', 'Admin\ClubsController@store' )->name( 'admin.clubs.store' );
	Route::patch( 'clubs/{club}', 'Admin\ClubsController@update' )->name( 'admin.clubs.update' );
	Route::delete( 'clubs/{club}', 'Admin\ClubsController@delete' )->name( 'admin.clubs.delete' );

	Route::get( 'clubs/{club}/courts', 'Admin\CourtsController@index' )->name( 'admin.courts.index' );
	Route::get( 'clubs/{club}/courts/create', 'Admin\CourtsController@create' )->name( 'admin.courts.create' );
	Route::get( 'clubs/{club}/courts/{court}/edit', 'Admin\CourtsController@edit' )->name( 'admin.courts.edit' );
	Route::get( 'clubs/{club}/courts/{court}', 'Admin\CourtsController@delete' )->name( 'admin.courts.delete' );
	Route::post( 'clubs/{club}/courts', 'Admin\CourtsController@store' )->name( 'admin.courts.store' );
	Route::patch( 'clubs/{club}/courts/{court}', 'Admin\CourtsController@update' )->name( 'admin.courts.update' );

	Route::get( 'bookings', 'Admin\BookingsController@index' )->name( 'admin.bookings.index' );
	Route::get( 'bookings/{booking}/cancel/is-valid-time', 'Admin\BookingsController@isValidTimeForCanceling' )->name( 'admin.bookings.isValidTimeForCanceling' );
	Route::post( 'bookings', 'Admin\BookingsController@store' )->name( 'admin.bookings.store' );
	Route::patch( 'bookings/{booking}/cancel', 'Admin\BookingsController@cancel' )->name( 'admin.bookings.cancel' );
	Route::patch( 'bookings/{booking}/pay', 'Admin\BookingsController@pay' )->name( 'admin.bookings.pay' );

	Route::get( 'ajax/coaches', 'Admin\CoachesController@getCoaches' )->name( 'admin.coaches.getCoaches' );

	Route::get( 'bookings/part-time/{partTimeBooking}/cancel/is-valid-time', 'Admin\PartTimeBookingsController@isValidTimeForPartTimeCanceling' )->name( 'admin.bookings.isValidTimeForPartTimeCanceling' );
	Route::post( 'bookings/{booking}/part-time', 'Admin\PartTimeBookingsController@store' )->name( 'admin.bookings.part_time.store' );
	Route::patch( 'bookings/{partTimeBooking}/part-time/pay', 'Admin\PartTimeBookingsController@pay' )->name( 'admin.bookings.part_time.pay' );
	Route::patch( 'bookings/{partTimeBooking}/part-time/cancel', 'Admin\PartTimeBookingsController@cancel' )->name( 'admin.bookings.part_time.cancel' );


	Route::get( 'hours', 'Admin\BookingsController@getHours' );
	Route::get( 'courts', 'Admin\CourtsController@courts' );
} );