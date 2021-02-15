<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\Passwords\CanResetPassword;

use Carbon\Carbon;



// implements MustVerifyEmailを削除した
class User extends Authenticatable
{
  use Notifiable;

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
| 会場と仮抑え一対多
|--------------------------------------------------------------------------|
*/
  public function pre_reservations()
  {
    return $this->hasMany(PreReservation::class);
  }




  public function searchs(
    $freeword,
    $id,
    $status,
    $company,
    $attr,
    $person_name,
    $mobile,
    $tel,
    $email,
    $attention
  ) {
    if (isset($freeword)) {
      return $this->where('id', 'LIKE', "%$freeword%")
        ->orWhere('status', 'LIKE', "%$freeword%")
        ->orWhere('company', 'LIKE', "%$freeword%")
        ->orWhere('attr', 'LIKE', "%$freeword%")
        ->orWhere('first_name', 'LIKE', "%$freeword%")
        ->orWhere('last_name', 'LIKE', "%$freeword%")
        ->orWhere('mobile', 'LIKE', "%$freeword%")
        ->orWhere('tel', 'LIKE', "%$freeword%")
        ->orWhere('email', 'LIKE', "%$freeword%")
        ->orWhere('attention', 'LIKE', "%$freeword%")->paginate(10);
    } else if (isset($id)) {
      return $this->where('id', 'LIKE', "%$id%")->paginate(10);
    } else if (isset($status)) {
      return $this->where('status', 'LIKE', "%$status%")->paginate(10);
    } else if (isset($company)) {
      return $this->where('company', 'LIKE', "%$company%")->paginate(10);
    } else if (isset($attr)) {
      return $this->where('attr', 'LIKE', "%$attr%")->paginate(10);
    } else if (isset($person_name)) {
      return $this->where('first_name', 'LIKE', "%$person_name%")
        ->orWhere('last_name', 'LIKE', "%$person_name%")->paginate(10);
    } else if (isset($mobile)) {
      return $this->where('mobile', 'LIKE', "%$mobile%")->paginate(10);
    } else if (isset($company)) {
      return $this->where('company', 'LIKE', "%$company%")->paginate(10);
    } else if (isset($tel)) {
      return $this->where('tel', 'LIKE', "%$tel%")->paginate(10);
    } else if (isset($email)) {
      return $this->where('email', 'LIKE', "%$email%")->paginate(10);
    } else if (isset($attention)) {
      return $this->where('attention', 'LIKE', "%$attention%")->paginate(10);
    } else {
      return $this->query()->paginate(10);
    }
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
}
