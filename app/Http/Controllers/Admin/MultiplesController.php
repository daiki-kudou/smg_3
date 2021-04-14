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

use Illuminate\Support\Facades\Validator;




class MultiplesController extends Controller
{
  use SearchTrait; //検索用トレイト

  public function index(Request $request)
  {
    if (count($request->all()) != 0) {
      $class = new MultipleReserve;
      $multiples = $this->MultipleSearch($class->with(["pre_reservations.unknown_user", "pre_reservations.pre_enduser"]), $request);
      $counter = count($multiples);
    } else {
      $multiples = MultipleReserve::with(["pre_reservations.unknown_user", "pre_reservations.pre_enduser"])->orderBy('id', 'desc')->paginate(30);
      $counter = count($multiples);
    }

    // $user = User::find(1);
    $agents = Agent::all();

    // var_dump($multiples);
    return view('admin.multiples.index', compact('multiples', "counter", "request", "agents"));
  }

  public function show($id)
  {
    $multiple = MultipleReserve::with("pre_reservations.pre_bill")->find($id);
    $venues = PreReservation::where("multiple_reserve_id", $id)->distinct()->select("venue_id")->get();
    $venue_count = $venues->count("venue_id");
    $checkVenuePrice = $multiple->checkVenuePrice();
    $checkEachStatus = $multiple->checkEachStatus();

    return view(
      'admin.multiples.show',
      compact('multiple', 'venue_count', 'venues', 'checkVenuePrice', 'checkEachStatus')
    );
  }

  public function switch($id)
  {
    $multiple = MultipleReserve::find($id);
    $venues = $multiple->pre_reservations()->distinct()->select('venue_id')->get();
    $venue_count = $venues->count('venue_id');
    $users = User::all();

    return view('admin.multiples.switch', [
      'multiple' => $multiple,
      'venue_count' => $venue_count,
      'venues' => $venues,
      'users' => $users,
    ]);
  }

  public function switchAgent($id)
  {
    $multiple = MultipleReserve::find($id);
    $venues = $multiple->pre_reservations()->distinct()->select('venue_id')->get();
    $venue_count = $venues->count('venue_id');
    $pre_enduser = $multiple->pre_reservations()->first()->pre_enduser;
    $agents = Agent::all();

    return view('admin.multiples.switch_agent', compact('multiple', 'venue_count', 'venues', 'agents', 'pre_enduser'));
  }

  public function switchAgent_cfm(Request $request, $id)
  {
    DB::transaction(function () use ($request, $id) { //トランザクションさせる
      $multiple = MultipleReserve::find($id);
      foreach ($multiple->pre_reservations()->get() as $key => $pre_reservation) {
        $pre_reservation->update([
          'agent_id' => $request->agent_id
        ]);
        $pre_reservation->pre_enduser()->delete();
        $pre_reservation->pre_enduser()->create([
          "pre_reservation_id" => $pre_reservation->id,
          "company" => $request->end_user_company,
          "person" => $request->end_user_name,
          "tel" => $request->end_user_tel,
          "mobile" => $request->end_user_mobile,
          "email" => $request->end_user_email,
          "attr" => $request->end_user_attr,
          "address" => $request->end_user_address,
          "charge" => 0,
        ]);
      }
    });
    $request->session()->regenerate();
    return redirect('admin/multiples/agent/' . $id);
  }

  public function switch_cfm(Request $request, $id)
  {
    DB::transaction(function () use ($request, $id) { //トランザクションさせる
      $multiple = MultipleReserve::find($id);
      foreach ($multiple->pre_reservations()->get() as $key => $pre_reservation) {
        $pre_reservation->update([
          'user_id' => $request->user_id
        ]);
        $pre_reservation->unknown_user()->delete();
        $pre_reservation->unknown_user()->create([
          "pre_reservation_id" => $pre_reservation->id,
          "unknown_user_company" => $request->unknown_user_company,
          "unknown_user_name" => $request->unknown_user_name,
          "unknown_user_email" => $request->unknown_user_email,
          "unknown_user_mobile" => $request->unknown_user_mobile,
          "unknown_user_tel" => $request->unknown_user_tel,
        ]);
      }
    });
    $request->session()->regenerate();
    return redirect('admin/multiples/' . $id);
  }

  public function switchStatus(Request $request)
  {
    var_dump($request->all());
    $multiple = MultipleReserve::find($request->multiple_id);
    DB::transaction(function () use ($multiple) {
      foreach ($multiple->pre_reservations()->get() as $key => $value) {
        $value->update(['status' => 1]);
      }
    });

    $request->session()->regenerate();
    return redirect()->route('admin.multiples.show', $request->multiple_id);
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
    $validator = Validator::make($request->all(), [
      $masterData->event_name1_copied0 => 'required',
    ]);

    if ($validator->fails()) {
      return redirect(route('admin.multiples.edit', [$multiples_id, $venues_id]))
        ->withErrors($validator)
        ->withInput();
    }



    echo "<pre>";
    var_dump($masterData);
    echo "</pre>";

    echo "<pre>";
    var_dump($masterData->cp_master_event_name1);
    echo "</pre>";


    // $multiple = MultipleReserve::find($multiples_id);
    // $multiple->UpdateAndReCreateAll($masterData, $venues_id);
    // return redirect('admin/multiples/' . $multiples_id . '/edit/' . $venues_id);
  }

  public function add_date($multiple_id, $venue_id)
  {
    $multiple = MultipleReserve::find($multiple_id);
    $venues = $multiple->pre_reservations()->distinct()->select('venue_id')->get();
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
    $venues = $multiple->pre_reservations()->distinct()->select('venue_id')->get();
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
    $venues = $multiple->pre_reservations()->distinct()->select('venue_id')->get();
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
    $venues = $multiple->pre_reservations()->distinct()->select('venue_id')->get();
    $venue_count = $venues->count('venue_id');
    $_venues = Venue::all();
    return view('admin.multiples.agent_show', compact('multiple', 'venues', 'venue_count', '_venues'));
  }

  public function destroy(Request $request)
  {
    $shapeRequest = $request->except(['_method', '_token']);
    if (count($shapeRequest) == 0) {
      $request->session()->regenerate();
      return redirect()->route('admin.multiples.index')->with('flash_message_error', '仮押えが選択されていません');
    } else {
      DB::transaction(function () use ($shapeRequest) {
        foreach ($shapeRequest as $key => $value) {
          $multiple = MultipleReserve::find($value);
          foreach ($multiple->pre_reservations()->get() as $key2 => $value2) {
            foreach ($value2->pre_breakdowns()->get() as $key3 => $value3) {
              $value3->delete();
            }
            foreach ($value2->pre_bill()->get() as $key4 => $value4) {
              $value4->delete();
            }
            $value2->unknown_user()->delete();
            $value2->delete();
          }
          $multiple->delete();
        }
      });
      $request->session()->regenerate();
      return redirect()->route('admin.multiples.index')->with('flash_message', '一括仮押えの削除が完了しました');
    }
  }

  public function SPDestroy(Request $request)
  {
    $shapeRequest = $request->except(['_method', '_token']);
    var_dump($shapeRequest);
  }
}
