<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Reservation;
use App\Models\Venue;
use App\Models\Agent;


class AgentsReservationsController extends Controller
{
  public function index()
  {
    $venues = Venue::all();
    $agents = Agent::all();
    return view('admin.agents_reservations.index', [
      'venues' => $venues,
      'agents' => $agents,
    ]);
  }
  // ajax get agent
  public function get_agent(Request $request)
  {
    $agent = Agent::find($request->agent_id);

    return [
      $agent->cost,
      $agent->person_firstname,
      $agent->person_lastname,
    ];
  }
}
