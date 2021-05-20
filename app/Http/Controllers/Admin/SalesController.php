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
use Carbon\Carbon;

use App\Traits\PaginatorTrait;

class SalesController extends Controller
{

  use PaginatorTrait;

  public function index(Request $request)
  {
    $agents = Agent::pluck("company", "id")->toArray();
    $venues = Venue::pluck("id")->toArray();
    if (!empty($request->all())) {
      $merge = $this->withRequest($request);
    } else {
      $merge = $this->noRequest();
    }
    $reservations = $this->customPaginate($merge, 10, $request);
    return view('admin.sales.index', compact('reservations', 'request', 'agents', 'venues'));
  }

  public function noRequest()
  {
    $today = Carbon::today();
    $after = Reservation::with(['bills.cxl', 'user', 'agent', 'cxls.cxl_breakdowns', 'enduser', 'venue'])->where('reserve_date', '>=', $today)->get()->sortBy('reserve_date');
    $before = Reservation::with(['bills.cxl', 'user', 'agent', 'cxls.cxl_breakdowns', 'enduser', 'venue'])->where('reserve_date', '<', $today)->get()->sortByDesc('reserve_date');
    $merge = $after->concat($before);
    return $merge;
  }

  public function withRequest($request)
  {
    $today = Carbon::today();
    $after = Reservation::with(['bills.cxl', 'user', 'agent', 'cxls.cxl_breakdowns', 'enduser', 'venue'])
      ->where('reserve_date', '>=', $today);
    $result_after = $this->search($after, $request)
      ->get()
      ->sortBy('reserve_date');
    $before = Reservation::with(['bills.cxl', 'user', 'agent', 'cxls.cxl_breakdowns', 'enduser', 'venue'])
      ->where('reserve_date', '<', $today);
    $result_before = $this->search($before, $request)
      ->get()
      ->sortByDesc('reserve_date');
    $merge = $result_after->concat($result_before);
    return $merge;
  }

  public function search($target, $request)
  {
    // 総額検索用
    $amounts_array = $this->getTotalAmountForSearch($target);

    $result = $target->where(function ($query) use ($request, $amounts_array) {
      if ($request->multiple_reserve_id) {
        $query->where('multiple_reserve_id', 'like', "%{$request->multiple_reserve_id}%");
      }
      if ($request->id) {
        $query->where('id', 'like', "%{$request->id}%");
      }
      if ($request->reserve_date) {
        $targetDate = str_replace(" ", "", str_replace('/', '-', explode('-', $request->reserve_date)));
        $query->whereBetween("reserve_date", $targetDate);
      }
      if ($request->user_id) {
        $query->where('user_id', 'like', "%{$request->user_id}%");
      }
      if ($request->company) {
        $user = User::where("company", "like", "%{$request->company}%")->pluck("id")->toArray();
        $query->whereIn("user_id", $user);
      }
      if ($request->person) {
        $user = User::where(\DB::raw('CONCAT(first_name, last_name)'), 'like', "%{$request->person}%")
          ->pluck('id')
          ->toArray();
        $query->whereIn("user_id", $user);
      }
      if ($request->agent) {
        $query->where('agent_id', 'like', "%{$request->agent}%");
      }
      if ($request->venue) {
        $query->where('venue_id', 'like', "%{$request->venue}%");
      }
      if ($request->enduser) {
        $end_user = Enduser::where("company", "like", "%{$request->enduser}%")->pluck("reservation_id")->toArray();
        $query->whereIn("id", $end_user);
      }
      if ($request->amount) {
        $array_result = $this->amountSearch($amounts_array, $request->amount);
        $query->whereIn("id", $array_result);
      }
      if ($request->payment_limit) {
        $targetDate = str_replace(" ", "", str_replace('/', '-', explode('-', $request->payment_limit)));
        $bill = Bill::whereBetween("payment_limit", $targetDate)->distinct()->pluck("reservation_id");
        $query->whereIn("id", $bill);
      }
      for ($i = 0; $i < 9; $i++) {
        $query->orWhere(function ($query2) use ($request, $i) {
          if ($request->{"status" . $i}) {
            $bill = Bill::where('reservation_status', $request->{"status" . $i})->distinct()->pluck("reservation_id")->toArray();
            $query2->whereIn("id", $bill);
          };
          if ($request->{"payment_status" . $i}) {
            $paid = Bill::where('paid', $request->{"payment_status" . $i})->pluck("reservation_id")->toArray();
            $query2->whereIn("id", $paid);
          };
          if ($request->{"alliance" . $i} != "") {
            $venue = Venue::where('alliance_flag', $request->{"alliance" . $i})->pluck("id")->toArray();
            $query2->whereIn("venue_id", $venue);
          };
        });
      }
    });

    return $result;
  }

  public function amountSearch($amounts_array, $input)
  {
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
