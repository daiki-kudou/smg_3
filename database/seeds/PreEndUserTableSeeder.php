<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use App\Models\PreEndUser;
use App\Models\PreReservation;

use Faker\Generator as Faker;

class PreEndUserTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run(Faker $faker)
  {
    DB::table('pre_endusers')->truncate();

    $preReservations = PreReservation::where("agent_id", ">", 0)->get();
    foreach ($preReservations as $key => $value) {
      if ($key % 2 == 0) {
        PreEndUser::create([
          'pre_reservation_id' => $value->id,
          'company' => $faker->company,
          'person' => $faker->name,
          'email' => $faker->unique()->safeEmail,
          'mobile' => $faker->numberBetween(11111111111, 99999999999),
          'tel' => $faker->numberBetween(1111111111, 9999999999),
          'address' => $faker->address,
          'attr' => rand(1, 3),
          'charge' => 0,
        ]);
      }
    }
  }
}
