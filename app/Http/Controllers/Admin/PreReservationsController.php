<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Reservation;
use App\Models\Venue;
use App\Models\User;
use App\Models\Bill;
use App\Models\Breakdown;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB; //トランザクション用



class PreReservationsController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    return view('admin.pre_reservations.index');
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    $users = User::all();
    $venues = Venue::all();
    return view('admin.pre_reservations.create', [
      'users' => $users,
      'venues' => $venues,
    ]);
  }

  public function check(Request $request)
  {

    $judge_count = [];
    foreach ($request->all() as $key => $value) {
      if (preg_match('/pre_date/', $key)) {
        $judge_count[] = $value;
      }
    }
    echo "<pre>";
    var_dump($request->all());
    echo "</pre>";

    if (count($judge_count) == 1) {
      $venue = Venue::find($request->pre_venue0);
      $equipments = $venue->equipments()->get();
      $services = $venue->services()->get();
      $layouts = [];
      $layouts[] = $venue->layout_prepare == 0 ? 0 : $venue->layout_prepare;
      $layouts[] = $venue->layout_clean == 0 ? 0 : $venue->layout_clean;

      return view('admin.pre_reservations.single_check', [
        'request' => $request,
        'equipments' => $equipments,
        'services' => $services,
        'venue' => $venue,
        'layouts' => $layouts,
      ]);
    }
  }

  public function calculate(Request $request)
  {


    if ($request->judge_count == 1) { //単発仮抑えの計算
      echo "<pre>";
      var_dump($request->all());
      echo "</pre>";
      $venues = Venue::all();
      $venue = $venues->find($request->venue_id);
      $equipments = $venue->equipments()->get();
      $services = $venue->services()->get();

      return view('admin.pre_reservations.single_calculate', [
        'request' => $request,
        'equipments' => $equipments,
        'services' => $services,
        'venues' => $venues,
        // 'venue' => $venue,
      ]);
    }
  }


  public function getuser(Request $request)
  {
    $user = User::find($request->user_id);
    return $user;
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
