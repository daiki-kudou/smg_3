<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Carbon\Carbon;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB; //トランザクション用

// 参照　https://qiita.com/t_n/items/1c9a239da4cf938ae0a8
use Illuminate\Pagination\LengthAwarePaginator; //カスタムページャー


trait PaginatorTrait
{
  public function customPaginate($collection, $pageCount, $request)
  {
    // LengthAwarePaginatorの作成
    $paginator = new LengthAwarePaginator(
      $collection->forPage($request->page, $pageCount), // 現在のページのsliceした情報(現在のページ, 1ページあたりの件数)
      $collection->count(), // 総件数
      $pageCount,
      null, // 現在のページ(ページャーの色がActiveになる)
      ['path' => $request->url()] // ページャーのリンクをOptionのpathで指定
    );
    return $paginator;
  }
}
