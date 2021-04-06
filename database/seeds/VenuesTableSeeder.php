<?php

use Illuminate\Database\Seeder;

use App\Models\Venue;


class VenuesTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    Venue::create([
      'alliance_flag' => 0,
      'name_area' => '四ツ橋',
      'name_bldg' => 'サンワールドビル',
      'name_venue' => '1号室',
      'size1' => 18,
      'size2' => 50,
      'capacity' => 20,
      'eat_in_flag' => 1,
      'post_code' => 'test',
      'address1' => 'test',
      'address2' => 'test',
      'address3' => 'test',
      'luggage_flag' => 1,
      'luggage_post_code' => 'test',
      'luggage_address1' => 'test',
      'luggage_address2' => 'test',
      'luggage_address3' => 'test',
      'luggage_name' => 'test',
      'luggage_tel' => 'test',
      'smg_url' => 'https://osaka-conference.com/rental/',
      'layout' => 1,
      'layout_prepare' => 5000,
      'layout_clean' => 8000
    ]);

    Venue::create([
      'alliance_flag' => 0,
      'name_area' => '四ツ橋',
      'name_bldg' => 'サンワールドビル',
      'name_venue' => '2号室(音響HG)',
      'size1' => 18,
      'size2' => 50,
      'capacity' => 20,
      'eat_in_flag' => 1,
      'post_code' => 'test',
      'address1' => 'test',
      'address2' => 'test',
      'address3' => 'test',
      'luggage_flag' => 1,
      'luggage_post_code' => 'test',
      'luggage_address1' => 'test',
      'luggage_address2' => 'test',
      'luggage_address3' => 'test',
      'luggage_name' => 'test',
      'luggage_tel' => 'test',
      'smg_url' => 'https://osaka-conference.com/rental/',
      'layout' => 1,
      'layout_prepare' => 5000,
      'layout_clean' => 8000
    ]);

    Venue::create([
      'alliance_flag' => 0,
      'name_area' => 'トリックスター',
      'name_bldg' => 'We Work',
      'name_venue' => '執務室',
      'size1' => 18,
      'size2' => 50,
      'capacity' => 20,
      'eat_in_flag' => 1,
      'post_code' => 'test',
      'address1' => 'test',
      'address2' => 'test',
      'address3' => 'test',
      'luggage_flag' => 1,
      'luggage_post_code' => 'test',
      'luggage_address1' => 'test',
      'luggage_address2' => 'test',
      'luggage_address3' => 'test',
      'luggage_name' => 'test',
      'luggage_tel' => 'test',
      'smg_url' => 'https://osaka-conference.com/rental/',
      'layout' => 1,
      'layout_prepare' => 5000,
      'layout_clean' => 8000
    ]);
  }
}
