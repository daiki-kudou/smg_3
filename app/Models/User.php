<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\Passwords\CanResetPassword;
use App\Notifications\CustomResetPassword; //自作


use Carbon\Carbon;

use Illuminate\Support\Facades\DB; //トランザクション用



// implements MustVerifyEmailを削除した
class User extends Authenticatable
{
  use Notifiable;

  // 自作パスワードリセット
  public function sendPasswordResetNotification($token)
  {
    $this->notify(new CustomResetPassword($token));
  }


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
    // 1:3営業日前 2:当月末　3:翌月末　4:翌々月末
    if ($this->pay_limit == 1) {
      $limit = $date->subDays(3);
    } elseif ($this->pay_limit == 2) {
      $limit = $date->endOfMonth();
    } elseif ($this->pay_limit == 3) {
      $limit = $date->addMonthsNoOverflow(1);
    } elseif ($this->pay_limit == 4) {
      $limit = $date->addMonthsNoOverflow(2);
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
    $class = $this->where(function ($query) use ($request) {

      if ($request->search_id) {
        $editId = $request->search_id;
        if (substr($request->search_id, 0, 5) == "00000") {
          $editId = str_replace("00000", "", $request->search_id);
        } elseif (substr($request->search_id, 0, 4) == "0000") {
          $editId = str_replace("0000", "", $request->search_id);
        } elseif (substr($request->search_id, 0, 3) == "000") {
          $editId = str_replace("000", "", $request->search_id);
        } elseif (substr($request->search_id, 0, 2) == "00") {
          $editId = str_replace("00", "", $request->search_id);
        }
        $query->where("id", "LIKE", "%" . $editId . "%");
      }

      if ($request->search_company) {
        $query->where("company", "LIKE", "%" . $request->search_company . "%");
      }
      if ($request->search_person) {
        $query->where('first_name', 'LIKE', "%{$request->search_person}%");
        $query->orWhere('last_name', 'LIKE', "%{$request->search_person}%");
        $query->orWhere(DB::raw('CONCAT(first_name, last_name)'), 'like', '%' . $request->search_person . '%');
      }
      if ($request->search_mobile) {
        $query->where('mobile', 'LIKE', "%{$request->search_mobile}%");
      }
      if ($request->search_tel) {
        $query->where('tel', 'LIKE', "%{$request->search_tel}%");
      }
      if ($request->search_email) {
        $query->where('email', 'LIKE', "%{$request->search_email}%");
      }

      if ($request->attention) {
        if ($request->attention == 1) {
          $query->where('attention', "LIKE", "%%");
        } elseif ($request->attention == 2) {
          $query->whereNull('attention');
        }
      }


      $query->where(function ($query) use ($request) {
        for ($i = 1; $i <= 7; $i++) {
          if (!empty($request->{"attr" . $i})) {
            $query->orWhere("attr", $request->{"attr" . $i});
          }
        }
      });

      if ($request->freeword) {
        $query->where('id', 'LIKE', "%{$request->freeword}%")
          ->orWhere("company", "LIKE", "%{$request->freeword}%")
          ->orWhere("first_name", "LIKE", "%{$request->freeword}%")
          ->orWhere("last_name", "LIKE", "%{$request->freeword}%")
          ->orWhere(DB::raw('CONCAT(first_name, last_name)'), 'like', '%' . $request->freeword . '%')
          ->orWhere("mobile", "LIKE", "%{$request->freeword}%")
          ->orWhere("tel", "LIKE", "%{$request->freeword}%")
          ->orWhere("email", "LIKE", "%{$request->freeword}%");
      }
    });

    return $class;
  }
}
