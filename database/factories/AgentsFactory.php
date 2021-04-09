<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Agent;
use Faker\Generator as Faker;

$factory->define(Agent::class, function (Faker $faker) {
  return [
    'name' => $faker->userName,
    'company' => $faker->company,
    'post_code' => $faker->postcode,
    'address1' => $faker->city,
    'address2' => $faker->streetName,
    'address3' => $faker->streetAddress,
    // 'address_remark' => $faker->sentence,
    // 'url' => $faker->url,
    // 'attr' => 1,
    // 'remark' => $faker->text,
    'person_firstname'  => $faker->firstName,
    'person_lastname'  => $faker->lastName,
    'firstname_kana'   => "カナ",
    'lastname_kana' => "テスト",
    'person_mobile' => $faker->numberBetween(11111111111, 99999999999),
    'person_tel' => $faker->numberBetween(1111111111, 9999999999),
    'fax' => $faker->numberBetween(1111111111, 9999999999),
    'email' => $faker->email,
    'cost' => 80,
    'payment_limit' => 1,
    'payment_day' => '１０月２日',
    'payment_remark' => '特になし',
  ];
});
