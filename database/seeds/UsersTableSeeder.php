<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;




class UsersTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    // factory(\App\Models\User::class, 100)->create();

    DB::table('users')->truncate();

    DB::table('users')->insert([
      'email' => 'maruoka@web-trickster.com',
      'password' => Hash::make('12345678'),
      'company' => "トリックスター",
      'post_code' => 'test',
      'address1' => 'test',
      'address2' => 'test',
      'address3' => 'test',
      'first_name' => "丸岡",
      'last_name' => "麻衣",
      'first_name_kana' => "マルオカ",
      'last_name_kana' => "マイ",
      'pay_method' => 1,
      'pay_limit' => 1,
      'status' => 1,
      'remember_token'    => Str::random(10),

    ]);
    DB::table('users')->insert([
      'email' => 'ooyama@web-trickster.com',
      'password' => Hash::make('12345678'),
      'company' => "トリックスター",
      'post_code' => 'test',
      'address1' => 'test',
      'address2' => 'test',
      'address3' => 'test',
      'first_name' => "大山",
      'last_name' => "紘一郎",
      'first_name_kana' => "オオヤマ",
      'last_name_kana' => "コウイチロウ",
      'pay_method' => 1,
      'pay_limit' => 1,
      'status' => 1,
      'remember_token'    => Str::random(10),

    ]);
    DB::table('users')->insert([
      'email' => 'kudou@web-trickster.com',
      'password' => Hash::make('12345678'),
      'company' => "トリックスター",
      'post_code' => 'test',
      'address1' => 'test',
      'address2' => 'test',
      'address3' => 'test',
      'first_name' => "工藤",
      'last_name' => "大揮",
      'first_name_kana' => "クドウ",
      'last_name_kana' => "ダイキ",
      'pay_method' => 1,
      'pay_limit' => 1,
      'status' => 1,
      'remember_token'    => Str::random(10),

    ]);

    // for ($i = 1; $i < 30; $i++) {
    //   DB::table('users')->insert(
    //     [
    //       'email'             => $i . $email_random->random(),
    //       'password'          => Hash::make('12345678'),
    //       'remember_token'    => Str::random(10),
    //       'company'    => $company_name->random(),
    //       'post_code'    => $postcode_random->random(),
    //       'address1'    => $prefecture_random->random(),
    //       'address2'    => $adr1_random->random(),
    //       'address3'    => $adr2_random->random(),
    //       'address_remark'    => '',
    //       'url'    => 'https://web-trickster.com/',
    //       'attr'    => $attr_random->random(),
    //       'condition'    => '',
    //       'first_name'    => $firstname_random->random(),
    //       'last_name'    => $lastname_random->random(),
    //       'first_name_kana'    => $first_kana_random->random(),
    //       'last_name_kana'    => $last_kana_random->random(),
    //       'mobile'    => $mobile_random->random(),
    //       'tel'    => $tel_random->random(),
    //       'fax'    => $tel_random->random(),
    //       'pay_method'    => $attr_random->random(),
    //       'pay_limit'    => $attr_random->random(),
    //       'pay_post_code'    => $postcode_random->random(),
    //       'pay_address1'    => $prefecture_random->random(),
    //       'pay_address2'    => $adr1_random->random(),
    //       'pay_address3'    => $adr2_random->random(),
    //       'pay_remark'    => $adr3_random->random(),
    //       'attention'    => '',
    //       'remark'    => '',
    //       'status' => '1'
    //     ]
    //   );
    // }
    // DB::table('users')->insert(
    //   [
    //     'email'             => 'user@example.com',
    //     'password'          => Hash::make('12345678'),
    //     'remember_token'    => Str::random(10),
    //     'company'    => $company_name->random(),
    //     'post_code'    => $postcode_random->random(),
    //     'address1'    => $prefecture_random->random(),
    //     'address2'    => $adr1_random->random(),
    //     'address3'    => $adr2_random->random(),
    //     'address_remark'    => '',
    //     'url'    => 'https://web-trickster.com/',
    //     'attr'    => $attr_random->random(),
    //     'condition'    => '',
    //     'first_name'    => $firstname_random->random(),
    //     'last_name'    => $lastname_random->random(),
    //     'first_name_kana'    => $first_kana_random->random(),
    //     'last_name_kana'    => $last_kana_random->random(),
    //     'mobile'    => $mobile_random->random(),
    //     'tel'    => $tel_random->random(),
    //     'fax'    => $tel_random->random(),
    //     'pay_method'    => $attr_random->random(),
    //     'pay_limit'    => $attr_random->random(),
    //     'pay_post_code'    => $postcode_random->random(),
    //     'pay_address1'    => $prefecture_random->random(),
    //     'pay_address2'    => $adr1_random->random(),
    //     'pay_address3'    => $adr2_random->random(),
    //     'pay_remark'    => $adr3_random->random(),
    //     'attention'    => '',
    //     'remark'    => '',
    //     'status' => '1'
    //   ]
    // );
  }
}
