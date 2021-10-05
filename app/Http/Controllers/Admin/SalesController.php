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

    $reservations = new Reservation;
    $data = $request->all();
    $search_result = $reservations->search_item($data);
    if (count(array_filter($data)) !== 0) {
      // 検索あり
      $reservationsWithOrder = array_unique($search_result->pluck('reservation_id')->toArray());
      $ids_order = !empty(array_values($reservationsWithOrder)) ? implode(',', array_values($reservationsWithOrder)) : "''";
      $reservations = Reservation::whereIn("id", $reservationsWithOrder)->with(['bills', 'venue', 'user', 'enduser', 'cxls'])->orderByRaw("FIELD(id, $ids_order)")->get();
    } else {
      // 検索なし
      $reservationsWithOrder = array_unique($search_result->orderByRaw('予約中かキャンセルか,今日以降かどうか,今日以降日付,今日未満日付 desc')->pluck('reservation_id')->toArray());
      $ids_order = !empty(array_values($reservationsWithOrder)) ? implode(',', array_values($reservationsWithOrder)) : "''";
      $reservations = Reservation::whereIn("id", $reservationsWithOrder)->with(['bills', 'venue', 'user', 'enduser', 'cxls'])->orderByRaw("FIELD(id, $ids_order)")->get();
    }
    $for_csv = $this->forCsv($reservations); //csv抽出用
    $this->adjustReservationData($reservations, $search_result);
    $reservationsObject = $reservations;
    $reservations = $reservations->toArray();


    return view('admin.sales.index', compact('reservations', 'reservationsObject', 'data', 'agents', 'venues', 'for_csv', 'counter'));
  }

  //reservationsに総額、キャンセル総額、予約総額を追加
  public function adjustReservationData($reservations, $search_result)
  {
    $sogakuAray = $search_result->get()->pluck(['総額'], 'reservation_id')->toArray();
    $masterTotalAray = $search_result->get()->pluck(['master_total_sum'], 'reservation_id')->toArray();
    $CxlMasterTotalAray = $search_result->get()->pluck(['cxls_master_total'], 'reservation_id')->toArray();

    // dd($sogakuAray, $masterTotalAray, $CxlMasterTotalAray);

    foreach ($reservations as $key => $value) {
      $venue = Venue::find($value['venue_id']);

      if (array_key_exists($value->id, $sogakuAray)) {
        $value['sogaku'] = $sogakuAray[$value->id];
      }
      if (array_key_exists($value->id, $masterTotalAray)) {
        $value['master_total'] = $masterTotalAray[$value->id];
      }
      if (array_key_exists($value->id, $CxlMasterTotalAray)) {
        $value['cxls_master_total'] = $CxlMasterTotalAray[$value->id];
      }

      $value['sum_cost_for_partner'] = $venue->sumCostForPartner($value);
      $value['sum_cxl_cost_for_partner'] = $venue->getCxlCostForPartner($value);


      foreach ($value->bills as $key2 => $bill) {
        $bill['cost_for_partner'] = $venue->getCostForPartner($venue, $bill->master_total, $bill->layout_price, $value);
      }
    }
  }

  public function amountSearch($amounts_array, $input)
  {
    $input = (str_replace(',', '', $input));
    $input = (str_replace('円', '', $input));
    $empty = [];
    foreach ($amounts_array as $key => $value) {
      if ($value == $input) {
        $empty[] = $key;
      }
    }
    return $empty;
  }

  public function getTotalAmountForSearch($target)
  {
    $sequence = $target->get()->map(function ($item) {
      return (["amount" => $item->totalAmountWithCxl(), "id" => $item->id]);
    });
    return $amounts_array = $sequence->pluck("amount", "id")->toArray();
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
