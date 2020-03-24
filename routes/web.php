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

Auth::routes();

Route::get( '/home', 'HomeController@index' )->name( 'home' );

Route::middleware( [ 'auth' ] )->prefix( 'admin' )->group( function () {

	Route::get( 'dashboard', 'Admin\DashboardController@index' )->name( 'admin.dashboard.index' );

	Route::get( 'clubs', 'Admin\ClubsController@create' )->name( 'admin.clubs.create' );
	Route::post( 'clubs', 'Admin\ClubsController@store' )->name( 'admin.clubs.store' );

	Route::get( 'clubs/{club}', 'Admin\CourtsController@index' )->name( 'admin.courts.index' );
	Route::get( 'clubs/{club}/courts', 'Admin\CourtsController@create' )->name( 'admin.courts.create' );
	Route::post( 'clubs/{club}/courts', 'Admin\CourtsController@store' )->name( 'admin.courts.store' );

	Route::get( 'clubs/{club}/design', 'Admin\ClubDesignController@index' )->name( 'admin.club_design.index' );

} );