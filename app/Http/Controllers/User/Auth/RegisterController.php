<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\AdminFinLeg;
use App\Mail\UserFinLeg;
use App\Service\SendSMGEmail;
use App\Models\Preuser;
use DB;



class RegisterController extends Controller
{
  use RegistersUsers;

  protected $redirectTo = RouteServiceProvider::HOME;

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('guest:user');
  }

  protected function guard()
  {
    return Auth::guard('user');
  }

  public function showRegistrationForm(Request $request)
  {
    $session = $request->session()->pull('request');
    if (empty($session['back'])) {
      $session = [];
    }
    return view('user.auth.register', compact('request', 'session'));
  }

  public function checkRegistrationForm(Request $request)
  {
    // dd($request->all());
    $validator = Validator::make($request->all(), [
      'email' => 'required|string|email|max:255|unique:users,email,NULL,id,deleted_at,NULL',
      'company' => 'required|max:255',
      'first_name' => 'max:20|regex:/^[^A-Za-z0-9]+$/u|required',
      'last_name' => 'max:20|regex:/^[^A-Za-z0-9]+$/u|required',
      'first_name_kana' => 'max:20|regex:/^[ァ-ヶ 　]+$/u|required',
      'last_name_kana' => 'max:20|regex:/^[ァ-ヶ 　]+$/u|required',
      'post_code' => '',
      'tel' => 'nullable|required_without:mobile',
      'mobile'   => 'nullable|required_without:tel',
      'password'   => 'required|between:min:6,20|alpha_num|confirmed',
      'password_confirmation'   => 'required',
      'q1'   => 'required',
    ]);

    if ($validator->fails()) {
      return back()
        ->withErrors($validator)
        ->withInput();
    }

    return view('user.auth.register_check', compact('request'));
  }


  public function register(Request $request)
  {
    $request->session()->put('request', $request->all());

    if ($request->back) {
      return redirect(route(
        'user.preusers.show',
        [
          'id' => $request->id,
          'token' => $request->token,
          'email' => $request->email,
        ]
      ))->withInput();
    }

    DB::beginTransaction();
    try {
      $data = $request->all();
      $user = User::create([
        'first_name'     => $data['first_name'],
        'last_name'     => $data['last_name'],
        'email'    => $data['email'],
        'password' => Hash::make($data['password']),
        'company' =>  $data['company'],
        'post_code' =>  $data['post_code'],
        'address1' =>  $data['address1'],
        'address2' =>  $data['address2'],
        'address3' =>  $data['address3'],
        'first_name_kana' =>  $data['first_name_kana'],
        'last_name_kana' =>  $data['last_name_kana'],
        'status' => 1,
        'admin_or_user' => 2,
        'mobile' => $data['mobile'],
        'pay_method' => 1,
        'pay_limit' => 1,
      ]);
      $SendSMGEmail = new SendSMGEmail($user, "", "");
      $SendSMGEmail->AuthSend("ユーザー会員登録用成功");
      DB::table('preusers')->where('email', $user->email)->delete();

      DB::commit();
    } catch (\Exception $e) {
      DB::rollback();
      return back()->withInput()->withErrors($e->getMessage());
    }
    $request->session()->regenerate();
    return redirect(url('user/login'))->with('flash_message', '会員登録が完了しました。下記より、ログインしてください。');
  }
}
