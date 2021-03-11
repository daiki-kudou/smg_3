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
    // マスタのクエリ
    $andSearch = $class->where('multiple_reserve_id', '=', 0);
    // id検索
    $this->SimpleWhereLike($request, "search_id", $andSearch, "id");
    // 利用日の検索
    if (!empty($request->search_date)) {
      $this->WhereInSearch($andSearch, 'reserve_date', $request, "search_date");
    }
    // 作成日の検索
    if (!empty($request->search_created_at)) {
      $this->WhereInSearch($andSearch, 'created_at', $request, "search_created_at", 1);
    }
    // 利用会場の検索
    $this->SimpleWhere($request, "search_venue", $andSearch, "venue_id");

    // 会社名団体名
    $this->SimpleWhereHas($request->search_user, $andSearch, "user", "company");
    // 担当者氏名
    if (!empty($request->search_person)) {
      $andSearch->whereHas('user', function ($query) use ($request) {
        $query->where('first_name', 'LIKE', "%$request->search_person%");
        $query->orWhere('last_name', 'LIKE', "%$request->search_person%");
        $query->orWhere(DB::raw('CONCAT(first_name, last_name)'), 'like', '%' . $request->search_person . '%');
        //https://qiita.com/tkek321/items/cb807751943ab5f873cd
        // こちらを参照
      });
    }
    // 携帯
    $this->SimpleWhereHas($request->search_mobile, $andSearch, "user", "mobile");
    // 電話
    $this->SimpleWhereHas($request->search_tel, $andSearch, "user", "tel");
    // 会社名・団体名（仮）unknown_user
    $this->SimpleWhereHas($request->search_unkown_user, $andSearch, "unknown_user", "unknown_user_company");
    // 仲介会社
    $this->SimpleWhere($request, "search_agent", $andSearch, "agent_id");
    // エンドユーザー
    $this->SimpleWhereHas($request->search_end_user, $andSearch, "pre_enduser", "company");

    // フリーワード検索
    // 以下参照
    // https://qiita.com/Hwoa/items/542456b63e51895f9a55
    if (!empty($request->search_free)) {
      $andSearch->where(function ($query) use ($request) {
        $query->orWhere('id', 'LIKE', "%$request->search_free%")
          ->orWhere('created_at', 'LIKE', "%$request->search_free%")
          ->orWhere('enter_time', 'LIKE', "%$request->search_free%")
          ->orWhere('leave_time', 'LIKE', "%$request->search_free%")
          ->whereHas("user", function ($query2) use ($request) {
            $query2->orWhere("first_name","LIKE","%$request->search_free%")
          });
      });

      // $andSearch->where('id', "LIKE", "%$request->search_free%");
      // $andSearch->orWhere('created_at', "LIKE", "%$request->search_free%");
      // // $andSearch->orWhere('created_at', $request->search_free);
      // // $andSearch->orWhere('reserve_date', $request->search_free);
      // $andSearch->orWhere('enter_time', $request->search_free);
      // $andSearch->orWhere('leave_time', $request->search_free);
      // $andSearch->whereHas('venue', function ($query) use ($request) {
      //   $query->where('name_area', 'LIKE', "%$request->search_free%");
      //   $query->orWhere('name_bldg', 'LIKE', "%$request->search_free%");
      //   $query->orWhere('name_venue', 'LIKE', "%$request->search_free%");
      //   $query->orWhere(DB::raw('CONCAT(name_area, name_bldg,name_venue)'), 'like', '%' . $request->search_free . '%');
      // });
      // $andSearch->whereHas('user', function ($query) use ($request) {
      //   $query->where('company', 'LIKE', "%$request->search_free%");
      //   $query->orWhere('first_name', 'LIKE', "%$request->search_free%");
      //   $query->orWhere('last_name', 'LIKE', "%$request->search_free%");
      //   $query->orWhere('mobile', 'LIKE', "%$request->search_free%");
      //   $query->orWhere('tel', 'LIKE', "%$request->search_free%");
      //   $query->orWhere(DB::raw('CONCAT(first_name, last_name)'), 'like', '%' . $request->search_free . '%');
      // });
      // $andSearch->whereHas('unknown_user', function ($query) use ($request) {
      //   $query->where('unknown_user_company', 'LIKE', "%$request->search_free%");
      // });
      // $andSearch->orWhere('agent_id', $request->search_free);
      // $andSearch->whereHas('pre_enduser', function ($query) use ($request) {
      //   $query->where('company', 'LIKE', "%$request->search_free%");
      // });
    }
    // 最終return
    return $andSearch->paginate(30);
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
        $value = current($value);
        $returnQuery->where($targetColumn, 'LIKE', "%$value%");
      }
    }
  }
}
