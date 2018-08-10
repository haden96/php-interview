<?php

use Faker\Generator as Faker;
use Proexe\BookingApp\Offices\Models\OfficeModel;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define( OfficeModel::class, function ( Faker $faker ) {
	$data = [
		'name' => $faker->colorName,
		'lat' => $faker->latitude,
		'lng' => $faker->longitude,
		'office_hours' => [],
	];
	for ( $lp = 0; $lp < 7; $lp ++ ) {
		if ( $faker->boolean( 10 ) ) {
			$data['office_hours'][ $lp ] = [ 'isClosed' => true ];
		} else {
			$data['office_hours'][ $lp ] = [
				'isClosed' => false,
				'from'     => $faker->numberBetween( 8, 12 ) . ':00',
				'to'       => $faker->numberBetween( 15, 20 ) . ':00'
			];
		}
	}
	return $data;
} );