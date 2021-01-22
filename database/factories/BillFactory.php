<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Bill;

use Faker\Generator as Faker;

$factory->define(Bill::class, function (Faker $faker) {
  return [
    'reservation_id' => rand(1, 50000),
    'venue_total' => 1,
    'discount_venue_total' => 1,
    'equipment_total' => 1,
    'service_total' => 1,
    'luggage_total' => 1,
    'equipment_service_total' => 1,
    'discount_equipment_service_total' => 1,
    'layout_total' => 1,
    'after_duscount_layouts' => 1,
    'others_total' => 1,
    'after_duscount_others' => 1,
    'sub_total' => 1,
    'tax' => 1,
    'total' => 1,
    'paid' => 0,
    'reservation_status' => 0,
    'double_check_status' => 0,
    'category' => 0,
  ];
});
