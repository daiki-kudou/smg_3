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
    var_dump($request->all());
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
      $reservation->ReserveStoreSessionBill($request, 'add_bill', 'add_bill', "add"); //引数4番は追加請求時のみ発動、デフォはnormal
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
      $bill = Bill::find($request->bill_id);
      $bill->update([
        'reservation_status' => 2, 'approve_send_at' => date('Y-m-d H:i:s')
      ]);
      $email = $bill->reservation->user->email;
      Mail::to($email)->send(new SendUserOtherBillsApprove($bill));
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
    return view('admin.bills.edit', compact('bill'));
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
    $bill = Bill::find($id);
    $bill->UpdateBill($request);
    $bill->ReserveStoreBreakdown($request);
    $bill->LayoutBreakdowns($request);
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
}
