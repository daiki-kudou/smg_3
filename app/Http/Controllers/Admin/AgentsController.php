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
    $agents = Agent::orderBy('id', 'desc')->paginate(30);
    // 画面表示
    return view('admin.agents.index', compact("agents"));
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

    $agent = new Agent;
    $agent->StoreAgent($request);

    $request->session()->regenerate();
    return redirect('admin/agents');
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
