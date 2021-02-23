<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\PreReservation;
use App\Models\MultipleReserve;

use App\Models\Venue;
use App\Models\User;
use App\Models\Agent;


use Illuminate\Support\Facades\DB; //トランザクション用

class PreAgentReservationsController extends Controller
{
  public function create()
  {
    $agents = Agent::all();
    $venues = Venue::all();
    return view('admin.pre_agent_reservations.create', [
      'agents' => $agents,
      'venues' => $venues,
    ]);
  }

  public function check(Request $request)
  {
    $judge_count = [];
    foreach ($request->all() as $key => $value) {
      if (preg_match('/pre_date/', $key)) {
        $judge_count[] = $value;
      }
    }
    echo "<pre>";
    var_dump(($request->all()));
    echo "</pre>";

    if (count($judge_count) == 1) {
      $venue = Venue::find($request->pre_venue0);
      //   $equipments = $venue->equipments()->get();
      //   $services = $venue->services()->get();
      //   $layouts = [];
      //   $layouts[] = $venue->layout_prepare == 0 ? 0 : $venue->layout_prepare;
      //   $layouts[] = $venue->layout_clean == 0 ? 0 : $venue->layout_clean;

      return view('admin.pre_agent_reservations.single_check', [
        'request' => $request,
        // 'equipments' => $equipments,
        // 'services' => $services,
        'venue' => $venue,
        // 'layouts' => $layouts,
      ]);
    } else {
      //   DB::transaction(function () use ($request) { //トランザクションさせる
      //     $multiple = MultipleReserve::create(); //一括IDを作成
      //     $counters = [];
      //     foreach ($request->all() as $key => $value) {
      //       if (preg_match('/pre_date/', $key)) {
      //         $counters[] = $value;
      //       }
      //     }
      //     $counters = count($counters);
      //     for ($i = 0; $i < $counters; $i++) {
      //       $pre_reservations = $multiple->pre_reservations()->create([
      //         'venue_id' => $request->{'pre_venue' . $i},
      //         'user_id' => $request->user_id,
      //         'agent_id' => 0,
      //         'reserve_date' => $request->{'pre_date' . $i},
      //         'enter_time' => $request->{'pre_enter' . $i},
      //         'leave_time' => $request->{'pre_leave' . $i}
      //       ]);
      //       if ($request->unknown_user_company) {
      //         $pre_reservations->unknown_user()->create([
      //           'unknown_user_company' => $request->unknown_user_company,
      //           'unknown_user_name' => $request->unknown_user_name,
      //           'unknown_user_email' => $request->unknown_user_email,
      //           'unknown_user_mobile' => $request->unknown_user_mobile,
      //           'unknown_user_tel' => $request->unknown_user_tel,
      //         ]);
      //       }
      //     }
      //   });

      //   $request->session()->regenerate();
      //   return redirect('admin/multiples');
    }
  }

  public function calculate(Request $request)
  {
    echo "<pre>";
    var_dump($request->all());
    echo "</pre>";
    // $agents = Agent::all();
    // $venues = Venue::all();
    return view('admin.pre_agent_reservations.single_calculate', [
      // 'agents' => $agents,
      // 'venues' => $venues,
    ]);
  }
}
