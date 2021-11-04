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

  <h2 class="mt-3 mb-3">仮押え 一覧</h2>
  <hr>
</div>

<div class="mt-5">
  <p class="text-right font-weight-bold">
    <span class="count-color" id="counter"></span>件
  </p>
</div>
<div class="table-wrap user-table-list">
  <table class="table table-bordered table-box table-scroll compact hover order-column stripe"
    id="pre_reservations_sort" style="height: 100%;">
    <thead>
      <tr>
        <th>一括仮押えID</th>
        <th>仮押えID</th>
        <th>受付日</th>
        <th>利用日</th>
        <th>入室</th>
        <th>退室</th>
        <th>利用会場</th>
        <th>詳細</th>
      </tr>
    </thead>
  </table>
</div>

<!-- 一覧　　終わり------------------------------------------------ -->


<script>
  $(document).ready(function(){
    $.extend($.fn.dataTable.defaults, {
        language: {
            url: "https://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Japanese.json"
        }
    });
    var test = $('#pre_reservations_sort').DataTable({
      order:[],
      processing: true,
      serverSide: true,
      searching: false,
      info: false,
      autowidth: false,
      ajax: { 
        "url": "{{ url('/user/pre_datatable') }}", 
        "type": "GET",
        "data": function ( d ) {
            return $.extend( {}, d, {
            "future_past": $('input[name="past"]').val(),
            'paid':$('select[name="paid"]').val(),
          } );
        }
      },
      columns: [
        { data: 'multiple_reservation_id' },
        { data: 'pre_reservation_id' },
        { data: 'created_at' },
        { data: 'reserve_date' },
        { data: 'enter_time' },
        { data: 'leave_time' },
        { data: 'venue_name' },
        { data: 'details' },
      ],
      "fnDrawCallback": function() {
        //datatableの情報取得が完了したら
          $('#counter').text('').text(test.page.info().recordsDisplay);
      },
      columnDefs: [
        {targets: [7], sortable: false, orderable: false},
      ],
     });
});
</script>


@endsection