@extends('layouts.admin.app')

@section('content')
<script src="{{ asset('/js/tablesorter/jquery.tablesorter.js') }}"></script>
<link href="{{ asset('/css/tablesorter/theme.default.min.css') }}" rel="stylesheet">

{{-- <script src="{{ asset('/js/admin/venue.js') }}"></script> --}}
<link href="{{ asset('/css/template.css') }}" rel="stylesheet">

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
  <div class="row">
    <div class="col-sm-6"></div>
    <div class="col-sm-6"></div>
  </div>
  <div class="row">
    <div class="col-sm-12">
      <table class="table table-bordered mt-5" id="agent_sort">
        <thead>
          <tr class="table_row">
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
          <tr role="row" class="even">
            <td>{{$query->id}}</td>
            <td>{{$query->name}}</td>
            <td>{{$query->company}}</td>
            <td>{{ReservationHelper::getAgentPerson($query->id)}}</td>
            <td>{{$query->person_tel}}</td>
            <td class="text-center"><a href="{{ url('admin/agents', $query->id) }}" class="more_btn">詳細</a></td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
  {{ $querys->links() }}
</div>



<script>
  $(function(){
    $("#agent_sort").tablesorter();
  })

</script>
@endsection