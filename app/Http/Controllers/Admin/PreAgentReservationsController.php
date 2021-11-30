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
use App\Models\PreEndUser;

use App\Models\Reservation;
use App\Models\Bill;
use App\Models\Breakdown;
use App\Models\Enduser;
use App\Models\Equipment;
use App\Models\Service;
use Carbon\Carbon;



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
    $price = $agent->agentPriceCalculate($request->end_user_charge);
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

    $request_equipments = 0;
    $request_services = 0;
    foreach ($request->all() as $key => $value) {
      if (preg_match("/equipment_breakdown/", $key)) {
        $request_equipments += (int)$value;
      } elseif (preg_match("/services_breakdown/", $key)) {
        $request_services += (int)$value;
      }
    }

    return view('admin.pre_agent_reservations.single_calculate', [
      'agent' => $agent,
      'request' => $request,
      'venue' => $venue,
      'price' => $price,
      'layout_prepare' => $layout_prepare,
      'layout_clean' => $layout_clean,
      'layout_total' => $layout_total,
      'request_equipments' => $request_equipments,
      'request_services' => $request_services,
    ]);
  }

  public function store(Request $request)
  {
    $data = $request->all();
    $data['email_flag'] = 0; //仲介会社はメール送付不要
    $data['in_charge'] = NULL; //仲介会社の当日の担当者は不要
    $data['tel'] = NULL; //仲介会社の当日の連絡先は不要

    $pre_reservation = new PreReservation;
    $pre_enduser = new PreEndUser;
    $pre_bill = new PreBill;
    $pre_breakdown = new PreBreakdown;

    DB::beginTransaction();
    try {
      $result_pre_reservation = $pre_reservation->PreReservationStore($data);
      $pre_enduser->PreEndUserStore($result_pre_reservation->id, $data);
      $result_pre_bill = $pre_bill->PreBillStore($result_pre_reservation->id, $data);
      $result_breakdowns = $pre_breakdown->PreBreakdownStore($result_pre_bill->id, $data);
      DB::commit();
    } catch (\Exception $e) {
      DB::rollback();
      dd($e);
      return back()->withInput()->withErrors($e->getMessage());
    }
    $request->session()->regenerate();
    return redirect()->route('admin.pre_reservations.show', $result_pre_reservation->id);
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
    $price = $agent->agentPriceCalculate($request->end_user_charge);
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



    $s_equipment = Equipment::getSessionArrays(collect($request->all()));
    $s_services = Service::getSessionArrays(collect($request->all()));
    // [0]備品＋サービス [1]備品詳細 [2]サービス詳細 [3]備品合計 [4]サービス合計
    $item_details = $venue->calculate_items_price($s_equipment, $s_services);



    return view('admin.pre_agent_reservations.edit_calculate', [
      'agent' => $agent,
      'request' => $request,
      'venue' => $venue,
      'price' => $price,
      'layout_prepare' => $layout_prepare,
      'layout_clean' => $layout_clean,
      "id" => $id,
      "layout_total" => $layout_total,
      "item_details" => $item_details,
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
        'luggage_flag' => $request->luggage_flag,
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
        'charge' =>  $request->end_user_charge,
        "attr" => $request->pre_enduser_attr,
      ]);
    });
    return redirect(route('admin.pre_reservations.show', $id));
  }

  public function switch_status(Request $request)
  {
    $data = $request->all();
    $pre_reservation = PreReservation::with(['pre_bill.pre_breakdowns', 'pre_enduser'])->find($data['pre_reservation_id']);
    $data = $pre_reservation->toArray();

    $data['luggage_price'] = ""; // ※lugage_priceは手動で追加
    $data['email_flag'] = 0; // 仲介会社は利用後メールを送信しないのでemail_flagは手動で追加
    $data['in_charge'] = ""; // 仲介会社は利用後メールを送信しないのでemail_flagは手動で追加
    $reservation = new Reservation;
    $bill = new Bill;
    $bill_data = $data['pre_bill'];
    $agent = Agent::find($data['agent_id']);
    $payment_limit = $agent->getAgentPayLimit($data['reserve_date']);
    $bill_data['payment_limit'] = $payment_limit;
    $bill_data['bill_company'] = $agent->name;
    $bill_data['bill_person'] = $agent->person_firstname . $agent->person_lastname;
    $bill_data['bill_created_at'] = Carbon::today();
    $bill_data['paid'] = 0;
    $bill_data['pay_day'] = NULL;
    $bill_data['pay_person'] = NULL;
    $bill_data['payment'] = NULL;
    $bill_data['cfm_at'] = date('Y-m-d H:i:s');

    $breakdowns = new Breakdown;
    $breakdown_data = [];
    foreach ($data['pre_bill']['pre_breakdowns'] as $key => $value) {
      if ((int)$value['unit_type'] === 1) {
        $breakdown_data['venue_breakdown_item'][] = $value['unit_item'];
        $breakdown_data['venue_breakdown_cost'][] = $value['unit_cost'];
        $breakdown_data['venue_breakdown_count'][] = $value['unit_count'];
        $breakdown_data['venue_breakdown_subtotal'][] = $value['unit_subtotal'];
      } elseif ((int)$value['unit_type'] === 2) {
        $breakdown_data['equipment_breakdown_item'][] = $value['unit_item'];
        $breakdown_data['equipment_breakdown_cost'][] = $value['unit_cost'];
        $breakdown_data['equipment_breakdown_count'][] = $value['unit_count'];
        $breakdown_data['equipment_breakdown_subtotal'][] = $value['unit_subtotal'];
      } elseif ((int)$value['unit_type'] === 3) {
        $breakdown_data['service_breakdown_item'][] = $value['unit_item'];
        $breakdown_data['service_breakdown_cost'][] = $value['unit_cost'];
        $breakdown_data['service_breakdown_count'][] = $value['unit_count'];
        $breakdown_data['service_breakdown_subtotal'][] = $value['unit_subtotal'];
      } elseif ((int)$value['unit_type'] === 4) {
        $breakdown_data['layout_breakdown_item'][] = $value['unit_item'];
        $breakdown_data['layout_breakdown_cost'][] = $value['unit_cost'];
        $breakdown_data['layout_breakdown_count'][] = $value['unit_count'];
        $breakdown_data['layout_breakdown_subtotal'][] = $value['unit_subtotal'];
      } elseif ((int)$value['unit_type'] === 5) {
        $breakdown_data['others_breakdown_item'][] = $value['unit_item'];
        $breakdown_data['others_breakdown_cost'][] = $value['unit_cost'];
        $breakdown_data['others_breakdown_count'][] = $value['unit_count'];
        $breakdown_data['others_breakdown_subtotal'][] = $value['unit_subtotal'];
      }
    }

    $enduser = new Enduser;
    $enduser_data = [];
    $enduser_data['enduser_company'] = $pre_reservation['pre_enduser']->company;
    $enduser_data['enduser_incharge'] = $pre_reservation['pre_enduser']->person;
    $enduser_data['enduser_mail'] = $pre_reservation['pre_enduser']->email;
    $enduser_data['enduser_mobile'] = $pre_reservation['pre_enduser']->mobile;
    $enduser_data['enduser_tel'] = $pre_reservation['pre_enduser']->tel;
    $enduser_data['enduser_address'] = $pre_reservation['pre_enduser']->address;
    $enduser_data['enduser_attr'] = $pre_reservation['pre_enduser']->attr;
    $enduser_data['end_user_charge'] = $pre_reservation['pre_enduser']->charge;



    DB::beginTransaction();
    try {
      $pre_reservation->delete();
      $result_reservation = $reservation->ReservationStore($data);
      if ($result_reservation === "重複") {
        throw new \Exception("選択された会場・日付・利用時間は既に利用済みです。");
      }
      $result_bill = $bill->BillStore($result_reservation->id, $bill_data);
      $result_breakdowns = $breakdowns->BreakdownStore($result_bill->id, $breakdown_data);
      $enduser->endUserStore($result_reservation->id, $enduser_data);
      DB::commit();
    } catch (\Exception $e) {
      DB::rollback();
      // return back()->withInput()->withErrors($e->getMessage());
      return redirect()->route('admin.pre_reservations.show', $pre_reservation->id)->withErrors($e->getMessage());
    }
    $request->session()->regenerate();
    return redirect()->route('admin.reservations.index');
  }
}
