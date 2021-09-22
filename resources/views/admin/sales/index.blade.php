@extends('layouts.admin.app')
@section('content')

<link href="{{ asset('/css/template.css') }}" rel="stylesheet">
<style>
  .remark_limit {
    height: 100%;
    overflow: hidden;
    white-space: nowrap;
    text-overflow: ellipsis;
    width: 60px;
  }
</style>

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
{{ Form::open(['url' => 'admin/sales', 'method'=>'GET','id'=>'sales_search']) }}
@csrf
<div class="search-wrap">
  <table class="table table-bordered">
    <tbody>
      <tr>
        <th class="search_item_name">
          <label for="bulkid">予約一括ID</label>
        </th>
        <td class="text-right">
          {{Form::text('multiple_id',$request->multiple_id,['class'=>'form-control'])}}
        </td>
        <th class="search_item_name">
          <label for="id">予約ID</label>
        </th>
        <td>
          {{Form::text('id',$request->id,['class'=>'form-control'])}}
        </td>
      </tr>
      <tr>
        <th class="search_item_name"><label for="date">利用日</label> </th>
        <td class="text-right form-group hasDatepicker">
          {{Form::text('reserve_date',$request->reserve_date, ['class'=>'form-control'])}}
        </td>
        <th class="search_item_name"><label for="venue">利用会場</label></th>
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
          <label for="customer">顧客ID</label>
        </th>
        <td>
          {{Form::text('user_id',$request->user_id,['class'=>'form-control'])}}
        </td>
        <th class="search_item_name">
          <label for="company">会社名・団体名</label>
        </th>
        <td class="text-right">
          {{Form::text('company',$request->company,['class'=>'form-control'])}}
        </td>
      </tr>
      <tr>
        <th class="search_item_name">
          <label for="person">担当者氏名</label>
        </th>
        <td class="text-right">
          {{Form::text('person',$request->person,['class'=>'form-control'])}}
        </td>
        <th class="search_item_name"><label for="agent">仲介会社</label></th>
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
        <th class="search_item_name"><label for="enduser">エンドユーザー</label></th>
        <td class="text-right">
          {{Form::text('enduser',$request->enduser,['class'=>'form-control'])}}
        </td>
        <th class="search_item_name"><label for="sum">総額</label></th>
        <td>
          {{Form::text('amount',$request->amount,['class'=>'form-control'])}}
        </td>
      </tr>
      <tr>
        <th class="search_item_name"><label for="paydue">支払期日</label></th>
        <td class="text-right form-group">
          {{Form::text('payment_limit',$request->payment_limit, ['class'=>'form-control'])}}
        </td>
        <th class="search_item_name"><label for="billStatus">売上区分</label></th>
        <td>
          <ul class="search_category">
            <li>
              {{ Form::checkbox('sales1', '1',$request->sales1==1?true:false,['id'=>'sales1']) }}
              {{ Form::label('sales1', '会場') }}
            </li>
            <li>
              {{ Form::checkbox('sales2', '2',$request->sales2==2?true:false,['id'=>'sales2']) }}
              {{ Form::label('sales2', 'キャンセル') }}
            </li>
            <li>
              {{ Form::checkbox('sales3', '3',$request->sales3==3?true:false,['id'=>'sales3']) }}
              {{ Form::label('sales3', '追加請求') }}
            </li>
          </ul>
        </td>
      </tr>
      <tr>
        <th class="search_item_name"><label for="billStatus">予約状況</label></th>
        <td>
          <ul class="search_category">
            <li>
              {{ Form::checkbox('status3', '3',$request->status3?true:false,['id'=>'status1']) }}
              {{ Form::label('status1', '予約完了') }}
            </li>
            <li>
              {{ Form::checkbox('status6', '6',$request->status6?true:false,['id'=>'status2']) }}
              {{ Form::label('status2', 'キャンセル') }}
            </li>
          </ul>
        </td>
        <th class="search_item_name"><label for="payStatus">入金状況</label></th>
        <td class="text-right">
          <ul class="search_category">
            <li>
              {{ Form::checkbox('payment_status0', '0',$request->payment_status0!=""?true:false,['id'=>'payment_status0']) }}
              {{ Form::label('payment_status0', '未入金') }}
            </li>
            <li>
              {{ Form::checkbox('payment_status1', '1',$request->payment_status1?true:false,['id'=>'payment_status1']) }}
              {{ Form::label('payment_status1', '入金済') }}
            </li>
            <li>
              {{ Form::checkbox('payment_status2', '2',$request->payment_status2?true:false,['id'=>'payment_status2']) }}
              {{ Form::label('payment_status2', '遅延') }}
            </li>
            <li>
              {{ Form::checkbox('payment_status3', '3',$request->payment_status3?true:false,['id'=>'payment_status3']) }}
              {{ Form::label('payment_status3', '入金不足') }}
            </li>
            <li>
              {{ Form::checkbox('payment_status4', '4',$request->payment_status4?true:false,['id'=>'payment_status4']) }}
              {{ Form::label('payment_status4', '入金過多') }}
            </li>
            <li>
              {{ Form::checkbox('payment_status5', '5',$request->payment_status5?true:false,['id'=>'payment_status5']) }}
              {{ Form::label('payment_status5', '次回繰越') }}
            </li>
          </ul>
        </td>
      </tr>
      <tr>
        <th class="search_item_name"><label for="venuetype">直/提</label></th>
        <td class="text-left">
          <ul class="search_category">
            <li>
              {{ Form::checkbox('alliance0', '0',$request->alliance0!=""?true:false,['id'=>'alliance0']) }}
              {{ Form::label('alliance0', '直営') }}
            </li>
            <li>
              {{ Form::checkbox('alliance1', '1',$request->alliance1?true:false,['id'=>'alliance1']) }}
              {{ Form::label('alliance1', '提携') }}
            </li>
          </ul>
        </td>
        <th class="search_item_name"><label for="freeword">フリーワード検索</label>
        <td class="text-right">
          {{Form::text('free_word',$request->free_word, ['class'=>'form-control'])}}
        </td>
      </tr>
    </tbody>
  </table>
  <p class="text-right">※フリーワード検索は本画面表記の項目のみ対象となります</p>
  <div class="btn_box d-flex justify-content-center">
    <a href="{{url('admin/sales')}}" class="btn reset_btn">リセット</a>
    {{Form::submit('検索',['class'=>'btn search_btn','id'=>'m_submit'])}}
  </div>
</div>
{{-- ソート用hidden --}}
{{Form::hidden("sort_multiple_reserve_id", $request->sort_multiple_reserve_id?($request->sort_multiple_reserve_id==1?2:1):1)}}
{{Form::hidden("sort_id", $request->sort_id?($request->sort_id==1?2:1):1)}}
{{Form::hidden("sort_reserve_date", $request->sort_reserve_date?($request->sort_reserve_date==1?2:1):1)}}
{{Form::hidden("sort_venue", $request->sort_venue?($request->sort_venue==1?2:1):1)}}
{{Form::hidden("sort_user_id", $request->sort_user_id?($request->sort_user_id==1?2:1):1)}}
{{Form::hidden("sort_user_company", $request->sort_user_company?($request->sort_user_company==1?2:1):1)}}
{{Form::hidden("sort_user_name", $request->sort_user_name?($request->sort_user_name==1?2:1):1)}}
{{Form::hidden("sort_agent", $request->sort_agent?($request->sort_agent==1?2:1):1)}}
{{Form::hidden("sort_enduser", $request->sort_enduser?($request->sort_enduser==1?2:1):1)}}
{{Form::hidden("sort_user_attr", $request->sort_user_attr?($request->sort_user_attr==1?2:1):1)}}
{{Form::hidden("sort_alliance", $request->sort_alliance?($request->sort_alliance==1?2:1):1)}}
{{-- ソート用hidden --}}

{{Form::close()}}



<!-- 検索　終わり------------------------------------------------ -->

<div class="d-flex justify-content-between">
  <dl class="count-sum d-flex align-items-center">
    <dt>売上総額</dt>
    <dd>
      @foreach ($request->except('_token') as $item)
      @if (($item!=""))
      {{number_format($all_total_amount)}}
      @break
      @endif
      @endforeach
      <span>円</span></dd>
  </dl>


  {{ Form::open(['url' => 'admin/csv', 'method'=>'post']) }}
  @csrf
  {{Form::hidden('csv_arrays',json_encode($for_csv))}}
  <p class="ml-1 text-right">{{Form::submit('表示結果ダウンロード(CSV)',['class'=>'btn more_btn4_lg'])}}</p>
  {{Form::close()}}


</div>
<div class="mt-3">
  <p class="text-right font-weight-bold">
    @if ($counter!=0)
    <span class="count-color">
      {{$counter}}
    </span>件
    @endif
  </p>
</div>

<!-- 一覧　　------------------------------------------------ -->
<div class="table-wrap">
  <table class="table table-bordered table-scroll">
    <thead>
      <tr class="table_row">
        <th id="sort_multiple_reserve_id">予約一括ID
          {!!ReservationHelper::sortIcon($request->sort_multiple_reserve_id)!!}</th>
        <th id="sort_id">予約ID {!!ReservationHelper::sortIcon($request->sort_id)!!}</th>
        <th id="sort_reserve_date">利用日 {!!ReservationHelper::sortIcon($request->sort_reserve_date)!!}</th>
        <th id="sort_venue">利用会場 {!!ReservationHelper::sortIcon($request->sort_venue)!!}</th>
        <th id="sort_user_id">顧客ID {!!ReservationHelper::sortIcon($request->sort_user_id)!!}</th>
        <th id="sort_user_company">会社名団体名 {!!ReservationHelper::sortIcon($request->sort_user_company)!!}</th>
        <th id="sort_user_name">担当者氏名 {!!ReservationHelper::sortIcon($request->sort_user_name)!!}</th>
        <th id="sort_agent">仲介会社 {!!ReservationHelper::sortIcon($request->sort_agent)!!}</th>
        <th id="sort_enduser">エンドユーザー {!!ReservationHelper::sortIcon($request->sort_enduser)!!}</th>
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
        <th id="sort_user_attr">顧客属性 {!!ReservationHelper::sortIcon($request->sort_user_attr)!!}</th>
        <th>支払期日</th>
        <th id="sort_alliance">運営 {!!ReservationHelper::sortIcon($request->sort_alliance)!!}</th>
      </tr>
    </thead>
    @foreach ($reservations as $reservation)
    <tbody class="sale-body">
      @for ($i = 0; $i < $reservation->billCount(); $i++)
        @if ($i==0)
        <tr class="table_row">
          <td rowspan="{{($reservation->billCount()*2)+$reservation->cxlCount()+2}}">
            {{ReservationHelper::IdFormat($reservation->multiple_reserve_id)}}</td>
          <td rowspan="{{($reservation->billCount()*2)+$reservation->cxlCount()+2}}">
            {{ReservationHelper::IdFormat($reservation->id)}}</td>
          <td rowspan="{{($reservation->billCount()*2)+$reservation->cxlCount()+2}}">
            {{ReservationHelper::formatDate($reservation->reserve_date)}}
          </td>
          <td rowspan="{{($reservation->billCount()*2)+$reservation->cxlCount()+2}}">
            {{ReservationHelper::getVenue($reservation->venue_id)}}</td>
          <td rowspan="{{($reservation->billCount()*2)+$reservation->cxlCount()+2}}">
            {{!empty($reservation->user_id)?ReservationHelper::IdFormat($reservation->user_id):""}}</td>
          <td rowspan="{{($reservation->billCount()*2)+$reservation->cxlCount()+2}}"
            class="{{ClassHelper::addNotMemberClass($reservation)}}">
            {{!empty($reservation->user_id)?ReservationHelper::getCompany($reservation->user_id):""}}
          </td>
          @if ($reservation->user_id>0)
          <td rowspan="{{($reservation->billCount()*2)+$reservation->cxlCount()+2}}"
            class="{{ClassHelper::addNotMemberClass($reservation)}}">
            {{!empty($reservation->user_id)?ReservationHelper::getPersonName($reservation->user_id):""}}
          </td>
          @else
          <td rowspan="{{($reservation->billCount()*2)+$reservation->cxlCount()+2}}">
            {{!empty($reservation->user_id)?ReservationHelper::getPersonName($reservation->user_id):""}}
          </td>
          @endif
          <td rowspan="{{($reservation->billCount()*2)+$reservation->cxlCount()+2}}">
            {{!empty($reservation->agent->id)?ReservationHelper::getAgentCompany($reservation->agent->id):''}}
          </td>
          <td rowspan="{{($reservation->billCount()*2)+$reservation->cxlCount()+2}}">
            {{!empty($reservation->agent_id>0)?optional($reservation->enduser)->company:''}}
          </td>
          <td rowspan="{{($reservation->billCount()*2)+$reservation->cxlCount()+2}}">
            {{number_format($reservation->totalAmountWithCxl())}}円
          </td>
          <td>
            {{number_format($reservation->bills->sortBy("id")->first()->master_total)}}円</td>
          <td> {{--売上原価--}}
            {{number_format($reservation->venue->getCostForPartner($reservation->venue, $reservation->bills->sortBy("id")->first()->master_total, $reservation->bills->sortBy("id")->first()->layout_price,$reservation))}}円
          </td>
          <td>{{--粗利--}}
            {{number_format($reservation->venue->getProfitForPartner($reservation->venue, $reservation->bills->sortBy("id")->first()->master_total, $reservation->bills->sortBy("id")->first()->layout_price,$reservation))}}円
          </td>
          <td> {{--売上区分--}}
            {{($reservation->bills->sortBy("id")->first()->category==1?"会場予約":"")}}
          </td>
          <td>{{--予約状況--}}
            {{ReservationHelper::judgeStatus($reservation->bills->sortBy("id")->first()->reservation_status)}}</td>
          <td> {{ReservationHelper::formatDate($reservation->bills->sortBy("id")->first()->pay_day)}}</td>
          <td class="payment-status">
            {{ReservationHelper::paidStatus($reservation->bills->sortBy("id")->first()->paid)}}</td>
          <td class="text-center" rowspan="{{($reservation->billCount()*2)+$reservation->cxlCount()+2}}">
            <a class="more_btn" href="{{route('admin.reservations.show',$reservation->id)}}">
              予約詳細
            </a>
          </td>
          <td>
            <p class="remark_limit">{{$reservation->bills->sortBy("id")->first()->pay_person}}</p>
          </td>
          <td rowspan="{{($reservation->billCount()*2)+$reservation->cxlCount()+2}}">
            {{!empty($reservation->user_id)?ReservationHelper::getAttr($reservation->user_id):""}}
          </td>
          <td>{{ReservationHelper::formatDate($reservation->bills->sortBy("id")->first()->payment_limit)}}</td>
          <td rowspan="{{($reservation->billCount()*2)+$reservation->cxlCount()+2}}"
            style="{{$reservation->venue->alliance_flag==1?"color:red":""}}">
            {{$reservation->venue->alliance_flag==0?"直":"提"}}</td>
        </tr>
        @else
        <tr>
          <td>
            {{number_format($reservation->bills->skip($i)->first()->master_total)}}円</td>
          <td>
            {{number_format($reservation->venue->getCostForPartner($reservation->venue, $reservation->bills->skip($i)->first()->master_total, $reservation->bills->skip($i)->first()->layout_price, $reservation))}}円
          </td>
          <td>
            {{number_format($reservation->venue->getProfitForPartner($reservation->venue, $reservation->bills->skip($i)->first()->master_total, $reservation->bills->skip($i)->first()->layout_price, $reservation))}}円
          </td>
          <td>{{--売上区分--}}
            {{'追加'.$i}}
          </td>
          <td>{{--予約状況--}}
            {{ReservationHelper::judgeStatus($reservation->bills->skip($i)->first()->reservation_status)}}</td>
          <td> {{ReservationHelper::formatDate($reservation->bills->skip($i)->first()->pay_day)}}</td>
          <td class="payment-status">
            {{$reservation->bills->skip($i)->first()->paid==0?"未入金":"入金済"}}</td>
          <td>
            <p class="remark_limit">{{($reservation->bills->skip($i)->first()->pay_person)}}</p>
          </td>
          <td> {{ReservationHelper::formatDate($reservation->bills->skip($i)->first()->payment_limit)}}</td>
        </tr>
        @endif
        @endfor
        {{-- キャンセルがあれば無条件で打ち消しとキャンセルを出す --}}
        @if ($reservation->cxls->count()>0)
        {{-- 打ち消し --}}
        <tr>
          <td> {{--売上--}}
            {{number_format(($reservation->totalBillAmount())*-1)}}円
          </td>
          <td>{{--売上原価--}}
            {{number_format(($reservation->venue->sumCostForPartner($reservation))*-1)}}円
          </td>
          <td>{{--粗利--}}
            {{number_format((($reservation->totalBillAmount())*-1)-(($reservation->venue->sumCostForPartner($reservation))*-1))}}
          </td>
          <td>{{--売上区分--}}
            打ち消し
          </td>
          <td>{{--予約状況--}}
            -
          </td>
          <td>
            -
          </td>
          <td class="payment-status">
            -
          </td>
          <td>
            -
          </td>
          <td>
            -
          </td>
        </tr>
        <tr>
          <td>{{number_format($reservation->cxlSubtotal())}}円</td>
          {{--売上--}}
          <td>{{number_format($reservation->cxlCost())}}円</td>
          {{--原価--}}
          <td>{{number_format($reservation->cxlProfit())}}円</td>
          <td>{{--売上区分--}}
            キャンセル料
          </td>
          <td>{{--予約状況--}}
            {{ReservationHelper::cxlStatus($reservation->cxls->first()->cxl_status)}}
          </td>
          <td>{{--支払い日--}}
            {{ReservationHelper::formatDate($reservation->cxls->first()->pay_day)}}
          </td>
          <td class="payment-status">
            {{ReservationHelper::paidStatus($reservation->cxls->first()->paid)}}
          </td>
          <td>
            {{$reservation->cxls->first()->pay_person}}
          </td>
          <td>
            {{ReservationHelper::formatDate($reservation->cxls->first()->payment_limit)}}
          </td>
        </tr>
        @endif
    </tbody>
    @endforeach
  </table>
</div>
<!-- 一覧　　終わり------------------------------------------------ -->



{{-- {{ $reservations->links() }} --}}
{{-- {{$reservations->appends(request()->input())->render()}} --}}
{{$reservations->appends(request()->input())->links()}}



<script>
  $(document).on("click", ".table-scroll th", function() {
    var click_th_id=$(this).attr("id");
    $('input[name^="sort_"]').each(function(key, item){
      if ($(item).attr("name")!=click_th_id) {
        $(item).val("");
      }
    })
    $("#sales_search").submit();
    }) 

    $(function() {
      $("#m_submit").on("click",function(){
        $('input[name^="sort_"]').each(function(key, item){
        $(item).val("");
        })
      })
    })


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
    ActiveDateRangePicker('payment_limit');
  })

$(function(){
  $('.payment-status').each(function(index, value){
    var target=$(value).text();
    console.log(target);
    if (target.match(/未入金/)) {
      $(value).css('font-weight','bold');
    }
  });
  $('td').each(function(index, value){
    var target=$(value).text();
    if (target.match(/-/)) {
    $(value).css('color','red');
    }
    });
});

</script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

@endsection