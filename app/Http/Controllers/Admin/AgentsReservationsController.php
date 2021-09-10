<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Reservation;
use App\Models\Bill;
use App\Models\Breakdown;
use App\Models\Venue;
use App\Models\Agent;

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
    $payment_limit = $agent->getAgentPayLimit($request->reserve_date);
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
        '_service'
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
    DB::beginTransaction();
    try {
      $result_reservation = $reservation->ReservationStore($data);
      if ($result_reservation === "重複") {
        throw new \Exception("選択された会場・日付・利用時間は既に利用済みです。");
      }
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
    $reservation = $reservation->toArray();
    return view('admin.agents_reservations.add_bills', compact(['data', 'reservation', 'percent', 'payment_limit', 'agent']));
  }

  public function createSession(Request $request)
  {
    $data = $request->all();
    $reservation = Reservation::with('agent')->find($data['reservation_id']);
    $reservation = $reservation->toArray();
    return view('admin.agents_reservations.add_check', compact('data', 'reservation'));
  }

  public function add_check(Request $request)
  {
    $data = $request->session()->get('add_bill');
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
      return $this->add_bills($request);
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
      dump($data);
      dump($e->getMessage());
      return $this->createSession($request)->withErrors($e->getMessage());
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
          'approve_send_at' => date('Y-m-d H:i:s')
        ]
      );
    });

    $request->session()->regenerate();
    $bill = Bill::find($request->bill_id);
    return redirect()->route('admin.reservations.show', $bill->reservation->id);
  }

  public function edit(Request $request)
  {
    $data = $request->all();
    $reservation = Reservation::with('bills.breakdowns')->find($data['reservation_id']);
    $venues = Venue::all();
    $venue = $venues->find($reservation['venue_id']);
    $agents = Agent::all();

    return view(
      'admin.agents_reservations.edit',
      compact('reservation', 'venues', 'venue', 'agents')
    );
  }

  public function editCheck(Request $request)
  {
    $data = $request->all();
    dump($data);
    $venues = $this->venues;
    $venue = $venues->find($data['venue_id']);
    $agents = $this->agents;

    return view("admin.agents_reservations.edit_check", compact('data', 'venues', 'venue', 'agents'));
  }

  public function update(Request $request)
  {
    $data = $request->all();
    if (!empty($data['back'])) {
      return $this->edit($request);
    }
    $reservation = Reservation::with('bills')->find($data['reservation_id']);
    $bill = Bill::find($data['bill_id']);
    $breakdown = new Breakdown;

    $data['reserve_date'] = "aa";
    DB::beginTransaction();
    try {
      $result_reservation = $reservation->ReservationUpdate($data);
      if ($result_reservation === "重複") {
        throw new \Exception("選択された会場・日付・利用時間は既に利用済みです。");
      }
      // $bill->BillUpdate($data);
      // $bill->breakdowns->map(function ($item) {
      //   return $item->delete();
      // });
      // $breakdown->BreakdownStore($data['bill_id'], $data);
      DB::commit();
    } catch (\Exception $e) {
      DB::rollback();
      dd($e);
      return back()->withInput()->withErrors($e->getMessage());
    }
    $request->session()->regenerate();
    return redirect(route('admin.reservations.show', $reservation->id));
    // /////////////////
    // $reservation = new Reservation;
    // $bill = new Bill;
    // $breakdowns = new Breakdown;
    // DB::beginTransaction();
    // try {
    //   $result_reservation = $reservation->ReservationStore($data);
    //   if ($result_reservation === "重複") {
    //     throw new \Exception("選択された会場・日付・利用時間は既に利用済みです。");
    //   }
    //   $result_bill = $bill->BillStore($result_reservation->id, $data);
    //   $result_breakdowns = $breakdowns->BreakdownStore($result_bill->id, $data);
    //   DB::commit();
    // } catch (\Exception $e) {
    //   DB::rollback();

    //   return back()->withInput()->withErrors($e->getMessage());
    // }
    // $request->session()->regenerate();
    // return redirect()->route('admin.reservations.show', $result_reservation->id);
  }

  // public function editShow(Request $request)
  // {
  //   $reservation = $request->session()->get('reservation');
  //   $bill = $request->session()->get('bill');
  //   $breakdown = $request->session()->get('breakdown');
  //   $venue = $reservation->venue;
  //   $agents = Agent::all();

  //   $selected_venue = Venue::find($reservation->venue_id);
  //   return view('admin.agents_reservations.edit', compact('reservation', 'bill', 'breakdown', 'venue', 'agents', 'selected_venue'));
  // }

  // public function addSessionInput(Request $request)
  // {
  //   $data = $request->all();
  //   $request->session()->put('inputs', $data);
  //   return redirect(route('admin.agents_reservations.show_input'));
  // }

  // public function showInput(Request $request)
  // {
  //   $inputs = $request->session()->get('inputs');
  //   $bill = $request->session()->get('bill');
  //   $reservation = $request->session()->get('reservation');
  //   $breakdown = $request->session()->get('breakdown');
  //   $agents = Agent::orderBy("id", "desc")->get();
  //   $venue = Venue::find($inputs['venue_id']);

  //   $price = $agents->find($inputs['agent_id'])->agentPriceCalculate($inputs['end_user_charge']);
  //   $payment_limit = $agents->find($inputs['agent_id'])->getAgentPayLimit($inputs['reserve_date']);
  //   $carbon1 = new Carbon($inputs['enter_time']);
  //   $carbon2 = new Carbon($inputs['leave_time']);
  //   $usage_hours = ($carbon1->diffInMinutes($carbon2)) / 60;

  //   $_equipment = $this->preg($inputs, 'equipment_breakdown');
  //   $_service = $this->preg($inputs, 'services_breakdown');
  //   if (!empty($inputs['layout_prepare']) || !empty($inputs['layout_clean'])) {
  //     $layoutPrice = $venue->getLayoutPrice($inputs['layout_prepare'], $inputs['layout_clean']);
  //   } else {
  //     $layoutPrice = [0, 0];
  //   }
  //   $price = ($layoutPrice[2] ?? 0) + (floor($price));

  //   return view('admin.agents_reservations.edit_calc', compact(
  //     'inputs',
  //     'venue',
  //     'breakdown',
  //     'agents',
  //     'usage_hours',
  //     'layoutPrice',
  //     'layoutPrice',
  //     "price",
  //     "payment_limit",
  //     "reservation",
  //     "bill",
  //   ));
  // }

  // public function editCheckSession(Request $request)
  // {
  //   $data = $request->all();
  //   $request->session()->put('result', $data);
  //   return redirect(route("admin.agents_reservations.edit_check"));
  // }

  // public function editCheck(Request $request)
  // {
  //   $result = $request->session()->get('result');
  //   $inputs = $request->session()->get('inputs');
  //   $venue = Venue::find($inputs['venue_id']);
  //   $agents = Agent::orderBy("id", "desc")->get();

  //   $price = $agents->find($inputs['agent_id'])->agentPriceCalculate($inputs['end_user_charge']);
  //   $payment_limit = $agents->find($inputs['agent_id'])->getAgentPayLimit($inputs['reserve_date']);
  //   $carbon1 = new Carbon($inputs['enter_time']);
  //   $carbon2 = new Carbon($inputs['leave_time']);
  //   $usage_hours = ($carbon1->diffInMinutes($carbon2)) / 60;
  //   if (!empty($inputs['layout_prepare']) || !empty($inputs['layout_clean'])) {
  //     $layoutPrice = $venue->getLayoutPrice($inputs['layout_prepare'], $inputs['layout_clean']);
  //   } else {
  //     $layoutPrice = [0, 0];
  //   }
  //   $price = ($layoutPrice[2] ?? 0) + (floor($price));

  //   $bill = $request->session()->get('bill');
  //   $reservation = $request->session()->get('reservation');
  //   $breakdown = $request->session()->get('breakdown');
  //   $o_count = $this->preg($result, 'others_breakdown_item');

  //   return view(
  //     "admin.agents_reservations.edit_check",
  //     compact(
  //       "result",
  //       "inputs",
  //       "venue",
  //       "payment_limit",
  //       "usage_hours",
  //       "layoutPrice",
  //       "price",
  //       "bill",
  //       "agents",
  //       "o_count",
  //     )
  //   );
  // }

  // public function update(Request $request)
  // {
  //   if ($request->back) {
  //     return redirect(route('admin.agents_reservations.edit_show'));
  //   }

  //   $reservation = $request->session()->get('reservation');
  //   $bill = $request->session()->get('bill');
  //   $breakdown = $request->session()->get('breakdown');
  //   $inputs = $request->session()->get('inputs');
  //   $result = $request->session()->get('result');
  //   try {
  //     $reservation->updateAgentReservation($inputs);
  //     $reservation->UpdateAgentEndUser($inputs);
  //     $bill->updateAgentBill($result);
  //     $bill->updateAgentBreakdown($result, $inputs);
  //   } catch (\Exception $e) {
  //     report($e);
  //     session()->flash('flash_message', '更新に失敗しました。<br>フォーム内の空欄や全角など確認した上でもう一度お試しください。');
  //     return redirect(route('admin.agents_reservations.show_input'));
  //   }
  //   $request->session()->regenerate();
  //   return redirect()->route('admin.reservations.show', $reservation->id);
  // }
}
