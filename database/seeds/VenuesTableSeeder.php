<?php

use Illuminate\Database\Seeder;

use App\Models\Venue;
use Faker\Generator as Faker;


class VenuesTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run(Faker $faker)
  {
    // DB::table('venues')->truncate();

    $venue1 = Venue::create([
      'alliance_flag' => '0',
      'name_area' => '四ツ橋',
      'name_bldg' => 'サンワールドビル',
      'name_venue' => '1号室',
      'size1' => '32',
      'size2' => '108',
      'capacity' => 'スクール形式20～60名',
      'eat_in_flag' => '1',
      'post_code' => '5500014',
      'address1' => '大阪府',
      'address2' => '大阪市西区北堀江1-6-2',
      'address3' => 'サンワールドビル6F',
      'remark' => '',
      'first_name' => '',
      'last_name' => '',
      'first_name_kana' => '',
      'last_name_kana' => '',
      'person_tel' => '',
      'person_email' => '',
      'luggage_flag' => '1',
      'luggage_post_code' => '5500014',
      'luggage_address1' => '大阪府',
      'luggage_address2' => '大阪市西区北堀江1-6-2',
      'luggage_address3' => 'サンワールドビル11F',
      'luggage_name' => 'SMG貸し会議室',
      'luggage_tel' => '665566462',
      'mgmt_company' => '',
      'mgmt_tel' => '',
      'mgmt_emer_tel' => '',
      'mgmt_first_name' => '',
      'mgmt_last_name' => '',
      'mgmt_person_tel' => '',
      'mgmt_email' => '',
      'mgmt_sec_company' => '',
      'mgmt_sec_tel' => '',
      'mgmt_remark' => '',
      'smg_url' => 'https://osaka-conference.com/rental/yb-sunworld/recreation/',
      'entrance_open_time' => '',
      'backyard_open_time' => '',
      'layout' => '1',
      'layout_prepare' => '5000',
      'layout_clean' => '5000',
      'reserver_company' => '',
      'reserver_tel' => '',
      'reserver_fax' => '',
      'reserver_remark' => '',
    ]);

    $venue2 = Venue::create([
      'alliance_flag' => '0',
      'name_area' => '四ツ橋',
      'name_bldg' => 'サンワールドビル',
      'name_venue' => '2号室',
      'size1' => '31',
      'size2' => '103',
      'capacity' => 'スクール形式20～60名',
      'eat_in_flag' => '1',
      'post_code' => '5500014',
      'address1' => '大阪府',
      'address2' => '大阪市西区北堀江1-6-2',
      'address3' => 'サンワールドビル11F',
      'remark' => '',
      'first_name' => '',
      'last_name' => '',
      'first_name_kana' => '',
      'last_name_kana' => '',
      'person_tel' => '',
      'person_email' => '',
      'luggage_flag' => '1',
      'luggage_post_code' => '5500014',
      'luggage_address1' => '大阪府',
      'luggage_address2' => '大阪市西区北堀江1-6-2',
      'luggage_address3' => 'サンワールドビル11F',
      'luggage_name' => 'SMG貸し会議室',
      'luggage_tel' => '665566462',

      'mgmt_company' => '',
      'mgmt_tel' => '',
      'mgmt_emer_tel' => '',
      'mgmt_first_name' => '',
      'mgmt_last_name' => '',
      'mgmt_person_tel' => '',
      'mgmt_email' => '',
      'mgmt_sec_company' => '',
      'mgmt_sec_tel' => '',
      'mgmt_remark' => '',
      'smg_url' => 'https://osaka-conference.com/rental/yb-sunworld/6b-e/',
      'entrance_open_time' => '',
      'backyard_open_time' => '',
      'layout' => '1',
      'layout_prepare' => '5000',
      'layout_clean' => '5000',
      'reserver_company' => '',
      'reserver_tel' => '',
      'reserver_fax' => '',
      'reserver_remark' => '',
    ]);


    $venue3 = Venue::create([
      'alliance_flag' => '0',
      'name_area' => '四ツ橋',
      'name_bldg' => '近商ビル',
      'name_venue' => '10A',
      'size1' => '36',
      'size2' => '121',
      'capacity' => 'スクール形式20～90名',
      'eat_in_flag' => '1',
      'post_code' => '5500014',
      'address1' => '大阪府',
      'address2' => '大阪市西区北堀江1-1-24',
      'address3' => '近商ビル6A',
      'remark' => '',
      'first_name' => '',
      'last_name' => '',
      'first_name_kana' => '',
      'last_name_kana' => '',
      'person_tel' => '',
      'person_email' => '',
      'luggage_flag' => '1',
      'luggage_post_code' => '5500014',
      'luggage_address1' => '大阪府',
      'luggage_address2' => '大阪市西区北堀江1-1-24',
      'luggage_address3' => '近商ビル6A',
      'luggage_name' => 'SMG貸し会議室',
      'luggage_tel' => '665566462',

      'mgmt_company' => '',
      'mgmt_tel' => '',
      'mgmt_emer_tel' => '',
      'mgmt_first_name' => '',
      'mgmt_last_name' => '',
      'mgmt_person_tel' => '',
      'mgmt_email' => '',
      'mgmt_sec_company' => '',
      'mgmt_sec_tel' => '',
      'mgmt_remark' => '',
      'smg_url' => 'https://osaka-conference.com/rental/yb-kinsyo/10a/',
      'entrance_open_time' => '',
      'backyard_open_time' => '',
      'layout' => '1',
      'layout_prepare' => '7000',
      'layout_clean' => '7000',
      'reserver_company' => '',
      'reserver_tel' => '',
      'reserver_fax' => '',
      'reserver_remark' => '',
    ]);


    $venue4 = Venue::create([
      'alliance_flag' => '0',
      'name_area' => '四ツ橋',
      'name_bldg' => '近商ビル',
      'name_venue' => '10B',
      'size1' => '15',
      'size2' => '51',
      'capacity' => 'スクール形式10～38名',
      'eat_in_flag' => '1',
      'post_code' => '5500014',
      'address1' => '大阪府',
      'address2' => '大阪市西区北堀江1-1-24',
      'address3' => '近商ビル10F',
      'remark' => '',
      'first_name' => '',
      'last_name' => '',
      'first_name_kana' => '',
      'last_name_kana' => '',
      'person_tel' => '',
      'person_email' => '',
      'luggage_flag' => '1',
      'luggage_post_code' => '5500014',
      'luggage_address1' => '大阪府',
      'luggage_address2' => '大阪市西区北堀江1-1-24',
      'luggage_address3' => '近商ビル10F',
      'luggage_name' => 'SMG貸し会議室',
      'luggage_tel' => '665566462',

      'mgmt_company' => '',
      'mgmt_tel' => '',
      'mgmt_emer_tel' => '',
      'mgmt_first_name' => '',
      'mgmt_last_name' => '',
      'mgmt_person_tel' => '',
      'mgmt_email' => '',
      'mgmt_sec_company' => '',
      'mgmt_sec_tel' => '',
      'mgmt_remark' => '',
      'smg_url' => '',
      'entrance_open_time' => '',
      'backyard_open_time' => '',
      'layout' => '1',
      'layout_prepare' => '5000',
      'layout_clean' => '5000',
      'reserver_company' => '',
      'reserver_tel' => '',
      'reserver_fax' => '',
      'reserver_remark' => '',
    ]);


    $venue5 = Venue::create([
      'alliance_flag' => '0',
      'name_area' => '四ツ橋',
      'name_bldg' => '近商ビル',
      'name_venue' => '7A',
      'size1' => '22',
      'size2' => '74',
      'capacity' => 'スクール形式10～45名',
      'eat_in_flag' => '1',
      'post_code' => '5500014',
      'address1' => '大阪府',
      'address2' => '大阪市西区北堀江1-1-24',
      'address3' => '近商ビル7F',
      'remark' => '',
      'first_name' => '',
      'last_name' => '',
      'first_name_kana' => '',
      'last_name_kana' => '',
      'person_tel' => '',
      'person_email' => '',
      'luggage_flag' => '1',
      'luggage_post_code' => '5500014',
      'luggage_address1' => '大阪府',
      'luggage_address2' => '大阪市西区北堀江1-1-24',
      'luggage_address3' => '近商ビル7F',
      'luggage_name' => 'SMG貸し会議室',
      'luggage_tel' => '665566462',

      'mgmt_company' => '',
      'mgmt_tel' => '',
      'mgmt_emer_tel' => '',
      'mgmt_first_name' => '',
      'mgmt_last_name' => '',
      'mgmt_person_tel' => '',
      'mgmt_email' => '',
      'mgmt_sec_company' => '',
      'mgmt_sec_tel' => '',
      'mgmt_remark' => '',
      'smg_url' => 'https://osaka-conference.com/rental/yb-kinsyo/7a/',
      'entrance_open_time' => '',
      'backyard_open_time' => '',
      'layout' => '1',
      'layout_prepare' => '5000',
      'layout_clean' => '5000',
      'reserver_company' => '',
      'reserver_tel' => '',
      'reserver_fax' => '',
      'reserver_remark' => '',
    ]);


    $venue6 = Venue::create([
      'alliance_flag' => '0',
      'name_area' => '四ツ橋',
      'name_bldg' => '近商ビル',
      'name_venue' => '7B',
      'size1' => '15',
      'size2' => '51',
      'capacity' => 'スクール形式10～38名',
      'eat_in_flag' => '1',
      'post_code' => '5500014',
      'address1' => '大阪府',
      'address2' => '大阪市西区北堀江1-1-24',
      'address3' => '近商ビル7F',
      'remark' => '',
      'first_name' => '',
      'last_name' => '',
      'first_name_kana' => '',
      'last_name_kana' => '',
      'person_tel' => '',
      'person_email' => '',
      'luggage_flag' => '1',
      'luggage_post_code' => '5500014',
      'luggage_address1' => '大阪府',
      'luggage_address2' => '大阪市西区北堀江1-1-24',
      'luggage_address3' => '近商ビル6A',
      'luggage_name' => 'SMG貸し会議室',
      'luggage_tel' => '665566462',

      'mgmt_company' => '',
      'mgmt_tel' => '',
      'mgmt_emer_tel' => '',
      'mgmt_first_name' => '',
      'mgmt_last_name' => '',
      'mgmt_person_tel' => '',
      'mgmt_email' => '',
      'mgmt_sec_company' => '',
      'mgmt_sec_tel' => '',
      'mgmt_remark' => '',
      'smg_url' => '',
      'entrance_open_time' => '',
      'backyard_open_time' => '',
      'layout' => '1',
      'layout_prepare' => '5000',
      'layout_clean' => '5000',
      'reserver_company' => '',
      'reserver_tel' => '',
      'reserver_fax' => '',
      'reserver_remark' => '',
    ]);


    $venue7 = Venue::create([
      'alliance_flag' => '0',
      'name_area' => '四ツ橋',
      'name_bldg' => '近商ビル',
      'name_venue' => '6A',
      'size1' => '22',
      'size2' => '74',
      'capacity' => 'スクール形式10～45名',
      'eat_in_flag' => '1',
      'post_code' => '5500014',
      'address1' => '大阪府',
      'address2' => '大阪市西区北堀江1-1-24',
      'address3' => '近商ビル6F',
      'remark' => '',
      'first_name' => '',
      'last_name' => '',
      'first_name_kana' => '',
      'last_name_kana' => '',
      'person_tel' => '',
      'person_email' => '',
      'luggage_flag' => '1',
      'luggage_post_code' => '5500014',
      'luggage_address1' => '大阪府',
      'luggage_address2' => '大阪市西区北堀江1-1-24',
      'luggage_address3' => '近商ビル6A',
      'luggage_name' => 'SMG貸し会議室',
      'luggage_tel' => '665566462',

      'mgmt_company' => '',
      'mgmt_tel' => '',
      'mgmt_emer_tel' => '',
      'mgmt_first_name' => '',
      'mgmt_last_name' => '',
      'mgmt_person_tel' => '',
      'mgmt_email' => '',
      'mgmt_sec_company' => '',
      'mgmt_sec_tel' => '',
      'mgmt_remark' => '',
      'smg_url' => 'https://osaka-conference.com/rental/yb-kinsyo/6a/',
      'entrance_open_time' => '',
      'backyard_open_time' => '',
      'layout' => '1',
      'layout_prepare' => '5000',
      'layout_clean' => '5000',
      'reserver_company' => '',
      'reserver_tel' => '',
      'reserver_fax' => '',
      'reserver_remark' => '',
    ]);


    $venue8 = Venue::create([
      'alliance_flag' => '0',
      'name_area' => '四ツ橋',
      'name_bldg' => '近商ビル',
      'name_venue' => '6B',
      'size1' => '15',
      'size2' => '51',
      'capacity' => 'スクール形式10～38名',
      'eat_in_flag' => '1',
      'post_code' => '5500014',
      'address1' => '大阪府',
      'address2' => '大阪市西区北堀江1-1-24',
      'address3' => '近商ビル6Ｆ',
      'remark' => '',
      'first_name' => '',
      'last_name' => '',
      'first_name_kana' => '',
      'last_name_kana' => '',
      'person_tel' => '',
      'person_email' => '',
      'luggage_flag' => '1',
      'luggage_post_code' => '5500014',
      'luggage_address1' => '大阪府',
      'luggage_address2' => '大阪市西区北堀江1-1-24',
      'luggage_address3' => '近商ビル6A',
      'luggage_name' => 'SMG貸し会議室',
      'luggage_tel' => '665566462',

      'mgmt_company' => '',
      'mgmt_tel' => '',
      'mgmt_emer_tel' => '',
      'mgmt_first_name' => '',
      'mgmt_last_name' => '',
      'mgmt_person_tel' => '',
      'mgmt_email' => '',
      'mgmt_sec_company' => '',
      'mgmt_sec_tel' => '',
      'mgmt_remark' => '',
      'smg_url' => 'https://osaka-conference.com/rental/yb-kinsyo/6b/',
      'entrance_open_time' => '',
      'backyard_open_time' => '',
      'layout' => '1',
      'layout_prepare' => '5000',
      'layout_clean' => '5000',
      'reserver_company' => '',
      'reserver_tel' => '',
      'reserver_fax' => '',
      'reserver_remark' => '',
    ]);


    $venue9 = Venue::create([
      'alliance_flag' => '0',
      'name_area' => '本町',
      'name_bldg' => 'カーニープレイス',
      'name_venue' => '4F',
      'size1' => '31',
      'size2' => '104',
      'capacity' => 'スクール形式20～70名',
      'eat_in_flag' => '1',
      'post_code' => '5500011',
      'address1' => '大阪府',
      'address2' => '大阪市西区阿波座1-6-13',
      'address3' => 'カーニープレイス本町4F',
      'remark' => '',
      'first_name' => '',
      'last_name' => '',
      'first_name_kana' => '',
      'last_name_kana' => '',
      'person_tel' => '',
      'person_email' => '',
      'luggage_flag' => '1',
      'luggage_post_code' => '5500011',
      'luggage_address1' => '大阪府',
      'luggage_address2' => '大阪市西区阿波座1-6-13',
      'luggage_address3' => 'カーニープレイス本町ビル5F',
      'luggage_name' => '株式会社ドリーマーズ',
      'luggage_tel' => '643955880',

      'mgmt_company' => '',
      'mgmt_tel' => '',
      'mgmt_emer_tel' => '',
      'mgmt_first_name' => '',
      'mgmt_last_name' => '',
      'mgmt_person_tel' => '',
      'mgmt_email' => '',
      'mgmt_sec_company' => '',
      'mgmt_sec_tel' => '',
      'mgmt_remark' => '',
      'smg_url' => 'https://osaka-conference.com/rental/hm-karny/4f/',
      'entrance_open_time' => '',
      'backyard_open_time' => '',
      'layout' => '1',
      'layout_prepare' => '6000',
      'layout_clean' => '6000',
      'reserver_company' => '',
      'reserver_tel' => '',
      'reserver_fax' => '',
      'reserver_remark' => '',
    ]);


    $venue10 = Venue::create([
      'alliance_flag' => '1',
      'name_area' => '本町',
      'name_bldg' => 'センタービル',
      'name_venue' => '1号室',
      'size1' => '21',
      'size2' => '69',
      'capacity' => 'スクール形式10～36名',
      'eat_in_flag' => '0',
      'post_code' => '5410053',
      'address1' => '大阪府',
      'address2' => '大阪市中央区本町2-6-10',
      'address3' => '本町センタービルB1F',
      'remark' => '',
      'first_name' => '',
      'last_name' => '',
      'first_name_kana' => '',
      'last_name_kana' => '',
      'person_tel' => '',
      'person_email' => '',
      'luggage_flag' => '1',
      'luggage_post_code' => '5410053',
      'luggage_address1' => '大阪府',
      'luggage_address2' => '大阪市中央区本町2-6-10',
      'luggage_address3' => '本町センタービルB1F',
      'luggage_name' => '管理室',
      'luggage_tel' => '661202162',
      'cost' => '60',
      'mgmt_company' => '',
      'mgmt_tel' => '',
      'mgmt_emer_tel' => '',
      'mgmt_first_name' => '',
      'mgmt_last_name' => '',
      'mgmt_person_tel' => '',
      'mgmt_email' => '',
      'mgmt_sec_company' => '',
      'mgmt_sec_tel' => '',
      'mgmt_remark' => '',
      'smg_url' => 'https://osaka-conference.com/rental/hm-center/room1/',
      'entrance_open_time' => '',
      'backyard_open_time' => '',
      'layout' => '0',
      'layout_prepare' => '0',
      'layout_clean' => '0',
      'reserver_company' => '',
      'reserver_tel' => '',
      'reserver_fax' => '',
      'reserver_remark' => '',
    ]);


    $venue11 = Venue::create([
      'alliance_flag' => '1',
      'name_area' => '本町',
      'name_bldg' => 'センタービル',
      'name_venue' => '2号室',
      'size1' => '14',
      'size2' => '48',
      'capacity' => 'スクール形式10～24名',
      'eat_in_flag' => '0',
      'post_code' => '5410053',
      'address1' => '大阪府',
      'address2' => '大阪市中央区本町2-6-10',
      'address3' => '本町センタービルB1F',
      'remark' => '',
      'first_name' => '',
      'last_name' => '',
      'first_name_kana' => '',
      'last_name_kana' => '',
      'person_tel' => '',
      'person_email' => '',
      'luggage_flag' => '1',
      'luggage_post_code' => '5410053',
      'luggage_address1' => '大阪府',
      'luggage_address2' => '大阪市中央区本町2-6-10',
      'luggage_address3' => '本町センタービルB1F',
      'luggage_name' => '管理室',
      'luggage_tel' => '661202162',
      'cost' => '60',
      'mgmt_company' => '',
      'mgmt_tel' => '',
      'mgmt_emer_tel' => '',
      'mgmt_first_name' => '',
      'mgmt_last_name' => '',
      'mgmt_person_tel' => '',
      'mgmt_email' => '',
      'mgmt_sec_company' => '',
      'mgmt_sec_tel' => '',
      'mgmt_remark' => '',
      'smg_url' => 'https://osaka-conference.com/rental/hm-center/room2/',
      'entrance_open_time' => '',
      'backyard_open_time' => '',
      'layout' => '0',
      'layout_prepare' => '0',
      'layout_clean' => '0',
      'reserver_company' => '',
      'reserver_tel' => '',
      'reserver_fax' => '',
      'reserver_remark' => '',
    ]);


    $venue12 = Venue::create([
      'alliance_flag' => '1',
      'name_area' => '本町',
      'name_bldg' => '大雅ビル',
      'name_venue' => '第1会議室',
      'size1' => '30',
      'size2' => '99',
      'capacity' => 'スクール形式63名',
      'eat_in_flag' => '1',
      'post_code' => '5410051',
      'address1' => '大阪府',
      'address2' => '大阪市中央区備後町3-6-2',
      'address3' => '大雅ビル5F',
      'remark' => '',
      'first_name' => '',
      'last_name' => '',
      'first_name_kana' => '',
      'last_name_kana' => '',
      'person_tel' => '',
      'person_email' => '',
      'luggage_flag' => '0',
      'luggage_post_code' => '',
      'luggage_address1' => '',
      'luggage_address2' => '',
      'luggage_address3' => '',
      'luggage_name' => '',
      'luggage_tel' => '',
      'cost' => '70',
      'mgmt_company' => '',
      'mgmt_tel' => '',
      'mgmt_emer_tel' => '',
      'mgmt_first_name' => '',
      'mgmt_last_name' => '',
      'mgmt_person_tel' => '',
      'mgmt_email' => '',
      'mgmt_sec_company' => '',
      'mgmt_sec_tel' => '',
      'mgmt_remark' => '',
      'smg_url' => 'https://osaka-conference.com/rental/hm-taiga/room1-h/',
      'entrance_open_time' => '',
      'backyard_open_time' => '',
      'layout' => '0',
      'layout_prepare' => '0',
      'layout_clean' => '0',
      'reserver_company' => '',
      'reserver_tel' => '',
      'reserver_fax' => '',
      'reserver_remark' => '',
    ]);


    $venue13 = Venue::create([
      'alliance_flag' => '1',
      'name_area' => '難波',
      'name_bldg' => '日興ビル',
      'name_venue' => '6F',
      'size1' => '7',
      'size2' => '24',
      'capacity' => 'スクール形式15名',
      'eat_in_flag' => '1',
      'post_code' => '5420086',
      'address1' => '大阪府',
      'address2' => '大阪市中央区西心斎橋2-4-2',
      'address3' => '難波日興ビル6F',
      'remark' => '',
      'first_name' => '',
      'last_name' => '',
      'first_name_kana' => '',
      'last_name_kana' => '',
      'person_tel' => '',
      'person_email' => '',
      'luggage_flag' => '1',
      'luggage_post_code' => '5420086',
      'luggage_address1' => '大阪府',
      'luggage_address2' => '大阪市中央区西心斎橋2-4-2',
      'luggage_address3' => '難波日興ビル6F',
      'luggage_name' => '株式会社ヒロコーポレーション',
      'luggage_tel' => '662136177',
      'cost' => '70',
      'mgmt_company' => '',
      'mgmt_tel' => '',
      'mgmt_emer_tel' => '',
      'mgmt_first_name' => '',
      'mgmt_last_name' => '',
      'mgmt_person_tel' => '',
      'mgmt_email' => '',
      'mgmt_sec_company' => '',
      'mgmt_sec_tel' => '',
      'mgmt_remark' => '',
      'smg_url' => '',
      'entrance_open_time' => '',
      'backyard_open_time' => '',
      'layout' => '0',
      'layout_prepare' => '0',
      'layout_clean' => '0',
      'reserver_company' => '',
      'reserver_tel' => '',
      'reserver_fax' => '',
      'reserver_remark' => '',
    ]);


    $venue14 = Venue::create([
      'alliance_flag' => '1',
      'name_area' => '難波',
      'name_bldg' => '日興ビル',
      'name_venue' => 'B2F',
      'size1' => '30',
      'size2' => '99',
      'capacity' => 'スクール形式72名',
      'eat_in_flag' => '1',
      'post_code' => '5420086',
      'address1' => '大阪府',
      'address2' => '大阪市中央区西心斎橋2-4-2',
      'address3' => '難波日興ビルB2F',
      'remark' => '',
      'first_name' => '',
      'last_name' => '',
      'first_name_kana' => '',
      'last_name_kana' => '',
      'person_tel' => '',
      'person_email' => '',
      'luggage_flag' => '1',
      'luggage_post_code' => '5420086',
      'luggage_address1' => '大阪府',
      'luggage_address2' => '大阪市中央区西心斎橋2-4-2',
      'luggage_address3' => '難波日興ビルB2F',
      'luggage_name' => '管理室',
      'luggage_tel' => '662131908',
      'cost' => '70',
      'mgmt_company' => '',
      'mgmt_tel' => '',
      'mgmt_emer_tel' => '',
      'mgmt_first_name' => '',
      'mgmt_last_name' => '',
      'mgmt_person_tel' => '',
      'mgmt_email' => '',
      'mgmt_sec_company' => '',
      'mgmt_sec_tel' => '',
      'mgmt_remark' => '',
      'smg_url' => 'https://osaka-conference.com/rental/nb-nikko/b2f/',
      'entrance_open_time' => '',
      'backyard_open_time' => '',
      'layout' => '0',
      'layout_prepare' => '0',
      'layout_clean' => '0',
      'reserver_company' => '',
      'reserver_tel' => '',
      'reserver_fax' => '',
      'reserver_remark' => '',
    ]);


    $venue15 = Venue::create([
      'alliance_flag' => '1',
      'name_area' => '新大阪',
      'name_bldg' => 'キューホー江坂ビル',
      'name_venue' => '2F',
      'size1' => '23',
      'size2' => '76',
      'capacity' => 'スクール形式10～33名',
      'eat_in_flag' => '0',
      'post_code' => '5640063',
      'address1' => '大阪府',
      'address2' => '吹田市江坂町2-1-43',
      'address3' => 'キューホー江坂ビル2F',
      'remark' => '',
      'first_name' => '',
      'last_name' => '',
      'first_name_kana' => '',
      'last_name_kana' => '',
      'person_tel' => '',
      'person_email' => '',
      'luggage_flag' => '0',
      'luggage_post_code' => '',
      'luggage_address1' => '',
      'luggage_address2' => '',
      'luggage_address3' => '',
      'luggage_name' => '',
      'luggage_tel' => '',
      'cost' => '70',
      'mgmt_company' => '',
      'mgmt_tel' => '',
      'mgmt_emer_tel' => '',
      'mgmt_first_name' => '',
      'mgmt_last_name' => '',
      'mgmt_person_tel' => '',
      'mgmt_email' => '',
      'mgmt_sec_company' => '',
      'mgmt_sec_tel' => '',
      'mgmt_remark' => '',
      'smg_url' => 'https://osaka-conference.com/rental/so-kyuho/2f/',
      'entrance_open_time' => '',
      'backyard_open_time' => '',
      'layout' => '0',
      'layout_prepare' => '0',
      'layout_clean' => '0',
      'reserver_company' => '',
      'reserver_tel' => '',
      'reserver_fax' => '',
      'reserver_remark' => '',
    ]);


    $venue16 = Venue::create([
      'alliance_flag' => '1',
      'name_area' => '天六',
      'name_bldg' => 'マロニエホール',
      'name_venue' => '7F',
      'size1' => '50',
      'size2' => '165',
      'capacity' => 'スクール形式50～100名',
      'eat_in_flag' => '0',
      'post_code' => '5310041',
      'address1' => '大阪府',
      'address2' => '大阪市北区天神橋7-7-4',
      'address3' => 'マロニエファッションデザイン専門学校7F',
      'remark' => '',
      'first_name' => '',
      'last_name' => '',
      'first_name_kana' => '',
      'last_name_kana' => '',
      'person_tel' => '',
      'person_email' => '',
      'luggage_flag' => '1',
      'luggage_post_code' => '5310041',
      'luggage_address1' => '大阪府',
      'luggage_address2' => '大阪市北区天神橋7-7-4',
      'luggage_address3' => 'マロニエファッションデザイン専門学校7F',
      'luggage_name' => 'SMG貸し会議室',
      'luggage_tel' => '665566462',
      'cost' => '70',
      'mgmt_company' => '',
      'mgmt_tel' => '',
      'mgmt_emer_tel' => '',
      'mgmt_first_name' => '',
      'mgmt_last_name' => '',
      'mgmt_person_tel' => '',
      'mgmt_email' => '',
      'mgmt_sec_company' => '',
      'mgmt_sec_tel' => '',
      'mgmt_remark' => '',
      'smg_url' => 'https://osaka-conference.com/rental/t6-maronie/hall/',
      'entrance_open_time' => '',
      'backyard_open_time' => '',
      'layout' => '0',
      'layout_prepare' => '0',
      'layout_clean' => '0',
      'reserver_company' => '',
      'reserver_tel' => '',
      'reserver_fax' => '',
      'reserver_remark' => '',
    ]);


    $venue17 = Venue::create([
      'alliance_flag' => '1',
      'name_area' => '心斎橋',
      'name_bldg' => '大成閣',
      'name_venue' => '大ホールA',
      'size1' => '160',
      'size2' => '528',
      'capacity' => '円卓形式150～200名',
      'eat_in_flag' => '0',
      'post_code' => '5420083',
      'address1' => '大阪府',
      'address2' => '大阪市中央区東心斎橋1-18-12',
      'address3' => '心斎橋大成閣',
      'remark' => '',
      'first_name' => '',
      'last_name' => '',
      'first_name_kana' => '',
      'last_name_kana' => '',
      'person_tel' => '',
      'person_email' => '',
      'luggage_flag' => '1',
      'luggage_post_code' => '5420083',
      'luggage_address1' => '大阪府',
      'luggage_address2' => '大阪市中央区東心斎橋1-18-12',
      'luggage_address3' => '大成閣',
      'luggage_name' => '孫（そん）',
      'luggage_tel' => '662715238',
      'cost' => '70',
      'mgmt_company' => '',
      'mgmt_tel' => '',
      'mgmt_emer_tel' => '',
      'mgmt_first_name' => '',
      'mgmt_last_name' => '',
      'mgmt_person_tel' => '',
      'mgmt_email' => '',
      'mgmt_sec_company' => '',
      'mgmt_sec_tel' => '',
      'mgmt_remark' => '',
      'smg_url' => 'https://osaka-conference.com/rental/sb-taiseikaku/hall-a/',
      'entrance_open_time' => '',
      'backyard_open_time' => '',
      'layout' => '0',
      'layout_prepare' => '0',
      'layout_clean' => '0',
      'reserver_company' => '',
      'reserver_tel' => '',
      'reserver_fax' => '',
      'reserver_remark' => '',
    ]);


    $venue18 = Venue::create([
      'alliance_flag' => '1',
      'name_area' => '四ツ橋',
      'name_bldg' => '近商ビル',
      'name_venue' => '100A ※登録テスト用※',
      'size1' => '36',
      'size2' => '121',
      'capacity' => 'スクール形式20～90名',
      'eat_in_flag' => '1',
      'post_code' => '5500014',
      'address1' => '大阪府',
      'address2' => '大阪市西区北堀江1-1-24',
      'address3' => '近商ビル10F',
      'remark' => '',
      'first_name' => '',
      'last_name' => '',
      'first_name_kana' => '',
      'last_name_kana' => '',
      'person_tel' => '',
      'person_email' => '',
      'luggage_flag' => '0',
      'luggage_post_code' => '',
      'luggage_address1' => '',
      'luggage_address2' => '',
      'luggage_address3' => '',
      'luggage_name' => '',
      'luggage_tel' => '665566462',
      'cost' => '70',
      'mgmt_company' => '',
      'mgmt_tel' => '',
      'mgmt_emer_tel' => '',
      'mgmt_first_name' => '',
      'mgmt_last_name' => '',
      'mgmt_person_tel' => '',
      'mgmt_email' => '',
      'mgmt_sec_company' => '',
      'mgmt_sec_tel' => '',
      'mgmt_remark' => '',
      'smg_url' => '',
      'entrance_open_time' => '',
      'backyard_open_time' => '',
      'layout' => '1',
      'layout_prepare' => '5000',
      'layout_clean' => '5000',
      'reserver_company' => '',
      'reserver_tel' => '',
      'reserver_fax' => '',
      'reserver_remark' => '',
    ]);

    $venue19 = Venue::create([
      'alliance_flag' => '1',
      'name_area' => '難波',
      'name_bldg' => '日興ビル',
      'name_venue' => '6FB',
      'size1' => '3',
      'size2' => '9',
      'capacity' => 'シアター形式1～5名',
      'eat_in_flag' => '1',
      'post_code' => '1234567',
      'address1' => 'sample1',
      'address2' => 'sample2',
      'address3' => 'sample3',
      'remark' => '',
      'first_name' => '',
      'last_name' => '',
      'first_name_kana' => '',
      'last_name_kana' => '',
      'person_tel' => '',
      'person_email' => '',
      'luggage_flag' => '0',
      'luggage_post_code' => '',
      'luggage_address1' => '',
      'luggage_address2' => '',
      'luggage_address3' => '',
      'luggage_name' => '',
      'luggage_tel' => '1234567',
      'cost' => '70',
      'mgmt_company' => '',
      'mgmt_tel' => '',
      'mgmt_emer_tel' => '',
      'mgmt_first_name' => '',
      'mgmt_last_name' => '',
      'mgmt_person_tel' => '',
      'mgmt_email' => '',
      'mgmt_sec_company' => '',
      'mgmt_sec_tel' => '',
      'mgmt_remark' => '',
      'smg_url' => '',
      'entrance_open_time' => '',
      'backyard_open_time' => '',
      'layout' => '1',
      'layout_prepare' => '5000',
      'layout_clean' => '5000',
      'reserver_company' => '',
      'reserver_tel' => '',
      'reserver_fax' => '',
      'reserver_remark' => '',
    ]);

    $venue20 = Venue::create([
      'alliance_flag' => '1',
      'name_area' => '難波',
      'name_bldg' => '日興ビル',
      'name_venue' => '6FA',
      'size1' => '7.26',
      'size2' => '24',
      'capacity' => 'スクール形式15名',
      'eat_in_flag' => '1',
      'post_code' => '1234567',
      'address1' => 'sample1',
      'address2' => 'sample2',
      'address3' => 'sample3',
      'remark' => '',
      'first_name' => '',
      'last_name' => '',
      'first_name_kana' => '',
      'last_name_kana' => '',
      'person_tel' => '',
      'person_email' => '',
      'luggage_flag' => '0',
      'luggage_post_code' => '',
      'luggage_address1' => '',
      'luggage_address2' => '',
      'luggage_address3' => '',
      'luggage_name' => '',
      'luggage_tel' => '1234567',
      'cost' => '70',
      'mgmt_company' => '',
      'mgmt_tel' => '',
      'mgmt_emer_tel' => '',
      'mgmt_first_name' => '',
      'mgmt_last_name' => '',
      'mgmt_person_tel' => '',
      'mgmt_email' => '',
      'mgmt_sec_company' => '',
      'mgmt_sec_tel' => '',
      'mgmt_remark' => '',
      'smg_url' => '',
      'entrance_open_time' => '',
      'backyard_open_time' => '',
      'layout' => '1',
      'layout_prepare' => '5000',
      'layout_clean' => '5000',
      'reserver_company' => '',
      'reserver_tel' => '',
      'reserver_fax' => '',
      'reserver_remark' => '',
    ]);


    $venue1->save_equipments([13]);
    $venue1->save_equipments([12]);
    $venue1->save_equipments([11]);
    $venue1->save_equipments([10]);
    $venue1->save_equipments([9]);
    $venue1->save_equipments([8]);
    $venue1->save_equipments([7]);
    $venue1->save_equipments([6]);
    $venue1->save_equipments([5]);
    $venue1->save_equipments([4]);
    $venue1->save_equipments([3]);
    $venue1->save_equipments([2]);
    $venue1->save_equipments([1]);
    $venue2->save_equipments([12]);
    $venue2->save_equipments([11]);
    $venue2->save_equipments([10]);
    $venue2->save_equipments([9]);
    $venue2->save_equipments([8]);
    $venue2->save_equipments([7]);
    $venue2->save_equipments([6]);
    $venue2->save_equipments([5]);
    $venue2->save_equipments([4]);
    $venue2->save_equipments([3]);
    $venue2->save_equipments([2]);
    $venue2->save_equipments([1]);
    $venue3->save_equipments([12]);
    $venue3->save_equipments([11]);
    $venue3->save_equipments([10]);
    $venue3->save_equipments([9]);
    $venue3->save_equipments([8]);
    $venue3->save_equipments([7]);
    $venue3->save_equipments([6]);
    $venue3->save_equipments([5]);
    $venue3->save_equipments([4]);
    $venue3->save_equipments([3]);
    $venue3->save_equipments([2]);
    $venue3->save_equipments([1]);
    $venue4->save_equipments([12]);
    $venue4->save_equipments([11]);
    $venue4->save_equipments([10]);
    $venue4->save_equipments([9]);
    $venue4->save_equipments([8]);
    $venue4->save_equipments([7]);
    $venue4->save_equipments([6]);
    $venue4->save_equipments([5]);
    $venue4->save_equipments([4]);
    $venue4->save_equipments([3]);
    $venue4->save_equipments([2]);
    $venue4->save_equipments([1]);
    $venue5->save_equipments([12]);
    $venue5->save_equipments([11]);
    $venue5->save_equipments([10]);
    $venue5->save_equipments([9]);
    $venue5->save_equipments([8]);
    $venue5->save_equipments([7]);
    $venue5->save_equipments([6]);
    $venue5->save_equipments([5]);
    $venue5->save_equipments([4]);
    $venue5->save_equipments([3]);
    $venue5->save_equipments([2]);
    $venue5->save_equipments([1]);
    $venue6->save_equipments([12]);
    $venue6->save_equipments([11]);
    $venue6->save_equipments([10]);
    $venue6->save_equipments([9]);
    $venue6->save_equipments([8]);
    $venue6->save_equipments([7]);
    $venue6->save_equipments([6]);
    $venue6->save_equipments([5]);
    $venue6->save_equipments([4]);
    $venue6->save_equipments([3]);
    $venue6->save_equipments([2]);
    $venue6->save_equipments([1]);
    $venue7->save_equipments([12]);
    $venue7->save_equipments([11]);
    $venue7->save_equipments([10]);
    $venue7->save_equipments([9]);
    $venue7->save_equipments([8]);
    $venue7->save_equipments([7]);
    $venue7->save_equipments([6]);
    $venue7->save_equipments([5]);
    $venue7->save_equipments([4]);
    $venue7->save_equipments([3]);
    $venue7->save_equipments([2]);
    $venue7->save_equipments([1]);
    $venue8->save_equipments([12]);
    $venue8->save_equipments([11]);
    $venue8->save_equipments([10]);
    $venue8->save_equipments([9]);
    $venue8->save_equipments([8]);
    $venue8->save_equipments([7]);
    $venue8->save_equipments([6]);
    $venue8->save_equipments([5]);
    $venue8->save_equipments([4]);
    $venue8->save_equipments([3]);
    $venue8->save_equipments([2]);
    $venue8->save_equipments([1]);
    $venue9->save_equipments([12]);
    $venue9->save_equipments([10]);
    $venue9->save_equipments([9]);
    $venue9->save_equipments([8]);
    $venue9->save_equipments([7]);
    $venue9->save_equipments([6]);
    $venue9->save_equipments([5]);
    $venue9->save_equipments([4]);
    $venue9->save_equipments([2]);
    $venue9->save_equipments([1]);
    $venue10->save_equipments([17]);
    $venue10->save_equipments([16]);
    $venue10->save_equipments([15]);
    $venue10->save_equipments([14]);
    $venue10->save_equipments([18]);
    $venue11->save_equipments([18]);
    $venue11->save_equipments([17]);
    $venue11->save_equipments([16]);
    $venue11->save_equipments([15]);
    $venue11->save_equipments([14]);
    $venue12->save_equipments([20]);
    $venue12->save_equipments([19]);
    $venue14->save_equipments([7]);
    $venue14->save_equipments([6]);
    $venue14->save_equipments([4]);
    $venue14->save_equipments([2]);
    $venue14->save_equipments([1]);
    $venue15->save_equipments([4]);
    $venue17->save_equipments([24]);
    $venue17->save_equipments([23]);
    $venue17->save_equipments([22]);
    $venue18->save_equipments([12]);
    $venue18->save_equipments([11]);
    $venue18->save_equipments([10]);
    $venue18->save_equipments([9]);
    $venue18->save_equipments([8]);
    $venue18->save_equipments([7]);
    $venue18->save_equipments([6]);
    $venue18->save_equipments([5]);
    $venue18->save_equipments([4]);
    $venue18->save_equipments([3]);
    $venue18->save_equipments([2]);
    $venue18->save_equipments([1]);

    $venue1->save_services([4]);
    $venue1->save_services([3]);
    $venue1->save_services([2]);
    $venue1->save_services([1]);
    $venue2->save_services([4]);
    $venue2->save_services([3]);
    $venue2->save_services([2]);
    $venue2->save_services([1]);
    $venue3->save_services([4]);
    $venue3->save_services([3]);
    $venue3->save_services([2]);
    $venue3->save_services([1]);
    $venue4->save_services([4]);
    $venue4->save_services([3]);
    $venue4->save_services([2]);
    $venue4->save_services([1]);
    $venue5->save_services([4]);
    $venue5->save_services([3]);
    $venue5->save_services([2]);
    $venue5->save_services([1]);
    $venue6->save_services([4]);
    $venue6->save_services([3]);
    $venue6->save_services([2]);
    $venue6->save_services([1]);
    $venue7->save_services([4]);
    $venue7->save_services([3]);
    $venue7->save_services([2]);
    $venue7->save_services([1]);
    $venue8->save_services([4]);
    $venue8->save_services([3]);
    $venue8->save_services([2]);
    $venue8->save_services([1]);
    $venue9->save_services([4]);
    $venue9->save_services([3]);
    $venue9->save_services([2]);
    $venue9->save_services([1]);
    $venue10->save_services([2]);
    $venue10->save_services([1]);
    $venue11->save_services([1]);
    $venue12->save_services([1]);
    $venue13->save_services([1]);
    $venue14->save_services([1]);
    $venue15->save_services([1]);
    $venue16->save_services([1]);
    $venue17->save_services([1]);
    $venue18->save_services([1]);
  }
}
