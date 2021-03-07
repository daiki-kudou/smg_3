<?php

namespace App\Http\Controllers\Admin;

use App\Models\Cxl;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Bill;
use App\Models\User;


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
  public function create(Request $request)
  {
    var_dump($request->all());
    $bill = Bill::find($request->bills_id);

    return view('admin.cxl.create', compact('bill', 'request'));
  }

  public function calculate(Request $request)
  {
    $bill = Bill::find($request->bills_id);
    $result = $bill->getCxlPrice($request);
    $user = User::find($bill->reservation->user_id);
    $payment_limit = $user->getUserPayLimit($bill->reservation->reserve_date);
    return view(
      'admin.cxl.calculate',
      compact('bill', 'request', 'result', 'user', 'payment_limit')
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
    //
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
