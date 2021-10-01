<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Bill;
use App\Models\Breakdown;
use App\Models\Venue;

use App\Models\Reservation;
use App\Models\User;

use Illuminate\Support\Facades\DB; //トランザクション用

use App\Mail\SendUserOtherBillsApprove;
use Illuminate\Support\Facades\Mail;
// メール
use App\Mail\AdminReqAddRes;
use App\Mail\UserReqAddRes;
use App\Mail\AdminPaid;
use App\Mail\UserPaid;

use Carbon\Carbon;
use App\Traits\PregTrait;
use App\Service\SendSMGEmail;




class BillsController extends Controller
{
  use PregTrait;

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    //
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create(Request $request)
  {
    $data = $request->all();
    $reservation = Reservation::with(['bills', 'user'])->find($data['reservation_id']);
    $payment_limit = $reservation->user->getUserPayLimit($reservation['reserve_date']);
    $reservation->toArray();
    return view('admin/bills/create', compact('reservation', 'data', 'payment_limit'));
  }

  public function createSession(Request $request)
  {
    $data = $request->all();
    return view('admin.bills.check', compact(
      'data',
    ));
  }

  /***********************
   * ajax 請求書追加 備品サービス取得
   ***********************
   */
  public function ajaxaddbillsequipments(Request $request)
  {
    $reservation = Reservation::find($request->reservation_id);
    $equipments = $reservation->venue->equipments()->get();
    $services = $reservation->venue->services()->get();
    return [$equipments, $services];
  }

  /***********************
   * ajax 請求書追加 レイアウト取得
   ***********************
   */
  public function ajaxaddbillslaytout(Request $request)
  {
    $reservation = Reservation::find($request->reservation_id);
    $layout_prepare = $reservation->venue->layout_prepare;
    $layout_clean = $reservation->venue->layout_clean;
    return [$layout_prepare, $layout_clean];
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
      return $this->create($request);
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
      dump($e->getMessage());
      return $this->createSession($request)->withErrors($e->getMessage());
    }
    $request->session()->regenerate();
    return redirect()->route('admin.reservations.show', $data['reservation_id']);
  }

  public function OtherDoubleCheck(Request $request)
  {
    DB::transaction(function () use ($request) {
      $bill = Bill::find($request->bills_id);
      if ($request->double_check_status == 0) {
        $bill->update([
          'double_check1_name' => $request->double_check1_name,
          'double_check_status' => 1
        ]);
      } elseif ($request->double_check_status == 1) {
        $bill->update([
          'double_check2_name' => $request->double_check2_name,
          'double_check_status' => 2
        ]);
      }
    });
    $bill = Bill::find($request->bills_id);
    return redirect('admin/reservations/' . $bill->reservation_id);
  }

  public function other_send_approve(Request $request)
  {
    DB::transaction(function () use ($request) { //トランザクションさせる
      $bill = Bill::with('reservation.user')->find($request->bill_id);
      $bill->update([
        'reservation_status' => 2, 'approve_send_at' => date('Y-m-d H:i:s')
      ]);
      // $admin = explode(',', config('app.admin_email'));
      // Mail::to($admin) //管理者
      //   ->send(new AdminReqAddRes());
      // Mail::to($bill->reservation->user->email) //ユーザー
      //   ->send(new UserReqAddRes());
      $user = User::find($bill->reservation->user->id);
      $reservation = $bill;
      $venue = Venue::find($bill->reservation->venue_id);
      $SendSMGEmail = new SendSMGEmail($user, $reservation, $venue);
      $SendSMGEmail->send("予約内容追加。管理者からユーザーへ承認依頼を送付");
    });
    return redirect()->route('admin.reservations.index');
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    $bill = Bill::find($id);
    // $data = $request->all();
    // $request->session()->put('add_bill', $data);
    return view('admin.bills.edit', compact('bill'));
  }

  public function agentEdit($id)
  {
    $bill = Bill::with(['reservation.agent', 'breakdowns'])->find($id);
    $percent = $bill->reservation->agent->cost;
    return view('admin.bills.agent_edit', compact('bill', 'percent'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
    $data = $request->all();
    DB::beginTransaction();
    try {
      $bill = Bill::with('reservation', 'breakdowns')->find($id);
      $bill->BillUpdate($data, $bill->reservation_status, $bill->double_check_status, $bill->category);
      $bill->breakdowns->map(function ($item) {
        return $item->delete();
      });
      $breakdowns = new Breakdown;
      $result_breakdowns = $breakdowns->BreakdownStore($bill->id, $data);
      DB::commit();
    } catch (\Exception $e) {
      DB::rollback();
      // return back()->withInput()->withErrors($e->getMessage());
      return back()->withInput()->withErrors("内容・単価・数量・金額は必須です");
    }
    $request->session()->regenerate();
    return redirect(route('admin.reservations.show', $bill->reservation->id));
  }

  public function agentEditUpdate(Request $request, $id)
  {
    $data = $request->all();
    DB::beginTransaction();
    try {
      $bill = Bill::with('reservation', 'breakdowns')->find($id);
      $bill->BillUpdate($data, $bill->reservation_status, $bill->double_check_status, $bill->category);
      $bill->breakdowns->map(function ($item) {
        return $item->delete();
      });
      $breakdowns = new Breakdown;
      $result_breakdowns = $breakdowns->BreakdownStore($bill->id, $data);
      DB::commit();
    } catch (\Exception $e) {
      DB::rollback();
      return back()->withInput()->withErrors("内容・単価・数量・金額は必須です");
      // return back()->withInput()->withErrors($e->getMessage());
    }

    $request->session()->regenerate();
    return redirect(route('admin.reservations.show', $bill->reservation->id));




    // $bill = Bill::with('reservation')->find($id);
    // $bill->UpdateBill($request);
    // $request->session()->put('add_breakdown', $request->all());
    // $data = $request->session()->get('add_breakdown');
    // $bill->agentUpdateBreakdown($data);
    // $request->session()->regenerate();
    // return redirect(route('admin.reservations.show', $bill->reservation->id));
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  // public function destroy($id)
  // {
  //   //
  // }

  public function updateBillInfo(Request $request)
  {
    $validatedData = $request->validate(
      [
        'bill_created_at' => 'required',
        'payment_limit' => 'required',
        'bill_company' => 'required',
        'bill_person' => 'required',
      ],
      [
        'bill_created_at.required' => '[請求書情報] ※請求日は必須です',
        'payment_limit.required' => '[請求書情報] ※支払期日は必須です',
        'bill_company.required' => '[請求書情報] ※請求書宛名は必須です',
        'bill_person.required' => '[請求書情報] ※担当者は必須です',
      ]
    );
    $bill = Bill::with('reservation')->find($request->bill_id);
    $bill->update(
      [
        'bill_created_at' => $request->bill_created_at,
        'payment_limit' => $request->payment_limit,
        'bill_company' => $request->bill_company,
        'bill_person' => $request->bill_person,
        'bill_remark' => $request->bill_remark,
      ]
    );
    return redirect(url('admin/reservations/' . $bill->reservation->id));
  }

  public function updatePaidInfo(Request $request)
  {
    $validatedData = $request->validate(
      [
        'paid' => 'required',
        // 'pay_day' => 'date',
        // 'payment' => 'integer|min:0',
      ],
      [
        'paid.required' => '[入金情報] ※入金状況は必須です',
        // 'pay_day.date' => '[入金情報] ※入金日は日付で入力してください',
        // 'payment.integer' => '[入金情報] ※入金額は半角英数字で入力してください',
        // 'payment.min' => '[入金情報] ※入金額は0以上を入力してください',
      ]
    );
    $bill = Bill::with('reservation.user')->find($request->bill_id);
    $bill->update(
      [
        'paid' => $request->paid,
        'pay_day' => $request->pay_day,
        'pay_person' => $request->pay_person,
        'payment' => !empty($request->payment) ? $request->payment : NULL,
      ]
    );
    if ($bill->reservation->agent_id == 0) {
      $this->judgePaymentStatusAndSendEmail($request->paid, $bill->reservation->user);
    }
    return redirect(url('admin/reservations/' . $bill->reservation->id));
  }

  /**
   * 入金ステータスが1なら入金完了メールを送る
   *
   * @param int $status
   * @param object $user
   */

  public function judgePaymentStatusAndSendEmail($status, $user)
  {
    if ((int)$status === 1) {
      $admin = explode(',', config('app.admin_email'));
      Mail::to($admin)->send(new AdminPaid($user));
      Mail::to($user->email)->send(new UserPaid($user));
    }
  }
}
