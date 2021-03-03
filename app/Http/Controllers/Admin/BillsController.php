<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Bill;

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
    $requests = $request->all();
    $s_venues = [];
    $s_equipments = [];
    $s_layouts = [];
    $s_others = [];
    foreach ($request->all() as $key => $value) {
      if (preg_match('/venue_breakdown/', $key)) {
        $s_venues[] = $value;
      }
      if (preg_match('/equipment_breakdown/', $key)) {
        $s_equipments[] = $value;
      }
      if (preg_match('/layout_breakdown/', $key)) {
        $s_layouts[] = $value;
      }
      if (preg_match('/others_breakdown/', $key)) {
        $s_others[] = $value;
      }
    }
    return view('admin.bills.check', [
      'requests' => $requests,
      's_venues' => $s_venues,
      's_equipments' => $s_equipments,
      's_layouts' => $s_layouts,
      's_others' => $s_others,
    ]);
  }


  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    echo "<pre>";
    var_dump($request->all());
    echo "</pre>";

    DB::transaction(function () use ($request) {
    });

    DB::transaction(function () use ($request) { //トランザクションさせる
      $bill = Bill::create([
        'reservation_id' => $request->reservation_id,
        'venue_price' => $request->venue_price ? $request->venue_price : 0,
        'equipment_price' => $request->equipment_price ? $request->equipment_price : 0,
        'layout_price' => $request->layout_price ? $request->layout_price : 0,
        'others_price' => $request->others_price ? $request->others_price : 0,
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


      function toBreakDown($num, $sub, $target, $type)
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
      toBreakDown($request->all(), 'venue_breakdown', $bill, 1);
      toBreakDown($request->all(), 'equipment_breakdown', $bill, 2);
      toBreakDown($request->all(), 'layout_breakdown_', $bill, 4);
      toBreakDown($request->all(), 'others_breakdown', $bill, 5);
    });

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
    var_dump($id);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  // public function update(Request $request, $id)
  // {
  //   //
  // }

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
