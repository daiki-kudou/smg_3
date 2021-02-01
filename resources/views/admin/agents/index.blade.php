@extends('layouts.admin.app')

@section('content')

<script src="https://cdn.datatables.net/t/bs-3.3.6/jqc-1.12.0,dt-1.10.11/datatables.min.js"></script>
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
<style>
  .form-inline {
    display: block;
  }

  .row {
    display: block;
    display: -ms-flexbox;
    -ms-flex-wrap: wrap;
    flex-wrap: wrap;
    margin-right: 0px;
    margin-left: 0px;
  }

  table.dataTable thead .sorting:after,
  table.dataTable thead .sorting_asc:after,
  table.dataTable thead .sorting_desc:after {
    opacity: 0.2;
    content: "↑↓";
  }
</style>


<h1><span class="badge badge-secondary">仲介会社　一覧</span></h1>
{{-- 検索 --}}
<div class="container">
  <div class="row ">
    <div class="col">
      <div>検索</div>
      <div class="col-sm-4" style="padding:20px 0; padding-left:0px;">
        <form class="form-inline" action="{{url('/admin/agents')}}">
          @csrf
          <div class="form-group">
            <label for="freeword">フリーワード検索</label>
            <input type="text" name="freeword" class="form-control" id="freeword">
          </div>
          <div class="form-group">
            <label for="id">ID</label>
            <input type="text" name="id" class="form-control" id="id">
          </div>
          <div class="form-group">
            <label for="name">会社名</label>
            <input type="text" name="name" class="form-control" id="name">
          </div>

          <div class="form-group">
            <label for="person_tel">電話番号</label>
            <input type="text" name="person_tel" class="form-control" id="person_tel">
          </div>

          <input type="submit" value="検索" class="btn btn-info">
        </form>
      </div>
    </div>
    <div class="col"></div>
  </div>
</div>
@if ($errors->any())
<div class="alert alert-danger">
  <ul>
    @foreach ($errors->all() as $error)
    <li>{{ $error }}</li>
    @endforeach
  </ul>
</div>
@endif
<table class="table">
  <thead>
    <tr>
      <th scope="col">ID</th>
      <th scope="col">会社名・団体名</th>
      <th scope="col">電話番号</th>
      <th scope="col">詳細</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($querys as $query)
    <tr>
      <th>{{$query->id}}</th>
      <td>{{$query->name}}</td>
      <td>{{$query->person_tel}}</td>
      <td><a href="{{ url('admin/agents', $query->id) }}">詳細</a></td>
    </tr>
    @endforeach
  </tbody>
</table>
{{ $querys->links() }}
@endsection