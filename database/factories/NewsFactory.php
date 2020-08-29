<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\News;
use Faker\Generator as Faker;

$factory->define(news::class, function (Faker $faker) {
    return [
        'title' => $faker->realText(rand(10, 30)),
        'text' => $faker->realText(rand(1000, 3000)),
        'isPrivate' => (bool)rand(0,1),
        'category_id' => (int)rand(1, 4)
    ];
});
