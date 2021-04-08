<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Venue;
use App\Models\User;

class HomeController extends Controller
{

  public function __construct()
  {
    $this->middleware('auth:admin');
  }

  public function index()
  {
    $venues = Venue::all()->count();
    $users = User::all()->count();
    return view('admin.home', [
      'venues' => $venues,
      'users' => $users,
    ]);
  }
}
