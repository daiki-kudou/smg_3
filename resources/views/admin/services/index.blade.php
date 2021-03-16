@extends('layouts.admin.app')
@section('content')
<script src="{{ asset('/js/tablesorter/jquery.tablesorter.js') }}"></script>
<link href="{{ asset('/css/tablesorter/theme.default.min.css') }}" rel="stylesheet">

{{-- <script src="{{ asset('/js/admin/venue.js') }}"></script> --}}
<link href="{{ asset('/css/template.css') }}" rel="stylesheet">




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

    <h2 class="mt-3 mb-3">有料サービス管理</h2>
    <hr>

    <div class="text-right">
      <a href="/admin/services/create" class="btn more_btn3">新規登録</a>
    </div>
    <hr>
    <div class="d-flex justify-content-between my-3">

      {{ Form::open(['url' => 'admin/services', 'method'=>'get', 'id'=>'page_counter_form']) }}
      @csrf
      {{Form::text('page_counter','',(['id'=>'page_counter_input','class'=>'hide']))}}
      {{ Form::close() }}


    </div>
  </div>
  <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
    <p class="text-right">※金額は税抜表記になります。</p>
    <div class="row">
      <div class="col-sm-12">
        <table class="table table-bordered mt-5" id="service_sort">
          <thead>
            <tr class="table_row">
              <th>ID</th>
              <th>登録日</th>
              <th>有料サービス名</th>
              <th>料金</th>
              <th>備考</th>
              <th class="btn-cell">編集</th>
              <th class="btn-cell">削除</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($querys as $query)
            <tr role="row" class="even" style="background: #E3E3E3;">
              <td>{{ ReservationHelper::IdFormat($query->id) }}</td>
              <td>{{ ReservationHelper::formatDate($query->created_at) }}</td>
              <td>{{ $query->item }}</td>
              <td class="text-right">{{ number_format($query->price) }}</td>
              <td>
                <p class="remark_limit">{{ $query->remark }}</p>
              </td>
              <td class="text-center">
                {{ link_to_route('admin.services.edit', '編集', $parameters = $query->id, ['class' => 'btn more_btn']) }}
                {{ Form::model($query, ['route' => ['admin.services.destroy', $query->id], 'method' => 'delete']) }}
                @csrf
              </td>
              <td class="text-center">
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

<script>
  $(function(){
    $("#service_sort").tablesorter();
  })
</script>

@endsection