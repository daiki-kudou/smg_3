<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Service;
use Faker\Generator as Faker;

$factory->define(Service::class, function (Faker $faker) {
  return [
    'item' => $faker->word . rand(1, 100),
    'price' => rand(2000, 5000),
    'remark' => $faker->sentence
  ];
});
