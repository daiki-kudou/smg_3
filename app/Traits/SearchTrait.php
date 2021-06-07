<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Models\User;
use App\Models\UnknownUser;
use App\Models\Agent;
use App\Models\PreEndUser;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB; //トランザクション用



trait SearchTrait
{
  public function BasicSearch($class, $request)
  {
    $andSearch = $class->where('multiple_reserve_id', 0); // マスタのクエリ 
    // フリーワード
    if (!empty($request->search_free)) {
      $andSearch->where(function ($query) use ($request) {
        // $query->whereHas('user', function ($query) use ($request) {
        //   $query->where('first_name', 'LIKE', "%{$request->search_free}%");
        //   $query->orWhere('last_name', 'LIKE', "%{$request->search_free}%");
        //   $query->orWhere(DB::raw('CONCAT(first_name, last_name)'), 'like', '%' . $request->search_free . '%');
        //   $query->orWhere('company', 'LIKE', "%{$request->search_free}%");
        //   $query->orWhere('mobile', 'LIKE', "%{$request->search_free}%");
        //   $query->orWhere('tel', 'LIKE', "%{$request->search_free}%");
        // });
        // $query->orWhereHas('venue', function ($query) use ($request) {
        //   $query->where('name_bldg', 'LIKE', "%{$request->search_free}%");
        //   $query->orWhere('name_venue', 'LIKE', "%{$request->search_free}%");
        //   $query->orWhere(DB::raw('CONCAT(name_bldg, name_venue)'), 'like', "%{$request->search_free}%");
        // });
        // $query->orWhereHas('agent', function ($query) use ($request) {
        //   $query->where('person_firstname', 'LIKE', "%{$request->search_free}%");
        //   $query->orWhere('person_lastname', 'LIKE', "%{$request->search_free}%");
        //   $query->orWhere(DB::raw('CONCAT(person_firstname, person_lastname)'), 'like', '%' . $request->search_free . '%');
        //   $query->orWhere('company', 'LIKE', "%{$request->search_free}%");
        //   $query->orWhere('person_mobile', 'LIKE', "%{$request->search_free}%");
        //   $query->orWhere('person_tel', 'LIKE', "%{$request->search_free}%");
        // });
        // $query->orWhereHas('unknown_user', function ($query) use ($request) {
        //   $query->where('unknown_user_company', 'LIKE', "%{$request->search_free}%");
        // });
        // $query->orWhereHas('pre_enduser', function ($query) use ($request) {
        //   $query->where('company', 'LIKE', "%{$request->search_free}%");
        // });
        // $query->orWhere("id", "LIKE", "%{$request->search_free}%"); //id
        // $query->orWhere("enter_time", "LIKE", "%{$request->search_free}%");
        // $query->orWhere("leave_time", "LIKE", "%{$request->search_free}%");

        if (preg_match("/^[0-9]+$/", $request->search_free)) { //数字のみ
          $fixId = $this->idFormatForSearch($request->search_free);
          $query->orWhere('id', 'like', "%{$fixId}%");
          $mobile = User::where("mobile", "LIKE", "%{$request->search_free}%")->pluck("id")->toArray();
          $query->orWhereIn("user_id", $mobile);
          $tel = User::where("tel", "LIKE", "%{$request->search_free}%")->pluck("id")->toArray();
          $query->orWhereIn("user_id", $tel);
        } elseif (preg_match("/^[0-9-_:.]+$/", $request->search_free)) { //日時のみ
        } else { //文字列
        }
      });
    }

    // $this->SimpleWhereLike($request, "search_id", $andSearch, "id"); // id検索
    if (!empty($request->search_id)) {
      $fixId = $this->idFormatForSearch($request->search_id);
      $andSearch->where('id', 'LIKE', "%" . $fixId . "%");
    }

    if (!empty($request->search_created_at)) { // 作成日の検索
      $splitDate = explode(' - ', $request->search_created_at);
      $s_carbon = Carbon::parse($splitDate[1]);
      $add_day = $s_carbon->addDays(1);
      $andSearch->whereBetween("created_at", [$splitDate[0], date('Y-m-d', strtotime($add_day))])->get();
    }

    if (!empty($request->search_date)) { // 利用日
      $splitDate = explode(' - ', $request->search_date);
      $s_carbon = Carbon::parse($splitDate[1]);
      $add_day = $s_carbon->addDays(1);
      $f_start = date(('Y-m-d'), strtotime($splitDate[0]));
      $f_finish = date(('Y-m-d'), strtotime($splitDate[1]));
      $andSearch->whereBetween("reserve_date", [$f_start, $f_finish])->get();
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
      $result = $class->where("id", "LIKE", "%{$request->search_free}%")
        ->orWhereDate("created_at", date('Y-m-d', strtotime($request->search_free)))
        ->orWhereHas('pre_reservations.user', function ($query) use ($request) {
          $query->where('first_name', 'LIKE', "%{$request->search_free}%");
          $query->orWhere('last_name', 'LIKE', "%{$request->search_free}%");
          $query->orWhere(DB::raw('CONCAT(first_name, last_name)'), 'like', '%' . $request->search_free . '%');
          $query->orWhere('company', 'LIKE', "%{$request->search_free}%");
          $query->orWhere('mobile', 'LIKE', "%{$request->search_free}%");
          $query->orWhere('tel', 'LIKE', "%{$request->search_free}%");
        })->orWhereHas('pre_reservations.agent', function ($query) use ($request) {
          $query->where('person_firstname', 'LIKE', "%{$request->search_free}%");
          $query->orWhere('person_lastname', 'LIKE', "%{$request->search_free}%");
          $query->orWhere(DB::raw('CONCAT(person_firstname, person_lastname)'), 'like', '%' . $request->search_free . '%');
          $query->orWhere('company', 'LIKE', "%{$request->search_free}%");
          $query->orWhere('person_mobile', 'LIKE', "%{$request->search_free}%");
          $query->orWhere('person_tel', 'LIKE', "%{$request->search_free}%");
        })->orWhereHas('pre_reservations.unknown_user', function ($query) use ($request) {
          $query->where('unknown_user_company', 'LIKE', "%{$request->search_free}%");
        })->orWhereHas('pre_reservations.pre_enduser', function ($query) use ($request) {
          $query->where('company', 'LIKE', "%{$request->search_free}%");
        });
    }

    if (!empty($request->search_id)) {
      $result = $class->where("id", "LIKE", "%{$request->search_id}%");
    }

    if (!empty($request->search_created_at)) { // 作成日の検索
      $splitDate = explode(' - ', $request->search_created_at);
      $s_carbon = Carbon::parse($splitDate[1]);
      $add_day = $s_carbon->addDays(1);
      $result = $class->whereBetween("created_at", [$splitDate[0], date('Y-m-d', strtotime($add_day))]);
    }

    if (!empty($request->search_company)) { // 担当者氏名
      $result = $class->whereHas('pre_reservations.user', function ($query) use ($request) {
        $query->where('company', 'LIKE', "%{$request->search_company}%");
      });
    }

    if (!empty($request->search_person)) { // 担当者氏名
      $result = $class->whereHas('pre_reservations.user', function ($query) use ($request) {
        $query->where('first_name', 'LIKE', "%{$request->search_person}%");
        $query->orWhere('last_name', 'LIKE', "%{$request->search_person}%");
        $query->orWhere(DB::raw('CONCAT(first_name, last_name)'), 'like', '%' . $request->search_person . '%');
      })->orWhereHas('pre_reservations.agent', function ($query) use ($request) {
        $query->where('person_firstname', 'LIKE', "%{$request->search_person}%");
        $query->orWhere('person_lastname', 'LIKE', "%{$request->search_person}%");
        $query->orWhere(DB::raw('CONCAT(person_firstname, person_lastname)'), 'like', '%' . $request->search_person . '%');
      });
    }

    if (!empty($request->search_mobile)) { // 携帯
      $result = $class->whereHas('pre_reservations.user', function ($query) use ($request) {
        $query->where('mobile', 'LIKE', "%{$request->search_mobile}%");
      })->orWhereHas('pre_reservations.agent', function ($query) use ($request) {
        $query->where('person_mobile', 'LIKE', "%{$request->search_mobile}%");
      });
    }

    if (!empty($request->search_tel)) { // 固定電話
      $result = $class->whereHas('pre_reservations.user', function ($query) use ($request) {
        $query->where('tel', 'LIKE', "%{$request->search_tel}%");
      })->orWhereHas('pre_reservations.agent', function ($query) use ($request) {
        $query->where('person_tel', 'LIKE', "%{$request->search_tel}%");
      });
    }

    if (!empty($request->search_unkown_user)) { // 固定電話
      $result = $class->whereHas('pre_reservations.unknown_user', function ($query) use ($request) {
        $query->where('unknown_user_company', 'LIKE', "%{$request->search_unkown_user}%");
      });
    }

    if (!empty($request->search_agent)) { // 固定電話
      $result = $class->whereHas('pre_reservations.agent', function ($query) use ($request) {
        $query->where('id', 'LIKE', "%{$request->search_agent}%");
      });
    }

    if (!empty($request->search_end_user)) { // 固定電話
      $result = $class->whereHas('pre_reservations.pre_enduser', function ($query) use ($request) {
        $query->where('company', 'LIKE', "%{$request->search_end_user}%");
      });
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
