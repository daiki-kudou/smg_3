<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AdminsTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    DB::table('admins')->truncate();
    DB::table('admins')->insert([
      'name'              => '管理者',
      'email'             => 'admin@example.com',
      'password'          => Hash::make('REGUUilg0aQt'),
      'remember_token'    => Str::random(10),
    ]);
    DB::table('admins')->insert([
      'name'              => '中務真梨子',
      'email'             => 'nakamu@nakamu.com',
      'password'          => Hash::make('OocxGPiaLuIy'),
      'remember_token'    => Str::random(10),
    ]);
    DB::table('admins')->insert([
      'name'              => '堺谷カツ美',
      'email'             => 'sakaitani@sakaitani.com',
      'password'          => Hash::make('RSQBGD8x52Ii'),
      'remember_token'    => Str::random(10),
    ]);
    DB::table('admins')->insert([
      'name'              => '薄雲一',
      'email'             => 'usugumo@usugumo.com',
      'password'          => Hash::make('B4LwMd9kzrFy'),
      'remember_token'    => Str::random(10),
    ]);
    DB::table('admins')->insert([
      'id'              => 8,
      'name'              => '提携',
      'email'             => 'teikei@s-mg.co.jp',
      'password'          => Hash::make('BHP5cbIk4FDL'),
      'remember_token'    => Str::random(10),
    ]);
  }
}
