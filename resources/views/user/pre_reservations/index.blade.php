@extends('layouts.user.app')
@section('content')
<link href="{{ asset('/css/template.css') }}" rel="stylesheet">
{{-- <script src="{{ asset('/js/template.js') }}"></script>
<script src="{{ asset('/js/ajax.js') }}"></script> --}}

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

  <h2 class="mt-3 mb-3">仮押え 一覧</h2>
  <hr>
</div>

<div class="mt-5">
  <p class="text-right font-weight-bold"><span class="count-color">{{$counter}}</span>件</p>
</div>
<div class="table-wrap">
  <table class="table table-bordered table-box table-scroll">
    <thead>
      <tr>
        <th>一括仮押えID</th>
        <th>仮押えID</th>
        <th>利用日</th>
        <th>入室時間</th>
        <th>退室時間</th>
        <th>利用会場</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      @foreach ($pre_reservations as $pre_reservation)
      <tr>
        <td>{{$pre_reservation->multiple_reserve_id==0?"":$pre_reservation->multiple_reserve_id}}</td>
        <td>{{ReservationHelper::fixId($pre_reservation->id)}}</td>
        <td>{{ReservationHelper::formatDate($pre_reservation->reserve_date)}}</td>
        <td>{{ReservationHelper::formatTime($pre_reservation->enter_time)}}</td>
        <td>{{ReservationHelper::formatTime($pre_reservation->leave_time)}}</td>
        <td>{{ReservationHelper::getVenueForUser($pre_reservation->venue_id)}}</td>
        <td>
          <a href="{{url('user/pre_reservations/'.$pre_reservation->id)}}" class="more_btn">本予約を申込む</a>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>

<!-- 一覧　　終わり------------------------------------------------ -->

{{$pre_reservations->appends(request()->input())->render()}}






@endsection