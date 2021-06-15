<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Venue;

class FakeTestController extends Controller
{
  public function index()
  {
    $this->calc(1, 1, "01:00:00", "04:00:00", 0);
    $this->calc(1, 1, "12:00:00", "23:30:00", 0);
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
    if ($result === 0) {
      echo "";
      echo "会場ID: " . $venueId . ' / ' . '料金体系' . $priceSystem . ' / ' . '入室: ' . $enter . ' / ' . '退室 :' . $leave . ' / ' . '期待する結果: ' . $expectValue . '<br>';
      echo "↓　システム算出結果<br><div style='background:black; color:#56DB3A;font-weight:bold;'>";
      dump(0);
      echo "</div><br>";
    } elseif ($result[0] == $expectValue) {
      echo "";
      echo "会場ID: " . $venueId . ' / ' . '料金体系' . $priceSystem . ' / ' . '入室: ' . $enter . ' / ' . '退室 :' . $leave . ' / ' . '期待する結果: ' . $expectValue . '<br>';
      echo "↓　システム算出結果<br><div style='background:black; color:#56DB3A;font-weight:bold;'>";
      echo "会場料金: " . ($result[0] - $result[1]) . '<br>';
      echo "延長料金: " . $result[1] . '<br>';
      echo "合計料金: " . $result[0] . '<br>';
      echo "</div><br>";
    } else {
      dd("失敗");
    }
  }
}
