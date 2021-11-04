@extends('layouts.user.app')
@section('content')
<link href="{{ asset('/css/template.css') }}" rel="stylesheet">

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

  <h2 class="mt-3 mb-3">予約一覧</h2>
  <hr>
</div>

{{ Form::open(['url' => 'user/home', 'method'=>'get', 'id'=>'user_reservations_form']) }}
@csrf
<div class="col-12">
  <dl class="d-flex col-12 justify-content-end align-items-center statuscheck">
    <dt><label for="">支払状況</label></dt>
    <dd class="mr-1">
      {{Form::select('paid', [1=>'未入金',
      2=>'入金済み',3=>'遅延',4=>'入金不足',5=>'入金過多',6=>'次回繰越'],$request->paid,['class'=>'form-control','placeholder'=>''])}}
      {{Form::hidden('past',(int)$request->past===1?1:0)}}
    </dd>
    <dd>
      <p class="text-right">
        {{Form::submit('検索', ['class'=>'btn more_btn'])}}
      </p>
    </dd>
  </dl>

</div>
<div class="col-12">
  <p class="text-right font-weight-bold">
    <span class="count-color" id="counter">
    </span>件
  </p>
</div>
<!-- 一覧　　------------------------------------------------ -->
<ul class="nav nav-tabs">
  <li class="nav-item">
    <button type="button" class="nav-link {{ (int)$request->past===0?" active":"" }}" id="future_btn">予約一覧</button>
  </li>
  <li class="nav-item">
    <button type="button" class="nav-link {{ (int)$request->past===1?" active":"" }}" id="past_btn">過去履歴</button>
  </li>
</ul>
{{Form::close()}}

<script>
  $(document).on('click', '#future_btn', function () {
    $('input[name="past"]').val(0);
    $('#user_reservations_form').submit();
  });
  $(document).on('click', '#past_btn', function () {
    $('input[name="past"]').val(1);
    $('#user_reservations_form').submit();
  });
</script>

<p class="text-left my-1">※予約確認中⇒弊社でご予約内容の確認中です。お客様にご対応頂くことはありません</p>




<div class="tab-content mt-2">
  <div id="reserve-list" class="tab-pane active">
    <div class="table-wrap user-table-list">
      {{-- <table class="table table-bordered table-box table-scroll" 　id="sales_sort"> --}}
        <table class="mt-2 table table-bordered table-box table-scroll compact hover order-column" id="sales_sort"
          style="height: 100%;">
          <thead>
            <tr>
              {{-- <th>予約ID</th>
              <th>利用日</th>
              <th>入室</th>
              <th>退室</th>
              <th>利用会場</th>

              <th width="120">予約状況</th>
              <th width="120">カテゴリー</th>
              <th>利用料金（税込）</th>
              <th>支払期日</th>
              <th>支払状況</th>
              <th class="btn-cell">詳細</th>
              <th class="btn-cell">請求書</th>
              <th class="btn-cell">領収書</th> --}}
              <th>予約ID</th>
              <th>利用日</th>
              <th>入室</th>
              <th>退室</th>
              <th>利用会場</th>
              <th>予約状況</th>
              <th>カテゴリー</th>
              <th>総額</th>
              <th>利用料金</th>
              <th>支払期日</th>
              <th>入金状況</th>
              <th>予約詳細</th>
              <th>請求書</th>
              <th>領収書</th>
            </tr>
          </thead>
        </table>
    </div>
  </div>
</div>

<!-- 一覧　　終わり------------------------------------------------ -->


</div>
<script>
  // 文字列、未入金にcssを付与
$(function () {
$("td:contains('未入金')").css("font-weight","bold"); 
});

</script>

<script>
  $(document).ready(function(){
    $.extend($.fn.dataTable.defaults, {
        language: {
            url: "https://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Japanese.json"
        }
    });
    var test = $('#sales_sort').DataTable({
      order:[],
      processing: true,
      serverSide: true,
      searching: false,
      info: false,
      autowidth: false,
      ajax: { 
        "url": "{{ url('/user/datatable') }}", 
        "type": "GET",
        "data": function ( d ) {
            return $.extend( {}, d, {
            "future_past": $('input[name="past"]').val(),
            'paid':$('select[name="paid"]').val(),
          } );
        }
      },
      columns: [
        { data: 'reservation_id' },
        { data: 'reserve_date' },
        { data: 'enter_time' },
        { data: 'leave_time' },
        { data: 'venue_name' },
        { data: 'reservation_status' },
        { data: 'category' },
        { data: 'sogaku' },
        { data: 'sales' },
        { data: 'payment_limit' },
        { data: 'paid' },
        { data: 'details' },
        { data: 'invoice' },
        { data: 'receipt' },
      ],
      "fnDrawCallback": function() {
        //datatableの情報取得が完了したら
          $('#counter').text('').text(test.page.info().recordsDisplay);
      },
      columnDefs: [
        {targets: [5,6,8,9,10,11,12,13], sortable: false, orderable: false},
        {targets: [7,8],className: "text-right",}
      ],
     });
});
</script>



@endsection