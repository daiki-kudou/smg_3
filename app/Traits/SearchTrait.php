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
    // 利用日の検索
    if (!empty($request->search_date)) {
      $this->WhereInSearch($andSearch, 'reserve_date', $request, "search_date");
    }
    // 作成日の検索
    if (!empty($request->search_created_at)) {
      $this->WhereInSearch($andSearch, 'created_at', $request, "search_created_at", 1);
    }
    // 利用会場の検索
    if (!empty($request->search_venue)) {
      $andSearch->where('venue_id', $request->search_venue);
    }
    // 会社名団体名
    if (!empty($request->search_user)) {
      $andSearch->whereHas('user', function ($query) use ($request) {
        $query->where('company', 'LIKE', "%$request->search_user%");
      });
    }
    // 担当者指名
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
    if (!empty($request->search_mobile)) {
      $andSearch->whereHas('user', function ($query) use ($request) {
        $query->where('mobile', 'LIKE', "%$request->search_mobile%");
      });
    }
    // 電話
    if (!empty($request->search_tel)) {
      $andSearch->whereHas('user', function ($query) use ($request) {
        $query->where('tel', 'LIKE', "%$request->search_tel%");
      });
    }
    // 会社名・団体名（仮）unknown_user
    if (!empty($request->search_unkown_user)) {
      $andSearch->whereHas('unknown_user', function ($query) use ($request) {
        $query->where('unknown_user_company', 'LIKE', "%$request->search_unkown_user%");
      });
    }
    // 仲介会社
    if (!empty($request->search_agent)) {
      $andSearch->where('agent_id', $request->search_agent);
    }
    // エンドユーザー
    if (!empty($request->search_end_user)) {
      $andSearch->whereHas('pre_enduser', function ($query) use ($request) {
        $query->where('company', 'LIKE', "%$request->search_end_user%");
      });
    }
    // フリーワード検索
    if (!empty($request->search_free)) {
      $andSearch->orWhere('venue_id', $request->search_free);
      // $andSearch->orWhere('created_at', $request->search_free);
      // $andSearch->orWhere('reserve_date', $request->search_free);
      $andSearch->orWhere('enter_time', $request->search_free);
      $andSearch->orWhere('leave_time', $request->search_free);
      $andSearch->whereHas('venue', function ($query) use ($request) {
        $query->where('name_area', 'LIKE', "%$request->search_free%");
        $query->orWhere('name_bldg', 'LIKE', "%$request->search_free%");
        $query->orWhere('name_venue', 'LIKE', "%$request->search_free%");
        $query->orWhere(DB::raw('CONCAT(name_area, name_bldg,name_venue)'), 'like', '%' . $request->search_free . '%');
      });
      $andSearch->whereHas('user', function ($query) use ($request) {
        $query->where('company', 'LIKE', "%$request->search_free%");
        $query->orWhere('first_name', 'LIKE', "%$request->search_free%");
        $query->orWhere('last_name', 'LIKE', "%$request->search_free%");
        $query->orWhere('mobile', 'LIKE', "%$request->search_free%");
        $query->orWhere('tel', 'LIKE', "%$request->search_free%");
        $query->orWhere(DB::raw('CONCAT(first_name, last_name)'), 'like', '%' . $request->search_free . '%');
      });
      $andSearch->whereHas('unknown_user', function ($query) use ($request) {
        $query->where('unknown_user_company', 'LIKE', "%$request->search_free%");
      });
      $andSearch->orWhere('agent_id', $request->search_free);
      $andSearch->whereHas('pre_enduser', function ($query) use ($request) {
        $query->where('company', 'LIKE', "%$request->search_free%");
      });
    }



    // 最終return
    return $andSearch->paginate(30);
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
