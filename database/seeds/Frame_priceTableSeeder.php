<?php

use Illuminate\Database\Seeder;


use App\Models\Venue;
use App\Models\FramePrice;


class Frame_priceTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    DB::table('frame_prices')->truncate();


    foreach (Venue::orderBy('id')->get() as $key => $value) {
      if ($key === 0) {
        FramePrice::create([
          'venue_id' => $value->id, 'frame' => '午前', 'start' => '10:00:00', 'finish' => '12:00:00', 'price' => 15000, 'extend' => 5000,
        ]);

        FramePrice::create([
          'venue_id' => $value->id, 'frame' => '午後', 'start' => '13:00:00', 'finish' => '17:00:00', 'price' => 30000, 'extend' => 5000,
        ]);

        FramePrice::create([
          'venue_id' => $value->id, 'frame' => '夜間', 'start' => '18:00:00', 'finish' => '23:00:00', 'price' => 15000, 'extend' => 5000,
        ]);

        FramePrice::create([
          'venue_id' => $value->id, 'frame' => '午前＆午後', 'start' => '10:00:00', 'finish' => '17:00:00', 'price' => 36000, 'extend' => 5000,
        ]);

        FramePrice::create([
          'venue_id' => $value->id, 'frame' => '午後＆夜間', 'start' => '13:00:00', 'finish' => '21:00:00', 'price' => 36000, 'extend' => 5000,
        ]);

        FramePrice::create([
          'venue_id' => $value->id, 'frame' => '終日', 'start' => '10:00:00', 'finish' => '21:00:00', 'price' => 42000, 'extend' => 5000,
        ]);
      } elseif ($key === 1) {
        FramePrice::create([
          'venue_id' => $value->id, 'frame' => '午前', 'start' => '10:00:00', 'finish' => '12:00:00', 'price' => 15000, 'extend' => 5000,
        ]);

        FramePrice::create([
          'venue_id' => $value->id, 'frame' => '午後', 'start' => '13:00:00', 'finish' => '17:00:00', 'price' => 30000, 'extend' => 5000,
        ]);

        FramePrice::create([
          'venue_id' => $value->id, 'frame' => '夜間', 'start' => '18:00:00', 'finish' => '23:00:00', 'price' => 15000, 'extend' => 5000,
        ]);

        FramePrice::create([
          'venue_id' => $value->id, 'frame' => '午前＆午後', 'start' => '10:00:00', 'finish' => '17:00:00', 'price' => 36000, 'extend' => 5000,
        ]);

        FramePrice::create([
          'venue_id' => $value->id, 'frame' => '午後＆夜間', 'start' => '13:00:00', 'finish' => '21:00:00', 'price' => 36000, 'extend' => 5000,
        ]);

        FramePrice::create([
          'venue_id' => $value->id, 'frame' => '終日', 'start' => '10:00:00', 'finish' => '21:00:00', 'price' => 42000, 'extend' => 5000,
        ]);
      } elseif ($key === 2) {
        FramePrice::create([
          'venue_id' => $value->id, 'frame' => '午前', 'start' => '10:00:00', 'finish' => '12:00:00', 'price' => 17000, 'extend' => 6000,
        ]);

        FramePrice::create([
          'venue_id' => $value->id, 'frame' => '午後', 'start' => '13:00:00', 'finish' => '17:00:00', 'price' => 36000, 'extend' => 6000,
        ]);

        FramePrice::create([
          'venue_id' => $value->id, 'frame' => '夜間', 'start' => '18:00:00', 'finish' => '23:00:00', 'price' => 17000, 'extend' => 6000,
        ]);

        FramePrice::create([
          'venue_id' => $value->id, 'frame' => '午前＆午後', 'start' => '10:00:00', 'finish' => '17:00:00', 'price' => 42000, 'extend' => 6000,
        ]);

        FramePrice::create([
          'venue_id' => $value->id, 'frame' => '午後＆夜間', 'start' => '13:00:00', 'finish' => '21:00:00', 'price' => 42000, 'extend' => 6000,
        ]);

        FramePrice::create([
          'venue_id' => $value->id, 'frame' => '終日', 'start' => '10:00:00', 'finish' => '21:00:00', 'price' => 50000, 'extend' => 6000,
        ]);
      } elseif ($key === 3) {
        FramePrice::create([
          'venue_id' => $value->id, 'frame' => '午前', 'start' => '10:00:00', 'finish' => '12:00:00', 'price' => 12000, 'extend' => 3000,
        ]);

        FramePrice::create([
          'venue_id' => $value->id, 'frame' => '午後', 'start' => '13:00:00', 'finish' => '17:00:00', 'price' => 24000, 'extend' => 3000,
        ]);

        FramePrice::create([
          'venue_id' => $value->id, 'frame' => '夜間', 'start' => '18:00:00', 'finish' => '23:00:00', 'price' => 12000, 'extend' => 3000,
        ]);

        FramePrice::create([
          'venue_id' => $value->id, 'frame' => '午前＆午後', 'start' => '10:00:00', 'finish' => '17:00:00', 'price' => 27000, 'extend' => 3000,
        ]);

        FramePrice::create([
          'venue_id' => $value->id, 'frame' => '午後＆夜間', 'start' => '13:00:00', 'finish' => '21:00:00', 'price' => 27000, 'extend' => 3000,
        ]);

        FramePrice::create([
          'venue_id' => $value->id, 'frame' => '終日', 'start' => '10:00:00', 'finish' => '21:00:00', 'price' => 31000, 'extend' => 3000,
        ]);
      } elseif ($key === 4) {
        FramePrice::create([
          'venue_id' => $value->id, 'frame' => '午前', 'start' => '10:00:00', 'finish' => '12:00:00', 'price' => 13000, 'extend' => 4000,
        ]);

        FramePrice::create([
          'venue_id' => $value->id, 'frame' => '午後', 'start' => '13:00:00', 'finish' => '17:00:00', 'price' => 26000, 'extend' => 4000,
        ]);

        FramePrice::create([
          'venue_id' => $value->id, 'frame' => '夜間', 'start' => '18:00:00', 'finish' => '23:00:00', 'price' => 13000, 'extend' => 4000,
        ]);

        FramePrice::create([
          'venue_id' => $value->id, 'frame' => '午前＆午後', 'start' => '10:00:00', 'finish' => '17:00:00', 'price' => 30000, 'extend' => 4000,
        ]);

        FramePrice::create([
          'venue_id' => $value->id, 'frame' => '午後＆夜間', 'start' => '13:00:00', 'finish' => '21:00:00', 'price' => 30000, 'extend' => 4000,
        ]);

        FramePrice::create([
          'venue_id' => $value->id, 'frame' => '終日', 'start' => '10:00:00', 'finish' => '21:00:00', 'price' => 36000, 'extend' => 4000,
        ]);
      } elseif ($key === 5) {
        FramePrice::create([
          'venue_id' => $value->id, 'frame' => '午前', 'start' => '10:00:00', 'finish' => '12:00:00', 'price' => 12000, 'extend' => 3000,
        ]);

        FramePrice::create([
          'venue_id' => $value->id, 'frame' => '午後', 'start' => '13:00:00', 'finish' => '17:00:00', 'price' => 24000, 'extend' => 3000,
        ]);

        FramePrice::create([
          'venue_id' => $value->id, 'frame' => '夜間', 'start' => '18:00:00', 'finish' => '23:00:00', 'price' => 12000, 'extend' => 3000,
        ]);

        FramePrice::create([
          'venue_id' => $value->id, 'frame' => '午前＆午後', 'start' => '10:00:00', 'finish' => '17:00:00', 'price' => 27000, 'extend' => 3000,
        ]);

        FramePrice::create([
          'venue_id' => $value->id, 'frame' => '午後＆夜間', 'start' => '13:00:00', 'finish' => '21:00:00', 'price' => 27000, 'extend' => 3000,
        ]);

        FramePrice::create([
          'venue_id' => $value->id, 'frame' => '終日', 'start' => '10:00:00', 'finish' => '21:00:00', 'price' => 31000, 'extend' => 3000,
        ]);
      } elseif ($key === 6) {
        FramePrice::create([
          'venue_id' => $value->id, 'frame' => '午前', 'start' => '10:00:00', 'finish' => '12:00:00', 'price' => 13000, 'extend' => 4000,
        ]);

        FramePrice::create([
          'venue_id' => $value->id, 'frame' => '午後', 'start' => '13:00:00', 'finish' => '17:00:00', 'price' => 26000, 'extend' => 4000,
        ]);

        FramePrice::create([
          'venue_id' => $value->id, 'frame' => '夜間', 'start' => '18:00:00', 'finish' => '23:00:00', 'price' => 13000, 'extend' => 4000,
        ]);

        FramePrice::create([
          'venue_id' => $value->id, 'frame' => '午前＆午後', 'start' => '10:00:00', 'finish' => '17:00:00', 'price' => 30000, 'extend' => 4000,
        ]);

        FramePrice::create([
          'venue_id' => $value->id, 'frame' => '午後＆夜間', 'start' => '13:00:00', 'finish' => '21:00:00', 'price' => 30000, 'extend' => 4000,
        ]);

        FramePrice::create([
          'venue_id' => $value->id, 'frame' => '終日', 'start' => '10:00:00', 'finish' => '21:00:00', 'price' => 36000, 'extend' => 4000,
        ]);
      } elseif ($key === 7) {
        FramePrice::create([
          'venue_id' => $value->id, 'frame' => '午前', 'start' => '10:00:00', 'finish' => '12:00:00', 'price' => 12000, 'extend' => 3000,
        ]);

        FramePrice::create([
          'venue_id' => $value->id, 'frame' => '午後', 'start' => '13:00:00', 'finish' => '17:00:00', 'price' => 24000, 'extend' => 3000,
        ]);

        FramePrice::create([
          'venue_id' => $value->id, 'frame' => '夜間', 'start' => '18:00:00', 'finish' => '23:00:00', 'price' => 12000, 'extend' => 3000,
        ]);

        FramePrice::create([
          'venue_id' => $value->id, 'frame' => '午前＆午後', 'start' => '10:00:00', 'finish' => '17:00:00', 'price' => 27000, 'extend' => 3000,
        ]);

        FramePrice::create([
          'venue_id' => $value->id, 'frame' => '午後＆夜間', 'start' => '13:00:00', 'finish' => '21:00:00', 'price' => 27000, 'extend' => 3000,
        ]);

        FramePrice::create([
          'venue_id' => $value->id, 'frame' => '終日', 'start' => '10:00:00', 'finish' => '21:00:00', 'price' => 31000, 'extend' => 3000,
        ]);
      } elseif ($key === 8) {
        FramePrice::create([
          'venue_id' => $value->id, 'frame' => '午前', 'start' => '10:00:00', 'finish' => '12:00:00', 'price' => 18500, 'extend' => 6500,
        ]);

        FramePrice::create([
          'venue_id' => $value->id, 'frame' => '午後', 'start' => '13:00:00', 'finish' => '17:00:00', 'price' => 36500, 'extend' => 6500,
        ]);

        FramePrice::create([
          'venue_id' => $value->id, 'frame' => '夜間', 'start' => '18:00:00', 'finish' => '23:00:00', 'price' => 18500, 'extend' => 6500,
        ]);

        FramePrice::create([
          'venue_id' => $value->id, 'frame' => '午前＆午後', 'start' => '10:00:00', 'finish' => '17:00:00', 'price' => 43500, 'extend' => 6500,
        ]);

        FramePrice::create([
          'venue_id' => $value->id, 'frame' => '午後＆夜間', 'start' => '13:00:00', 'finish' => '21:00:00', 'price' => 43500, 'extend' => 6500,
        ]);

        FramePrice::create([
          'venue_id' => $value->id, 'frame' => '終日', 'start' => '10:00:00', 'finish' => '21:00:00', 'price' => 52000, 'extend' => 6500,
        ]);
      } elseif ($key === 9) {
        FramePrice::create([
          'venue_id' => $value->id, 'frame' => '午前', 'start' => '10:00:00', 'finish' => '12:00:00', 'price' => 12000, 'extend' => 5500,
        ]);

        FramePrice::create([
          'venue_id' => $value->id, 'frame' => '午後', 'start' => '13:00:00', 'finish' => '17:00:00', 'price' => 27000, 'extend' => 5500,
        ]);

        FramePrice::create([
          'venue_id' => $value->id, 'frame' => '夜間', 'start' => '18:00:00', 'finish' => '20:00:00', 'price' => 10000, 'extend' => 5500,
        ]);

        FramePrice::create([
          'venue_id' => $value->id, 'frame' => '午前＆午後', 'start' => '10:00:00', 'finish' => '17:00:00', 'price' => 36000, 'extend' => 5500,
        ]);

        FramePrice::create([
          'venue_id' => $value->id, 'frame' => '午後＆夜間', 'start' => '13:00:00', 'finish' => '20:00:00', 'price' => 36000, 'extend' => 5500,
        ]);

        FramePrice::create([
          'venue_id' => $value->id, 'frame' => '終日', 'start' => '10:00:00', 'finish' => '20:00:00', 'price' => 44000, 'extend' => 5500,
        ]);
      } elseif ($key === 10) {
        FramePrice::create([
          'venue_id' => $value->id, 'frame' => '午前', 'start' => '10:00:00', 'finish' => '12:00:00', 'price' => 10000, 'extend' => 4000,
        ]);

        FramePrice::create([
          'venue_id' => $value->id, 'frame' => '午後', 'start' => '13:00:00', 'finish' => '17:00:00', 'price' => 25000, 'extend' => 4000,
        ]);

        FramePrice::create([
          'venue_id' => $value->id, 'frame' => '夜間', 'start' => '18:00:00', 'finish' => '20:00:00', 'price' => 9500, 'extend' => 4000,
        ]);

        FramePrice::create([
          'venue_id' => $value->id, 'frame' => '午前＆午後', 'start' => '10:00:00', 'finish' => '17:00:00', 'price' => 32000, 'extend' => 4000,
        ]);

        FramePrice::create([
          'venue_id' => $value->id, 'frame' => '午後＆夜間', 'start' => '13:00:00', 'finish' => '20:00:00', 'price' => 32000, 'extend' => 4000,
        ]);

        FramePrice::create([
          'venue_id' => $value->id, 'frame' => '終日', 'start' => '10:00:00', 'finish' => '21:00:00', 'price' => 39500, 'extend' => 4000,
        ]);
      } elseif ($key === 11) {
        FramePrice::create([
          'venue_id' => $value->id, 'frame' => '午前', 'start' => '10:00:00', 'finish' => '12:00:00', 'price' => 8000, 'extend' => 3000,
        ]);

        FramePrice::create([
          'venue_id' => $value->id, 'frame' => '午後', 'start' => '13:00:00', 'finish' => '17:00:00', 'price' => 15000, 'extend' => 3000,
        ]);

        // FramePrice::create([
        //   'venue_id' => $value->id, 'frame' => '夜間', 'start' => '18:00:00', 'finish' => '23:00:00', 'price' => 9500, 'extend' => 4000,
        // ]);

        FramePrice::create([
          'venue_id' => $value->id, 'frame' => '午前＆午後', 'start' => '10:00:00', 'finish' => '17:00:00', 'price' => 21000, 'extend' => 3000,
        ]);

        // FramePrice::create([
        //   'venue_id' => $value->id, 'frame' => '午後＆夜間', 'start' => '13:00:00', 'finish' => '21:00:00', 'price' => 32000, 'extend' => 4000,
        // ]);

        // FramePrice::create([
        //   'venue_id' => $value->id, 'frame' => '終日', 'start' => '10:00:00', 'finish' => '21:00:00', 'price' => 39500, 'extend' => 4000,
        // ]);
      } elseif ($key === 12) {
        FramePrice::create([
          'venue_id' => $value->id, 'frame' => '午前', 'start' => '10:00:00', 'finish' => '12:00:00', 'price' => 18000, 'extend' => 6500,
        ]);

        FramePrice::create([
          'venue_id' => $value->id, 'frame' => '午後', 'start' => '13:00:00', 'finish' => '17:00:00', 'price' => 36500, 'extend' => 6500,
        ]);

        FramePrice::create([
          'venue_id' => $value->id, 'frame' => '夜間', 'start' => '18:00:00', 'finish' => '23:00:00', 'price' => 18500, 'extend' => 6500,
        ]);

        FramePrice::create([
          'venue_id' => $value->id, 'frame' => '午前＆午後', 'start' => '10:00:00', 'finish' => '17:00:00', 'price' => 43500, 'extend' => 6500,
        ]);

        FramePrice::create([
          'venue_id' => $value->id, 'frame' => '午後＆夜間', 'start' => '13:00:00', 'finish' => '21:00:00', 'price' => 43500, 'extend' => 6500,
        ]);

        FramePrice::create([
          'venue_id' => $value->id, 'frame' => '終日', 'start' => '10:00:00', 'finish' => '21:00:00', 'price' => 52000, 'extend' => 6500,
        ]);
      } elseif ($key === 13) {
        FramePrice::create([
          'venue_id' => $value->id, 'frame' => '午前', 'start' => '10:00:00', 'finish' => '12:00:00', 'price' => 12000, 'extend' => 3000,
        ]);

        FramePrice::create([
          'venue_id' => $value->id, 'frame' => '午後', 'start' => '13:00:00', 'finish' => '17:00:00', 'price' => 21000, 'extend' => 3000,
        ]);

        FramePrice::create([
          'venue_id' => $value->id, 'frame' => '夜間', 'start' => '18:00:00', 'finish' => '23:00:00', 'price' => 12000, 'extend' => 3000,
        ]);

        FramePrice::create([
          'venue_id' => $value->id, 'frame' => '午前＆午後', 'start' => '10:00:00', 'finish' => '17:00:00', 'price' => 24000, 'extend' => 3000,
        ]);

        FramePrice::create([
          'venue_id' => $value->id, 'frame' => '午後＆夜間', 'start' => '13:00:00', 'finish' => '21:00:00', 'price' => 24000, 'extend' => 3000,
        ]);

        FramePrice::create([
          'venue_id' => $value->id, 'frame' => '終日', 'start' => '10:00:00', 'finish' => '21:00:00', 'price' => 27000, 'extend' => 3000,
        ]);
      } elseif ($key === 14) {
        FramePrice::create([
          'venue_id' => $value->id, 'frame' => '午前', 'start' => '10:00:00', 'finish' => '12:00:00', 'price' => 50000, 'extend' => 20000,
        ]);

        FramePrice::create([
          'venue_id' => $value->id, 'frame' => '午後', 'start' => '13:00:00', 'finish' => '17:00:00', 'price' => 80000, 'extend' => 20000,
        ]);

        FramePrice::create([
          'venue_id' => $value->id, 'frame' => '夜間', 'start' => '18:00:00', 'finish' => '21:00:00', 'price' => 80000, 'extend' => 20000,
        ]);

        FramePrice::create([
          'venue_id' => $value->id, 'frame' => '午前＆午後', 'start' => '10:00:00', 'finish' => '17:00:00', 'price' => 120000, 'extend' => 20000,
        ]);

        FramePrice::create([
          'venue_id' => $value->id, 'frame' => '午後＆夜間', 'start' => '13:00:00', 'finish' => '21:00:00', 'price' => 120000, 'extend' => 20000,
        ]);

        FramePrice::create([
          'venue_id' => $value->id, 'frame' => '終日', 'start' => '10:00:00', 'finish' => '21:00:00', 'price' => 150000, 'extend' => 20000,
        ]);
      } elseif ($key === 15) {
        FramePrice::create([
          'venue_id' => $value->id, 'frame' => '午前', 'start' => '10:00:00', 'finish' => '12:00:00', 'price' => 75000, 'extend' => 90000,
        ]);

        FramePrice::create([
          'venue_id' => $value->id, 'frame' => '午後', 'start' => '13:00:00', 'finish' => '17:00:00', 'price' => 255000, 'extend' => 90000,
        ]);

        FramePrice::create([
          'venue_id' => $value->id, 'frame' => '夜間', 'start' => '18:00:00', 'finish' => '21:00:00', 'price' => 255000, 'extend' => 90000,
        ]);

        FramePrice::create([
          'venue_id' => $value->id, 'frame' => '午前＆午後', 'start' => '10:00:00', 'finish' => '17:00:00', 'price' => 300000, 'extend' => 90000,
        ]);

        FramePrice::create([
          'venue_id' => $value->id, 'frame' => '午後＆夜間', 'start' => '13:00:00', 'finish' => '21:00:00', 'price' => 450000, 'extend' => 90000,
        ]);

        FramePrice::create([
          'venue_id' => $value->id, 'frame' => '終日', 'start' => '10:00:00', 'finish' => '21:00:00', 'price' => 525000, 'extend' => 90000,
        ]);
      }
    }
  }
}
