<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Reservation;
use App\Models\Venue;
use App\Models\Agent;

use Carbon\Carbon;

use Illuminate\Support\Facades\DB; //トランザクション用



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
    $payment_limit = $agent->getAgentPayLimit($request->reserve_date);
    $price = $agent->agentPriceCalculate($request->enduser_charge);
    $venues = Venue::select('id', 'name_area', 'name_bldg', 'name_venue')->get();
    $agents = Agent::all();
    $equipments = $venues->find($request->venue_id)->equipments()->get();
    $services = $venues->find($request->venue_id)->services()->get();

    $requests = $request->all();

    var_dump($request->all());

    $carbon1 = new Carbon($request->enter_time);
    $carbon2 = new Carbon($request->leave_time);

    $usage_hours = $carbon1->diffInMinutes($carbon2);
    $usage_hours = $usage_hours / 60;

    $s_equipment = [];
    $s_services = [];
    $s_others = [];
    foreach ($requests as $key => $value) {
      if (preg_match('/equipment_breakdown/', $key)) {
        $s_equipment[] = $value;
      }
      if (preg_match('/services_breakdown/', $key)) {
        $s_services[] = $value;
      }
      if (preg_match('/others_input/', $key)) {
        $s_others[] = $value;
      }
    }

    return view('admin.agents_reservations.calculate', [
      'price' => $price,
      'venues' => $venues,
      'equipments' => $equipments,
      'services' => $services,
      'agents' => $agents,
      'requests' => $requests,
      'payment_limit' => $payment_limit,
      'usage_hours' => $usage_hours,
      's_equipment' => $s_equipment,
      's_services' => $s_services,
      's_others' => $s_others,

    ]);
  }

  public function recalculate(Request $request)
  {

    $all_requests = json_decode($request->all_requests, true);

    echo "<pre>";
    var_dump($all_requests);
    echo "</pre>";

    $venues = Venue::all();
    $venue = $venues->find($all_requests['venue_id']);
    $equipments = $venue->equipments()->get();
    $services = $venue->services()->get();
    $agents = Agent::all();

    $s_equipment = [];
    $s_services = [];
    $s_others = [];
    foreach ($all_requests as $key => $value) {
      if (preg_match('/equipment_breakdown_count/', $key)) {
        $s_equipment[] = $value;
      }
      if (preg_match('/services_breakdown/', $key)) {
        $s_services[] = $value;
      }
      if (preg_match('/others_input/', $key)) {
        $s_others[] = $value;
      }
    }
    // $item_details = json_decode($all_requests['item_details']);

    // $layouts_details = json_decode($all_requests['layouts_details']);

    // $others_details = json_decode($request->others_details);

    return view('admin.agents_reservations.re_calculate', [
      'all_requests' => $all_requests,
      'venues' => $venues,
      'equipments' => $equipments,
      'services' => $services,
      's_equipment' => $s_equipment,
      's_services' => $s_services,
      's_others' => $s_others,
      'agents' => $agents,
      // 'item_details' => $item_details,
      // 'layouts_details' => $layouts_details,
      // 'others_details' => $others_details,
    ]);
  }




  public function check(Request $request)
  {
    echo "<pre>";
    var_dump($request->all());
    echo "</pre>";

    $s_equipments = [];
    $s_services = [];
    $s_others = [];
    foreach ($request->all() as $key => $value) {
      if (preg_match('/equipment_breakdown/', $key)) {
        $s_equipments[] = $value;
      }
      if (preg_match('/service_breakdown/', $key)) {
        $s_services[] = $value;
      }
      if (preg_match('/others_input/', $key)) {
        $s_others[] = $value;
      }
    }

    // var_dump($s_others);
    $judge = array_filter($s_others);

    return view('admin.agents_reservations.check', [
      'request' => $request,
      's_equipments' => $s_equipments,
      's_services' => $s_services,
      's_others' => $s_others,
      'judge' => $judge,
    ]);
  }

  public function store(Request $request)
  {
    var_dump($request->all());

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
        'layout_price' =>  0, //デフォで0
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

        'reservation_status' => 1, //デフォで1、仮抑えのデフォは0
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
        var_dump($s_arrays);
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
          'unit_cost' => 0,
          'unit_count' => 1,
          'unit_subtotal' => 0,
          'unit_type' => 4,
        ]);
      }
      if ($request->layout_clean_count) {
        $bills->breakdowns()->create([
          'unit_item' => $request->layout_clean_item,
          'unit_cost' => 0,
          'unit_count' => 1,
          'unit_subtotal' => 0,
          'unit_type' => 4,
        ]);
      }
    });

    // 戻って再度送信してもエラーになるように設定
    $request->session()->regenerate();
    return redirect()->route('admin.reservations.index');
  }
}
