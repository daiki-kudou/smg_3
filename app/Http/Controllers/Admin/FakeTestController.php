<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Venue;

class FakeTestController extends Controller
{
  public function index()
  {
    $this->calc(1, 1, "08:00:00", "12:00:00", 25000);
    $this->calc(1, 1, "08:00:00", "21:30:00", 54500);
    $this->calc(1, 1, "08:00:00", "15:30:00", 46000);
    $this->calc(1, 1, "12:00:00", "16:00:00", 35000);
    $this->calc(1, 1, "12:00:00", "20:30:00", 41000);
    $this->calc(1, 1, "12:00:00", "23:00:00", 51000);
    $this->calc(1, 1, "16:00:00", "19:00:00", 36000);
    $this->calc(1, 1, "16:00:00", "22:30:00", 43500);
    $this->calc(1, 1, "11:30:00", "17:00:00", 36000);
    $this->calc(1, 1, "18:00:00", "21:00:00", 15000);
    $this->calc(1, 1, "17:00:00", "23:00:00", 15000);
    $this->calc(1, 1, "17:30:00", "23:00:00", 15000);
    $this->calc(1, 1, "12:30:00", "23:00:00", 48500);
    $this->calc(1, 1, "12:30:00", "17:00:00", 32500);
  }

  public function calc($venueId, $priceSystem, $enter, $leave, $expectValue)
  {
    $venue = Venue::with('frame_prices')->find($venueId);
    $result = $venue->calculate_price($priceSystem, $enter, $leave);
    $expect = $expectValue;
    if ($result[0] == $expect) {
      dump($result[0]);
    } else {
      dump("失敗");
    }
  }
}
