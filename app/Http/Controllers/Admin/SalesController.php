<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Reservation;
use App\Models\Bill;
use App\Models\User;
use App\Models\Agent;
use App\Models\Venue;
use App\Models\Enduser;
use App\Models\Cxl;
use Carbon\Carbon;
use App\Traits\PaginatorTrait;
use App\Traits\SearchTrait;
use App\Http\Helpers\ReservationHelper;
use App\Http\Requests\SalesRequest;

class SalesController extends Controller
{
  use PaginatorTrait;
  use SearchTrait;
  public function index(SalesRequest $request)
  {

    $_reservation = new Reservation;
    $counter = $_reservation
      ->SearchReservation($request->all())
      ->get()
      ->count();

    $total_amount = $_reservation->SearchReservation($request->all())->get()->pluck('sogaku')->sum();

    if ((int)$request->csv === 1) {
      return $this->download_csv($request);
    }
    $agents = Agent::get()->sortByDesc('id')->pluck("name", "id")->toArray();
    $venues = Venue::get()->sortByDesc('id')->pluck("id")->toArray();
    $data = $request->all();
    return view('admin.sales.index', compact('data', 'agents', 'venues', 'counter', 'total_amount'));
  }

  public function download_csv(Request $request)
  {
    // Total records 
    $_bill = new Bill;
    $result = $_bill
      ->CSVSearch($request->all())
      ->orderByRaw("予約中かキャンセルか,今日以降かどうか,今日以降日付,今日未満日付 desc")
      ->get();
    // // ※参照　https://blog.hrendoh.com/laravel-6-download-csv-with-streamdownload/
    
    $header = [
      '予約一括ID',
      '予約ID',
      '利用日',
      '利用会場',
      '顧客ID',
      '会社・団体名',
      '担当者氏名',
      '仲介会社',
      'エンドユーザー',
      '総額',
      '売上',
      '売上原価',
      '粗利',
      '売上区分',
      '予約状況',
      '支払日',
      '入金状況',
      '振込名',
      '顧客属性',
      '支払期日',
      '運営'
    ];

    return response()->streamDownload(
      function () use ($result, $header) {
        $stream = fopen('php://output', 'w'); // 出力バッファをopen
        stream_filter_prepend($stream, 'convert.iconv.utf-8/cp932//TRANSLIT'); // 文字コードをShift-JISに変換
        fputcsv($stream, $header);
        foreach ($result->chunk(1000) as $chunk) {
          foreach ($chunk as $key => $r) {
            fputcsv($stream, [
              '="' . ($r->multiple_reserve_id) . '"',
              '="' . ($r->reservation_id) . '"',
              $r->reserve_date,
              $r->venue_name,
              '="' . $r->user_id . '"',
              $r->company_name,
              $r->user_name,
              $r->agent_name,
              $r->enduser_company,
              $r->sogaku,
              $r->master_total,
              $r->cost,
              $r->profit,
              $r->bill_category,
              $r->reservation_status,
              $r->pay_day,
              $r->paid,
              $r->pay_person,
              $r->attr,
              $r->payment_limit,
              $r->alliance_flag,
            ]);
            // 打ち消し用
            if (count($chunk) !== ($key + 1)) {
              if ($chunk[$key + 1]->original_reservation_id !== $r->original_reservation_id) {
                if ($r->cxl_id > 0) {
                  fputcsv($stream, [
                    '="' . ($r->multiple_reserve_id) . '"',
                    '="' . ($r->reservation_id) . '"',
                    $r->reserve_date,
                    $r->venue_name,
                    '="' . $r->user_id . '"',
                    $r->company_name,
                    $r->user_name,
                    $r->agent_name,
                    $r->enduser_company,
                    $r->sogaku,
                    number_format((int)str_replace(',', '', $r->sogaku) * -1),
                    number_format((int)str_replace(',', '', $r->cost) * -1),
                    number_format((int)str_replace(',', '', $r->profit) * -1),
                    "打ち消し",
                    "-",
                    "-",
                    "-",
                    "-",
                    "-",
                    "-",
                    $r->alliance_flag,
                  ]);
                  // 実際のキャンセル料
                  fputcsv($stream, [
                    '="' . ($r->multiple_reserve_id) . '"',
                    '="' . ($r->reservation_id) . '"',
                    $r->reserve_date,
                    $r->venue_name,
                    '="' . $r->user_id . '"',
                    $r->company_name,
                    $r->user_name,
                    $r->agent_name,
                    $r->enduser_company,
                    $r->sogaku,
                    $r->cxl_master_total,
                    $r->cost,
                    $r->profit,
                    "キャンセル料",
                    $r->cxl_status,
                    $r->cxl_pay_day,
                    $r->cxl_paid,
                    $r->cxl_pay_person,
                    $r->attr,
                    $r->payment_limit,
                    $r->alliance_flag,
                  ]);
                }
              }
            }
            // 打ち消し用（最後のループ）
            if (count($chunk) === ($key + 1)) {
              if ($r->cxl_id > 0) {
                fputcsv($stream, [
                  '="' . ($r->multiple_reserve_id) . '"',
                  '="' . ($r->reservation_id) . '"',
                  $r->reserve_date,
                  $r->venue_name,
                  '="' . $r->user_id . '"',
                  $r->company_name,
                  $r->user_name,
                  $r->agent_name,
                  $r->enduser_company,
                  $r->sogaku,
                  number_format((int)str_replace(',', '', $r->sogaku) * -1),
                  number_format((int)str_replace(',', '', $r->cost) * -1),
                  number_format((int)str_replace(',', '', $r->profit) * -1),
                  "打ち消し",
                  "-",
                  "-",
                  "-",
                  "-",
                  "-",
                  "-",
                  $r->alliance_flag,
                ]);
                // 実際のキャンセル料
                fputcsv($stream, [
                  '="' . ($r->multiple_reserve_id) . '"',
                  '="' . ($r->reservation_id) . '"',
                  $r->reserve_date,
                  $r->venue_name,
                  '="' . $r->user_id . '"',
                  $r->company_name,
                  $r->user_name,
                  $r->agent_name,
                  $r->enduser_company,
                  $r->sogaku,
                  $r->cxl_master_total,
                  $r->cost,
                  $r->profit,
                  "キャンセル料",
                  $r->cxl_status,
                  $r->cxl_pay_day,
                  $r->cxl_paid,
                  $r->cxl_pay_person,
                  $r->attr,
                  $r->payment_limit,
                  $r->alliance_flag,
                ]);
              }
            }
          }
        }
        fclose($stream);
      },
      'reservations.csv',
      ['Content-Type' => 'application/octet-stream',]
    );
  }

  public function forCsv($merge)
  {
    $array = [];
    foreach ($merge as $key => $res) {
      foreach ($res->bills as $key => $bil) {
        $array[] = $bil->id;
      }
    }
    return $array;
  }
}
