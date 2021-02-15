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
      // echo "<pre>";
      // var_dump($request->all());
      // echo "</pre>";
      $users = User::all();
      $venues = Venue::all();
      $venue = $venues->find($request->venue_id);
      $equipments = $venue->equipments()->get();
      $services = $venue->services()->get();

      $price_details = $venue->calculate_price( //[0]は合計料金, [1]は延長料金, [2]は合計＋延長、 [3]は利用時間, [4]は延長時間
        $request->price_system,
        $request->enter_time,
        $request->leave_time
      );

      echo "<pre>";
      var_dump($price_details);
      echo "</pre>";

      $s_equipment = [];
      $s_services = [];
      foreach ($request->all() as $key => $value) {
        if (preg_match('/equipment_breakdown/', $key)) {
          $s_equipment[] = $value;
        }
        if (preg_match('/services_breakdown/', $key)) {
          $s_services[] = $value;
        }
      }
      $item_details = $venue->calculate_items_price($s_equipment, $s_services);    // [0]備品＋サービス [1]備品詳細 [2]サービス詳細 [3]備品合計 [4]サービス合計
      $layouts_details = $venue->getLayoutPrice($request->layout_prepare, $request->layout_clean);

      echo "<pre>";
      var_dump($item_details);
      echo "</pre>";

      echo "<pre>";
      var_dump($layouts_details);
      echo "</pre>";

      if ($price_details == 0) { //枠がなく会場料金を手打ちするパターン
        $masters =
          ($item_details[0] + $request->luggage_price)
          + $layouts_details[2];
      } else {
        $masters =
          ($price_details[2] ? $price_details[2] : 0)
          + ($item_details[0] + $request->luggage_price)
          + $layouts_details[2];
      }
      $user = User::find($request->user_id);
      $pay_limit = $user->getUserPayLimit($request->reserve_date);




      return view('admin.pre_reservations.single_calculate', [
        'venues' => $venues,
        'users' => $users,
        'request' => $request,
        'equipments' => $equipments,
        'services' => $services,
        's_equipment' => $s_equipment, //選択された備品
        's_services' => $s_services, //選択されたサービス
        'price_details' => $price_details,
        'item_details' => $item_details,
        'layouts_details' => $layouts_details,
        'masters' => $masters,
        'pay_limit' => $pay_limit,
        'user' => $user,

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
