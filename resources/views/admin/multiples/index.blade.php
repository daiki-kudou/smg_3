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
          <tr>
            <th class="search_item_name"><label for="search_end_user">権限</label></th>
            <td>
              {{Form::select('search_role', ['0' => 'S', '1' => '顧'], optional($data)['search_role'],
              ['class' =>'form-control','placeholder'=>''])}}
            </td>
          </tr>
        </tbody>
      </table>
      <div class="annotation text-left">
        <p>
          ※フリーワード検索は本画面表記の項目のみ対象となります</p>
        <p>※担当者氏名の検索時は、フルネーム時はスペース禁止</p>
      </div>

      <div class="btn_box d-flex justify-content-center">
        <a href="{{url('admin/multiples')}}" class="btn reset_btn">リセット</a>
        {{-- 超過用hidden --}}
        {{Form::hidden("time_over",empty($data)?0:((int)$data['time_over']===1?1:0))}}
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
            @if (empty($data))
            <button type="button" id="time_over" class="btn more_btn">仮押え期間超過</button>
            @else
            @if ((int)$data['time_over']===1)
            <button type="button" id="time_over" class="btn more_btn bg-red">仮押え期間超過一覧表示中</button>
            @else
            <button type="button" id="time_over" class="btn more_btn">仮押え期間超過</button>
            @endif
            @endif
            <p class=" ml-3 font-weight-bold">
              @if ($data)
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
              <th>権限</th>
              <th>仮押え詳細</th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
  </div>
</div>



<script>
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
      { title: "権限" },
      { title: "仮押え詳細" },
      ],
      order: [],
      columnDefs: [
        {targets: [0,10], sortable: false, orderable: false},
        {
          "className": "text-center",
          "targets": [0,1,2,3,4,6,7,8,9,10,11,12],
        }
        ],
      });
  })
</script>

<script>
  $(function(){
    $('#time_over').on('click',function(){
      var this_time_over_val=Number($('input[name="time_over"]').val());
      var time_over_val=this_time_over_val===1?0:1;
      $('input[name="time_over"]').val(time_over_val);
      $('#searchMultiple').submit();
    })
  })
</script>



<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />



@endsection