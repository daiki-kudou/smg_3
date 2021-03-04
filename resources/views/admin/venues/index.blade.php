@extends('layouts.admin.app')
@section('content')
<script src="https://cdn.datatables.net/t/bs-3.3.6/jqc-1.12.0,dt-1.10.11/datatables.min.js"></script>
<script src="{{ asset('/js/admin/venue.js') }}"></script>
<link href="{{ asset('/css/template.css') }}" rel="stylesheet">

<div class="container-field mt-3">
  <div class="float-right">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active"><a href="https://staging-smg2.herokuapp.com/admin/home">ホーム</a> &gt;
          会場　一覧
        </li>
      </ol>
    </nav>
  </div>

  <h2 class="mt-3 mb-3">会場一覧</h2>
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

  <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
    <div class="row">
      <div class="col-sm-6"></div>
      <div class="col-sm-6"></div>
    </div>
    <div class="row">
      <div class="col-sm-12">
        <table class="table table-bordered mt-5 dataTable no-footer" id="DataTables_Table_0" role="grid">
          <thead>
            <tr style="white-space: nowrap;" role="row">
              <th class="sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                aria-sort="ascending" aria-label="ID: activate to sort column descending" style="width: 73px;">ID</th>
              <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                aria-label="登録日: activate to sort column ascending" style="width: 155px;">登録日</th>
              <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                aria-label="会場: activate to sort column ascending" style="width: 390px;">会場</th>
              <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                aria-label="直/携: activate to sort column ascending" style="width: 86px;">直/携</th>
              <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                aria-label="広さ（坪）: activate to sort column ascending" style="width: 141px;">広さ（坪）</th>
              <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                aria-label="広さ（㎡）: activate to sort column ascending" style="width: 142px;">広さ（㎡）</th>
              <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                aria-label="収容人数: activate to sort column ascending" style="width: 120px;">収容人数</th>
              <th style="min-width: 89px; width: 143px;" class="btn-cell sorting_disabled" rowspan="1" colspan="1"
                aria-label="詳細">詳細</th>
              <th>レイアウト</th>
              <th>荷物</th>
              <th>飲食</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($querys as $key=>$query)
            @if ($key%2==0)
            <tr role="row" class="even">
              <td class="sorting_1">{{ ReservationHelper::IdFormat($query->id)}}</td>
              <td>{{ ReservationHelper::formatDate($query->created_at)}}</td>
              <td>{{ $query->name_area }}{{ $query->name_bldg }}{{ $query->name_venue }}</td>
              <td>{{$query->alliance_flag==0?'直営':'提携'}}</td>
              <td>{{ $query->size1}}</td>
              <td>{{ $query->size2 }}</td>
              <td>{{ $query->capacity }}</td>
              <td><a class="more_btn" href="{{ url('/admin/venues', $query->id) }}">詳細</a></td>
              <td>{{$query->layout==1?"有":"無"}}</td>
              <td>{{$query->luggage_flag==1?"有":"無"}}</td>
              <td>{{$query->eat_in_flag==1?"有":"無"}}</td>
            </tr>
            @else
            <tr role="row" class="odd">
              <td class="sorting_1">{{ ReservationHelper::IdFormat($query->id)}}</td>
              <td>{{ ReservationHelper::formatDate($query->created_at)}}</td>
              <td>{{ $query->name_area }}{{ $query->name_bldg }}{{ $query->name_venue }}</td>
              <td>{{$query->alliance_flag==0?'直営':'提携'}}</td>
              <td>{{ $query->size1}}</td>
              <td>{{ $query->size2 }}</td>
              <td>{{ $query->capacity }}</td>
              <td><a class="more_btn" href="{{ url('/admin/venues', $query->id) }}">詳細</a></td>
              <td>{{$query->layout==1?"有":"無"}}</td>
              <td>{{$query->luggage_flag==1?"有":"無"}}</td>
              <td>{{$query->eat_in_flag==1?"有":"無"}}</td>
            </tr>
            @endif
            @endforeach
          </tbody>
        </table>
        {{ $querys->links() }}
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