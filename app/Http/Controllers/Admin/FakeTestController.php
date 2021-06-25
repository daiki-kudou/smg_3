<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Venue;

use App\Services\Admin\Venue\CalculateService;

class FakeTestController extends Controller
{
  public function index()
  {
    $test = new CalculateService(1, "12:00:00", "22:00:00");
    dump($test->calc());
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
      echo "会場ID: " . $venueId . ' / ' . '料金体系' . $priceSystem . ' / ' . '入室: ' . $enter . ' / ' . '退室 :' . $leave . ' / ' . '期待する結果: ' . $expectValue . '<br>';
      echo "↓　システム算出結果<br><div style='background:black; color:red;font-weight:bold;'>";
      echo "会場料金: " . ($result[0] - $result[1]) . '<br>';
      echo "延長料金: " . $result[1] . '<br>';
      echo "合計料金: " . $result[0] . '<br>';
      echo "</div><br>";
      dump('期待する結果と異なる');

      // echo "";
      // echo "会場ID: " . $venueId . ' / ' . '料金体系' . $priceSystem . ' / ' . '入室: ' . $enter . ' / ' . '退室 :' . $leave . ' / ' . '期待する結果: ' . $expectValue . '<br>';
      // echo "↓　システム算出結果<br><div style='background:black; color:#56DB3A;font-weight:bold;'>";
      // echo "会場料金: " . ($result[0] - $result[1]) . '<br>';
      // echo "延長料金: " . $result[1] . '<br>';
      // echo "合計料金: " . $result[0] . '<br>';
      // echo "</div><br>";
    }
  }
}
