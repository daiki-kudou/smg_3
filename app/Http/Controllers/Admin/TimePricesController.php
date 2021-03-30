<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\TimePrices;
use App\Models\Venue;
use Carbon\Carbon;


class TimePricesController extends Controller
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
  public function create($id)
  {
    $venue = Venue::find($id);
    $time_price = new Time_price;
    return view('admin.time_prices.create', [
      'venue' => $venue,
      'time_price' => $time_price,
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
    $previous = $request->session()->get('_previous');
    $previous = $previous['url'];
    $origin = request()->server->get('HTTP_ORIGIN');
    $origin = $origin . '/admin/time_prices/create/' . $request->venue_id;

    // 別ルートからきたstoreは拒絶
    if ($previous != $origin) {
      return abort(404);
    }

    //createからくるフォームのrequestが何列かにわかれてくるため何列かわかるための計算
    $count_request = (count($request->all()) - 2) / 3;
    if ($count_request == 1) { //$requestの中身が１列の場合
      Time_price::create([
        'time' => $request->time,
        'price' => $request->price,
        'extend' => $request->extend,
        'venue_id' => $request->venue_id,
      ]);
      //$requestが１列以上の場合
    } else {
      for ($i = 0; $i < $count_request; $i++) {
        $v_time = 'time' . $i;
        $v_price = 'price' . $i;
        $v_extend = 'extend' . $i;
        Time_price::create([
          'time' => $request->$v_time,
          'price' => $request->$v_price,
          'extend' => $request->$v_extend,
          'venue_id' => $request->venue_id,
        ]);
      }
    }

    return redirect('/admin/frame_prices/' . $request->venue_id);
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    $venue = Venue::find($id);
    $time_prices = $venue->time_prices;

    return view('admin.time_prices.edit', [
      'venue' => $venue,
      'time_prices' => $time_prices,
    ]);
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
    $count_request = ((count($request->all())) - 3) / 3;
    if ($count_request == 1) {
      $request->validate([
        'time0' => 'required',
        'price0' => 'required',
        'extend0' => 'required',
      ]);
    } else {
      for ($i = 0; $i < $count_request; $i++) {
        $v_time = 'time' . $i;
        $v_price = 'price' . $i;
        $v_extend = 'extend' . $i;
        $request->validate([
          $v_time => 'required',
          $v_price => 'required',
          $v_extend => 'required',
        ]);
      }
    }

    $time_prices = Time_price::where('venue_id', $id);
    $time_prices->delete();

    if ($count_request == 1) { //$requestの中身が１列の場合
      Time_price::create([
        'time' => $request->time0,
        'price' => $request->price0,
        'extend' => $request->extend0,
        'venue_id' => $request->venue_id,
      ]);
      //$requestが１列以上の場合
    } else {
      for ($i = 0; $i < $count_request; $i++) {
        $v_time = 'time' . $i;
        $v_price = 'price' . $i;
        $v_extend = 'extend' . $i;
        Time_price::create([
          'time' => $request->$v_time,
          'price' => $request->$v_price,
          'extend' => $request->$v_extend,
          'venue_id' => $request->venue_id,
        ]);
      }
    }
    return redirect('/admin/frame_prices/' . $id);
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
