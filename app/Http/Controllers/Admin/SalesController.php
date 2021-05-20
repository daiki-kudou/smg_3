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
    $today = Carbon::today();
    // $reservations = Reservation::with(['bills.cxl', 'user', 'agent', 'cxls', 'enduser', 'venue'])
    //   ->orderByRaw(
    //     "CASE WHEN reserve_date > '$today' 
    //     THEN reserve_date 
    //     ELSE 9999 
    //     END"
    //   )->paginate(30);
    $reservations = Reservation::with(['bills.cxl', 'user', 'agent', 'cxls.cxl_breakdowns', 'enduser', 'venue'])->get()->sortByDesc('id');
    return view('admin.sales.index', compact('reservations'));
  }

  public function download_csv(Request $request)
  {
    // ※参照
    // https://blog.hrendoh.com/laravel-6-download-csv-with-streamdownload/
    return response()->streamDownload(
      function () {
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
          '予約詳細',
          '振込名',
          '顧客属性',
          '支払期日',
          '運営'
        ]);
        Bill::with(['reservation.venue', 'reservation.user', 'reservation.agent', 'reservation.endusers'])->chunk(
          1000,
          function ($bills) use ($stream) {
            foreach ($bills as $bill) {
              $total_amount = $bill->reservation->totalAmountWithCxl();
              fputcsv($stream, [
                $bill->reservation->multiple_reserve_id,
                $bill->reservation->id,
                $bill->reservation->reserve_date,
                $bill->reservation->venue->name_area . $bill->reservation->venue->name_bldg . $bill->reservation->venue->name_venue,
                $bill->reservation->user_id,
                optional($bill->reservation->user)->company,
                optional($bill->reservation->user)->first_name . optional($bill->reservation->user)->last_name,
                optional($bill->reservation->agent)->company,
                optional($bill->reservation->endusers)->company,
                $total_amount,
                $bill->master_total,
                $bill->reservation->venue->getCostForPartner($bill->reservation->venue, $bill->master_total, $bill->layout_price, $bill->reservation),
                $bill->reservation->venue->getProfitForPartner($bill->reservation->venue, $bill->master_total, $bill->layout_price, $bill->reservation),
                $bill->category == 1 ? "会場予約" : "追加請求",
                $this->checkStatus($bill->reservation_status),
                $bill->pay_day,
                $bill->paid == 0 ? "未入金" : "入金済",
                $bill->pay_person,
                $this->getAttr($bill->reservation->user_id),
                $bill->payment_limit,
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

  public function checkStatus($num)
  {
    if (empty($num)) {
      return null;
    }
    switch ($num) {
      case 0:
        return "仮押え";
        break;
      case 1:
        return "予約確認中";
        break;
      case 2:
        return "予約承認待ち";
        break;
      case 3:
        return "予約完了";
        break;
      case 4:
        return "キャンセル申請中";
        break;
      case 5:
        return "キャンセル承認待ち";
        break;
      case 6:
        return "キャンセル";
        break;
    }
  }

  public function getAttr($user_id)
  {
    switch ($user_id) {
      case 1:
        return "一般企業";
        break;
      case 2:
        return "上場企業";
        break;
      case 3:
        return "近隣利用";
        break;
      case 4:
        return "個人講師";
        break;
      case 5:
        return "MLM";
        break;
      case 6:
        return "その他";
        break;
    }
  }
}
