@extends('layouts.admin.app')
@section('content')

<script src="{{ asset('/js/tablesorter/jquery.tablesorter.js') }}"></script>
<link href="{{ asset('/css/tablesorter/theme.default.min.css') }}" rel="stylesheet">
{{-- <script src="{{ asset('/js/admin/venue.js') }}"></script> --}}
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

  <h2 class="mt-3 mb-3">有料備品管理</h2>
  <hr>
  <div class="text-right">
    <a href="/admin/equipments/create" class="btn more_btn3">新規登録</a>
  </div>
</div>

<table class="table table-bordered mt-4" id="equipments_sort">
  <thead>
    <tr class="table_row">
      <th id="id">ID {!!ReservationHelper::sortIcon($request->id)!!}</th>
      <th id="created_at">登録日 {!!ReservationHelper::sortIcon($request->created_at)!!}</th>
      <th id="item">有料備品名 {!!ReservationHelper::sortIcon($request->item)!!}</th>
      <th id="price">料金<span class="ml-1 annotation">※税抜 </span>{!!ReservationHelper::sortIcon($request->price)!!}</th>
      <th id="stock">数量 {!!ReservationHelper::sortIcon($request->stock)!!}</th>
      <th id="remark">備考 {!!ReservationHelper::sortIcon($request->remark)!!}</th>
      <th class="btn-cell">編集</th>
      <th class="btn-cell">削除</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($equipments as $query)
    <tr role="row" class="even">
      <td>{{ ReservationHelper::fixId($query->id) }}</td>
      <td>{{ ReservationHelper::formatDate($query->created_at) }}</td>
      <td class="word_break">{{ $query->item }}</td>
      <td class="text-right">
        <div class="d-flex justify-content-end">
          {{ number_format($query->price )}}
          <span>円</span>
        </div>
      </td>
      <td class="text-right">{{ $query->stock }}</td>
      <td>
        <p class="remark_limit">
          {!!nl2br(e($query->remark))!!}
        </p>
      </td>
      <td class="text-center">
        {{ Form::open(['url' => 'admin/equipments/'.$query->id."/edit", 'method'=>'GET', 'id'=>'']) }}
        @csrf
        {{Form::hidden('current_p',$equipments->currentPage() )}}
        {{ Form::submit('編集', ['class' => 'btn more_btn']) }}
        {{ Form::close() }}
      </td>
      <td class="text-center">
        {{ Form::model($query, ['route' => ['admin.equipments.destroy', $query->id], 'method' => 'delete']) }}
        @csrf
        {{Form::hidden("page",$equipments->currentPage())}}
        {{ Form::submit('削除', ['class' => 'btn more_btn4 del_btn']) }}
        {{ Form::close() }}
      </td>
    </tr>
    @endforeach
  </tbody>
</table>
{{ $equipments->appends(request()->input())->links() }}



{{-- 1降順　2昇順 --}}
{{ Form::open(['url' => 'admin/equipments', 'method'=>'get', 'id'=>'sort_form']) }}
@csrf
{{Form::hidden("id", $request->id?($request->id==1?2:1):1)}}
{{Form::hidden("created_at", $request->created_at?($request->created_at==1?2:1):1)}}
{{Form::hidden("item", $request->item?($request->item==1?2:1):1)}}
{{Form::hidden("price", $request->price?($request->price==1?2:1):1)}}
{{Form::hidden("stock", $request->stock?($request->stock==1?2:1):1)}}
{{Form::hidden("remark", $request->remark?($request->remark==1?2:1):1)}}
{{Form::close()}}



<script>
  $(document).on("click", "th", function() {
    var click_th_id=$(this).attr("id");
    $("#sort_form input").each(function(key, item){
      if ($(item).attr("name")!=click_th_id) {
        $(item).val("");
      }
    })
    $("#sort_form").submit();
    })



  $(function () {
  $('.del_btn').on('click', function () {
    var target = $(this).parent().parent().parent().find('td').eq(2).text();
    console.log(target);
    if (!confirm(target+'を本当に削除しますか？\n削除した時点で会場情報・顧客側予約フォームからも削除されます')) {
      return false;
    } else {
    }
  })
})

</script>

@endsection