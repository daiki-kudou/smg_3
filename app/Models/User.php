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

  public function search_target()
  {
    $users = DB::table('users')
      ->select(DB::raw(
        "
        case when users.attention is not null then '●' else null end as attention,
        lpad(users.id,6,0) as fix_id,
        users.company,
        case 
        when users.attr = 1 then '一般企業'
        when users.attr = 2 then '上場企業'
        when users.attr = 3 then '近隣利用'
        when users.attr = 4 then '個人講師'
        when users.attr = 5 then 'MLM'
        when users.attr = 6 then '仲介会社'
        when users.attr = 7 then 'その他'
        end as attr,
        concat(users.first_name, users.last_name) as name,
        users.mobile,
        users.tel,
        users.email,
        users.id
        "
      ))
      ->whereRaw('deleted_at is null');
    return $users;
  }

  public function search($ary)
  {
    $users = $this->search_target();
    if (!empty($ary['search_id'])) {
      $users = $users->whereRaw('users.id like ?', ['%' . $ary['search_id'] . '%']);
    }
    if (!empty($ary['search_company'])) {
      $users = $users->whereRaw('users.company like ?', ['%' . $ary['search_company'] . '%']);
    }
    if (!empty($ary['search_person'])) {
      $users = $users->whereRaw('concat(users.first_name, users.last_name) like ?', ['%' . $ary['search_person'] . '%']);
    }
    if (!empty($ary['search_mobile'])) {
      $users = $users->whereRaw('users.mobile like ?', ['%' . $ary['search_mobile'] . '%']);
    }
    if (!empty($ary['search_tel'])) {
      $users = $users->whereRaw('users.tel like ?', ['%' . $ary['search_tel'] . '%']);
    }
    if (!empty($ary['search_email'])) {
      $users = $users->whereRaw('users.email like ?', ['%' . $ary['search_email'] . '%']);
    }
    if (!empty($ary['attention']) && (int)$ary['attention'] === 1) {
      $users = $users->whereRaw('users.attention is not null');
    }

    return $users;
  }
}
