<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Frame_price;
use App\Models\Venue;


class Freme_pricesController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $venues = Venue::all();
    return view('admin.frame_prices.index', [
      'venues' => $venues,
    ]);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create($id)
  {
    $venue = Venue::find($id);
    return view('admin.frame_prices.create', [
      'venue' => $venue,
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
    // 直前のセッション取得
    $previous = $request->session()->get('_previous');
    $previous = $previous['url'];
    $origin = request()->server->get('HTTP_ORIGIN');
    $origin = $origin . '/admin/frame_prices/create/' . $request->venue_id;

    // 別ルートからきたstoreは拒絶
    if ($previous != $origin) {
      return abort(404);
    }

    //createからくるフォームのrequestが何列かにわかれてくるため何列かわかるための計算
    $count_request = (count($request->all()) - 3) / 4;

    // バリデーションは後日対応予定、現時点で未着手
    // if ($count_request == 1) {
    //     $request->validate([
    //         'frame' => 'required',
    //         'start' => 'required',
    //         'finish' => 'required',
    //         'price' => 'required|integer|min:1',
    //         'extend' => 'required',
    //     ]);
    // }
    // else {
    //     for ($i = 0; $i < $count_request; $i++) {
    //         $v_frame = 'frame' . $i;
    //         $v_start = 'start' . $i;
    //         $v_finish = 'finish' . $i;
    //         $v_price = 'price' . $i;
    //         $request->validate([
    //             $v_frame => 'required',
    //             $v_start => 'required',
    //             $v_finish => 'required',
    //             $v_price => 'required',
    //             'extend' => 'required',
    //         ]);
    //     }
    // }

    if ($count_request == 1) { //$requestの中身が１列の場合
      Frame_price::create([
        'frame' => $request->frame0,
        'start' => $request->start0,
        'finish' => $request->finish0,
        'price' => $request->price0,
        'venue_id' => $request->venue_id,
        'extend' => $request->extend,
      ]);
      //$requestが１列以上の場合
    } else {
      for ($i = 0; $i < $count_request; $i++) {
        Frame_price::create([
          'frame' => $request->{'frame' . $i},
          'start' => $request->{'start' . $i},
          'finish' => $request->{'finish' . $i},
          'price' => $request->{'price' . $i},
          'venue_id' => $request->venue_id,
          'extend' => $request->extend,
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
    $venue = Venue::find($id);
    $frame_prices = $venue->frame_prices;
    $time_prices = $venue->time_prices;
    return view('admin.frame_prices.show', [
      'venue' => $venue,
      'frame_prices' => $frame_prices,
      'time_prices' => $time_prices,
    ]);
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
    $frame_prices = $venue->frame_prices;

    return view('admin.frame_prices.edit', [
      'venue' => $venue,
      'frame_prices' => $frame_prices,
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

    $count_request = ((count($request->all())) - 4) / 4;

    // if ($count_request == 1) {
    //   $request->validate([
    //     'frame0' => 'required',
    //     'start0' => 'required',
    //     'finish0' => 'required',
    //     'price0' => 'required',
    //     'extend' => 'required',
    //   ]);
    // } else {
    //   for ($i = 0; $i < $count_request; $i++) {
    //     $v_frame = 'frame' . $i;
    //     $v_start = 'start' . $i;
    //     $v_finish = 'finish' . $i;
    //     $v_price = 'price' . $i;
    //     $request->validate([
    //       $v_frame => 'required',
    //       $v_start => 'required',
    //       $v_finish => 'required',
    //       $v_price => 'required',
    //       'extend' => 'required',
    //     ]);
    //   }
    // }

    $frame_prices = Frame_price::where('venue_id', $id);
    $frame_prices->delete();

    if ($count_request == 1) { //$requestの中身が１列の場合
      Frame_price::create([
        'frame' => $request->frame0,
        'start' => $request->start0,
        'finish' => $request->finish0,
        'price' => $request->price0,
        'venue_id' => $request->venue_id,
        'extend' => $request->extend,
      ]);
      //$requestが１列以上の場合
    } else {
      for ($i = 0; $i < $count_request; $i++) {
        $v_frame = 'frame' . $i;
        $v_start = 'start' . $i;
        $v_finish = 'finish' . $i;
        $v_price = 'price' . $i;
        Frame_price::create([
          'frame' => $request->$v_frame,
          'start' => $request->$v_start,
          'finish' => $request->$v_finish,
          'price' => $request->$v_price,
          'venue_id' => $request->venue_id,
          'extend' => $request->extend,
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
  }
}
