<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Reservation;
use Faker\Generator as Faker;

$factory->define(Reservation::class, function (Faker $faker) {
  return [
    'venue_id' => 1,
    'user_id' => 1,
    'agent_id' => 0,
    'reserve_date' => '2020-01-01',
    'price_system' => 1,
    'enter_time' => '10:00:00',
    'leave_time' => '10:00:00',
    'board_flag' => 1,
    'email_flag' => 1,
    'in_charge' => 1,
    'tel' => 1,
    'cost' => 1,
    "eat_in" => 0,
    "eat_in_prepare" => 0,
  ];
});
