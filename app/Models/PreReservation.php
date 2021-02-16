<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PreReservation extends Model
{
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
    'luggage_count',
    'luggage_arrive',
    'luggage_return',
    'email_flag',
    'in_charge',
    'tel',
    'email_send',
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
    'status',

  ];
  protected $dates = [
    'reserve_date',
    'payment_limit',
    'bill_created_at',
    'bill_pay_limit',
    'luggage_arrive'
  ];

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
| PreBillsとの一対多
|--------------------------------------------------------------------------|
*/
  public function pre_bills()
  {
    return $this->hasMany(PreBill::class);
  }
  /*
|--------------------------------------------------------------------------
| PreBillsを経由してbreakdowns
|--------------------------------------------------------------------------|
*/
  public function pre_breakdowns()
  {
    return $this->hasManyThrough(
      'App\Models\PreBreakdown',
      'App\Models\PreBill',
    );
  }

  /*
|--------------------------------------------------------------------------
| 仲介会社との一対多
|--------------------------------------------------------------------------|
*/
  public function agent()
  {
    return $this->belongsTo(Agent::class);
  }

  // 未登録ユーザーとの１対１
  public function unknown_user()
  {
    // Profileモデルのデータを引っ張てくる
    return $this->hasOne(UnknownUser::class);
  }

  // Prebills 削除用
  protected static function boot()
  {
    parent::boot();
    static::deleting(function ($model) {
      foreach ($model->pre_bills()->get() as $child) {
        $child->delete();
      }
      foreach ($model->unknown_user()->get() as $child2) {
        $child2->delete();
      }
    });
  }
}
