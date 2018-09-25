<?php

use Faker\Generator as Faker;
use App\Models\Region;

$factory->define(Region::class, function (Faker $faker) {
    return [
        'name' => $name = $faker->unique()->city,
        'slug' => str_slug($name),
        'parent_id' => null,
    ];
});
