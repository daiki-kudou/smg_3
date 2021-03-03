<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Agent;


class AgentsController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    // 検索ロジックはモデルに移行
    $search_freeword = $request->freeword;
    $search_id = $request->id;
    $search_name = $request->name;
    $search_tel = $request->person_tel;
    $agent = new Agent;
    $querys = $agent->searchs(
      $search_freeword,
      $search_id,
      $search_name,
      $search_tel,
    );
    // 画面表示
    return view('admin.agents.index', [
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
    return view('admin.agents.create');
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    echo "<pre>";
    var_dump($request->all());
    echo "</pre>";

    $agent = new Agent;
    $agent->StoreAgent($request);
    // $request->validate([
    //   'name' => 'required|max:255',
    //   'post_code' => 'required',
    //   'address1' => 'required',
    //   'address2' => 'required',
    //   'address3' => 'required',
    //   'address_remark' => 'required',
    //   'url' => 'required',
    //   'attr' => 'required',
    //   'remark' => 'required',
    //   'person_firstname' => 'required',
    //   'firstname_kana' => 'required',
    //   'lastname_kana' => 'required',
    //   'person_mobile' => 'required',
    //   'person_tel' => 'required',
    //   'fax' => 'required',
    //   'email' => 'required|email:rfc,dns',
    //   'cost' => 'required',
    // ]);

    // $agent = new Agent;
    // $agent->name = $request->name;
    // $agent->post_code = $request->post_code;
    // $agent->address1 = $request->address1;
    // $agent->address2 = $request->address2;
    // $agent->address3 = $request->address3;
    // $agent->address_remark = $request->address_remark;
    // $agent->url = $request->url;
    // $agent->attr = $request->attr;
    // $agent->remark = $request->remark;
    // $agent->person_firstname = $request->person_firstname;
    // $agent->person_lastname = $request->person_lastname;
    // $agent->firstname_kana = $request->firstname_kana;
    // $agent->lastname_kana = $request->lastname_kana;
    // $agent->person_mobile = $request->person_mobile;
    // $agent->person_tel = $request->person_tel;
    // $agent->fax = $request->fax;
    // $agent->email = $request->email;
    // $agent->cost = $request->cost;

    // $agent->payment_limit = $request->payment_limit;
    // $agent->payment_day = $request->payment_day;
    // $agent->payment_remark = $request->payment_remark;

    // $agent->save();

    // return redirect('admin/agents');
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    $agent = Agent::find($id);
    return view('admin.agents.show', [
      'agent' => $agent,
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
    $agent = Agent::find($id);
    return view('admin.agents.edit', [
      'agent' => $agent,
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
    $agent = Agent::find($id);
    $agent->updateAgent($request);

    return redirect('admin/agents');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $agent = Agent::find($id);
    $agent->delete();

    return redirect('admin/agents');
  }
}
