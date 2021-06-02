@extends('layouts.admin.app')
@section('content')


<link href="{{ asset('/css/template.css') }}" rel="stylesheet">
<script src="{{ asset('/js/template.js') }}"></script>
<script src="{{ asset('/js/admin/validation.js') }}"></script>

<script src="{{ asset('/js/tablesorter/jquery.tablesorter.js') }}"></script>
<link href="{{ asset('/css/tablesorter/theme.default.min.css') }}" rel="stylesheet">


<script>
  $(function() {
    $('.flash_message').fadeOut(3000);
  })
</script>
@if (session('flash_message'))
<div class="flash_message bg-success text-center py-3 my-0">
  {{ session('flash_message') }}
</div>
@endif
@if (session('flash_message_error'))
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
                  >{{ReservationHelper::getAgentCompanyName($s_a->id)}}</option>
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
      <p class="text-right">※フリーワード検索は本画面表記の項目のみ対象となります<br><br>※日付検索時は「2021-04-12」のようにように年と月と日付を-で分けてください</p>
      <div class="btn_box d-flex justify-content-center">
        <a href="{{url('admin/pre_reservations')}}" class="btn reset_btn">リセット</a>
        {{Form::submit('検索', ['class'=>'btn search_btn', 'id'=>''])}}
      </div>
    </div>
    {{Form::close()}}
    <!-- 検索　終わり------------------------------------------------ -->


    <ul class="d-flex reservation_list mb-2 justify-content-between">
      <li>
        {{-- 削除ボタン --}}
        {{Form::open(['url' => 'admin/pre_reservations/destroy', 'method' => 'POST', 'id'=>'for_destroy'])}}
        @csrf
        {{ Form::submit('削除', ['class' => 'btn more_btn4','id'=>'confirm_destroy']) }}
        {{ Form::close() }}
      </li>
      <li>
        <div class="d-flex">
          {{-- 仮押さえ超過ボタン --}}
          {{Form::open(['url' => 'admin/pre_reservations', 'method' => 'GET', 'id'=>''])}}
          @csrf
          {{ Form::submit('仮押え期間超過', ['class' => 'btn more_btn bg-red','name'=>'time_over']) }}
          {{ Form::close() }}
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
            <th>仮押えID</th>
            <th>作成日</th>
            <th>利用日</th>
            <th>入室</th>
            <th>退室</th>
            <th>利用会場</th>
            <th>会社・団体名</th>
            <th>担当者氏名</th>
            <th>携帯電話</th>
            <th>固定電話</th>
            <th>会社・団体名(仮)</th>
            <th>仲介会社</th>
            <th>エンドユーザー</th>
            <th>仮押え詳細</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($pre_reservations as $pre_reservation)
          <tr>
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
              {{-- {{ReservationHelper::checkAgentOrUserTel($pre_reservation->user_id, $pre_reservation->agent_id)}}
              --}}
              @if ($pre_reservation->user_id>0)
              {{ReservationHelper::getPersonTel($pre_reservation->user_id)}}
              @endif
            </td>
            <td>{{!empty($pre_reservation->unknown_user)?$pre_reservation->unknown_user->unknown_user_company:""}}</td>
            <td>
              {{$pre_reservation->agent_id==0?"":(ReservationHelper::getAgentCompanyName($pre_reservation->agent_id))}}
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
  {{-- 
  @if ($counter)
  {{ $pre_reservations->appends(request()->input())->appends(['counter'=>$counter])->links() }}
  @elseif($request->counter)
  {{ $pre_reservations->appends(request()->input())->appends(['counter'=>$request->counter])->links() }}
  @else
  {{ $pre_reservations->links() }}
  @endif --}}


  {{$pre_reservations->appends(request()->input())->links()}}







</div>



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
  $(function() {
    $("input[type='checkbox']").on('change', function() {
      checked = $('[class="checkbox"]:checked').map(function() {
        return $(this).val();
      }).get();
      console.log(checked.length);
      for (let index = 0; index < checked.length; index++) {
        var ap_data = "<input type='hidden' name='destroy" + checked[index] + "' value='" + checked[index] + "'>"
        $('#for_destroy').append(ap_data);
      }
    })
  })

  

</script>




<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />



@endsection