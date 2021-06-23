<?php

use Illuminate\Database\Seeder;

use App\Models\Venue;
use App\Models\TimePrice;
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
    DB::table('time_prices')->truncate();

    foreach (Venue::orderBy('id')->get() as $key => $value) {
      if ($key === 0) {
        TimePrice::create([
          'venue_id' => $value->id, 'time' => 3, 'price' => 32500, 'extend' => 5900, 'created_at' => Carbon::now(),
        ]);
        TimePrice::create([
          'venue_id' => $value->id, 'time' => 4, 'price' => 38400, 'extend' => 7100, 'created_at' => Carbon::now(),
        ]);
        TimePrice::create([
          'venue_id' => $value->id, 'time' => 6, 'price' => 46000, 'extend' => 6000, 'created_at' => Carbon::now(),
        ]);
        TimePrice::create([
          'venue_id' => $value->id, 'time' => 8, 'price' => 52400, 'extend' => 5300, 'created_at' => Carbon::now(),
        ]);
        TimePrice::create([
          'venue_id' => $value->id, 'time' => 12, 'price' => 64000, 'extend' => 4500, 'created_at' => Carbon::now(),
        ]);
      } else if ($key === 1) {
        TimePrice::create([
          'venue_id' => $value->id, 'time' => 3, 'price' => 32500, 'extend' => 5900, 'created_at' => Carbon::now(),
        ]);
        TimePrice::create([
          'venue_id' => $value->id, 'time' => 4, 'price' => 38400, 'extend' => 7100, 'created_at' => Carbon::now(),
        ]);
        TimePrice::create([
          'venue_id' => $value->id, 'time' => 6, 'price' => 46000, 'extend' => 6000, 'created_at' => Carbon::now(),
        ]);
        TimePrice::create([
          'venue_id' => $value->id, 'time' => 8, 'price' => 52400, 'extend' => 5300, 'created_at' => Carbon::now(),
        ]);
        TimePrice::create([
          'venue_id' => $value->id, 'time' => 12, 'price' => 64000, 'extend' => 4500, 'created_at' => Carbon::now(),
        ]);
      } else if ($key === 8) {
        TimePrice::create([
          'venue_id' => $value->id, 'time' => 3, 'price' => 36400, 'extend' => 8200, 'created_at' => Carbon::now(),
        ]);
        TimePrice::create([
          'venue_id' => $value->id, 'time' => 4, 'price' => 40400, 'extend' => 7600, 'created_at' => Carbon::now(),
        ]);
        TimePrice::create([
          'venue_id' => $value->id, 'time' => 6, 'price' => 46000, 'extend' => 6000, 'created_at' => Carbon::now(),
        ]);
        TimePrice::create([
          'venue_id' => $value->id, 'time' => 8, 'price' => 61200, 'extend' => 6400, 'created_at' => Carbon::now(),
        ]);
        TimePrice::create([
          'venue_id' => $value->id, 'time' => 12, 'price' => 77200, 'extend' => 5600, 'created_at' => Carbon::now(),
        ]);
      } else if ($key === 16) {
        TimePrice::create([
          'venue_id' => $value->id, 'time' => 3, 'price' => 32500, 'extend' => 4700, 'created_at' => Carbon::now(),
        ]);
        TimePrice::create([
          'venue_id' => $value->id, 'time' => 4, 'price' => 37200, 'extend' => 6800, 'created_at' => Carbon::now(),
        ]);
        TimePrice::create([
          'venue_id' => $value->id, 'time' => 6, 'price' => 46000, 'extend' => 6000, 'created_at' => Carbon::now(),
        ]);
        TimePrice::create([
          'venue_id' => $value->id, 'time' => 8, 'price' => 52400, 'extend' => 5300, 'created_at' => Carbon::now(),
        ]);
        TimePrice::create([
          'venue_id' => $value->id, 'time' => 12, 'price' => 61600, 'extend' => 4300, 'created_at' => Carbon::now(),
        ]);
      }
    }
  }
}
