<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Reservation;
use App\Models\Bill;
use App\Models\Breakdown;
use App\Models\Venue;
use App\Models\Agent;
use App\Models\Enduser;
use App\Models\Equipment;
use App\Models\Service;

use Carbon\Carbon;

use Illuminate\Support\Facades\DB; //トランザクション用


use App\Traits\PregTrait;
use App\Traits\InvoiceTrait;


class AgentsReservationsController extends Controller
{
  use PregTrait;
  use InvoiceTrait;

  public function __construct()
  {
    $venues = Venue::all();
    $this->venues = $venues;
    $agents = Agent::all();
    $this->agents = $agents;
  }

  public function create()
  {
    session()->forget(['master_info', 'calc_info', 'reservation', 'bill', 'breakdown']);
    $venues = Venue::orderBy("id", "desc")->get();
    $agents = Agent::orderBy("id", "desc")->get();
    return view('admin.agents_reservations.create', compact('venues', 'agents'));
  }

  public function storeSession(Request $request)
  {
    $data = $request->all();
    $request->session()->put('master_info', $data);
    $calcData = $this->calcSession($request);
    $request->session()->put('calc_info', $calcData);
    return redirect(route('admin.agents_reservations.calculate'));
  }

  public function calcSession($request)
  {
    $agent = Agent::find($request->agent_id);
    $price = $agent->agentPriceCalculate($request->end_user_charge);
    $payment_limit = $agent->getAgentPayLimit($request->reserve_date, $agent->payment_limit);
    $carbon1 = new Carbon($request->enter_time);
    $carbon2 = new Carbon($request->leave_time);
    $usage_hours = ($carbon1->diffInMinutes($carbon2)) / 60;
    return [$price, $payment_limit, $usage_hours];
  }

  public function calculate(Request $request)
  {
    $master_info = $request->session()->get('master_info');
    $calc_info = $request->session()->get('calc_info');
    $discount_info = $request->session()->get('discount_info');
    $check_info = $request->session()->get('check_info');
    $venues = Venue::all();
    $agents = Agent::all();
    $_equipment = $this->preg($master_info, 'equipment_breakdown');
    $_service = $this->preg($master_info, 'services_breakdown');
    if (empty($master_info['layout_prepare']) && empty($master_info['layout_clean'])) {
      $layoutPrice = 0;
    } else {
      $layoutPrice = $venues->find($master_info['venue_id'])->getLayoutPrice($master_info['layout_prepare'], $master_info['layout_clean']);
    }
    $price = (!empty($layoutPrice[2]) ? $layoutPrice[2] : 0) + (floor($calc_info[0]));
    return view(
      'admin.agents_reservations.calculate',
      compact(
        'venues',
        'agents',
        'master_info',
        'calc_info',
        'discount_info',
        'layoutPrice',
        'price',
        '_equipment',
        '_service',
        'check_info'
      )
    );
  }

  public function checkSession(Request $request)
  {
    $data = $request->all();
    $request->session()->put('check_info', $data);
    return redirect(route('admin.agents_reservations.check'));
  }


  public function check(Request $request)
  {
    $data = $request->session()->get('add_bill');
    $master_info = $request->session()->get('master_info');
    $calc_info = $request->session()->get('calc_info');
    $check_info = $request->session()->get('check_info');
    $venue = Venue::find($master_info['venue_id']);
    return view(
      'admin.agents_reservations.check',
      compact('master_info', 'calc_info', 'check_info', 'venue')
    );
  }

  public function store(Request $request)
  {
    $data = $request->all();
    $reservation = new Reservation;
    $bill = new Bill;
    $breakdowns = new Breakdown;
    $enduser = new Enduser;
    DB::beginTransaction();
    try {
      $result_reservation = $reservation->ReservationStore($data);
      if ($result_reservation === "重複") {
        throw new \Exception("選択された会場・日付・利用時間は既に利用済みです。");
      }
      $enduser->endUserStore($result_reservation->id, $data);
      $result_bill = $bill->BillStore($result_reservation->id, $data);
      $result_breakdowns = $breakdowns->BreakdownStore($result_bill->id, $data);
      DB::commit();
    } catch (\Exception $e) {
      DB::rollback();
      return back()->withInput()->withErrors($e->getMessage());
    }
    $request->session()->regenerate();
    return redirect()->route('admin.reservations.index');
  }

  public function add_bills(Request $request)
  {
    $data = $request->all();
    $reservation = Reservation::with(['agent'])->find($request->reservation_id);
    $agent = $reservation->agent;
    $percent = $agent->cost;
    $payment_limit = $reservation->agent->getAgentPayLimit($reservation->reserve_date);
    // $reservation = $reservation->toArray();
    return view('admin.agents_reservations.add_bills', compact(['data', 'reservation', 'percent', 'payment_limit', 'agent']));
  }

  public function add_check(Request $request)
  {
    $data = $request->all();
    $venues = $this->preg($data, 'venue_breakdown_item');
    $equipments = $this->preg($data, 'equipment_breakdown_item');
    $layouts = $this->preg($data, 'layout_breakdown_item');
    $others = $this->preg($data, 'others_breakdown_item');
    return view('admin.agents_reservations.add_check', compact(
      'data',
      'venues',
      'equipments',
      'layouts',
      'others',
    ));
  }
  public function add_store(Request $request)
  {
    $data = $request->all();

    if ($request->back) {
      return redirect(route('admin.agents_reservations.add_bills', $data));
    }

    $bill = new Bill;
    $breakdowns = new Breakdown;
    DB::beginTransaction();
    try {
      $result_bill = $bill->BillStore($data['reservation_id'], $data);
      $result_breakdowns = $breakdowns->BreakdownStore($result_bill->id, $data);
      DB::commit();
    } catch (\Exception $e) {
      DB::rollback();
      return redirect(route('admin.agents_reservations.add_bills', $data))->withErrors($e->getMessage());
    }

    $request->session()->regenerate();
    return redirect()->route('admin.reservations.show', $request->reservation_id);
  }

  public function add_confirm(Request $request)
  {
    DB::transaction(function () use ($request) {
      $bill = Bill::find($request->bill_id);
      $bill->update(
        [
          'reservation_status' => 3,
          'approve_send_at' => date('Y-m-d H:i:s'),
          'cfm_at' => date('Y-m-d H:i:s')
        ]
      );
    });

    $request->session()->regenerate();
    $bill = Bill::find($request->bill_id);
    return redirect()->route('admin.reservations.show', $bill->reservation->id);
  }

  public function edit($id)
  {
    $reservation = Reservation::with(['bills', 'bills.breakdowns', 'enduser'])->find($id)->toArray();
    $venue = Venue::find($reservation['venue_id']);
    $agents = Agent::all();
    $discounts = collect($reservation['bills'][0]['breakdowns'])->filter(function ($value, $key) {
      if (strpos($value['unit_item'], '割引料金') !== false) {
        return $value['unit_cost'];
      }
    });
    $discounts = - ($discounts->pluck('unit_cost')->sum());
    return view(
      'admin.agents_reservations.edit',
      compact(
        'reservation',
        'venue',
        'agents',
        'discounts',
      )
    );
  }

  public function editCheck(Request $request)
  {
    $data = $request->all();
    // dd($data);
    if ($request->edit_calc) { //再計算ボタン押下
      return $this->edit_calc($data);
    }

    $venue = Venue::find($data['venue_id']);
    $agents = Agent::all();
    return view('admin.agents_reservations.edit_check', compact(
      'data',
      'venue',
      'agents',
    ));
  }

  public function edit_calc($array)
  {
    $data = $array;
    // dd($data);
    $venue = Venue::find($data['venue_id']);
    $agents = Agent::all();
    $agent = $agents->find($data['agent_id']);
    if (!empty($data['layout_prepare']) || !empty($data['layout_clean'])) {
      $layout_price = $venue->getLayoutPrice(!empty($data['layout_prepare']) ? $data['layout_prepare'] : 0, !empty($data['layout_clean']) ? $data['layout_clean'] : 0);
    } else {
      $layout_price = [0, 0, 0];
    }
    $master_subtotal = $agent->agentPriceCalculate($data['end_user_charge']) + $layout_price[2];
    $payment_limit = $agent->getAgentPayLimit($data['reserve_date']);

    $s_equipment = Equipment::getSessionArrays(collect($data))[0];
    $s_services = Service::getSessionArrays(collect($data))[0];
    $item_details = $venue->calculate_items_price($s_equipment, $s_services);
    $layouts_details = $layout_price;

    return view('admin.agents_reservations.edit_calc', compact(
      'data',
      'venue',
      'agents',
      'master_subtotal',
      'payment_limit',
      's_equipment',
      's_services',
      'item_details',
      'layouts_details',
    ));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request)
  {
    $data = $request->all();
    if (!empty($data['back'])) {
      return redirect(route('admin.agents_reservations.edit', $data['reservation_id']));
    }
    // dd($data);

    $reservation = Reservation::find($data['reservation_id']);
    $bill = Bill::with('breakdowns')->find($data['bill_id']);
    $breakdown = new Breakdown;
    $endUser = Enduser::where('reservation_id', $data['reservation_id'])->first();
    DB::beginTransaction();
    try {
      $result_reservation = $reservation->ReservationUpdate($data);
      if ($result_reservation === "重複") {
        throw new \Exception("選択された会場・日付・利用時間は既に利用済みです。");
      }
      $endUser->endUserUpdate($data);
      $result_bill = $bill->BillUpdate($data, $bill->reservation_status, $bill->double_check_status);
      $bill->breakdowns->map(function ($item) {
        return $item->delete();
      });
      $result_breakdowns = $breakdown->BreakdownStore($result_bill->id, $data);
      DB::commit();
    } catch (\Exception $e) {
      DB::rollback();
      // dd($e->getMessage());
      return $this->edit($reservation->id)->withErrors($e->getMessage());
      // return back()->withInput()->withErrors($e->getMessage());
    }
    $request->session()->regenerate();
    return redirect()->route('admin.reservations.show', $reservation->id);
  }
}
