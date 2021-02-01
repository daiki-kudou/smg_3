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
    DB::transaction(function () use ($request) { //トランザクションさせる
      if ($request->unit_type == 2) {
        $bill = Bill::create([
          'reservation_id' => $request->reservation_id,
          'venue_total' => 0, //追加請求書で会場の追加はありえないので、固定で0
          'venue_discount_percent' => 0, //追加請求書にて会場関連は全部固定で0
          'venue_dicsount_number' => 0, //追加請求書にて会場関連は全部固定で0
          'discount_venue_total' => 0, //追加請求書にて会場関連は全部固定で0
          'equipment_total' => 0, //追加請求書にて　備品とサービスは項目が分かれておらず統一されているので、備品とサービスの個別の料金は不要
          'service_total' =>  0, //追加請求書にて　備品とサービスは項目が分かれておらず統一されているので、備品とサービスの個別の料金は不要
          'luggage_total' => 0, //追加請求書にて荷物預かりは不要なので、固定で0
          'equipment_service_total' => $request->sub_total,
          'discount_item' => $request->discount_input, //割引額
          'discount_equipment_service_total' => $request->after_dicsount,
          'layout_total' => 0,
          'layout_discount' => 0, //割引額
          'after_duscount_layouts' => 0,
          'others_total' => 0,
          'others_discount' => 0,
          'after_duscount_others' => 0,
          'sub_total' => $request->after_dicsount,
          'tax' => $request->tax,
          'total' => $request->total,
          'paid' => 0, //デフォで0 作成時点では未入金
          'reservation_status' => 1, //デフォで1、仮抑えのデフォは0
          'double_check_status' => 0, //デフォで0
          'category' => 2 //デフォで2。　新規以外だと　2:その他有料備品　3:レイアウト　4:その他
        ]);
        foreach ($request->master_arrays as $key => $value) {
          $bill->breakdowns()->create([
            'unit_item' => $value['unit_item'],
            'unit_cost' => $value['unit_cost'],
            'unit_count' => $value['unit_count'],
            'unit_subtotal' => $value['unit_subtotal'],
            'unit_type' => 2 //unit_typeが２で渡ってきているので、２で固定
          ]);
        }
      } elseif ($request->unit_type == 3) {
        $bill = Bill::create([
          'reservation_id' => $request->reservation_id,
          'venue_total' => 0, //追加請求書で会場の追加はありえないので、固定で0
          'venue_discount_percent' => 0, //追加請求書にて会場関連は全部固定で0
          'venue_dicsount_number' => 0, //追加請求書にて会場関連は全部固定で0
          'discount_venue_total' => 0, //追加請求書にて会場関連は全部固定で0
          'equipment_total' => 0, //追加請求書にて　備品とサービスは項目が分かれておらず統一されているので、備品とサービスの個別の料金は不要
          'service_total' =>  0, //追加請求書にて　備品とサービスは項目が分かれておらず統一されているので、備品とサービスの個別の料金は不要
          'luggage_total' => 0, //追加請求書にて荷物預かりは不要なので、固定で0
          'equipment_service_total' => 0, //３が渡ってきているのでここは固定０
          'discount_item' => 0, //３が渡ってきているのでここは固定０
          'discount_equipment_service_total' => 0, //３が渡ってきているのでここは固定０
          'layout_total' => $request->sub_total,
          'layout_discount' => $request->discount_input, //割引額
          'after_duscount_layouts' => $request->after_dicsount,
          'others_total' => 0,
          'others_discount' => 0,
          'after_duscount_others' => 0,

          'sub_total' => $request->after_dicsount,
          'tax' => $request->tax,
          'total' => $request->total,
          'paid' => 0, //デフォで0 作成時点では未入金
          'reservation_status' => 1, //デフォで1、仮抑えのデフォは0
          'double_check_status' => 0, //デフォで0
          'category' => 3 //デフォで2。　新規以外だと　2:その他有料備品　3:レイアウト　4:その他
        ]);
        foreach ($request->master_arrays as $key => $value) {
          $bill->breakdowns()->create([
            'unit_item' => $value['unit_item'],
            'unit_cost' => $value['unit_cost'],
            'unit_count' => $value['unit_count'],
            'unit_subtotal' => $value['unit_subtotal'],
            'unit_type' => 3 //unit_typeが２で渡ってきているので、3で固定
          ]);
        }
      } elseif ($request->unit_type == 4) {
        var_dump($request->all());
        $bill = Bill::create([
          'reservation_id' => $request->reservation_id,
          'venue_total' => 0, //追加請求書で会場の追加はありえないので、固定で0
          'venue_discount_percent' => 0, //追加請求書にて会場関連は全部固定で0
          'venue_dicsount_number' => 0, //追加請求書にて会場関連は全部固定で0
          'discount_venue_total' => 0, //追加請求書にて会場関連は全部固定で0
          'equipment_total' => 0, //追加請求書にて　備品とサービスは項目が分かれておらず統一されているので、備品とサービスの個別の料金は不要
          'service_total' =>  0, //追加請求書にて　備品とサービスは項目が分かれておらず統一されているので、備品とサービスの個別の料金は不要
          'luggage_total' => 0, //追加請求書にて荷物預かりは不要なので、固定で0
          'equipment_service_total' => 0, //３が渡ってきているのでここは固定０
          'discount_item' => 0, //３が渡ってきているのでここは固定０
          'discount_equipment_service_total' => 0, //３が渡ってきているのでここは固定０
          'layout_total' => 0,
          'layout_discount' => 0,
          'after_duscount_layouts' => 0,

          'others_total' => $request->sub_total,
          'others_discount' => $request->discount_input,
          'after_duscount_others' => $request->after_dicsount,

          'sub_total' => $request->after_dicsount,
          'tax' => $request->tax,
          'total' => $request->total,
          'paid' => 0, //デフォで0 作成時点では未入金
          'reservation_status' => 1, //デフォで1、仮抑えのデフォは0
          'double_check_status' => 0, //デフォで0
          'category' => 4 //デフォで2。　新規以外だと　2:その他有料備品　3:レイアウト　4:その他
        ]);
        foreach ($request->master_arrays as $key => $value) {
          $bill->breakdowns()->create([
            'unit_item' => $value['unit_item'],
            'unit_cost' => $value['unit_cost'],
            'unit_count' => $value['unit_count'],
            'unit_subtotal' => $value['unit_subtotal'],
            'unit_type' => 4 //unit_typeが２で渡ってきているので、4で固定
          ]);
        }
      }
    });

    $request->session()->regenerate();
    return redirect()->route('admin.reservations.show', $request->reservation_id);
  }

  public function OtherDoubleCheck(Request $request)
  {
    $bill = Bill::find($request->bills_id);

    if ($request->double_check_status == 0) {
      $bill->update([
        'double_check1_name' => $request->double_check1_name,
        'double_check_status' => 1
      ]);
    } else if ($request->double_check_status == 1) {
      $bill->update([
        'double_check2_name' => $request->double_check2_name,
        'double_check_status' => 2
      ]);
    }
    return redirect('admin/reservations/' . $bill->reservation_id);
  }

  public function other_send_approve(Request $request)
  {
    DB::transaction(function () use ($request) { //トランザクションさせる

      $bill = Bill::find($request->id);
      $bill->update([
        'reservation_status' => 2, 'approve_send_at' => date('Y-m-d H:i:s')
      ]);
      $email = $bill->reservation->user->email;
      Mail::to($email)->send(new SendUserOtherBillsApprove($bill));
    });
    // return redirect()->route('admin.reservations.index');
  }





  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    //
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
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    //
  }
}
