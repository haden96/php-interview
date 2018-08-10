<?php

use Faker\Generator as Faker;

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

$factory->define(\Proexe\BookingApp\Bookings\Models\BookingModel::class, function (Faker $faker) {
    return [
        'office_id' => factory(Proexe\BookingApp\Offices\Models\OfficeModel::class)->create()->id,
    ];
});
