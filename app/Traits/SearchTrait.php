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
    $andSearch = $class->where('multiple_reserve_id', '=', 0); // マスタのクエリ 

    $this->SimpleWhereLike($request, "search_id", $andSearch, "id"); // id検索
    if (!empty($request->search_date)) { // 利用日の検索
      $this->WhereInSearch($andSearch, 'reserve_date', $request, "search_date");
    }

    if (!empty($request->search_created_at)) { // 作成日の検索
      foreach ($this->SplitDate($request->search_created_at) as $key => $value) {
        $andSearch->orWhereDate("created_at", "=", current($value));
      }
    }

    $this->SimpleWhere($request, "search_venue", $andSearch, "venue_id"); // 利用会場の検索
    $this->SimpleWhereHas($request->search_user, $andSearch, "user", "company"); // 会社名団体名

    if (!empty($request->search_person)) { // 担当者氏名
      $andSearch->whereHas('user', function ($query) use ($request) {
        $query->where('first_name', 'LIKE', "%$request->search_person%");
        $query->orWhere('last_name', 'LIKE', "%$request->search_person%");
        $query->orWhere(DB::raw('CONCAT(first_name, last_name)'), 'like', '%' . $request->search_person . '%');
        //https://qiita.com/tkek321/items/cb807751943ab5f873cd
        // こちらを参照
      });
    }
    $this->SimpleWhereHas($request->search_mobile, $andSearch, "user", "mobile"); // 携帯
    $this->SimpleWhereHas($request->search_tel, $andSearch, "user", "tel"); // 電話
    $this->SimpleWhereHas($request->search_unkown_user, $andSearch, "unknown_user", "unknown_user_company"); // 会社名・団体名（仮）unknown_user
    $this->SimpleWhere($request, "search_agent", $andSearch, "agent_id"); // 仲介会社
    $this->SimpleWhereHas($request->search_end_user, $andSearch, "pre_enduser", "company"); // エンドユーザー
    // 最終return
    return $andSearch->paginate(30);
  }





  public function MultipleSearch($class, $request)
  {

    $result = $class::query();

    $this->SimpleWhere($request, "search_id", $result, "id");

    $joinTable = $class->join("pre_reservations", "multiple_reserves.id", "pre_reservations.multiple_reserve_id");


    return $result->paginate(30);
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
        $returnQuery->whereDate($targetColumn, 'LIKE', "%$value%");
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
