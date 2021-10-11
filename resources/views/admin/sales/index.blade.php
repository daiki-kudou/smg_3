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

  #sales_sort tbody td:nth-child(11),
  #sales_sort tbody td:nth-child(12),
  #sales_sort tbody td:nth-child(13),
  #sales_sort tbody td:nth-child(14),
  #sales_sort tbody td:nth-child(15),
  #sales_sort tbody td:nth-child(16),
  #sales_sort tbody td:nth-child(17),
  #sales_sort tbody td:nth-child(18),
  #sales_sort tbody td:nth-child(19) {
    padding: 0 !important;
    white-space: nowrap;
  }

  #sales_sort tbody td {
    text-align: center;
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
          {{Form::text('sogaku',optional($data)['sogaku'],['class'=>'form-control'])}}
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
      <span>円</span></dd>
  </dl>


  {{ Form::open(['url' => 'admin/csv', 'method'=>'post']) }}
  @csrf
  {{-- {{Form::hidden('csv_arrays',json_encode($for_csv))}} --}}
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
  <table class="table table-bordered compact hover order-column" id="sales_sort" style="height: 100%;">
    <thead>
      <tr class="table_row">
        <th>予約一括ID</th>
        <th>予約ID</th>
        <th>利用日</th>
        <th>利用会場</th>
        <th>顧客ID</th>
        <th>会社名団体名</th>
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
    {{-- <tbody class="sale-body">
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
        @foreach ($reservation['bills'] as $bill)
        <!--売上-->
        <li>
          <div class="multi-column__item">
            <span>{{number_format($bill['master_total'])}}</span>
          </div>
        </li>
        @endforeach
        @if (count($reservation['cxls'])>0)
        <!--打ち消し-->
        <li>
          <div class="multi-column__item">
            <span>{{number_format($reservation['master_total']*-1)}}</span>
          </div>
        </li>
        <li>
          <!--キャンセル-->
          <div class="multi-column__item">
            <span>{{number_format($reservation['cxls_master_total'])}}</span>
          </div>
        </li>
        @endif
      </ul>
    </td>
    <td class="p-0">
      <ul class="multi-column__list">
        @foreach ($reservation['bills'] as $bill)
        <!--売上-->
        <li>
          <div class="multi-column__item">
            <span>{{number_format($bill['cost_for_partner'])}}</span>
          </div>
        </li>
        @endforeach
        @if (count($reservation['cxls'])>0)
        <!--打ち消し-->
        <li>
          <div class="multi-column__item">
            <span>{{number_format($reservation['sum_cost_for_partner']*-1)}}</span>
          </div>
        </li>
        <li>
          <!--キャンセル-->
          <div class="multi-column__item">
            <span>{{number_format($reservation['sum_cxl_cost_for_partner'])}}</span>
          </div>
        </li>
        @endif
      </ul>
    </td>
    <td class="p-0">
      <ul class="multi-column__list">
        @foreach ($reservation['bills'] as $bill)
        <!--売上-->
        <li>
          <div class="multi-column__item">
            <span>{{number_format($bill['master_total']-$bill['cost_for_partner'])}}</span>
          </div>
        </li>
        @endforeach
        @if (count($reservation['cxls'])>0)
        <!--打ち消し-->
        <li>
          <div class="multi-column__item">
            <span>{{number_format($reservation['master_total']*-1-($reservation['sum_cost_for_partner']*-1))}}</span>
          </div>
        </li>
        <li>
          <!--キャンセル-->
          <div class="multi-column__item">
            <span>{{number_format((int)$reservation['cxls_master_total']-(int)$reservation['sum_cxl_cost_for_partner'])}}</span>
          </div>
        </li>
        @endif
      </ul>
    </td>
    <td class="p-0">
      <ul class="multi-column__list">
        @foreach ($reservation['bills'] as $key =>$bill)
        <!--売上-->
        <li>
          <div class="multi-column__item">
            <span>{{(int)$bill['category']===1?"会場予約":"追加".$key}}</span>
          </div>
        </li>
        @endforeach
        @if (count($reservation['cxls'])>0)
        <!--打ち消し-->
        <li>
          <div class="multi-column__item">
            <span>打ち消し</span>
          </div>
        </li>
        <li>
          <!--キャンセル-->
          <div class="multi-column__item">
            <span>キャンセル料</span>
          </div>
        </li>
        @endif
      </ul>
    </td>
    <td class="p-0">
      <ul class="multi-column__list">
        @foreach ($reservation['bills'] as $key =>$bill)
        <!--売上-->
        <li>
          <div class="multi-column__item">
            <span>{{ReservationHelper::judgeStatus((int)$bill['reservation_status'])}}</span>
          </div>
        </li>
        @endforeach
        @if (count($reservation['cxls'])>0)
        <!--打ち消し-->
        <li>
          <div class="multi-column__item">
            <span>-</span>
          </div>
        </li>
        <li>
          <!--キャンセル-->
          <div class="multi-column__item">
            <span>{{ReservationHelper::cxlStatus($reservation['cxls'][0]['cxl_status'])}}</span>
          </div>
        </li>
        @endif
      </ul>
    </td>
    <td class=" p-0">
      <ul class="multi-column__list">
        @foreach ($reservation['bills'] as $key =>$bill)
        <!--売上-->
        <li>
          <div class="multi-column__item">
            <span>{{(ReservationHelper::formatDate($bill['pay_day']))}}</span>
          </div>
        </li>
        @endforeach
        @if (count($reservation['cxls'])>0)
        <!--打ち消し-->
        <li>
          <div class="multi-column__item">
            <span>-</span>
          </div>
        </li>
        <li>
          <!--キャンセル-->
          <div class="multi-column__item">
            <span>{{ReservationHelper::formatDate($reservation['cxls'][0]['pay_day'])}}</span>
          </div>
        </li>
        @endif
      </ul>
    </td>
    <td class=" p-0">
      <ul class="multi-column__list">
        @foreach ($reservation['bills'] as $key =>$bill)
        <!--売上-->
        <li>
          <div class="multi-column__item">
            <span class="payment-status">{{(ReservationHelper::paidStatus($bill['paid']))}}</span>
          </div>
        </li>
        @endforeach
        @if (count($reservation['cxls'])>0)
        <!--打ち消し-->
        <li>
          <div class="multi-column__item">
            <span>-</span>
          </div>
        </li>
        <li>
          <!--キャンセル-->
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
        @foreach ($reservation['bills'] as $key =>$bill)
        <!--売上-->
        <li>
          <div class="multi-column__item">
            <p class="text-limit">{{(($bill['pay_person']))}}</p>
          </div>
        </li>
        @endforeach
        @if (count($reservation['cxls'])>0)
        <!--打ち消し-->
        <li>
          <div class="multi-column__item">
            <p class="text-limit">-</p>
          </div>
        </li>
        <li>
          <!--キャンセル-->
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
        @foreach ($reservation['bills'] as $key =>$bill)
        <!--売上-->
        <li>
          <div class="multi-column__item">
            <span>{{((ReservationHelper::formatDate($bill['payment_limit'])))}}</span>
          </div>
        </li>
        @endforeach
        @if (count($reservation['cxls'])>0)
        <!--打ち消し-->
        <li>
          <div class="multi-column__item">
            <span>-</span>
          </div>
        </li>
        <li>
          <!--キャンセル-->
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
    </tr>
    @endforeach
    </tbody> --}}
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
        $(this).val(picker.startDate.format('YYYY/MM/DD') + ' ~ ' + picker.endDate.format('YYYY/MM/DD'));
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
      order:[],
      processing: true,
      serverSide: true,
      searching: false,
      info: false,
      autowidth: false,
      ajax: { 
        "url": "{{ url('admin/sales/datatable') }}", 
        "type": "GET",
        "data": function ( d ) {
            return $.extend( {}, d, {
            "search_id": $('input[name="search_id"]').val(),
            "reserve_date": $('input[name="reserve_date"]').val(),
            "venue_id": $('select[name="venue_id"]').val(),
            "user_id": $('input[name="user_id"]').val(),
            "company": $('input[name="company"]').val(),
            "person_name": $('input[name="person_name"]').val(),
            "agent": $('select[name="agent"]').val(),
            "enduser_person": $('input[name="enduser_person"]').val(),
            "sogaku": $('input[name="sogaku"]').val(),
            "payment_limit": $('input[name="payment_limit"]').val(),
            // "check_icon1": $('#checkboxPrimary1').prop('checked')?1:0,
            // "check_icon2": $('#checkboxPrimary2').prop('checked')?1:0,
            // "check_icon3": $('#checkboxPrimary3').prop('checked')?1:0,
            // "check_icon4": $('#checkboxPrimary4').prop('checked')?1:0,
            // "check_status1": $('#check_status1').prop('checked')?1:0,
            // "check_status2": $('#check_status2').prop('checked')?1:0,
            // "check_status3": $('#check_status3').prop('checked')?1:0,
            // "check_status4": $('#check_status4').prop('checked')?1:0,
            // "check_status5": $('#check_status5').prop('checked')?1:0,
            // "check_status6": $('#check_status6').prop('checked')?1:0,
          } );
        }
      },
      columns: [
        { data: 'multiple_reserve_id' },
        { data: 'reservation_id' },
        { data: 'reserve_date' },
        { data: 'venue_name' },
        { data: 'user_id'},
        { data: 'company_name' },
        { data: 'person_name' },
        { data: 'agent_name' },
        { data: 'enduser_company' },
        { data: 'sogaku' },
        { data: 'sales' },
        { data: 'cost' },
        { data: 'profit' },
        { data: 'category' },
        { data: 'reservation_status' },
        { data: 'pay_day' },
        { data: 'paid' },
        { data: 'details' },
        { data: 'pay_person' },
        { data: 'attr' },
        { data: 'payment_limit' },
        { data: 'alliance_flag' },
      ],
      columnDefs: [
        {targets: 10, sortable: false, orderable: false},
        {targets: 11, sortable: false, orderable: false},
        {targets: 12, sortable: false, orderable: false},
        {targets: 13, sortable: false, orderable: false},
        {targets: 14, sortable: false, orderable: false},
        {targets: 15, sortable: false, orderable: false},
        {targets: 16, sortable: false, orderable: false},
        {targets: 17, sortable: false, orderable: false},
        {targets: 18, sortable: false, orderable: false},
        {targets: 19, sortable: false, orderable: false},
        {targets: 20, sortable: false, orderable: false},
      ],
     });
    });
</script>


<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

@endsection