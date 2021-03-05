<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Service;

use Illuminate\Support\Facades\DB; //トランザクション用


class ServicesController extends Controller
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
    $search_item = $request->item;
    $service = new Service;
    $querys = $service->searchs(
      $search_freeword,
      $search_id,
      $search_item
    );

    return view('admin.services.index', [
      'querys' => $querys,
    ]);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    return view('admin.services.create');
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
    ]);

    DB::transaction(function () use ($request) { //トランザクションさせる
      $services = new Service;
      $services->item = $request->item;
      $services->price = $request->price;
      $services->remark = $request->remark;
      $services->save();
    });
    $request->session()->regenerate();
    return redirect('admin/services');
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    $service = Service::find($id);
    return view('admin.services.show', [
      'service' => $service,
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
    $service = Service::find($id);
    return view('admin.services.edit', [
      'service' => $service,
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
    ]);

    DB::transaction(function () use ($request, $id) { //トランザクションさせる
      $service = Service::find($id);
      $service->item = $request->item;
      $service->price = $request->price;
      $service->remark = $request->remark;
      $service->save();
    });
    $request->session()->regenerate();

    return redirect('admin/services');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $service = Service::find($id);
    $service->delete();
    return redirect('admin/services');
  }
}
