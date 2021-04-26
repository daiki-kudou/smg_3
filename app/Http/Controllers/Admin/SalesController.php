<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Reservation;


class SalesController extends Controller
{
  public function download_csv(Request $request)
  {
    return response()->streamDownload(
      function () {
        // 出力バッファをopen
        $stream = fopen('php://output', 'w');
        // 文字コードをShift-JISに変換
        stream_filter_prepend($stream, 'convert.iconv.utf-8/cp932//TRANSLIT');
        // ヘッダー
        fputcsv($stream, [
          'id',
          'reserve_date',
        ]);
        // データ
        foreach (Reservation::cursor() as $reservation) {
          fputcsv($stream, [
            $reservation->id,
            $reservation->reserve_date,
          ]);
        }
        fclose($stream);
      },
      'reservations.csv',
      [
        'Content-Type' => 'application/octet-stream',
      ]
    );
  }
}
