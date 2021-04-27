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
          <td rowspan="{{$reservation->billCount()}}">予約一括ID</td>
          <td rowspan="{{$reservation->billCount()}}">{{$reservation->id}}</td>
          <td rowspan="{{$reservation->billCount()}}">{{ReservationHelper::formatDate($reservation->reserve_date)}}</td>
          <td rowspan="{{$reservation->billCount()}}">{{ReservationHelper::getVenue($reservation->venue_id)}}</td>
          <td rowspan="{{$reservation->billCount()}}">{{!empty($reservation->user_id)?$reservation->user_id:""}}</td>
          <td rowspan="{{$reservation->billCount()}}">
            {{!empty($reservation->user_id)?ReservationHelper::getCompany($reservation->user_id):""}}
          </td>
          <td rowspan="{{$reservation->billCount()}}">
            {{!empty($reservation->user_id)?ReservationHelper::getPersonName($reservation->user_id):""}}
          </td>
          <td rowspan="{{$reservation->billCount()}}">
            {{!empty($reservation->agent->id)?ReservationHelper::getAgentCompanyName($reservation->agent->id):''}}
          </td>
          <td rowspan="{{$reservation->billCount()}}">
            {{!empty($reservation->agent->id)?$reservation->enduser->company:''}}
          </td>
          <td rowspan="{{$reservation->billCount()}}">総額</td>
          <td>{{number_format($reservation->bills->first()->master_total)}}円</td>
          <td>売上原価 </td>
          <td>粗利 </td>
          <td>{{($reservation->bills->first()->category==1?"会場予約":"")}}</td>
          <td> {{ReservationHelper::judgeStatus($reservation->bills->first()->reservation_status)}}</td>
          <td> {{$reservation->bills->first()->pay_day}}</td>
          <td> {{$reservation->bills->first()->paid==0?"未入金":"入金済"}}</td>
          <td class="text-center" rowspan="{{$reservation->billCount()}}">
            <a class="more_btn" href="{{route('admin.reservations.show',$reservation->id)}}">
              予約詳細
            </a>
          </td>
          <td rowspan="{{$reservation->billCount()}}">振込名 </td>
          <td rowspan="{{$reservation->billCount()}}">
            {{!empty($reservation->user_id)?ReservationHelper::getAttr($reservation->user_id):""}}
          </td>
          <td>{{ReservationHelper::formatDate($reservation->bills->first()->payment_limit)}}</td>
          <td rowspan="{{$reservation->billCount()}}">運営 {{$reservation->venue->alliance_flag==0?"直":"提"}}</td>
        </tr>
        @else
        <tr>
          <td>{{number_format($reservation->bills->skip($i)->first()->master_total)}}円</td>
          <td>売上原価 </td>
          <td>粗利 </td>
          <td> {{($reservation->bills->skip($i)->first()->category==2?"追加請求".$i:"")}}</td>
          <td> {{ReservationHelper::judgeStatus($reservation->bills->skip($i)->first()->reservation_status)}}</td>
          <td> {{$reservation->bills->skip($i)->first()->pay_day}}</td>
          <td> {{$reservation->bills->skip($i)->first()->paid==0?"未入金":"入金済"}}</td>
          <td> {{ReservationHelper::formatDate($reservation->bills->skip($i)->first()->payment_limit)}}</td>
        </tr>
        @endif

        @endfor
    </tbody>
    @endforeach

  </table>
</div>
<!-- 一覧　　終わり------------------------------------------------ -->




@endsection





{{-- 
@foreach ($reservations as $reservation)
<tr>
  <td rowspan="{{$reservation->billCount()}}"></td>
<td rowspan="{{$reservation->billCount()}}">{{$reservation->id}}</td>
<td rowspan="{{$reservation->billCount()}}">{{ReservationHelper::formatDate($reservation->reserve_date)}}</td>
<td rowspan="{{$reservation->billCount()}}">{{(ReservationHelper::getVenue($reservation->venue_id))}}</td>
<td rowspan="{{$reservation->billCount()}}">{{!empty($reservation->user_id)?$reservation->user_id:""}}</td>
<td rowspan="{{$reservation->billCount()}}">{{!empty($reservation->user->id)?$reservation->user->id:""}}</td>
<td rowspan="{{$reservation->billCount()}}">
  {{!empty($reservation->user->id)?ReservationHelper::getPersonName($reservation->user->id):ReservationHelper::getAgentPerson($reservation->agent->id)}}
</td>
<td rowspan="{{$reservation->billCount()}}">
  {{!empty($reservation->agent->id)?ReservationHelper::getAgentCompanyName($reservation->agent->id):''}}
</td>
<td rowspan="{{$reservation->billCount()}}">
  {{!empty($reservation->agent->id)?$reservation->enduser->company:''}}
</td>
<td rowspan="{{$reservation->billCount()}}">総額</td>
<td>売上</td>
<td>売上原価</td>
<td>粗利</td>
<td>売上区分</td>
<td>予約状況</td>
<td>支払い日</td>
<td>入金状況</td>
<td rowspan="{{$reservation->billCount()}}">予約詳細</td>
<td rowspan="{{$reservation->billCount()}}">振り込み名</td>
<td rowspan="{{$reservation->billCount()}}">顧客属性</td>
<td>支払い期日</td>
<td rowspan="{{$reservation->billCount()}}">運営</td>
</tr>
@endforeach
<tr>
  <td>売上2</td>
  <td>売上原価2</td>
  <td>粗利2</td>
  <td>売上区分2</td>
  <td>予約状況2</td>
  <td>支払い日2</td>
  <td>入金状況2</td>
  <td>支払い期日</td>
</tr> --}}









{{-- <tr>
          <td class="text-center">00000</td>
          <td class="text-center">00000</td>
          <td>2020/12/07(月)</td>
          <td>四ツ橋・サンワールドビル22号室</td>
          <td>00000</td>
          <td>株式会社テスト</td>
          <td>山田元気</td>
          <td>-</td>
          <td>-</td>
          <td class="sale-number">
            <p>100,000</p>
          </td>
          <td class="table_column sale-number">
            <p>50,000</p>
            <p>50,000</p>
          </td>
          <td class="table_column sale-number">
            <p>0</p>
            <p>0</p>
          </td>
          <td class="table_column sale-number">
            <p>50,000</p>
            <p>50,000</p>
          </td>
          <td class="table_column">
            <p>会場</p>
            <p>追加請求</p>
          </td>
          <td class="table_column">
            <p>予約完了</p>
            <p>予約完了</p>
          </td>
          <td class="table_column">
            <p>2020/12/07(月)</p>
            <p>2020/12/07(月)</p>
          </td>
          <td class="table_column">
            <p>入金済</p>
            <p>未払</p>
          </td>
          <td class="text-center"><a class="more_btn" href="##############">詳細</a></td>
          <td class="limit_remark">ﾄﾘｯｸｽﾀｰ</td>
          <td>インターネット</td>
          <td class="table_column">
            <p>2020/12/07(月)</p>
            <p>2020/12/07(月)</p>
          </td>
          <td class="text-center">直</td>
        </tr>
        <tr>
          <td class="text-center">00000</td>
          <td class="text-center">00000</td>
          <td>2020/12/07(月)</td>
          <td>四ツ橋・サンワールドビル22号室</td>
          <td>00000</td>
          <td>株式会社テスト</td>
          <td>山田元気</td>
          <td>-</td>
          <td>-</td>
          <td class="sale-number">
            <p>100,000</p>
          </td>
          <td class="table_column sale-number">
            <p>50,000</p>
            <p>50,000</p>
          </td>
          <td class="table_column sale-number">
            <p>35,000</p>
            <p>35,000</p>
          </td>
          <td class="table_column sale-number">
            <p>15,000</p>
            <p>15,000</p>
          </td>
          <td class="table_column">
            <p>会場</p>
            <p>追加請求</p>
          </td>
          <td class="table_column">
            <p>予約完了</p>
            <p>予約完了</p>
          </td>
          <td class="table_column">
            <p>2020/12/07(月)</p>
            <p>2020/12/07(月)</p>
          </td>
          <td class="table_column">
            <p>入金済</p>
            <p>未払</p>
          </td>
          <td class="text-center"><a class="more_btn" href="##########">詳細</a></td>
          <td class="limit_remark">ﾄﾘｯｸｽﾀｰ</td>
          <td>インターネット</td>
          <td class="table_column">
            <p>2020/12/07(月)</p>
            <p>2020/12/07(月)</p>
          </td>
          <td class="text-center">提</td>
        </tr>
        <tr>
          <td class="text-center">00000</td>
          <td class="text-center">00000</td>
          <td>2020/12/07(月)</td>
          <td>四ツ橋・サンワールドビル22号室</td>
          <td>00000</td>
          <td>-</td>
          <td>-</td>
          <td>スペースマーケット</td>
          <td>山田太郎</td>
          <td class="sale-number">
            <p>70,000</p>
          </td>
          <td class="table_column sale-number">
            <p>35,000</p>
            <p>35,000</p>
          </td>
          <td class="table_column sale-number">
            <p>0</p>
            <p>0</p>
          </td>
          <td class="table_column sale-number">
            <p>35,000</p>
            <p>35,000</p>
          </td>
          <td class="table_column">
            <p>会場</p>
            <p>追加請求</p>
          </td>
          <td class="table_column">
            <p>予約完了</p>
            <p>予約完了</p>
          </td>
          <td class="table_column">
            <p>2020/12/07(月)</p>
            <p>2020/12/07(月)</p>
          </td>
          <td class="table_column">
            <p>入金済</p>
            <p>未払</p>
          </td>
          <td class="text-center"><a class="more_btn" href="##########">詳細</a></td>
          <td class="limit_remark">ﾄﾘｯｸｽﾀｰ</td>
          <td>インターネット</td>
          <td class="table_column">
            <p>2020/12/07(月)</p>
            <p>2020/12/07(月)</p>
          </td>
          <td class="text-center">直</td>
        </tr>
        <tr>
          <td class="text-center">00000</td>
          <td class="text-center">00000</td>
          <td>2020/12/07(月)</td>
          <td>四ツ橋・サンワールドビル22号室</td>
          <td>00000</td>
          <td>-</td>
          <td>-</td>
          <td>スペースマーケット</td>
          <td>山田太郎</td>
          <td class="sale-number">
            <p>70,000</p>
          </td>
          <td class="table_column sale-number">
            <p>35,000</p>
            <p>35,000</p>
          </td>
          <td class="table_column sale-number">
            <p>24,500</p>
            <p>24,500</p>
          </td>
          <td class="table_column sale-number">
            <p>10,500</p>
            <p>10,500</p>
          </td>
          <td class="table_column">
            <p>会場</p>
            <p>追加請求</p>
          </td>
          <td class="table_column">
            <p>予約完了</p>
            <p>予約完了</p>
          </td>
          <td class="table_column">
            <p>2020/12/07(月)</p>
            <p>2020/12/07(月)</p>
          </td>
          <td class="table_column">
            <p>入金済</p>
            <p>未払</p>
          </td>
          <td class="text-center"><a class="more_btn" href="##########">詳細</a></td>
          <td class="limit_remark">ﾄﾘｯｸｽﾀｰ</td>
          <td>インターネット</td>
          <td class="table_column">
            <p>2020/12/07(月)</p>
            <p>2020/12/07(月)</p>
          </td>
          <td class="text-center">提</td>
        </tr>
        <!-- 一括キャンセルパターン -->
        <tr>
          <td class="text-center">00000</td>
          <td class="text-center">00000</td>
          <td>2020/12/07(月)</td>
          <td>四ツ橋・サンワールドビル22号室</td>
          <td>00000</td>
          <td>株式会社テスト</td>
          <td>山田元気</td>
          <td>-</td>
          <td>-</td>
          <td class="sale-number">
            <p>100,000</p>
          </td>
          <td class="table_column sale-number">
            <p>50,000</p>
            <p class="cancel-color">-50,000</p>
            <p>50,000</p>
            <p class="cancel-color">-50,000</p>
            <p>100,000</p>
          </td>
          <td class="table_column sale-number">
            <p>0</p>
            <p>0</p>
            <p>0</p>
            <p>0</p>
            <p>0</p>
          </td>
          <td class="table_column sale-number">
            <p>50,000</p>
            <p class="cancel-color">-50,000</p>
            <p>50,000</p>
            <p class="cancel-color">-50,000</p>
            <p>100,000</p>
          </td>
          <td class="table_column">
            <p>会場</p>
            <p>会場キャンセル</p>
            <p>追加請求</p>
            <p>追加請求キャンセル</p>
            <p>キャンセル料</p>
          </td>
          <td class="table_column text-right">
            <p>キャンセル</p>
            <p>キャンセル</p>
            <p>キャンセル</p>
            <p>キャンセル</p>
            <p>-</p>
          </td>
          <td class="table_column">
            <p>2020/12/07(月)</p>
            <p>2020/12/07(月)</p>
            <p>2020/12/07(月)</p>
            <p>2020/12/07(月)</p>
            <p>-</p>
          </td>
          <td class="table_column">
            <p>入金済</p>
            <p>入金済</p>
            <p>入金済</p>
            <p>未払</p>
            <p>-</p>
          </td>
          <td class="text-center"><a class="more_btn" href="##########">詳細</a></td>
          <td class="limit_remark">ﾄﾘｯｸｽﾀｰ</td>
          <td>インターネット</td>
          <td class="table_column">
            <p>2020/12/07(月)</p>
            <p>2020/12/07(月)</p>
            <p>2020/12/07(月)</p>
            <p>2020/12/07(月)</p>
            <p>-</p>
          </td>
          <td class="text-center">直</td>
        </tr>
        <tr>
          <td class="text-center">00000</td>
          <td class="text-center">00000</td>
          <td>2020/12/07(月)</td>
          <td>四ツ橋・サンワールドビル22号室</td>
          <td>00000</td>
          <td>株式会社テスト</td>
          <td>山田元気</td>
          <td>-</td>
          <td>-</td>
          <td class="sale-number">
            <p>100,000</p>
          </td>
          <td class="table_column sale-number">
            <p>50,000</p>
            <p class="cancel-color">-50,000</p>
            <p>50,000</p>
            <p class="cancel-color">-50,000</p>
            <p>100,000</p>
          </td>
          <td class="table_column sale-number">
            <p>35,000</p>
            <p class="cancel-color">-35,000</p>
            <p>35,000</p>
            <p class="cancel-color">-35,000</p>
            <p>70,000</p>
          </td>
          <td class="table_column sale-number">
            <p>15,000</p>
            <p class="cancel-color">-15,000</p>
            <p>15,000</p>
            <p class="cancel-color">-15,000</p>
            <p>30,000</p>
          </td>
          <td class="table_column">
            <p>会場</p>
            <p>会場キャンセル</p>
            <p>追加請求</p>
            <p>追加請求キャンセル</p>
            <p>キャンセル料</p>
          </td>
          <td class="table_column">
            <p>予約完了</p>
            <p>予約完了</p>
            <p>予約完了</p>
            <p>予約完了</p>
            <p>-</p>
          </td>
          <td class="table_column">
            <p>2020/12/07(月)</p>
            <p>2020/12/07(月)</p>
            <p>2020/12/07(月)</p>
            <p>2020/12/07(月)</p>
            <p>-</p>
          </td>
          <td class="table_column">
            <p>入金済</p>
            <p>未払</p>
            <p>未払</p>
            <p>未払</p>
            <p>-</p>
          </td>
          <td class="text-center"><a class="more_btn" href="##########">詳細</a></td>
          <td class="limit_remark">ﾄﾘｯｸｽﾀｰ</td>
          <td>インターネット</td>
          <td class="table_column">
            <p>2020/12/07(月)</p>
            <p>2020/12/07(月)</p>
            <p>2020/12/07(月)</p>
            <p>2020/12/07(月)</p>
            <p>-</p>
          </td>
          <td class="text-center">提</td>
        </tr>
        <tr>
          <td class="text-center">00000</td>
          <td class="text-center">00000</td>
          <td>2020/12/07(月)</td>
          <td>四ツ橋・サンワールドビル22号室</td>
          <td>00000</td>
          <td>-</td>
          <td>-</td>
          <td>スペースマーケット</td>
          <td>山田元気</td>
          <td class="sale-number">
            <p>70,000</p>
          </td>
          <td class="table_column sale-number">
            <p>35,000</p>
            <p class="cancel-color">-35,000</p>
            <p>35,000</p>
            <p class="cancel-color">-35,000</p>
            <p>70,000</p>
          </td>
          <td class="table_column sale-number">
            <p>0</p>
            <p>0</p>
            <p>0</p>
            <p>0</p>
            <p>0</p>
          </td>
          <td class="table_column sale-number">
            <p>35,000</p>
            <p class="cancel-color">-35,000</p>
            <p>35,000</p>
            <p class="cancel-color">-35,000</p>
            <p>70,000</p>
          </td>
          <td class="table_column">
            <p>会場</p>
            <p>会場キャンセル</p>
            <p>追加請求</p>
            <p>追加請求キャンセル</p>
            <p>キャンセル料</p>
          </td>
          <td class="table_column text-right">
            <p>キャンセル</p>
            <p>キャンセル</p>
            <p>キャンセル</p>
            <p>キャンセル</p>
            <p>-</p>
          </td>
          <td class="table_column">
            <p>2020/12/07(月)</p>
            <p>2020/12/07(月)</p>
            <p>2020/12/07(月)</p>
            <p>2020/12/07(月)</p>
            <p>-</p>
          </td>
          <td class="table_column">
            <p>入金済</p>
            <p>入金済</p>
            <p>入金済</p>
            <p>未払</p>
            <p>-</p>
          </td>
          <td class="text-center"><a class="more_btn" href="##########">詳細</a></td>
          <td class="limit_remark">ﾄﾘｯｸｽﾀｰ</td>
          <td>インターネット</td>
          <td class="table_column">
            <p>2020/12/07(月)</p>
            <p>2020/12/07(月)</p>
            <p>2020/12/07(月)</p>
            <p>2020/12/07(月)</p>
            <p>-</p>
          </td>
          <td class="text-center">直</td>
        </tr>
        <tr>
          <td class="text-center">00000</td>
          <td class="text-center">00000</td>
          <td>2020/12/07(月)</td>
          <td>四ツ橋・サンワールドビル22号室</td>
          <td>00000</td>
          <td>-</td>
          <td>-</td>
          <td>スペースマーケット</td>
          <td>山田元気</td>
          <td class="sale-number">
            <p>70,000</p>
          </td>
          <td class="table_column sale-number">
            <p>35,000</p>
            <p class="cancel-color">-35,000</p>
            <p>35,000</p>
            <p class="cancel-color">-35,000</p>
            <p>70,000</p>
          </td>
          <td class="table_column sale-number">
            <p>24,500</p>
            <p class="cancel-color">-24,500</p>
            <p>24,500</p>
            <p class="cancel-color">-24,500</p>
            <p>49,000</p>
          </td>
          <td class="table_column sale-number">
            <p>10,500</p>
            <p class="cancel-color">-10,500</p>
            <p>10,500</p>
            <p class="cancel-color">-10,500</p>
            <p>21,000</p>
          </td>
          <td class="table_column">
            <p>会場</p>
            <p>会場キャンセル</p>
            <p>追加請求</p>
            <p>追加請求キャンセル</p>
            <p>キャンセル料</p>
          </td>
          <td class="table_column">
            <p>予約完了</p>
            <p>予約完了</p>
            <p>予約完了</p>
            <p>予約完了</p>
            <p>-</p>
          </td>
          <td class="table_column">
            <p>2020/12/07(月)</p>
            <p>2020/12/07(月)</p>
            <p>2020/12/07(月)</p>
            <p>2020/12/07(月)</p>
            <p>-</p>
          </td>
          <td class="table_column">
            <p>入金済</p>
            <p>未払</p>
            <p>未払</p>
            <p>未払</p>
            <p>-</p>
          </td>
          <td class="text-center"><a class="more_btn" href="##########">詳細</a></td>
          <td class="limit_remark">ﾄﾘｯｸｽﾀｰ</td>
          <td>インターネット</td>
          <td class="table_column">
            <p>2020/12/07(月)</p>
            <p>2020/12/07(月)</p>
            <p>2020/12/07(月)</p>
            <p>2020/12/07(月)</p>
            <p>-</p>
          </td>
          <td class="text-center">提</td>
        </tr>--}}