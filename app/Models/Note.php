<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB; //トランザクション用

class Note extends Model
{
  protected $fillable = [
    'hour',
    'venue',
    'company',
    'content',
  ];
}
