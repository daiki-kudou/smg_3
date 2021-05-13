<?php

use Illuminate\Database\Seeder;

class AgentsTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    DB::table('agents')->truncate();
    factory(\App\Models\Agent::class, 2000)->create();
  }
}
