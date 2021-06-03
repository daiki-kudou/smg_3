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
  <div class="table-wrap">
    <table class="table table-bordered mt-5" id="venue_index">
      <thead>
        <tr class="table_row">
          <th id="id">ID {!!ReservationHelper::sortIcon($request->id)!!}</th>
          <th id="created_at">登録日 {!!ReservationHelper::sortIcon($request->created_at)!!}</th>
          <th id="alliance_flag">直/携 {!!ReservationHelper::sortIcon($request->alliance_flag)!!}</th>
          <th id="name_bldg">会場 {!!ReservationHelper::sortIcon($request->name_bldg)!!}</th>
          <th id="size1">広さ（坪） {!!ReservationHelper::sortIcon($request->size1)!!}</th>
          <th id="size2">広さ（㎡） {!!ReservationHelper::sortIcon($request->size2)!!}</th>
          <th id="capacity">収容人数 {!!ReservationHelper::sortIcon($request->capacity)!!}</th>
          <th id="layout">レイアウト変更 {!!ReservationHelper::sortIcon($request->layout)!!}</th>
          <th id="luggage_flag">預り荷物 {!!ReservationHelper::sortIcon($request->luggage_flag)!!}</th>
          <th id="eat_in_flag">室内飲食 {!!ReservationHelper::sortIcon($request->eat_in_flag)!!}</th>
          <th class="btn-cell">詳細</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($venues as $key=>$venue)
        @if (!empty($venue->deleted_at))
        <tr role="row" class="even">
          <td class="sorting_1">{{ ReservationHelper::fixId($venue->id)}}</td>
          <td>{{ ReservationHelper::formatDate($venue->created_at)}}</td>
          <td class="text-center">{{$venue->alliance_flag==0?'直':'提'}}</td>
          <td>{{ $venue->name_bldg }}{{ $venue->name_venue }}</td>
          <td class="text-right">{{ $venue->size1}}坪</td>
          <td class="text-right">{{ $venue->size2 }}㎡</td>
          <td class="text-right">{{ $venue->capacity }}</td>
          <td class="text-center">{{$venue->layout==1?"可":"不可"}}</td>
          <td class="text-center">{{$venue->luggage_flag==1?"可":"不可"}}</td>
          <td class="text-center">{{$venue->eat_in_flag==1?"可":"不可"}}</td>
          <td class="text-center"><a class="more_btn" href="{{ url('/admin/venues', $venue->id) }}">詳細</a></td>
        </tr>
        @else
        <tr role="row" class="even">
          <td class="sorting_1">{{ ReservationHelper::fixId($venue->id)}}</td>
          <td>{{ ReservationHelper::formatDate($venue->created_at)}}</td>
          <td class="text-center">{{$venue->alliance_flag==0?'直':'提'}}</td>
          <td>{{ $venue->name_bldg }}{{ $venue->name_venue }}</td>
          <td class="text-right">{{ $venue->size1}}坪</td>
          <td class="text-right">{{ $venue->size2 }}㎡</td>
          <td class="text-right">{{ $venue->capacity }}</td>
          <td class="text-center">{{$venue->layout==1?"可":"不可"}}</td>
          <td class="text-center">{{$venue->luggage_flag==1?"可":"不可"}}</td>
          <td class="text-center">{{$venue->eat_in_flag==1?"可":"不可"}}</td>
          <td class="text-center"><a class="more_btn" href="{{ url('/admin/venues', $venue->id) }}">詳細</a></td>
        </tr>
        @endif
        @endforeach
      </tbody>
    </table>
    {{ $venues->appends(request()->input())->links() }}
  </div>
</div>



{{-- 1降順　2昇順 --}}
{{ Form::open(['url' => 'admin/venues', 'method'=>'get', 'id'=>'sort_form']) }}
@csrf
{{Form::hidden("id", $request->id?($request->id==1?2:1):1)}}
{{Form::hidden("created_at", $request->created_at?($request->created_at==1?2:1):1)}}
{{Form::hidden("alliance_flag", $request->alliance_flag?($request->alliance_flag==1?2:1):1)}}
{{Form::hidden("name_bldg", $request->name_bldg?($request->name_bldg==1?2:1):1)}}
{{Form::hidden("size1", $request->size1?($request->size1==1?2:1):1)}}
{{Form::hidden("size2", $request->size2?($request->size2==1?2:1):1)}}
{{Form::hidden("capacity", $request->capacity?($request->capacity==1?2:1):1)}}
{{Form::hidden("layout", $request->layout?($request->layout==1?2:1):1)}}
{{Form::hidden("luggage_flag", $request->luggage_flag?($request->luggage_flag==1?2:1):1)}}
{{Form::hidden("eat_in_flag", $request->eat_in_flag?($request->eat_in_flag==1?2:1):1)}}
{{Form::close()}}

<script>
  $(document).on("click", "th", function() {
    var click_th_id=$(this).attr("id");
    $("#sort_form input").each(function(key, item){
      if ($(item).attr("name")!=click_th_id) {
        $(item).val("");
      }
    })
    $("#sort_form").submit();
    })


  $(function(){
    $('td').each(function(index, element){
      if ($(element).text()=="提") {
        $(element).css('color','red');
      }
  })
  })
</script>

@endsection