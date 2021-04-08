<?php

use Illuminate\Database\Seeder;

class BillsTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    DB::table('bills')->truncate();
    factory(\App\Models\Bill::class, 200)->create();
  }
}
