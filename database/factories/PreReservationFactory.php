<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\PreReservation;
use App\Models\Venue;
use App\Models\User;
use App\Models\Agent;
use Faker\Generator as Faker;


$factory->define(PreReservation::class, function (Faker $faker) {
  $venues = Venue::all()->pluck("id");
  $users = User::all()->pluck("id");
  $agents = Agent::all()->pluck("id");
  $enter = ['10:00:00', '12:00:00', '14:00:00'];
  $leave = ['16:00:00', '18:00:00', '20:00:00'];
  $date = ["2020-04-01 00:00:00", "2020-04-03 00:00:00", "2020-04-05 00:00:00", "2020-04-07 00:00:00", "2020-04-09 00:00:00", "2020-04-11 00:00:00", "2020-04-12 00:00:00", "2020-04-18 00:00:00", "2020-04-19 00:00:00", "2020-04-20 00:00:00", "2020-04-21 00:00:00", "2020-04-29 00:00:00"];

  return [
    'multiple_reserve_id' => 0,
    'venue_id' => $venues[array_rand($venues->all(), 1)],
    'user_id' => $users[array_rand($users->all(), 1)],
    'agent_id' => $agents[array_rand($agents->all(), 1)],
    'reserve_date' => $faker->dateTimeThisYear,
    'price_system' => rand(1, 2),
    'enter_time' => $enter[array_rand($enter, 1)],
    'leave_time' => $leave[array_rand($leave, 1)],
    'board_flag' => rand(0, 1),
    'event_start' => "",
    'event_finish' => "",
    'event_name1' => "",
    'event_name2' => "",
    'event_owner' => "",
    'luggage_count' => rand(1, 9),
    'luggage_arrive' => $date[array_rand($date, 1)],
    'luggage_return' => rand(1, 9),
    'email_flag' => 0,
    'in_charge' => $faker->lastName . $faker->firstName,
    'tel' => $faker->phoneNumber,
    'discount_condition' => "",
    'attention' => "",
    'user_details' => "",
    'admin_details' => "",
    'status' => 0,
    'eat_in' => 0,
    'eat_in_prepare' => 0,
    'cost' => 0,
  ];
});
