@extends('layouts.admin.app')
@section('content')

<link href="{{ asset('/css/template.css') }}" rel="stylesheet">


<div class="container-field mt-3">
  <div class="float-right">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active"><a href="######">ホーム</a> >
          売上・請求情報
        </li>
      </ol>
    </nav>
  </div>

  <h2 class="mt-3 mb-3">売上・請求情報</h2>
  <hr>
</div>


<!-- 検索--------------------------------------- -->
<div class="search-wrap">
  <table class="table table-bordered">
    <tbody>
      <tr>
        <th class="search_item_name"><label for="bulkid">予約一括ID</label>
        <td class="text-right">
          <input type="text" name="bulkid" class="form-control" id="bulkid">
        </td>
        <th class="search_item_name"><label for="id">予約ID</label></th>
        <td>
          <input type="text" name="id" class="form-control" id="id">
        </td>
      </tr>
      <tr>
        <th class="search_item_name"><label for="date">利用日</label></th>
        <td class="text-right form-group hasDatepicker">
          <input type="date" class="form-control hasDatepicker" id="">
        </td>
        <th class="search_item_name"><label for="venue">利用会場</label></th>
        <td class="text-right">
          <dd>
            <select class="form-control select2" name="venue">
              <option>テスト会場A</option>
              <option>テスト会場B</option>
              <option>テスト会場C</option>
            </select>
        </td>
      </tr>
      <tr>
        <th class="search_item_name"><label for="customer">顧客ID</label></th>
        <td>
          <input type="text" name="customer" class="form-control">
        </td>
        <th class="search_item_name"><label for="company">会社名・団体名</label></th>
        <td class="text-right">
          <input type="text" name="company" class="form-control" id="company">
        </td>
      </tr>
      <tr>
        <th class="search_item_name"><label for="person">担当者氏名</label></th>
        <td class="text-right">
          <input type="text" name="person" class="form-control" id="person">
        </td>
        <th class="search_item_name"><label for="agent">仲介会社</label></th>
        <td class="text-right">
          <select class="form-control select2" name="agent">
            <option>スペースマーケット</option>
            <option>スペースマーケット</option>
            <option>スペースマーケット</option>
          </select>
        </td>
      </tr>
      <tr>
        <th class="search_item_name"><label for="enduser">エンドユーザー</label></th>
        <td class="text-right">
          <input type="text" name="enduser" class="form-control" id="enduser">
        </td>
        <th class="search_item_name"><label for="sum">総額</label></th>
        <td>
          <input type="text" name="sum" class="form-control">
        </td>
      </tr>
      <tr>
        <th class="search_item_name"><label for="paydue">支払期日</label></th>
        <td class="text-right form-group">
          <input type="date" class="form-control float-right" id="paydue">
        </td>
        <th class="search_item_name"><label for="billStatus">売上区分</label></th>
        <td>
          <ul class="search_category">
            <li>
              <input type="checkbox">
              <label for="checkboxPrimary1">会場</label>
            </li>
            <li>
              <input type="checkbox">
              <label for="checkboxPrimary1">キャンセル</label>
            </li>
            <li>
              <input type="checkbox">
              <label for="checkboxPrimary1">追加請求</label>
            </li>
          </ul>
        </td>
      </tr>
      <tr>
        <th class="search_item_name"><label for="billStatus">予約状況</label></th>
        <td>
          <ul class="search_category">
            <li>
              <input type="checkbox">
              <label for="checkboxPrimary1">予約完了</label>
            </li>
            <li>
              <input type="checkbox">
              <label for="checkboxPrimary1">キャンセル</label>
            </li>
          </ul>
        </td>
        <th class="search_item_name"><label for="payStatus">入金状況</label></th>
        <td class="text-right">
          <ul class="search_category">
            <li>
              <input type="checkbox">
              <label for="payStatus">未入金</label>
            </li>
            <li>
              <input type="checkbox">
              <label for="payStatus">入金済</label>
            </li>
            <li>
              <input type="checkbox">
              <label for="payStatus">遅延</label>
            </li>
            <li>
              <input type="checkbox">
              <label for="payStatus">入金不足</label>
            </li>
            <li>
              <input type="checkbox">
              <label for="payStatus">入金過多</label>
            </li>
            <li>
              <input type="checkbox">
              <label for="payStatus">次回繰越</label>
            </li>
          </ul>
        </td>
      </tr>
      <tr>
        <th class="search_item_name"><label for="venuetype">直/提</label></th>
        <td class="text-left">
          <ul class="search_category">
            <li>
              <input type="checkbox" id="">
              <label for="venuetype">直営</label>
            </li>
            <li>
              <input type="checkbox" id="">
              <label for="venuetype">提携</label>
            </li>
          </ul>
        </td>
        <th class="search_item_name"><label for="freeword">フリーワード検索</label>
        <td class="text-right">
          <input type="text" name="freeword" class="form-control" id="freeword">
        </td>
      </tr>
    </tbody>
  </table>
  <p class="text-right">※フリーワード検索は本画面表記の項目のみ対象となります</p>

  <div class="btn_box d-flex justify-content-center">
    <input type="reset" value="リセット" class="btn reset_btn">
    <input type="submit" value="検索" class="btn search_btn">
  </div>

</div>

<!-- 検索　終わり------------------------------------------------ -->

<div class="d-flex justify-content-between">
  <dl class="count-sum d-flex">
    <dt>売上総額</dt>
    <dd>00000<span>円</span></dd>
  </dl>

  <p class="ml-1 text-right"><a class="more_btn4_lg" href="">表示結果ダウンロード(CSV)</a></p>
</div>
<div class="mt-3">
  <p class="text-right font-weight-bold"><span class="count-color">10</span>件</p>
</div>
<!-- 一覧　　------------------------------------------------ -->
<div class="table-wrap">
  <table class="table table-bordered table-scroll">
    <thead>
      <tr class="table_row">
        <th>予約一括ID</th>
        <th>予約ID</th>
        <th>利用日</th>
        <th>利用会場</th>
        <th>顧客ID</th>
        <th>会社・団体名</th>
        <th>担当者氏名</th>
        <th>仲介会社</th>
        <th>エンドユーザー</th>
        <th>総額</th>
        <th>売上</th>
        <th>売上原価</th>
        <th>粗利</th>
        <th>売上区分</th>
        <th>予約状況</th>
        <th>支払日</th>
        <th>入金状況</th>
        <th class="btn-cell">予約詳細</th>
        <th>振込名</th>
        <th>顧客属性</th>
        <th>支払期日</th>
        <th>運営</th>
      </tr>
    </thead>
    @foreach ($reservations as $reservation)
    <tbody class="sale-body">
      @for ($i = 0; $i < $reservation->billCount(); $i++)
        @if ($i==0)
        <tr class="table_row">
          <td rowspan="{{$reservation->billCount()+$reservation->cxlCount()+2}}">予約一括ID</td>
          <td rowspan="{{$reservation->billCount()+$reservation->cxlCount()+2}}">
            {{ReservationHelper::IdFormat($reservation->id)}}</td>
          <td rowspan="{{$reservation->billCount()+$reservation->cxlCount()+2}}">
            {{ReservationHelper::formatDate($reservation->reserve_date)}}
          </td>
          <td rowspan="{{$reservation->billCount()+$reservation->cxlCount()+2}}">
            {{ReservationHelper::getVenue($reservation->venue_id)}}</td>
          <td rowspan="{{$reservation->billCount()+$reservation->cxlCount()+2}}">
            {{!empty($reservation->user_id)?ReservationHelper::IdFormat($reservation->user_id):""}}</td>
          <td rowspan="{{$reservation->billCount()+$reservation->cxlCount()+2}}">
            {{!empty($reservation->user_id)?ReservationHelper::getCompany($reservation->user_id):""}}
          </td>
          <td rowspan="{{$reservation->billCount()+$reservation->cxlCount()+2}}">
            {{!empty($reservation->user_id)?ReservationHelper::getPersonName($reservation->user_id):""}}
          </td>
          <td rowspan="{{$reservation->billCount()+$reservation->cxlCount()+2}}">
            {{!empty($reservation->agent->id)?ReservationHelper::getAgentCompanyName($reservation->agent->id):''}}
          </td>
          <td rowspan="{{$reservation->billCount()+$reservation->cxlCount()+2}}">
            {{!empty($reservation->agent->id)?$reservation->enduser->company:''}}
          </td>
          <td rowspan="{{$reservation->billCount()+$reservation->cxlCount()+2}}">
            {{-- 総額 --}}
            {{number_format($reservation->bills->where('reservation_status','<=',3)->pluck('master_total')->sum())}}円
          </td>
          <td>
            {{-- 売上 --}}
            {{number_format($reservation->bills->first()->master_total)}}円</td>
          <td>
            {{-- 売上原価 --}}
            {{number_format($reservation->venue->getCostForPartner($reservation->venue, $reservation->bills->first()->master_total, $reservation->bills->first()->layout_price))}}円
          </td>
          <td>
            {{-- 粗利 --}}
            {{number_format($reservation->venue->getProfitForPartner($reservation->venue, $reservation->bills->first()->master_total, $reservation->bills->first()->layout_price))}}円
          </td>
          <td>{{($reservation->bills->first()->category==1?"会場予約":"")}}</td>
          <td> {{ReservationHelper::judgeStatus($reservation->bills->first()->reservation_status)}}</td>
          <td> {{ReservationHelper::formatDate($reservation->bills->first()->pay_day)}}</td>
          <td> {{$reservation->bills->first()->paid==0?"未入金":"入金済"}}</td>
          <td class="text-center" rowspan="{{$reservation->billCount()+$reservation->cxlCount()+2}}">
            <a class="more_btn" href="{{route('admin.reservations.show',$reservation->id)}}">
              予約詳細
            </a>
          </td>
          <td rowspan="{{$reservation->billCount()+$reservation->cxlCount()+2}}">振込名 </td>
          <td rowspan="{{$reservation->billCount()+$reservation->cxlCount()+2}}">
            {{!empty($reservation->user_id)?ReservationHelper::getAttr($reservation->user_id):""}}
          </td>
          <td>{{ReservationHelper::formatDate($reservation->bills->first()->payment_limit)}}</td>
          <td rowspan="{{$reservation->billCount()+$reservation->cxlCount()+2}}">
            {{$reservation->venue->alliance_flag==0?"直":"提"}}</td>
        </tr>
        @if ($reservation->cxls->where('bill_id',0)->count()>0)
        <tr> {{--個別キャンセル分 --}}
          <td style="color:red">
            {{-- 売上 --}}
            {{number_format(-$reservation->bills->first()->master_total)}}円
          </td>
          {{-- 売上 --}}
          <td>
            {{-- 売上原価 --}}
          </td>
          <td>
            {{-- 粗利 --}}
          </td>
          <td>
            {{"会場予約キャンセル"}}
          </td>
          <td>
            {{ReservationHelper::judgeStatus($reservation->bills->first()->reservation_status)}}
          </td>
          <td>
          </td>
          <td>
          </td>
          <td>{{ReservationHelper::formatDate($reservation->bills->first()->payment_limit)}}</td>
        </tr>
        @endif
        @else
        <tr>
          <td>
            {{-- 売上 --}}
            {{number_format($reservation->bills->skip($i)->first()->master_total)}}円</td>
          <td>
            {{-- 売上原価 --}}
            {{number_format($reservation->venue->getCostForPartner($reservation->venue, $reservation->bills->skip($i)->first()->master_total, $reservation->bills->skip($i)->first()->layout_price))}}円
          </td>
          <td>
            {{-- 粗利 --}}
            {{number_format($reservation->venue->getProfitForPartner($reservation->venue, $reservation->bills->skip($i)->first()->master_total, $reservation->bills->skip($i)->first()->layout_price))}}円
          </td>
          <td> {{($reservation->bills->skip($i)->first()->category==2?"追加請求".$i:"")}}</td>
          <td> {{ReservationHelper::judgeStatus($reservation->bills->skip($i)->first()->reservation_status)}}</td>
          <td> {{ReservationHelper::formatDate($reservation->bills->skip($i)->first()->pay_day)}}</td>
          <td> {{$reservation->bills->skip($i)->first()->paid==0?"未入金":"入金済"}}</td>
          <td> {{ReservationHelper::formatDate($reservation->bills->skip($i)->first()->payment_limit)}}</td>
        </tr>
        @if ($reservation->bills->skip($i)->first()->cxl)
        <tr> {{--個別キャンセル分 --}}
          <td style="color:red">
            {{-- 売上 --}}
            {{number_format(-$reservation->bills->skip($i)->first()->master_total)}}円
          </td>
          <td>
            {{-- 売上原価 --}}
          </td>
          <td>
            {{-- 粗利 --}}
          </td>
          <td>
            {{"追加請求".$i."キャンセル"}}
          </td>
          <td>
            {{ReservationHelper::cxlStatus($reservation->bills->skip($i)->first()->cxl->cxl_status)}}
          </td>
          <td>
            {{-- 個別キャンセル分16 --}}
          </td>
          <td>
            {{-- 個別キャンセル分7 --}}
          </td>
          <td>
          </td>
        </tr>
        @endif
        @endif
        @endfor

        {{-- キャンセル部分　一番下にくる --}}
        @if ($reservation->cxls->count()>0)
        <tr>
          <td>{{number_format($reservation->cxls->pluck('master_total')->sum())}}円</td>{{--売上--}}
          <td></td>{{--原価--}}
          <td></td>{{--粗利--}}
          <td>キャンセル</td>{{--区分--}}
          <td>キャンセル</td>{{--状況--}}
          <td></td>{{--支払--}}
          <td></td>{{--入金--}}
          <td></td>{{--期日--}}
        </tr>
        @endif
        {{-- キャンセル部分 --}}

    </tbody>
    @endforeach
  </table>
</div>
<!-- 一覧　　終わり------------------------------------------------ -->




@endsection