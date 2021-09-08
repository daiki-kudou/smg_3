<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Models\Equipment;



class EquipmentTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    // DB::table('equipments')->truncate();
    Equipment::create(['item' => '次亜塩素酸水専用・超音波加湿器＋スプレーボトル', 'price' => '1000', 'stock' => '1', 'remark' => '',]);
    Equipment::create(['item' => '【追加】次亜塩素酸水専用・超音波加湿器 1台まで', 'price' => '500', 'stock' => '1', 'remark' => '',]);
    Equipment::create(['item' => '赤外線温度計（非接触型体温計）＋スプレーボトル', 'price' => '1000', 'stock' => '1', 'remark' => '',]);
    Equipment::create(['item' => 'ホワイトボード（幅120㎝）', 'price' => '1000', 'stock' => '1', 'remark' => '',]);
    Equipment::create(['item' => 'スピーカー', 'price' => '2000', 'stock' => '1', 'remark' => '',]);
    Equipment::create(['item' => '有線マイク', 'price' => '1000', 'stock' => '1', 'remark' => '',]);
    Equipment::create(['item' => '無線マイク', 'price' => '2500', 'stock' => '1', 'remark' => '',]);
    Equipment::create(['item' => 'レーザーポインター', 'price' => '1000', 'stock' => '1', 'remark' => '',]);
    Equipment::create(['item' => 'iphone(Lightning)⇔VGA変換ケーブル', 'price' => '1000', 'stock' => '1', 'remark' => '',]);
    Equipment::create(['item' => 'DVDプレイヤー', 'price' => '2000', 'stock' => '1', 'remark' => '',]);
    Equipment::create(['item' => 'CDプレイヤー', 'price' => '1000', 'stock' => '1', 'remark' => '',]);
    Equipment::create(['item' => '持ち運びパーテーション', 'price' => '1000', 'stock' => '1', 'remark' => '',]);
    Equipment::create(['item' => '卓球台セット', 'price' => '1000', 'stock' => '1', 'remark' => '在庫は、四ツ橋・サンワールドビル1号室のみ',]);
    Equipment::create(['item' => 'プロジェクター', 'price' => '3000', 'stock' => '1', 'remark' => '本町・センタービル専用',]);
    Equipment::create(['item' => 'スクリーン', 'price' => '1000', 'stock' => '1', 'remark' => '本町・センタービル専用',]);
    Equipment::create(['item' => 'ホワイトボード（幅120㎝）', 'price' => '1000', 'stock' => '1', 'remark' => '本町・センタービル専用',]);
    Equipment::create(['item' => '無線マイク', 'price' => '2000', 'stock' => '1', 'remark' => '本町・センタービル専用',]);
    Equipment::create(['item' => '既存パーテーションの移動', 'price' => '2000', 'stock' => '1', 'remark' => '本町・センタービル専用',]);
    Equipment::create(['item' => '有線マイク ※音響HGプランでのご利用が前提です', 'price' => '3000', 'stock' => '1', 'remark' => '音響HG会場専用',]);
    Equipment::create(['item' => '無線マイク ※音響HGプランでのご利用が前提です', 'price' => '3000', 'stock' => '1', 'remark' => '音響HG会場専用',]);
    Equipment::create(['item' => 'ホワイトボード（幅120㎝） ※音響HGプランでのご利用が前提です', 'price' => '2500', 'stock' => '1', 'remark' => '音響HG会場専用',]);
    Equipment::create(['item' => 'プロジェクター&スクリーン', 'price' => '15000', 'stock' => '1', 'remark' => '心斎橋・大成閣専用',]);
    Equipment::create(['item' => '机変更(円卓→長卓 / 1台あたり）', 'price' => '1500', 'stock' => '1', 'remark' => '心斎橋・大成閣専用',]);
    Equipment::create(['item' => '長卓搬入出', 'price' => '5000', 'stock' => '1', 'remark' => '心斎橋・大成閣専用',]);
    Equipment::create(['item' => '延長コード（約5ｍ）', 'price' => '500', 'stock' => '1', 'remark' => '2本目までは無料。3本目以降。',]);
  }
}
