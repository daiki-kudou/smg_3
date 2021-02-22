<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\MultipleReserve;
use App\Models\PreReservation;
use App\Models\Venue;

class MultiplesController extends Controller
{
  public function index()
  {
    $multiples = MultipleReserve::withCount('pre_reservations')->get();

    return view('admin.multiples.index', [
      'multiples' => $multiples,
    ]);
  }

  public function show($id)
  {
    $multiple = MultipleReserve::find($id);
    $venues = $multiple->pre_reservations()->distinct('')->select('venue_id')->get();
    $venue_count = $venues->count('venue_id');

    return view('admin.multiples.show', [
      'multiple' => $multiple,
      'venue_count' => $venue_count,
      'venues' => $venues,
    ]);
  }

  public function edit($multiple_id, $venue_id)
  {
    $multiple = MultipleReserve::find($multiple_id);
    $venue = Venue::find($venue_id);
    return view('admin.multiples.edit', [
      'multiple' => $multiple,
      'venue' => $venue,
    ]);
  }

  public function calculate(Request $request, $multiple_id, $venue_id)
  {

    $multiple = MultipleReserve::find($multiple_id);
    $venue = Venue::find($venue_id);

    $result = $multiple->calculateVenue($venue_id, $request); //0に会場料金　1にサービス　2にレイアウト

    $multiple->preStore($venue_id, $request, $result);

    return view('admin.multiples.calculate', [
      'multiple' => $multiple,
      'venue' => $venue,
      'request' => $request,
      'result' => $result,
    ]);
  }

  public function specificUpdate(Request $request, $multiple_id, $venue_id, $pre_reservation_id)
  {
    $pre_reservation = PreReservation::find($pre_reservation_id);
    // echo "<pre>";
    // var_dump($request->all());
    // echo "</pre>";

    $result = $pre_reservation->reCalculateVenue($request, $venue_id);

    $pre_reservation->specificUpdate($request, $result, $venue_id);

    return redirect('admin/multiples/' . $multiple_id . '/edit/' . $venue_id);
  }



  public function allUpdates(Request $request, $multiples_id, $venues_id)
  {



    $masterData = json_decode($request->master_data);
    $multiple = MultipleReserve::find($multiples_id);
    $multiple->UpdateAndReCreateAll($masterData);

    // echo "<pre>";
    // var_dump($masterData);
    // echo "</pre>";
  }
}
