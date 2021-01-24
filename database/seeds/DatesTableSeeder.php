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
        $venues = Venue::all();
        foreach ($venues as $venue) {
            for ($week_days = 1; $week_days <= 7; $week_days++) {
                $venue->dates()->create([
                    'venue_id' => $venue->id,
                    'week_day' => $week_days,
                    'start' => Carbon::parse('08:00'),
                    'finish' => Carbon::parse('23:00'),
                ]);
            };
        }
    }
}
