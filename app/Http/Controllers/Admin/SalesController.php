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
    $agents = Agent::get()->sortByDesc('id')->pluck("name", "id")->toArray();
    $venues = Venue::get()->sortByDesc('id')->pluck("id")->toArray();
    $counter = 0;
    $data = $request->all();

    return view('admin.sales.index', compact('data', 'agents', 'venues', 'counter'));
  }

  public function download_csv(Request $request)
  {
    $bill_arrays = json_decode($request->csv_arrays);
    // ※参照
    // https://blog.hrendoh.com/laravel-6-download-csv-with-streamdownload/

    return response()->streamDownload(
      function () use ($bill_arrays) {
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
        Bill::with(['reservation.venue', 'reservation.user', 'reservation.agent', 'reservation.endusers'])->whereIn('id', $bill_arrays)->orderBy("reservation_id")->chunk(
          1000,
          function ($bills) use ($stream) {
            foreach ($bills as $bill) {
              $total_amount = $bill->reservation->totalAmountWithCxl();
              fputcsv($stream, [
                sprintf('%06d', $bill->reservation->multiple_reserve_id),
                sprintf('%06d', $bill->reservation->id),
                date("Y-m-d", strtotime($bill->reservation->reserve_date)),
                $bill->reservation->venue->name_area . $bill->reservation->venue->name_bldg . $bill->reservation->venue->name_venue,
                sprintf('%06d', $bill->reservation->user_id),
                optional($bill->reservation->user)->company,
                optional($bill->reservation->user)->first_name . optional($bill->reservation->user)->last_name,
                optional($bill->reservation->agent)->name,
                optional($bill->reservation->endusers)->company,
                $total_amount,
                $bill->master_total,
                $bill->reservation->venue->getCostForPartner($bill->reservation->venue, $bill->master_total, $bill->layout_price, $bill->reservation),
                $bill->reservation->venue->getProfitForPartner($bill->reservation->venue, $bill->master_total, $bill->layout_price, $bill->reservation),
                $bill->category == 1 ? "会場予約" : "追加請求",
                $this->checkStatus($bill->reservation_status),
                $bill->pay_day === NULL ? NULL : date("Y-m-d", strtotime($bill->pay_day)),
                $bill->paid == 0 ? "未入金" : "入金済",
                $bill->pay_person,
                $this->getAttr($bill->reservation->user_id),
                date("Y-m-d", strtotime($bill->payment_limit)),
                $bill->reservation->venue->alliance_flag == 0 ? "直" : "提"
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
