<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\PreReservation;
use App\Models\MultipleReserve;

use App\Models\Venue;
use App\Models\Agent;
use App\Models\PreBill;
use App\Models\PreBreakdown;


use Illuminate\Support\Facades\DB; //トランザクション用

class PreAgentReservationsController extends Controller
{
  public function create()
  {
    $agents = Agent::orderBy("id", "desc")->get();
    $venues = Venue::orderBy("id", "desc")->get();

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
      $venue = Venue::with(["frame_prices", "time_prices"])->find($request->pre_venue0);
      return view('admin.pre_agent_reservations.single_check', [
        'request' => $request,
        'venue' => $venue,
      ]);
    } else {
      $multiple = MultipleReserve::create(); //一括IDを作成
      $multiple->MultipleStoreForAgent($request);
      $request->session()->regenerate();
      if ($multiple->pre_reservations->first()->user_id > 0) {
        return redirect(route('admin.multiples.show', $multiple->id))->with('flash_message', '仮押さえは完了しました');
      } else {
        return redirect(route('admin.multiples.agent_show', $multiple->id))->with('flash_message', '仮押さえは完了しました');
      }
    }
  }

  public function calculate(Request $request)
  {
    $agent = Agent::find($request->agent_id);
    $venue = Venue::with(["frame_prices", "time_prices"])->find($request->venue_id);
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

    $layout_total = $layout_prepare + $layout_clean;

    return view('admin.pre_agent_reservations.single_calculate', [
      'agent' => $agent,
      'request' => $request,
      'venue' => $venue,
      'price' => $price,
      'layout_prepare' => $layout_prepare,
      'layout_clean' => $layout_clean,
      'layout_total' => $layout_total,
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

  public function edit($pre_reservation)
  {
    $PreReservation = PreReservation::with('pre_bill')->find($pre_reservation);
    $agents = Agent::orderBy("id", "desc")->get();

    $SPVenue = Venue::with(["frame_prices", "time_prices"])->find($PreReservation->venue_id);
    return view('admin.pre_agent_reservations.edit', compact('PreReservation', 'agents', 'SPVenue'));
  }

  public function get_agent(Request $request)
  {
    $agent = Agent::find($request->agent_id);
    return $agent;
  }

  public function edit_calculate(Request $request, $id)
  {
    $agent = Agent::find($request->agent_id);
    $venue = Venue::with(["frame_prices", "time_prices"])->find($request->venue_id);
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
    $layout_total = $layout_prepare + $layout_clean;
    return view('admin.pre_agent_reservations.edit_calculate', [
      'agent' => $agent,
      'request' => $request,
      'venue' => $venue,
      'price' => $price,
      'layout_prepare' => $layout_prepare,
      'layout_clean' => $layout_clean,
      "id" => $id,
      "layout_total" => $layout_total,
    ]);
  }

  public function update(Request $request, $id)
  {
    DB::transaction(function () use ($request, $id) {
      $pre_reservation = PreReservation::find($id);
      foreach ($pre_reservation->pre_breakdowns()->get() as $key => $value) {
        $value->delete();
      }
      $pre_reservation->pre_bill()->delete();
      $pre_reservation->update([
        'agent_id' => $request->agent_id,
        'price_system' => $request->price_system,
        'enter_time' => $request->enter_time,
        'leave_time' => $request->leave_time,
        'board_flag' => $request->board_flag,
        'event_start' => $request->event_start,
        'event_finish' => $request->event_finish,
        'event_name1' => $request->event_name1,
        'event_name2' => $request->event_name2,
        'event_owner' => $request->event_owner,
        'luggage_count' => $request->luggage_count,
        'luggage_arrive' => $request->luggage_arrive,
        'luggage_return' => $request->luggage_return,
        'email_flag' => $request->email_flag,
        'in_charge' => $request->in_charge,
        'tel' => $request->tel,
        'discount_condition' => $request->discount_condition,
        'attention' => $request->attention,
        'user_details' => $request->user_details,
        'admin_details' => $request->admin_details,
        'status' => 0,
        'cost' => $request->cost,
      ]);
      $pre_bill = new PreBill;
      $pre_bill->PreBillCreate($request, $pre_reservation);
      $pre_breakdowns = new PreBreakdown;
      $pre_breakdowns->PreBreakdownCreate($request, $pre_reservation);

      $pre_reservation->pre_enduser()->update([
        'pre_reservation_id' => $pre_reservation->id,
        'company' =>  $request->pre_endusers_company,
        'person' =>  $request->pre_endusers_person,
        'email' => $request->pre_endusers_email,
        'mobile' =>  $request->pre_endusers_mobile,
        'tel' =>  $request->pre_endusers_tel,
        'charge' =>  $request->enduser_charge,
        "attr" => $request->pre_enduser_attr,
      ]);
    });
    return redirect(route('admin.pre_reservations.show', $id));
  }
}
