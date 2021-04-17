<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Database\Eloquent\Model;
use App\Models\Cxl;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Models\Bill;
use App\Models\User;
use App\Models\Reservation;




class CxlController extends Controller
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
  public function multiCreate(Request $request)
  {
    $reservation = Reservation::with('bills')->find($request->reservation_id);
    $price_result = $reservation->pluckSum(['venue_price', 'equipment_price', 'layout_price', 'others_price']);
    session()->put('cxlMaster', $price_result);
    return view('admin.cxl.multi_create', compact('price_result', 'reservation'));
  }

  public function multiCalc(Request $request)
  {
    $request->session()->forget('invoice');
    $request->session()->put('cxlCalcInfo', $request->all());
    $cxl = new Cxl;
    $result = $cxl->calcCxlAmount();
    $request->session()->put('cxlResult', $result);
    return redirect(route('admin.cxl.multi_calc'));
  }

  public function multiCalcShow(Request $request)
  {
    $info = session()->get('cxlMaster');
    $data = session()->get('cxlCalcInfo');
    $result = session()->get('cxlResult');

    $reservation = Reservation::with('user')->find($data['reservation_id']);
    $user = $reservation->user;
    // $result = $request->result;
    return view('admin.cxl.multi_calculate', compact('info', 'data', 'result', 'user'));
  }

  public function multiCheck(Request $request)
  {
    $info = session()->get('cxlMaster');
    $data = session()->get('cxlCalcInfo');
    $result = session()->get('cxlResult');
    $request->session()->put('invoice', $request->all());
    $invoice = session()->get('invoice');
    if ($request->back) {
      return redirect(route(
        'admin.cxl.multi_create',
        ['reservation_id' => $data['reservation_id']]
      ));
    }
    return view(
      'admin.cxl.multi_check',
      compact('info', 'data', 'result', 'invoice')
    );
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function multiStore(Request $request)
  {
    if ($request->back) {
      return redirect(route('admin.cxl.multi_calc'));
    }
    $data = session()->get('cxlCalcInfo');
    $invoice = session()->get('invoice');
    $reservation_id = $data['reservation_id'];

    // try {
    $cxl = new Cxl;
    $bill_id = 0; //一括キャンセルによりbill_idを0にする　単発の場合はbillに応じたbill_id;
    $cxlBill = $cxl->storeCxl($data, $invoice, $bill_id);
    $cxlBill->storeCxlBreakdown($data, $invoice);
    $bills = Bill::where('reservation_id', $reservation_id)->where('reservation_status', 3)->get();
    foreach ($bills as $key => $value) {
      $value->updateStatusByCxl();
    }
    // } catch (\Exception $e) {
    //   report($e);
    //   session()->flash('flash_message', '作成に失敗しました。<br>フォーム内の空欄や全角など確認した上でもう一度お試しください。');
    //   return redirect(route('admin.cxl.multi_calc'));
    // }
    // $request->session()->regenerate();
    // return redirect()->route('admin.reservations.show', $reservation_id);
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Cxl  $cxl
   * @return \Illuminate\Http\Response
   */
  public function show(Cxl $cxl)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\Cxl  $cxl
   * @return \Illuminate\Http\Response
   */
  public function edit(Cxl $cxl)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Cxl  $cxl
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Cxl $cxl)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Cxl  $cxl
   * @return \Illuminate\Http\Response
   */
  public function destroy(Cxl $cxl)
  {
    //
  }
}
