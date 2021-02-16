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

    DB::table('users')->insert([
      'id' => 999,
      'email' => 'sample@sample.com',
      'password' => Hash::make('12345678'),
      'company' => "（未登録ユーザー）",
      'post_code' => '（未設定）',
      'address1' => '（未設定）',
      'address2' => '（未設定）',
      'address3' => '（未設定）',
      'first_name' => "（未登録ユーザー）",
      'last_name' => "（未登録ユーザー）",
      'first_name_kana' => "（未登録ユーザー）",
      'last_name_kana' => "（未登録ユーザー）",
      'pay_method' => 1,
      'pay_limit' => 1,
      'status' => 1,
      'remember_token'    => Str::random(10),
    ]);
  }
}
