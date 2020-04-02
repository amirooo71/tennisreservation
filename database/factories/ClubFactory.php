<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Club;
use Faker\Generator as Faker;

$factory->define( Club::class, function ( Faker $faker ) {
	return [
		'owner_id'     => factory( \App\User::class ),
		'name'         => $faker->name,
		'description'  => $faker->paragraph,
		'courts_count' => $faker->numberBetween( 1, 30 ),
		'opening_time' => '06:00',
		'closing_time' => '23:00'
	];
} );
