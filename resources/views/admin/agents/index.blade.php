@extends('layouts.admin.app')

@section('content')
<link href="{{ asset('/css/template.css') }}" rel="stylesheet">

<script src="https://cdn.datatables.net/t/bs-3.3.6/jqc-1.12.0,dt-1.10.11/datatables.min.js"></script>

<div class="container-field">
  <div class="float-right">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active">
          {{ Breadcrumbs::render(Route::currentRouteName()) }}
        </li>
      </ol>
    </nav>
  </div>
  <h2 class="mt-3 mb-3">仲介会社　一覧</h2>
  <hr>
  <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
    <div class="row">
      <div class="col-sm-6"></div>
      <div class="col-sm-6"></div>
    </div>
    <div class="row">
      <div class="col-sm-12">
        <table class="table table-bordered mt-5 dataTable no-footer" id="DataTables_Table_0" role="grid">
          <thead>
            <tr role="row">
              <th>ID</th>
              <th>サービス名称</th>
              <th>運営会社名</th>
              <th>担当者氏名</th>
              <th>担当者TEL</th>
              <th>詳細</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($querys as $query)
            <tr>
              <th>{{$query->id}}</th>
              <td>{{$query->name}}</td>
              <td>{{$query->company}}</td>
              <td>{{ReservationHelper::getAgentPerson($query->id)}}</td>
              <td>{{$query->person_tel}}</td>
              <td><a href="{{ url('admin/agents', $query->id) }}" class="more_btn">詳細</a></td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
    {{ $querys->links() }}
  </div>
</div>

<script>
  $(function() {
    $(".table").DataTable({
      lengthChange: false, // 件数切替機能 無効
      searching: false, // 検索機能 無効
      ordering: true, // ソート機能 無効
      info: false, // 情報表示 無効
      paging: false, // ページング機能 無効
    });
  })
</script>
@endsection