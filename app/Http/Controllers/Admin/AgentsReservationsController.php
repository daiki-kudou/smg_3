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



class AgentsReservationsController extends Controller
{
  public function create()
  {
    $venues = Venue::select('id', 'name_area', 'name_bldg', 'name_venue')->get();

    $agents = Agent::all();
    return view('admin.agents_reservations.create', [
      'venues' => $venues,
      'agents' => $agents,
    ]);
  }

  public function calculate(Request $request)
  {
    $venues = Venue::all();
    $SPvenue = $venues->find($request->venue_id);
    $agents = Agent::all();
    $agent = $agents->find($request->agent_id);
    $price = $agent->agentPriceCalculate($request->enduser_charge);
    $payment_limit = $agent->getAgentPayLimit($request->reserve_date);
    $equipments = $venues->find($request->venue_id)->equipments()->get();
    $services = $venues->find($request->venue_id)->services()->get();
    $requests = $request->all();
    $carbon1 = new Carbon($request->enter_time);
    $carbon2 = new Carbon($request->leave_time);
    $usage_hours = $carbon1->diffInMinutes($carbon2);
    $usage_hours = $usage_hours / 60;

    $layout_price = 0;
    if ($request->layout_prepare > 0) {
      $layout_price += $venues->find($request->venue_id)->layout_prepare;
    } else {
      $layout_price += 0;
    }
    if ($request->layout_clean > 0) {
      $layout_price += $venues->find($request->venue_id)->layout_clean;
    } else {
      $layout_price += 0;
    }
    $price = $price + $layout_price;
    return view(
      'admin.agents_reservations.calculate',
      compact(
        'SPvenue',
        'agents',
        'agent',
        'payment_limit',
        'price',
        'venues',
        'request',
        'usage_hours',
        'layout_price'
      )
    );
  }



  public function check(Request $request)
  {
    $venue = Venue::find($request->venue_id);
    $others_details = [];
    foreach ($request->all() as $key => $value) {
      if (preg_match('/others_input_item/', $key)) {
        if (!empty($value)) {
          $others_details[] = $value;
        }
      }
    }
    $others_details = !empty($others_details) ? count($others_details) : "";
    return view(
      'admin.agents_reservations.check',
      compact('request', 'venue', 'others_details')
    );
  }

  public function store(Request $request)
  {


    DB::transaction(function () use ($request) { //トランザクションさせる
      $reservation = Reservation::create([
        'venue_id' => $request->venue_id,
        'user_id' => 0, //デフォで0
        'agent_id' => $request->agent_id,
        'reserve_date' => $request->reserve_date,
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
        'email_flag' => 0,
        'in_charge' => '',
        'tel' => '',
        'cost' => 0,
        'discount_condition' => $request->discount_condition,
        'attention' => $request->attention,
        'user_details' => $request->user_details,
        'admin_details' => $request->admin_details,
      ]);

      $reservation->enduser()->create([
        'reservation_id' => $reservation->id,
        'company' => $request->enduser_company,
        'person' => $request->enduser_incharge,
        'address' => $request->enduser_address,
        'tel' => $request->enduser_tel,
        'email' => $request->enduser_mail,
        'attr' => $request->enduser_attr,
        'charge' => $request->enduser_charge,
      ]);

      $bills = $reservation->bills()->create([
        'reservation_id' => $reservation->id,
        'venue_price' => 0, //デフォで0
        'equipment_price' => 0, //デフォで0
        'layout_price' =>  $request->layouts_price ? $request->layouts_price : 0, //デフォで0
        'others_price' => 0, //デフォで0
        // 該当billの合計額関連
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

        'reservation_status' => 1, //デフォで1、仮押さえのデフォは0
        'double_check_status' => 0, //デフォで0
        'category' => 1, //デフォで１。　新規以外だと　2:その他有料備品　3:レイアウト　4:その他
        'admin_judge' => 1, //管理者作成なら1 ユーザー作成なら2
      ]);
      function toBreakDown($num, $sub, $target, $type)
      {
        $s_arrays = [];
        foreach ($num as $key => $value) {
          if (preg_match("/" . $sub . "/", $key)) {
            $s_arrays[] = $value;
          }
        }

        $counts = (count($s_arrays) / 2);
        for ($i = 0; $i < $counts; $i++) {
          $target->breakdowns()->create([
            'unit_item' => $s_arrays[($i * 2)],
            'unit_cost' => 0,
            'unit_count' => $s_arrays[($i * 2) + 1],
            'unit_subtotal' => 0,
            'unit_type' => $type,
          ]);
        }
      }
      toBreakDown($request->all(), 'venue_breakdown', $bills, 1);
      toBreakDown($request->all(), 'equipment_breakdown', $bills, 2);
      toBreakDown($request->all(), 'service_breakdown', $bills, 3);
      toBreakDown($request->all(), 'others_breakdown', $bills, 5);
      if ($request->luggage_price) {
        $bills->breakdowns()->create([
          'unit_item' => $request->luggage_item,
          'unit_cost' => 0,
          'unit_count' => 1,
          'unit_subtotal' => 0,
          'unit_type' => 3,
        ]);
      }

      if ($request->layout_prepare_count) {
        $bills->breakdowns()->create([
          'unit_item' => $request->layout_prepare_item,
          'unit_cost' => $request->layout_prepare_cost,
          'unit_count' => 1,
          'unit_subtotal' => $request->layout_prepare_cost,
          'unit_type' => 4,
        ]);
      }
      if ($request->layout_clean_count) {
        $bills->breakdowns()->create([
          'unit_item' => $request->layout_clean_item,
          'unit_cost' => $request->layout_clean_cost,
          'unit_count' => 1,
          'unit_subtotal' => $request->layout_clean_cost,
          'unit_type' => 4,
        ]);
      }
    });

    // 戻って再度送信してもエラーになるように設定
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
