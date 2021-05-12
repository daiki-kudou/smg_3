<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;


class ChangeLogsController extends Controller
{
  public function update(Request $request)
  {
    DB::transaction(function () use ($request) {
      $reservation = Reservation::with('change_log')->find($request->reservation_id);
      $reservation->change_log()->updateOrCreate(
        ['reservation_id' => $reservation->id],
        ['content' => $request->remark_textarea]
      );
    });
    return redirect(url('admin/reservations/' . $request->reservation_id));
  }
}
