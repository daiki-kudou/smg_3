@extends('layouts.admin.app')
@section('content')

<link href="{{ asset('/css/template.css') }}" rel="stylesheet">
<script src="{{ asset('/js/template.js') }}"></script>
<script src="{{ asset('/js/admin/search/validation.js') }}"></script>


@if (session('flash_message'))
<div class="flash_message bg-success text-center py-3 my-0">
  {{ session('flash_message') }}
</div>
@endif

<style>
  .svg {
    width: 20px;
    height: 20px;
  }
</style>

<div class="content">
  <div class="container-fluid">
    <div class="container-field mt-3">

      <h2 class="mt-3 mb-3">予約一覧</h2>
      <hr>
    </div>

    {{ Form::open(['url' => 'admin/reservations', 'method'=>'get', 'id'=>'reserve_search'])}}
    @csrf
    <div class="search-wrap">
      <table class="table table-bordered">
        <tbody>
          <tr>
            <th class="search_item_name">
              <label for="multiple_id">予約一括ID</label>
            <td class="text-right">
              {{ Form::text('multiple_id', $request->multiple_id, ['class' => 'form-control', 'id'=>'multiple_id']) }}
              <p class="is-error-multiple_id" style="color: red"></p>
            </td>
            <th class="search_item_name">
              <label for="search_id">予約ID</label>
            </th>
            <td>
              {{ Form::text('search_id', $request->search_id, ['class' => 'form-control', 'id'=>'']) }}
              <p class="is-error-search_id" style="color: red"></p>
            </td>
          </tr>
          <tr>
            <th class="search_item_name">
              <label for="date">利用日</label>
            </th>
            <td class="text-right form-group">
              {{ Form::text('reserve_date', $request->reserve_date, ['class' => 'form-control', 'id'=>'']) }}
            </td>
            <th class="search_item_name"><label for="time">入室・退室</label></th>
            <td class="text-right">
              <div class="d-flex align-items-center">
                <select class="form-control select2" name="enter_time">
                  <option value=""></option>
                  {!!ReservationHelper::timeOptionsWithRequest($request->enter_time)!!}
                </select>
                <span>～</span>
                <select class="form-control select2" name="leave_time">
                  <option value=""></option>
                  {!!ReservationHelper::timeOptionsWithRequest($request->leave_time)!!}
                </select>
              </div>
            </td>
          </tr>
          <tr>
            <th class="search_item_name">
              <label for="venue">利用会場</label>
            </th>
            <td class="text-right">
              <select class="form-control select2" name="venue_id">
                <option value=""></option>
                @foreach ($venues as $venue)
                <option value="{{$venue['id']}}" {{$venue['id']==$request->venue_id?"selected":""}}>
                  {{ReservationHelper::getVenue($venue['id'])}}
                </option>
                @endforeach
              </select>
            </td>
            <th class="search_item_name">
              <label for="company">会社・団体名</label>
            </th>
            <td class="text-right">
              {{ Form::text('company', $request->company, ['class' => 'form-control', 'id'=>'']) }}
            </td>
          </tr>
          <tr>
            <th class="search_item_name">
              <label for="person_name">担当者氏名</label>
            </th>
            <td class="text-right">
              {{ Form::text('person_name', $request->person_name, ['class' => 'form-control', 'id'=>'']) }}
            </td>
            <th class="search_item_name">
              <label for="search_mobile">携帯電話</label>
            </th>
            <td>
              {{ Form::text('search_mobile', $request->search_mobile, ['class' => 'form-control', 'id'=>'']) }}
              <p class="is-error-search_mobile" style="color: red"></p>
            </td>
          </tr>
          <tr>
            <th class="search_item_name">
              <label for="search_tel">固定電話</label>
            </th>
            <td>
              {{ Form::text('search_tel', $request->search_tel, ['class' => 'form-control', 'id'=>'']) }}
              <p class="is-error-search_tel" style="color: red"></p>
            </td>
            <th class="search_item_name">
              <label for="agent">仲介会社</label>
            </th>
            <td class="text-right">
              <select class="form-control select2" style="width: 100%;" name="agent">
                <option value=""></option>
                @foreach ($agents as $agent)
                <option value="{{$agent['id']}}" {{$agent['id']==$request->agent?"selected":""}}>
                  {{ReservationHelper::getAgentCompany($agent['id'])}}
                </option>
                @endforeach
              </select>
            </td>
          </tr>
          <tr>
            <th class="search_item_name">
              <label for="enduser_person">エンドユーザー</label>
            </th>
            <td class="text-right">
              {{ Form::text('enduser_person', $request->enduser_person, ['class' => 'form-control', 'id'=>'']) }}
            </td>
            <th class="search_item_name">
              <label for="category">アイコン</label>
            </th>
            <td class="text-right">
              <ul class="search_category">
                <li>
                  {{Form::checkbox('check_icon1', 2, $request->check_icon1?true:false,['id'=>'checkboxPrimary1'])}}
                  {{Form::label("checkboxPrimary1","有料備品")}}
                </li>
                <li>
                  {{Form::checkbox('check_icon2', 3, $request->check_icon2?true:false,['id'=>'checkboxPrimary2'])}}
                  {{Form::label("checkboxPrimary2","有料サービス")}}
                </li>
                <li>
                  {{Form::checkbox('check_icon3', 4, $request->check_icon3?true:false,['id'=>'checkboxPrimary3'])}}
                  {{Form::label("checkboxPrimary3","レイアウト")}}
                </li>
                <li>
                  {{Form::checkbox('check_icon4', 5, $request->check_icon4!=""?true:false,['id'=>'checkboxPrimary4'])}}
                  {{Form::label("checkboxPrimary4","ケータリング")}}
                </li>
              </ul>
            </td>
          </tr>
          <tr>
            <th class="search_item_name"><label for="Status">予約状況</label></th>
            <td colspan="3">
              <ul class="search_category">
                <li>
                  {{Form::checkbox('check_status1', 1, $request->check_status1?true:false,['id'=>'check_status1'])}}
                  {{Form::label("check_status1","予約確認中")}}
                </li>
                <li>
                  {{Form::checkbox('check_status2', 2, $request->check_status2?true:false,['id'=>'check_status2'])}}
                  {{Form::label("check_status2","予約承認待ち")}}
                </li>
                <li>
                  {{Form::checkbox('check_status3', 3, $request->check_status3?true:false,['id'=>'check_status3'])}}
                  {{Form::label("check_status3","予約完了")}}
                </li>
                <li>
                  {{Form::checkbox('check_status4', 4, $request->check_status4?true:false,['id'=>'check_status4'])}}
                  {{Form::label("check_status4","キャンセル申請中")}}
                </li>
                <li>
                  {{Form::checkbox('check_status5', 5, $request->check_status5?true:false,['id'=>'check_status5'])}}
                  {{Form::label("check_status5","キャンセル承認待ち")}}
                </li>
                <li>
                  {{Form::checkbox('check_status6', 6, $request->check_status6?true:false,['id'=>'check_status6'])}}
                  {{Form::label("check_status6","キャンセル")}}
                </li>
              </ul>
            </td>
          </tr>
          <tr>
            <th class="search_item_name"><label for="freeword">フリーワード検索</label></th>
            <td colspan="3">
              {{ Form::text('freeword', $request->freeword, ['class' => 'form-control', 'id'=>'']) }}
            </td>
          </tr>
        </tbody>
      </table>
      <p class="text-right">※フリーワード検索は本画面表記の項目のみ対象となります</p>
      <div class="btn_box d-flex justify-content-center">
        <a href="{{url('admin/reservations')}}" class="btn reset_btn">リセット</a>
        {{ Form::submit('検索', ['class' => 'btn search_btn', "id"=>"m_submit"]) }}
      </div>
    </div>

    <div class="d-flex justify-content-between">
      <ul class="d-flex reservation_list">
        <li>
          {{ Form::submit('前日予約', ['class' => 'btn more_btn','name'=>'day_before','id'=>'day_before']) }}
        </li>
        <li>
          {{ Form::submit('当日予約', ['class' => 'btn more_btn','name'=>'today','id'=>'today']) }}
        </li>
        <li>
          {{ Form::submit('翌日予約', ['class' => 'btn more_btn','name'=>'day_after','id'=>'day_after']) }}
        </li>
      </ul>
      {{ Form::close() }}

      @if ($counter!=0)
      <p class="font-weight-bold">
        <span class="count-color">
          {{$counter}}</span>件
      </p>
      @endif
    </div>
    <div class="table-wrap">
      <table class="table table-bordered " id="reservation_sort" style="height: 100%;">
        <thead>
          <tr class="table_row">
            <th>予約一括ID</th>
            <th>予約ID </th>
            <th>利用日 </th>
            <th>入室 </th>
            <th>退室 </th>
            <th>利用会場 </th>
            <th>会社名団体名 </th>
            <th>担当者氏名 </th>
            <th>携帯電話 </th>
            <th>固定電話 </th>
            <th>仲介会社 </th>
            <th>エンドユーザー </th>
            <th>アイコン</th>
            <th width="120">売上区分</th>
            <th width="120">予約状況</th>
            <th class="text-center">予約詳細</th>
            <th class="text-center">案内板</th>
          </tr>
        </thead>

        {{-- <style>
          .cxl_gray {
            background: gray;
          }
        </style> --}}
        {{-- <tbody>
          @foreach ($reservations as $reservation)
          <tr class="{{$reservation->cxlGray()? "cxl_gray":""}}">
        <td>
          {{ReservationHelper::fixId($reservation->multiple_reserve_id)}}
        </td>
        <td class="text-center" data-order="{{$reservation->id}}">
          {{ReservationHelper::fixId($reservation->id)}}</td>
        <td>
          {{ReservationHelper::formatDate($reservation->reserve_date)}}
        </td>
        <td>{{ReservationHelper::formatTime($reservation->enter_time)}}
        </td>
        <td>{{ReservationHelper::formatTime($reservation->leave_time)}}
        </td>
        <td>
          {{ReservationHelper::getVenue($reservation->venue->id)}}
        </td>
        <td>
          @if ($reservation->user_id>0)
          {{$reservation->user->company}}
          @endif
        </td>
        @if ($reservation->user_id>0)
        <td>
          {{ReservationHelper::getPersonName($reservation->user_id)}}
          @elseif($reservation->user_id==0)
        <td>
          @endif
        </td>
        <td>
          @if ($reservation->user_id>0)
          {{$reservation->user->mobile}}
          @endif
        </td>
        <td>
          @if ($reservation->user_id>0)
          {{$reservation->user->tel}}
          @endif
        </td>
        <td>
          @if ($reservation->agent_id>0)
          {{ReservationHelper::getAgentCompany($reservation->agent_id)}}
          @endif
        </td>
        <td>
          @if ($reservation->agent_id>0)
          {{!empty($reservation->endusers->company)?$reservation->endusers->company:""}}
          @endif
        </td>
        <td class="p-0">
          <div style="display: table; height:100%; vertical-align: middle; width:110px">
            @foreach ($reservation->bills as $bill)
            <div style="display: table-row;">
              <div
                style="display: table-cell; width:100%; vertical-align: middle; {{$loop->first?"border-bottom:solid 1px #dee2e6;":($loop->last?"":"border-bottom:solid 1px #dee2e6;")}} padding:5px;">
                @foreach (ImageHelper::addBillsShow($bill->id) as $icon)
                {!!$icon!!}
                @endforeach
                @if ($loop->first)
                {!!ImageHelper::catering($reservation->id)!!}
                {!!ImageHelper::newUser($reservation->user_id,$reservation->id)!!}
                @endif
                <span style="color: white; width:1px;">{{$bill->id}}</span>
              </div>
            </div>
            @endforeach
          </div>
        </td>
        <td class=" p-0">
          <div style="display: table; height:100%; vertical-align: middle; width:110px">
            @foreach ($reservation->bills as $bill)
            <div style="display: table-row;">
              <div
                style="display: table-cell; width:100%; vertical-align: middle; {{$loop->first?"border-bottom:solid 1px #dee2e6;":($loop->last?"":"border-bottom:solid 1px #dee2e6;")}} padding:5px;">
                {{((int)$bill->category===1?"会場予約":"追加請求")}}
                <span style="color: white">{{$bill->id}}</span>
              </div>
            </div>
            @endforeach
          </div>
        </td>
        <td class="p-0">
          <div style="display: table; height:100%; vertical-align: middle; width:110px">
            @foreach ($reservation->bills as $bill)
            <div style="display: table-row;">
              <div
                style="display: table-cell; width:100%; vertical-align: middle; {{$loop->first?"border-bottom:solid 1px #dee2e6;":($loop->last?"":"border-bottom:solid 1px #dee2e6;")}} padding:5px;">
                {{ReservationHelper::judgeStatus($bill->reservation_status)}}
                <span style="color: white">{{$bill->id}}</span>
              </div>
            </div>
            @endforeach
          </div>
        </td>
        <td class="text-center"><a href="{{ url('admin/reservations', $reservation->id) }}" class="more_btn btn">詳細</a>
        </td>
        <td class="text-center">
          @if ($reservation->board_flag!=0)
          {{ Form::open(['url' => 'admin/board', 'method'=>'post', 'id'=>'', 'target'=>'_blank'])}}
          @csrf
          {{Form::hidden('reservation_id',$reservation->id)}}
          {{Form::submit('表示', ['class' => 'btn more_btn']) }}
          {{Form::close()}}
          @endif
        </td>
        </tr>
        @endforeach
        </tbody> --}}
      </table>
    </div>
  </div>
</div>




<script>
  $(function() {
    $('.flash_message').fadeOut(3000);
  })

  $(function(){
    $('#day_before, #today, #day_after').on('click',function(){
      $('input[type="text"]').each(function($key,$value){
        $($value).val('');
      })
    })
  })

  $(function() {
    function ActiveDateRangePicker($target) {
      $("input[name='" + $target + "']").daterangepicker({
        "locale": {
          "format": "YYYY-MM-DD",
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
        $(this).val(picker.startDate.format('YYYY-MM-DD') + ' ~ ' + picker.endDate.format('YYYY-MM-DD'));
      });
      $("input[name='" + $target + "']").on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('');
      });
    }
    ActiveDateRangePicker('reserve_date');
  })
</script>

<script>
  $(document).ready(function(){
    $.extend($.fn.dataTable.defaults, {
        language: {
            url: "https://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Japanese.json"
        }
    });
    $('#reservation_sort').DataTable({
      order:[],
      processing: true,
      serverSide: true,
      searching: false,
      info: false,
      autowidth: false,
      ajax: { 
        "url": "{{ url('admin/reservations/datatable') }}", 
        "type": "GET",
        "data": function ( d ) {
            return $.extend( {}, d, {
            "search_id": $('input[name="search_id"]').val(),
            "reserve_date": $('input[name="reserve_date"]').val(),
            "enter_time": $('select[name="enter_time"]').val(),
            "leave_time": $('select[name="leave_time"]').val(),
            "venue_id": $('select[name="venue_id"]').val(),
            "company": $('input[name="company"]').val(),
            "person_name": $('input[name="person_name"]').val(),
            "search_mobile": $('input[name="search_mobile"]').val(),
            "search_tel": $('input[name="search_tel"]').val(),
            "agent": $('select[name="agent"]').val(),
            "enduser_person": $('input[name="enduser_person"]').val(),
          } );
        }
      },
      columns: [
        { data: 'multiple_reserve_id' },
        { data: 'reservation_id' },
        { data: 'reserve_date' },
        { data: 'enter_time' },
        { data: 'leave_time' },
        { data: 'venue_name' },
        { data: 'company_name' },
        { data: 'user_name' },
        { data: 'mobile' },
        { data: 'tel' },
        { data: 'agent_name' },
        { data: 'enduser_company' },
        { data: 'icon' },
        { data: 'category' },
        { data: 'reservation_status' },
        { data: 'details' },
        { data: 'board' },
      ],
      columnDefs: [
        {targets: 12, sortable: false, orderable: false},
        {targets: 13, sortable: false, orderable: false},
        {targets: 14, sortable: false, orderable: false},
        {targets: 15, sortable: false, orderable: false},
        {targets: 16, sortable: false, orderable: false},
      ],
     });
    });
</script>



<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

@endsection