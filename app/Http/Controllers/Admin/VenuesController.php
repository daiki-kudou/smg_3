<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Venue; //Venue利用
use App\Models\Equipment;
use App\Models\Service;
use App\Models\Date;
use Carbon\Carbon;

use Illuminate\Support\Facades\DB;


class VenuesController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    $search_freeword = $request->freeword;
    $search_id = $request->id;
    $search_alliance_flag = $request->alliance_flag;
    $search_name_area = $request->name_area;
    $search_name_bldg = $request->name_bldg;
    $search_name_venue = $request->name_venue;
    $search_capacity1 = $request->capacity1;
    $search_capacity2 = $request->capacity2;
    $counter = $request->counter;
    $counter != '' ? $counter : $counter = 10; //デフォルト30

    $venue = new Venue;
    $querys = $venue->searchs(
      $search_freeword,
      $search_id,
      $search_alliance_flag,
      $search_name_area,
      $search_name_bldg,
      $search_name_venue,
      $search_capacity1,
      $search_capacity2,
      $counter
    );

    return view('admin.venues.index', [
      'querys' => $querys,
      'counter' => $counter,
      'search_freeword' => $search_freeword,
      'search_id' => $search_id,
      'search_alliance_flag' => $search_alliance_flag,
      'search_name_area' => $search_name_area,
      'search_name_bldg' => $search_name_bldg,
      'search_name_venue' => $search_name_venue,
      'search_capacity1' => $search_capacity1,
      'search_capacity2' => $search_capacity2,
    ]);
  }


  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    // $venues = new Venue;
    $equipments = Equipment::all();
    $s_equipments = [];
    $i_equipments = [];
    foreach ($equipments as $equipment) {
      $s_equipments[] = $equipment->item;
      $i_equipments[] = $equipment->id;
    }

    $services = Service::all();
    $s_services = [];
    $i_services = [];
    foreach ($services as $service) {
      $s_services[] = $service->item;
      $i_services[] = $service->id;
    }

    return view('admin.venues.create', [
      // 'venues' => $venues,
      'equipments' => $equipments,
      'services' => $services,
      's_equipments' => $s_equipments,
      'i_equipments' => $i_equipments,
      's_services' => $s_services,
      'i_services' => $i_services,
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
    $this->validate($request, [
      'alliance_flag' => ['required', 'max:191'],
      'name_area' => ['required', 'max:191'],
      'name_bldg' => ['required', 'max:191'],
      'name_venue' => ['required', 'max:191'],
      'size1' => ['required', 'max:191', 'numeric'],
      'size2' => ['required', 'max:191', 'numeric'],
      'capacity' => ['required', 'max:191', 'numeric'],
      'eat_in_flag' => ['required', 'max:191', 'numeric'],
      'post_code' => ['required', 'max:191'],
      'address1' => 'required',
      'address2' => 'required',
      'address3' => 'required',
      'luggage_flag' => ['required', 'max:191', 'numeric'],
      'luggage_post_code' => ['required', 'max:191'],
      'luggage_address1' => 'required',
      'luggage_address2' => 'required',
      'luggage_address3' => 'required',
      'luggage_name' => 'required',
      'luggage_tel' => ['required', 'max:191'],
      'smg_url' => 'required',
      'layout' => 'required',
    ]);

    $venues = new Venue;
    $venues->alliance_flag = $request->alliance_flag;
    $venues->name_area = $request->name_area;
    $venues->name_bldg = $request->name_bldg;
    $venues->name_venue = $request->name_venue;
    $venues->size1 = $request->size1;
    $venues->size2 = $request->size2;
    $venues->capacity = $request->capacity;
    $venues->eat_in_flag = $request->eat_in_flag;
    $venues->post_code = $request->post_code;
    $venues->address1 = $request->address1;
    $venues->address2 = $request->address2;
    $venues->address3 = $request->address3;
    $venues->remark = $request->remark;
    $venues->first_name = $request->first_name;
    $venues->last_name = $request->last_name;
    $venues->first_name_kana = $request->first_name_kana;
    $venues->last_name_kana = $request->last_name_kana;
    $venues->person_tel = $request->person_tel;
    $venues->person_email = $request->person_email;
    $venues->luggage_flag = $request->luggage_flag;
    $venues->luggage_post_code = $request->luggage_post_code;
    $venues->luggage_address1 = $request->luggage_address1;
    $venues->luggage_address2 = $request->luggage_address2;
    $venues->luggage_address3 = $request->luggage_address3;
    $venues->luggage_name = $request->luggage_name;
    $venues->luggage_tel = $request->luggage_tel;
    $venues->cost = $request->cost;
    $venues->mgmt_company = $request->mgmt_company;
    $venues->mgmt_tel = $request->mgmt_tel;
    $venues->mgmt_emer_tel = $request->mgmt_emer_tel;
    $venues->mgmt_first_name = $request->mgmt_first_name;
    $venues->mgmt_last_name = $request->mgmt_last_name;
    $venues->mgmt_person_tel = $request->mgmt_person_tel;
    $venues->mgmt_email = $request->mgmt_email;
    $venues->mgmt_sec_company = $request->mgmt_sec_company;
    $venues->mgmt_sec_tel = $request->mgmt_sec_tel;
    $venues->mgmt_remark = $request->mgmt_remark;
    $venues->smg_url = $request->smg_url;
    $venues->entrance_open_time = $request->entrance_open_time;
    $venues->backyard_open_time = $request->backyard_open_time;
    $venues->layout = $request->layout;
    $venues->save();

    // 備品保存
    $e_selects = $request->equipment_id;
    if (isset($e_selects)) {
      $e_array = [];
      for ($e = 0; $e < count($e_selects); $e++) {
        $e_array[] = $e_selects[$e];
      }
      $venues->save_equipments($e_array);
    }
    // サービス保存
    $s_selects = $request->service_id;
    if (isset($s_selects)) {
      $s_array = [];
      for ($s = 0; $s < count($s_selects); $s++) {
        $s_array[] = $s_selects[$s];
      }
      $venues->save_services($s_array);
    }

    // 会場に紐づく営業日（曜日）のデフォルトを追加
    for ($week_days = 1; $week_days <= 7; $week_days++) {
      $venues->dates()->create([
        'venue_id' => $venues->id,
        'week_day' => $week_days,
        'start' => Carbon::parse('08:00'),
        'finish' => Carbon::parse('23:00'),
      ]);
    }

    return redirect('admin/venues');
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
    // 【備品連携】
    $equipments = $venue->equipments()->get();
    // $r_emptys = [];
    // foreach ($equipments as $equipment) {
    //   $r_emptys[] = $equipment;
    // }
    // サービス連携
    $services = $venue->services()->get();
    // $s_emptys = [];
    // foreach ($services as $service) {
    //   $s_emptys[] = $service;
    // }
    // 営業時間
    $date_venues = $venue->dates()->get();

    // 料金体系：枠
    $frame_prices = $venue->frame_prices()->get();

    // 料金体系：時間
    $time_prices = $venue->time_prices()->get();

    return view('admin.venues.show', [
      'venue' => $venue,
      'equipments' => $equipments,
      'services' => $services,
      'date_venues' => $date_venues,
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
    $m_equipments = Equipment::all();
    $equipments = $venue->equipments()->get();
    $r_emptys = [];
    foreach ($equipments as $equipment) {
      $r_emptys[] = $equipment;
    }

    $m_services = Service::all();
    $services = $venue->services()->get();
    $s_emptys = [];
    foreach ($services as $service) {
      $s_emptys[] = $service;
    }

    return view('admin.venues.edit', [
      'venue' => $venue,
      'r_emptys' => $r_emptys,
      'equipments' => $equipments,
      'm_equipments' => $m_equipments,
      'services' => $services,
      's_emptys' => $s_emptys,
      'm_services' => $m_services,
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
    $this->validate($request, [
      'alliance_flag' => ['required', 'max:191'],
      'name_area' => ['required', 'max:191'],
      'name_bldg' => ['required', 'max:191'],
      'name_venue' => ['required', 'max:191'],
      'size1' => ['required', 'max:191', 'numeric'],
      'size2' => ['required', 'max:191', 'numeric'],
      'capacity' => ['required', 'max:191', 'numeric'],
      'eat_in_flag' => ['required', 'max:191', 'numeric'],
      'post_code' => ['required', 'max:191'],
      'address1' => 'required',
      'address2' => 'required',
      'address3' => 'required',
      'luggage_flag' => ['required', 'max:191', 'numeric'],
      'luggage_post_code' => ['required', 'max:191'],
      'luggage_address1' => 'required',
      'luggage_address2' => 'required',
      'luggage_address3' => 'required',
      'luggage_name' => 'required',
      'luggage_tel' => ['required', 'max:191'],
      'smg_url' => 'required',
      'layout' => 'required',
    ]);


    DB::transaction(function () use ($request, $id) { //トランザクションさせる

      $venue = Venue::find($id);
      $venue->alliance_flag = $request->alliance_flag;
      $venue->name_area = $request->name_area;
      $venue->name_bldg = $request->name_bldg;
      $venue->name_venue = $request->name_venue;
      $venue->size1 = $request->size1;
      $venue->size2 = $request->size2;
      $venue->capacity = $request->capacity;
      $venue->eat_in_flag = $request->eat_in_flag;
      $venue->post_code = $request->post_code;
      $venue->address1 = $request->address1;
      $venue->address2 = $request->address2;
      $venue->address3 = $request->address3;
      $venue->remark = $request->remark;
      $venue->first_name = $request->first_name;
      $venue->last_name = $request->last_name;
      $venue->first_name_kana = $request->first_name_kana;
      $venue->last_name_kana = $request->last_name_kana;
      $venue->person_tel = $request->person_tel;
      $venue->person_email = $request->person_email;
      $venue->luggage_flag = $request->luggage_flag;
      $venue->luggage_post_code = $request->luggage_post_code;
      $venue->luggage_address1 = $request->luggage_address1;
      $venue->luggage_address2 = $request->luggage_address2;
      $venue->luggage_address3 = $request->luggage_address3;
      $venue->luggage_name = $request->luggage_name;
      $venue->luggage_tel = $request->luggage_tel;
      $venue->cost = $request->cost;
      $venue->mgmt_company = $request->mgmt_company;
      $venue->mgmt_tel = $request->mgmt_tel;
      $venue->mgmt_emer_tel = $request->mgmt_emer_tel;
      $venue->mgmt_first_name = $request->mgmt_first_name;
      $venue->mgmt_last_name = $request->mgmt_last_name;
      $venue->mgmt_person_tel = $request->mgmt_person_tel;
      $venue->mgmt_email = $request->mgmt_email;
      $venue->mgmt_sec_company = $request->mgmt_sec_company;
      $venue->mgmt_sec_tel = $request->mgmt_sec_tel;
      $venue->mgmt_remark = $request->mgmt_remark;
      $venue->smg_url = $request->smg_url;
      $venue->entrance_open_time = $request->entrance_open_time;
      $venue->backyard_open_time = $request->backyard_open_time;
      $venue->layout = $request->layout;
      $venue->layout_prepare = $request->layout_prepare;
      $venue->layout_clean = $request->layout_clean;
      $venue->save();

      $e_selects = $request->equipment_id;
      if (is_countable($e_selects)) {
        $e_array = [];
        for ($i = 0; $i < count($e_selects); $i++) {
          $e_array[] = $e_selects[$i];
        }
        $venue->sync_equipments($e_array);
      } else {
        $venue->detach_equipments();
      }

      $s_selects = $request->service_id;
      if (is_countable($s_selects)) {
        $s_array = [];
        for ($i = 0; $i < count($s_selects); $i++) {
          $s_array[] = $s_selects[$i];
        }
        $venue->sync_services($s_array);
      } else {
        $venue->detach_services();
      }
    });

    $request->session()->regenerate();
    return redirect('admin/venues');
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
    $venue = Venue::find($id);
    $venue->delete();

    return redirect('admin/venues');
  }
}
