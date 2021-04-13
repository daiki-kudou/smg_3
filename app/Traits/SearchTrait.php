<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Models\User;

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
        $query->whereHas('user', function ($query) use ($request) {
          $query->where('first_name', 'LIKE', "%{$request->search_free}%");
          $query->orWhere('last_name', 'LIKE', "%{$request->search_free}%");
          $query->orWhere(DB::raw('CONCAT(first_name, last_name)'), 'like', '%' . $request->search_free . '%');
          $query->orWhere('company', 'LIKE', "%{$request->search_free}%");
          $query->orWhere('mobile', 'LIKE', "%{$request->search_free}%");
          $query->orWhere('tel', 'LIKE', "%{$request->search_free}%");
        });
        $query->orWhereHas('venue', function ($query) use ($request) {
          $query->where('name_bldg', 'LIKE', "%{$request->search_free}%");
          $query->orWhere('name_venue', 'LIKE', "%{$request->search_free}%");
          $query->orWhere(DB::raw('CONCAT(name_bldg, name_venue)'), 'like', "%{$request->search_free}%");
        });
        $query->orWhereHas('agent', function ($query) use ($request) {
          $query->where('person_firstname', 'LIKE', "%{$request->search_free}%");
          $query->orWhere('person_lastname', 'LIKE', "%{$request->search_free}%");
          $query->orWhere(DB::raw('CONCAT(person_firstname, person_lastname)'), 'like', '%' . $request->search_free . '%');
          $query->orWhere('company', 'LIKE', "%{$request->search_free}%");
          $query->orWhere('person_mobile', 'LIKE', "%{$request->search_free}%");
          $query->orWhere('person_tel', 'LIKE', "%{$request->search_free}%");
        });
        $query->orWhereHas('unknown_user', function ($query) use ($request) {
          $query->where('unknown_user_company', 'LIKE', "%{$request->search_free}%");
        });
        $query->orWhereHas('pre_enduser', function ($query) use ($request) {
          $query->where('company', 'LIKE', "%{$request->search_free}%");
        });
        $query->orWhere("id", "LIKE", "%{$request->search_free}%"); //id
        $query->orWhere("enter_time", "LIKE", "%{$request->search_free}%");
        $query->orWhere("leave_time", "LIKE", "%{$request->search_free}%");

        $query->orWhereDate("reserve_date", date('Y-m-d', strtotime($request->search_free)));
        $query->orWhereDate("created_at",  date('Y-m-d', strtotime($request->search_free)));
      });
    }

    $this->SimpleWhereLike($request, "search_id", $andSearch, "id"); // id検索

    if (!empty($request->search_date)) { // 利用日
      $splitDate = explode(' - ', $request->search_date);
      $s_carbon = Carbon::parse($splitDate[1]);
      $add_day = $s_carbon->addDays(1);
      $f_start = date(('Y-m-d'), strtotime($splitDate[0]));
      $f_finish = date(('Y-m-d'), strtotime($splitDate[1]));
      $andSearch->whereBetween("reserve_date", [$f_start, $f_finish])->get();
    }

    if (!empty($request->search_created_at)) { // 作成日の検索
      $splitDate = explode(' - ', $request->search_created_at);
      $s_carbon = Carbon::parse($splitDate[1]);
      $add_day = $s_carbon->addDays(1);
      $andSearch->whereBetween("created_at", [$splitDate[0], date('Y-m-d', strtotime($add_day))])->get();
    }

    $this->SimpleWhere($request, "search_venue", $andSearch, "venue_id"); // 利用会場の検索
    $this->SimpleWhereHas($request->search_user, $andSearch, "user", "company"); // 会社名団体名

    if (!empty($request->search_person)) { // 担当者氏名
      $andSearch->whereHas('user', function ($query) use ($request) {
        $query->where('first_name', 'LIKE', "%{$request->search_person}%");
        $query->orWhere('last_name', 'LIKE', "%{$request->search_person}%");
        $query->orWhere(DB::raw('CONCAT(first_name, last_name)'), 'like', '%' . $request->search_person . '%'); //https://qiita.com/tkek321/items/cb807751943ab5f873cd
      });
    }

    $this->SimpleWhereHas($request->search_mobile, $andSearch, "user", "mobile"); // 携帯
    $this->SimpleWhereHas($request->search_tel, $andSearch, "user", "tel"); // 電話
    if (!empty($request->search_tel)) {
      $andSearch->orWhereHas('agent', function ($query) use ($request) {
        $query->where('person_tel', 'LIKE', "%{$request->search_tel}%");
      });
    }
    $this->SimpleWhereHas($request->search_unkown_user, $andSearch, "unknown_user", "unknown_user_company"); // 会社名・団体名（仮）unknown_user
    $this->SimpleWhere($request, "search_agent", $andSearch, "agent_id"); // 仲介会社
    $this->SimpleWhereHas($request->search_end_user, $andSearch, "pre_enduser", "company"); // エンドユーザー

    // 最終return
    return [$andSearch->orderBy('id', 'desc')->paginate(30), $andSearch->count()];
  }

  public function MultipleSearch($class, $request)
  {
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
      });
      $result = $class->whereHas('pre_reservations.agent', function ($query) use ($request) {
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


    return $result->orderBy('id', 'desc')->paginate(30);
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
}













    // フリーワード検索
    // 以下参照
    // https://qiita.com/Hwoa/items/542456b63e51895f9a55


    // $andSearch->where(function ($query) use ($request) {
    //   $query->orWhere('id', 'LIKE', "%$request->search_free%")
    //     ->orWhereDate('created_at', 'LIKE', "%$request->search_free%")
    //     ->orWhere('enter_time', 'LIKE', "%$request->search_free%")
    //     ->orWhere('leave_time', 'LIKE', "%$request->search_free%")
    //     ->orWhere('in_charge', 'LIKE', "%$request->search_free%")
    //     ->orWhere('tel', 'LIKE', "%$request->search_free%")
    //     ->orWhereHas('user', function ($query) use ($request) {
    //       $query->where('first_name', 'LIKE', "%$request->search_free%");
    //       $query->orWhere('last_name', 'LIKE', "%$request->search_free%");
    //       $query->orWhere(DB::raw('CONCAT(first_name, last_name)'), 'LIKE', "%$request->search_person%");
    //     })->orWhereHas('agent', function ($query) use ($request) {
    //       $query->where('person_firstname', 'LIKE', "%$request->search_free%");
    //       $query->orWhere('person_lastname', 'LIKE', "%$request->search_free%");
    //       $query->orWhere(DB::raw('CONCAT(person_firstname, person_lastname)'), 'LIKE', "%$request->search_person%");
    //     });
    // });
    // dd($andSearch->toSql(), $andSearch->getBindings());
