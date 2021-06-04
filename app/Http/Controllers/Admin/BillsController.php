<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Bill;
use App\Models\Venue;

use App\Models\Reservation;
use App\Models\User;

use Illuminate\Support\Facades\DB; //トランザクション用

use App\Mail\SendUserOtherBillsApprove;
use Illuminate\Support\Facades\Mail;
// メール
use App\Mail\AdminReqAddRes;
use App\Mail\UserReqAddRes;


use Carbon\Carbon;

use App\Traits\PregTrait;




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
    $reservation = Reservation::find($request->reservation_id);
    $user = User::find($reservation->user_id);
    $pay_limit = $user->getUserPayLimit($reservation->reserve_date);
    $data = $request->session()->get('add_bill');
    if (!empty($data)) {
      $venues = $this->preg($data, 'venue_breakdown_item');
      $equipments = $this->preg($data, 'equipment_breakdown_item');
      $layouts = $this->preg($data, 'layout_breakdown_item');
      $others = $this->preg($data, 'others_breakdown_item');
      return view('admin/bills/create', compact('reservation', 'pay_limit', 'data', 'venues', 'equipments', 'layouts', 'others'));
    } else {
      return view('admin/bills/create', compact('reservation', 'pay_limit'));
    }
  }

  public function createSession(Request $request)
  {
    $request->session()->forget('add_bill');
    $data = $request->all();
    $request->session()->put('add_bill', $data);
    return redirect(route("admin.bills.check"));
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

  public function check(Request $request)
  {
    $data = $request->session()->get('add_bill');
    $venues = $this->preg($data, 'venue_breakdown_item');
    $equipments = $this->preg($data, 'equipment_breakdown_item');
    $layouts = $this->preg($data, 'layout_breakdown_item');
    $others = $this->preg($data, 'others_breakdown_item');
    return view('admin.bills.check', compact(
      'data',
      'venues',
      'equipments',
      'layouts',
      'others',
    ));
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $data = $request->session()->get('add_bill');
    if ($request->back) {
      return redirect(route('admin.bills.create', [
        'reservation_id' => $data['reservation_id']
      ]));
    }

    $reservation = Reservation::find($data["reservation_id"]);
    try {
      $bill = $reservation->ReserveStoreSessionBill($request, 'add_bill', 'add_bill', "add"); //引数4番は追加請求時のみ発動、デフォはnormal
      $bill->ReserveStoreSessionBreakdown($request, 'add_bill');
    } catch (\Exception $e) {
      report($e);
      session()->flash('flash_message', '更新に失敗しました。<br>フォーム内の空欄や全角など確認した上でもう一度お試しください。');
      return redirect(route('admin.bills.check', $request->reservation_id));
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
      $admin = explode(',', config('app.admin_email'));
      Mail::to($admin) //管理者
        ->send(new AdminReqAddRes());
      Mail::to($bill->reservation->user->email) //ユーザー
        ->send(new UserReqAddRes());
    });
    return redirect()->route('admin.reservations.index');
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  // public function show($id)
  // {
  //   //
  // }

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
    $bill = Bill::with('reservation')->find($id);
    $bill->UpdateBill($request);
    $bill->ReserveStoreBreakdown($request);
    $request->session()->regenerate();
    return redirect(route('admin.reservations.show', $bill->reservation->id));
  }

  public function agentEditUpdate(Request $request, $id)
  {
    $bill = Bill::with('reservation')->find($id);
    $bill->UpdateBill($request);
    $request->session()->put('add_breakdown', $request->all());
    $data = $request->session()->get('add_breakdown');
    $bill->agentUpdateBreakdown($data);
    $request->session()->regenerate();
    return redirect(route('admin.reservations.show', $bill->reservation->id));
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
        'pay_day' => 'date',
        'payment' => 'integer|min:0',
      ],
      [
        'paid.required' => '[入金情報] ※入金状況は必須です',
        'pay_day.date' => '[入金情報] ※入金日は日付で入力してください',
        'payment.integer' => '[入金情報] ※入金額は半角英数字で入力してください',
        'payment.min' => '[入金情報] ※入金額は0以上を入力してください',
      ]
    );
    $bill = Bill::with('reservation')->find($request->bill_id);
    $bill->update(
      [
        'paid' => $request->paid,
        'pay_day' => $request->pay_day,
        'pay_person' => $request->pay_person,
        'payment' => !empty($request->payment) ? $request->payment : 0,
      ]
    );
    return redirect(url('admin/reservations/' . $bill->reservation->id));
  }
}
