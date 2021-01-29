<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Bill;

use Faker\Generator as Faker;

$factory->define(Bill::class, function (Faker $faker) {
  return [
    'reservation_id' => rand(1, 10),
    'venue_price' => 1,
    'equipment_price' => 1,
    'layout_price' => 1,
    'others_price' => 1,
    'master_subtotal' => 1,
    'master_tax' => 1,
    'master_total' => 1,

    'paid' => 0,
    'reservation_status' => 1,
    'double_check_status' => 0,
    'category' => 1,
    'admin_judge' => 1,
  ];
});
