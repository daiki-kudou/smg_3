<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Reservation;
use App\Models\Venue;
use App\Models\Agent;
use App\Models\Equipment;
use App\Models\Service;
use App\Models\User;

use Carbon\Carbon;

use Illuminate\Support\Facades\DB; //トランザクション用

use App\Models\Bill;

use App\Traits\PregTrait;


class AgentsReservationsController extends Controller
{
  use PregTrait;

  public function create()
  {
    session()->forget(['master_info', 'calc_info', 'reservation', 'bill', 'breakdown']);

    $venues = Venue::all();
    $agents = Agent::all();
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
    $price = $agent->agentPriceCalculate($request->enduser_charge);
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
    $layoutPrice = $venues->find($master_info['venue_id'])->getLayoutPrice($master_info['layout_prepare'], $master_info['layout_clean']);
    $price = ($layoutPrice[2]) + (floor($calc_info[0]));
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
    $reservation = new Reservation();
    $reservation->ReserveFromAgent($request);
    $request->session()->regenerate();
    return redirect()->route('admin.reservations.index');
  }

  public function add_bills(Request $request)
  {
    $reservation = Reservation::with(['agent'])->find($request->reservation_id);
    $pay_limit = $reservation->agent->getAgentPayLimit($reservation->reserve_date);
    $percent = $reservation->agent->cost;
    $data = $request->session()->get('add_bill');
    if (!empty($data)) {
      $venues = $this->preg($data, 'venue_breakdown_item');
      $equipments = $this->preg($data, 'equipment_breakdown_item');
      $layouts = $this->preg($data, 'layout_breakdown_item');
      $others = $this->preg($data, 'others_breakdown_item');
      return view(
        'admin.agents_reservations.add_bills',
        compact('reservation', 'pay_limit', 'data', 'venues', 'equipments', 'layouts', 'others', 'percent')
      );
    } else {
      return view(
        'admin.agents_reservations.add_bills',
        compact('request', 'percent', 'pay_limit', 'reservation',)
      );
    }
  }

  public function createSession(Request $request)
  {
    $request->session()->forget('add_bill');
    $data = $request->all();
    $request->session()->put('add_bill', $data);
    return redirect(route("admin.agents_reservations.add_check"));
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
    $data = $request->session()->get('add_bill');
    if ($request->back) {
      return redirect(route('admin.agents_reservations.add_bills', [
        'reservation_id' => $data['reservation_id'],
        'reserve_date' => $data['reserve_date'],
      ]));
    }
    DB::transaction(function () use ($request) { //トランザクションさせる
      $bill = Bill::create([
        'reservation_id' => $request->reservation_id,
        'venue_price' => 0, //仲介会社の追加請求なのでデフォで0
        'equipment_price' => 0, //仲介会社の追加請求なのでデフォで0
        'layout_price' => $request->layout_price ? $request->layout_price : 0,
        'others_price' => 0, //仲介会社の追加請求なのでデフォで0
        'master_subtotal' => $request->master_subtotal,
        'master_tax' => $request->master_tax,
        'master_total' => $request->master_total,
        'payment_limit' => $request->pay_limit,
        'bill_company' => $request->pay_company,
        'bill_person' => $request->bill_person,
        'bill_created_at' => Carbon::now(),
        'bill_remark' => $request->bill_remark,
        'paid' => $request->paid,
        'pay_day' => $request->pay_day,
        'pay_person' => $request->pay_person,
        'payment' => $request->payment,
        'reservation_status' => 1, //固定で1
        'double_check_status' => 0, //固定で1
        'category' => 2, //1が会場　２が追加請求
        'admin_judge' => 1, //１が管理者　２がユーザー
      ]);

      function storeAndBreakDown($num, $sub, $target, $type)
      {
        $s_arrays = [];
        foreach ($num as $key => $value) {
          if (preg_match("/" . $sub . "/", $key)) {
            $s_arrays[] = $value;
          }
        }
        $counts = (count($s_arrays) / 4);
        for ($i = 0; $i < $counts; $i++) {
          $target->breakdowns()->create([
            'unit_item' => $s_arrays[($i * 4)],
            'unit_cost' => $s_arrays[($i * 4) + 1],
            'unit_count' => $s_arrays[($i * 4) + 2],
            'unit_subtotal' => $s_arrays[($i * 4) + 3],
            'unit_type' => $type,
          ]);
        }
      }
      storeAndBreakDown($request->all(), 'venue_breakdown', $bill, 1);
      storeAndBreakDown($request->all(), 'equipment_breakdown', $bill, 2);
      storeAndBreakDown($request->all(), 'layout_breakdown_', $bill, 4);
      storeAndBreakDown($request->all(), 'others_breakdown', $bill, 5);
    });
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
    $request->session()->forget(['master_info', 'calc_info', 'reservation', 'bill', 'breakdown']);
    $reservation = Reservation::with(['bills.breakdowns', 'venue', 'user', 'agent', 'enduser'])->find($request->reservation_id);
    $bill = $reservation->bills->find($request->bill_id);
    $breakdown = $bill->breakdowns;
    $request->session()->put('reservation', $reservation);
    $request->session()->put('bill', $bill);
    $request->session()->put('breakdown', $breakdown);
    return redirect(route('admin.agents_reservations.edit_show'));
  }

  public function editShow(Request $request)
  {
    $reservation = $request->session()->get('reservation');
    $bill = $request->session()->get('bill');
    $breakdown = $request->session()->get('breakdown');
    $venue = $reservation->venue;
    $agents = Agent::all();
    return view('admin.agents_reservations.edit', compact('reservation', 'bill', 'breakdown', 'venue', 'agents'));
  }

  public function addSessionInput(Request $request)
  {
    $data = $request->all();
    $request->session()->put('inputs', $data);
    return redirect(route('admin.agents_reservations.show_input'));
  }

  public function showInput(Request $request)
  {
    $inputs = $request->session()->get('inputs');
    $bill = $request->session()->get('bill');
    $reservation = $request->session()->get('reservation');
    $breakdown = $request->session()->get('breakdown');
    $agents = Agent::all();
    $venue = Venue::find($inputs['venue_id']);

    $price = $agents->find($inputs['agent_id'])->agentPriceCalculate($inputs['enduser_charge']);
    $payment_limit = $agents->find($inputs['agent_id'])->getAgentPayLimit($inputs['reserve_date']);
    $carbon1 = new Carbon($inputs['enter_time']);
    $carbon2 = new Carbon($inputs['leave_time']);
    $usage_hours = ($carbon1->diffInMinutes($carbon2)) / 60;

    $_equipment = $this->preg($inputs, 'equipment_breakdown');
    $_service = $this->preg($inputs, 'services_breakdown');
    $layoutPrice = $venue->getLayoutPrice($inputs['layout_prepare'], $inputs['layout_clean']);
    $price = ($layoutPrice[2]) + (floor($price));

    return view('admin.agents_reservations.edit_calc', compact(
      'inputs',
      'venue',
      'breakdown',
      'agents',
      'usage_hours',
      'layoutPrice',
      'layoutPrice',
      "price",
      "payment_limit",
      "reservation",
      "bill",
    ));
  }

  public function editCheckSession(Request $request)
  {
    $data = $request->all();
    $request->session()->put('result', $data);
    return redirect(route("admin.agents_reservations.edit_check"));
  }

  public function editCheck(Request $request)
  {
    $result = $request->session()->get('result');
    $inputs = $request->session()->get('inputs');
    $venue = Venue::find($inputs['venue_id']);
    $agents = Agent::all();

    $price = $agents->find($inputs['agent_id'])->agentPriceCalculate($inputs['enduser_charge']);
    $payment_limit = $agents->find($inputs['agent_id'])->getAgentPayLimit($inputs['reserve_date']);
    $carbon1 = new Carbon($inputs['enter_time']);
    $carbon2 = new Carbon($inputs['leave_time']);
    $usage_hours = ($carbon1->diffInMinutes($carbon2)) / 60;
    $layoutPrice = $venue->getLayoutPrice($inputs['layout_prepare'], $inputs['layout_clean']);
    $price = ($layoutPrice[2]) + (floor($price));

    $bill = $request->session()->get('bill');
    $reservation = $request->session()->get('reservation');
    $breakdown = $request->session()->get('breakdown');

    $o_count = $this->preg($result, 'others_breakdown_item');

    return view(
      "admin.agents_reservations.edit_check",
      compact(
        "result",
        "inputs",
        "venue",
        "payment_limit",
        "usage_hours",
        "layoutPrice",
        "price",
        "bill",
        "agents",
        "o_count",
      )
    );
  }

  public function update(Request $request)
  {
    if ($request->back) {
      return redirect(route('admin.agents_reservations.edit_show'));
    }

    $reservation = $request->session()->get('reservation');
    $bill = $request->session()->get('bill');
    $breakdown = $request->session()->get('breakdown');
    $inputs = $request->session()->get('inputs');
    $result = $request->session()->get('result');
    try {
      $reservation->updateAgentReservation($inputs);
      $reservation->UpdateAgentEndUser($inputs);
      $bill->updateAgentBill($result);
      $bill->updateAgentBreakdown($result, $inputs);
    } catch (\Exception $e) {
      report($e);
      session()->flash('flash_message', '更新に失敗しました。<br>フォーム内の空欄や全角など確認した上でもう一度お試しください。');
      return redirect(route('admin.agents_reservations.show_input'));
    }
    $request->session()->regenerate();
    return redirect()->route('admin.reservations.show', $reservation->id);
  }
}
