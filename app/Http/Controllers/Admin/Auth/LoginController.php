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


  public function login(Request $request)
  {
    $this->validateLogin($request);
    $request->session()->regenerate();

    // If the class is using the ThrottlesLogins trait, we can automatically throttle
    // the login attempts for this application. We'll key this by the username and
    // the IP address of the client making these requests into this application.
    if (
      method_exists($this, 'hasTooManyLoginAttempts') &&
      $this->hasTooManyLoginAttempts($request)
    ) {
      $this->fireLockoutEvent($request);

      return $this->sendLockoutResponse($request);
    }

    if ($this->attemptLogin($request)) {
      return $this->sendLoginResponse($request);
    }

    // If the login attempt was unsuccessful we will increment the number of attempts
    // to login and redirect the user back to the login form. Of course, when this
    // user surpasses their maximum number of attempts they will get locked out.
    $this->incrementLoginAttempts($request);

    return $this->sendFailedLoginResponse($request);
  }

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
