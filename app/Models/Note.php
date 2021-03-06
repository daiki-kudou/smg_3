<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
  protected $fillable = [
    'hour',
    'venue',
    'company',
    'content',
    'date',
    'sort_no',
  ];
}
