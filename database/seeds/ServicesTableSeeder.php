<?php

use Illuminate\Database\Seeder;

class ServicesTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    // factory(\App\Models\Service::class, 30)->create();
    // DB::table('services')->truncate();
    DB::table('services')->insert([
      [
        'item' => '領収書発行',
        'price' => 200,
      ],
      [
        'item' => '鍵レンタル',
        'price' => 500,
      ],
      [
        'item' => 'プロジェクター設置',
        'price' => 2000,
      ],
      [
        'item' => 'DVDプレイヤー設置',
        'price' => 2000,
      ],
    ]);
  }
}
