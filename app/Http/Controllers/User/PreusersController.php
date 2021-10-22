<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// メール送信用
use App\Mail\AdminReqLeg;
use App\Mail\UserReqLeg;
use App\Models\Preuser;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
// 日付
use Illuminate\Database\Eloquent\Model;
// Str
use Illuminate\Support\Str;
use App\Service\SendSMGEmail;
use DB;
use Session;





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

    $users = User::where('email', $request->email)->first();
    $preusers = Preuser::where('email', $request->email)->where('expiration_datetime', ">", now())->first();

    try {
      if ($users) {
        throw new \Exception("既に存在するメールアドレスです。お持ちのメールアドレスでログインを試みるか別のメールアドレスで再度お試しください");
      } elseif ($preusers) {
        throw new \Exception("既に認証用メールを送付しています。届いていない場合、迷惑メールフォルダをご確認いただくは別のメールアドレスをお試しください");
      }
    } catch (\Exception $e) {
      return back()->withInput()->withErrors($e->getMessage());
    }

    DB::beginTransaction();
    try {
      $preuser = new Preuser;
      $result = $preuser->create([
        'email' => $request->email,
        'token' => Str::random(250),
        'expiration_datetime' => now()->addMinutes(60),
      ]);
      $link = url('/') . "/user/preusers/" . $result->id . "/" . $result->token . "/" . $result->email;

      $SendSMGEmail = new SendSMGEmail(['result' => $result, 'link' => $link], "", "");
      $SendSMGEmail->AuthSend("ユーザー会員登録用、認証メール送信");

      DB::commit();
    } catch (\Exception $e) {
      DB::rollback();
      return back()->withInput()->withErrors($e->getMessage());
    }
    $request->session()->regenerate();
    return redirect(route('user.preusers.complete', ['email' => $request->email]));
  }


  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id, $token, $email)
  {
    try {
      $preuser_check = Preuser::where('id', $id)->where('token', $token)->exists();
      if (!$preuser_check) {
        throw new \Exception("認証有効期限切れ");
      }
    } catch (\Exception $e) {
      return abort(403);
    }

    $preuser_check = Preuser::where('id', $id)->where('token', $token)->exists();
    $time_check = Preuser::find($id)->expiration_datetime;
    $preuser = Preuser::find($id);
    if (now() < $time_check) {
      if ($preuser_check) {
        $preuser->status = 1;
        $preuser->save();
        session()->regenerate();
        return redirect(route('user.register', ['id' => $id, 'token' => $token, 'status' => 1, 'email' => $email]));
      } else {
        // トークンなど合致しなければルートへ
        session()->regenerate();
        return redirect(url('user/preusers'));
      };
    } else {
      // 時間が経過していたらルートへ
      session()->regenerate();
      return redirect(url('user/preusers'));
    }
  }
}
