<?php

use Faker\Generator as Faker;
use App\Models\Region;
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

$factory->define(Region::class, function (Faker $faker) {
    return [
        'name' => $name = $faker->unique()->city,
        'slug' => str_slug($name),
        'parent_id' => null,
    ];
});



//* @property string $country
//* @property string $city
//* @property string $streetName
//* @property string $buildingNumber