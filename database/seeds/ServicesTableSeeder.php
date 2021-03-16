<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;


class ServicesTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    // DB::table('services')->truncate();
    DB::table('services')->insert([
      [
        'item' => '領収書発行',
        'price' => 200,
        'created_at' => Carbon::now(),
      ],
      [
        'item' => '鍵レンタル',
        'price' => 500,
        'created_at' => Carbon::now(),
      ],
      [
        'item' => 'プロジェクター設置',
        'price' => 2000,
        'created_at' => Carbon::now(),
      ],
      [
        'item' => 'DVDプレイヤー設置',
        'price' => 2000,
        'created_at' => Carbon::now(),
      ],
    ]);
    factory(\App\Models\Service::class, 40)->create();
  }
}
