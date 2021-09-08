<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

use App\Models\Venue;

use Carbon\Carbon;


class DatesTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    // DB::table('dates')->truncate();

    // $venues = Venue::orderBy('id')->get();
    // foreach ($venues as $venue) {
    //   for ($week_days = 1; $week_days <= 7; $week_days++) {
    //     $venue->dates()->create([
    //       'venue_id' => $venue->id,
    //       'week_day' => $week_days,
    //       'start' => Carbon::parse('08:00'),
    //       'finish' => Carbon::parse('23:00'),
    //     ]);
    //   };
    // }
    $venue1 = Venue::find(1);
    $venue2 = Venue::find(2);
    $venue3 = Venue::find(3);
    $venue4 = Venue::find(4);
    $venue5 = Venue::find(5);
    $venue6 = Venue::find(6);
    $venue7 = Venue::find(7);
    $venue8 = Venue::find(8);
    $venue9 = Venue::find(9);
    $venue10 = Venue::find(10);
    $venue11 = Venue::find(11);
    $venue12 = Venue::find(12);
    $venue13 = Venue::find(13);
    $venue14 = Venue::find(14);
    $venue15 = Venue::find(15);
    $venue16 = Venue::find(16);
    $venue17 = Venue::find(17);
    $venue18 = Venue::find(18);

    $venue1->dates()->create(['week_day' => 1, 'start' => Carbon::parse('8:00:00'), 'finish' => Carbon::parse('23:00:00'),]);
    $venue1->dates()->create(['week_day' => 2, 'start' => Carbon::parse('8:00:00'), 'finish' => Carbon::parse('23:00:00'),]);
    $venue1->dates()->create(['week_day' => 3, 'start' => Carbon::parse('8:00:00'), 'finish' => Carbon::parse('23:00:00'),]);
    $venue1->dates()->create(['week_day' => 4, 'start' => Carbon::parse('8:00:00'), 'finish' => Carbon::parse('23:00:00'),]);
    $venue1->dates()->create(['week_day' => 5, 'start' => Carbon::parse('8:00:00'), 'finish' => Carbon::parse('23:00:00'),]);
    $venue1->dates()->create(['week_day' => 6, 'start' => Carbon::parse('8:00:00'), 'finish' => Carbon::parse('23:00:00'),]);
    $venue1->dates()->create(['week_day' => 7, 'start' => Carbon::parse('8:00:00'), 'finish' => Carbon::parse('23:00:00'),]);
    $venue2->dates()->create(['week_day' => 1, 'start' => Carbon::parse('8:00:00'), 'finish' => Carbon::parse('23:00:00'),]);
    $venue2->dates()->create(['week_day' => 2, 'start' => Carbon::parse('8:00:00'), 'finish' => Carbon::parse('23:00:00'),]);
    $venue2->dates()->create(['week_day' => 3, 'start' => Carbon::parse('8:00:00'), 'finish' => Carbon::parse('23:00:00'),]);
    $venue2->dates()->create(['week_day' => 4, 'start' => Carbon::parse('8:00:00'), 'finish' => Carbon::parse('23:00:00'),]);
    $venue2->dates()->create(['week_day' => 5, 'start' => Carbon::parse('8:00:00'), 'finish' => Carbon::parse('23:00:00'),]);
    $venue2->dates()->create(['week_day' => 6, 'start' => Carbon::parse('8:00:00'), 'finish' => Carbon::parse('23:00:00'),]);
    $venue2->dates()->create(['week_day' => 7, 'start' => Carbon::parse('8:00:00'), 'finish' => Carbon::parse('23:00:00'),]);
    $venue3->dates()->create(['week_day' => 1, 'start' => Carbon::parse('8:00:00'), 'finish' => Carbon::parse('23:00:00'),]);
    $venue3->dates()->create(['week_day' => 2, 'start' => Carbon::parse('8:00:00'), 'finish' => Carbon::parse('23:00:00'),]);
    $venue3->dates()->create(['week_day' => 3, 'start' => Carbon::parse('8:00:00'), 'finish' => Carbon::parse('23:00:00'),]);
    $venue3->dates()->create(['week_day' => 4, 'start' => Carbon::parse('8:00:00'), 'finish' => Carbon::parse('23:00:00'),]);
    $venue3->dates()->create(['week_day' => 5, 'start' => Carbon::parse('8:00:00'), 'finish' => Carbon::parse('23:00:00'),]);
    $venue3->dates()->create(['week_day' => 6, 'start' => Carbon::parse('8:00:00'), 'finish' => Carbon::parse('23:00:00'),]);
    $venue3->dates()->create(['week_day' => 7, 'start' => Carbon::parse('8:00:00'), 'finish' => Carbon::parse('23:00:00'),]);
    $venue4->dates()->create(['week_day' => 1, 'start' => Carbon::parse('8:00:00'), 'finish' => Carbon::parse('23:00:00'),]);
    $venue4->dates()->create(['week_day' => 2, 'start' => Carbon::parse('8:00:00'), 'finish' => Carbon::parse('23:00:00'),]);
    $venue4->dates()->create(['week_day' => 3, 'start' => Carbon::parse('8:00:00'), 'finish' => Carbon::parse('23:00:00'),]);
    $venue4->dates()->create(['week_day' => 4, 'start' => Carbon::parse('8:00:00'), 'finish' => Carbon::parse('23:00:00'),]);
    $venue4->dates()->create(['week_day' => 5, 'start' => Carbon::parse('8:00:00'), 'finish' => Carbon::parse('23:00:00'),]);
    $venue4->dates()->create(['week_day' => 6, 'start' => Carbon::parse('8:00:00'), 'finish' => Carbon::parse('23:00:00'),]);
    $venue4->dates()->create(['week_day' => 7, 'start' => Carbon::parse('8:00:00'), 'finish' => Carbon::parse('23:00:00'),]);
    $venue5->dates()->create(['week_day' => 1, 'start' => Carbon::parse('8:00:00'), 'finish' => Carbon::parse('23:00:00'),]);
    $venue5->dates()->create(['week_day' => 2, 'start' => Carbon::parse('8:00:00'), 'finish' => Carbon::parse('23:00:00'),]);
    $venue5->dates()->create(['week_day' => 3, 'start' => Carbon::parse('8:00:00'), 'finish' => Carbon::parse('23:00:00'),]);
    $venue5->dates()->create(['week_day' => 4, 'start' => Carbon::parse('8:00:00'), 'finish' => Carbon::parse('23:00:00'),]);
    $venue5->dates()->create(['week_day' => 5, 'start' => Carbon::parse('8:00:00'), 'finish' => Carbon::parse('23:00:00'),]);
    $venue5->dates()->create(['week_day' => 6, 'start' => Carbon::parse('8:00:00'), 'finish' => Carbon::parse('23:00:00'),]);
    $venue5->dates()->create(['week_day' => 7, 'start' => Carbon::parse('8:00:00'), 'finish' => Carbon::parse('23:00:00'),]);
    $venue6->dates()->create(['week_day' => 1, 'start' => Carbon::parse('8:00:00'), 'finish' => Carbon::parse('23:00:00'),]);
    $venue6->dates()->create(['week_day' => 2, 'start' => Carbon::parse('8:00:00'), 'finish' => Carbon::parse('23:00:00'),]);
    $venue6->dates()->create(['week_day' => 3, 'start' => Carbon::parse('8:00:00'), 'finish' => Carbon::parse('23:00:00'),]);
    $venue6->dates()->create(['week_day' => 4, 'start' => Carbon::parse('8:00:00'), 'finish' => Carbon::parse('23:00:00'),]);
    $venue6->dates()->create(['week_day' => 5, 'start' => Carbon::parse('8:00:00'), 'finish' => Carbon::parse('23:00:00'),]);
    $venue6->dates()->create(['week_day' => 6, 'start' => Carbon::parse('8:00:00'), 'finish' => Carbon::parse('23:00:00'),]);
    $venue6->dates()->create(['week_day' => 7, 'start' => Carbon::parse('8:00:00'), 'finish' => Carbon::parse('23:00:00'),]);
    $venue7->dates()->create(['week_day' => 1, 'start' => Carbon::parse('8:00:00'), 'finish' => Carbon::parse('23:00:00'),]);
    $venue7->dates()->create(['week_day' => 2, 'start' => Carbon::parse('8:00:00'), 'finish' => Carbon::parse('23:00:00'),]);
    $venue7->dates()->create(['week_day' => 3, 'start' => Carbon::parse('8:00:00'), 'finish' => Carbon::parse('23:00:00'),]);
    $venue7->dates()->create(['week_day' => 4, 'start' => Carbon::parse('8:00:00'), 'finish' => Carbon::parse('23:00:00'),]);
    $venue7->dates()->create(['week_day' => 5, 'start' => Carbon::parse('8:00:00'), 'finish' => Carbon::parse('23:00:00'),]);
    $venue7->dates()->create(['week_day' => 6, 'start' => Carbon::parse('8:00:00'), 'finish' => Carbon::parse('23:00:00'),]);
    $venue7->dates()->create(['week_day' => 7, 'start' => Carbon::parse('8:00:00'), 'finish' => Carbon::parse('23:00:00'),]);
    $venue8->dates()->create(['week_day' => 1, 'start' => Carbon::parse('8:00:00'), 'finish' => Carbon::parse('23:00:00'),]);
    $venue8->dates()->create(['week_day' => 2, 'start' => Carbon::parse('8:00:00'), 'finish' => Carbon::parse('23:00:00'),]);
    $venue8->dates()->create(['week_day' => 3, 'start' => Carbon::parse('8:00:00'), 'finish' => Carbon::parse('23:00:00'),]);
    $venue8->dates()->create(['week_day' => 4, 'start' => Carbon::parse('8:00:00'), 'finish' => Carbon::parse('23:00:00'),]);
    $venue8->dates()->create(['week_day' => 5, 'start' => Carbon::parse('8:00:00'), 'finish' => Carbon::parse('23:00:00'),]);
    $venue8->dates()->create(['week_day' => 6, 'start' => Carbon::parse('8:00:00'), 'finish' => Carbon::parse('23:00:00'),]);
    $venue8->dates()->create(['week_day' => 7, 'start' => Carbon::parse('8:00:00'), 'finish' => Carbon::parse('23:00:00'),]);
    $venue9->dates()->create(['week_day' => 1, 'start' => Carbon::parse('8:00:00'), 'finish' => Carbon::parse('23:00:00'),]);
    $venue9->dates()->create(['week_day' => 2, 'start' => Carbon::parse('8:00:00'), 'finish' => Carbon::parse('23:00:00'),]);
    $venue9->dates()->create(['week_day' => 3, 'start' => Carbon::parse('8:00:00'), 'finish' => Carbon::parse('23:00:00'),]);
    $venue9->dates()->create(['week_day' => 4, 'start' => Carbon::parse('8:00:00'), 'finish' => Carbon::parse('23:00:00'),]);
    $venue9->dates()->create(['week_day' => 5, 'start' => Carbon::parse('8:00:00'), 'finish' => Carbon::parse('23:00:00'),]);
    $venue9->dates()->create(['week_day' => 6, 'start' => Carbon::parse('8:00:00'), 'finish' => Carbon::parse('23:00:00'),]);
    $venue9->dates()->create(['week_day' => 7, 'start' => Carbon::parse('8:00:00'), 'finish' => Carbon::parse('23:00:00'),]);
    $venue10->dates()->create(['week_day' => 1, 'start' => Carbon::parse('8:00:00'), 'finish' => Carbon::parse('20:00:00'),]);
    $venue10->dates()->create(['week_day' => 2, 'start' => Carbon::parse('8:00:00'), 'finish' => Carbon::parse('20:00:00'),]);
    $venue10->dates()->create(['week_day' => 3, 'start' => Carbon::parse('8:00:00'), 'finish' => Carbon::parse('20:00:00'),]);
    $venue10->dates()->create(['week_day' => 4, 'start' => Carbon::parse('8:00:00'), 'finish' => Carbon::parse('20:00:00'),]);
    $venue10->dates()->create(['week_day' => 5, 'start' => Carbon::parse('8:00:00'), 'finish' => Carbon::parse('20:00:00'),]);
    $venue10->dates()->create(['week_day' => 6, 'start' => Carbon::parse('8:00:00'), 'finish' => Carbon::parse('20:00:00'),]);
    $venue10->dates()->create(['week_day' => 7, 'start' => Carbon::parse('8:00:00'), 'finish' => Carbon::parse('8:00:00'),]);
    $venue11->dates()->create(['week_day' => 1, 'start' => Carbon::parse('8:00:00'), 'finish' => Carbon::parse('20:00:00'),]);
    $venue11->dates()->create(['week_day' => 2, 'start' => Carbon::parse('8:00:00'), 'finish' => Carbon::parse('20:00:00'),]);
    $venue11->dates()->create(['week_day' => 3, 'start' => Carbon::parse('8:00:00'), 'finish' => Carbon::parse('20:00:00'),]);
    $venue11->dates()->create(['week_day' => 4, 'start' => Carbon::parse('8:00:00'), 'finish' => Carbon::parse('20:00:00'),]);
    $venue11->dates()->create(['week_day' => 5, 'start' => Carbon::parse('8:00:00'), 'finish' => Carbon::parse('20:00:00'),]);
    $venue11->dates()->create(['week_day' => 6, 'start' => Carbon::parse('8:00:00'), 'finish' => Carbon::parse('20:00:00'),]);
    $venue11->dates()->create(['week_day' => 7, 'start' => Carbon::parse('8:00:00'), 'finish' => Carbon::parse('8:00:00'),]);
    $venue12->dates()->create(['week_day' => 1, 'start' => Carbon::parse('10:00:00'), 'finish' => Carbon::parse('21:00:00'),]);
    $venue12->dates()->create(['week_day' => 2, 'start' => Carbon::parse('10:00:00'), 'finish' => Carbon::parse('21:00:00'),]);
    $venue12->dates()->create(['week_day' => 3, 'start' => Carbon::parse('10:00:00'), 'finish' => Carbon::parse('21:00:00'),]);
    $venue12->dates()->create(['week_day' => 4, 'start' => Carbon::parse('10:00:00'), 'finish' => Carbon::parse('21:00:00'),]);
    $venue12->dates()->create(['week_day' => 5, 'start' => Carbon::parse('10:00:00'), 'finish' => Carbon::parse('21:00:00'),]);
    $venue12->dates()->create(['week_day' => 6, 'start' => Carbon::parse('10:00:00'), 'finish' => Carbon::parse('21:00:00'),]);
    $venue12->dates()->create(['week_day' => 7, 'start' => Carbon::parse('10:00:00'), 'finish' => Carbon::parse('21:00:00'),]);
    $venue13->dates()->create(['week_day' => 1, 'start' => Carbon::parse('10:00:00'), 'finish' => Carbon::parse('17:00:00'),]);
    $venue13->dates()->create(['week_day' => 2, 'start' => Carbon::parse('10:00:00'), 'finish' => Carbon::parse('17:00:00'),]);
    $venue13->dates()->create(['week_day' => 3, 'start' => Carbon::parse('10:00:00'), 'finish' => Carbon::parse('17:00:00'),]);
    $venue13->dates()->create(['week_day' => 4, 'start' => Carbon::parse('10:00:00'), 'finish' => Carbon::parse('17:00:00'),]);
    $venue13->dates()->create(['week_day' => 5, 'start' => Carbon::parse('10:00:00'), 'finish' => Carbon::parse('17:00:00'),]);
    $venue13->dates()->create(['week_day' => 6, 'start' => Carbon::parse('10:00:00'), 'finish' => Carbon::parse('17:00:00'),]);
    $venue13->dates()->create(['week_day' => 7, 'start' => Carbon::parse('8:00:00'), 'finish' => Carbon::parse('8:00:00'),]);
    $venue14->dates()->create(['week_day' => 1, 'start' => Carbon::parse('8:00:00'), 'finish' => Carbon::parse('23:00:00'),]);
    $venue14->dates()->create(['week_day' => 2, 'start' => Carbon::parse('8:00:00'), 'finish' => Carbon::parse('23:00:00'),]);
    $venue14->dates()->create(['week_day' => 3, 'start' => Carbon::parse('8:00:00'), 'finish' => Carbon::parse('23:00:00'),]);
    $venue14->dates()->create(['week_day' => 4, 'start' => Carbon::parse('8:00:00'), 'finish' => Carbon::parse('23:00:00'),]);
    $venue14->dates()->create(['week_day' => 5, 'start' => Carbon::parse('8:00:00'), 'finish' => Carbon::parse('23:00:00'),]);
    $venue14->dates()->create(['week_day' => 6, 'start' => Carbon::parse('8:00:00'), 'finish' => Carbon::parse('23:00:00'),]);
    $venue14->dates()->create(['week_day' => 7, 'start' => Carbon::parse('8:00:00'), 'finish' => Carbon::parse('23:00:00'),]);
    $venue15->dates()->create(['week_day' => 1, 'start' => Carbon::parse('8:00:00'), 'finish' => Carbon::parse('23:00:00'),]);
    $venue15->dates()->create(['week_day' => 2, 'start' => Carbon::parse('8:00:00'), 'finish' => Carbon::parse('23:00:00'),]);
    $venue15->dates()->create(['week_day' => 3, 'start' => Carbon::parse('8:00:00'), 'finish' => Carbon::parse('23:00:00'),]);
    $venue15->dates()->create(['week_day' => 4, 'start' => Carbon::parse('8:00:00'), 'finish' => Carbon::parse('23:00:00'),]);
    $venue15->dates()->create(['week_day' => 5, 'start' => Carbon::parse('8:00:00'), 'finish' => Carbon::parse('23:00:00'),]);
    $venue15->dates()->create(['week_day' => 6, 'start' => Carbon::parse('8:00:00'), 'finish' => Carbon::parse('23:00:00'),]);
    $venue15->dates()->create(['week_day' => 7, 'start' => Carbon::parse('8:00:00'), 'finish' => Carbon::parse('23:00:00'),]);
    $venue16->dates()->create(['week_day' => 1, 'start' => Carbon::parse('10:00:00'), 'finish' => Carbon::parse('21:00:00'),]);
    $venue16->dates()->create(['week_day' => 2, 'start' => Carbon::parse('10:00:00'), 'finish' => Carbon::parse('21:00:00'),]);
    $venue16->dates()->create(['week_day' => 3, 'start' => Carbon::parse('10:00:00'), 'finish' => Carbon::parse('21:00:00'),]);
    $venue16->dates()->create(['week_day' => 4, 'start' => Carbon::parse('10:00:00'), 'finish' => Carbon::parse('21:00:00'),]);
    $venue16->dates()->create(['week_day' => 5, 'start' => Carbon::parse('10:00:00'), 'finish' => Carbon::parse('21:00:00'),]);
    $venue16->dates()->create(['week_day' => 6, 'start' => Carbon::parse('10:00:00'), 'finish' => Carbon::parse('21:00:00'),]);
    $venue16->dates()->create(['week_day' => 7, 'start' => Carbon::parse('10:00:00'), 'finish' => Carbon::parse('21:00:00'),]);
    $venue17->dates()->create(['week_day' => 1, 'start' => Carbon::parse('10:00:00'), 'finish' => Carbon::parse('21:00:00'),]);
    $venue17->dates()->create(['week_day' => 2, 'start' => Carbon::parse('10:00:00'), 'finish' => Carbon::parse('21:00:00'),]);
    $venue17->dates()->create(['week_day' => 3, 'start' => Carbon::parse('10:00:00'), 'finish' => Carbon::parse('21:00:00'),]);
    $venue17->dates()->create(['week_day' => 4, 'start' => Carbon::parse('10:00:00'), 'finish' => Carbon::parse('21:00:00'),]);
    $venue17->dates()->create(['week_day' => 5, 'start' => Carbon::parse('10:00:00'), 'finish' => Carbon::parse('21:00:00'),]);
    $venue17->dates()->create(['week_day' => 6, 'start' => Carbon::parse('10:00:00'), 'finish' => Carbon::parse('21:00:00'),]);
    $venue17->dates()->create(['week_day' => 7, 'start' => Carbon::parse('10:00:00'), 'finish' => Carbon::parse('21:00:00'),]);
    $venue18->dates()->create(['week_day' => 1, 'start' => Carbon::parse('8:00:00'), 'finish' => Carbon::parse('23:00:00'),]);
    $venue18->dates()->create(['week_day' => 2, 'start' => Carbon::parse('8:00:00'), 'finish' => Carbon::parse('23:00:00'),]);
    $venue18->dates()->create(['week_day' => 3, 'start' => Carbon::parse('8:00:00'), 'finish' => Carbon::parse('23:00:00'),]);
    $venue18->dates()->create(['week_day' => 4, 'start' => Carbon::parse('8:00:00'), 'finish' => Carbon::parse('23:00:00'),]);
    $venue18->dates()->create(['week_day' => 5, 'start' => Carbon::parse('8:00:00'), 'finish' => Carbon::parse('23:00:00'),]);
    $venue18->dates()->create(['week_day' => 6, 'start' => Carbon::parse('8:00:00'), 'finish' => Carbon::parse('23:00:00'),]);
    $venue18->dates()->create(['week_day' => 7, 'start' => Carbon::parse('8:00:00'), 'finish' => Carbon::parse('23:00:00'),]);
  }
}
