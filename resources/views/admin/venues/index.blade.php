@extends('layouts.admin.app')
@section('content')
<script src="https://cdn.datatables.net/t/bs-3.3.6/jqc-1.12.0,dt-1.10.11/datatables.min.js"></script>
<link href="{{ asset('/css/template.css') }}" rel="stylesheet">

<script>
  // テーブルソーと
  $(function() {
    $(".table").DataTable({
      lengthChange: false, // 件数切替機能 無効
      searching: false, // 検索機能 無効
      ordering: true, // ソート機能 無効
      info: false, // 情報表示 無効
      paging: false, // ページング機能 無効
      aoColumnDefs: [{
        "bSortable": false,
        "aTargets": [7]
      }],
    });

    $('#counter').on('change', function() {
      var counter = $(this).val();
      var freeword = $('#freeword').val();
      var s_id = $('#id').val();
      var s_alliance = $('#alliance_flag').val();
      var s_area = $('#name_area').val();
      var s_buil = $('#name_bldg').val();
      var s_venue = $('#name_venue').val();
      var s_from = $('#capacity').val();
      var s_to = $('#capacity2').val();
      var s_counter = $('#counter').val();
      window.location.href = "/admin/venues?counter=" + counter + "&freeword=" + freeword + "&id=" + s_id + "&alliance_flag=" + s_alliance + "&name_area=" + s_area + "&name_bldg=" + s_buil + "&name_venue=" + s_venue + "&capacity1=" + s_from + "&capacity2=" + s_to;
    });

    var freeword = $('#freeword').val();
    var s_id = $('#id').val();
    var s_alliance = $('#alliance_flag').val();
    var s_area = $('#name_area').val();
    var s_buil = $('#name_bldg').val();
    var s_venue = $('#name_venue').val();
    var s_from = $('#capacity').val();
    var s_to = $('#capacity2').val();
    var s_counter = $('#counter').val();

    for (let index = 0; index < $('.page-item a').length; index++) {
      $('.page-item a').eq(index).attr('href', $('.page-item a').eq(index).attr('href') + "&counter=" + s_counter + "&freeword=" + freeword + "&id=" + s_id + "&alliance_flag=" + s_alliance + "&name_area=" + s_area + "&name_bldg=" + s_buil + "&name_venue=" + s_venue + "&capacity1=" + s_from + "&capacity2=" + s_to);
    }

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
  <h1 class="mt-3 mb-5">会場一覧</h1>
  <hr>
  <form class="" action="{{url('/admin/venues')}}">
    @csrf
    <div class="d-flex justify-content-between mt-3 mb-5">
      <span>
        <select name="counter" id="counter">
          <option value="10" {{$counter==10?'selected':''}}>10</option>
          <option value="30" {{$counter==30?'selected':''}}>30</option>
          <option value="50" {{$counter==50?'selected':''}}>50</option>
        </select>
        件表示
      </span>
      <div>
        <div class="dropdown">
          <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-offset="-320,5">
            検索
          </button>
          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <div class="d-flex justify-content-around">
              <div class="form-group">
                <label for="freeword">フリーワード検索</label>
                <input type="text" name="freeword" class="form-control" id="freeword" value={{$search_freeword}}>
              </div>
              <div class="form-group">
                <label for="id">ID</label>
                <input type="text" name="id" class="form-control" id="id" value={{$search_id}}>
              </div>
            </div>
            <div class="d-flex justify-content-around">
              <div class="form-group">
                <label for="alliance_flag">直営・提携</label>
                <input type="text" name="alliance_flag" class="form-control" id="alliance_flag" value={{$search_alliance_flag}}>
              </div>
              <div class="form-group">
                <label for="name_area">エリア別</label>
                <input type="text" name="name_area" class="form-control" id="name_area" value={{$search_name_area}}>
              </div>
            </div>
            <div class="d-flex justify-content-around">
              <div class="form-group">
                <label for="name_bldg">ビル名</label>
                <input type="text" name="name_bldg" class="form-control" id="name_bldg" value={{$search_name_bldg}}>
              </div>
              <div class="form-group">
                <label for="name_venue">会場名</label>
                <input type="text" name="name_venue" class="form-control" id="name_venue" value={{$search_name_venue}}>
              </div>
            </div>
            <div class="d-flex justify-content-around col-md-12">
              <div class="form-group">
                <label for="name_bldg">収容人数（~名以上）</label>
                <input type="number" name="capacity1" class="form-control" id="capacity" value={{$search_capacity1}}>
              </div>
              <div class="form-group">
                <label for="name_venue">収容人数（~名以下）</label>
                <input type="number" name="capacity2" class="form-control" id="capacity2" value={{$search_capacity2}}>
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
      <th>直営・提携</th>
      <th>会場</th>
      <th>広さ（坪）</th>
      <th>広さ（㎡）</th>
      <th>収容人数</th>
      <th>詳細</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($querys as $query)
    <tr>
      <td>{{ ReservationHelper::IdFormat($query->id) }}</td>
      <td>{{ ReservationHelper::formatDate($query->created_at) }}</td>
      <td>{{ $query->alliance_flag==0?'直営':'提携' }}</td>
      <td>{{ $query->name_area }}{{ $query->name_bldg }}{{ $query->name_venue }}</td>
      <td>{{ $query->size1 }}</td>
      <td>{{ $query->size2 }}</td>
      <td>{{ $query->capacity }}</td>
      <td><a href="{{ url('/admin/venues', $query->id) }}">詳細</a></td>
    </tr>
    @endforeach
  </tbody>
</table>
{{ $querys->links() }}
@endsection