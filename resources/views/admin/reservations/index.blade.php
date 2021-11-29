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

  #reservation_sort tbody td:nth-child(13),
  #reservation_sort tbody td:nth-child(14),
  #reservation_sort tbody td:nth-child(15) {
    padding: 0 !important;
  }
</style>

<div class="content">
  <div class="container-fluid">
    <div class="container-field mt-3">

      <h2 class="mt-3 mb-3">予約一覧</h2>
      <hr>
    </div>

    {{ Form::open(['url' => '/admin/reservations', 'method'=>'get', 'id'=>'reserve_search'])}}
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
              {{ Form::text('search_id', $request->search_id, ['class' => 'form-control', 'id'=>'search_id']) }}
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
                  {{Form::checkbox('check_icon1', 1, $request->check_icon1?true:false,['id'=>'checkboxPrimary1'])}}
                  {{Form::label("checkboxPrimary1","有料備品")}}
                </li>
                <li>
                  {{Form::checkbox('check_icon2', 1, $request->check_icon2?true:false,['id'=>'checkboxPrimary2'])}}
                  {{Form::label("checkboxPrimary2","有料サービス")}}
                </li>
                <li>
                  {{Form::checkbox('check_icon3', 1, $request->check_icon3?true:false,['id'=>'checkboxPrimary3'])}}
                  {{Form::label("checkboxPrimary3","レイアウト")}}
                </li>
                <li>
                  {{Form::checkbox('check_icon4', 1, $request->check_icon4!=""?true:false,['id'=>'checkboxPrimary4'])}}
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
              {{ Form::text('free_word', $request->free_word, ['class' => 'form-control', 'id'=>'']) }}
            </td>
          </tr>
        </tbody>
      </table>
      <div class="annotation text-left">
        <p>※フリーワード検索は本画面表記の項目のみ対象となります</p>
        <p>※フリーワード検索時、「0~9, カンマ」は数値として検索しそれ以外の入力は文字列として検索します。</p>
        <p>※フリーワード検索時、数値の検索対象は「予約一括ID・予約ID・携帯電話・固定電話」です。</p>
        <p>※フリーワード検索時、文字列の検索対象は「利用日・入室時間・退室時間・利用会場・会社名団体名・担当者氏名・仲介会社・エンドユーザー」です。</p>
        <p>※フリーワードにて日付検索時のフォーマットは「年(4桁)-月(2桁)-日(2桁)」です。（例: 2021-12-31）</p>
        <p>※フリーワードにて時間検索時のフォーマットは「時(2桁):分(2桁)」の30分刻みです。（例: 12:30）</p>
        <p>※入退室時間にて検索する際、入室時間・退室時間のいずれか一方のみに入力があった場合、入室時間以上・退室時間未満に該当するすべての予約が表示されます</p>
        <p>※担当者氏名の検索時は、フルネーム時はスペース禁止</p>
      </div>

      <div class="btn_box d-flex justify-content-center">
        <a href="{{url('/admin/reservations')}}" class="btn reset_btn">リセット</a>
        {{ Form::submit('検索', ['class' => 'btn search_btn', "id"=>"m_submit"]) }}
      </div>
    </div>

    <div class="d-flex justify-content-between">
      <ul class="d-flex reservation_list">
        <li>
          <button type="button" class="btn more_btn" id="day_before">前日予約</button>
          {{ Form::hidden('day_before', $request->day_before) }}
        </li>
        <li>
          <button type="button" class="btn more_btn" id="today">当日予約</button>
          {{ Form::hidden('today', $request->today) }}
        </li>
        <li>
          <button type="button" class="btn more_btn" id="day_after">翌日予約</button>
          {{ Form::hidden('day_after', $request->day_after) }}
        </li>
      </ul>
      {{ Form::close() }}

      @if ($request->except('_token'))
      <p class="font-weight-bold">
        <span class="count-color">
          {{$counter}}</span>件
      </p>
      @endif

    </div>
    <div class="table-wrap">
      <table class="table table-bordered compact hover order-column" id="reservation_sort" style="height: 100%;">
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
      </table>
    </div>
  </div>
</div>




<script>
  $(function() {
    $('.flash_message').fadeOut(3000);
  })

  $(function(){
    function clearInputs(){
      $('table tbody input,table tbody select').val('');
      $('table tbody input[type="checkbox"]').prop('checked', false);
      $('input[name="day_before"]').val('');
      $('input[name="today"]').val('');
      $('input[name="day_after"]').val('');
    }

    $(document).on('click','#day_before',function(){
      clearInputs();
      $('input[name="day_before"]').val(1);
      $('#reserve_search').submit();
    });
    $(document).on('click','#today',function(){
      clearInputs();
      $('input[name="today"]').val(1);
      $('#reserve_search').submit();
    });
    $(document).on('click','#day_after',function(){
      clearInputs();
      $('input[name="day_after"]').val(1);
      $('#reserve_search').submit();
    });
  })

  $(function(){
    $('#m_submit').on('click',function(){
      $('input[name="day_before"]').val('');
      $('input[name="today"]').val('');
      $('input[name="day_after"]').val('');
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
        "url": "{{ url('/admin/reservations/datatable') }}", 
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
            "check_icon1": $('#checkboxPrimary1').prop('checked')?1:0,
            "check_icon2": $('#checkboxPrimary2').prop('checked')?1:0,
            "check_icon3": $('#checkboxPrimary3').prop('checked')?1:0,
            "check_icon4": $('#checkboxPrimary4').prop('checked')?1:0,
            "check_status1": $('#check_status1').prop('checked')?1:0,
            "check_status2": $('#check_status2').prop('checked')?1:0,
            "check_status3": $('#check_status3').prop('checked')?1:0,
            "check_status4": $('#check_status4').prop('checked')?1:0,
            "check_status5": $('#check_status5').prop('checked')?1:0,
            "check_status6": $('#check_status6').prop('checked')?1:0,
            "day_before": $('input[name="day_before"]').val(),
            "today": $('input[name="today"]').val(),
            "day_after": $('input[name="day_after"]').val(),
            "free_word": $('input[name="free_word"]').val(),
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
        {
          targets: [12,13,14,15,16], 
          sortable: false, 
          orderable: false
        },
        {
          targets: [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16],
          className: "text-center",
        }
      ],
      createdRow: function( row, data, dataIndex ) {
            if ($(data)[0]['attention']) {
            $(row).eq(0).addClass('caution');
            }
            }
     });
    });
</script>



<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

@endsection