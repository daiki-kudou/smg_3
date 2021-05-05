<?php

use Illuminate\Database\Seeder;

use App\Models\Reservation;

class ReservationTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    DB::table('reservations')->truncate();

    factory(\App\Models\Reservation::class, 200)->create();
  }
}
