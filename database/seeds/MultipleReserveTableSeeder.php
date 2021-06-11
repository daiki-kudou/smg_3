<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use App\Models\PreEndUser;
use App\Models\MultipleReserve;

use Faker\Generator as Faker;

class MultipleReserveTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    for ($i = 1; $i <= 200; $i++) {
      MultipleReserve::create([
        "id" => $i,
      ]);
    }
  }
}
