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
    $request->session()->forget(['invoice', 'cxlMaster', 'cxlResult']);

    $reservation = Reservation::with('bills')->find($request->reservation_id);
    $bill = Bill::find($request->bill_id);

    if ($request->multi) {
      //一括キャンセル押下時
      $price_result = $reservation->pluckSum(['venue_price', 'equipment_price', 'layout_price', 'others_price']);
      $multi = 1;
      $single = 0;
    } elseif ($request->single) {
      //個別キャンセル押下時
      $price_result = [$bill->venue_price, $bill->equipment_price, $bill->layout_price, $bill->others_price];
      $multi = 0;
      $single = 1;
    }
    session()->put('cxlMaster', $price_result);
    session()->put('multiOrSingle', ['multi' => $multi, 'single' => $single]);
    return view('admin.cxl.multi_create', compact('price_result', 'reservation', 'bill'));
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
    $pay_limit = $user->getUserPayLimit($reservation->reserve_date);
    return view('admin.cxl.multi_calculate', compact('info', 'data', 'result', 'user', 'pay_limit'));
  }

  public function multiCheck(Request $request)
  {
    $info = session()->get('cxlMaster');
    $data = session()->get('cxlCalcInfo');
    $result = session()->get('cxlResult');
    $request->session()->put('invoice', $request->all());
    $invoice = session()->get('invoice');
    $multiOrSingle = session()->get('multiOrSingle');
    $judge = $multiOrSingle['multi'] == 1 ? 'multi' : 'single';
    if ($request->back) {
      return redirect(route(
        'admin.cxl.multi_create',
        [
          'reservation_id' => $data['reservation_id'],
          'bill_id' => $data['bill_id'],
          $judge => $judge,
        ]
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
  public function store(Request $request)
  {
    if ($request->back) {
      return redirect(route('admin.cxl.multi_calc'));
    }
    $data = session()->get('cxlCalcInfo');
    $invoice = session()->get('invoice');
    $multiOrSingle = session()->get('multiOrSingle');
    $reservation_id = $data['reservation_id'];
    $bill_id = $data['bill_id'];
    try {
      if ($multiOrSingle['multi'] === 1) {
        $this->multiStore($data, $invoice, $bill_id, $reservation_id);
      } elseif ($multiOrSingle['single'] === 1) {
        $this->singleStore($data, $invoice, $bill_id, $reservation_id);
      }
    } catch (\Exception $e) {
      report($e);
      session()->flash('flash_message', '作成に失敗しました。<br>フォーム内の空欄や全角など確認した上でもう一度お試しください。');
      return redirect(route('admin.cxl.multi_calc'));
    }
    $request->session()->regenerate();
    return redirect()->route('admin.reservations.show', $reservation_id);
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
