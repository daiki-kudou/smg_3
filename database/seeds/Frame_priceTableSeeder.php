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
    FramePrice::create([
      'venue_id' => 1,
      'frame' => '午前',
      'start' => '10:00:00',
      'finish' => '12:00:00',
      'price' => 15000,
      'extend' => 5000,
    ]);

    FramePrice::create([
      'venue_id' => 1,
      'frame' => '午後',
      'start' => '13:00:00',
      'finish' => '17:00:00',
      'price' => 30000,
      'extend' => 5000,
    ]);

    FramePrice::create([
      'venue_id' => 1,
      'frame' => '夜間',
      'start' => '18:00:00',
      'finish' => '23:00:00',
      'price' => 15000,
      'extend' => 5000,
    ]);

    FramePrice::create([
      'venue_id' => 1,
      'frame' => '午前＆午後',
      'start' => '10:00:00',
      'finish' => '17:00:00',
      'price' => 36000,
      'extend' => 5000,
    ]);

    FramePrice::create([
      'venue_id' => 1,
      'frame' => '午後＆夜間',
      'start' => '13:00:00',
      'finish' => '21:00:00',
      'price' => 36000,
      'extend' => 5000,
    ]);

    FramePrice::create([
      'venue_id' => 1,
      'frame' => '終日',
      'start' => '10:00:00',
      'finish' => '21:00:00',
      'price' => 42000,
      'extend' => 5000,
    ]);







    FramePrice::create([
      'venue_id' => 2,
      'frame' => '午前',
      'start' => '10:00:00',
      'finish' => '12:00:00',
      'price' => 17000,
      'extend' => 6000,
    ]);

    FramePrice::create([
      'venue_id' => 2,
      'frame' => '午後',
      'start' => '13:00:00',
      'finish' => '17:00:00',
      'price' => 36000,
      'extend' => 6000,
    ]);

    FramePrice::create([
      'venue_id' => 2,
      'frame' => '夜間',
      'start' => '18:00:00',
      'finish' => '23:00:00',
      'price' => 17000,
      'extend' => 6000,
    ]);

    FramePrice::create([
      'venue_id' => 2,
      'frame' => '午前＆午後',
      'start' => '10:00:00',
      'finish' => '17:00:00',
      'price' => 42000,
      'extend' => 6000,
    ]);

    FramePrice::create([
      'venue_id' => 2,
      'frame' => '午後＆夜間',
      'start' => '13:00:00',
      'finish' => '21:00:00',
      'price' => 42000,
      'extend' => 6000,
    ]);

    FramePrice::create([
      'venue_id' => 2,
      'frame' => '終日',
      'start' => '10:00:00',
      'finish' => '21:00:00',
      'price' => 50000,
      'extend' => 6000,
    ]);








    FramePrice::create([
      'venue_id' => 3,
      'frame' => '午前',
      'start' => '10:00:00',
      'finish' => '12:00:00',
      'price' => 17000,
      'extend' => 6000,
    ]);

    FramePrice::create([
      'venue_id' => 3,
      'frame' => '午後',
      'start' => '13:00:00',
      'finish' => '17:00:00',
      'price' => 36000,
      'extend' => 6000,
    ]);

    FramePrice::create([
      'venue_id' => 3,
      'frame' => '夜間',
      'start' => '18:00:00',
      'finish' => '23:00:00',
      'price' => 17000,
      'extend' => 6000,
    ]);

    FramePrice::create([
      'venue_id' => 3,
      'frame' => '午前＆午後',
      'start' => '10:00:00',
      'finish' => '17:00:00',
      'price' => 42000,
      'extend' => 6000,
    ]);

    FramePrice::create([
      'venue_id' => 3,
      'frame' => '午後＆夜間',
      'start' => '13:00:00',
      'finish' => '21:00:00',
      'price' => 42000,
      'extend' => 6000,
    ]);

    FramePrice::create([
      'venue_id' => 3,
      'frame' => '終日',
      'start' => '10:00:00',
      'finish' => '21:00:00',
      'price' => 50000,
      'extend' => 6000,
    ]);
  }
}
