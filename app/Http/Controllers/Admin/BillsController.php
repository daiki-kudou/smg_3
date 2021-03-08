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





class BillsController extends Controller
{
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

    return view('admin/bills/create', [
      'reservation' => $reservation,
      'pay_limit' => $pay_limit,
    ]);
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
    $venues = Venue::getBreakdowns($request);
    $equipments = Venue::getBreakdowns($request);
    $services = Venue::getBreakdowns($request);
    $layouts = [];
    foreach ($request->all() as $key => $value) {
      if (preg_match('/layout_breakdown_item/', $key)) {
        $layouts[] = $value;
      }
    }
    $layouts = count($layouts);
    $others = [];
    foreach ($request->all() as $key => $value) {
      if (preg_match('/others_breakdown_item/', $key)) {
        $others[] = $value;
      }
    }
    $others = count($others);

    return view('admin.bills.check', compact(
      'request',
      'venues',
      'equipments',
      'services',
      'layouts',
      'others'
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
    $reservation = Reservation::find($request->reservation_id);
    $reservation->ReserveStoreBill($request);

    $request->session()->regenerate();
    return redirect()->route('admin.reservations.show', $request->reservation_id);
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
