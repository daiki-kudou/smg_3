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

use App\Traits\PaginatorTrait;
use App\Traits\SortTrait;



class VenuesController extends Controller
{
  use PaginatorTrait;
  use SortTrait;

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    $m_venues = Venue::get()->sortByDesc("id");
    $sort = $this->customSort($m_venues, $request->except("page")) ?? $m_venues;
    $venues = $this->customPaginate($sort, 30, $request);
    return view('admin.venues.index', compact("venues", "request"));
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
    // $s_equipments = [];
    // $i_equipments = [];
    // foreach ($equipments as $equipment) {
    //   $s_equipments[] = $equipment->item;
    //   $i_equipments[] = $equipment->id;
    // }

    $services = Service::all();
    // $s_services = [];
    // $i_services = [];
    // foreach ($services as $service) {
    //   $s_services[] = $service->item;
    //   $i_services[] = $service->id;
    // }

    return view('admin.venues.create', [
      // 'venues' => $venues,
      'equipments' => $equipments,
      'services' => $services,
      // 's_equipments' => $s_equipments,
      // 'i_equipments' => $i_equipments,
      // 's_services' => $s_services,
      // 'i_services' => $i_services,
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

    $venue = Venue::create([
      'alliance_flag' => $request->alliance_flag,
      'name_area' => $request->name_area,
      'name_bldg' => $request->name_bldg,
      'name_venue' => $request->name_venue,
      'size1' => $request->size1,
      'size2' => $request->size2,
      'capacity' => $request->capacity,
      'eat_in_flag' => $request->eat_in_flag,
      'post_code' => $request->post_code,
      'address1' => $request->address1,
      'address2' => $request->address2,
      'address3' => $request->address3,
      'remark' => $request->remark,
      'first_name' => $request->first_name,
      'last_name' => $request->last_name,
      'first_name_kana' => $request->first_name_kana,
      'last_name_kana' => $request->last_name_kana,
      'person_tel' => $request->person_tel,
      'person_email' => $request->person_email,
      'luggage_flag' => $request->luggage_flag,

      'reserver_company' => $request->reserver_company,
      'reserver_tel' => $request->reserver_tel,
      'reserver_fax' => $request->reserver_fax,
      'reserver_remark' => $request->reserver_remark,

      'luggage_post_code' => $request->luggage_post_code,
      'luggage_address1' => $request->luggage_address1,
      'luggage_address2' => $request->luggage_address2,
      'luggage_address3' => $request->luggage_address3,
      'luggage_name' => $request->luggage_name,
      'luggage_tel' => $request->luggage_tel,
      'cost' => $request->cost,
      'mgmt_company' => $request->mgmt_company,
      'mgmt_tel' => $request->mgmt_tel,
      'mgmt_emer_tel' => $request->mgmt_emer_tel,
      'mgmt_first_name' => $request->mgmt_first_name,
      'mgmt_last_name' => $request->mgmt_last_name,
      'mgmt_person_tel' => $request->mgmt_person_tel,
      'mgmt_email' => $request->mgmt_email,
      'mgmt_sec_company' => $request->mgmt_sec_company,
      'mgmt_sec_tel' => $request->mgmt_sec_tel,
      'mgmt_remark' => $request->mgmt_remark,
      'smg_url' => $request->smg_url,
      'entrance_open_time' => $request->entrance_open_time,
      'backyard_open_time' => $request->backyard_open_time,
      'layout' => $request->layout,
    ]);



    // 備品保存
    $e_selects = $request->equipment_id;
    if (isset($e_selects)) {
      $e_array = [];
      for ($e = 0; $e < count($e_selects); $e++) {
        $e_array[] = $e_selects[$e];
      }
      $venue->save_equipments($e_array);
    }
    // サービス保存
    $s_selects = $request->service_id;
    if (isset($s_selects)) {
      $s_array = [];
      for ($s = 0; $s < count($s_selects); $s++) {
        $s_array[] = $s_selects[$s];
      }
      $venue->save_services($s_array);
    }

    // 会場に紐づく営業日（曜日）のデフォルトを追加
    for ($week_days = 1; $week_days <= 7; $week_days++) {
      $venue->dates()->create([
        'venue_id' => $venue->id,
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
    // サービス連携
    $services = $venue->services()->get();
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
    // $this->validate($request, [
    //   'alliance_flag' => ['required', 'max:191'],
    //   'name_area' => ['required', 'max:191'],
    //   'name_bldg' => ['required', 'max:191'],
    //   'name_venue' => ['required', 'max:191'],
    //   'size1' => ['required', 'max:191', 'numeric'],
    //   'size2' => ['required', 'max:191', 'numeric'],
    //   'capacity' => ['required', 'max:191', 'numeric'],
    //   'eat_in_flag' => ['required', 'max:191', 'numeric'],
    //   'post_code' => ['required', 'max:191'],
    //   'address1' => 'required',
    //   'address2' => 'required',
    //   'address3' => 'required',
    //   'luggage_flag' => ['required', 'max:191', 'numeric'],
    //   'luggage_post_code' => ['required', 'max:191'],
    //   'luggage_address1' => 'required',
    //   'luggage_address2' => 'required',
    //   'luggage_address3' => 'required',
    //   'luggage_name' => 'required',
    //   'luggage_tel' => ['required', 'max:191'],
    //   'smg_url' => 'required',
    //   'layout' => 'required',
    // ]);

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

      $venue->reserver_company = $request->reserver_company;
      $venue->reserver_tel = $request->reserver_tel;
      $venue->reserver_fax = $request->reserver_fax;
      $venue->reserver_remark = $request->reserver_remark;

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

  public function restore($id)
  {
    $venue = Venue::withTrashed()->find($id);
    $venue->restore();

    return redirect('admin/venues');
  }
}
