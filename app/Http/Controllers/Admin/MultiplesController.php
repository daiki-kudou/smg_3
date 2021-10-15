<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\MultipleReserve;
use App\Models\PreReservation;
use App\Models\Reservation;
use App\Models\Bill;
use App\Models\Breakdown;
use App\Models\Venue;
use App\Models\User;
use App\Models\Agent;

use Illuminate\Support\Facades\DB; //トランザクション用

use App\Traits\SearchTrait;

use App\Traits\PaginatorTrait;
// バリデーションロジック
use App\Http\Requests\Admin\Multiples\Agent\PostRequest;
use Carbon\Carbon;
use App\Service\SendSMGEmail;


class MultiplesController extends Controller
{
  use SearchTrait; //検索用トレイト
  use PaginatorTrait;


  public function index(Request $request)
  {
    $data = $request->all();

    $_multiples = new MultipleReserve;
    $_multiples = $_multiples->SearchMultiple($data)->orderByRaw('multiple_reserve_id desc')->get()->toArray();
    $multiples = [];
    foreach ($_multiples as $p) {
      if ((int)$p->user_id === 0 || empty($p->user_id)) {
        $detail_link = "<a href=" . url('admin/multiples/agent', $p->multiple_reserve_original_id) . " class='more_btn btn'>詳細</a>";
      } else {
        $detail_link = "<a href=" . url('admin/multiples', $p->multiple_reserve_original_id) . " class='more_btn btn'>詳細</a>";
      }
      $multiples[] = [
        "<input type='checkbox' name='checkbox" . $p->multiple_reserve_original_id . "' value='" . $p->multiple_reserve_original_id . "' class='checkbox'>",
        $p->multiple_reserve_id,
        $p->created_at,
        $p->pre_reservation_count,
        $p->company,
        $p->person_name,
        $p->mobile,
        $p->tel,
        $p->unknown_user_company,
        $p->agent_name,
        $p->enduser,
        $detail_link,
      ];
    }
    $multiples = json_encode($multiples);

    $counter = 0;
    $agents = DB::table('agents')->select(DB::raw('id, name'))->orderByRaw('id desc')->pluck('name', 'id')->toArray();

    return view('admin.multiples.index', compact('multiples', "counter", "data", "agents"));
  }

  public function show($id)
  {
    $multiple = MultipleReserve::with("pre_reservations.pre_bill")->find($id);
    $checkVenuePrice = $multiple->checkVenuePrice();
    $checkEachStatus = $multiple->checkEachStatus();

    // dd($pre_reservations->pluck('formatdate'));

    return view(
      'admin.multiples.show',
      compact('multiple', 'checkVenuePrice', 'checkEachStatus')
    );
  }

  public function switch($id)
  {
    $multiple = MultipleReserve::find($id);
    $venues = $multiple->pre_reservations()->distinct()->select('venue_id')->get();
    $venue_count = $venues->count('venue_id');
    $users = User::orderBy("id", "desc")->get();

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
    $agents = Agent::orderBy("id", "desc")->get();

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
    $multiple = MultipleReserve::with(['pre_reservations.pre_bill.pre_breakdowns', 'pre_reservations.pre_breakdowns'])->find($multiple_id);
    $venue = Venue::find($venue_id);
    return view('admin.multiples.edit', [
      'multiple' => $multiple,
      'venue' => $venue,
    ]);
  }

  public function agent_edit($multiple_id, $venue_id)
  {
    $multiple = MultipleReserve::with('pre_reservations.pre_enduser', 'pre_reservations.pre_bill')->find($multiple_id);
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

  public function agent_calculate(PostRequest $request, $multiple_id, $venue_id)
  {
    $multiple = MultipleReserve::find($multiple_id);
    $agent = Agent::find($request->agent_id);
    $result = $agent->agentPriceCalculate($request->cp_master_end_user_charge);
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
    $end_user_charge = [];
    foreach ($request->all() as $key => $value) {
      if (preg_match('/end_user_charge_copied/', $key)) {
        if (!empty($value)) {
          $end_user_charge[] = $value;
        }
      }
    }
    $result = $agent->agentPriceCalculate($end_user_charge[0]);
    $pre_reservation->AgentSpecificUpdate($request, $result, $venue_id, $pre_reservation_id);
    return redirect(url('admin/multiples/agent/' . $multiple_id . '/edit/' . $venue_id));
  }

  public function allUpdates(Request $request, $multiples_id, $venues_id)
  {
    $masterData = json_decode($request->master_data);
    $test = [];
    foreach ($masterData as $key => $value) {
      if (preg_match('/venue_breakdown/', $key)) {
        $test[] = $value;
      }
    }
    foreach ($test as $key => $value) {
      if ($value === "") {
        return redirect()
          ->route('admin.multiples.edit', [$multiples_id, $venues_id])
          ->with('error', '一部予約の会場利用料が未設定です。必ず設定してください');
      }
    }

    $multiple = MultipleReserve::find($multiples_id);
    $multiple->UpdateAndReCreateAll($masterData, $venues_id);
    return redirect('admin/multiples/' . $multiples_id);
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
    $multiple = MultipleReserve::with('pre_reservations')->find($multiple_id);
    $venues = $multiple->pre_reservations->unique('venue_id');
    $venue_count = $venues->count('venue_id');
    $_venues = Venue::all();
    $pre_reservations = $multiple->pre_reservations->unique('venue_id');
    return view('admin.multiples.add_venue', compact('multiple', 'venues', 'venue_count', '_venues', 'pre_reservations'));
  }

  public function add_venue_store(Request $request)
  {

    foreach ($request->all() as $key => $value) {
      $validatedData = $request->validate([
        $key => 'required',
      ]);
    }

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
    $multiple = MultipleReserve::with(['pre_reservations.pre_bill', 'pre_reservations.venue'])->find($multiple_id);
    // $venues = $multiple->pre_reservations->unique('venue_id');
    // $venue_count = $venues->count('venue_id');
    // $_venues = Venue::orderBy("id", "desc")->get();
    $checkEachBills = $multiple->checkEachBills();

    return view('admin.multiples.agent_show', compact('multiple', 'checkEachBills'));
  }

  public function agentMoveToReservation(Request $request)
  {
    $data = $request->all();

    $multiple = MultipleReserve::with('pre_reservations.pre_bill.pre_breakdowns')->find($data['multiple_id']);

    foreach ($multiple->pre_reservations as $key => $value) {
      $pre_reservation = $value;

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

      DB::beginTransaction();
      try {
        $pre_reservation->delete();
        $result_reservation = $reservation->ReservationStore($data);
        if ($result_reservation === "重複") {
          throw new \Exception("選択された会場・日付・利用時間は既に利用済みです。");
        }
        $result_bill = $bill->BillStore($result_reservation->id, $bill_data);
        $result_breakdowns = $breakdowns->BreakdownStore($result_bill->id, $breakdown_data);
        DB::commit();
      } catch (\Exception $e) {
        DB::rollback();
        dd($e);
        return back()->withInput()->withErrors($e->getMessage());
      }
    }


    $request->session()->regenerate();
    return redirect()->route('admin.reservations.index');
  }

  public function destroy(Request $request)
  {
    $data = $request->all();
    if (!empty($data['delete_target']) && $data['delete_target'] !== "[]") { //空配列は弾く
      $delete_target_array = json_decode($data['delete_target']); //配列
      DB::beginTransaction();
      try {
        foreach ($delete_target_array as $value) {
          $multipleReserve = MultipleReserve::find($value);
          if (is_null($multipleReserve)) { //削除対象がなければ
            throw new \Exception("ID" . $value . "は存在しません");
          }
        }
        //問題なければ削除
        foreach ($delete_target_array as $v) {
          $multipleReserve = MultipleReserve::find($v);
          $multipleReserve->delete();
        }
        DB::commit();
      } catch (\Exception $e) {
        DB::rollback();
        return back()->withInput()->withErrors($e->getMessage());
      }
      return redirect()->route('admin.multiples.index')->with('flash_message', '削除完了');
    } else {
      return redirect()->route('admin.multiples.index')->with('flash_message_error', '仮押えが選択されていません');
    }
  }

  public function SPDestroy(Request $request)
  {
    $data = $request->all();
    if (!empty($data['delete_target']) && $data['delete_target'] !== "[]") { //空配列は弾く
      $delete_target_array = json_decode($data['delete_target']); //配列
      DB::beginTransaction();
      try {
        foreach ($delete_target_array as $value) {
          $preReservation = PreReservation::with(['user', 'venue'])->find($value);
          if (is_null($preReservation)) { //削除対象がなければ
            throw new \Exception("ID" . $value . "は存在しません");
          }
          if (($preReservation->user_id > 0)) {
            if (!filter_var($preReservation->user->email, FILTER_VALIDATE_EMAIL)) { //対象がメールアドレスでなければ
              throw new \Exception("ID" . $value . "のメールアドレス" . $preReservation->user->email . "は正しくありません");
            }
          }
        }
        // 上のforeachでメールアドレスチェックをし、全て通ったら再度foreachでメール送信処理
        foreach ($delete_target_array as $v) {
          $preReservation = PreReservation::with(['user', 'venue'])->find($v);
          if ($preReservation->user_id > 0) {
            $user = $preReservation->user;
            $venue = $preReservation->venue;
            $SendSMGEmail = new SendSMGEmail($user, "test", $preReservation->venue);
            $SendSMGEmail->send("管理者が仮抑え一覧よりチェックボックスを選択し削除");
          }
        }
        // 上のメール送信も問題なければ削除
        foreach ($delete_target_array as $v) {
          $preReservation = PreReservation::find($v);
          $preReservation->delete();
        }
        DB::commit();
      } catch (\Exception $e) {
        DB::rollback();
        return back()->withInput()->withErrors($e->getMessage());
      }
      return redirect()->route('admin.multiples.index')->with('flash_message', '削除したよ');
    } else {
      return back()->withInput()->with('flash_message_error', '仮押えが選択されていません');
    }
  }
}
