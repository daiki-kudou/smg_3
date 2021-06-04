<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Venue;
use App\Models\Date;


class DatesController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $venues = Venue::orderBy("id", "desc")->get();

    return view('admin.dates.index', [
      'venues' => $venues,
    ]);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create(Request $request)
  {
    $venue_id = $request->id;
    $venue = Venue::find($venue_id);
    $date_venues = $venue->dates()->get();
    $weekday_id = $request->weekday_id;
    return view('admin.dates.create', [
      'venue_id' => $venue_id,
      'weekday_id' => $weekday_id,
      'date_venues' => $date_venues,
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
    $venue_id = $request->venue_id;
    $weekday_id = $request->weekday_id;
    $start = $request->start;
    $finish = $request->finish;
    Date::dateUpdates($venue_id, $weekday_id, $start, $finish);
    return redirect('admin/dates/' . $request->venue_id);
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {

    // $venue_id = Venue::find($id);
    $venues = Venue::find($id);

    // $date_venues = $venue_id->dates()->get();
    $date_venues = $venues->dates()->get();

    return view('admin.dates.show', [
      // 'venue_id' => $venue_id,
      'venues' => $venues,
      'date_venues' => $date_venues,
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
