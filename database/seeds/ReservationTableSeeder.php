<?php

use Illuminate\Database\Seeder;

class ReservationTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    factory(\App\Models\Reservation::class, 200)->create();
  }
}
