<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\PreReservation;
use App\Models\Venue;
use App\Models\User;
use App\Models\Agent;
use Faker\Generator as Faker;

use Faker\Provider\DateTime;


$factory->define(PreReservation::class, function (Faker $faker) {
  $venues = Venue::all()->pluck("id");
  $users = User::all()->pluck("id");
  $agents = Agent::all()->pluck("id");
  $enter = ['10:00:00', '12:00:00', '14:00:00'];
  $leave = ['16:00:00', '18:00:00', '20:00:00'];
  $date = [
    "2020-08-20",
    "2020-08-22",
    "2021-06-15",
    "2021-06-16",
    "2021-06-17",
    "2021-06-18",
    "2021-06-19",
    "2021-06-20",
    "2021-06-21",
    "2021-06-22",
    "2021-06-23",
    "2021-06-24",
    "2021-06-25",
    "2021-06-26",
    "2021-06-27",
    "2021-06-28",
    "2021-06-29",
  ];

  $randUser = $users[array_rand($users->all(), 1)];
  $randAgent = $agents[array_rand($agents->all(), 1)];
  if ($randUser % 2 == 0) {
    $randUser = 0;
    $randAgent = $agents[array_rand($agents->all(), 1)];
  } else {
    $randUser = $users[array_rand($users->all(), 1)];
    $randAgent = 0;
  }
  return [
    'multiple_reserve_id' => 0,
    'venue_id' => $venues[array_rand($venues->all(), 1)],
    'user_id' => $randUser,
    'agent_id' => $randAgent,
    'reserve_date' => $faker->dateTimeBetween($startDate = '-7 day', $endDate = '+15 day'),
    'price_system' => rand(1, 2),
    'enter_time' => $enter[array_rand($enter, 1)],
    'leave_time' => $leave[array_rand($leave, 1)],
    'board_flag' => rand(0, 1),
    'event_start' => NULL,
    'event_finish' => NULL,
    'event_name1' => NULL,
    'event_name2' => NULL,
    'event_owner' => NULL,
    'luggage_flag' => 1,
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
    'status' => rand(0, 2),
    'eat_in' => 0,
    'eat_in_prepare' => 0,
    'cost' => 0,
    'created_at' => $faker->dateTimeBetween($startDate = '-2 month', $endDate = '+2 moth'),
    'updated_at' => $faker->dateTimeBetween($startDate = '-7 day', $endDate = '+1 day'),
  ];
});
