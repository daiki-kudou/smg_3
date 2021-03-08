<?php

use Illuminate\Database\Seeder;

use App\Models\Venue;
use Carbon\Carbon;


class Time_priceTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $venue = Venue::find(1);
    $venue->time_prices()->create([
      'venue_id' => $venue->id,
      'time' => 3,
      'price' => 32500,
      'extend' => 5900,
      'created_at' => Carbon::now(),
    ]);
    $venue->time_prices()->create([
      'venue_id' => $venue->id,
      'time' => 4,
      'price' => 38400,
      'extend' => 7100,
      'created_at' => Carbon::now(),

    ]);
    $venue->time_prices()->create([
      'venue_id' => $venue->id,
      'time' => 6,
      'price' => 46000,
      'extend' => 6000,
      'created_at' => Carbon::now(),

    ]);
    $venue->time_prices()->create([
      'venue_id' => $venue->id,
      'time' => 8,
      'price' => 52400,
      'extend' => 5300,
      'created_at' => Carbon::now(),

    ]);
    $venue->time_prices()->create([
      'venue_id' => $venue->id,
      'time' => 12,
      'price' => 64000,
      'extend' => 4500,
      'created_at' => Carbon::now(),

    ]);
  }
}
