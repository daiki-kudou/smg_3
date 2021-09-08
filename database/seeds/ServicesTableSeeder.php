<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Models\Service;



class ServicesTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    Service::create(['item' => '領収書発行', 'price' => '200', 'remark' => '',]);
    Service::create(['item' => '鍵レンタル', 'price' => '500', 'remark' => '',]);
    Service::create(['item' => 'プロジェクター設置', 'price' => '2000', 'remark' => '',]);
    Service::create(['item' => 'DVDプレイヤー設置', 'price' => '2000', 'remark' => '',]);
    Service::create(['item' => 'レイアウト変更', 'price' => '7000', 'remark' => '※10A',]);
    Service::create(['item' => 'レイアウト変更', 'price' => '6000', 'remark' => '※カーニー4F',]);
    Service::create(['item' => 'レイアウト変更', 'price' => '5000', 'remark' => '※近商10A、カード4F以外の近商ビル各会場',]);
  }
}
