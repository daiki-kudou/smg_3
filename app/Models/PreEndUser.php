<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PreEndUser extends Model
{
  protected $table = 'pre_endusers';

  protected $fillable = [
    'pre_reservation_id',
    'company',
    'person',
    'email',
    'mobile',
    'tel',
    'address',
    'attr',
    'charge',
  ];

  public function pre_reservation()
  {
    return $this->belongsTo(PreReservation::class);
  }

  public function PreEndUserStore($pre_reservation_id, $data)
  {
    $result = $this->create([
      "pre_reservation_id" => $pre_reservation_id,
      "company" => $data['pre_enduser_company'],
      "person" => $data['pre_enduser_name'],
      "email" => $data['pre_enduser_email'],
      "mobile" => $data['pre_enduser_mobile'],
      "tel" => $data['pre_enduser_tel'],
      "address" => $data['pre_enduser_address'],
      "attr" => $data['pre_enduser_attr'],
      'charge' => $data['enduser_charge'],
    ]);
    return $result;
  }
}
