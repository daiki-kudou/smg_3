<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;



use App\Models\User;


class ClientsController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    $querys = User::orderBy('id', 'desc')->paginate(30);
    return view('admin.clients.index', compact('querys'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    return view('admin.clients.create', []);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $validatedData = $request->validate([
      'email' => 'required|unique:App\Models\User,email',
    ]);


    $user = new User;
    $user->company = $request->company;
    $user->post_code = $request->post_code;
    $user->address1 = $request->address1;
    $user->address2 = $request->address2;
    $user->address3 = $request->address3;
    $user->address_remark = $request->address_remark;
    $user->url = $request->url;
    $user->attr = $request->attr;
    $user->condition = $request->condition;
    $user->first_name = $request->first_name;
    $user->last_name = $request->last_name;
    $user->first_name_kana = $request->first_name_kana;
    $user->last_name_kana = $request->last_name_kana;
    $user->tel = $request->tel;
    $user->mobile = $request->mobile;
    $user->email = $request->email;
    $user->fax = $request->fax;
    $user->pay_method = $request->pay_method;
    $user->pay_limit = $request->pay_limit;
    $user->pay_post_code = $request->pay_post_code;
    $user->pay_address1 = $request->pay_address1;
    $user->pay_address2 = $request->pay_address2;
    $user->pay_address3 = $request->pay_address3;
    $user->pay_remark = $request->pay_remark;
    $user->attention = $request->attention;
    $user->remark = $request->remark;
    // デフォルトでは0の8桁がパスワードとする
    $user->password = Hash::make('00000000');
    // 会員登録時デフォルトではでは会員ステータスを1とする
    $user->status = 1;
    $user->admin_or_user = $request->admin_or_user; //1なら管理者　2ならユーザー
    $user->save();

    return redirect('admin/clients');
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id, Request $request)
  {
    $user = User::find($id);
    $reservations = $user->reservations()->paginate(10);
    return view('admin.clients.show', compact("user", "reservations", 'request'));
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    $user = User::find($id);
    return view('admin.clients.edit', [
      'user' => $user,
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
    $user = User::find($id);
    $user->company = $request->company;
    $user->post_code = $request->post_code;
    $user->address1 = $request->address1;
    $user->address2 = $request->address2;
    $user->address3 = $request->address3;
    $user->address_remark = $request->address_remark;
    $user->url = $request->url;
    $user->attr = $request->attr;
    $user->condition = $request->condition;
    $user->first_name = $request->first_name;
    $user->last_name = $request->last_name;
    $user->first_name_kana = $request->first_name_kana;
    $user->last_name_kana = $request->last_name_kana;
    $user->tel = $request->tel;
    $user->mobile = $request->mobile;
    $user->email = $request->email;
    $user->fax = $request->fax;
    $user->pay_method = $request->pay_method;
    $user->pay_limit = $request->pay_limit;
    $user->pay_post_code = $request->pay_post_code;
    $user->pay_address1 = $request->pay_address1;
    $user->pay_address2 = $request->pay_address2;
    $user->pay_address3 = $request->pay_address3;
    $user->pay_remark = $request->pay_remark;
    $user->attention = $request->attention;
    $user->remark = $request->remark;
    $user->save();

    return redirect('admin/clients');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id, Request $request)
  {
    $user = User::find($id);
    DB::transaction(function () use ($user) {
      $user->delete();
    });


    if ($request->page == 1) {
      return redirect('admin/clients');
    } else {
      return redirect(url("admin/clients?page=" . $request->page));
    }
  }

  /***********************
   * ajax 顧客情報　取得
   **********************
   */
  public function getclients(Request $request)
  {
    $user_id = $request->user_id;
    $user = User::find($user_id);
    $name = $user->first_name . $user->last_name;
    //1. ３営業日前　2. 当月末　3. 翌月末
    return [$user->pay_limit, $name];
  }
}
