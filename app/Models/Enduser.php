<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enduser extends Model
{
  protected $fillable = [
    'reservation_id',
    'company',
    'person',
    'address',
    'tel',
    'email',
    'attr',
    'charge',
    'mobile',
  ];

  /*
|--------------------------------------------------------------------------
| 仲介会社経由予約に紐づく予約の参照
|--------------------------------------------------------------------------|
*/
  public function reservation()
  {
    return $this->belongsTo(Reservation::class);
  }

  public function endUserStore($reservation_id, $data)
  {
    $result = $this->create([
      'reservation_id' => $reservation_id,
      'company' => $data['enduser_company'],
      'person' => $data['enduser_incharge'],
      'address' => $data['enduser_address'],
      'tel' => $data['enduser_tel'],
      'email' => $data['enduser_mail'],
      'attr' => $data['enduser_attr'],
      'charge' => $data['end_user_charge'],
      'mobile' => $data['enduser_mobile'],
    ]);
    return $result;
  }

  public function endUserUpdate($data)
  {
    $result = $this->update([
      'company' => $data['enduser_company'],
      'person' => $data['enduser_incharge'],
      'address' => $data['enduser_address'],
      'tel' => $data['enduser_tel'],
      'email' => $data['enduser_mail'],
      'attr' => $data['enduser_attr'],
      'charge' => $data['end_user_charge'],
      'mobile' => $data['enduser_mobile'],
    ]);
    return $result;
  }
}
