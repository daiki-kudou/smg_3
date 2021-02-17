<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\MultipleReserve;

class MultiplesController extends Controller
{
  public function index()
  {
    // $multiples = MultipleReserve::all();
    $multiples = MultipleReserve::withCount('pre_reservations')->get();


    return view('admin.multiples.index', [
      'multiples' => $multiples,
    ]);
  }
}
