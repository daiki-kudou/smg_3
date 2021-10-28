<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;

class AdminsController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
   */
  public function index()
  {
    $auth = auth('admin')->user()->toArray();
    $admins = Admin::orderBy("id")->get()->toArray();
    return view('admin.administer.index', compact('admins', 'auth'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
   */
  public function create()
  {
    return view('admin.administer.create');
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
   */
  public function store(Request $request)
  {
    $validatedData = $request->validate([
      'name' => 'required',
      'email' => 'required|email|unique:admins,email',
      'password' => 'required',
    ]);

    $admin = new Admin;
    $admin->create([
      'name' => $request->name,
      'email' => $request->email,
      'password' => Hash::make($request->password),
    ]);

    return redirect(route('admin.administer.index'));
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
   */
  public function edit($id)
  {
    $auth = auth('admin')->user()->toArray();
    if ($auth['id'] != $id) {
      return redirect(route('admin.administer.index'));
    }
    return view('admin.administer.edit', compact('auth'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
   */
  public function update(Request $request, $id)
  {
    $auth = auth('admin')->user()->toArray();
    if ($auth['id'] != $id) {
      return redirect(route('admin.administer.index'));
    }
    $admin = Admin::find($id);
    $admin->update(
      ['name' => $request->name, 'email' => $request->email]
    );
    return redirect(route('admin.administer.index'));
  }
}
