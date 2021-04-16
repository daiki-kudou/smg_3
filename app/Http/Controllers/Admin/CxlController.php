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
    $request->session()->forget('cxlCalcInfo');
    $request->session()->put('cxlCalcInfo', $request->all());
    $cxl = new Cxl;
    $result = $cxl->calcCxlAmount();
    return redirect(route('admin.cxl.multi_calc', compact('result')));
  }

  public function multiCalcShow(Request $request)
  {
    $info = session()->get('cxlMaster');
    $data = session()->get('cxlCalcInfo');
    $reservation = Reservation::with('user')->find($data['reservation_id']);
    $user = $reservation->user;
    $result = $request->result;
    return view('admin.cxl.multi_calculate', compact('info', 'data', 'result', 'user'));
  }


  // public function calculate(Request $request)
  // {
  //   // $bill = Bill::find($request->bills_id);
  //   // $result = $bill->getCxlPrice($request);
  //   // $user = User::find($bill->reservation->user_id);
  //   // $payment_limit = $user->getUserPayLimit($bill->reservation->reserve_date);
  //   return view(
  //     'admin.cxl.calculate',
  //     // compact('bill', 'request', 'result', 'user', 'payment_limit')
  //   );
  // }

  public function check(Request $request)
  {
    $info = session()->get('cxlMaster');
    $data = session()->get('cxlCalcInfo');
    if ($request->back) {
      return redirect(route(
        'admin.cxl.multi_create',
        ['reservation_id' => $data['reservation_id']]
      ));
    }

    return view(
      'admin.cxl.check',
      // compact('bill', 'request', 'result', 'payment_limit', 'user')
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
    $cxl = new Cxl;
    $cxl->storeCxl($request);
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
