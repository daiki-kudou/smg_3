<?php

namespace App\Services\Admin\Venue;

use Carbon\Carbon;

class CalculateService
{
  protected $status;
  protected $start;
  protected $finish;

  public function __construct($status, $start, $finish)
  {
    $this->status = $status;
    $this->start = Carbon::parse($start);
    $this->finish = Carbon::parse($finish);
  }

  public function calc() //計算のマスタ
  {
    if ($this->status === 1) {
      return $this->frameCalc();
    } elseif ($this->status === 2) {
      return $this->timeCalc();
    } else {
      return 0;
    }
  }

  public function rejectTime()
  {
    if ($this->start < Carbon::parse("08:00:00") || $this->finish > Carbon::parse("23:00:00")) {
      return FALSE;
    } else {
      return TRUE;
    }
  }

  public function frameCalc()
  {
    //入退室が 8時以前or23時以降なら処理中断
    if (!$this->rejectTime()) {
      return 0;
    } else {
      return $this->generateStartTime();
    }
  }

  public function timeCalc()
  {
    return "時間計算です";
  }

  public function generateStartTime()
  {
    if ($this->start == Carbon::parse('17:00:00') || $this->start == Carbon::parse('17:30:00')) {
      return Carbon::parse('18:00:00');
    } elseif ($this->start == Carbon::parse('12:00:00') || $this->start == Carbon::parse('12:30:00')) {
      return Carbon::parse('13:00:00');
    } elseif ($this->start == Carbon::parse('08:00:00') || $this->start == Carbon::parse('08:30:00') || $this->start == Carbon::parse('09:00:00') || $this->start == Carbon::parse('09:30:00')) {
      return Carbon::parse('10:00:00');
    } elseif ($this->start >= '10:00:00' && $this->start <= '19:00:00') {
      return $this->start;
    }
  }
}
