<?php

namespace App\Http\Helpers;

use App\Models\Venue;
use App\Models\User;
use App\Models\Agent;
use App\Models\PreEndUser;

use Carbon\Carbon;


class ReservationHelper
{
  // Laravelの標準ヘルパの実装に習い staticにする
  public static function judgeStatus($num)
  {
    if (empty($num)) {
      return null;
    }
    switch ($num) {
      case 0:
        return "仮押え";
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
    if (empty($num) || $num == "1970-01-01 00:00:00") {
      return null;
    }
    $weekday = date('w', strtotime($num));
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
    return date('Y/m/d', strtotime($num)) . '(' . $weekday . ')';
  }

  public static function formatDateJA($num)
  {
    $weekday = date('w', strtotime($num));
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
    return date('Y年n月j日', strtotime($num)) . '(' . $weekday . ')';
  }

  public static function formatTime($num)
  {
    if (!empty($num)) {
      return date('H:i', strtotime($num));
    } else {
      return "";
    }
  }

  public static function getVenue($venue_id)
  {
    if (!empty($venue_id)) {
      $venue = Venue::find($venue_id);
      return  $venue->name_area . $venue->name_bldg . $venue->name_venue;
    } else {
      return NULL;
    }
  }

  public static function getVenueForUser($venue_id)
  {
    $venue = Venue::find($venue_id);
    return $venue->full_name;
  }

  public static function getVenueAddreess($venue_id)
  {
    $venue = Venue::find($venue_id);
    return [$venue->post_code, $venue->address1, $venue->address2, $venue->address3, $venue->remark];
  }

  public static function getVenueFullAddress($venue_id)
  {
    if (!empty($venue_id)) {
      $venue = Venue::find($venue_id);
      return $venue->post_code . ' ' . $venue->address1 . $venue->address2 . $venue->address3;
    } else {
      return NULL;
    }
  }

  public static function getCompany($user_id)
  {
    if (!empty($user_id)) {
      $user = User::withTrashed()->find($user_id);
      return $user->company;
    } else {
      return NULL;
    }
  }

  public static function getPersonName($user_id)
  {
    if (!empty($user_id)) {
      $user = User::withTrashed()->find($user_id);
      return $user->first_name . $user->last_name;
    } else {
      return NULL;
    }
  }

  public static function getPersonNameKANA($user_id)
  {
    if (!empty($user_id)) {
      $user = User::find($user_id);
      return $user->first_name_kana . $user->last_name_kana;
    } else {
      return NULL;
    }
  }

  public static function getPersonEmail($user_id)
  {
    if (!empty($user_id)) {
      $user = User::find($user_id);
      return $user->email;
    } else {
      return NULL;
    }
  }

  public static function getPersonMobile($user_id)
  {
    if ((int)$user_id === 0 || empty($user_id)) {
      return NULL;
    } else {
      $user = User::find($user_id);
      return $user->mobile;
    }
  }

  public static function getPersonTel($user_id)
  {
    if ((int)$user_id === 0 || empty($user_id)) {
      return NULL;
    } else {
      $user = User::find($user_id);
      return $user->tel;
    }
  }

  public static function getPersonCondition($user_id)
  {
    if ((int)$user_id === 0 || empty($user_id)) {
      return NULL;
    } else {
      $user = User::find($user_id);
      return $user->condition;
    }
  }

  public static function getPersonAttention($user_id)
  {
    if ((int)$user_id === 0 || empty($user_id)) {
      return NULL;
    } else {
      $user = User::find($user_id);
      return $user->attention;
    }
  }

  public static function getAgentPerson($agent_id)
  {
    if ((int)$agent_id === 0 || empty($agent_id)) {
      return NULL;
    } else {
      $agent = Agent::find($agent_id);
      return $agent->person_firstname . $agent->person_lastname;
    }
  }

  public static function getAgentPersonKANA($agent_id)
  {
    if ((int)$agent_id === 0 || empty($agent_id)) {
      return NULL;
    } else {
      $agent = Agent::find($agent_id);
      return $agent->firstname_kana . $agent->lastname_kana;
    }
  }

  public static function getAgentCompany($agent_id)
  {
    if ((int)$agent_id === 0 || empty($agent_id)) {
      return NULL;
    } else {
      $agent = Agent::find($agent_id);
      return $agent->name;
    }
  }

  public static function getAgentCompanyName($agent_id)
  {
    if ((int)$agent_id === 0 || empty($agent_id)) {
      return NULL;
    } else {
      $agent = Agent::find($agent_id);
      return $agent->company;
    }
  }

  public static function getAgentEmail($agent_id)
  {
    if ((int)$agent_id === 0 || empty($agent_id)) {
      return NULL;
    } else {
      $agent = Agent::find($agent_id);
      return $agent->email;
    }
  }

  public static function getAgentTel($agent_id)
  {
    if ((int)$agent_id === 0 || empty($agent_id)) {
      return NULL;
    } else {
      $agent = Agent::find($agent_id);
      return $agent->person_tel;
    }
  }

  public static function getAgentMobile($agent_id)
  {
    if ((int)$agent_id === 0 || empty($agent_id)) {
      return NULL;
    } else {
      $agent = Agent::find($agent_id);
      return $agent->person_mobile;
    }
  }

  public static function getAttr($num)
  {
    if (empty($num)) {
      return NULL;
    }
    switch ($num) {
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
        return "個人講師";
        break;
      case 5:
        return "MLM";
        break;
      case 6:
        return "その他";
        break;
      default:
        return NULL;
        break;
    }
  }

  public static function PreEndUserGetAttr($enduser_id)
  {
    switch ($enduser_id) {
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
        return "個人講師";
        break;
      case 5:
        return "MLM";
        break;
      case 6:
        return "その他";
        break;
      default:
        return NULL;
        break;
    }
  }

  public static function judgePaid($num)
  {
    return $num == 0 ? '未払' : '支払済';
  }

  public static function priceSystem($num)
  {
    return $num == 1 ? '通常（枠貸）' : '音響HG';
  }

  public static function getTax($num)
  {
    $target = $num * 0.1;
    $target = floor($target);

    return $target;
  }

  public static function taxAndPrice($num)
  {
    $tax = ($num * 0.1);
    $tax = ($num + $tax);
    $tax = floor($tax);
    return $tax;
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
    for ($i = 0 * 2; $i <= 24 * 2; $i++) {
      if ($i == 48) {
        break;
      }
      $html1 = "<option value=" . date('H:i:s', strtotime('00:00 +' . $i * 30 . ' minute')) . " >";
      $html2 = date('H時i分', strtotime('00:00 +' . $i * 30 . ' minute'));
      $html3 = "</option>";
      $arrays[] = $html1 . $html2 . $html3;
    }
    $result =  implode('', $arrays);
    return str_replace('"', '', $result);
  }
  public static function timeOptionsWithRequest($time)
  {
    $arrays = [];
    for ($i = 0 * 2; $i <= 24 * 2; $i++) {
      if ($i == 48) {
        break;
      }
      $selected = $time == date('H:i:s', strtotime('00:00 +' . $i * 30 . ' minute')) ? "selected" : "";
      $html1 = "<option value=" . date('H:i:s', strtotime('00:00 +' . $i * 30 . ' minute')) . " " . $selected . ">";
      $html2 = date('H時i分', strtotime('00:00 +' . $i * 30 . ' minute'));
      $html3 = "</option>";
      $arrays[] = $html1 . $html2 . $html3;
    }
    $result =  implode('', $arrays);
    return str_replace('"', '', $result);
  }
  public static function timeOptionsWithRequestAndLimit($time, $limit_start, $limit_finish)
  {
    $arrays = [];
    for ($i = 0 * 2; $i <= 24 * 2; $i++) {
      if ($i == 48) {
        break;
      }
      $selected = $time == date('H:i:s', strtotime('00:00 +' . $i * 30 . ' minute')) ? "selected" : "";
      $limit1 = $limit_start > date('H:i:s', strtotime('00:00 +' . $i * 30 . ' minute')) && (date('H:i:s', strtotime('00:00 +' . $i * 30 . ' minute'))!=='00:00:00') ? "disabled" : "";
      $limit2 = $limit_finish < date('H:i:s', strtotime('00:00 +' . $i * 30 . ' minute')) ? "disabled" : "";
      $html1 = "<option value=" . date('H:i:s', strtotime('00:00 +' . $i * 30 . ' minute')) . " " . $selected . $limit1 . $limit2 . ">";
      $html2 = date('H時i分', strtotime('00:00 +' . $i * 30 . ' minute'));
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
    return (int) $num1 * (int) $num2;
  }

  public static function numTimesNumArrays($requests, $text)
  {
    $target = 0;
    foreach ($requests as $key => $value) {
      $target += $value[0][$text];
    }

    return $target;
  }

  public static function getUsage($enter_time, $leave_time)
  {
    $carbon1 = new Carbon($enter_time);
    $carbon2 = new Carbon($leave_time);
    $usage_hours = $carbon1->diffInMinutes($carbon2);
    return $usage_hours / 60;
  }

  public static function checkAgentOrUser($user_id)
  {
    if ($user_id != 0) {
    }
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
      return ReservationHelper::getAgentTel($agent_id);
    }
  }

  public static function checkEquipmentBreakdowns($arrays)
  {
    $s_equipment = [];
    foreach ($arrays as $key => $value) {
      if (preg_match('/equipment_breakdown/', $key)) {
        $s_equipment[] = $value;
      }
    }
    return ReservationHelper::judgeArrayEmpty($s_equipment);
  }

  public static function checkServiceBreakdowns($arrays)
  {
    $s_service = [];
    foreach ($arrays as $key => $value) {
      if (preg_match('/services_breakdown/', $key)) {
        $s_service[] = $value;
      }
    }

    return ReservationHelper::judgeArrayEmpty($s_service);
  }

  public static function jsonDecode($arrays)
  {
    return json_decode($arrays, true);
  }

  public static function DBLJsonDecode($arrays)
  {
    return json_decode($arrays, true);
  }

  public static function getLayoutPrice($venue_id)
  {
    $venue = Venue::find($venue_id);
    $prepare = $venue->layout_prepare;
    $clean = $venue->layout_clean;
    return [$prepare, $clean];
  }

  public static function getEndUser($enduser)
  {
    switch ($enduser) {
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
        return "個人講師";
        break;
      case 5:
        return "MLM";
        break;
      case 6:
        return "その他";
        break;
      default:
        return NULL;
        break;
    }
  }

  public static function JudgeEmpty($item)
  {
    if (empty($item)) {
      return "";
    } else {
      return $item;
    }
  }

  public static function getController($route, $target1, $target2)
  {
    $controllerName1 = explode('.', $route)[0];
    $controllerName2 = explode('.', $route)[1];
    if ($controllerName1 == $target1 && $controllerName2 == $target2) {
      return "menu-open";
    }
  }

  public static function getRoute($route, $target)
  {
    if ($route == $target) {
      return "active";
    }
  }

  public static function payTerm($num)
  {
    if ($num === 1) {
      return "当月末締め／当月末支払い";
    } elseif ($num === 2) {
      return "当月末締め／翌月末支払い";
    } elseif ($num === 3) {
      return "当月末締め／翌々月末支払い";
    } elseif ($num === 4) {
      return "当月末締め／翌々々月末支払い";
    }
  }

  public static function fixId($num)
  {
    if (!empty($num)) {
      return sprintf('%06d', $num);
    } else {
      return null;
    }
  }

  public static function isEmpty($item)
  {
    if (!empty($item)) {
      return $item;
    } else {
      return "";
    }
  }

  public static function cxlStatus($cxl_id)
  {
    switch ($cxl_id) {
      case 0:
        return "キャンセル申請中";
        break;
      case 1:
        return "キャンセル承認待ち";
        break;
      case 2:
        return "キャンセル";
        break;
    }
  }

  public static function paidStatus($num)
  {
    switch ($num) {
      case 0:
        return "未入金";
        break;
      case 1:
        return "入金済";
        break;
      case 2:
        return "遅延";
        break;
      case 3:
        return "入金不足";
        break;
      case 4:
        return "入金過多";
        break;
      case 5:
        return "次回繰越";
        break;
    }
  }

  public static function sortIcon($num)
  {
    if (empty($num)) {
      return "<i class='fas fa-sort'></i>";
    } elseif ($num == 1) {
      return "<i class='fas fa-sort-amount-up' style='color:darkcyan;'></i>";
    } elseif ($num == 2) {
      return "<i class='fas fa-sort-amount-down-alt' style='color:darkcyan;'></i>";
    }
  }
}
