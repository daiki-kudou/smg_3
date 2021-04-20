<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Reservation;
use App\Models\Venue;
use App\Models\Agent;
use App\Models\Equipment;
use App\Models\Service;

use Carbon\Carbon;

use Illuminate\Support\Facades\DB; //トランザクション用

use App\Models\Bill;

use App\Traits\PregTrait;


class AgentsReservationsController extends Controller
{
  use PregTrait;

  public function create()
  {
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

    $reservation = Reservation::find($request->reservation_id);
    $percent = $reservation->agent->cost;
    $pay_limit = $reservation->agent->getAgentPayLimit($reservation->reserve_date);
    return view('admin.agents_reservations.add_bills', [
      'request' => $request,
      'percent' => $percent,
      'pay_limit' => $pay_limit,
      'reservation' => $reservation,
    ]);
  }

  public function add_check(Request $request)
  {
    $s_venues = [];
    $s_equipments = [];
    $s_layouts = [];
    $s_others = [];
    foreach ($request->all() as $key => $value) {
      if (preg_match("/venue_breakdown/", $key)) {
        $s_venues[] = $value;
      }
      if (preg_match("/equipment_breakdown/", $key)) {
        $s_equipments[] = $value;
      }
      if (preg_match("/layout_breakdown/", $key)) {
        $s_layouts[] = $value;
      }
      if (preg_match("/others_breakdown/", $key)) {
        $s_others[] = $value;
      }
    }



    return view('admin.agents_reservations.add_check', [
      'request' => $request,
      's_venues' => $s_venues,
      's_equipments' => $s_equipments,
      's_layouts' => $s_layouts,
      's_others' => $s_others,
    ]);
  }
  public function add_store(Request $request)
  {

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
      ); //固定で3
    });

    $request->session()->regenerate();
    $bill = Bill::find($request->bill_id);
    return redirect()->route('admin.reservations.show', $bill->reservation->id);
  }
}
