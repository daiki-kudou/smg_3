<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
  protected $fillable = [
    'venue_id',
    'user_id',
    'reserve_date',
    'enter_time',
    'leave_time',
    'event_start',
    'event_finish',
    'event_name1',
    'event_name2',
    'event_owner',
    'luggage_count',
    'luggage_arrive',
    'luggage_return',
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
    'paid',
    'reservation_status',
    'double_check_status',
    'double_check1_name',
    'double_check2_name',
    'bill_company',
    'bill_person',
    'bill_created_at',
    'bill_pay_limit',
    'bill_remark',
  ];
  protected $dates = [
    'reserve_date',
    'payment_limit',
    'bill_created_at',
    'bill_pay_limit',
    'luggage_arrive'
  ];
  //formatで使用できるようにするため 参考https://readouble.com/laravel/6.x/ja/eloquent-mutators.html


  /*
|--------------------------------------------------------------------------
| 顧客との一対多
|--------------------------------------------------------------------------|
*/
  public function user()
  {
    return $this->belongsTo(User::class);
  }

  /*
|--------------------------------------------------------------------------
| 会場との一対多
|--------------------------------------------------------------------------|
*/
  public function venue()
  {
    return $this->belongsTo(Venue::class);
  }

  /*
|--------------------------------------------------------------------------
| Billsとの一対多
|--------------------------------------------------------------------------|
*/
  public function bills()
  {
    return $this->hasMany(Bill::class);
  }
  /*
|--------------------------------------------------------------------------
| Billsを経由してbreakdowns
|--------------------------------------------------------------------------|
*/
  public function breakdowns()
  {
    return $this->hasManyThrough(
      'App\Models\Breakdown',
      'App\Models\Bill',
    );
  }



}
