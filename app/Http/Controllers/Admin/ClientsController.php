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
    $search_freeword = $request->freeword;
    $search_id = $request->id;
    $search_status = $request->status;
    $search_company = $request->company;
    $search_attr = $request->attr;
    $search_person_name = $request->person_name;
    $search_mobile = $request->mobile;
    $search_tel = $request->tel;
    $search_email = $request->email;
    $search_attention = $request->attention;

    $user = new User;
    $querys = $user->searchs(
      $search_freeword,
      $search_id,
      $search_status,
      $search_company,
      $search_attr,
      $search_person_name,
      $search_mobile,
      $search_tel,
      $search_email,
      $search_attention,
    );

    return view('admin.clients.index', [
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
    $user->admin_or_user = 1; //1なら管理者　2ならユーザー
    $user->save();

    return redirect('admin/clients');
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    $user = User::find($id);
    return view('admin.clients.show', [
      'user' => $user,
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
  public function destroy($id)
  {
    $venue = User::find($id);
    $venue->delete();

    return redirect('admin/clients');
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
