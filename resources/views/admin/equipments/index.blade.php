@extends('layouts.admin.app')
@section('content')
<script src="https://cdn.datatables.net/t/bs-3.3.6/jqc-1.12.0,dt-1.10.11/datatables.min.js"></script>
<link href="{{ asset('/css/template.css') }}" rel="stylesheet">

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
</script>


<div class="container-field mt-3">
  <div class="float-right">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active">{{ Breadcrumbs::render(Route::currentRouteName()) }}</li>
      </ol>
    </nav>
  </div>
  <h1 class="mt-3 mb-5">有料備品管理</h1>
  <div class="text-right">
    <a href="/admin/equipments/create" class="btn btn-outline-info btn-lg d-inline-block" style="width: 140px;">新規登録　<i class="fas fa-plus"></i></a>
  </div>
  <hr>
  <div class="d-flex justify-content-between mt-3 mb-5">
    <span>{{$equipments->count()}}件表示</span>
    <div>
      <div class="dropdown">
        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-offset="-320,5">
          検索
        </button>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
          <form class="" action="{{url('/admin/equipments')}}">
            @csrf
            <div class="d-flex justify-content-around">
              <div class="form-group">
                <label for="freeword">フリーワード検索</label>
                <input type="text" name="freeword" class="form-control" id="freeword">
              </div>
              <div class="form-group">
                <label for="id">ID</label>
                <input type="text" name="id" class="form-control" id="id">
              </div>
            </div>
            <div class="d-flex justify-content-around">
              <div class="form-group">
                <label for="createdat">作成日</label>
                <input type="text" name="createdat" class="form-control" id="createdat">
              </div>
              <div class="form-group">
                <label for="item">有料備品名</label>
                <input type="text" name="item" class="form-control" id="item">
              </div>
            </div>
            <div class="mx-auto" style="width: 50px;">
              <input type="submit" value="検索" class="btn btn-info">
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<table class="table table-striped table-bordered">
  <thead>
    <tr>
      <th>id</th>
      <th>登録日</th>
      <th>有料備品名</th>
      <th>料金</th>
      <th>数量</th>
      <th>備考</th>
      <th>詳細(編集)・削除</th>
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
      <td>{{ $query->remark }}</td>
      <td class="d-flex justify-content-around">
        {{ link_to_route('admin.equipments.edit', '編集', $parameters = $query->id, ['class' => 'btn btn-primary']) }}
        {{ Form::model($query, ['route' => ['admin.equipments.destroy', $query->id], 'method' => 'delete']) }}
        @csrf
        {{ Form::submit('削除', ['class' => 'btn btn-danger']) }}
        {{ Form::close() }}
      </td>
    </tr>
    @endforeach
  </tbody>
</table>
{{ $equipments->links() }}
@endsection