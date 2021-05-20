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
{{ Form::open(['url' => 'admin/sales', 'method'=>'GET']) }}
@csrf
<div class="search-wrap">
  <table class="table table-bordered">
    <tbody>
      <tr>
        <th class="search_item_name"><label for="bulkid">予約一括ID</label>
        <td class="text-right">
          <input type="text" name="bulkid" class="form-control" id="bulkid">
        </td>
        <th class="search_item_name"><label for="id">予約ID OK!!!!!!!!!!!!!!!!!!!</label></th>
        <td>
          {{Form::text('id',$request->id,['class'=>'form-control'])}}
        </td>
      </tr>
      <tr>
        <th class="search_item_name"><label for="date">利用日 OK!!!!!!!!!!!!!!!!!!!　</label> </th>
        <td class="text-right form-group hasDatepicker">
          {{Form::text('reserve_date',$request->reserve_date, ['class'=>'form-control'])}}
        </td>
        <th class="search_item_name"><label for="venue">利用会場 OK!!!!!!!!!!!!!!!!!!!　</label></th>
        <td class="text-right">
          <dd>
            <select class="form-control select2" name="venue">
              <option value=""></option>
              @foreach ($venues as $venue)
              @if ($request->venue==$venue)
              <option value="{{$venue}}" selected>{{ReservationHelper::getVenue($venue)}}</option>
              @endif
              <option value="{{$venue}}">{{ReservationHelper::getVenue($venue)}}</option>
              @endforeach
            </select>
        </td>
      </tr>
      <tr>
        <th class="search_item_name">
          <label for="customer">顧客ID OK!!!!!!!!!!!!!!!!!!! </label>
        </th>
        <td>
          {{Form::text('user_id',$request->user_id,['class'=>'form-control'])}}
        </td>
        <th class="search_item_name">
          <label for="company">会社名・団体名 OK!!!!!!!!!!!!!!!!!!! </label>
        </th>
        <td class="text-right">
          {{Form::text('company',$request->company,['class'=>'form-control'])}}
        </td>
      </tr>
      <tr>
        <th class="search_item_name">
          <label for="person">担当者氏名 OK!!!!!!!!!!!!!!!!!!! </label>
        </th>
        <td class="text-right">
          {{Form::text('person',$request->person,['class'=>'form-control'])}}
        </td>
        <th class="search_item_name"><label for="agent">仲介会社 OK!!!!!!!!!!!!!!!!!!! </label></th>
        <td class="text-right">
          <select class="form-control select2" name="agent">
            <option value=""></option>
            @foreach ($agents as $key=>$value)
            @if ($request->agent==$key)
            <option value="{{$key}}" selected>{{$value}}</option>
            @endif
            <option value="{{$key}}">{{$value}}</option>
            @endforeach
          </select>
        </td>
      </tr>
      <tr>
        <th class="search_item_name"><label for="enduser">エンドユーザー　 OK!!!!!!!!!!!!!!!!!!! </label></th>
        <td class="text-right">
          {{Form::text('enduser',$request->enduser,['class'=>'form-control'])}}
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
    <a href="{{url('admin/sales')}}" class="btn reset_btn">リセット</a>
    {{Form::submit('検索',['class'=>'btn search_btn'])}}
  </div>
</div>
{{Form::close()}}



<!-- 検索　終わり------------------------------------------------ -->

<div class="d-flex justify-content-between">
  <dl class="count-sum d-flex">
    <dt>売上総額</dt>
    <dd>00000<span>円</span></dd>
  </dl>

  <p class="ml-1 text-right">
    <a class="more_btn4_lg" href="{{url('admin/csv')}}">表示結果ダウンロード(CSV)</a>
  </p>
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
          <td rowspan="{{($reservation->billCount()*2)+$reservation->cxlCount()+2}}">
            {{$reservation->multiple_reserve_id}}</td>
          <td rowspan="{{($reservation->billCount()*2)+$reservation->cxlCount()+2}}">
            {{ReservationHelper::IdFormat($reservation->id)}}</td>
          <td rowspan="{{($reservation->billCount()*2)+$reservation->cxlCount()+2}}">
            {{ReservationHelper::formatDate($reservation->reserve_date)}}
          </td>
          <td rowspan="{{($reservation->billCount()*2)+$reservation->cxlCount()+2}}">
            {{ReservationHelper::getVenue($reservation->venue_id)}}</td>
          <td rowspan="{{($reservation->billCount()*2)+$reservation->cxlCount()+2}}">
            {{!empty($reservation->user_id)?ReservationHelper::IdFormat($reservation->user_id):""}}</td>
          <td rowspan="{{($reservation->billCount()*2)+$reservation->cxlCount()+2}}">
            {{!empty($reservation->user_id)?ReservationHelper::getCompany($reservation->user_id):""}}
          </td>
          <td rowspan="{{($reservation->billCount()*2)+$reservation->cxlCount()+2}}">
            {{!empty($reservation->user_id)?ReservationHelper::getPersonName($reservation->user_id):""}}
          </td>
          <td rowspan="{{($reservation->billCount()*2)+$reservation->cxlCount()+2}}">
            {{!empty($reservation->agent->id)?ReservationHelper::getAgentCompanyName($reservation->agent->id):''}}
          </td>
          <td rowspan="{{($reservation->billCount()*2)+$reservation->cxlCount()+2}}">
            {{!empty($reservation->agent->id)?$reservation->enduser->company:''}}
          </td>
          <td rowspan="{{($reservation->billCount()*2)+$reservation->cxlCount()+2}}">
            {{-- 総額 --}}
            {{number_format($reservation->totalAmountWithCxl())}}円
          </td>
          <td>
            {{-- 売上 --}}
            {{number_format($reservation->bills->first()->master_total)}}円</td>
          <td>
            {{-- 売上原価 --}}
            {{number_format($reservation->venue->getCostForPartner($reservation->venue, $reservation->bills->first()->master_total, $reservation->bills->first()->layout_price,$reservation))}}円
          </td>
          <td>
            {{-- 粗利 --}}
            {{number_format($reservation->venue->getProfitForPartner($reservation->venue, $reservation->bills->first()->master_total, $reservation->bills->first()->layout_price,$reservation))}}円
          </td>
          <td>{{($reservation->bills->first()->category==1?"会場予約":"")}}</td>
          <td> {{ReservationHelper::judgeStatus($reservation->bills->first()->reservation_status)}}</td>
          <td> {{ReservationHelper::formatDate($reservation->bills->first()->pay_day)}}</td>
          <td> {{$reservation->bills->first()->paid==0?"未入金":"入金済"}}</td>
          <td class="text-center" rowspan="{{($reservation->billCount()*2)+$reservation->cxlCount()+2}}">
            <a class="more_btn" href="{{route('admin.reservations.show',$reservation->id)}}">
              予約詳細
            </a>
          </td>
          <td>{{$reservation->bills->first()->pay_person}}</td>
          <td rowspan="{{($reservation->billCount()*2)+$reservation->cxlCount()+2}}">
            {{!empty($reservation->user_id)?ReservationHelper::getAttr($reservation->user_id):""}}
          </td>
          <td>{{ReservationHelper::formatDate($reservation->bills->first()->payment_limit)}}</td>
          <td rowspan="{{($reservation->billCount()*2)+$reservation->cxlCount()+2}}">
            {{$reservation->venue->alliance_flag==0?"直":"提"}}</td>
        </tr>
        @if ($reservation->cxls->where('bill_id',0)->count()>0)
        <tr> {{--個別キャンセル分 --}}
          <td style="color:red">
            {{-- 売上 --}}
            {{number_format(-$reservation->bills->first()->master_total)}}円
          </td>
          <td>
            -
          </td>
          <td>
            -
          </td>
          <td>
            {{"会場予約キャンセル"}}
          </td>
          <td>
            {{ReservationHelper::judgeStatus($reservation->bills->first()->reservation_status)}}
          </td>
          <td>-</td>
          <td>-</td>
          <td>{{--振り込み名　表示必要なし --}}</td>
          <td>-</td>
        </tr>
        @endif
        @else
        <tr>
          <td>
            {{-- 売上 --}}
            {{number_format($reservation->bills->skip($i)->first()->master_total)}}円</td>
          <td>
            {{-- 売上原価 --}}
            {{number_format($reservation->venue->getCostForPartner($reservation->venue, $reservation->bills->skip($i)->first()->master_total, $reservation->bills->skip($i)->first()->layout_price, $reservation))}}円
          </td>
          <td>
            {{-- 粗利 --}}
            {{number_format($reservation->venue->getProfitForPartner($reservation->venue, $reservation->bills->skip($i)->first()->master_total, $reservation->bills->skip($i)->first()->layout_price, $reservation))}}円
          </td>
          <td> {{($reservation->bills->skip($i)->first()->category==2?"追加請求".$i:"")}}</td>
          <td> {{ReservationHelper::judgeStatus($reservation->bills->skip($i)->first()->reservation_status)}}</td>
          <td> {{ReservationHelper::formatDate($reservation->bills->skip($i)->first()->pay_day)}}</td>
          <td> {{$reservation->bills->skip($i)->first()->paid==0?"未入金":"入金済"}}</td>
          <td>{{($reservation->bills->skip($i)->first()->pay_person)}}</td>
          <td> {{ReservationHelper::formatDate($reservation->bills->skip($i)->first()->payment_limit)}}</td>
        </tr>
        @if ($reservation->bills->skip($i)->first()->cxl)
        <tr> {{--個別キャンセル分 --}}
          <td style="color:red">
            {{-- 売上 --}}
            {{number_format(-$reservation->bills->skip($i)->first()->master_total)}}円
          </td>
          <td>-</td>
          <td>-</td>
          <td>
            {{"追加請求".$i."キャンセル"}}
          </td>
          <td>
            {{ReservationHelper::cxlStatus($reservation->bills->skip($i)->first()->cxl->cxl_status)}}
          </td>
          <td>-</td>
          <td>-</td>
          <td>{{--振り込み名　表示必要なし --}}</td>
          <td>-</td>
        </tr>
        @elseif($reservation->cxls->where('bill_id',0)->count()>0)
        <tr> {{--個別キャンセルではなく、メインの予約がキャンセルされた際 --}}
          <td style="color:red">
            {{-- 売上 --}}
            {{number_format(-$reservation->bills->skip($i)->first()->master_total)}}円
          </td>
          <td>-</td>
          <td>-</td>
          <td>
            {{"追加請求".$i."キャンセル"}}
          </td>
          <td>
            {{ReservationHelper::cxlStatus($reservation->bills->skip($i)->first()->cxl_status)}}
          </td>
          <td>-</td>
          <td>-</td>
          <td>{{--振り込み名　表示必要なし --}}</td>
          <td>-</td>
        </tr>
        @endif
        @endif
        @endfor

        {{-- キャンセル部分　一番下にくる --}}
        @if ($reservation->cxls->count()>0)
        <tr>
          <td>{{number_format($reservation->cxlSubtotal())}}円</td>{{--売上--}}
          <td>{{number_format($reservation->cxlCost())}}円</td>{{--原価--}}
          <td>{{number_format($reservation->cxlProfit())}}円</td>{{--粗利--}}
          <td>キャンセル</td>{{--区分--}}
          <td>キャンセル</td>{{--状況--}}
          <td></td>{{--支払--}}
          <td></td>{{--入金--}}
          <td>{{--振り込み名　表示必要なし --}}</td>
          <td></td>{{--期日--}}
        </tr>
        @endif
        {{-- キャンセル部分 --}}
    </tbody>
    @endforeach
  </table>
</div>
<!-- 一覧　　終わり------------------------------------------------ -->



{{-- {{ $reservations->links() }} --}}
{{$reservations->appends(request()->input())->render()}}


<script>
  $(function() {
    function ActiveDateRangePicker($target) {
      $("input[name='" + $target + "']").daterangepicker({
        "locale": {
          "format": "YYYY/MM/DD",
          "separator": " ~ ",
          "applyLabel": "反映",
          "cancelLabel": "初期化",
          "weekLabel": "W",
          "daysOfWeek": ["Su", "Mo", "Tu", "We", "Th", "Fr", "Sa"],
          "monthNames": ["1月", "2月", "3月", "4月", "5月", "6月", "7月", "8月", "9月", "10月", "11月", "12月"],
          "firstDay": 1,
        },
        autoUpdateInput: false
      });
      $("input[name='" + $target + "']").on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('YYYY/MM/DD') + ' - ' + picker.endDate.format('YYYY/MM/DD'));
      });
      $("input[name='" + $target + "']").on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('');
      });
    }
    ActiveDateRangePicker('reserve_date');
  })
</script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

@endsection