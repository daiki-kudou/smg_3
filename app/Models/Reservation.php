<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Support\Facades\DB; //トランザクション用

use App\Models\Venue;
use App\Models\User;
use App\Models\Cxl;
use App\Models\Enduser;
use Illuminate\Support\Collection;

use Carbon\Carbon;

use App\Presenters\ReservationPresenter;
use Robbo\Presenter\PresentableInterface; //プレゼンターの追加

use App\Traits\InvoiceTrait;
use App\Traits\SearchTrait;
use App\Traits\TransactionTrait;


class Reservation extends Model implements PresentableInterface
{
  use InvoiceTrait;
  use SearchTrait;
  use TransactionTrait;


  public function getPresenter() //実装したプレゼンタを利用
  {
    return new ReservationPresenter($this);
  }

  use SoftDeletes; //reservation大事なのでソフトデリートする

  protected $fillable = [
    'venue_id',
    'user_id',
    'agent_id',
    'reserve_date',
    'price_system',
    'enter_time',
    'leave_time',
    'event_start',
    'event_finish',
    'board_flag',
    'event_name1',
    'event_name2',
    'event_owner',
    'luggage_flag',
    'luggage_count',
    'luggage_arrive',
    'luggage_return',
    'luggage_price',
    'email_flag',
    'in_charge',
    'tel',
    'email_send',
    'cost',
    'discount_condition',
    'attention',
    'user_details',
    'admin_details',
    'payment_limit',
    'reservation_status',
    'double_check_status',
    'double_check1_name',
    'double_check2_name',
    'bill_company',
    'bill_person',
    'bill_created_at',
    'bill_pay_limit',
    'bill_remark',
    'eat_in',
    'eat_in_prepare',
    'multiple_reserve_id',

  ];
  protected $dates = [
    'reserve_date',
    'payment_limit',
    'bill_created_at',
    'bill_pay_limit',
    'luggage_arrive'
  ];
  //formatで使用できるようにするため 参考https://readouble.com/laravel/6.x/ja/eloquent-mutators.html


  // | 顧客との一対多
  public function user()
  {
    return $this->belongsTo(User::class)->withTrashed();
  }

  // | 会場との一対多
  public function venue()
  {
    return $this->belongsTo(Venue::class);
  }

  // | Billsとの一対多
  public function bills()
  {
    return $this->hasMany(Bill::class);
  }
  // | Billsを経由してbreakdowns
  public function breakdowns()
  {
    return $this->hasManyThrough(
      'App\Models\Breakdown',
      'App\Models\Bill',
    );
  }

  // | 仲介会社との一対多
  public function agent()
  {
    return $this->belongsTo(Agent::class);
  }

  // cxl一対多
  public function cxls()
  {
    return $this->hasMany(Cxl::Class);
  }

  public function endusers()
  {
    return $this->hasOne(Enduser::Class);
  }

  public function change_log()
  {
    return $this->hasOne('App\Models\ChangeLog');
  }

  // bills 削除用
  protected static function boot()
  {
    parent::boot();
    static::deleting(function ($model) {
      foreach ($model->bills()->get() as $child) {
        $child->delete();
      }
    });
  }

  public function addAllBills()
  {
    $bills = $this->bills()->get();
    $result_subtotal = 0;
    foreach ($$bills as $key => $value) {
      $result_subtotal += $value->sub_total;
    }
    return $result_subtotal;
  }

  //  管理者予約保存
  public function ReservationStore($data)
  {
    $chkReservation = ($this->checkReservationsTransaction($data['reserve_date'], $data['enter_time'], $data['leave_time'], $data['venue_id']));
    $chkPreReservation = ($this->checkPreReservationsTransaction($data['reserve_date'], $data['enter_time'], $data['leave_time'], $data['venue_id']));
    if (!$chkReservation || !$chkPreReservation) {
      return "重複";
    }
    $result = $this->create([
      'venue_id' => $data['venue_id'],
      'user_id' => !empty($data['user_id']) ? $data['user_id'] : 0,
      'agent_id' => !empty($data['agent_id']) ? $data['agent_id'] : 0,
      'reserve_date' => $data['reserve_date'],
      'price_system' => $data['price_system'],
      'enter_time' => $data['enter_time'],
      'leave_time' => $data['leave_time'],
      'board_flag' => $data['board_flag'],
      'event_start' => $data['event_start'] ?? "",
      'event_finish' => $data['event_finish'] ?? "",
      'event_name1' => $data['event_name1'] ?? NULL,
      'event_name2' => $data['event_name2'] ?? NULL,
      'event_owner' => $data['event_owner'] ?? NULL,
      'luggage_flag' => !empty($data['luggage_flag']) ? $data['luggage_flag'] : 0,
      'luggage_price' => !empty($data['luggage_price']) ? $data['luggage_price'] : 0,
      'luggage_count' => !empty($data['luggage_count']) ? $data['luggage_count'] : 0,
      'luggage_arrive' => !empty($data['luggage_arrive']) ? $data['luggage_arrive'] : NULL,
      'luggage_return' => !empty($data['luggage_return']) ? $data['luggage_return'] : NULL,
      'email_flag' => $data['email_flag'],
      'in_charge' => $data['in_charge'],
      'tel' => !empty($data['tel']) ? $data['tel'] : "",
      'cost' => !empty($data['cost']) ? $data['cost'] : 0,
      'discount_condition' => !empty($data['discount_condition']) ? $data['discount_condition'] : NULL,
      'attention' => !empty($data['attention']) ? $data['attention'] : NULL,
      'user_details' => !empty($data['user_details']) ? $data['user_details'] : NULL,
      'admin_details' => !empty($data['admin_details']) ? $data['admin_details'] : NULL,
      'eat_in' => !empty($data['eat_in']) ? $data['eat_in'] : 0,
      'eat_in_prepare' => !empty($data['eat_in_prepare']) ? $data['eat_in_prepare'] : 0,
      'multiple_reserve_id' => !empty($data['multiple_reserve_id']) ? $data['multiple_reserve_id'] : 0,

    ]);
    return $result;
  }

  public function ReservationUpdate($data)
  {
    $chkReservation = ($this->checkReservationsTransaction($data['reserve_date'], $data['enter_time'], $data['leave_time'], $data['venue_id'], $data['reservation_id']));
    $chkPreReservation = ($this->checkPreReservationsTransaction($data['reserve_date'], $data['enter_time'], $data['leave_time'], $data['venue_id']));
    if (!$chkReservation || !$chkPreReservation) {
      return "重複";
    }
    $this->update([
      'venue_id' => $data['venue_id'],
      'user_id' => !empty($data['user_id']) ? $data['user_id'] : 0,
      'agent_id' => !empty($data['agent_id']) ? $data['agent_id'] : 0,
      'reserve_date' => $data['reserve_date'],
      'price_system' => $data['price_system'],
      'enter_time' => $data['enter_time'],
      'leave_time' => $data['leave_time'],
      'board_flag' => $data['board_flag'],
      'event_start' => !empty($data['event_start']) ? $data['event_start'] : "",
      'event_finish' => !empty($data['event_finish']) ? $data['event_finish'] : "",
      'event_name1' => !empty($data['event_name1']) ? $data['event_name1'] : "",
      'event_name2' => !empty($data['event_name2']) ? $data['event_name2'] : "",
      'event_owner' => !empty($data['event_owner']) ? $data['event_owner'] : "",
      'luggage_flag' => !empty($data['luggage_flag']) ? $data['luggage_flag'] : 0,
      'luggage_price' => !empty($data['luggage_price']) ? $data['luggage_price'] : 0,
      'luggage_count' => !empty($data['luggage_count']) ? $data['luggage_count'] : 0,
      'luggage_arrive' => !empty($data['luggage_arrive']) ? $data['luggage_arrive'] : NULL,
      'luggage_return' => !empty($data['luggage_return']) ? $data['luggage_return'] : NULL,
      'email_flag' => !empty($data['email_flag']) ? $data['email_flag'] : 1,
      'in_charge' => !empty($data['in_charge']) ? $data['in_charge'] : "",
      'tel' => !empty($data['tel']) ? $data['tel'] : "",
      'cost' => !empty($data['cost']) ? $data['cost'] : 0,
      'discount_condition' => !empty($data['discount_condition']) ? $data['discount_condition'] : NULL,
      'attention' => !empty($data['attention']) ? $data['attention'] : NULL,
      'user_details' => !empty($data['user_details']) ? $data['user_details'] : NULL,
      'admin_details' => !empty($data['admin_details']) ? $data['admin_details'] : NULL,      'eat_in' => !empty($data['eat_in']) ? $data['eat_in'] : 0,
      'eat_in_prepare' => !empty($data['eat_in_prepare']) ? $data['eat_in_prepare'] :  0,
      'multiple_reserve_id' => !empty($data['multiple_reserve_id']) ? $data['multiple_reserve_id'] : 0,

    ]);
    return $this;
  }

  public function CreateEndUser($request)
  {
    if (
      !empty($request->enduser_company) ||
      !empty($request->enduser_incharge) ||
      !empty($request->enduser_address) ||
      !empty($request->enduser_tel) ||
      !empty($request->enduser_mail) ||
      !empty($request->enduser_attr) ||
      !empty($request->end_user_charge) ||
      !empty($request->enduser_mobile)
    ) {
      DB::transaction(function () use ($request) {
        $this->enduser()->create([
          'reservation_id' => $this->id,
          'company' => $request->enduser_company,
          'person' => $request->enduser_incharge,
          'address' => $request->enduser_address,
          'tel' => $request->enduser_tel,
          'email' => $request->enduser_mail,
          'attr' => $request->enduser_attr,
          'charge' => $request->end_user_charge,
          'mobile' => $request->enduser_mobile,
        ]);
      });
    }
  }

  // 仲介会社選択の場合のみ、エンドユーザーとの一対一

  public function enduser()
  {
    return $this->hasOne(Enduser::class);
  }

  public function SearchReservation($data)
  {
    $searchTarget = $this->ReservationSearchTarget();

    if (!empty($data['multiple_id']) && (int)$data['multiple_id'] > 0) {
      for ($i = 0; $i < strlen($data['multiple_id']); $i++) {
        if ((int)$data['multiple_id'][$i] !== 0) {
          $id = strstr($data['multiple_id'], $data['multiple_id'][$i]);
          break;
        }
      }
      $searchTarget->whereRaw('reservations.multiple_reserve_id = ? ', [$id]);
    }

    if (!empty($data['search_id']) && (int)$data['search_id'] > 0) {
      // for ($i = 0; $i < strlen($data['search_id']); $i++) {
      //   if ((int)$data['search_id'][$i] !== 0) {
      //     $id = strstr($data['search_id'], $data['search_id'][$i]);
      //     break;
      //   }
      // }
      $searchTarget->whereRaw('reservations.id LIKE ? ',  ['%' . $data['search_id'] . '%']);
    }

    if (!empty($data['user_id']) && (int)$data['user_id'] > 0) {
      for ($i = 0; $i < strlen($data['user_id']); $i++) {
        if ((int)$data['user_id'][$i] !== 0) {
          $id = strstr($data['user_id'], $data['user_id'][$i]);
          break;
        }
      }
      $searchTarget->whereRaw('users.id = ?', [$id]);
    }

    if (!empty($data['reserve_date'])) {
      $targetData = explode(" ~ ", $data['reserve_date']);
      $searchTarget->whereRaw('reservations.reserve_date between ? AND ? ',  $targetData);
    }

    if (!empty($data['enter_time'])) {
      $searchTarget->whereRaw('reservations.enter_time >= ? ',  $data['enter_time']);
    }

    if (!empty($data['leave_time'])) {
      $searchTarget->whereRaw('reservations.leave_time <= ? ',  $data['leave_time']);
    }

    if (!empty($data['venue_id'])) {
      $searchTarget->whereRaw('reservations.venue_id = ? ',  [$data['venue_id']]);
    }

    if (!empty($data['company'])) {
      $searchTarget->whereRaw('users.company LIKE ? ',  ['%' . $data['company'] . '%']);
    }

    if (!empty($data['person_name'])) {
      $searchTarget->whereRaw('concat(users.first_name,users.last_name) LIKE ? ',  ['%' . $data['person_name'] . '%']);
    }

    if (!empty($data['search_mobile'])) {
      $searchTarget->whereRaw('users.mobile LIKE ? ',  ['%' . $data['search_mobile'] . '%']);
    }

    if (!empty($data['search_tel'])) {
      $searchTarget->whereRaw('users.tel LIKE ? ',  ['%' . $data['search_tel'] . '%']);
    }

    if (!empty($data['agent'])) {
      $searchTarget->whereRaw('agents.id = ? ',  [$data['agent']]);
    }

    if (!empty($data['enduser_person'])) {
      $searchTarget->whereRaw('endusers.company LIKE ? ',  ['%' . $data['enduser_person'] . '%']);
    }

    if (!empty($data['amount'])) {
      $searchTarget->havingRaw('総額 = ?', [$data['amount']]);
    }

    if (!empty($data['payment_limit'])) {
      $date = explode(' - ', $data['payment_limit']);
      $searchTarget->whereRaw('bills.payment_limit between ? AND ?', $date);
    }

    if (!empty($data['pay_day'])) {
      $date = explode(' - ', $data['pay_day']);
      $searchTarget->whereRaw('bills.pay_day between ? AND ?', $date);
    }

    if (!empty($data['pay_person'])) {
      $searchTarget->whereRaw('bills.pay_person LIKE ?', ['%' . $data['pay_person'] . '%']);
    }

    if (!empty($data['attr'])) {
      $searchTarget->whereRaw('users.attr = ?', [$data['attr']]);
    }

    // チェックボックス
    $searchTarget = $searchTarget->where(function ($query) use ($data) {
      if (!empty($data['alliance0'])) {
        $query->orWhereRaw('venues.alliance_flag = ? ', [0]);
      }
      if (!empty($data['alliance1'])) {
        $query->orWhereRaw('venues.alliance_flag = ? ', [1]);
      }
    });

    // アイコン
    if (!empty($data['check_icon1'])) {
      $searchTarget->orWhereRaw('breakdowns2.unit_type = ? ',  [$data['check_icon1']]);
    }
    if (!empty($data['check_icon2'])) {
      $searchTarget->orWhereRaw('breakdowns3.unit_type = ? ',  [$data['check_icon2']]);
    }
    if (!empty($data['check_icon3'])) {
      $searchTarget->orWhereRaw('breakdowns4.unit_type = ? ',  [$data['check_icon3']]);
    }
    if (!empty($data['check_icon4'])) {
      $searchTarget->orWhereRaw('reservations.eat_in = ? ',  [1]);
    }

    // チェックボックス
    $searchTarget = $searchTarget->where(function ($query) use ($data) {
      if (!empty($data['check_status1'])) {
        $query->orWhereRaw('bills.reservation_status = ? ', [1]);
      }
      if (!empty($data['check_status2'])) {
        $query->orWhereRaw('bills.reservation_status = ? ',  [2]);
      }
      if (!empty($data['check_status3'])) {
        $query->orWhereRaw('bills.reservation_status = ? ',  [3]);
      }
      if (!empty($data['check_status4'])) {
        $query->orWhereRaw('bills.reservation_status = ? ',  [4]);
      }
      if (!empty($data['check_status5'])) {
        $query->orWhereRaw('bills.reservation_status = ? ',  [5]);
      }
      if (!empty($data['check_status6'])) {
        $query->orWhereRaw('bills.reservation_status = ? ',  [6]);
      }
    });

    // チェックボックス 売上区分
    $searchTarget = $searchTarget->where(function ($query) use ($data) {
      if (!empty($data['sales1'])) {
        $query->orWhereRaw('bill_count_m.bill_count = ? ', [1]);
      }
      if (!empty($data['sales2'])) {
        $query->orWhereRaw('cxl_count_m.cxl_count >= ? ', [1]);
      }
      if (!empty($data['sales3'])) {
        $query->orWhereRaw('bill_count_m.bill_count > ? ', [1]);
      }
    });

    // チェックボックス 入金状況
    $searchTarget = $searchTarget->where(function ($query) use ($data) {
      if (!empty($data['payment_status0'])) {
        $query->orWhereRaw('bills.paid = ? ', [0]);
      }
      if (!empty($data['payment_status1'])) {
        $query->orWhereRaw('bills.paid = ? ', [1]);
      }
      if (!empty($data['payment_status2'])) {
        $query->orWhereRaw('bills.paid = ? ', [2]);
      }
      if (!empty($data['payment_status3'])) {
        $query->orWhereRaw('bills.paid = ? ', [3]);
      }
      if (!empty($data['payment_status4'])) {
        $query->orWhereRaw('bills.paid = ? ', [4]);
      }
      if (!empty($data['payment_status5'])) {
        $query->orWhereRaw('bills.paid = ? ', [5]);
      }
    });

    $searchTarget = $searchTarget->where(function ($query) use ($data) {
      if (!empty($data['freeword'])) {
        for ($i = 0; $i < strlen($data['freeword']); $i++) {
          if ((int)$data['freeword'][$i] !== 0) {
            $id = strstr($data['freeword'], $data['freeword'][$i]);
            $query->orWhereRaw('reservations.id LIKE ? ', ['%' . $id . '%']);
            $query->orWhereRaw('reservations.multiple_reserve_id LIKE ? ', ['%' . $id . '%']);
            $query->orWhereRaw('users.mobile LIKE ? ', ['%' . $id . '%']);
            $query->orWhereRaw('users.tel LIKE ? ', ['%' . $id . '%']);
            $query->orWhereRaw('reservations.reserve_date LIKE ? ', ['%' . $id . '%']);
            $query->orWhereRaw('reservations.enter_time LIKE ? ', ['%' . $id . '%']);
            $query->orWhereRaw('reservations.leave_time LIKE ? ', ['%' . $id . '%']);
            break;
          }
        }
        // 利用会場
        $query->orWhereRaw('concat(venues.name_area,venues.name_bldg,venues.name_venue) LIKE ? ',  ['%' . $data['freeword'] . '%']);
        $query->orWhereRaw('concat(users.first_name,users.last_name) LIKE ? ',  ['%' . $data['freeword'] . '%']);
        $query->orWhereRaw('users.company LIKE ? ',  ['%' . $data['freeword'] . '%']);
        $query->orWhereRaw('concat(agents.person_firstname,agents.person_lastname) LIKE ? ',  ['%' . $data['freeword'] . '%']);
        $query->orWhereRaw('agents.name LIKE ? ',  ['%' . $data['freeword'] . '%']);
        $query->orWhereRaw('endusers.company LIKE ? ',  ['%' . $data['freeword'] . '%']);
      }
    });

    // 売上請求一覧用のフリーワード検索
    if (!empty($data['sales_search_box'])) {
      if (!empty($data['free_word'])) {
        if (preg_match('/^[0-9!,]+$/', $data['free_word'])) {
          //数字の場合検索
          $searchTarget = $searchTarget->where(function ($query) use ($data) {
            if (!empty($data['free_word'])) {
              for ($i = 0; $i < strlen($data['free_word']); $i++) {
                if ((int)$data['free_word'][$i] !== 0) {
                  $id = strstr($data['free_word'], $data['free_word'][$i]);
                  break;
                }
              }
              $query->orWhereRaw('reservations.id LIKE ? ', ['%' . $id . '%']); //予約ID
              $query->orWhereRaw('reservations.multiple_reserve_id LIKE ? ', ['%' . $id . '%']); //一括ID
              $query->orWhereRaw('users.id LIKE ? ', ['%' . $id . '%']); //顧客ID
            }
          });
        } else {
          //文字列の場合
          $searchTarget = $searchTarget->where(function ($query) use ($data) {
            if (!empty($data['free_word'])) {
              $query->orWhereRaw('reservations.reserve_date = ? ', [$data['free_word']]); //利用日
              $query->orWhereRaw('users.company LIKE ? ', ['%' . $data['free_word'] . '%']); //会社名・団体名
              $query->orWhereRaw('concat(users.first_name,users.last_name) LIKE ? ',  ['%' . $data['free_word'] . '%']); //担当者氏名
              $query->orWhereRaw('endusers.company LIKE ? ',  ['%' . $data['free_word'] . '%']); //エンドユーザー
              $query->orWhereRaw('bills.payment_limit = ? ',  [$data['free_word']]); //支払い期日
              $query->orWhereRaw('bills.pay_day = ? ',  [$data['free_word']]); //支払い日
              $query->orWhereRaw('bills.pay_person = ? ',  [$data['free_word']]); //振込人名
              $query->orWhereRaw('concat(venues.name_area,venues.name_bldg,venues.name_venue) LIKE ? ',  ['%' . $data['free_word'] . '%']);
              $query->orWhereRaw('agents.name LIKE ? ',  ['%' . $data['free_word'] . '%']); //エンドユーザー
            }
          });
        }
      }
    }

    // $searchTarget->orderByRaw('予約中かキャンセルか,今日以降かどうか,今日以降日付,今日未満日付 desc');

    return $searchTarget;
  }

  /**   
   * 予約一覧の検索対象マスタ
   * @return object collectionで返る
   */
  public function ReservationSearchTarget()
  {
    $searchTarget = DB::table('reservations')
      ->select(DB::raw(
        '
        distinct reservations.id as reservation_id,
      reservations.multiple_reserve_id as multiple_reserve_id,
      reservations.reserve_date as reserve_date,
      reservations.enter_time as enter_time,
      reservations.leave_time as leave_time,
      reservations.board_flag as board_flag,
      reservations.venue_id as venue_id,
      concat(venues.name_area,venues.name_bldg,venues.name_venue) as venue_name, 
      users.company as company_name,
      concat(users.first_name, users.last_name) as user_name, 
      users.mobile as mobile,
      users.tel as tel,
      agents.name as agent_name,
      agents.id as agent_id,
      endusers.company as enduser_company,
      case when bills.reservation_status <= 3 then 0 else 1 end as 予約中かキャンセルか,
      case when reservations.reserve_date >= CURRENT_DATE then 0 else 1 end as 今日以降かどうか,
      case when reservations.reserve_date >= CURRENT_DATE then reserve_date end as 今日以降日付,
      case when reservations.reserve_date < CURRENT_DATE then reserve_date end as 今日未満日付
      '
      ))
      ->leftJoin('bills', 'reservations.id', '=', 'bills.reservation_id')
      ->leftJoin('users', 'reservations.user_id', '=', 'users.id')
      ->leftJoin('agents', 'reservations.agent_id', '=', 'agents.id')
      ->leftJoin('endusers', 'reservations.id', '=', 'endusers.reservation_id')
      ->leftJoin('venues', 'reservations.venue_id', '=', 'venues.id')
      ->leftJoin(DB::raw(""));

    return $searchTarget;
  }

  // reservations show 各請求書合計額
  public function TotalAmount()
  {
    $venues_master = 0;
    $items_master = 0;
    $layouts_master = 0;
    $others_master = 0;
    $master_subtotals = 0;
    $master_taxs = 0;
    $master_totals = 0;
    foreach ($this->bills->where('reservation_status', '<', 4) as $key => $value) {
      $venues_master += $value->venue_price;
      $items_master += $value->equipment_price;
      $layouts_master += $value->layout_price;
      $others_master += $value->others_price;
      $master_subtotals += $value->master_subtotal;
      $master_taxs += $value->master_tax;
      $master_totals += $value->master_total;
    }
    $all_master_subtotal = $venues_master + $items_master + $layouts_master + $others_master;
    return [
      $venues_master,
      $items_master,
      $layouts_master,
      $others_master,
      $all_master_subtotal
    ];
  }

  public function checkBillsStatus()
  {
    $collection = $this->bills->pluck('reservation_status');
    foreach ($collection as $key => $value) {
      if ($value < 3) {
        //ステータスが予約完了もしくはキャンセル完了していないキャンセルプロセスがあれば
        return 0;
        break;
      } elseif ($value > 3 && $value < 6) {
        return 0;
        break;
      }
    }
    return 1;
  }
  public function checkSingleBillsStatus()
  {
    $collection = $this->bills->pluck('reservation_status');
    foreach ($collection as $key => $value) {
      if ($value > 3 && $value != 6) {
        //ステータスが予約完了もしくはキャンセル完了していないキャンセルプロセスがあれば
        return 0;
        break;
      }
    }
    return 1;
  }

  public function pluckSum($array, $targetStatus)
  {
    $result = [];
    foreach ($array as $key => $value) {
      $result[] = $this->bills->where("reservation_status", $targetStatus)->pluck($value)->sum(); //予約ステータス3（予約完了）のみが対象
    }
    return $result;
  }

  public function UpdateAgentEndUser($inputs)
  {
    $this->enduser()->delete();
    if (
      !empty($inputs['enduser_company']) ||
      !empty($inputs['enduser_incharge']) ||
      !empty($inputs['enduser_address']) ||
      !empty($inputs['enduser_tel']) ||
      !empty($inputs['enduser_mail']) ||
      !empty($inputs['enduser_attr']) ||
      !empty($inputs['end_user_charge']) ||
      !empty($inputs['enduser_mobile'])
    ) {
      DB::transaction(function () use ($inputs) {
        $this->enduser()->create([
          'reservation_id' => $this->id,
          'company' => $inputs['enduser_company'],
          'person' => $inputs['enduser_incharge'],
          'address' => $inputs['enduser_address'],
          'tel' => $inputs['enduser_tel'],
          'email' => $inputs['enduser_mail'],
          'attr' => $inputs['enduser_attr'],
          'charge' => $inputs['end_user_charge'],
          'mobile' => $inputs['enduser_mobile'],
        ]);
      });
    }
  }

  public function totalAmountWithCxl()
  {
    $subtotal = $this->bills->where('reservation_status', '<=', 3)->pluck('master_total')->sum();
    $cxl = $this->cxls->pluck('master_total')->sum();
    return $subtotal + $cxl;
  }
}
