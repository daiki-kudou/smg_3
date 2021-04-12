<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use App\Models\UnknownUser;
use App\Models\PreReservation;

use Faker\Generator as Faker;



class UnknownUsersTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run(Faker $faker)
  {
    DB::table('unknown_users')->truncate();

    $preReservations = PreReservation::where("user_id", ">", 0)->get();
    foreach ($preReservations as $key => $value) {
      if ($key % 2 == 0) {
        UnknownUser::create([
          'pre_reservation_id' => $value->id,
          'unknown_user_company' => $faker->company,
          'unknown_user_name' => $faker->name,
          'unknown_user_email' => $faker->unique()->safeEmail,
          'unknown_user_mobile' => $faker->numberBetween(11111111111, 99999999999),
          'unknown_user_tel' => $faker->numberBetween(1111111111, 9999999999),
        ]);
      }
    }
  }
}
