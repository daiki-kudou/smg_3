<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\MultipleReserve;
use App\Models\PreReservation;
use App\Models\Venue;
use App\Models\User;
use App\Models\Agent;

use Illuminate\Support\Facades\DB; //トランザクション用

use App\Traits\SearchTrait;



class MultiplesController extends Controller
{
  use SearchTrait; //検索用トレイト

  public function index(Request $request)
  {
    if (count($request->all()) != 0) {
      $class = new MultipleReserve;
      $multiples = $this->BasicSearch($class, $request);
    } else {
      $multiples = MultipleReserve::withCount('pre_reservations')->paginate(30);
    }

    return view('admin.multiples.index', compact('multiples'));
  }

  public function show($id)
  {
    $multiple = MultipleReserve::find($id);
    $venues = $multiple->pre_reservations()->distinct('')->select('venue_id')->get();
    $venue_count = $venues->count('venue_id');

    return view('admin.multiples.show', [
      'multiple' => $multiple,
      'venue_count' => $venue_count,
      'venues' => $venues,

    ]);
  }

  public function switch($id)
  {
    $multiple = MultipleReserve::find($id);
    $venues = $multiple->pre_reservations()->distinct('')->select('venue_id')->get();
    $venue_count = $venues->count('venue_id');
    $users = User::all();

    return view('admin.multiples.switch', [
      'multiple' => $multiple,
      'venue_count' => $venue_count,
      'venues' => $venues,
      'users' => $users,
    ]);
  }

  public function switch_cfm(Request $request, $id)
  {
    DB::transaction(function () use ($request, $id) { //トランザクションさせる
      $multiple = MultipleReserve::find($id);
      foreach ($multiple->pre_reservations()->get() as $key => $pre_reservation) {
        $pre_reservation->update([
          'user_id' => $request->user_id
        ]);
      }
    });
    $request->session()->regenerate();
    return redirect('admin/multiples/' . $id);
  }

  public function edit($multiple_id, $venue_id)
  {
    $multiple = MultipleReserve::find($multiple_id);
    $venue = Venue::find($venue_id);
    return view('admin.multiples.edit', [
      'multiple' => $multiple,
      'venue' => $venue,
    ]);
  }

  public function agent_edit($multiple_id, $venue_id)
  {
    $multiple = MultipleReserve::find($multiple_id);
    $venue = Venue::find($venue_id);
    return view('admin.multiples.agent_edit', [
      'multiple' => $multiple,
      'venue' => $venue,
    ]);
  }

  public function calculate(Request $request, $multiple_id, $venue_id)
  {
    $multiple = MultipleReserve::find($multiple_id);
    $venue = Venue::find($venue_id);
    $result = $multiple->calculateVenue($venue_id, $request); //0に会場料金　1にサービス　2にレイアウト
    $multiple->preStore($venue_id, $request, $result);
    return view('admin.multiples.calculate', [
      'multiple' => $multiple,
      'venue' => $venue,
      'request' => $request,
      'result' => $result,
    ]);
  }

  public function agent_calculate(Request $request, $multiple_id, $venue_id)
  {
    $multiple = MultipleReserve::find($multiple_id);
    // $venue = Venue::find($venue_id);
    $agent = Agent::find($request->agent_id);
    $result = $agent->agentPriceCalculate($request->cp_master_enduser_charge);
    $multiple->AgentPreStore($venue_id, $request, $result);

    return redirect(url('admin/multiples/agent/' . $multiple_id . '/edit/' . $venue_id));
  }

  public function specificUpdate(Request $request, $multiple_id, $venue_id, $pre_reservation_id)
  {
    $pre_reservation = PreReservation::find($pre_reservation_id);
    $result = $pre_reservation->reCalculateVenue($request, $venue_id);
    $pre_reservation->specificUpdate($request, $result, $venue_id);
    return redirect('admin/multiples/' . $multiple_id . '/edit/' . $venue_id);
  }

  public function agent_specificUpdate(Request $request, $multiple_id, $venue_id, $pre_reservation_id)
  {
    $pre_reservation = PreReservation::find($pre_reservation_id);
    $agent = Agent::find($request->agent_id);
    $enduser_charge = [];
    foreach ($request->all() as $key => $value) {
      if (preg_match('/enduser_charge_copied/', $key)) {
        if (!empty($value)) {
          $enduser_charge[] = $value;
        }
      }
    }
    $result = $agent->agentPriceCalculate($enduser_charge[0]);
    $pre_reservation->AgentSpecificUpdate($request, $result, $venue_id, $pre_reservation_id);
    return redirect(url('admin/multiples/agent/' . $multiple_id . '/edit/' . $venue_id));
  }

  public function allUpdates(Request $request, $multiples_id, $venues_id)
  {
    $masterData = json_decode($request->master_data);
    $multiple = MultipleReserve::find($multiples_id);
    $multiple->UpdateAndReCreateAll($masterData, $venues_id);
    return redirect('admin/multiples/' . $multiples_id . '/edit/' . $venues_id);
  }

  public function add_date($multiple_id, $venue_id)
  {
    $multiple = MultipleReserve::find($multiple_id);
    $venues = $multiple->pre_reservations()->distinct('')->select('venue_id')->get();
    $venue_count = $venues->count('venue_id');
    return view('admin.multiples.add_date', compact('multiple', 'venues', 'venue_count', 'venue_id'));
  }

  public function add_date_store(Request $request)
  {
    $multiple = MultipleReserve::find($request->multiple_id);
    $multiple->MultipleStore($request);
    $request->session()->regenerate();
    return redirect('admin/multiples/' . $request->multiple_id);
  }

  public function add_venue($multiple_id)
  {
    $multiple = MultipleReserve::find($multiple_id);
    $venues = $multiple->pre_reservations()->distinct('')->select('venue_id')->get();
    $venue_count = $venues->count('venue_id');
    $_venues = Venue::all();
    return view('admin.multiples.add_venue', compact('multiple', 'venues', 'venue_count', '_venues'));
  }

  public function add_venue_store(Request $request)
  {
    $multiple = MultipleReserve::find($request->multiple_id);
    $multiple->MultipleStore($request);
    $request->session()->regenerate();
    return redirect('admin/multiples/' . $request->multiple_id);
  }

  public function agent_add_venue($multiple_id)
  {
    $multiple = MultipleReserve::find($multiple_id);
    $venues = $multiple->pre_reservations()->distinct('')->select('venue_id')->get();
    $venue_count = $venues->count('venue_id');
    $_venues = Venue::all();
    return view('admin.multiples.agent_add_venue', compact('multiple', 'venues', 'venue_count', '_venues'));
  }

  public function agent_add_venue_store(Request $request)
  {
    $multiple = MultipleReserve::find($request->multiple_id);
    $multiple->MultipleStoreForAgent($request);
    $request->session()->regenerate();
    return redirect('admin/multiples/agent/' . $request->multiple_id);
  }


  public function agent_show($multiple_id)
  {
    $multiple = MultipleReserve::find($multiple_id);
    $venues = $multiple->pre_reservations()->distinct('')->select('venue_id')->get();
    $venue_count = $venues->count('venue_id');
    $_venues = Venue::all();
    return view('admin.multiples.agent_show', compact('multiple', 'venues', 'venue_count', '_venues'));
  }
}
