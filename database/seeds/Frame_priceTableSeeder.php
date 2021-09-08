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

    FramePrice::create(['venue_id' => '1', 'frame' => '午前', 'start' => '10:00:00', 'finish' => '12:00:00', 'price' => '15000', 'extend' => '5000',]);
    FramePrice::create(['venue_id' => '1', 'frame' => '午後', 'start' => '13:00:00', 'finish' => '17:00:00', 'price' => '30000', 'extend' => '5000',]);
    FramePrice::create(['venue_id' => '1', 'frame' => '夜間', 'start' => '18:00:00', 'finish' => '23:00:00', 'price' => '15000', 'extend' => '5000',]);
    FramePrice::create(['venue_id' => '1', 'frame' => '午前＆午後', 'start' => '10:00:00', 'finish' => '17:00:00', 'price' => '36000', 'extend' => '5000',]);
    FramePrice::create(['venue_id' => '1', 'frame' => '午後＆夜間', 'start' => '13:00:00', 'finish' => '23:00:00', 'price' => '36000', 'extend' => '5000',]);
    FramePrice::create(['venue_id' => '1', 'frame' => '終日', 'start' => '10:00:00', 'finish' => '23:00:00', 'price' => '42000', 'extend' => '5000',]);





    FramePrice::create(['venue_id' => '2', 'frame' => '午前', 'start' => '10:00:00', 'finish' => '12:00:00', 'price' => '15000', 'extend' => '5000',]);
    FramePrice::create(['venue_id' => '2', 'frame' => '午後', 'start' => '13:00:00', 'finish' => '17:00:00', 'price' => '30000', 'extend' => '5000',]);
    FramePrice::create(['venue_id' => '2', 'frame' => '夜間', 'start' => '18:00:00', 'finish' => '23:00:00', 'price' => '15000', 'extend' => '5000',]);
    FramePrice::create(['venue_id' => '2', 'frame' => '午前＆午後', 'start' => '10:00:00', 'finish' => '17:00:00', 'price' => '36000', 'extend' => '5000',]);
    FramePrice::create(['venue_id' => '2', 'frame' => '午後＆夜間', 'start' => '13:00:00', 'finish' => '23:00:00', 'price' => '36000', 'extend' => '5000',]);
    FramePrice::create(['venue_id' => '2', 'frame' => '終日', 'start' => '10:00:00', 'finish' => '23:00:00', 'price' => '42000', 'extend' => '5000',]);





    FramePrice::create(['venue_id' => '3', 'frame' => '午前', 'start' => '10:00:00', 'finish' => '12:00:00', 'price' => '17000', 'extend' => '6000',]);
    FramePrice::create(['venue_id' => '3', 'frame' => '午後', 'start' => '13:00:00', 'finish' => '17:00:00', 'price' => '36000', 'extend' => '6000',]);
    FramePrice::create(['venue_id' => '3', 'frame' => '夜間', 'start' => '18:00:00', 'finish' => '23:00:00', 'price' => '17000', 'extend' => '6000',]);
    FramePrice::create(['venue_id' => '3', 'frame' => '午前＆午後', 'start' => '10:00:00', 'finish' => '17:00:00', 'price' => '42000', 'extend' => '6000',]);
    FramePrice::create(['venue_id' => '3', 'frame' => '午後＆夜間', 'start' => '13:00:00', 'finish' => '23:00:00', 'price' => '42000', 'extend' => '6000',]);
    FramePrice::create(['venue_id' => '3', 'frame' => '終日', 'start' => '10:00:00', 'finish' => '23:00:00', 'price' => '50000', 'extend' => '6000',]);





    FramePrice::create(['venue_id' => '4', 'frame' => '午前', 'start' => '10:00:00', 'finish' => '12:00:00', 'price' => '12000', 'extend' => '3000',]);
    FramePrice::create(['venue_id' => '4', 'frame' => '午後', 'start' => '13:00:00', 'finish' => '17:00:00', 'price' => '24000', 'extend' => '3000',]);
    FramePrice::create(['venue_id' => '4', 'frame' => '夜間', 'start' => '18:00:00', 'finish' => '23:00:00', 'price' => '12000', 'extend' => '3000',]);
    FramePrice::create(['venue_id' => '4', 'frame' => '午前＆午後', 'start' => '10:00:00', 'finish' => '17:00:00', 'price' => '27000', 'extend' => '3000',]);
    FramePrice::create(['venue_id' => '4', 'frame' => '午後＆夜間', 'start' => '13:00:00', 'finish' => '23:00:00', 'price' => '27000', 'extend' => '3000',]);
    FramePrice::create(['venue_id' => '4', 'frame' => '終日', 'start' => '10:00:00', 'finish' => '23:00:00', 'price' => '31000', 'extend' => '3000',]);





    FramePrice::create(['venue_id' => '5', 'frame' => '午前', 'start' => '10:00:00', 'finish' => '12:00:00', 'price' => '13000', 'extend' => '4000',]);
    FramePrice::create(['venue_id' => '5', 'frame' => '午後', 'start' => '13:00:00', 'finish' => '17:00:00', 'price' => '26000', 'extend' => '4000',]);
    FramePrice::create(['venue_id' => '5', 'frame' => '夜間', 'start' => '18:00:00', 'finish' => '23:00:00', 'price' => '13000', 'extend' => '4000',]);
    FramePrice::create(['venue_id' => '5', 'frame' => '午前＆午後', 'start' => '10:00:00', 'finish' => '17:00:00', 'price' => '30000', 'extend' => '4000',]);
    FramePrice::create(['venue_id' => '5', 'frame' => '午後＆夜間', 'start' => '13:00:00', 'finish' => '23:00:00', 'price' => '30000', 'extend' => '4000',]);
    FramePrice::create(['venue_id' => '5', 'frame' => '終日', 'start' => '10:00:00', 'finish' => '23:00:00', 'price' => '36000', 'extend' => '4000',]);





    FramePrice::create(['venue_id' => '6', 'frame' => '午前', 'start' => '10:00:00', 'finish' => '12:00:00', 'price' => '12000', 'extend' => '3000',]);
    FramePrice::create(['venue_id' => '6', 'frame' => '午後', 'start' => '13:00:00', 'finish' => '17:00:00', 'price' => '24000', 'extend' => '3000',]);
    FramePrice::create(['venue_id' => '6', 'frame' => '夜間', 'start' => '18:00:00', 'finish' => '23:00:00', 'price' => '12000', 'extend' => '3000',]);
    FramePrice::create(['venue_id' => '6', 'frame' => '午前＆午後', 'start' => '10:00:00', 'finish' => '17:00:00', 'price' => '27000', 'extend' => '3000',]);
    FramePrice::create(['venue_id' => '6', 'frame' => '午後＆夜間', 'start' => '13:00:00', 'finish' => '23:00:00', 'price' => '27000', 'extend' => '3000',]);
    FramePrice::create(['venue_id' => '6', 'frame' => '終日', 'start' => '10:00:00', 'finish' => '23:00:00', 'price' => '31000', 'extend' => '3000',]);





    FramePrice::create(['venue_id' => '7', 'frame' => '午前', 'start' => '10:00:00', 'finish' => '12:00:00', 'price' => '13000', 'extend' => '4000',]);
    FramePrice::create(['venue_id' => '7', 'frame' => '午後', 'start' => '13:00:00', 'finish' => '17:00:00', 'price' => '26000', 'extend' => '4000',]);
    FramePrice::create(['venue_id' => '7', 'frame' => '夜間', 'start' => '18:00:00', 'finish' => '23:00:00', 'price' => '13000', 'extend' => '4000',]);
    FramePrice::create(['venue_id' => '7', 'frame' => '午前＆午後', 'start' => '10:00:00', 'finish' => '17:00:00', 'price' => '30000', 'extend' => '4000',]);
    FramePrice::create(['venue_id' => '7', 'frame' => '午後＆夜間', 'start' => '13:00:00', 'finish' => '23:00:00', 'price' => '30000', 'extend' => '4000',]);
    FramePrice::create(['venue_id' => '7', 'frame' => '終日', 'start' => '10:00:00', 'finish' => '23:00:00', 'price' => '36000', 'extend' => '4000',]);





    FramePrice::create(['venue_id' => '8', 'frame' => '午前', 'start' => '10:00:00', 'finish' => '12:00:00', 'price' => '12000', 'extend' => '3000',]);
    FramePrice::create(['venue_id' => '8', 'frame' => '午後', 'start' => '13:00:00', 'finish' => '17:00:00', 'price' => '24000', 'extend' => '3000',]);
    FramePrice::create(['venue_id' => '8', 'frame' => '夜間', 'start' => '18:00:00', 'finish' => '23:00:00', 'price' => '12000', 'extend' => '3000',]);
    FramePrice::create(['venue_id' => '8', 'frame' => '午前＆午後', 'start' => '10:00:00', 'finish' => '17:00:00', 'price' => '27000', 'extend' => '3000',]);
    FramePrice::create(['venue_id' => '8', 'frame' => '午後＆夜間', 'start' => '13:00:00', 'finish' => '23:00:00', 'price' => '27000', 'extend' => '3000',]);
    FramePrice::create(['venue_id' => '8', 'frame' => '終日', 'start' => '10:00:00', 'finish' => '23:00:00', 'price' => '31000', 'extend' => '3000',]);





    FramePrice::create(['venue_id' => '9', 'frame' => '午前', 'start' => '10:00:00', 'finish' => '12:00:00', 'price' => '18500', 'extend' => '6500',]);
    FramePrice::create(['venue_id' => '9', 'frame' => '午後', 'start' => '13:00:00', 'finish' => '17:00:00', 'price' => '36500', 'extend' => '6500',]);
    FramePrice::create(['venue_id' => '9', 'frame' => '夜間', 'start' => '18:00:00', 'finish' => '23:00:00', 'price' => '18500', 'extend' => '6500',]);
    FramePrice::create(['venue_id' => '9', 'frame' => '午前＆午後', 'start' => '10:00:00', 'finish' => '17:00:00', 'price' => '43500', 'extend' => '6500',]);
    FramePrice::create(['venue_id' => '9', 'frame' => '午後＆夜間', 'start' => '13:00:00', 'finish' => '23:00:00', 'price' => '43500', 'extend' => '6500',]);
    FramePrice::create(['venue_id' => '9', 'frame' => '終日', 'start' => '10:00:00', 'finish' => '23:00:00', 'price' => '52000', 'extend' => '6500',]);





    FramePrice::create(['venue_id' => '10', 'frame' => '午前', 'start' => '10:00:00', 'finish' => '12:00:00', 'price' => '12000', 'extend' => '5500',]);
    FramePrice::create(['venue_id' => '10', 'frame' => '午後', 'start' => '13:00:00', 'finish' => '17:00:00', 'price' => '27000', 'extend' => '5500',]);
    FramePrice::create(['venue_id' => '10', 'frame' => '夜間', 'start' => '18:00:00', 'finish' => '20:00:00', 'price' => '10000', 'extend' => '5500',]);
    FramePrice::create(['venue_id' => '10', 'frame' => '午前＆午後', 'start' => '10:00:00', 'finish' => '17:00:00', 'price' => '36000', 'extend' => '5500',]);
    FramePrice::create(['venue_id' => '10', 'frame' => '午後＆夜間', 'start' => '13:00:00', 'finish' => '20:00:00', 'price' => '36000', 'extend' => '5500',]);
    FramePrice::create(['venue_id' => '10', 'frame' => '終日', 'start' => '10:00:00', 'finish' => '20:00:00', 'price' => '44000', 'extend' => '5500',]);





    FramePrice::create(['venue_id' => '11', 'frame' => '午前', 'start' => '10:00:00', 'finish' => '12:00:00', 'price' => '10000', 'extend' => '4000',]);
    FramePrice::create(['venue_id' => '11', 'frame' => '午後', 'start' => '13:00:00', 'finish' => '17:00:00', 'price' => '25000', 'extend' => '4000',]);
    FramePrice::create(['venue_id' => '11', 'frame' => '夜間', 'start' => '18:00:00', 'finish' => '20:00:00', 'price' => '9500', 'extend' => '4000',]);
    FramePrice::create(['venue_id' => '11', 'frame' => '午前＆午後', 'start' => '10:00:00', 'finish' => '17:00:00', 'price' => '32000', 'extend' => '4000',]);
    FramePrice::create(['venue_id' => '11', 'frame' => '午後＆夜間', 'start' => '13:00:00', 'finish' => '20:00:00', 'price' => '32000', 'extend' => '4000',]);
    FramePrice::create(['venue_id' => '11', 'frame' => '終日', 'start' => '10:00:00', 'finish' => '20:00:00', 'price' => '39500', 'extend' => '4000',]);
















    FramePrice::create(['venue_id' => '13', 'frame' => '午前', 'start' => '10:00:00', 'finish' => '12:00:00', 'price' => '8000', 'extend' => '3000',]);
    FramePrice::create(['venue_id' => '13', 'frame' => '午後', 'start' => '13:00:00', 'finish' => '17:00:00', 'price' => '15000', 'extend' => '3000',]);
    FramePrice::create(['venue_id' => '13', 'frame' => '午前＆午後', 'start' => '10:00:00', 'finish' => '17:00:00', 'price' => '21000', 'extend' => '3000',]);
    #N/A
    #N/A
    #N/A





    FramePrice::create(['venue_id' => '14', 'frame' => '午前', 'start' => '10:00:00', 'finish' => '12:00:00', 'price' => '18500', 'extend' => '6500',]);
    FramePrice::create(['venue_id' => '14', 'frame' => '午後', 'start' => '13:00:00', 'finish' => '17:00:00', 'price' => '36500', 'extend' => '6500',]);
    FramePrice::create(['venue_id' => '14', 'frame' => '夜間', 'start' => '18:00:00', 'finish' => '23:00:00', 'price' => '18500', 'extend' => '6500',]);
    FramePrice::create(['venue_id' => '14', 'frame' => '午前＆午後', 'start' => '10:00:00', 'finish' => '17:00:00', 'price' => '43500', 'extend' => '6500',]);
    FramePrice::create(['venue_id' => '14', 'frame' => '午後＆夜間', 'start' => '13:00:00', 'finish' => '23:00:00', 'price' => '43500', 'extend' => '6500',]);
    FramePrice::create(['venue_id' => '14', 'frame' => '終日', 'start' => '10:00:00', 'finish' => '23:00:00', 'price' => '52000', 'extend' => '6500',]);





    FramePrice::create(['venue_id' => '15', 'frame' => '午前', 'start' => '10:00:00', 'finish' => '12:00:00', 'price' => '12000', 'extend' => '3000',]);
    FramePrice::create(['venue_id' => '15', 'frame' => '午後', 'start' => '13:00:00', 'finish' => '17:00:00', 'price' => '21000', 'extend' => '3000',]);
    FramePrice::create(['venue_id' => '15', 'frame' => '夜間', 'start' => '18:00:00', 'finish' => '23:00:00', 'price' => '12000', 'extend' => '3000',]);
    FramePrice::create(['venue_id' => '15', 'frame' => '午前＆午後', 'start' => '10:00:00', 'finish' => '17:00:00', 'price' => '24000', 'extend' => '3000',]);
    FramePrice::create(['venue_id' => '15', 'frame' => '午後＆夜間', 'start' => '13:00:00', 'finish' => '23:00:00', 'price' => '24000', 'extend' => '3000',]);
    FramePrice::create(['venue_id' => '15', 'frame' => '終日', 'start' => '10:00:00', 'finish' => '23:00:00', 'price' => '27000', 'extend' => '3000',]);





    FramePrice::create(['venue_id' => '16', 'frame' => '午前', 'start' => '10:00:00', 'finish' => '12:00:00', 'price' => '50000', 'extend' => '20000',]);
    FramePrice::create(['venue_id' => '16', 'frame' => '午後', 'start' => '13:00:00', 'finish' => '17:00:00', 'price' => '80000', 'extend' => '20000',]);
    FramePrice::create(['venue_id' => '16', 'frame' => '夜間', 'start' => '18:00:00', 'finish' => '23:00:00', 'price' => '80000', 'extend' => '20000',]);
    FramePrice::create(['venue_id' => '16', 'frame' => '午前＆午後', 'start' => '10:00:00', 'finish' => '17:00:00', 'price' => '120000', 'extend' => '20000',]);
    FramePrice::create(['venue_id' => '16', 'frame' => '午後＆夜間', 'start' => '13:00:00', 'finish' => '23:00:00', 'price' => '120000', 'extend' => '20000',]);
    FramePrice::create(['venue_id' => '16', 'frame' => '終日', 'start' => '10:00:00', 'finish' => '23:00:00', 'price' => '150000', 'extend' => '20000',]);





    FramePrice::create(['venue_id' => '17', 'frame' => '午前', 'start' => '10:00:00', 'finish' => '12:00:00', 'price' => '75000', 'extend' => '90000',]);
    FramePrice::create(['venue_id' => '17', 'frame' => '午後', 'start' => '13:00:00', 'finish' => '17:00:00', 'price' => '255000', 'extend' => '90000',]);
    FramePrice::create(['venue_id' => '17', 'frame' => '夜間', 'start' => '18:00:00', 'finish' => '23:00:00', 'price' => '255000', 'extend' => '90000',]);
    FramePrice::create(['venue_id' => '17', 'frame' => '午前＆午後', 'start' => '10:00:00', 'finish' => '17:00:00', 'price' => '300000', 'extend' => '90000',]);
    FramePrice::create(['venue_id' => '17', 'frame' => '午後＆夜間', 'start' => '13:00:00', 'finish' => '23:00:00', 'price' => '450000', 'extend' => '90000',]);
    FramePrice::create(['venue_id' => '17', 'frame' => '終日', 'start' => '10:00:00', 'finish' => '23:00:00', 'price' => '525000', 'extend' => '90000',]);





    FramePrice::create(['venue_id' => '18', 'frame' => '午前', 'start' => '10:00:00', 'finish' => '12:00:00', 'price' => '10000', 'extend' => '5000',]);
    FramePrice::create(['venue_id' => '18', 'frame' => '午後', 'start' => '13:00:00', 'finish' => '17:00:00', 'price' => '10000', 'extend' => '5000',]);
    FramePrice::create(['venue_id' => '18', 'frame' => '夜間', 'start' => '18:00:00', 'finish' => '23:00:00', 'price' => '10000', 'extend' => '5000',]);
    FramePrice::create(['venue_id' => '18', 'frame' => '午前＆午後', 'start' => '10:00:00', 'finish' => '17:00:00', 'price' => '20000', 'extend' => '5000',]);
    FramePrice::create(['venue_id' => '18', 'frame' => '午後＆夜間', 'start' => '13:00:00', 'finish' => '23:00:00', 'price' => '20000', 'extend' => '5000',]);
    FramePrice::create(['venue_id' => '18', 'frame' => '終日', 'start' => '10:00:00', 'finish' => '23:00:00', 'price' => '30000', 'extend' => '5000',]);
  }
}
