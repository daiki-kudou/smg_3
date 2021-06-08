<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Models\User;
use App\Models\UnknownUser;
use App\Models\Agent;
use App\Models\PreEndUser;
use App\Models\Venue;
use App\Models\PreReservation;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB; //トランザクション用

trait SearchTrait
{
  public function BasicSearch($class, $request)
  {
    $andSearch = $class->where('multiple_reserve_id', 0)->where('status', '<', 2); // マスタのクエリ 
    // フリーワード
    if (!empty($request->search_free)) {
      $andSearch->where(function ($query) use ($request) {
        if (preg_match("/^[0-9]+$/", $request->search_free)) { //数字のみ
          $fixId = $this->idFormatForSearch($request->search_free);
          $query->orWhere('id', 'like', "%{$fixId}%");
          $mobile = User::where("mobile", "LIKE", "%{$request->search_free}%")->pluck("id")->toArray();
          $query->orWhereIn("user_id", $mobile);
          $tel = User::where("tel", "LIKE", "%{$request->search_free}%")->pluck("id")->toArray();
          $query->orWhereIn("user_id", $tel);
        } elseif (preg_match("/^[0-9-_:.]+$/", $request->search_free)) { //日時のみ
          $query->orWhere("reserve_date", "LIKE", $request->search_free);
          $query->orWhere("created_at", "LIKE", $request->search_free);
        } else { //文字列
          $fixId = $this->idFormatForSearch($request->search_free);
          $query->orWhere('id', 'LIKE', "%" . $fixId . "%");
          $venue = Venue::where("name_bldg", "LIKE", "%{$request->search_free}%")->pluck("id")->toArray();
          $query->orWhereIn("venue_id", $venue);
          $user = User::where("company", "LIKE", "%{$request->search_free}%")->pluck("id")->toArray();
          $query->orWhereIn("user_id", $user);
          $user_name = User::where(\DB::raw('CONCAT(first_name, last_name)'), 'like', "%{$request->search_free}%")->pluck('id')->toArray();
          $query->orWhereIn("user_id", $user_name);
          $unknown_user = UnknownUser::where("unknown_user_company", "LIKE", "%{$request->search_free}%")->pluck("pre_reservation_id")->toArray();
          $query->orWhereIn("id", $unknown_user);
          $agent = Agent::where("company", "LIKE", "%{$request->search_free}%")->pluck("id")->toArray();
          $query->orWhereIn("agent_id", $agent);
          $end_user = PreEndUser::where("company", "LIKE", "%{$request->search_free}%")->pluck("pre_reservation_id")->toArray();
          $query->orWhereIn("id", $end_user);
        }
      });
    }

    if (!empty($request->search_id)) {
      $fixId = $this->idFormatForSearch($request->search_id);
      $andSearch->where('id', 'LIKE', "%" . $fixId . "%");
    }

    if (!empty($request->search_created_at)) { // 作成日の検索
      $splitDate = explode(' ~ ', $request->search_created_at);
      $andSearch->whereBetween("created_at", [$splitDate[0], date('Y-m-d', strtotime(Carbon::parse($splitDate[1])->addDays(1)))])->get();
    }

    if (!empty($request->search_date)) { // 利用日
      $splitDate = explode(' ~ ', $request->search_date);
      $andSearch->whereBetween("reserve_date", [$splitDate[0], $splitDate[1]])->get();
    }

    if (!empty($request->search_venue)) { // 利用会場の検索
      $andSearch->where('venue_id', $request->search_venue);
    }

    if (!empty($request->search_user)) { // 会社名団体名
      $user = User::where("company", "LIKE", "%{$request->search_user}%")->pluck("id")->toArray();
      $andSearch->whereIn("user_id", $user);
    }

    if (!empty($request->search_person)) { // 担当者氏名
      $user = User::where(\DB::raw('CONCAT(first_name, last_name)'), 'like', "%{$request->search_person}%")->pluck('id')->toArray();
      $andSearch->whereIn("user_id", $user);
    }

    if (!empty($request->search_mobile)) { // 携帯
      $user = User::where("mobile", "LIKE", "%{$request->search_mobile}%")->pluck("id")->toArray();
      $andSearch->whereIn("user_id", $user);
    }

    if (!empty($request->search_tel)) { // 固定電話	
      $user = User::where("tel", "LIKE", "%{$request->search_tel}%")->pluck("id")->toArray();
      $andSearch->whereIn("user_id", $user);
    }

    if (!empty($request->search_unkown_user)) { // 会社名・団体名（仮）unknown_user
      $unknown_user = UnknownUser::where("unknown_user_company", "LIKE", "%{$request->search_unkown_user}%")->pluck("pre_reservation_id")->toArray();
      $andSearch->whereIn("id", $unknown_user);
    }

    if (!empty($request->search_agent)) { // 仲介会社
      $andSearch->where('agent_id', $request->search_agent);
    }

    // エンドユーザー
    if (!empty($request->search_end_user)) { // 仲介会社
      $end_user = PreEndUser::where("company", "LIKE", "%{$request->search_end_user}%")->pluck("pre_reservation_id")->toArray();
      $andSearch->whereIn("id", $end_user);
    }

    // 最終return
    return [$andSearch->orderBy('id', 'desc')->get(), $andSearch->count()];
  }

  public function MultipleSearch($class, $request)
  {
    $result = $class;
    if (!empty($request->search_free)) {
      if (preg_match("/^[0-9]+$/", $request->search_free)) { //数字のみ
        $fixId = $this->idFormatForSearch($request->search_free);
        $result = $class->orWhere('id', 'like', "%{$fixId}%");

        $mobile = User::where("mobile", "LIKE", "%{$request->search_free}%")->pluck("id")->toArray();
        $pre_res = PreReservation::whereIn("user_id", $mobile)->pluck("multiple_reserve_id")->toArray();
        $result = $class->orWhereIn("id", $pre_res);

        $tel = User::where("tel", "LIKE", "%{$request->search_free}%")->pluck("id")->toArray();
        $pre_res = PreReservation::whereIn("user_id", $tel)->pluck("multiple_reserve_id")->toArray();
        $result = $class->orWhereIn("id", $pre_res);
      } elseif (preg_match("/^[0-9-_:.]+$/", $request->search_free)) { //日時のみ
        $created = PreReservation::where("created_at", "LIKE", "%{$request->search_free}%")->pluck("multiple_reserve_id")->toArray();
        $result = $class->orWhereIn("id", $created);
      } else { //文字列
        $company = User::where("company", "LIKE", "%{$request->search_free}%")->orWhere(\DB::raw('CONCAT(first_name, last_name)'), 'like', "%{$request->search_free}%")->pluck("id")->toArray();
        $pre_res_c = PreReservation::whereIn("user_id", $company)->pluck("multiple_reserve_id")->toArray();
        $result = $class->orWhereIn("id", $pre_res_c);

        $unknown_user = UnknownUser::where("unknown_user_company", "LIKE", "%{$request->search_free}%")->pluck("pre_reservation_id")->toArray();
        $pre_res = PreReservation::whereIn("id", $unknown_user)->pluck("multiple_reserve_id")->toArray();
        $result = $class->orWhereIn("id", $pre_res);

        $agent = Agent::where("company", "LIKE", "%{$request->search_free}%")->pluck("id")->toArray();
        $pre_res = PreReservation::whereIn("agent_id", $agent)->pluck("multiple_reserve_id")->toArray();
        $result = $class->orWhereIn("id", $pre_res);

        $end_user = PreEndUser::where("company", "LIKE", "%{$request->search_free}%")->pluck("pre_reservation_id")->toArray();
        $pre_res = PreReservation::whereIn("id", $end_user)->pluck("multiple_reserve_id")->toArray();
        $result = $class->orWhereIn("id", $pre_res);
      }
    }

    if (!empty($request->search_id)) {
      $fixId = $this->idFormatForSearch($request->search_id);
      $result = $class->where("id", "LIKE", "%{$fixId}%");
    }

    if (!empty($request->search_created_at)) { // 作成日の検索
      $splitDate = explode(' ~ ', $request->search_created_at);
      $result = $class->whereBetween("created_at", [$splitDate[0], date('Y-m-d', strtotime(Carbon::parse($splitDate[1])->addDays(1)))]);
    }

    if (!empty($request->search_company)) { // 会社名
      $user = User::where("company", "LIKE", "%{$request->search_company}%")->pluck("id")->toArray();
      $pre_res = PreReservation::whereIn("user_id", $user)->pluck("multiple_reserve_id")->toArray();
      $result = $class->whereIn("id", $pre_res);
    }

    if (!empty($request->search_person)) { // 担当者氏名
      $user = User::where(\DB::raw('CONCAT(first_name, last_name)'), 'like', "%{$request->search_person}%")->pluck('id')->toArray();
      $pre_res = PreReservation::whereIn("user_id", $user)->pluck("multiple_reserve_id")->toArray();
      $result = $class->whereIn("id", $pre_res);
    }

    if (!empty($request->search_mobile)) { // 携帯
      $user = User::where("mobile", "LIKE", "%{$request->search_mobile}%")->pluck("id")->toArray();
      $pre_res = PreReservation::whereIn("user_id", $user)->pluck("multiple_reserve_id")->toArray();
      $result = $class->whereIn("id", $pre_res);
    }

    if (!empty($request->search_tel)) {
      $user = User::where("tel", "LIKE", "%{$request->search_tel}%")->pluck("id")->toArray();
      $pre_res = PreReservation::whereIn("user_id", $user)->pluck("multiple_reserve_id")->toArray();
      $result = $class->whereIn("id", $pre_res);
    }

    if (!empty($request->search_unkown_user)) {
      $unknown_user = UnknownUser::where("unknown_user_company", "LIKE", "%{$request->search_unkown_user}%")->pluck("pre_reservation_id")->toArray();
      $pre_res = PreReservation::whereIn("id", $unknown_user)->pluck("multiple_reserve_id")->toArray();
      $result = $class->whereIn("id", $pre_res);
    }

    if (!empty($request->search_agent)) { // 
      $agent = Agent::where("id", "LIKE", "%{$request->search_agent}%")->pluck("id")->toArray();
      $pre_res = PreReservation::whereIn("agent_id", $agent)->pluck("multiple_reserve_id")->toArray();
      $result = $class->whereIn("id", $pre_res);
    }

    if (!empty($request->search_end_user)) {
      $end_user = PreEndUser::where("company", "LIKE", "%{$request->search_end_user}%")->pluck("pre_reservation_id")->toArray();
      $pre_res = PreReservation::whereIn("id", $end_user)->pluck("multiple_reserve_id")->toArray();
      $result = $class->whereIn("id", $pre_res);
    }

    return $result->orderBy('id', 'desc')->get();
  }


  public function SimpleWhere($request, $item, $masterQuery, $targetColumn)
  {
    if (!empty($request->{$item})) {
      $masterQuery->where($targetColumn, $request->{$item});
    }
  }

  public function SimpleWhereLike($request, $item, $masterQuery, $targetColumn)
  {
    if (!empty($request->{$item})) {
      $masterQuery->where($targetColumn, 'LIKE', "%" . $request->{$item} . "%");
    }
  }

  public function SimpleWhereHas($item, $masterQuery, $targetRelation, $targetColumn)
  {
    if (!empty($item)) {
      $masterQuery->whereHas($targetRelation, function ($query) use ($item, $targetColumn) {
        $query->where($targetColumn, 'LIKE', "%{$item}%");
      });
    }
  }

  public function SplitDate($date)
  {
    $arrays = explode(' - ', $date);
    $start = new Carbon($arrays[0]);
    $finish = new Carbon($arrays[1]);
    $diff = $start->diffInDays($finish);
    $dateArrays = [date("Y-m-d", strtotime($start))];
    $target = "";
    for ($i = 0; $i < $diff; $i++) {
      $target = $start->addDays(1);
      $target = date("Y-m-d", strtotime($target));
      $dateArrays[] = $target;
    }
    return [$dateArrays];
  }

  public function WhereInSearch($returnQuery, $targetColumn, $request, $inputName, $LIKE = 0)
  {
    if ($LIKE === 0) {
      foreach ($this->SplitDate($request->$inputName) as $key => $value) {
        $returnQuery->whereIn($targetColumn, $value);
      }
    } else {
      foreach ($this->SplitDate($request->$inputName) as $key => $value) {
        $returnQuery->whereDate($targetColumn, 'LIKE', "%{$value}%");
      }
    }
  }

  public function idFormatForSearch($num)
  {
    $result = $num;
    if (substr($num, 0, 5) == "00000") {
      $result = str_replace("00000", "", $num);
    } elseif (substr($num, 0, 4) == "0000") {
      $result = str_replace("0000", "", $num);
    } elseif (substr($num, 0, 3) == "000") {
      $result = str_replace("000", "", $num);
    } elseif (substr($num, 0, 2) == "00") {
      $result = str_replace("00", "", $num);
    }
    return $result;
  }
}
