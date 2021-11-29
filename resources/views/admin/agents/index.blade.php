@extends('layouts.admin.app')

@section('content')
<script src="{{ asset('/js/tablesorter/jquery.tablesorter.js') }}"></script>
<link href="{{ asset('/css/tablesorter/theme.default.min.css') }}" rel="stylesheet">
<link href="{{ asset('/css/template.css') }}" rel="stylesheet">

<div class="container-field">
  @include('layouts.admin.breadcrumbs')
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
            <th>管理URL</th>
            <th>運営会社名</th>
            <th>担当者氏名</th>
            <th>担当者TEL</th>
            <th>詳細</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($agents as $agent)
          <tr>
            <td>{{ReservationHelper::fixId($agent->id)}}</td>
            <td>{{$agent->name}}</td>
            <td class="text-center">
              <a href="{{ $agent->login }}" target="blank" class="more_btn">管理画面をみる</a>
            </td>
            <td>{{$agent->company}}</td>
            <td>{{ReservationHelper::getAgentPerson($agent->id)}}</td>
            <td>{{$agent->person_mobile}}</td>
            <td class="text-center"><a href="{{ url('/admin/agents', $agent->id) }}" class="more_btn">詳細</a></td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
<script>
  $(document).ready(function(){
    $.extend($.fn.dataTable.defaults, {
        language: {
            url: "https://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Japanese.json"
        }
    });
    $('#agent_sort').DataTable({
      searching: false,
      info: false,
      autowidth: false,
      "order": [[ 0, "desc" ]], //初期ソートソート条件
      "columnDefs": [
        {
        "orderable": false, 
        "targets": [2,6] 
        },
        {
        "className": "text-center",
        "targets": [0,1,2,3,4,5,6],
        }
        ],
      "stripeClasses": [],
     });
    });
</script>
@endsection