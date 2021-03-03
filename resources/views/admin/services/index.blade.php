@extends('layouts.admin.app')
@section('content')
<script src="https://cdn.datatables.net/t/bs-3.3.6/jqc-1.12.0,dt-1.10.11/datatables.min.js"></script>
<link href="{{ asset('/css/template.css') }}" rel="stylesheet">
<div class="container-fluid">


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
"aTargets": [5]
}], //特定のカラムソート不可

});
})
  </script>

  <div class="container-field mt-3">
    <div class="float-right">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item active"><a href="https://staging-smg2.herokuapp.com/admin/home">ホーム</a> &gt;
            有料サービス管理
          </li>
        </ol>
      </nav>
    </div>

    <h2 class="mt-3 mb-3">有料サービス管理</h2>
    <hr>

    <div class="text-right">
      <a href="/admin/services/create" class="btn more_btn3">新規登録</a>
    </div>
    <hr>
    <div class="d-flex justify-content-between my-3">
      <span>
        <select name="page_counter" id="page_counter">
          <option value="ten">10</option>
          <option value="thirty">30</option>
          <option value="fifty">50</option>
        </select>件表示
      </span>

    </div>
  </div>
  <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
    <div class="row">
      <div class="col-sm-6"></div>
      <div class="col-sm-6"></div>
    </div>
    <div class="row">
      <div class="col-sm-12">
        <table class="table table-striped table-bordered">
          <thead>
            <tr>
              <th>ID</th>
              <th>登録日</th>
              <th>有料サービス名</th>
              <th>料金</th>
              <th>備考</th>
              <th>詳細(編集)・削除</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($querys as $query)
            <tr>
              <td>{{ ReservationHelper::IdFormat($query->id) }}</td>
              <td>{{ ReservationHelper::formatDate($query->created_at) }}</td>
              <td>{{ $query->item }}</td>
              <td>{{ number_format($query->price) }}</td>
              <td>{{ $query->remark }}</td>
              <td class="d-flex justify-content-around">
                {{ link_to_route('admin.services.edit', '編集', $parameters = $query->id, ['class' => 'btn more_btn']) }}
                {{ Form::model($query, ['route' => ['admin.services.destroy', $query->id], 'method' => 'delete']) }}
                @csrf
                {{ Form::submit('削除', ['class' => 'btn more_btn4']) }}
                {{ Form::close() }}
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
    {{ $querys->links() }}
  </div>
</div>
@endsection