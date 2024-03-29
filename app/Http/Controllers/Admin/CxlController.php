<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Database\Eloquent\Model;
use App\Models\Cxl;
use App\Models\CxlBreakdown;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Models\Bill;
use App\Models\User;
use App\Models\Reservation;

use Illuminate\Support\Facades\Mail;
use App\Mail\UserCxlPaid;

use Illuminate\Support\Facades\DB;
use App\Service\SendSMGEmail;



class CxlController extends Controller
{
  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function multiCreate(Request $request)
  {
    $reservation = Reservation::with('bills')->find($request->reservation_id);
    $bill = Bill::find($request->bill_id);

    if ($request->multi) { //一括キャンセル押下時
      if ($reservation->user_id > 0) {
        $price_result = $reservation->pluckSum(['venue_price', 'equipment_price', 'layout_price', 'others_price'], 3);
      } else { //仲介会社の場合、会場料としてsubtotalを表示
        // $price_result = $reservation->pluckSum(['master_subtotal', 0, 'layout_price', 0], 3);
        $master_subtotal = $reservation->bills->where('reservation_status', 3)->pluck('master_subtotal')->sum();
        $layout = $reservation->bills->where('reservation_status', 3)->pluck('layout_price')->sum();
        $price_result = [($master_subtotal - $layout), 0, $layout, 0];
      }
      $multi = 1;
      $single = 0;
    } elseif ($request->single) { //個別キャンセル押下時
      if ($reservation->user_id > 0) {
        $price_result = [$bill->venue_price, $bill->equipment_price, $bill->layout_price, $bill->others_price];
      } else { //仲介会社の場合、会場料としてsubtotalを表示
        $price_result = [($bill->master_subtotal - $bill->layout_price), $bill->equipment_price, $bill->layout_price, $bill->others_price];
      }
      $multi = 0;
      $single = 1;
    }
    return view('admin.cxl.multi_create', compact('price_result', 'reservation', 'bill'));
  }

  public function multiCalc(Request $request)
  {
    $data = $request->all();
    $reservation = Reservation::with(['user', 'agent'])->find($data['reservation_id']);
    $user = $reservation->user;
    $agent = $reservation->agent;
    if ($reservation->user_id > 0) {
      $pay_limit = $user->getUserPayLimit($reservation->reserve_date);
    } else {
      $pay_limit = $agent->getPayDetails($reservation->reserve_date);
    }
    return view('admin.cxl.multi_calculate', compact('data', 'user', 'agent', 'pay_limit'));
  }

  public function multiCheck(Request $request)
  {
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $data = $request->all();
    if ($request->back) {
      return redirect()->route('admin.cxl.multi_create', $data)->withInput();
    }

    $cxl = new Cxl;
    $cxl_breakdown = new CxlBreakdown;
    $bill = new Bill;
    DB::beginTransaction();
    try {
      $result_cxl = $cxl->CxlStore($data);
      $result_breakdown = $cxl_breakdown->BreakdownStore($result_cxl->id, $data);
      $bill->BillUpdateCxlStatus($result_cxl->reservation_id);
      DB::commit();
    } catch (\Exception $e) {
      DB::rollback();
      return redirect()->route('admin.cxl.multi_create', $data)->withInput()->withErrors($e->getMessage());
    }
    $request->session()->regenerate();
    return redirect()->route('admin.reservations.show', $result_cxl->reservation_id);
  }

  public function multiStore($data, $invoice, $bill_id, $reservation_id)
  {
    $cxl = new Cxl;
    $cxlBill = $cxl->storeCxl($data, $invoice, $bill_id, $reservation_id);
    $cxlBill->storeCxlBreakdown($data, $invoice);
    $bills = Bill::where('reservation_id', $reservation_id)->where('reservation_status', 3)->get();
    foreach ($bills as $key => $value) {
      $value->updateStatusByCxl();
    }
  }

  public function singleStore($data, $invoice, $bill_id, $reservation_id)
  {
    $cxl = new Cxl;
    $cxlBill = $cxl->storeCxl($data, $invoice, $bill_id, $reservation_id);
    $cxlBill->storeCxlBreakdown($data, $invoice);
    $bill = Bill::find($bill_id);
    $bill->updateStatusByCxl();
  }

  public function doubleCheck(Request $request)
  {
    $cxl = Cxl::find($request->cxl_id);
    $cxl->doubleCheck($request->double_check_status, $request->cxl_id, $request->double_check1_name, $request->double_check2_name);
    return redirect(route('admin.reservations.show', $cxl->reservation_id));
  }

  public function send_email_and_approve(Request $request)
  {
    $cxl = Cxl::with(['reservation.bills', 'reservation.user', 'reservation.venue'])->find($request->cxl_id);
    $reservation_id = $cxl->reservation->id;
    try {
      $cxl->sendCxlEmail($cxl->id);
      $cxl->updateCxlStatusByEmail(1);
      $cxl->updateReservationStatusByCxl(5);
    } catch (\Exception $e) {
      report($e);
    }
    $request->session()->regenerate();
    return redirect()->route('admin.reservations.show', $reservation_id);
  }

  public function confirm_cxl(Request $request)
  {
    $cxl = Cxl::with('reservation')->find($request->cxl_id);
    $reservation_id = $cxl->reservation->id;
    try {
      $cxl->updateCxlStatusByEmail(2);
      $cxl->updateReservationStatusByCxl(6);
    } catch (\Exception $e) {
      report($e);
    }
    if ($cxl->reservation->user_id > 0) {
      $SendSMGEmail = new SendSMGEmail();
      $SendSMGEmail->send("ユーザーがキャンセルを承認", $cxl->id);
    }

    $request->session()->regenerate();
    return redirect()->route('admin.reservations.show', $reservation_id);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\Cxl  $cxl
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    $cxl = Cxl::with(['bill', 'reservation.bills', 'cxl_breakdowns'])->find($id);
    $reservation = Reservation::find($cxl->reservation_id);
    return view('admin.cxl.edit', compact('cxl', 'reservation'));
  }

  public function editCalc(Request $request)
  {
    $data = $request->all();
    $reservation = Reservation::with(['user', 'agent', 'cxls'])->find($data['reservation_id']);
    $cxl = $reservation->cxls->first();
    $user = $reservation->user;
    $agent = $reservation->agent;
    if ($reservation->user_id > 0) {
      $pay_limit = $user->getUserPayLimit($reservation->reserve_date);
    } else {
      $pay_limit = $agent->getPayDetails($reservation->reserve_date);
    }

    return view('admin.cxl.edit_calc', compact('data', 'reservation', 'pay_limit', 'agent', 'user', 'cxl'));
  }

  // public function editCalcShow(Request $request)
  // {
  //   $info = session()->get('cxlMaster');
  //   $data = session()->get('cxlCalcInfo');
  //   $result = session()->get('cxlResult');
  //   $reservation = Reservation::with(['user', 'agent'])->find($data['reservation_id']);
  //   $user = $reservation->user;
  //   $agent = $reservation->agent;
  //   if (!empty($user)) {
  //     $pay_limit = $user->getUserPayLimit($reservation->reserve_date);
  //   } else {
  //     $pay_limit = $agent->getAgentPayLimit($reservation->reserve_date);
  //   }
  //   $cxl = Cxl::find($data['cxl_id']);
  //   return view('admin.cxl.edit_calc', compact('info', 'data', 'result', 'user', 'pay_limit', 'cxl'));
  // }

  // public function editCheck(Request $request)
  // {
  //   $info = session()->get('cxlMaster');
  //   $data = session()->get('cxlCalcInfo');
  //   $result = session()->get('cxlResult');
  //   $request->session()->put('invoice', $request->all());
  //   $invoice = session()->get('invoice');
  //   $multiOrSingle = session()->get('multiOrSingle');
  //   if ($request->back) {
  //     return redirect(route('admin.cxl.edit', $data['cxl_id']));
  //   }
  //   return view(
  //     'admin.cxl.edit_check',
  //     compact('info', 'data', 'result', 'invoice')
  //   );
  // }


  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Cxl  $cxl
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request)
  {
    $data = $request->all();
    $r = Reservation::with('cxls')->find($data['reservation_id']);
    $cxl = $r->cxls->first();
    if ($request->back) {
      return redirect()->route('admin.cxl.edit', $cxl->id)->withInput();
    }
    $cxl_breakdown = new CxlBreakdown;
    $bill = new Bill;
    DB::beginTransaction();
    try {
      $result_cxl = $cxl->CxlUpdate($data);
      $cxl_breakdown->BreakdownDelete($cxl->id);
      $cxl_breakdown->BreakdownStore($cxl->id, $data);
      DB::commit();
    } catch (\Exception $e) {
      DB::rollback();
      return redirect()->route('admin.cxl.edit', $cxl->id)->withInput()->withErrors($e->getMessage());
    }
    $request->session()->regenerate();
    return redirect()->route('admin.reservations.show', $result_cxl->reservation_id);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Cxl  $cxl
   * @return \Illuminate\Http\Response
   */
  // public function destroy(Cxl $cxl)
  // {
  //   //
  // }

  public function updateCxlBillInfo(Request $request)
  {
    $validatedData = $request->validate(
      [
        'bill_created_at' => 'required',
        'payment_limit' => 'required',
        'bill_company' => 'required',
        'bill_person' => 'required',
      ],
      [
        'bill_created_at.required' => '[キャンセル請求書情報] ※請求日は必須です',
        'payment_limit.required' => '[キャンセル請求書情報] ※支払期日は必須です',
        'bill_company.required' => '[キャンセル請求書情報] ※請求書宛名は必須です',
        'bill_person.required' => '[キャンセル請求書情報] ※担当者は必須です',
      ]
    );
    $cxl = Cxl::find($request->cxl_id);
    $cxl->update(
      [
        'bill_created_at' => $request->bill_created_at,
        'payment_limit' => $request->payment_limit,
        'bill_company' => $request->bill_company,
        'bill_person' => $request->bill_person,
        'bill_remark' => $request->bill_remark,
      ]
    );
    return redirect(url('/admin/reservations/' . $cxl->reservation_id));
  }

  public function updateCxlPaidInfo(Request $request)
  {
    $validatedData = $request->validate(
      [
        'paid' => 'required',
        // 'pay_day' => 'date',
        // 'payment' => 'integer|min:0',
      ],
      [
        'paid.required' => '[キャンセル入金情報] ※入金状況は必須です',
        // 'pay_day.date' => '[キャンセル入金情報] ※入金日は日付で入力してください',
        // 'payment.integer' => '[キャンセル入金情報] ※入金額は半角英数字で入力してください',
        // 'payment.min' => '[キャンセル入金情報] ※入金額は0以上を入力してください',
      ]
    );
    $cxl = Cxl::with(['reservation.user', 'reservation.venue'])->find($request->cxl_id);
    $cxl->update(
      [
        'paid' => $request->paid,
        'pay_day' => $request->pay_day,
        'pay_person' => $request->pay_person,
        'payment' => !empty($request->payment) ? $request->payment : 0,
      ]
    );
    if ($cxl->reservation->agent_id == 0) {
      $this->judgePaymentStatusAndSendEmail($request->paid, $cxl->reservation->id, $cxl->id);
    }

    return redirect(url('/admin/reservations/' . $cxl->reservation->id));
  }

  public function judgePaymentStatusAndSendEmail($status, $reservation, $cxl_id)
  {
    if ($status == 1) {
      $SendSMGEmail = new SendSMGEmail();
      $SendSMGEmail->send("キャンセル料入金確認完了", ['reservation_id' => $reservation, 'cxl_id' => $cxl_id]);
    }
  }
}
