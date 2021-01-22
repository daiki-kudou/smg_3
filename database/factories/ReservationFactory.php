<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Reservation;
use Faker\Generator as Faker;

$factory->define(Reservation::class, function (Faker $faker) {
  return [
    'venue_id' => 1,
    'user_id' => 1,
    'reserve_date' => '2020-01-01',
    'price_system' => 1,
    'enter_time' => '10:00:00',
    'leave_time' => '10:00:00',
    'board_flag' => 1,
    'email_flag' => 1,
    'in_charge' => 1,
    'tel' => 1,
    'cost' => 1,
    'payment_limit' => '2020-01-01',
    'bill_company' => 1,
    'bill_person' => 1,
    'bill_created_at' => '2020-01-01',
    'bill_pay_limit' => '2020-01-01',
  ];
});
