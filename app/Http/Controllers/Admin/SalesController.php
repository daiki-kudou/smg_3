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

class SalesController extends Controller
{

  use PaginatorTrait;
  use SearchTrait;

  public function index(Request $request)
  {
    if ((int)$request->csv === 1) {
      return $this->download_csv($request);
    }

    $agents = Agent::get()->sortByDesc('id')->pluck("name", "id")->toArray();
    $venues = Venue::get()->sortByDesc('id')->pluck("id")->toArray();
    $counter = 0;
    $data = $request->all();

    return view('admin.sales.index', compact('data', 'agents', 'venues', 'counter'));
  }

  public function download_csv(Request $request)
  {
    // Total records 
    $_bill = new Bill;
    $result = $_bill
      ->CSVSearch($request->all())
      ->orderByRaw("予約中かキャンセルか,今日以降かどうか,今日以降日付,今日未満日付 desc")
      ->get();

    // // ※参照
    // // https://blog.hrendoh.com/laravel-6-download-csv-with-streamdownload/

    return response()->streamDownload(
      function () use ($result) {
        $stream = fopen('php://output', 'w'); // 出力バッファをopen
        stream_filter_prepend($stream, 'convert.iconv.utf-8/cp932//TRANSLIT'); // 文字コードをShift-JISに変換
        fputcsv($stream, [ // ヘッダー
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
        ]);
        foreach ($result->chunk(1000) as $chunk) {
          foreach ($chunk as $r) {
            fputcsv($stream, [
              $r->multiple_reserve_id,
              $r->reservation_id,
              $r->reserve_date,
              $r->venue_name,
              $r->user_id,
              $r->company_name,
              $r->user_name,
              $r->agent_name,
              $r->enduser_company,
              $r->sogaku,
              $r->bills_master_total,
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
            ]);
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
