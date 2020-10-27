<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;     

use App\Models\Equipment;

class EquipmentsController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {

    // 検索処理はモデルに移行
    $search_freeword = $request->freeword;
    $search_id = $request->id;
    $search_item = $request->item;
    $search_createdat = $request->createdat;

    $equipment = new Equipment;
    $equipments = $equipment->searchs($search_freeword, $search_id, $search_item, $search_createdat);

    return view('admin.equipments.index', [
      'equipments' => $equipments,
    ]);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    // $eqipments = Equipment::query()->orderBy('id', 'desc')->paginate(10);
    return view('admin.equipments.create', [
      // 'eqipments' => $eqipments,
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
    $eqipments = new Equipment;
    $eqipments->item = $request->item;
    $eqipments->price = $request->price;
    $eqipments->stock = $request->stock;
    $eqipments->remark = $request->remark;
    $eqipments->save();

    return redirect('admin/equipments');
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    // $eqipment = Equipment::find($id);
    // return view('admin.equipments.show', [
    //     'eqipment' => $eqipment,
    // ]);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    $eqipment = Equipment::find($id);
    return view('admin.equipments.edit', [
      'eqipment' => $eqipment,
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
    $eqipment = Equipment::find($id);

    $eqipment->item = $request->item;
    $eqipment->price = $request->price;
    $eqipment->stock = $request->stock;
    $eqipment->remark = $request->remark;
    $eqipment->save();

    return redirect('admin/equipments');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $eqipment = Equipment::find($id);
    $eqipment->delete();
    return redirect('admin/equipments');
  }
}
