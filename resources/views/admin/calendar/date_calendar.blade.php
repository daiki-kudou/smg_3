@extends('layouts.admin.app')

@section('content')

<link href="{{ asset('/css/template.css') }}" rel="stylesheet">
<script src="{{ asset('/js/template.js') }}"></script>



<div class="calender-ttl">
  <h3>予約状況</h3>

  <div class="d-flex align-items-center">
    <div class="row w-100">
      <div class="col text-right">
        <i class="fas fa-chevron-left fa-2x"></i>
      </div>
      <div class="col">
        {{ Form::open(['url' => 'admin/calendar/date_calendar', 'method' => 'get']) }}
        {{ Form::text('', date('Y-m-d',strtotime($today)) ,['class'=>'form-control', 'id'=>'datepicker8', 'placeholder'=>'入力してください'] ) }}
        {{ Form::hidden('date', $today) }}
        {{Form::submit('確認する')}}
        {{ Form::close() }}

      </div>
      <div class="col">
        <i class="fas fa-chevron-right fa-2x"></i>
      </div>
    </div>
  </div>

</div>
<ul class="calender-color">
  <li class="li-bg-reserve">予約済み</li>
  <li class="li-bg-prereserve">仮予約</li>
  <li class="li-bg-empty">空室</li>
  <li class="li-bg-closed">休業日</li>
</ul>








@foreach ($reservations->where('reserve_date',$today) as $reservation)
予約ID　：　{{$reservation->id}}<br>
会場　：　{{$reservation->venue_id}}<br>
予約ユーザー　：　{{$reservation->user_id}}<br>
開始時間　：　{{$reservation->enter_time}}<br>
終了時間　：　{{$reservation->leave_time}}<br>
<br><br>
@endforeach


<table class="table table-bordered calender-flame">
  <thead>
    <tr class="calender-head">
      <td class="field-title">会議室</td>
      <td colspan="2">10:00</td>
      <td colspan="2">11:00</td>
      <td colspan="2">12:00</td>
      <td colspan="2">13:00</td>
      <td colspan="2">14:00</td>
      <td colspan="2">15:00</td>
      <td colspan="2">16:00</td>
      <td colspan="2">17:00</td>
      <td colspan="2">18:00</td>
      <td colspan="2">19:00</td>
      <td colspan="2">20:00</td>
      <td colspan="2">21:00</td>
      <td colspan="2">22:00</td>
      <td colspan="2">23:00</td>
    </tr>
  </thead>
  <tbody>
    @foreach ($venues as $venue)
    <tr class="calender-data">
      <td class="field-title">{{ReservationHelper::getVenue($venue->id)}}</td>
      <td class="{{ReservationHelper::getVenue($venue->id)}}cal1000 calhalf no_wrap"></td>
      <td class="{{ReservationHelper::getVenue($venue->id)}}cal1030 no_wrap"></td>
      <td class="{{ReservationHelper::getVenue($venue->id)}}cal1100 calhalf no_wrap"></td>
      <td class="{{ReservationHelper::getVenue($venue->id)}}cal1130 no_wrap"></td>
      <td class="{{ReservationHelper::getVenue($venue->id)}}cal1200 calhalf no_wrap"></td>
      <td class="{{ReservationHelper::getVenue($venue->id)}}cal1230 no_wrap"></td>
      <td class="{{ReservationHelper::getVenue($venue->id)}}cal1300 calhalf no_wrap"></td>
      <td class="{{ReservationHelper::getVenue($venue->id)}}cal1330 no_wrap"></td>
      <td class="{{ReservationHelper::getVenue($venue->id)}}cal1400 calhalf no_wrap"></td>
      <td class="{{ReservationHelper::getVenue($venue->id)}}cal1430 no_wrap"></td>
      <td class="{{ReservationHelper::getVenue($venue->id)}}cal1500 calhalf no_wrap"></td>
      <td class="{{ReservationHelper::getVenue($venue->id)}}cal1530 no_wrap"></td>
      <td class="{{ReservationHelper::getVenue($venue->id)}}cal1600 calhalf no_wrap"></td>
      <td class="{{ReservationHelper::getVenue($venue->id)}}cal1630 no_wrap"></td>
      <td class="{{ReservationHelper::getVenue($venue->id)}}cal1700 calhalf no_wrap"></td>
      <td class="{{ReservationHelper::getVenue($venue->id)}}cal1730 no_wrap"></td>
      <td class="{{ReservationHelper::getVenue($venue->id)}}cal1800 calhalf no_wrap"></td>
      <td class="{{ReservationHelper::getVenue($venue->id)}}cal1830 no_wrap"></td>
      <td class="{{ReservationHelper::getVenue($venue->id)}}cal1900 calhalf no_wrap"></td>
      <td class="{{ReservationHelper::getVenue($venue->id)}}cal1930 no_wrap"></td>
      <td class="{{ReservationHelper::getVenue($venue->id)}}cal2000 calhalf no_wrap"></td>
      <td class="{{ReservationHelper::getVenue($venue->id)}}cal2030 no_wrap"></td>
      <td class="{{ReservationHelper::getVenue($venue->id)}}cal2100 calhalf no_wrap"></td>
      <td class="{{ReservationHelper::getVenue($venue->id)}}cal2130 no_wrap"></td>
      <td class="{{ReservationHelper::getVenue($venue->id)}}cal2200 calhalf no_wrap"></td>
      <td class="{{ReservationHelper::getVenue($venue->id)}}cal2230 no_wrap"></td>
      <td class="{{ReservationHelper::getVenue($venue->id)}}cal2300 calhalf no_wrap"></td>
      <td class="{{ReservationHelper::getVenue($venue->id)}}cal2330 no_wrap"></td>
    </tr>
    @endforeach
  </tbody>
</table>









<script>
  $(function(){
    $('#datepicker8').on('change',function(){
      $('input[name="date"]').val($(this).val());
      console.log($(this).val());
    })
  })
</script>

@endsection