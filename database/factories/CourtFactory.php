<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Court;
use Faker\Generator as Faker;

$factory->define(Court::class, function (Faker $faker) {
    return [
	    'club_id'   => factory( \App\Club::class ),
	    'name'      => $faker->name,
	    'type'      => 'hard',
	    'price'     => 30000,
	    'is_indoor' => false,
	    'is_center' => false,
    ];
});
