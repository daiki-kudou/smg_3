<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Carbon\Carbon;

use App\Models\Venue;

class HomeController extends Controller
{
  public function index()
  {
    $venues = Venue::all();
    return view('home.index', compact('venues'));
  }

  public function slct_date(Request $request)
  {
    var_dump($request->all());
    $venues = Venue::all();
    return view('home.slct_date', compact('request', 'venues'));
  }

  public function slct_venue(Request $request)
  {
    var_dump($request->all());
    $venues = Venue::all();
    return view('home.slct_venue', compact('request', 'venues'));
  }
}
