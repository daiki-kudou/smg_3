<?php

use Illuminate\Database\Seeder;

use App\Models\Venue;

class Frame_priceTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $venue = Venue::find(1);
    $venue->frame_prices()->create([
      // 'venue_id' => 1,
      'frame' => '午前',
      'start' => '10:00:00',
      'finish' => '12:00:00',
      'price' => 15000,
      'extend' => 5000,
    ]);
    $venue->frame_prices()->create([
      // 'venue_id' => $venue->id,
      'frame' => '午後',
      'start' => '13:00:00',
      'finish' => '17:00:00',
      'price' => 30000,
      'extend' => 5000,
    ]);
    $venue->frame_prices()->create([
      // 'venue_id' => $venue->id,
      'frame' => '夜間',
      'start' => '18:00:00',
      'finish' => '23:00:00',
      'price' => 15000,
      'extend' => 5000,
    ]);
    $venue->frame_prices()->create([
      // 'venue_id' => $venue->id,
      'frame' => '午前＆午後',
      'start' => '10:00:00',
      'finish' => '17:00:00',
      'price' => 36000,
      'extend' => 5000,
    ]);
    $venue->frame_prices()->create([
      // 'venue_id' => $venue->id,
      'frame' => '午後＆夜間',
      'start' => '13:00:00',
      'finish' => '21:00:00',
      'price' => 36000,
      'extend' => 5000,
    ]);
    $venue->frame_prices()->create([
      // 'venue_id' => $venue->id,
      'frame' => '終日',
      'start' => '10:00:00',
      'finish' => '21:00:00',
      'price' => 42000,
      'extend' => 5000,
    ]);




    $venue2 = Venue::find(2);
    $venue2->frame_prices()->create([
      // 'venue_id' => 2,
      'frame' => '午前',
      'start' => '10:00:00',
      'finish' => '12:00:00',
      'price' => 17000,
      'extend' => 6000,
    ]);
    $venue2->frame_prices()->create([
      // 'venue_id' => $venue2->id,
      'frame' => '午後',
      'start' => '13:00:00',
      'finish' => '17:00:00',
      'price' => 36000,
      'extend' => 6000,
    ]);
    $venue2->frame_prices()->create([
      // 'venue_id' => $venue2->id,
      'frame' => '夜間',
      'start' => '18:00:00',
      'finish' => '23:00:00',
      'price' => 17000,
      'extend' => 6000,
    ]);
    $venue2->frame_prices()->create([
      // 'venue_id' => $venue2->id,
      'frame' => '午前＆午後',
      'start' => '10:00:00',
      'finish' => '17:00:00',
      'price' => 42000,
      'extend' => 6000,
    ]);
    $venue2->frame_prices()->create([
      // 'venue_id' => $venue2->id,
      'frame' => '午後＆夜間',
      'start' => '13:00:00',
      'finish' => '21:00:00',
      'price' => 42000,
      'extend' => 6000,
    ]);
    $venue2->frame_prices()->create([
      // 'venue_id' => $venue2->id,
      'frame' => '終日',
      'start' => '10:00:00',
      'finish' => '21:00:00',
      'price' => 50000,
      'extend' => 6000,
    ]);




    $venue3 = Venue::find(3);
    $venue3->frame_prices()->create([
      // 'venue_id' => 3,
      'frame' => '午前',
      'start' => '10:00:00',
      'finish' => '12:00:00',
      'price' => 17000,
      'extend' => 6000,
    ]);
    $venue3->frame_prices()->create([
      // 'venue_id' => $venue3->id,
      'frame' => '午後',
      'start' => '13:00:00',
      'finish' => '17:00:00',
      'price' => 36000,
      'extend' => 6000,
    ]);
    $venue3->frame_prices()->create([
      // 'venue_id' => $venue3->id,
      'frame' => '夜間',
      'start' => '18:00:00',
      'finish' => '23:00:00',
      'price' => 17000,
      'extend' => 6000,
    ]);
    $venue3->frame_prices()->create([
      // 'venue_id' => $venue3->id,
      'frame' => '午前＆午後',
      'start' => '10:00:00',
      'finish' => '17:00:00',
      'price' => 42000,
      'extend' => 6000,
    ]);
    $venue3->frame_prices()->create([
      // 'venue_id' => $venue3->id,
      'frame' => '午後＆夜間',
      'start' => '13:00:00',
      'finish' => '21:00:00',
      'price' => 42000,
      'extend' => 6000,
    ]);
    $venue3->frame_prices()->create([
      // 'venue_id' => $venue3->id,
      'frame' => '終日',
      'start' => '10:00:00',
      'finish' => '21:00:00',
      'price' => 50000,
      'extend' => 6000,
    ]);
  }
}
