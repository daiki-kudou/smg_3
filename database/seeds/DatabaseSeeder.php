<?php

use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
  /**
   * Seed the application's database.
   *
   * @return void
   */
  public function run()
  {
    $this->call([
      UsersTableSeeder::class,
      AdminsTableSeeder::class,
      // EquipmentTableSeeder::class,
      // ServicesTableSeeder::class,
      AgentsTableSeeder::class,
      // VenuesTableSeeder::class,
      // ReservationTableSeeder::class,
      // BillsTableSeeder::class,
      // DatesTableSeeder::class,
    ]);
  }
}
