<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;


class UnknownUser extends Model
{
  protected $fillable = [
    'pre_reservation_id',
    'unknown_user_company',
    'unknown_user_name',
    'unknown_user_email',
    'unknown_user_mobile',
    'unknown_user_tel',
  ];

  public function pre_reservation()
  {
    return $this->belongsTo(PreReservation::class);
  }

  public function UnknownUserStore($pre_reservation_id, $data)
  {
    $result = $this->create([
      'pre_reservation_id' => $pre_reservation_id,
      'unknown_user_company' => !empty($data['unknown_user_company']) ? $data['unknown_user_company'] : NULL,
      'unknown_user_name' => !empty($data['unknown_user_name']) ? $data['unknown_user_name'] : NULL,
      'unknown_user_email' => !empty($data['unknown_user_email']) ? $data['unknown_user_email'] : NULL,
      'unknown_user_mobile' => !empty($data['unknown_user_mobile']) ? $data['unknown_user_mobile'] : NULL,
      'unknown_user_tel' => !empty($data['unknown_user_tel']) ? $data['unknown_user_tel'] : NULL,
    ]);
    return $result;
  }
}
