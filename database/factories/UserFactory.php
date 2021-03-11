<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
  return [
    'email'              => $faker->unique()->safeEmail,
    'password'             => Hash::make('12345678'),
    'company'          => $faker->company,
    'post_code'    => $faker->postcode,
    'address1' => $faker->city,
    'address2' => $faker->streetName,
    'address3' => $faker->streetAddress,
    'first_name'    => $faker->lastName,
    'last_name'    => $faker->firstName,
    'first_name_kana'    => 'ダミーのため一致しません',
    'last_name_kana'    => 'ダミーのため一致しません',
    'status'    => 1,
    'mobile' =>  $faker->phoneNumber(),
    'tel' =>  $faker->phoneNumber(),
    "pay_method" => $faker->randomElement(['0', '1', '2', '3']),
    'pay_limit' => $faker->randomElement(['1', '2', '3', '4']),
    'pay_post_code' => $faker->postcode,
    'pay_address1' => "ダミーデータ",
    'pay_address2' => "ダミーデータ",
    'pay_address3' => "ダミーデータ",
    'pay_remark' => "ダミーデータ" . $faker->realText(20),
  ];
});
