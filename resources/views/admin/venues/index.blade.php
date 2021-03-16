@extends('layouts.admin.app')
@section('content')

<script src="{{ asset('/js/tablesorter/jquery.tablesorter.js') }}"></script>
<link href="{{ asset('/css/tablesorter/theme.default.min.css') }}" rel="stylesheet">

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
</div>

<div class="container-field">

  <div class="row">
    <div class="col-sm-6"></div>
    <div class="col-sm-6"></div>
  </div>
  <div class="row">
    <div class="col-sm-12">
      <table class="table table-bordered mt-5" id="venue_index">
        <thead>
          <tr class="table_row">
            <th>ID</th>
            <th>登録日</th>
            <th>直/携</th>
            <th>会場</th>
            <th>広さ（坪）</th>
            <th>広さ（㎡）</th>
            <th>収容人数</th>
            <th>レイアウト</th>
            <th>荷物</th>
            <th>飲食</th>
            <th class="btn-cell">詳細</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($venues as $key=>$venue)
          @if (!empty($venue->deleted_at))
          <tr role="row" class="even" style="background: #E3E3E3;">
            <td class="sorting_1">{{ ReservationHelper::IdFormat($venue->id)}}</td>
            <td>{{ ReservationHelper::formatDate($venue->created_at)}}</td>
            <td>{{$venue->alliance_flag==0?'直営':'提携'}}</td>
            <td>{{ $venue->name_area }}{{ $venue->name_bldg }}{{ $venue->name_venue }}</td>
            <td class="text-right">{{ $venue->size1}}</td>
            <td class="text-right">{{ $venue->size2 }}</td>
            <td class="text-right">{{ $venue->capacity }}</td>
            <td class="text-center">{{$venue->layout==1?"有":"無"}}</td>
            <td class="text-center">{{$venue->luggage_flag==1?"有":"無"}}</td>
            <td class="text-center">{{$venue->eat_in_flag==1?"有":"無"}}</td>
            <td class="text-center"><a class="more_btn" href="{{ url('/admin/venues', $venue->id) }}">詳細</a></td>
          </tr>
          @else
          <tr role="row" class="even">
            <td class="sorting_1">{{ ReservationHelper::IdFormat($venue->id)}}</td>
            <td>{{ ReservationHelper::formatDate($venue->created_at)}}</td>
            <td>{{$venue->alliance_flag==0?'直営':'提携'}}</td>
            <td>{{ $venue->name_area }}{{ $venue->name_bldg }}{{ $venue->name_venue }}</td>
            <td class="text-right">{{ $venue->size1}}</td>
            <td class="text-right">{{ $venue->size2 }}</td>
            <td class="text-right">{{ $venue->capacity }}</td>
            <td class="text-center">{{$venue->layout==1?"有":"無"}}</td>
            <td class="text-center">{{$venue->luggage_flag==1?"有":"無"}}</td>
            <td class="text-center">{{$venue->eat_in_flag==1?"有":"無"}}</td>
            <td class="text-center"><a class="more_btn" href="{{ url('/admin/venues', $venue->id) }}">詳細</a></td>
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

<script>
  $(function(){
    $("#venue_index").tablesorter();
  })
</script>

<script>
  $(function(){
    $('td').each(function(index, element){
      if ($(element).text()=="提携") {
        $(element).css('color','red');
      }
  })
  })
</script>

@endsection