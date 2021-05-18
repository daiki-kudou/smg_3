<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Reservation;
use App\Models\Bill;
use Carbon\Carbon;


class SalesController extends Controller
{
  public function index(Request $request)
  {
    $today = date('Y-m-d', strtotime(Carbon::today()));
    $after_today = Reservation::with(
      ['bills.cxl', 'user', 'agent', 'cxls', 'enduser', 'venue']
    )->whereDate('reserve_date', '>=', $today)->get()->sortBy('reserve_date');

    $before_today = Reservation::with(
      ['bills.cxl', 'user', 'agent', 'cxls', 'enduser', 'venue']
    )->whereDate('reserve_date', '<', $today)->get()->sortBy('reserve_date');

    $reservations = $after_today->concat($before_today);

    return view('admin.sales.index', compact('reservations'));
  }

  public function download_csv(Request $request)
  {
    return response()->streamDownload(
      function () {
        $stream = fopen('php://output', 'w'); // 出力バッファをopen
        stream_filter_prepend($stream, 'convert.iconv.utf-8/cp932//TRANSLIT'); // 文字コードをShift-JISに変換
        fputcsv($stream, [ // ヘッダー
          'id',
          'reserve_date',
          'reservation_id',
        ]);
        // データ
        // foreach (Reservation::chunk() as $reservation) {
        //   fputcsv($stream, [
        //     $reservation->id,
        //     $reservation->reserve_date,
        //   ]);
        // }
        Bill::with('reservation')->chunk(
          1000,
          function ($bills) use ($stream) {
            foreach ($bills as $bill) {
              fputcsv($stream, [
                $bill->id,
                $bill->reservation->reserve_date,
                $bill->reservation->id,
              ]);
            }
          }
        );
        fclose($stream);
      },
      'reservations.csv',
      ['Content-Type' => 'application/octet-stream',]
    );
  }
}
