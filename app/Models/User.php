<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\Passwords\CanResetPassword;
use App\Notifications\CustomResetPassword; //自作

use Carbon\Carbon;

use Illuminate\Support\Facades\DB; //トランザクション用

use Illuminate\Database\Eloquent\SoftDeletes; //追記


// implements MustVerifyEmailを削除した
class User extends Authenticatable
{
  use Notifiable;
  use SoftDeletes;

  // 自作パスワードリセット
  public function sendPasswordResetNotification($token)
  {
    $this->notify(new CustomResetPassword($token));
  }

  protected $dates = ['deleted_at']; //追記

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'email',
    'password',
    'company',
    'post_code',
    'address1',
    'address2',
    'address3',
    'address_remark',
    'url',
    'attr',
    'condition',
    'first_name',
    'last_name',
    'first_name_kana',
    'last_name_kana',
    'mobile',
    'tel',
    'fax',
    'pay_method',
    'pay_limit',
    'pay_post_code',
    'pay_address1',
    'pay_address2',
    'pay_address3',
    'pay_remark',
    'attention',
    'remark',
    'status',
    'admin_or_user'
  ];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [
    'password', 'remember_token',
  ];

  /**
   * The attributes that should be cast to native types.
   *
   * @var array
   */
  protected $casts = [
    'email_verified_at' => 'datetime',
  ];

  // アクセサ
  // fix_id
  public function getFixIdAttribute()
  {
    return sprintf('%06d', $this->id);
  }

  // fix_attr
  public function getFixAttrAttribute()
  {
    switch ($this->attr) {
      case 1:
        return '一般企業';
        break;
      case 2:
        return '上場企業';
        break;
      case 3:
        return '近隣利用';
        break;
      case 4:
        return '個人講師';
        break;
      case 5:
        return 'MLM';
        break;
      case 6:
        return '仲介会社';
        break;
      case 7:
        return 'その他';
        break;
      default:
        return NULL;
        break;
    }
  }

  // person
  public function getPersonAttribute()
  {
    return $this->first_name . $this->last_name;
  }


  /*
|--------------------------------------------------------------------------
| 会場と予約の一対多
|--------------------------------------------------------------------------|
*/
  public function reservations()
  {
    return $this->hasMany(Reservation::class);
  }

  /*
|--------------------------------------------------------------------------
| 会場と仮押え一対多
|--------------------------------------------------------------------------|
*/
  public function pre_reservations()
  {
    return $this->hasMany(PreReservation::class);
  }

  public function getUserPayLimit($reserve_date)
  {
    $date = Carbon::parse($reserve_date);
    $limit = "";

    if ($this->pay_limit == 1) {
      $limit = $date;
    } elseif ($this->pay_limit == 2) {
      $limit = $date->subDays(3);
      if (!$limit->isSaturday() && !$limit->isSunday()) {
        $limit;
      } else {
        $limit->subDays(1);
      }
    } elseif ($this->pay_limit == 3) {
      $limit = $date->endOfMonth();
    } elseif ($this->pay_limit == 4) {
      $months = 1; // 追加する月数
      $limit = $date->day(1)->addMonths($months)->endOfMonth();
    } elseif ($this->pay_limit == 5) {
      $months = 2; // 追加する月数
      $limit = $date->day(1)->addMonths($months)->endOfMonth();
    }
    $result = new Carbon($limit);
    return date("Y-m-d", strtotime($result));
  }

  public function getCompany()
  {
    return $this->company;
  }

  public function getPerson()
  {
    return $this->first_name . $this->last_name;
  }

  public function search($request)
  {
    $users = DB::table('users')
      ->select(DB::raw(
        "
      lpad(bills.reservation_id,6,0) as reservation_id,
      bills.id as bill_id,
      bills.reservation_status as status,
      format(bills.master_total,0) as master_total,
      case when bills.category = 1 then '会場予約' else '追加請求' end as category,
      cxls_list.cxl_reservation_id as cxl_reservation_id,
      lpad(users.id,6,0) as user_id,
      users.email as user_email,
      users.company as company,
        concat(date_format(reservations.reserve_date, '%Y/%m/%d'),
        case 
        when DAYOFWEEK(reservations.reserve_date) = 1 then '(日)' 
        when DAYOFWEEK(reservations.reserve_date) = 2 then '(月)'
        when DAYOFWEEK(reservations.reserve_date) = 3 then '(火)'
        when DAYOFWEEK(reservations.reserve_date) = 4 then '(水)'
        when DAYOFWEEK(reservations.reserve_date) = 5 then '(木)'
        when DAYOFWEEK(reservations.reserve_date) = 6 then '(金)'
        when DAYOFWEEK(reservations.reserve_date) = 7 then '(土)'
        end
        ) as reserve_date,
              time_format(reservations.enter_time, '%H:%i') as enter_time,
              time_format(reservations.leave_time, '%H:%i') as leave_time,
      concat(venues.name_area,venues.name_bldg,venues.name_venue) as venue_name,
      case when cxls_list.cxl_reservation_id is null then bills.invoice_number else null end as invoice_number,
        concat(date_format(bills.payment_limit, '%Y/%m/%d'),
        case 
        when DAYOFWEEK(bills.payment_limit) = 1 then '(日)' 
        when DAYOFWEEK(bills.payment_limit) = 2 then '(月)'
        when DAYOFWEEK(bills.payment_limit) = 3 then '(火)'
        when DAYOFWEEK(bills.payment_limit) = 4 then '(水)'
        when DAYOFWEEK(bills.payment_limit) = 5 then '(木)'
        when DAYOFWEEK(bills.payment_limit) = 6 then '(金)'
        when DAYOFWEEK(bills.payment_limit) = 7 then '(土)'
        end
        ) as payment_limit,
      venues.smg_url as smg_url
        "
      ));
    return $users;
    // $class = $this->where(function ($query) use ($request) {

    //   if ($request->search_id) {
    //     $editId = $request->search_id;
    //     if (substr($request->search_id, 0, 5) == "00000") {
    //       $editId = str_replace("00000", "", $request->search_id);
    //     } elseif (substr($request->search_id, 0, 4) == "0000") {
    //       $editId = str_replace("0000", "", $request->search_id);
    //     } elseif (substr($request->search_id, 0, 3) == "000") {
    //       $editId = str_replace("000", "", $request->search_id);
    //     } elseif (substr($request->search_id, 0, 2) == "00") {
    //       $editId = str_replace("00", "", $request->search_id);
    //     }
    //     $query->where("id", "LIKE", "%" . $editId . "%");
    //   }

    //   if ($request->search_company) {
    //     $query->where("company", "LIKE", "%" . $request->search_company . "%");
    //   }
    //   if ($request->search_person) {
    //     $query->where('first_name', 'LIKE', "%{$request->search_person}%");
    //     $query->orWhere('last_name', 'LIKE', "%{$request->search_person}%");
    //     $query->orWhere(DB::raw('CONCAT(first_name, last_name)'), 'like', '%' . $request->search_person . '%');
    //   }
    //   if ($request->search_mobile) {
    //     $query->where('mobile', 'LIKE', "%{$request->search_mobile}%");
    //   }
    //   if ($request->search_tel) {
    //     $query->where('tel', 'LIKE', "%{$request->search_tel}%");
    //   }
    //   if ($request->search_email) {
    //     $query->where('email', 'LIKE', "%{$request->search_email}%");
    //   }

    //   if ($request->attention) {
    //     if ($request->attention == 1) {
    //       $query->where('attention', "LIKE", "%%");
    //     } elseif ($request->attention == 2) {
    //       $query->whereNull('attention');
    //     }
    //   }


    //   $query->where(function ($query) use ($request) {
    //     for ($i = 1; $i <= 7; $i++) {
    //       if (!empty($request->{"attr" . $i})) {
    //         $query->orWhere("attr", $request->{"attr" . $i});
    //       }
    //     }
    //   });

    //   if ($request->freeword) {
    //     $query->where('id', 'LIKE', "%{$request->freeword}%")
    //       ->orWhere("company", "LIKE", "%{$request->freeword}%")
    //       ->orWhere("first_name", "LIKE", "%{$request->freeword}%")
    //       ->orWhere("last_name", "LIKE", "%{$request->freeword}%")
    //       ->orWhere(DB::raw('CONCAT(first_name, last_name)'), 'like', '%' . $request->freeword . '%')
    //       ->orWhere("mobile", "LIKE", "%{$request->freeword}%")
    //       ->orWhere("tel", "LIKE", "%{$request->freeword}%")
    //       ->orWhere("email", "LIKE", "%{$request->freeword}%");
    //   }
    //   $query->where('deleted_at', NULL);
    // });

    // return $class;
  }
}
