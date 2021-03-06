@extends('layouts.admin.app')
@section('content')


<link href="{{ asset('/css/template.css') }}" rel="stylesheet">
<script src="{{ asset('/js/admin/search/validation.js') }}"></script>
{{-- <script src="{{ asset('/js/tablesorter/jquery.tablesorter.js') }}"></script>
<link href="{{ asset('/css/tablesorter/theme.default.min.css') }}" rel="stylesheet"> --}}


<script>
  $(function() {
    $('.flash_message').fadeOut(3000);
  })
</script>
@if (session('flash_message'))
<div class="flash_message bg-success text-center py-3 my-0">
  {{ session('flash_message') }}
</div>
@elseif(session('flash_message_error'))
<div class="flash_message bg-danger text-center py-3 my-0">
  {{ session('flash_message_error') }}
</div>
@endif

<style>
  .checkbox,
  #all_check {
    width: 14px;
    height: 14px;
    -moz-transform: scale(1.4);
    -webkit-transform: scale(1.4);
    transform: scale(1.4);
  }
</style>


<div class="content">
  <div class="container-fluid">
    <div class="container-field mt-3">
      <div class="float-right">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item active">
              {{ Breadcrumbs::render(Route::currentRouteName()) }}
            </li>
          </ol>
        </nav>
      </div>
      <h2 class="mt-3 mb-3">仮押え一覧</h2>
      <hr>
    </div>

    <!-- 検索--------------------------------------- -->
    {{Form::open(['url' => 'admin/pre_reservations', 'method' => 'GET', 'id'=>'preserve_search'])}}
    @csrf
    <div class="search-wrap">
      <table class="table table-bordered">
        <tbody>
          <tr>
            <th class="search_item_name"><label for="id">仮押えID</label>
            <td class="text-right">
              {{Form::text("search_id", $request->search_id?:'', ['class'=>'form-control'])}}
              <p class="is-error-search_id" style="color: red"></p>
            </td>
            <th class="search_item_name"><label for="">作成日</label></th>
            <td class="text-right form-group">
              {{Form::text("search_created_at",$request->search_created_at?:'', ['class'=>'form-control','id'=>'datepicker1'])}}
            </td>
          </tr>
          <tr>
            <th class="search_item_name"><label for="date">利用日</label></th>
            <td class="text-right form-group">
              {{Form::text("search_date",$request->search_date?:'', ['class'=>'form-control','id'=>'datepicker2'])}}
            </td>

            <th class="search_item_name"><label for="venue">利用会場</label></th>
            <td class="text-right">
              <dd>
                <select name="search_venue" id="search_venue" class="form-control">
                  <option value=""></option>
                  @foreach ($venues as $s_v)
                  <option value="{{$s_v->id}}" @if ($s_v->id==$request->search_venue)
                    selected
                    @endif
                    >{{ReservationHelper::getVenue($s_v->id)}}</option>
                  @endforeach
                </select>
            </td>
          </tr>
          <tr>
            <th class="search_item_name"><label for="company">会社・団体名</label></th>
            <td class="text-right">
              {{Form::text('search_user',$request->search_user?:'',['class'=>'form-control'])}}
            </td>
            <th class="search_item_name"><label for="person_name">担当者氏名</label></th>
            <td class="text-right">
              <dd>
                {{Form::text('search_person',$request->search_person?:'',['class'=>'form-control'])}}
            </td>
          </tr>
          <tr>
            <th class="search_item_name"><label for="mobile">携帯電話</label></th>
            <td>
              {{Form::text("search_mobile",$request->search_mobile?:'', ['class'=>'form-control','id'=>''])}}
              <p class="is-error-search_mobile" style="color: red"></p>
            </td>
            <th class="search_item_name"><label for="tel">固定電話</label></th>
            <td>
              {{Form::text("search_tel",$request->search_tel?:'', ['class'=>'form-control','id'=>''])}}
              <p class="is-error-search_tel" style="color: red"></p>
            </td>
          </tr>
          <tr>
            <th class="search_item_name"><label for="temp_company">会社・団体名(仮)</label></th>
            <td>
              {{Form::text("search_unkown_user",$request->search_unkown_user?:'', ['class'=>'form-control','id'=>''])}}
            </td>
            <th class="search_item_name"><label for="agent">仲介会社</label></th>
            <td>
              <select name="search_agent" id="search_agent" class="form-control">
                <option value=""></option>
                @foreach ($agents as $s_a)
                <option value="{{$s_a->id}}" @if ($s_a->id==$request->search_agent)
                  selected
                  @endif
                  >{{ReservationHelper::getAgentCompany($s_a->id)}}</option>
                @endforeach
              </select>
            </td>
          </tr>
          <tr>
            <th class="search_item_name"><label for="search_end_user">エンドユーザー</label></th>
            <td>
              {{Form::text("search_end_user",$request->search_end_user?:'', ['class'=>'form-control','id'=>''])}}
            </td>
            <th class="search_item_name"><label for="freeword">フリーワード検索</label></th>
            <td colspan="3">
              {{Form::text("search_free",$request->search_free?:'', ['class'=>'form-control','id'=>''])}}
            </td>
          </tr>
        </tbody>
      </table>
      <p class="text-left">
        ※フリーワード検索は本画面表記の項目のみ対象となります<br>
        <br>
        ※担当者氏名の検索時は、フルネーム時はスペース禁止
      </p>
      <div class="btn_box d-flex justify-content-center">
        <a href="{{url('admin/pre_reservations')}}" class="btn reset_btn">リセット</a>
        {{-- ソート用hidden --}}
        {{Form::hidden("sort_id", $request->sort_id?($request->sort_id==1?2:1):1)}}
        {{Form::hidden("sort_created_at", $request->sort_created_at?($request->sort_created_at==1?2:1):1)}}
        {{Form::hidden("sort_reserve_date", $request->sort_reserve_date?($request->sort_reserve_date==1?2:1):1)}}
        {{Form::hidden("sort_enter_time", $request->sort_enter_time?($request->sort_enter_time==1?2:1):1)}}
        {{Form::hidden("sort_leave_time", $request->sort_leave_time?($request->sort_leave_time==1?2:1):1)}}
        {{Form::hidden("sort_venue", $request->sort_venue?($request->sort_venue==1?2:1):1)}}
        {{Form::hidden("sort_user_company", $request->sort_user_company?($request->sort_user_company==1?2:1):1)}}
        {{Form::hidden("sort_user_name", $request->sort_user_name?($request->sort_user_name==1?2:1):1)}}
        {{Form::hidden("sort_user_mobile", $request->sort_user_mobile?($request->sort_user_mobile==1?2:1):1)}}
        {{Form::hidden("sort_user_tel", $request->sort_user_tel?($request->sort_user_tel==1?2:1):1)}}
        {{Form::hidden("sort_unknown", $request->sort_unknown?($request->sort_unknown==1?2:1):1)}}
        {{Form::hidden("sort_agent", $request->sort_agent?($request->sort_agent==1?2:1):1)}}
        {{Form::hidden("sort_enduser", $request->sort_enduser?($request->sort_enduser==1?2:1):1)}}
        {{-- ソート用hidden --}}
        {{-- 超過用hidden --}}
        {{Form::hidden("time_over", $request->time_over)}}

        {{Form::submit('検索', ['class'=>'btn search_btn', 'id'=>''])}}
      </div>
    </div>
    {{Form::close()}}
    <!-- 検索　終わり------------------------------------------------ -->
    <ul class="d-flex reservation_list mb-2 justify-content-between">
      <li>
        {{-- 削除ボタン --}}
        {{Form::open(['url' => 'admin/pre_reservations/destroy', 'method' => 'POST', 'id'=>''])}}
        @csrf
        <div id="for_destroy"></div>
        {{ Form::submit('削除', ['class' => 'btn more_btn4','id'=>'confirm_destroy']) }}
        <span class="d-block">※メールアドレスが正しくないと削除されません。</span>
        {{ Form::close() }}
      </li>
      <li>
        <div class="d-flex">
          {{-- 仮押さえ超過ボタン --}}
          <button id="time_over" class="btn more_btn {{$request->time_over?"bg-red":""}}">仮押え期間超過</button>
          {{-- 件数 --}}
          <p class="ml-3 font-weight-bold">
            @if ($counter!=0)
            <span class="count-color">{{$counter}}</span>件
            @elseif($request->counter!=0)
            <span class="count-color">{{$request->counter}}</span>件
            @endif
          </p>
        </div>
      </li>
    </ul>


    <div class="table-wrap">
      <table class="table table-bordered table-scroll sort_table">
        <thead>
          <tr class="table_row">
            <th>
              <p class="annotation">すべて</p><input type="checkbox" name="all_check" id="all_check" />
            </th>
            <th id="sort_id">仮押えID {!!ReservationHelper::sortIcon($request->sort_id)!!}</th>
            <th id="sort_created_at">作成日 {!!ReservationHelper::sortIcon($request->sort_created_at)!!}</th>
            <th id="sort_reserve_date">利用日 {!!ReservationHelper::sortIcon($request->sort_reserve_date)!!}</th>
            <th id="sort_enter_time">入室 {!!ReservationHelper::sortIcon($request->sort_enter_time)!!}</th>
            <th id="sort_leave_time">退室 {!!ReservationHelper::sortIcon($request->sort_leave_time)!!}</th>
            <th id="sort_venue">利用会場 {!!ReservationHelper::sortIcon($request->sort_venue)!!}</th>
            <th id="sort_user_company">会社・団体名 {!!ReservationHelper::sortIcon($request->sort_user_company)!!}</th>
            <th id="sort_user_name">担当者氏名 {!!ReservationHelper::sortIcon($request->sort_user_name)!!}</th>
            <th id="sort_user_mobile">携帯電話 {!!ReservationHelper::sortIcon($request->sort_user_mobile)!!}</th>
            <th id="sort_user_tel">固定電話 {!!ReservationHelper::sortIcon($request->sort_user_tel)!!}</th>
            <th id="sort_unknown">会社・団体名(仮) {!!ReservationHelper::sortIcon($request->sort_unknown)!!}</th>
            <th id="sort_agent">仲介会社 {!!ReservationHelper::sortIcon($request->sort_agent)!!}</th>
            <th id="sort_enduser">エンドユーザー {!!ReservationHelper::sortIcon($request->sort_enduser)!!}</th>
            <th>仮押え詳細</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($pre_reservations as $pre_reservation)
          <tr style="{{$pre_reservation->user_id>0?($pre_reservation->user->attention?"background:pink;":""):""}}">
            <td class="text-center">
              <input type="checkbox" name="{{'delete_check'.$pre_reservation->id}}" value="{{$pre_reservation->id}}"
                class="checkbox" />
            </td>
            <td>{{ReservationHelper::fixId($pre_reservation->id)}}</td>
            <td>{{ReservationHelper::formatDate($pre_reservation->created_at)}}</td>
            <td>{{ReservationHelper::formatDate($pre_reservation->reserve_date)}}</td>
            <td>{{ReservationHelper::formatTime($pre_reservation->enter_time)}}</td>
            <td>{{ReservationHelper::formatTime($pre_reservation->leave_time)}}</td>
            <td>{{ReservationHelper::getVenue($pre_reservation->venue_id)}}</td>
            <td>{{$pre_reservation->user_id>0?ReservationHelper::getCompany($pre_reservation->user_id):""}}</td>
            <td>
              @if ($pre_reservation->user_id>0)
              {{ReservationHelper::getPersonName($pre_reservation->user_id)}}
              @endif
            </td>
            <td>
              @if ($pre_reservation->user_id>0)
              {{ReservationHelper::getPersonMobile($pre_reservation->user_id)}}
              @endif
            </td>
            <td>
              @if ($pre_reservation->user_id>0)
              {{ReservationHelper::getPersonTel($pre_reservation->user_id)}}
              @endif
            </td>
            <td>{{!empty($pre_reservation->unknown_user)?$pre_reservation->unknown_user->unknown_user_company:""}}</td>
            <td>
              {{$pre_reservation->agent_id==0?"":(ReservationHelper::getAgentCompany($pre_reservation->agent_id))}}
            </td>
            <td>
              {{!empty($pre_reservation->pre_enduser)?$pre_reservation->pre_enduser->company:""}}
            </td>
            <td class="text-center">
              <a class="more_btn" href="{{url('admin/pre_reservations/'.$pre_reservation->id)}}">詳細</a>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>


  {{$pre_reservations->appends(request()->input())->links()}}



</div>



<script>
  $(document).on("click", "#time_over", function() {
    if ($('input[name="time_over"]').val()==0) {
      $('input[name="time_over"]').val(1);
    }else{
      $('input[name="time_over"]').val(0);
    }
    $('input[name^="sort_"]').each(function(key, item){
        $(item).val("");
        });
    $('#preserve_search').submit();
  })

  $(document).on("click", ".table-scroll th", function() {
    var click_th_id=$(this).attr("id");
    var index = $('.table-scroll th').index(this);
    if (index!=0&&index!=14) {
      $('input[name^="sort_"]').each(function(key, item){
        if ($(item).attr("name")!=click_th_id) {
          $(item).val("");
        }
      })
      $("#preserve_search").submit();
    }
  })

    $(function() {
      $(".search_btn").on("click",function(){
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
        $(this).val(picker.startDate.format('YYYY-MM-DD') + ' ~ ' + picker.endDate.format('YYYY-MM-DD'));
      });
      $("input[name='" + $target + "']").on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('');
      });
    }
    ActiveDateRangePicker('search_created_at');
    ActiveDateRangePicker('search_date');
  })

  $(function() {
    // 全選択アクション
    $('#all_check').on('change', function() {
      $('.checkbox').prop('checked', $(this).is(':checked'));
    })
    // 削除確認コンファーム
    $('#confirm_destroy').on('click', function() {
      if (!confirm('削除してもよろしいですか？')) {
        return false;
      }
    })
  })


    $(document).on("change", "input[type='checkbox']", function () {
      $('#for_destroy').html("");
      checked = $('[class="checkbox"]:checked').map(function() {
        return $(this).val();
      }).get();
      for (let index = 0; index < checked.length; index++) {
        var ap_data = "<input type='hidden' name='destroy" + checked[index] + "' value='" + checked[index] + "'>"
        $('#for_destroy').append(ap_data);
      }
  });


</script>






<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />



@endsection