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
  public function index()
  {

    $querys = Service::orderBy('id', 'desc')->paginate(30);
    return view('admin.services.index', compact("querys"));
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
  public function edit($id, Request $request)
  {
    $service = Service::find($id);
    $request->session()->put('current_page', $request->current_p);

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


    $current_page = $request->session()->pull('current_page');
    $request->session()->regenerate();
    return redirect('admin/services/?page=' . $current_page);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id, Request $request)
  {
    $service = Service::find($id);

    DB::transaction(function () use ($service) {
      $service->delete();
    });

    if ($request->page == 1) {
      return redirect('admin/services');
    } else {
      return redirect(url("admin/services?page=" . $request->page));
    }
  }
}
