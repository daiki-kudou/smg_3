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
    // if (!empty($request->all())) {
    //   $reservations = Reservation::with('bills')->get();
    //   $counter = "";
    //   $all_total_amount = "";
    // } else {
    //   $reservations = Reservation::all();
    //   $counter = "";
    //   $all_total_amount = "";
    // }

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

  // public function noRequest()
  // {
  //   $today = Carbon::today();
  //   $after = Reservation::with(['bills.cxl', 'user', 'agent', 'cxls.cxl_breakdowns', 'enduser', 'venue'])->where('reserve_date', '>=', $today)->get()->sortBy('reserve_date');
  //   $before = Reservation::with(['bills.cxl', 'user', 'agent', 'cxls.cxl_breakdowns', 'enduser', 'venue'])->where('reserve_date', '<', $today)->get()->sortByDesc('reserve_date');
  //   $merge = $after->concat($before);
  //   return $merge;
  // }

  // public function withRequest($request)
  // {
  //   $today = Carbon::today();
  //   $after = Reservation::with(['bills.cxl', 'user', 'agent', 'cxls.cxl_breakdowns', 'enduser', 'venue'])
  //     ->where('reserve_date', '>=', $today);
  //   $result_after = $this->search($after, $request)
  //     ->get()
  //     ->sortBy('reserve_date');
  //   $before = Reservation::with(['bills.cxl', 'user', 'agent', 'cxls.cxl_breakdowns', 'enduser', 'venue'])
  //     ->where('reserve_date', '<', $today);
  //   $result_before = $this->search($before, $request)
  //     ->get()
  //     ->sortByDesc('reserve_date');
  //   $merge = $result_after->concat($result_before);
  //   return $merge;
  // }

  // public function search($target, $request)
  // {
  //   // 総額検索用
  //   $amounts_array = $this->getTotalAmountForSearch($target);

  //   $result = $target->where(function ($query) use ($request, $amounts_array) {
  //     if ($request->multiple_id) {
  //       $val = $this->formatInputInteger($request->multiple_id);
  //       $query->where('multiple_reserve_id', 'like', "%{$val}%");
  //     }
  //     if ($request->id) {
  //       $val = $this->formatInputInteger($request->id);
  //       $query->where('id', 'like', "%{$val}%");
  //     }
  //     if ($request->reserve_date) {
  //       $targetDate = str_replace(" ", "", str_replace('/', '-', explode('-', $request->reserve_date)));
  //       $query->whereBetween("reserve_date", $targetDate);
  //     }
  //     if ($request->user_id) {
  //       $val = $this->formatInputInteger($request->user_id);
  //       $query->where('user_id', 'like', "%{$val}%");
  //     }
  //     if ($request->company) {
  //       $user = User::where("company", "like", "%{$request->company}%")->pluck("id")->toArray();
  //       $query->whereIn("user_id", $user);
  //     }
  //     if ($request->person) {
  //       $user = User::where(\DB::raw('CONCAT(first_name, last_name)'), 'like', "%{$request->person}%")
  //         ->pluck('id')
  //         ->toArray();
  //       $query->whereIn("user_id", $user);
  //     }
  //     if ($request->agent) {
  //       $query->where('agent_id', 'like', "%{$request->agent}%");
  //     }
  //     if ($request->venue) {
  //       $query->where('venue_id', 'like', "%{$request->venue}%");
  //     }
  //     if ($request->enduser) {
  //       $end_user = Enduser::where("company", "like", "%{$request->enduser}%")->pluck("reservation_id")->toArray();
  //       $query->whereIn("id", $end_user);
  //     }
  //     if ($request->amount) {
  //       $array_result = $this->amountSearch($amounts_array, $request->amount);
  //       $query->whereIn("id", $array_result);
  //     }
  //     if ($request->payment_limit) {
  //       $targetDate = str_replace(" ", "", str_replace('/', '-', explode('-', $request->payment_limit)));
  //       $bill = Bill::whereBetween("payment_limit", $targetDate)->distinct()->pluck("reservation_id");
  //       $query->whereIn("id", $bill);
  //     }
  //     for ($i = 0; $i < 9; $i++) {
  //       $query->orWhere(function ($query2) use ($request, $i) {
  //         if ($request->{"status" . $i}) {
  //           $bill = Bill::where('reservation_status', $request->{"status" . $i})->distinct()->pluck("reservation_id")->toArray();
  //           $query2->whereIn("id", $bill);
  //         };
  //         if ($request->{"payment_status" . $i}) {
  //           $paid = Bill::where('paid', $request->{"payment_status" . $i})->pluck("reservation_id")->toArray();
  //           $query2->whereIn("id", $paid);
  //         };
  //         if ($request->{"alliance" . $i} != "") {
  //           $venue = Venue::where('alliance_flag', $request->{"alliance" . $i})->pluck("id")->toArray();
  //           $query2->whereIn("venue_id", $venue);
  //         };
  //       });
  //     }
  //     if ($request->sales2) {
  //       $cxl = Cxl::pluck('reservation_id')->toArray();
  //       $query->orWhereIn("id", $cxl);
  //     }
  //     if ($request->sales3) {
  //       $bill = Bill::pluck("reservation_id")->toArray();
  //       $duplicate = array_count_values($bill);
  //       $check = [];
  //       foreach ($duplicate as $key => $value) {
  //         if ($value > 1) {
  //           $check[] = $key;
  //         }
  //       }
  //       $query->orWhereIn("id", $check);
  //     }

  //     if ($request->free_word) {
  //       $query->where(function ($query2) use ($request, $amounts_array) {
  //         $val = $this->formatInputInteger($request->free_word);
  //         $val = $request->free_word;
  //         $query2->orWhere('id', 'like', "%{$val}%");
  //         $query2->orWhere('multiple_reserve_id', 'like', "%{$val}%");
  //         $query2->orWhere('multiple_reserve_id', 'like', "%{$val}%");
  //         $venue = Venue::where(\DB::raw('CONCAT(name_area, name_bldg, name_venue)'), 'like', "%{$request->free_word}%")
  //           ->pluck('id')
  //           ->toArray();
  //         $query2->orWhereIn("venue_id", $venue);
  //         $query2->orWhere('user_id', 'like', "%{$val}%"); //顧客ID
  //         $company = User::where("company", "like", "%{$request->free_word}%")->pluck("id")->toArray();
  //         $query2->orWhereIn("user_id", $company); //会社名・団体名
  //         $user = User::where(\DB::raw('CONCAT(first_name, last_name)'), 'like', "%{$request->free_word}%")
  //           ->pluck('id')
  //           ->toArray();
  //         $query2->orWhereIn("user_id", $user); //担当者氏名
  //         $agent = Agent::where("company", "like", "%{$request->free_word}%")->pluck("id")->toArray();
  //         $query2->orWhereIn("agent_id", $agent); //仲介会社
  //         $end_user = Enduser::where("company", "like", "%{$request->free_word}%")->pluck("reservation_id")->toArray();
  //         $query2->orWhereIn("id", $end_user); //エンドユーザー
  //         $array_result = $this->amountSearch($amounts_array, $request->free_word);
  //         $query2->orWhereIn("id", $array_result); //総額
  //         if (date('Y-m-d', strtotime($request->free_word)) != "1970-01-01") {
  //           $query2->orWhereDate("reserve_date", $request->free_word);
  //           $bill = Bill::where("payment_limit", $request->free_word)->pluck("reservation_id");
  //           $query2->orWhereIn("id", $bill);
  //         }
  //       });
  //     }
  //   });
  //   return $result;
  // }

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

  // public function customSearchAndSort($model, $request)
  // {
  //   if ($request->sort_multiple_reserve_id) {
  //     if ($request->sort_multiple_reserve_id == 1) {
  //       return $model->sortByDesc("multiple_reserve_id");
  //     } else {
  //       return $model->sortBy("multiple_reserve_id");
  //     }
  //   } elseif ($request->sort_id) {
  //     if ($request->sort_id == 1) {
  //       return $model->sortByDesc("id");
  //     } else {
  //       return $model->sortBy("id");
  //     }
  //   } elseif ($request->sort_reserve_date) {
  //     if ($request->sort_reserve_date == 1) {
  //       return $model->sortByDesc("reserve_date");
  //     } else {
  //       return $model->sortBy("reserve_date");
  //     }
  //   } elseif ($request->sort_enter_time) {
  //     if ($request->sort_enter_time == 1) {
  //       return $model->sortByDesc("enter_time");
  //     } else {
  //       return $model->sortBy("enter_time");
  //     }
  //   } elseif ($request->sort_leave_time) {
  //     if ($request->sort_leave_time == 1) {
  //       return $model->sortByDesc("leave_time");
  //     } else {
  //       return $model->sortBy("leave_time");
  //     }
  //   } elseif ($request->sort_venue) {
  //     if ($request->sort_venue == 1) {
  //       return $model->sortByDesc("venue.name_bldg");
  //     } else {
  //       return $model->sortBy("venue.name_bldg");
  //     }
  //   } elseif ($request->sort_user_company) {
  //     if ($request->sort_user_company == 1) {
  //       return $model->sortByDesc("user.company");
  //     } else {
  //       return $model->sortBy("user.company");
  //     }
  //   } elseif ($request->sort_user_name) {
  //     if ($request->sort_user_name == 1) {
  //       return $model->sortByDesc("user.first_name_kana");
  //     } else {
  //       return $model->sortBy("user.first_name_kana");
  //     }
  //   } elseif ($request->sort_agent) {
  //     if ($request->sort_agent == 1) {
  //       return $model->sortByDesc("agent.company");
  //     } else {
  //       return $model->sortBy("agent.company");
  //     }
  //   } elseif ($request->sort_enduser) {
  //     if ($request->sort_enduser == 1) {
  //       return $model->sortByDesc("endusers.company");
  //     } else {
  //       return $model->sortBy("endusers.company");
  //     }
  //   } elseif ($request->sort_user_id) {
  //     if ($request->sort_user_id == 1) {
  //       return $model->sortByDesc("user.id");
  //     } else {
  //       return $model->sortBy("user.id");
  //     }
  //   } elseif ($request->sort_user_attr) {
  //     if ($request->sort_user_attr == 1) {
  //       return $model->sortByDesc("user.attr");
  //     } else {
  //       return $model->sortBy("user.attr");
  //     }
  //   } elseif ($request->sort_alliance) {
  //     if ($request->sort_alliance == 1) {
  //       return $model->sortByDesc("venue.alliance_flag");
  //     } else {
  //       return $model->sortBy("venue.alliance_flag");
  //     }
  //   }

  //   return $model;
  // }
}
