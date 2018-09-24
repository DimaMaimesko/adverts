<?php

use Faker\Generator as Faker;
use App\Models\Adverts\Category;


$factory->define(Category::class, function (Faker $faker) {
    return [
        'name' => $name = $faker->unique()->company,
        'slug' => str_slug($name),
        'parent_id' => null,
    ];
});

