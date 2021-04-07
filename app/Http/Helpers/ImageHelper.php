<?php

namespace App\Http\Helpers;

use App\Models\Reservation;

class ImageHelper
{
  public static function show($reservation_id)
  {
    $new = "<svg xmlns='http://www.w3.org/2000/svg' width='92' height='92' viewBox='0 0 92 92' class='svg'>" .
      "<g id='グループ_615' data-name='グループ 615' transform='translate(-7126 2705)'>" .
      "<rect id='長方形_344' data-name='長方形 344' width='92' height='92' rx='10' transform='translate(7126 -2705)' fill='#1eb302'/>" .
      "<text id='初' transform='translate(7144 -2638)' fill='#f9fafc' font-size='56' font-family='YuGo-Medium, YuGothic' font-weight='500'><tspan x='0' y='0'>初</tspan></text>" .
      "</g>" .
      "</svg>";

    $service = "<svg xmlns='http://www.w3.org/2000/svg' width='92' height='92' viewBox='0 0 92 92' class='svg'>" .
      "<g id='グループ_616' data-name='グループ 616' transform='translate(-7126 2597)'>" .
      "<rect id='長方形_345' data-name='長方形 345' width='92' height='92' rx='10' transform='translate(7126 -2597)' fill='#f47100'/>" .
      "<text id='サ' transform='translate(7144 -2530)' fill='#f9fafc' font-size='56' font-family='YuGo-Medium, YuGothic' font-weight='500'><tspan x='0' y='0'>サ</tspan></text>" .
      "</g>" .
      "</svg>";

    $catering = "<svg xmlns='http://www.w3.org/2000/svg' width='92' height='92' viewBox='0 0 92 92' class='svg'>" .
      "<g id='グループ_617' data-name='グループ 617' transform='translate(-7126 2489)'>" .
      "<rect id='長方形_346' data-name='長方形 346' width='92' height='92' rx='10' transform='translate(7126 -2489)' fill='#980d52'/>" .
      "<text id='ケ' transform='translate(7144 -2422)' fill='#f9fafc' font-size='56' font-family='YuGo-Medium, YuGothic' font-weight='500'><tspan x='0' y='0'>ケ</tspan></text>" .
      "</g>" .
      "</svg>";

    $equipment =
      "<svg xmlns='http://www.w3.org/2000/svg' width='92' height='92' viewBox='0 0 92 92' class='svg'>" .
      "<g id='グループ_618' data-name='グループ 618' transform='translate(-7126 2381)'>" .
      "<rect id='長方形_347' data-name='長方形 347' width='92' height='92' rx='10' transform='translate(7126 -2381)' fill='#124d81'/>" .
      "<text id='有' transform='translate(7144 -2314)' fill='#f9fafc' font-size='56' font-family='YuGo-Medium, YuGothic' font-weight='500'><tspan x='0' y='0'>有</tspan></text>" .
      "</g>" .
      "</svg>";

    $layout =
      "<svg xmlns='http://www.w3.org/2000/svg' width='92' height='92' viewBox='0 0 92 92' class='svg'>" .
      "<g id='グループ_619' data-name='グループ 619' transform='translate(-7126 2273)'>" .
      "<rect id='長方形_348' data-name='長方形 348' width='92' height='92' rx='10' transform='translate(7126 -2273)' fill='#b41b00'/>" .
      "<text id='レ' transform='translate(7144 -2206)' fill='#f9fafc' font-size='56' font-family='YuGo-Medium, YuGothic' font-weight='500'><tspan x='0' y='0'>レ</tspan></text>" .
      "</g>" .
      "</svg>";

    $allReservation = Reservation::all();
    $reservation = $allReservation->find($reservation_id);
    $breakdown = $reservation->breakdowns()->get();
    $icon = [];
    if ($breakdown->where('unit_type', 2)->count() > 0) $icon[] = $equipment;
    if ($breakdown->where('unit_type', 3)->count() > 0) $icon[] = $service;
    if ($breakdown->where('unit_type', 4)->count() > 0) $icon[] = $layout;
    if ($allReservation->where('user_id', $reservation->user_id)->count() == 1) {
      $icon[] = $new;
    }

    return $icon;
  }
}
