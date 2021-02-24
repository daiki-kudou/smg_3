<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReservationsController extends Controller
{
  public function create(Request $request)
  {

    return view('user.reservations.create');
  }

  public function test(Request $request)
  {
    //セッションに保存したい変数を定義する（ここでは商品idと注文個数）
    //飛んできた$requestの中のname属性をそれぞれ指定
    $SessionProductId = $request->test;
    //配列の入れ物を作る（初期化）
    $SessionData = array();

    //作った配列に、compact関数を用いてidと個数の変数をまとめる（”” を使っているが変数の意味）
    $SessionData = compact("SessionProductId");

    //session_dataというキーで、$SessionDataをセッションに登録
    $request->session()->push('session_data', $SessionData);

    // return redirect('cartitem');
    return redirect('user/reservations/test2');
  }

  public function test2(Request $request)
  {
    //セッションに保存していた値を取得し、変数として定義
    $SessionData = $request->session()->get('session_data');
    //セッションデータのなかのそれぞれのデータを抽出
    // $SessionProductId = array_column($SessionData, 'SessionProductId');
    // $SessionProductQuantity = array_column($SessionData, 'SessionProductQuantity');
    // dd($SessionData);
    $request->session()->regenerate();
    return view('user.reservations.test2', compact("SessionData"));
  }
}
