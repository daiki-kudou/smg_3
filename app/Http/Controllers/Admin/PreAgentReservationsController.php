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

    if (count($judge_count) == 1) {
      $venue = Venue::find($request->pre_venue0);
      return view('admin.pre_agent_reservations.single_check', [
        'request' => $request,
        'venue' => $venue,
      ]);
    } else {
    }
  }

  public function calculate(Request $request)
  {
    $agent = Agent::find($request->agent_id);
    $venue = Venue::find($request->venue_id);
    $price = $agent->agentPriceCalculate($request->enduser_charge);
    if ($request->layout_prepare == 1) {
      $layout_prepare = $venue->getLayoutPrice($request->layout_prepare, $request->layout_clean)[0];
    } else {
      $layout_prepare = 0;
    }
    if ($request->layout_clean == 1) {
      $layout_clean = $venue->getLayoutPrice($request->layout_prepare, $request->layout_clean)[1];
    } else {
      $layout_clean = 0;
    }

    return view('admin.pre_agent_reservations.single_calculate', [
      'agent' => $agent,
      'request' => $request,
      'venue' => $venue,
      'price' => $price,
      'layout_prepare' => $layout_prepare,
      'layout_clean' => $layout_clean,
    ]);
  }

  public function store(Request $request)
  {
    $agent = Agent::find($request->agent_id);
    $venue = Venue::find($request->venue_id);

    $pre_reservation = new PreReservation;
    $pre_reservation->AgentSingleStore($request, $agent, $venue);

    $request->session()->regenerate();
    return redirect('admin/pre_reservations');
  }
}
