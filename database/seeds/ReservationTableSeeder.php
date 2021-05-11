<?php

use Illuminate\Database\Seeder;

use App\Models\Reservation;
use App\Models\Bill;
use App\Models\Venue;
use App\Models\User;
use App\Models\Agent;
use Faker\Generator as Faker;


class ReservationTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run(Faker $faker)
  {
    DB::table('reservations')->truncate();

    for ($i = 1; $i < 1000; $i++) {

      $venues = Venue::all()->pluck("id");
      $users = User::all()->pluck("id");
      $agents = Agent::all()->pluck("id");
      $enter = ['10:00:00', '11:00:00', '12:00:00', '13:00:00', '14:00:00'];
      $leave = ['16:00:00', '17:00:00', '18:00:00', '19:00:00', '20:00:00', '21:00:00', '22:00:00'];
      $date = [
        "2020-04-01",
        "2020-04-03",
        "2020-04-05",
        "2020-04-07",
        "2020-04-09",
        "2020-04-11",
        "2020-04-12",
        "2020-04-18",
        "2020-04-19",
        "2020-04-20",
        "2020-04-21",
        "2020-04-29",
        "2020-05-01",
        "2020-05-03",
        "2020-05-05",
        "2020-05-07",
        "2020-05-09",
        "2020-05-11",
        "2020-05-12",
        "2020-05-18",
        "2020-05-19",
        "2020-05-20",
        "2020-05-21",
        "2020-05-29"
      ];

      $randUser = $users[array_rand($users->all(), 1)];
      $randAgent = $agents[array_rand($agents->all(), 1)];
      if ($randUser % 2 == 0) {
        $randUser = 0;
      } else {
        $randAgent = 0;
      }

      $reservation = Reservation::create([
        'multiple_reserve_id' => 0,
        'venue_id' => $venues[array_rand($venues->all(), 1)],
        'user_id' => $randUser,
        'agent_id' => $randAgent,
        'reserve_date' => $faker->dateTimeThisYear,
        'price_system' => rand(1, 2),
        'enter_time' => $enter[array_rand($enter, 1)],
        'leave_time' => $leave[array_rand($leave, 1)],
        'board_flag' => rand(0, 1),
        'event_start' => NULL,
        'event_finish' => NULL,
        'event_name1' => NULL,
        'event_name2' => NULL,
        'event_owner' => NULL,
        'luggage_count' => rand(1, 9),
        'luggage_arrive' => $date[array_rand($date, 1)],
        'luggage_return' => rand(1, 9),
        'email_flag' => 0,
        'in_charge' => $faker->lastName . $faker->firstName,
        'tel' => $faker->phoneNumber,
        'discount_condition' => "",
        'attention' => "",
        'user_details' => "",
        'admin_details' => "",
        'eat_in' => 0,
        'eat_in_prepare' => 0,
        'cost' => 0,
        'created_at' => $faker->dateTimeBetween($startDate = '-2 month', $endDate = '+2 moth'),
      ]);
      $bill = Bill::create([
        'reservation_id' => $reservation->id,
        'venue_price' => mt_rand(1000, 20000),
        'equipment_price' => mt_rand(1000, 20000),
        'layout_price' => mt_rand(1000, 20000),
        'others_price' => mt_rand(1000, 20000),
        'master_subtotal' => mt_rand(1000, 20000),
        'master_tax' => mt_rand(1000, 20000),
        'master_total' => mt_rand(1000, 20000),
        'payment_limit' => '2020-12-12',
        'bill_company' => 'test',
        'bill_person' => 'test',
        'bill_created_at' => '2020-12-12',
        'paid' => 0,
        'reservation_status' => mt_rand(1, 3),
        'double_check_status' => 0,
        'category' => 0,
        'admin_judge' => 0,
      ]);
      $bill->breakdowns()->create([
        'bill_id' => $bill->id,
        "unit_item" => "test",
        "unit_cost" => "1",
        "unit_count" => "1",
        "unit_subtotal" => "1",
        "unit_type" => "1",
      ]);
    }
  }
}
