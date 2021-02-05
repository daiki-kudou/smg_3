<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Reservation;
use App\Models\Venue;
use App\Models\Agent;


class AgentsReservationsController extends Controller
{
  public function create()
  {
    $venues = Venue::select('id', 'name_area', 'name_bldg', 'name_venue')->get();
    // $agents = Agent::select('id', 'name', 'person_firstname', 'person_lastname', 'email')->get();

    $agents = Agent::all();
    return view('admin.agents_reservations.create', [
      'venues' => $venues,
      'agents' => $agents,
    ]);
  }

  public function calculate(Request $request)
  {
    $agent = Agent::find($request->agent_id);
    $price = $agent->agentPriceCalculate($request->enduser_charge);
    $venues = Venue::select('id', 'name_area', 'name_bldg', 'name_venue')->get();
    $agents = Agent::all();

    $requests = $request->all();

    return view('admin.agents_reservations.calculate', [
      'price' => $price,
      'venues' => $venues,
      'agents' => $agents,
      'requests' => $requests,
    ]);
  }




  // // ajax get agent
  // public function get_agent(Request $request)
  // {
  //   $agent = Agent::find($request->agent_id);

  //   return [
  //     $agent->cost,
  //     $agent->person_firstname,
  //     $agent->person_lastname,
  //   ];
  // }

  // // ajax paymentlimits
  // public function pay_limits(Request $request)
  // {
  //   $agent = Agent::find($request->agent_id);
  //   $result = $agent->getPayDetails($request->date);
  //   return $result;
  // }

  public function check(Request $request)
  {
    echo "<pre>";
    var_dump($request->all());
    echo "</pre>";

    return view('admin.agents_reservations.check', [
      'request' => $request
    ]);
  }
}
