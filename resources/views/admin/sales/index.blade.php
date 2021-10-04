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
          {{Form::text('multiple_id',optional($data)['multiple_id'],['class'=>'form-control'])}}
        </td>
        <th class="search_item_name">
          <label for="id">予約ID</label>
        </th>
        <td>
          {{Form::text('search_id',optional($data)['search_id'],['class'=>'form-control'])}}
        </td>
      </tr>
      <tr>
        <th class="search_item_name"><label for="date">利用日</label> </th>
        <td class="text-right form-group hasDatepicker">
          {{Form::text('reserve_date',optional($data)['reserve_date'], ['class'=>'form-control'])}}
        </td>
        <th class="search_item_name"><label for="venue">利用会場</label></th>
        <td class="text-right">
          <dd>
            <select class="form-control select2" name="venue_id">
              <option value=""></option>
              @foreach ($venues as $venue)
              @if (optional($data)['venue_id']==$venue)
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
          {{Form::text('user_id',optional($data)['user_id'],['class'=>'form-control'])}}
        </td>
        <th class="search_item_name">
          <label for="company">会社名・団体名</label>
        </th>
        <td class="text-right">
          {{Form::text('company',optional($data)['company'],['class'=>'form-control'])}}
        </td>
      </tr>
      <tr>
        <th class="search_item_name">
          <label for="person">担当者氏名</label>
        </th>
        <td class="text-right">
          {{Form::text('person_name',optional($data)['person_name'],['class'=>'form-control'])}}
        </td>
        <th class="search_item_name"><label for="agent">仲介会社</label></th>
        <td class="text-right">
          <select class="form-control select2" name="agent">
            <option value=""></option>
            @foreach ($agents as $key=>$value)
            @if (optional($data)['agent']==$key)
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
          {{Form::text('enduser_person',optional($data)['enduser_person'],['class'=>'form-control'])}}
        </td>
        <th class="search_item_name"><label for="sum">総額</label></th>
        <td>
          {{Form::text('amount',optional($data)['amount'],['class'=>'form-control'])}}
        </td>
      </tr>
      <tr>
        <th class="search_item_name"><label for="paydue">支払期日</label></th>
        <td class="text-right form-group">
          {{Form::text('payment_limit',optional($data)['payment_limit'], ['class'=>'form-control'])}}
        </td>
        <th class="search_item_name"><label for="billStatus">売上区分</label></th>
        <td>
          <ul class="search_category">
            <li>
              {{ Form::checkbox('sales1', '1',optional($data)['sales1']==1?true:false,['id'=>'sales1']) }}
              {{ Form::label('sales1', '会場予約') }}
            </li>
            <li>
              {{ Form::checkbox('sales2', '2',optional($data)['sales2']==2?true:false,['id'=>'sales2']) }}
              {{ Form::label('sales2', 'キャンセル') }}
            </li>
            <li>
              {{ Form::checkbox('sales3', '3',optional($data)['sales3']==3?true:false,['id'=>'sales3']) }}
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
              {{ Form::checkbox('check_status3', '3',optional($data)['check_status3']?true:false,['id'=>'status1']) }}
              {{ Form::label('status1', '予約完了') }}
            </li>
            <li>
              {{ Form::checkbox('check_status6', '6',optional($data)['check_status6']?true:false,['id'=>'status2']) }}
              {{ Form::label('status2', 'キャンセル') }}
            </li>
          </ul>
        </td>
        <th class="search_item_name"><label for="payStatus">入金状況</label></th>
        <td class="text-right">
          <ul class="search_category">
            <li>
              {{ Form::checkbox('payment_status0', '1',optional($data)['payment_status0']!=""?true:false,['id'=>'payment_status0']) }}
              {{ Form::label('payment_status0', '未入金') }}
            </li>
            <li>
              {{ Form::checkbox('payment_status1', '1',optional($data)['payment_status1']?true:false,['id'=>'payment_status1']) }}
              {{ Form::label('payment_status1', '入金済') }}
            </li>
            <li>
              {{ Form::checkbox('payment_status2', '2',optional($data)['payment_status2']?true:false,['id'=>'payment_status2']) }}
              {{ Form::label('payment_status2', '遅延') }}
            </li>
            <li>
              {{ Form::checkbox('payment_status3', '3',optional($data)['payment_status3']?true:false,['id'=>'payment_status3']) }}
              {{ Form::label('payment_status3', '入金不足') }}
            </li>
            <li>
              {{ Form::checkbox('payment_status4', '4',optional($data)['payment_status4']?true:false,['id'=>'payment_status4']) }}
              {{ Form::label('payment_status4', '入金過多') }}
            </li>
            <li>
              {{ Form::checkbox('payment_status5', '5',optional($data)['payment_status5']?true:false,['id'=>'payment_status5']) }}
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
              {{ Form::checkbox('alliance0', '1',optional($data)['alliance0']!=""?true:false,['id'=>'alliance0']) }}
              {{ Form::label('alliance0', '直営') }}
            </li>
            <li>
              {{ Form::checkbox('alliance1', '1',optional($data)['alliance1']!=""?true:false,['id'=>'alliance1']) }}
              {{ Form::label('alliance1', '提携') }}
            </li>
          </ul>
        </td>
        <th class="search_item_name"><label for="freeword">フリーワード検索</label>
        <td class="text-right">
          {{Form::text('free_word',optional($data)['free_word'], ['class'=>'form-control'])}}
        </td>
      </tr>
      <tr>
        <th class="search_item_name"><label for="enduser">支払日</label></th>
        <td class="text-right">
          {{Form::text('pay_day',optional($data)['pay_day'], ['class'=>'form-control'])}}
        </td>
        <th class="search_item_name"><label for="sum">振込人名</label></th>
        <td>
          {{Form::text('pay_person',optional($data)['pay_person'], ['class'=>'form-control'])}}
        </td>
      </tr>
      <tr>
        <th class="search_item_name"><label for="enduser">顧客属性</label>
        </th>
        <td class="text-right">
          {{Form::select('attr',[0=>"",1=>"一般企業",2=>"上場企業",3=>"近隣利用",4=>"個人講師",5=>"MLM",6=>"その他"],optional($data)['attr'],['class'=>'form-control'])}}
        </td>
      </tr>
    </tbody>
  </table>
  <p class="text-right">※フリーワード検索は本画面表記の項目のみ対象となります</p>
  <div class="btn_box d-flex justify-content-center">
    <a href="{{url('admin/sales')}}" class="btn reset_btn">リセット</a>
    {{Form::hidden('sales_search_box','sales_search_box', ['class'=>'form-control'])}}
    {{Form::submit('検索',['class'=>'btn search_btn','id'=>'m_submit'])}}
  </div>
</div>

{{Form::close()}}



<!-- 検索　終わり------------------------------------------------ -->

<div class="d-flex justify-content-between">
  <dl class="count-sum d-flex align-items-center">
    <dt>売上総額</dt>
    <dd>
      {{-- @foreach ($request->except('_token') as $item)
      @if (($item!=""))
      {{number_format($all_total_amount)}}
      @break
      @endif
      @endforeach --}}
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
  <table class="table table-bordered table-scroll" id="sales_sort" style="height: 100%;">
    <thead>
      <tr class="table_row">
        <th>予約一括ID
        </th>
        <th>予約ID </th>
        <th>利用日 </th>
        <th>利用会場 </th>
        <th>顧客ID </th>
        <th>会社名団体名 </th>
        <th>担当者氏名 </th>
        <th>仲介会社 </th>
        <th>エンドユーザー </th>
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
        <th>顧客属性 </th>
        <th>支払期日</th>
        <th>運営 </th>
      </tr>
    </thead>
    <tbody class="sale-body">
      @foreach ($reservations as $masterKey=>$reservation)

      <tr
        style="{{count($reservation['cxls'])>0?((int)$reservation['cxls'][0]['cxl_status']===2?"background:gray":""):""}}">
        <td class="text-center">
          {{ReservationHelper::fixId($reservation['multiple_reserve_id'])}}</td>
        <td class="text-center">
          {{ReservationHelper::fixId($reservation['id'])}}</td>
        <td class="text-center">
          {{ReservationHelper::formatDate($reservation['reserve_date'])}}</td>
        <td class="text-center">
          {{ReservationHelper::getVenue($reservation['venue_id'])}}</td>
        <td class="text-center">
          {{ReservationHelper::fixId($reservation['user_id'])}}</td>
        <td class="text-center">
          {{ReservationHelper::getCompany($reservation['user_id'])}}</td>
        <td class="text-center">
          {{ReservationHelper::getPersonName($reservation['user_id'])}}</td>
        <td class="text-center">
          {{ReservationHelper::getAgentCompany($reservation['agent_id'])}}</td>
        <td class="text-center">
          {{(optional($reservation['enduser'])['company'])}}</td>
        <td class="text-center">
          {{number_format($reservation['sogaku'])}}</td>
        <td class="multi-column p-0">
          <ul class="multi-column__list">
            @foreach ($reservation['bills'] as $bill) {{--売上--}}
            <li>
              <div class="multi-column__item">
                <span>{{number_format($bill['master_total'])}}</span>
              </div>
            </li>
            @endforeach
            @if (count($reservation['cxls'])>0) {{--打ち消し--}}
            <li>
              <div class="multi-column__item">
                <span>{{number_format($reservation['master_total']*-1)}}</span>
              </div>
            </li>
            <li> {{--キャンセル--}}
              <div class="multi-column__item">
                <span>{{number_format($reservation['cxls_master_total'])}}</span>
              </div>
            </li>
            @endif
          </ul>
        </td>
        <td class="p-0">
          <ul class="multi-column__list">
            @foreach ($reservation['bills'] as $bill) {{--売上--}}
            <li>
              <div class="multi-column__item">
                <span>{{number_format($bill['cost_for_partner'])}}</span>
              </div>
            </li>
            @endforeach
            @if (count($reservation['cxls'])>0) {{--打ち消し--}}
            <li>
              <div class="multi-column__item">
                <span>{{number_format($reservation['sum_cost_for_partner']*-1)}}</span>
              </div>
            </li>
            <li> {{--キャンセル--}}
              <div class="multi-column__item">
                <span>{{number_format($reservation['sum_cxl_cost_for_partner'])}}</span>
              </div>
            </li>
            @endif
          </ul>
        </td>
        <td class="p-0">
          <ul class="multi-column__list">
            @foreach ($reservation['bills'] as $bill) {{--売上--}}
            <li>
              <div class="multi-column__item">
                <span>{{number_format($bill['master_total']-$bill['cost_for_partner'])}}</span>
              </div>
            </li>
            @endforeach
            @if (count($reservation['cxls'])>0) {{--打ち消し--}}
            <li>
              <div class="multi-column__item">
                <span>{{number_format($reservation['master_total']*-1-($reservation['sum_cost_for_partner']*-1))}}</span>
              </div>
            </li>
            <li> {{--キャンセル--}}
              <div class="multi-column__item">
                <span>{{number_format((int)$reservation['cxls_master_total']-(int)$reservation['sum_cxl_cost_for_partner'])}}</span>
              </div>
            </li>
            @endif
          </ul>
        </td>
        <td class="p-0">
          <ul class="multi-column__list">
            @foreach ($reservation['bills'] as $key =>$bill) {{--売上--}}
            <li>
              <div class="multi-column__item">
                <span>{{(int)$bill['category']===1?"会場予約":"追加".$key}}</span>
              </div>
            </li>
            @endforeach
            @if (count($reservation['cxls'])>0) {{--打ち消し--}}
            <li>
              <div class="multi-column__item">
                <span>打ち消し</span>
              </div>
            </li>
            <li> {{--キャンセル--}}
              <div class="multi-column__item">
                <span>キャンセル料</span>
              </div>
            </li>
            @endif
          </ul>
        </td>
        <td class="p-0">
          <ul class="multi-column__list">
            @foreach ($reservation['bills'] as $key =>$bill) {{--売上--}}
            <li>
              <div class="multi-column__item">
                <span>{{ReservationHelper::judgeStatus((int)$bill['reservation_status'])}}</span>
              </div>
            </li>
            @endforeach
            @if (count($reservation['cxls'])>0) {{--打ち消し--}}
            <li>
              <div class="multi-column__item">
                <span>-</span>
              </div>
            </li>
            <li> {{--キャンセル--}}
              <div class="multi-column__item">
                <span>{{ReservationHelper::cxlStatus($reservation['cxls'][0]['cxl_status'])}}</span>
              </div>
            </li>
            @endif
          </ul>
        </td>
        <td class=" p-0">
          <ul class="multi-column__list">
            @foreach ($reservation['bills'] as $key =>$bill) {{--売上--}}
            <li>
              <div class="multi-column__item">
                <span>{{(ReservationHelper::formatDate($bill['pay_day']))}}</span>
              </div>
            </li>
            @endforeach
            @if (count($reservation['cxls'])>0) {{--打ち消し--}}
            <li>
              <div class="multi-column__item">
                <span>-</span>
              </div>
            </li>
            <li> {{--キャンセル--}}
              <div class="multi-column__item">
                <span>{{ReservationHelper::formatDate($reservation['cxls'][0]['pay_day'])}}</span>
              </div>
            </li>
            @endif
          </ul>
        </td>
        <td class=" p-0">
          <ul class="multi-column__list">
            @foreach ($reservation['bills'] as $key =>$bill) {{--売上--}}
            <li>
              <div class="multi-column__item">
                <span class="payment-status">{{(ReservationHelper::paidStatus($bill['paid']))}}</span>
              </div>
            </li>
            @endforeach
            @if (count($reservation['cxls'])>0) {{--打ち消し--}}
            <li>
              <div class="multi-column__item">
                <span>-</span>
              </div>
            </li>
            <li> {{--キャンセル--}}
              <div class="multi-column__item">
                <span class="payment-status">{{ReservationHelper::paidStatus($reservation['cxls'][0]['paid'])}}</span>
              </div>
            </li>
            @endif
          </ul>
        </td>
        <td class="text-center">
          <a class="more_btn" href="{{route('admin.reservations.show',$reservation['id'])}}">
            予約詳細
          </a>
        </td>
        <td class=" p-0">
          <ul class="multi-column__list">
            @foreach ($reservation['bills'] as $key =>$bill) {{--売上--}}
            <li>
              <div class="multi-column__item">
                <p class="text-limit">{{(($bill['pay_person']))}}</p>
              </div>
            </li>
            @endforeach
            @if (count($reservation['cxls'])>0) {{--打ち消し--}}
            <li>
              <div class="multi-column__item">
                <p class="text-limit">-</p>
              </div>
            </li>
            <li> {{--キャンセル--}}
              <div class="multi-column__item">
                <p class="text-limit">{{($reservation['cxls'][0]['pay_person'])}}</p>
              </div>
            </li>
            @endif
          </ul>
        </td>
        <td class="text-center">
          {{(ReservationHelper::getAttr(optional($reservation['user'])['attr']))}}
        </td>
        <td class=" p-0">
          <ul class="multi-column__list">
            @foreach ($reservation['bills'] as $key =>$bill) {{--売上--}}
            <li>
              <div class="multi-column__item">
                <span>{{((ReservationHelper::formatDate($bill['payment_limit'])))}}</span>
              </div>
            </li>
            @endforeach
            @if (count($reservation['cxls'])>0) {{--打ち消し--}}
            <li>
              <div class="multi-column__item">
                <span>-</span>
              </div>
            </li>
            <li> {{--キャンセル--}}
              <div class="multi-column__item">
                <span>{{ReservationHelper::formatDate($reservation['cxls'][0]['payment_limit'])}}</span>
              </div>
            </li>
            @endif
          </ul>
        </td>
        <td class="text-center" style="{{(int)$reservation['venue']['alliance_flag']===1?"color:red;":""}}">
          {{(int)$reservation['venue']['alliance_flag']===0?"直":"提"}}
        </td>
        {{-- <td class=" p-0">
          <div style="display: table; height:100%; vertical-align: middle; width:110px">
            @foreach ($reservation['bills'] as $bill)
            <div style="display: table-row;">
              <div
                style="display: table-cell; width:100%; vertical-align: middle; {{$loop->first?"border-bottom:solid 1px #dee2e6;":($loop->last?"":"border-bottom:solid 1px #dee2e6;")}class="text-center"}
        padding:5px;">
        <span style="color: white">{{$bill['id']}}</span>
</div>
</div>
@endforeach
</div>
</td> --}}
{{-- <td class=" p-0">
          <div style="display: table; height:100%; vertical-align: middle; width:110px">
            @foreach ($reservation['bills'] as $bill)
            <div style="display: table-row;">
              <div
                style="display: table-cell; width:100%; vertical-align: middle; {{$loop->first?"border-bottom:solid 1px #dee2e6;":($loop->last?"":"border-bottom:solid 1px #dee2e6;")}class="text-center"}
padding:5px;">
test
<span style="color: white">{{$bill['id']}}</span>
</div>
</div>
@endforeach
</div>
</td> --}}
{{-- <td class=" p-0">
          <div style="display: table; height:100%; vertical-align: middle; width:110px">
            @foreach ($reservation['bills'] as $bill)
            <div style="display: table-row;">
              <div
                style="display: table-cell; width:100%; vertical-align: middle; {{$loop->first?"border-bottom:solid 1px #dee2e6;":($loop->last?"":"border-bottom:solid 1px #dee2e6;")}class="text-center"}
padding:5px;">
test
<span style="color: white">{{$bill['id']}}</span>
</div>
</div>
@endforeach
</div>
</td> --}}
{{-- <td class=" p-0">
          <div style="display: table; height:100%; vertical-align: middle; width:110px">
            @foreach ($reservation['bills'] as $bill)
            <div style="display: table-row;">
              <div
                style="display: table-cell; width:100%; vertical-align: middle; {{$loop->first?"border-bottom:solid 1px #dee2e6;":($loop->last?"":"border-bottom:solid 1px #dee2e6;")}class="text-center"}
padding:5px;">
test
<span style="color: white">{{$bill['id']}}</span>
</div>
</div>
@endforeach
</div>
</td> --}}
{{-- <td class=" p-0">
  <div style="display: table; height:100%; vertical-align: middle; width:110px">
    @foreach ($reservation['bills'] as $bill)
    <div style="display: table-row;">
      <div
        style="display: table-cell; width:100%; vertical-align: middle; {{$loop->first?"border-bottom:solid 1px #dee2e6;":($loop->last?"":"border-bottom:solid 1px #dee2e6;")}class="text-center"}
padding:5px;">
test
<span style="color: white">{{$bill['id']}}</span>
</div>
</div>
@endforeach
</div>
</td>
<td></td>
<td class=" p-0">
  <div style="display: table; height:100%; vertical-align: middle; width:110px">
    @foreach ($reservation['bills'] as $bill)
    <div style="display: table-row;">
      <div
        style="display: table-cell; width:100%; vertical-align: middle; {{$loop->first?"border-bottom:solid 1px #dee2e6;":($loop->last?"":"border-bottom:solid 1px #dee2e6;")}} padding:5px;"
        class="text-center">
        test
        <span style="color: white">{{$bill['id']}}</span>
      </div>
    </div>
    @endforeach
  </div>
</td>
<td></td>
<td class=" p-0">
  <div style="display: table; height:100%; vertical-align: middle; width:110px">
    @foreach ($reservation['bills'] as $bill)
    <div style="display: table-row;">
      <div
        style="display: table-cell; width:100%; vertical-align: middle; {{$loop->first?"border-bottom:solid 1px #dee2e6;":($loop->last?"":"border-bottom:solid 1px #dee2e6;")}} padding:5px;"
        class="text-center">
        test
        <span style="color: white">{{$bill['id']}}</span>
      </div>
    </div>
    @endforeach
  </div>
</td>
<td></td> --}}
</tr>
{{-- @for ($i = 0; $i < $reservation->billCount(); $i++)
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
<td>
  {{number_format($reservation->venue->getCostForPartner($reservation->venue, $reservation->bills->sortBy("id")->first()->master_total, $reservation->bills->sortBy("id")->first()->layout_price,$reservation))}}円
</td>
<td>
  {{number_format($reservation->venue->getProfitForPartner($reservation->venue, $reservation->bills->sortBy("id")->first()->master_total, $reservation->bills->sortBy("id")->first()->layout_price,$reservation))}}円
</td>
<td>
  {{($reservation->bills->sortBy("id")->first()->category==1?"会場予約":"")}}
</td>
<td>
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
  <td>
    {{'追加'.$i}}
  </td>
  <td>
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

@if ($reservation->cxls->count()>0)

<tr>
  <td>
    {{number_format(($reservation->totalBillAmount())*-1)}}円
  </td>
  <td>
    {{number_format(($reservation->venue->sumCostForPartner($reservation))*-1)}}円
  </td>
  <td>
    {{number_format((($reservation->totalBillAmount())*-1)-(($reservation->venue->sumCostForPartner($reservation))*-1))}}
  </td>
  <td>
    打ち消し
  </td>
  <td>
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

  <td>{{number_format($reservation->cxlCost())}}円</td>

  <td>{{number_format($reservation->cxlProfit())}}円</td>
  <td>
    キャンセル料
  </td>
  <td>
    {{ReservationHelper::cxlStatus($reservation->cxls->first()->cxl_status)}}
  </td>
  <td>
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
@endif --}}
@endforeach
</tbody>
</table>
</div>
<!-- 一覧　　終わり------------------------------------------------ -->


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
    ActiveDateRangePicker('payment_limit');
    ActiveDateRangePicker('pay_day');
  })

$(function(){
  $('.payment-status').each(function(index, value){
    var target=$(value).text();
    console.log(target);
    if (target.match(/未入金/)) {
      $(value).css('font-weight','bold');
    }
  });
  $('span').each(function(index, value){
    var target=$(value).text();
    if (target.match(/-/)) {
    $(value).css('color','red');
    }
    });
});
</script>
<script>
  $(document).ready(function(){
    $.extend($.fn.dataTable.defaults, {
        language: {
            url: "https://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Japanese.json"
        }
    });
    $('#sales_sort').DataTable({
      searching: false,
      info: false,
      autowidth: false,
      // "order": [[ 1, "desc" ]], //初期ソートソート条件
      "columnDefs": [{ "orderable": false, "targets": [10,11,12,13,14,15,16,18,20] }],
      "stripeClasses": [],
     });
    });
</script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

@endsection