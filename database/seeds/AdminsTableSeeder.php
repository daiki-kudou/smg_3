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
    // DB::table('admins')->insert([
    //   'name'              => '管理者',
    //   'email'             => 'admin@example.com',
    //   'password'          => Hash::make('REGUUilg0aQt'),
    //   'remember_token'    => Str::random(10),
    // ]);
  }
}
