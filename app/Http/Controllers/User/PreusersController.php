<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// メール送信用
use App\Mail\AdminReqLeg;
use App\Mail\UserReqLeg;
use App\Models\Preuser;
use Illuminate\Support\Facades\Mail;
// 日付
use Illuminate\Database\Eloquent\Model;
// Str
use Illuminate\Support\Str;



class PreusersController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    return view('user.preusers.index', []);
  }

  // メール送信
  public function sendmail(Request $request)
  {
    // 管理者
    $id = $request->id;
    $token = $request->token;
    $email = $request->email;
    $link = url('/') . "/user/preusers/" . $id . "/" . $token . "/" . $email;
    $admin = explode(',', config('app.admin_email'));
    Mail::to($admin)->send(new AdminReqLeg($id, $token, $email, $link));
    Mail::to($email)->send(new UserReqLeg($id, $token, $email, $link));

    return redirect(route('user.preusers.complete', ['email' => $email]));
  }

  public function complete(Request $request)
  {
    $email = $request->email;
    return view('user.preusers.complete', [
      'email' => $email,
    ]);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create(Request $request)
  {
    // ココにバリデーションつける必要あり
    $preuser = new Preuser;
    $preuser->email = $request->email;
    $preuser->token = Str::random(250);
    // 丸岡さん！！！！！！！　ここでメールの有効期限を１分にしてます
    $preuser->expiration_datetime = now()->addMinutes(1);

    $preuser->save();

    return redirect(route('user.preusers.sendmail', [
      'id' => $preuser->id,
      'email' => $preuser->email,
      'token' => $preuser->token,
      'expiration_datetime' => $preuser->expiration_datetime,
    ]));
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    //
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id, $token, $email)
  {
    $preuser_check = Preuser::where('id', $id)->where('token', $token)->exists();
    $time_check = Preuser::find($id)->expiration_datetime;
    $preuser = Preuser::find($id);
    if (now() < $time_check) {
      if ($preuser_check) {
        $preuser->status = 1;
        $preuser->save();
        return redirect(route('user.register', ['id' => $id, 'token' => $token, 'status' => 1, 'email' => $email]));
      } else {
        // トークンなど合致しなければルートへ
        // return redirect('/');
        return redirect(url('user/preusers'));
      };
    } else {
      // 時間が経過していたらルートへ
      // return redirect('/');
      return redirect(url('user/preusers'));
    }
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    //
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
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    //
  }
}
