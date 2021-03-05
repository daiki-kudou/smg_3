@extends('layouts.admin.app')
@section('content')
<script src="https://cdn.datatables.net/t/bs-3.3.6/jqc-1.12.0,dt-1.10.11/datatables.min.js"></script>
<script src="{{ asset('/js/admin/venue.js') }}"></script>
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

  <h2 class="mt-3 mb-3">会場一覧</h2>
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
            <tr>
              <th>ID</th>
              <th>登録日</th>
              <th>会場</th>
              <th>直/携</th>
              <th>広さ（坪）</th>
              <th>広さ（㎡）</th>
              <th>収容人数</th>
              <th>詳細</th>
              <th>レイアウト</th>
              <th>荷物</th>
              <th>飲食</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($venues as $key=>$venue)
            @if (!empty($venue->deleted_at))
            <tr role="row" class="even" style="background: #E3E3E3;">
              <td class="sorting_1">{{ ReservationHelper::IdFormat($venue->id)}}</td>
              <td>{{ ReservationHelper::formatDate($venue->created_at)}}</td>
              <td>{{ $venue->name_area }}{{ $venue->name_bldg }}{{ $venue->name_venue }}</td>
              <td>{{$venue->alliance_flag==0?'直営':'提携'}}</td>
              <td>{{ $venue->size1}}</td>
              <td>{{ $venue->size2 }}</td>
              <td>{{ $venue->capacity }}</td>
              <td><a class="more_btn" href="{{ url('/admin/venues', $venue->id) }}">詳細</a></td>
              <td>{{$venue->layout==1?"有":"無"}}</td>
              <td>{{$venue->luggage_flag==1?"有":"無"}}</td>
              <td>{{$venue->eat_in_flag==1?"有":"無"}}</td>
            </tr>
            @else
            <tr role="row" class="even">
              <td class="sorting_1">{{ ReservationHelper::IdFormat($venue->id)}}</td>
              <td>{{ ReservationHelper::formatDate($venue->created_at)}}</td>
              <td>{{ $venue->name_area }}{{ $venue->name_bldg }}{{ $venue->name_venue }}</td>
              <td>{{$venue->alliance_flag==0?'直営':'提携'}}</td>
              <td>{{ $venue->size1}}</td>
              <td>{{ $venue->size2 }}</td>
              <td>{{ $venue->capacity }}</td>
              <td><a class="more_btn" href="{{ url('/admin/venues', $venue->id) }}">詳細</a></td>
              <td>{{$venue->layout==1?"有":"無"}}</td>
              <td>{{$venue->luggage_flag==1?"有":"無"}}</td>
              <td>{{$venue->eat_in_flag==1?"有":"無"}}</td>
            </tr>
            @endif
            @endforeach
          </tbody>
        </table>
        {{ $venues->links() }}
      </div>
    </div>
    <div class="row">
      <div class="col-sm-5"></div>
      <div class="col-sm-7"></div>
    </div>
  </div>
</div>

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
  })
</script>

@endsection