<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Equipment;

use Illuminate\Support\Facades\DB;

use App\Traits\PaginatorTrait;
use App\Traits\SortTrait;


class EquipmentsController extends Controller
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
    $m_equipments = Equipment::get()->sortByDesc("id");
    $sort = $this->customSort($m_equipments, $request->all()) ?? $m_equipments;
    $equipments = $this->customPaginate($sort, 30, $request);

    return view('admin.equipments.index', compact("equipments", "request"));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    return view('admin.equipments.create');
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
      'item' => ['required', 'max:191'],
      'price' => ['required', 'max:191'],
      'stock' => ['required', 'max:191'],
    ]);

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
  public function edit($id, Request $request)
  {
    $eqipment = Equipment::find($id);
    $request->session()->put('current_page', $request->current_p);

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
    $this->validate($request, [
      'item' => ['required', 'max:191'],
      'price' => ['required', 'max:191'],
      'stock' => ['required', 'max:191'],
    ]);

    DB::transaction(function () use ($request, $id) {
      $eqipment = Equipment::find($id);
      $eqipment->item = $request->item;
      $eqipment->price = $request->price;
      $eqipment->stock = $request->stock;
      $eqipment->remark = $request->remark;
      $eqipment->save();
    });


    $current_page = $request->session()->pull('current_page');
    // 複数タブ生成時、postする際tokenの不一致がおこるためregenerateはしない
    // $request->session()->regenerate();

    return redirect('admin/equipments/?page=' . $current_page);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id, Request $request)
  {
    $eqipment = Equipment::find($id);
    DB::transaction(function () use ($eqipment) {
      $eqipment->delete();
    });

    if ($request->page == 1) {
      return redirect('admin/equipments');
    } else {
      return redirect(url("admin/equipments?page=" . $request->page));
    }
  }
}
