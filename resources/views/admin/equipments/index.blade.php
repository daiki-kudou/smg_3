@extends('layouts.admin.app')
@section('content')
<script src="https://cdn.datatables.net/t/bs-3.3.6/jqc-1.12.0,dt-1.10.11/datatables.min.js"></script>
<link href="{{ asset('/css/template.css') }}" rel="stylesheet">

<style>
  .hide {
    display: none !important;
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


      <h2 class="mt-3 mb-3">有料備品管理</h2>
      <hr>
      <div class="text-right">
        <a href="/admin/equipments/create" class="btn more_btn3">新規登録</a>
      </div>
      <hr>
      {{-- <div class="d-flex justify-content-between mt-3 mb-3">
        <span>
          <select name="page_counter" id="page_counter">
            <option value="10" {{$request->page_counter==10?'selected':""}}>10</option>
      <option value="30" {{$request->page_counter==30?'selected':""}}>30</option>
      <option value="50" {{$request->page_counter==50?'selected':""}}>50</option>
      </select>件表示
      </span>
    </div> --}}
  </div>

  {{ Form::open(['url' => 'admin/equipments', 'method'=>'get', 'id'=>'page_counter_form']) }}
  @csrf
  {{Form::text('page_counter','',(['id'=>'page_counter_input','class'=>'hide']))}}
  {{ Form::close() }}


  <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
    <p class="text-right mb-2">※金額は税抜表記になります。</p>
    <div class="row">
      <div class="col-sm-12">
        <table class="table table-bordered dataTable no-footer" id="DataTables_Table_0" role="grid">
          <thead>
            <tr class="table_row" role="row">
              <th>ID</th>
              <th>登録日</th>
              <th>有料備品名</th>
              <th>料金</th>
              <th>数量</th>
              <th>備考</th>
              <th class="btn-cell">編集</th>
              <th class="btn-cell">削除</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($equipments as $query)
            <tr>
              <td>{{ ReservationHelper::IdFormat($query->id) }}</td>
              <td>{{ ReservationHelper::formatDate($query->created_at) }}</td>
              <td>{{ $query->item }}</td>
              <td>{{ number_format($query->price )}}</td>
              <td>{{ $query->stock }}</td>
              <td>
                {{ $query->remark }}
              </td>
              <td>
                {{ link_to_route('admin.equipments.edit', '編集', $parameters = $query->id, ['class' => 'btn more_btn']) }}
                {{ Form::model($query, ['route' => ['admin.equipments.destroy', $query->id], 'method' => 'delete']) }}
                @csrf
              </td>
              <td>
                {{ Form::submit('削除', ['class' => 'btn more_btn4']) }}
                {{ Form::close() }}
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
</div>
{{ $equipments->links() }}


<script>
  $(function() {
$(".table").DataTable({
lengthChange: false, // 件数切替機能 無効
searching: false, // 検索機能 無効
ordering: true, // ソート機能 無効
info: false, // 情報表示 無効
paging: false, // ページング機能 無効
aoColumnDefs: [{
"bSortable": false,
"aTargets": [6]
}], //特定のカラムソート不可
});
})

$(function(){
  $('#page_counter').on('change',function(){
    $('#page_counter_input').val($(this).val());
    $("#page_counter_form").submit();
  });
})
</script>

@endsection