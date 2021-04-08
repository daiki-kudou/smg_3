<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;


class EquipmentTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    // factory(\App\Models\Equipment::class, 30)->create();
    DB::table('equipments')->truncate();
    DB::table('equipments')->insert([
      [
        'item' => '有線マイク',
        'price' => 3000,
        'stock' => 10,
        'created_at' => Carbon::now(),
      ],
      [
        'item' => '無線マイク',
        'price' => 3000,
        'stock' => 10,
        'created_at' => Carbon::now(),
      ],
      [
        'item' => '次亜塩素酸水専用・超音波加湿器＋スプレーボトル',
        'price' => 1000,
        'stock' => 10,
        'created_at' => Carbon::now(),
      ],
      [
        'item' => '【追加】次亜塩素酸水専用・超音波加湿器',
        'price' => 500,
        'stock' => 10,
        'created_at' => Carbon::now(),
      ],
      [
        'item'     => '赤外線温度計（非接触型体温計）＋スプレーボトル',
        'price' => 1000,
        'stock' => 10,
        'created_at' => Carbon::now(),
      ],
      [
        'item' => 'ホワイトボード（幅120㎝）',
        'price' => 2500,
        'stock' => 10,
        'created_at' => Carbon::now(),
      ],
      [
        'item' => 'プロジェクター',
        'price' => 3000,
        'stock' => 10,
        'created_at' => Carbon::now(),
      ],
      [
        'item' => '既存パーテーションの移動',
        'price' => 2000,
        'stock' => 10,
        'created_at' => Carbon::now(),
      ],
      [
        'item' => 'レーザーポインター',
        'price' => 1000,
        'stock' => 10,
        'created_at' => Carbon::now(),
      ],
      [
        'item' => 'iphone(Lightning)⇔VGA変換ケーブル',
        'price' => 1000,
        'stock' => 10,
        'created_at' => Carbon::now(),
      ],
      [
        'item' => 'iphone(Lightning)DVDプレイヤー',
        'price' => 2000,
        'stock' => 10,
        'created_at' => Carbon::now(),
      ],
      [
        'item' => 'CDプレイヤー',
        'price' => 1000,
        'stock' => 10,
        'created_at' => Carbon::now(),
      ],
      [
        'item' => '持ち運びパーテーション',
        'price' => 1000,
        'stock' => 10,
        'created_at' => Carbon::now(),
      ],
      [
        'item' => '卓球台セット',
        'price' => 1000,
        'stock'  => 10,
        'created_at' => Carbon::now(),
      ],
    ]);
    factory(\App\Models\Equipment::class, 330)->create();
  }
}
