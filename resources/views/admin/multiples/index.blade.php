@extends('layouts.admin.app')

@section('content')


<link href="{{ asset('/css/template.css') }}" rel="stylesheet">
<script src="{{ asset('/js/template.js') }}"></script>
<script src="{{ asset('/js/admin/search/validation.js') }}"></script>
<script src="{{ asset('/js/tablesorter/jquery.tablesorter.js') }}"></script>
<link href="{{ asset('/css/tablesorter/theme.default.min.css') }}" rel="stylesheet">


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

@include('layouts.admin.errors')
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

<div class="content">
  <div class="container-fluid">
    <div class="container-field mt-3">
      <div class="float-right">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item active">
              {{-- {{ Breadcrumbs::render(Route::currentRouteName(),$data['id']) }} --}}
            </li>
          </ol>
        </nav>
      </div>
      <h2 class="mt-3 mb-3">一括仮押え 一覧</h2>
      <hr>
    </div>

    <!-- 検索--------------------------------------- -->
    {{Form::open(['url' => 'admin/multiples', 'method' => 'GET', 'id'=>'searchMultiple'])}}
    @csrf
    <div class="search-wrap">
      <table class="table table-bordered mb-0">
        <tbody>
          <tr>
            <th class="search_item_name"><label for="id">一括仮押えID</label>
            <td class="text-right">
              {{Form::text("search_id",optional($data)['search_id'], ['class'=>'form-control'])}}
              <p class="is-error-search_id text-left" style="color: red"></p>
            </td>
            <th class="search_item_name"><label for="">受付日</label></th>
            <td class="text-right form-group">
              {{Form::text("search_created_at",optional($data)['search_created_at'],
              ['class'=>'form-control','id'=>''])}}
            </td>
          </tr>
          <tr>
            <th class="search_item_name"><label for="company">会社・団体名</label></th>
            <td class="text-right">
              {{Form::text("search_company",optional($data)['search_company'], ['class'=>'form-control'])}}
            </td>
            <th class="search_item_name"><label for="person_name">担当者氏名</label></th>
            <td class="text-right">
              <dd>
                {{Form::text('search_person',optional($data)['search_person'],['class'=>'form-control'])}}
            </td>
          </tr>
          <tr>
            <th class="search_item_name"><label for="mobile">携帯電話</label></th>
            <td>
              {{Form::text("search_mobile",optional($data)['search_mobile'], ['class'=>'form-control','id'=>''])}}
              <p class="is-error-search_mobile text-left" style="color: red"></p>
            </td>
            <th class="search_item_name"><label for="tel">固定電話</label></th>
            <td>
              {{Form::text("search_tel",optional($data)['search_tel'], ['class'=>'form-control','id'=>''])}}
              <p class="is-error-search_tel text-left" style="color: red"></p>
            </td>
          </tr>
          <tr>
            <th class="search_item_name"><label for="temp_company">会社・団体名(仮)</label></th>
            <td>
              {{Form::text("search_unkown_user",optional($data)['search_unkown_user'],
              ['class'=>'form-control','id'=>''])}}
            </td>
            <th class="search_item_name"><label for="agent">仲介会社</label></th>
            <td>
              {{Form::select('search_agent',$agents,optional($data)['search_agent'],['class'=>'form-control','placeholder'=>''])}}
            </td>
          </tr>
          <tr>
            <th class="search_item_name"><label for="search_end_user">エンドユーザー</label></th>
            <td>
              {{Form::text("search_end_user",optional($data)['search_end_user'], ['class'=>'form-control','id'=>''])}}
            </td>
            <th class="search_item_name"><label for="freeword">フリーワード検索</label></th>
            <td>
              {{Form::text("search_free",optional($data)['search_free'], ['class'=>'form-control','id'=>''])}}
            </td>
          </tr>
        </tbody>
      </table>
      <p class="text-left">
        ※フリーワード検索は本画面表記の項目のみ対象となります<br>
        ※担当者氏名の検索時は、フルネーム時はスペース禁止
      </p>

      <div class="btn_box d-flex justify-content-center">
        <a href="{{url('admin/multiples')}}" class="btn reset_btn">リセット</a>
        {{-- 超過用hidden --}}
        {{-- {{Form::hidden("time_over", optional($data)['time_over'])}} --}}
        {{Form::submit('検索', ['class'=>'btn search_btn', 'id'=>''])}}
      </div>
    </div>
    {{Form::close()}}






    <!-- 検索　終わり------------------------------------------------ -->
    <div class="section-wrap">

      <ul class="d-flex reservation_list mb-2 justify-content-between">
        <li>
          {{-- 削除ボタン --}}
          {{Form::open(['url' => 'admin/multiples/destroy', 'method' => 'delete'])}}
          @csrf
          <div id="for_destroy"></div>
          {{Form::hidden("delete_target","")}}
          {{ Form::submit('削除', ['class' => 'btn more_btn4','id'=>'confirm_destroy']) }}
          {{ Form::close() }}
        </li>
        <li>
          <div class="d-flex align-items-center">
            <p>
              <button id="time_over" class="btn more_btn 
              {{-- {{$data['time_over']?" bg-red":""}} --}} ">仮押え期間超過</button>
            </p>
            <p class=" ml-3 font-weight-bold">
                @if ($counter!=0)
                <span class="count-color">{{$counter}}</span>件
                @elseif($counter!=0)
                <span class="count-color">{{$counter}}</span>件
                @endif
            </p>
          </div>
        </li>
      </ul>


      <div class="table-wrap" id="parent_multiple_table" data-multiples="{{$multiples}}">
        <table class="table table-bordered table-scroll sort_table compact hover order-column" id="multiple_sort">
          <thead>
            <tr class="table_row">
              <th>
                <p class="annotation">すべて</p>
                <input type="checkbox" name="all_check" id="all_check" />
              </th>
              <th>一括仮押えID</th>
              <th>受付日</th>
              <th>件数</th>
              <th>会社・団体名</th>
              <th>担当者氏名</th>
              <th>携帯電話</th>
              <th>固定電話</th>
              <th>会社・団体名</th>
              <th>仲介会社</th>
              <th>エンドユーザー</th>
              <th>仮押え詳細</th>
            </tr>
          </thead>
          {{-- <tbody>
            @foreach ($multiples as $multiple)
            @if (!empty($multiple->pre_reservations->toArray()))
            <tr>
              <td class="text-center">
                <input type="checkbox" name="{{'delete_check'.$multiple->id}}" value="{{$multiple->id}}"
                  class="checkbox">
              </td>
              <td>{{ReservationHelper::fixId($multiple->id)}}</td>
              <td>{{ReservationHelper::formatDate($multiple->created_at)}}</td>
              <td>{{$multiple->pre_reservations->count()}}</td>
              <td>
                @if (!empty($multiple->pre_reservations->first()->user))
                {{(ReservationHelper::getCompany($multiple->pre_reservations->first()->user->id))}}
                @endif
              </td>
              <td>
                @if (!empty($multiple->pre_reservations->first()->user))
                {{ReservationHelper::getPersonName($multiple->pre_reservations->first()->user->id)}}
                @endif
              </td>
              <td>
                @if (!empty($multiple->pre_reservations->first()->user))
                {{ReservationHelper::getPersonMobile($multiple->pre_reservations->first()->user->id)}}
                @endif
              </td>
              <td>
                @if (!empty($multiple->pre_reservations->first()->user))
                {{ReservationHelper::getPersonTel($multiple->pre_reservations->first()->user->id)}}
                @endif
              </td>
              <td>
                @if (!empty($multiple->pre_reservations->first()->user))
                {{(optional($multiple->pre_reservations->first()->unknown_user)->unknown_user_company)}}
                @endif
              </td>
              <td>
                @if (empty($multiple->pre_reservations->first()->user))
                {{$multiple->pre_reservations->first()->agent->name}}
                @endif
              </td>
              <td>
                @if (empty($multiple->pre_reservations->first()->user))
                {{$multiple->pre_reservations->first()->pre_enduser->company}}
                @endif
              </td>
              <td class="text-center">
                @if (!empty($multiple->pre_reservations->first()->user))
                <a href="{{url('admin/multiples/'.$multiple->id)}}" class="btn more_btn">詳細</a>
                @else
                <a href="{{url('admin/multiples/agent/'.$multiple->id)}}" class="btn more_btn">詳細</a>
                @endif
              </td>
            </tr>
            @endif
            @endforeach
          </tbody> --}}
        </table>
      </div>
    </div>
  </div>

  {{-- {{ $multiples->appends(request()->input())->links() }} --}}
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
    $('#searchMultiple').submit();
  })

  $(function() {
    $('.flash_message').fadeOut(3000);
  })

  $(function() {
    // 全選択アクション
    $('#all_check').on('change', function() {
      $('.checkbox').prop('checked', $(this).is(':checked'));
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
    ActiveDateRangePicker('search_created_at');
    ActiveDateRangePicker('search_date');
  })

  $(document).on('click', '#all_check', function (){
    var parent_checked = $(this).prop('checked');
    var array = [];
    $('.checkbox').each(function(index, element){
    $('.checkbox').eq(index).prop('checked',false );
    $('.checkbox').eq(index).prop('checked',parent_checked );
    if (parent_checked===true) {
    array.push($('.checkbox').eq(index).val());
    }
    })
    console.log(JSON.stringify(array));
    $('input[name="delete_target"]').val(JSON.stringify(array));
    }
    );
    
    $(document).on('change', 'select[name="pre_reservation_sort_length"]', function (){
    var parent_checked = $("#all_check").prop('checked');
    var array = [];
    $('.checkbox').each(function(index, element){
    $('.checkbox').eq(index).prop('checked',false );
    $('.checkbox').eq(index).prop('checked',parent_checked );
    if (parent_checked===true) {
    array.push($('.checkbox').eq(index).val());
    }
    })
    console.log(JSON.stringify(array));
    $('input[name="delete_target"]').val(JSON.stringify(array));
    }
    );
    
    $(document).on('click', '.checkbox', function (){
    var parent_checked = $("#all_check").prop('checked');
    var array = [];
    $('.checkbox').each(function(index, element){
    if ($('.checkbox').eq(index).prop('checked')===true) {
    array.push($('.checkbox').eq(index).val());
    }
    })
    console.log(JSON.stringify(array));
    $('input[name="delete_target"]').val(JSON.stringify(array));
    });
    
    $(document).on('click', '.sorting', function (){
    $('.checkbox').each(function(index, element){
    $('.checkbox').eq(index).prop('checked',false );
    })
    $('input[name="delete_target"]').val("");
    $('#all_check').prop('checked',false);
    });
</script>

<script>
  $(function(){
    var multiples = $('#parent_multiple_table').data('multiples');
      $.extend( $.fn.dataTable.defaults, {
      // 日本語化
        language: {
        url: "https://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Japanese.json"
        }
        });
      $("#multiple_sort").DataTable({
      // data オプションでデータを定義する
      data: multiples,
      searching: false,
      info: false,
      autowidth: false,
      // column オプションで view の th にあたる部分を定義する
      columns: [
      { title: "<p class='annotation'>すべて</p> <input type='checkbox' name='all_check' id='all_check'>" },
      { title: "一括仮押えID" },
      { title: "受付日" },
      { title: "件数" },
      { title: "会社・団体名" },
      { title: "担当者氏名" },
      { title: "携帯電話" },
      { title: "固定電話" },
      { title: "会社・団体名（仮）" },
      { title: "仲介会社" },
      { title: "エンドユーザー" },
      { title: "仮押え詳細" },
      ],
      order: [],
      columnDefs: [
        {targets: 0, sortable: false, orderable: false},
        {targets: 10, sortable: false, orderable: false},
        ],
      });
  })
</script>



<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />



@endsection