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
use App\Mail\AdminCxlPaid;
use App\Mail\UserCxlPaid;

use Illuminate\Support\Facades\DB;



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

  // public function multiCalcShow(Request $request)
  // {
  //   $info = session()->get('cxlMaster');
  //   $data = session()->get('cxlCalcInfo');
  //   $result = session()->get('cxlResult');
  //   $reservation = Reservation::with(['user', 'agent'])->find($data['reservation_id']);
  //   $user = $reservation->user;
  //   $agent = $reservation->agent;
  //   if ($reservation->user_id > 0) {
  //     $pay_limit = $user->getUserPayLimit($reservation->reserve_date);
  //   } else {
  //     $pay_limit = $agent->getPayDetails($reservation->reserve_date);
  //   }
  //   return view('admin.cxl.multi_calculate', compact('info', 'data', 'result', 'user', 'agent', 'pay_limit'));
  // }

  public function multiCheck(Request $request)
  {
    // if ($request->back) {
    //   return redirect(route(
    //     'admin.cxl.multi_create',
    //     [
    //       'reservation_id' => $data['reservation_id'],
    //       'bill_id' => $data['bill_id'],
    //       $judge => $judge,
    //     ]
    //   ));
    // }

    // $data = $request->all();
    // echo "<pre>";
    // var_dump($data);
    // echo "</pre>";

    // return view(
    //   'admin.cxl.multi_check',
    //   compact('data')
    // );
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
    DB::beginTransaction();
    try {
      $result_cxl = $cxl->CxlStore($data);
      $result_breakdown = $cxl_breakdown->BreakdownStore($result_cxl->id, $data);
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
    $cxl = Cxl::with('reservation.bills')->find($request->cxl_id);
    $reservation_id = $cxl->reservation->id;
    try {
      $cxl->sendCxlEmail();
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
    $cxl = Cxl::find($request->cxl_id);
    $reservation_id = $cxl->reservation->id;
    try {
      $cxl->updateCxlStatusByEmail(2);
      $cxl->updateReservationStatusByCxl(6);
    } catch (\Exception $e) {
      report($e);
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
    session()->forget(['invoice', 'cxlMaster', 'cxlResult', 'cxlCalcInfo']);
    $cxl = Cxl::with(['bill', 'reservation.bills', 'cxl_breakdowns'])->find($id);
    if (empty($cxl->bill)) {
      //一括キャンセル押下時
      if ($cxl->reservation->user_id > 0) {
        $price_result = $cxl->reservation->pluckSum(['venue_price', 'equipment_price', 'layout_price', 'others_price'], 4);
      } else { //仲介会社の場合、会場料としてsubtotalを表示
        $master_subtotal = $cxl->reservation->bills->where('reservation_status', '>', 3)->where('reservation_status', '<', 6)->pluck('master_subtotal')->sum();
        $layout = $cxl->reservation->bills->where('reservation_status', '>', 3)->where('reservation_status', '<', 6)->pluck('layout_price')->sum();
        $price_result = [($master_subtotal - $layout), 0, $layout, 0];
      }
    } else {
      //個別キャンセル押下時
      if ($cxl->reservation->user_id > 0) {
        $price_result = [$cxl->bill->venue_price, $cxl->bill->equipment_price, $cxl->bill->layout_price, $cxl->bill->others_price];
      } else { //仲介会社の場合、会場料としてsubtotalを表示
        $master_subtotal = $cxl->bill->master_subtotal;
        $layout = $cxl->bill->layout_price;
        $price_result = [($master_subtotal - $layout), 0, $layout, 0];
      }
    }
    session()->put('cxlMaster', $price_result);
    return view('admin.cxl.edit', compact('price_result', 'cxl'));
  }

  public function editCalc(Request $request)
  {
    $request->session()->forget('invoice');
    $request->session()->put('cxlCalcInfo', $request->all());
    $cxl = new Cxl;
    $result = $cxl->calcCxlAmount();
    $request->session()->put('cxlResult', $result);
    return redirect(route('admin.cxl.edit_calc'));
  }

  public function editCalcShow(Request $request)
  {
    $info = session()->get('cxlMaster');
    $data = session()->get('cxlCalcInfo');
    $result = session()->get('cxlResult');
    $reservation = Reservation::with(['user', 'agent'])->find($data['reservation_id']);
    $user = $reservation->user;
    $agent = $reservation->agent;
    if (!empty($user)) {
      $pay_limit = $user->getUserPayLimit($reservation->reserve_date);
    } else {
      $pay_limit = $agent->getAgentPayLimit($reservation->reserve_date);
    }
    $cxl = Cxl::find($data['cxl_id']);
    return view('admin.cxl.edit_calc', compact('info', 'data', 'result', 'user', 'pay_limit', 'cxl'));
  }

  public function editCheck(Request $request)
  {
    $info = session()->get('cxlMaster');
    $data = session()->get('cxlCalcInfo');
    $result = session()->get('cxlResult');
    $request->session()->put('invoice', $request->all());
    $invoice = session()->get('invoice');
    $multiOrSingle = session()->get('multiOrSingle');
    if ($request->back) {
      return redirect(route('admin.cxl.edit', $data['cxl_id']));
    }
    return view(
      'admin.cxl.edit_check',
      compact('info', 'data', 'result', 'invoice')
    );
  }


  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Cxl  $cxl
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request)
  {
    if ($request->back) {
      return redirect(route('admin.cxl.edit_calc'));
    }
    $data = session()->get('cxlCalcInfo');
    $invoice = session()->get('invoice');
    $multiOrSingle = session()->get('multiOrSingle');
    $reservation_id = $data['reservation_id'];
    $bill_id = $data['bill_id'];
    try {
      $cxl = Cxl::with('cxl_breakdowns')->find($data['cxl_id']);
      $cxl->updateCxl($data, $invoice);
      foreach ($cxl->cxl_breakdowns as $key => $value) {
        $value->delete();
      }
      $cxl->updateCxlBreakdowns($data, $invoice);
    } catch (\Exception $e) {
      report($e);
      session()->flash('flash_message', '作成に失敗しました。<br>フォーム内の空欄や全角など確認した上でもう一度お試しください。');
      return redirect(route('admin.cxl.edit_calc'));
    }
    $request->session()->regenerate();
    return redirect()->route('admin.reservations.show', $reservation_id);
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
    return redirect(url('admin/reservations/' . $cxl->reservation_id));
  }

  public function updateCxlPaidInfo(Request $request)
  {
    $validatedData = $request->validate(
      [
        'paid' => 'required',
        'pay_day' => 'date',
        'payment' => 'integer|min:0',
      ],
      [
        'paid.required' => '[キャンセル入金情報] ※入金状況は必須です',
        'pay_day.date' => '[キャンセル入金情報] ※入金日は日付で入力してください',
        'payment.integer' => '[キャンセル入金情報] ※入金額は半角英数字で入力してください',
        'payment.min' => '[キャンセル入金情報] ※入金額は0以上を入力してください',
      ]
    );
    $cxl = Cxl::with('reservation.user')->find($request->cxl_id);
    $cxl->update(
      [
        'paid' => $request->paid,
        'pay_day' => $request->pay_day,
        'pay_person' => $request->pay_person,
        'payment' => !empty($request->payment) ? $request->payment : 0,
      ]
    );
    if ($cxl->reservation->agent_id == 0) {
      $this->judgePaymentStatusAndSendEmail($request->paid, $cxl->reservation->user);
    }

    return redirect(url('admin/reservations/' . $cxl->reservation->id));
  }

  public function judgePaymentStatusAndSendEmail($status, $user)
  {
    if ($status == 1) {
      $admin = explode(',', config('app.admin_email'));
      Mail::to($admin)->send(new AdminCxlPaid($user));
      Mail::to($user->email)->send(new UserCxlPaid($user));
    }
  }
}
