<?php

namespace App\Http\Controllers\Admin\Ajax;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\User;

class AjaxClientsController extends Controller
{
  public function get_clients(Request $request)
  {
    $user = User::find($request->user_id);
    $person = $user->first_name . $user->last_name;
    $email = $user->email;
    $mobile = $user->mobile;
    $tel = $user->tel;
    $condition = $user->condition;
    $attention = $user->attention;

    return [$person, $email, $mobile, $tel, $condition, $attention, $request->user_id];
  }
}
