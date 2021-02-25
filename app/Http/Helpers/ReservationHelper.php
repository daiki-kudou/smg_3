<?php

namespace App\Http\Helpers;

use App\Models\Venue;
use App\Models\User;
use App\Models\Agent;

use Carbon\Carbon;


class ReservationHelper
{
  // Laravelの標準ヘルパの実装に習い staticにする
  public static function judgeStatus($num)
  {
    switch ($num) {
      case 0:
        return "仮抑え";
        break;
      case 1:
        return "予約確認中";
        break;
      case 2:
        return "予約承認待ち";
        break;
      case 3:
        return "予約完了";
        break;
      case 4:
        return "キャンセル申請中";
        break;
      case 5:
        return "キャンセル承認待ち";
        break;
      case 6:
        return "キャンセル";
        break;
    }
  }

  public static function formatDate($num)
  {
    $weekday = date('w',  strtotime($num));
    if ($weekday == 0) {
      $weekday = "日";
    } elseif ($weekday == 1) {
      $weekday = "月";
    } elseif ($weekday == 2) {
      $weekday = "火";
    } elseif ($weekday == 3) {
      $weekday = "水";
    } elseif ($weekday == 4) {
      $weekday = "木";
    } elseif ($weekday == 5) {
      $weekday = "金";
    } elseif ($weekday == 6) {
      $weekday = "土";
    }
    return date('Y/m/d',  strtotime($num)) . '(' . $weekday . ')';
  }

  public static function formatTime($num)
  {
    return date('H:i',  strtotime($num));
  }

  public static function getVenue($venue_id)
  {
    $venue = Venue::find($venue_id);
    $result = $venue->name_area . $venue->name_bldg . $venue->name_venue;
    return $result;
  }

  public static function getVenueAddreess($venue_id)
  {
    $venue = Venue::find($venue_id);
    return [$venue->post_code, $venue->address1, $venue->address2, $venue->address3, $venue->remark];
  }

  public static function getCompany($user_id)
  {
    $user = User::find($user_id);
    return $user->company;
  }

  public static function getPersonName($user_id)
  {
    $user = User::find($user_id);
    return $user->first_name . $user->last_name;
  }

  public static function getPersonNameKANA($user_id)
  {
    $user = User::find($user_id);
    return $user->first_name_kana . $user->last_name_kana;
  }

  public static function getPersonEmail($user_id)
  {
    $user = User::find($user_id);
    return $user->email;
  }

  public static function getPersonMobile($user_id)
  {
    $user = User::find($user_id);
    return $user->mobile;
  }

  public static function getPersonTel($user_id)
  {
    $user = User::find($user_id);
    return $user->tel;
  }

  public static function getAgentPerson($agent_id)
  {
    $agent = Agent::find($agent_id);
    return $agent->person_firstname . $agent->person_lastname;
  }

  public static function getAgentCompany($agent_id)
  {
    $agent = Agent::find($agent_id);
    return $agent->name;
  }

  public static function getAgentEmail($agent_id)
  {
    $agent = Agent::find($agent_id);
    return $agent->email;
  }

  public static function getAgentTel($agent_id)
  {
    $agent = Agent::find($agent_id);
    return $agent->person_tel;
  }

  public static function getAgentMobile($agent_id)
  {
    $agent = Agent::find($agent_id);
    return $agent->person_mobile;
  }

  public static function getAttr($user_id)
  {
    $user = User::find($user_id);
    switch ($user->attr) {
      case 1:
        return "一般企業";
        break;
      case 2:
        return "上場企業";
        break;
      case 3:
        return "近隣利用";
        break;
      case 4:
        return "講師・セミナー";
        break;
      case 5:
        return "ネットワーク";
        break;
      case 6:
        return "その他";
        break;
    }
  }

  public static function judgePaid($num)
  {
    return $num == 0 ? '未払' : '支払済';
  }

  public static function priceSystem($num)
  {
    return $num == 1 ? '通常（枠貸）' : 'アクセア（時間貸）';
  }

  public static function getTax($num)
  {
    return floor($num * 0.1);
  }

  public static function taxAndPrice($num)
  {
    $tax = 0;
    $tax = floor($num * 0.1);
    $result = floor($num + $tax);
    return $result;
  }

  public static function IdFormat($num)
  {
    return sprintf('%05d', $num);
  }

  public static function judgeArrayEmpty($array)
  {
    $judge = array_filter($array);
    if (!empty($judge)) {
      //配列有り
      return 1;
    } else {
      // 配列無し
      return 0;
    }
  }

  public static function timeOptions()
  {
    $arrays = [];
    for ($i = 0 * 2; $i <= 23 * 2; $i++) {
      $html1 = "<option value=" . date('H:i:s', strtotime('00:00 +' . $i * 30 . ' minute')) . " >";
      $html2 = date('H:i', strtotime('00:00 +' . $i * 30 . ' minute'));
      $html3 = "</option>";
      $arrays[] = $html1 . $html2 . $html3;
    }
    $result =  implode('', $arrays);
    return str_replace('"', '', $result);
  }
  public static function timeOptionsWithDefault()
  {
    $arrays = [];
    for ($i = 8 * 2; $i <= 23 * 2; $i++) {
      $html1 = "<option value=" . date('H:i:s', strtotime('00:00 +' . $i * 30 . ' minute')) . " >";
      $html2 = date('H:i', strtotime('00:00 +' . $i * 30 . ' minute'));
      $html3 = "</option>";
      $arrays[] = $html1 . $html2 . $html3;
    }
    $result =  implode('', $arrays);
    return str_replace('"', '', $result);
  }

  public static function numTimesNum($num1, $num2)
  {
    return (int)$num1 * (int)$num2;
  }

  public static function getUsage($enter_time, $leave_time)
  {
    $carbon1 = new Carbon($enter_time);
    $carbon2 = new Carbon($leave_time);

    $usage_hours = $carbon1->diffInMinutes($carbon2);
    $usage_hours = $usage_hours / 60;
    return $usage_hours;
  }

  public static function checkAgentOrUserCompany($user_id, $agent_id)
  {
    if ($user_id > 0) {
      if ($user_id == 999) {
        return "未登録ユーザー";
      } else {
        return ReservationHelper::getCompany($user_id);
      }
    } else {
      return ReservationHelper::getAgentCompany($agent_id);
    }
  }

  public static function checkAgentOrUserName($user_id, $agent_id)
  {
    if ($user_id > 0) {
      if ($user_id == 999) {
        return "";
      } else {
        return ReservationHelper::getPersonName($user_id);
      }
    } else {
      return ReservationHelper::getAgentPerson($agent_id);
    }
  }

  public static function checkAgentOrUserEmail($user_id, $agent_id)
  {
    if ($user_id > 0) {
      if ($user_id == 999) {
        return "";
      } else {
        return ReservationHelper::getPersonEmail($user_id);
      }
    } else {
      return ReservationHelper::getAgentEmail($agent_id);
    }
  }

  public static function checkAgentOrUserMobile($user_id, $agent_id)
  {
    if ($user_id > 0) {
      if ($user_id == 999) {
        return "";
      } else {
        return ReservationHelper::getPersonMobile($user_id);
      }
    } else {
      return ReservationHelper::getAgentMobile($agent_id);
    }
  }

  public static function checkAgentOrUserTel($user_id, $agent_id)
  {
    if ($user_id > 0) {
      if ($user_id == 999) {
        return "";
      } else {
        return ReservationHelper::getPersonTel($user_id);
      }
    } else {
      return ReservationHelper::getAgentMobile($agent_id);
    }
  }

  public static function checkEquipmentBreakdowns($arrays)
  {
    $_equipment = [];
    foreach ($arrays as $key => $value) {
      if (preg_match('/equipment_breakdown/', $key)) {
        $s_equipment[] = $value;
      }
    }
    $result = ReservationHelper::judgeArrayEmpty($s_equipment);
    return $result;
  }

  public static function checkServiceBreakdowns($arrays)
  {
    $s_service = [];
    foreach ($arrays as $key => $value) {
      if (preg_match('/services_breakdown/', $key)) {
        $s_service[] = $value;
      }
    }
    $result = ReservationHelper::judgeArrayEmpty($s_service);
    return $result;
  }
}
