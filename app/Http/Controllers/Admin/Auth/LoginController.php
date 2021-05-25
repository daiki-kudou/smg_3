<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;


class LoginController extends Controller
{
  use AuthenticatesUsers;

  protected $redirectTo = RouteServiceProvider::ADMIN_HOME;

  public function __construct()
  {
    $this->middleware('guest:admin')->except('logout');
  }

  protected function guard()
  {
    return Auth::guard('admin');
  }

  public function showLoginForm()
  {
    return view('admin.auth.login');
  }

  public function logout(Request $request)
  {
    Auth::guard('admin')->logout();

    return $this->loggedOut($request);
  }

  public function loggedOut(Request $request)
  {
    return redirect(route('admin.login'));
  }


  // オーバーライド
  // ユーザーがログインしていたら管理者にはログインできないように。
  // これは本番UPしてから実装
  // public function login(Request $request)
  // {
  //   $user_auth = Auth::guard('user')->check();
  //   if ($user_auth) {
  //     return $this->sendFailedLoginResponse($request);
  //   }

  //   $this->validateLogin($request);

  //   if (method_exists($this, 'hasTooManyLoginAttempts') && $this->hasTooManyLoginAttempts($request)) {
  //     $this->fireLockoutEvent($request);
  //     return $this->sendLockoutResponse($request);
  //   }

  //   if ($this->attemptLogin($request)) {
  //     return $this->sendLoginResponse($request);
  //   }

  //   $this->incrementLoginAttempts($request);

  //   return $this->sendFailedLoginResponse($request);
  // }

  // オーバーライド
  // ユーザーがログインしていたら管理者にはログインできないように。
  // これは本番UPしてから実装

  // protected function sendFailedLoginResponse(Request $request)
  // {
  //   throw ValidationException::withMessages([
  //     $this->username() => ["ユーザー権限でログイン中は管理者権限でログインできません。ユーザー権限からログアウトしてください"],
  //   ]);
  // }
}
