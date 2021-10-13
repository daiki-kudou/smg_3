@extends('layouts.admin.app')
@section('content')
<link href="{{ asset('/css/template.css') }}" rel="stylesheet">
<script src="{{ asset('/js/template.js') }}"></script>
<script src="{{ asset('/js/date_calendar.js') }}"></script>

<style>
  .no_wrap {
    white-space: nowrap;
  }

  .gray {
    background: gray;
  }

  table a {
    text-decoration: none;
    color: black;
  }
</style>

<div class="container-field">
  @include('layouts.admin.breadcrumbs')
  <h2 class="mt-3 mb-3">予約状況カレンダー 利用日別</h2>
  <hr>

  <section class="mt-5 bg-white">
    <div class="date_calender_wrapper" id="date_calender_wrapper">
      <div class="calender-ttl">
        <div class="d-flex align-items-center">
          <div class="row w-100">
            <div class="col text-right">
              <a href="javascript:$('#yesterday').submit()" class="text-white">
                <i class="fas fa-chevron-left fa-2x"></i>
              </a>
              {{ Form::open(['url' => 'admin/calendar/date_calendar', 'method' => 'get','id'=>'yesterday']) }}
              @csrf
              {{ Form::hidden('date', $yesterday) }}
              {{ Form::close() }}
            </div>
            <div class="col">
              {{ Form::open(['url' => 'admin/calendar/date_calendar', 'method' => 'get','id'=>'s_calendar']) }}
              @csrf
              {{ Form::text('', date('Y-m-d',strtotime($today)) ,['class'=>'form-control', 'id'=>'datepicker8', 'placeholder'=>'入力してください'] ) }}
              {{ Form::hidden('date', $today) }}
              {{ Form::close() }}
            </div>
            <div class="col">
              <a href="javascript:$('#tomorrow').submit()" class="text-white"><i
                  class="fas fa-chevron-right fa-2x"></i></a>
              {{ Form::open(['url' => 'admin/calendar/date_calendar', 'method' => 'get','id'=>'tomorrow']) }}
              @csrf
              {{ Form::hidden('date', $tomorrow) }}
              {{ Form::close() }}
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

      <table class="table table-bordered calender-flame table-scroll" style="table-layout: fixed">
        <thead>
          <tr class="calender-head">
            <td class="field-title">会議室</td>
            <td colspan="2"><span class="time-item">08:00</span></td>
            <td colspan="2"><span class="time-item">09:00</span></td>
            <td colspan="2"><span class="time-item">10:00</span></td>
            <td colspan="2"><span class="time-item">11:00</span></td>
            <td colspan="2"><span class="time-item">12:00</span></td>
            <td colspan="2"><span class="time-item">13:00</span></td>
            <td colspan="2"><span class="time-item">14:00</span></td>
            <td colspan="2"><span class="time-item">15:00</span></td>
            <td colspan="2"><span class="time-item">16:00</span></td>
            <td colspan="2"><span class="time-item">17:00</span></td>
            <td colspan="2"><span class="time-item">18:00</span></td>
            <td colspan="2"><span class="time-item">19:00</span></td>
            <td colspan="2"><span class="time-item">20:00</span></td>
            <td colspan="2"><span class="time-item">21:00</span></td>
            <td colspan="2"><span class="time-item">22:00</span></td>
            <td colspan="2"><span class="time-item">23:00</span></td>
          </tr>
        </thead>
        <tbody>
          @foreach ($venues as $venue)
          <tr class="calender-data">
            <td class="field-title">{{ReservationHelper::getVenue($venue->id)}}</td>
            <td class="{{($venue->id)}}cal0800 calhalf no_wrap"></td>
            <td class="{{($venue->id)}}cal0830 no_wrap"></td>
            <td class="{{($venue->id)}}cal0900 calhalf no_wrap"></td>
            <td class="{{($venue->id)}}cal0930 no_wrap"></td>
            <td class="{{($venue->id)}}cal1000 calhalf no_wrap"></td>
            <td class="{{($venue->id)}}cal1030 no_wrap"></td>
            <td class="{{($venue->id)}}cal1100 calhalf no_wrap"></td>
            <td class="{{($venue->id)}}cal1130 no_wrap"></td>
            <td class="{{($venue->id)}}cal1200 calhalf no_wrap"></td>
            <td class="{{($venue->id)}}cal1230 no_wrap"></td>
            <td class="{{($venue->id)}}cal1300 calhalf no_wrap"></td>
            <td class="{{($venue->id)}}cal1330 no_wrap"></td>
            <td class="{{($venue->id)}}cal1400 calhalf no_wrap"></td>
            <td class="{{($venue->id)}}cal1430 no_wrap"></td>
            <td class="{{($venue->id)}}cal1500 calhalf no_wrap"></td>
            <td class="{{($venue->id)}}cal1530 no_wrap"></td>
            <td class="{{($venue->id)}}cal1600 calhalf no_wrap"></td>
            <td class="{{($venue->id)}}cal1630 no_wrap"></td>
            <td class="{{($venue->id)}}cal1700 calhalf no_wrap"></td>
            <td class="{{($venue->id)}}cal1730 no_wrap"></td>
            <td class="{{($venue->id)}}cal1800 calhalf no_wrap"></td>
            <td class="{{($venue->id)}}cal1830 no_wrap"></td>
            <td class="{{($venue->id)}}cal1900 calhalf no_wrap"></td>
            <td class="{{($venue->id)}}cal1930 no_wrap"></td>
            <td class="{{($venue->id)}}cal2000 calhalf no_wrap"></td>
            <td class="{{($venue->id)}}cal2030 no_wrap"></td>
            <td class="{{($venue->id)}}cal2100 calhalf no_wrap"></td>
            <td class="{{($venue->id)}}cal2130 no_wrap"></td>
            <td class="{{($venue->id)}}cal2200 calhalf no_wrap"></td>
            <td class="{{($venue->id)}}cal2230 no_wrap"></td>
            <td class="{{($venue->id)}}cal2300 calhalf no_wrap"></td>
            <td class="{{($venue->id)}}cal2330 no_wrap"></td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </section>

  <iframe class="mt-5" src="{{url('/')}}/admin/note?date={{$today}}" frameborder="0" width="100%" height="500px;"
    scrolling="yes"></iframe>

  @foreach ($reservations as $reservation)
  <input type="hidden" name="venue_id" value="{{($reservation->venue_id)}}">
  <input type="hidden" name="start" value="{{date('H:i',strtotime($reservation->enter_time))}}">
  <input type="hidden" name="status" value="{{$reservation->bills->sortBy("id")->first()->reservation_status }}">
  <input type="hidden" name="company"
    value="{{ ReservationHelper::checkAgentOrUserCompany($reservation->user_id,$reservation->agent_id)}}">
  <input type="hidden" name="reservation_id" value="{{$reservation->id }}">
  @endforeach
  <input type="hidden" name="json" value="{{$json_result}}">

  <br>

  @foreach ($pre_reservations as $pre_reservation)
  <input type="hidden" name="pre_reservation_venue_id" value="{{($pre_reservation->venue_id)}}">
  <input type="hidden" name="pre_reservation_start" value="{{date('H:i',strtotime($pre_reservation->enter_time))}}">
  <input type="hidden" name="pre_reservation_finish" value="{{date('H:i',strtotime($pre_reservation->leave_time)) }}">
  <input type="hidden" name="pre_company"
    value="{{ReservationHelper::checkAgentOrUserCompany($pre_reservation->user_id,$pre_reservation->agent_id) }}">
  <input type="hidden" name="pre_reservation_id" value="{{$pre_reservation->id }}">
  <input type="hidden" name="pre_multiple_id" value="{{$pre_reservation->multiple_reserve_id }}">
  <input type="hidden" name="pre_user_id" value="{{$pre_reservation->user_id }}">
  <input type="hidden" name="pre_agent_id" value="{{$pre_reservation->agent_id }}">
  @endforeach
  <input type="hidden" name="pre_json" value="{{$pre_json_result}}">
</div>



<script type="text/javascript" src="https://code.jquery.com/ui/1.12.0/jquery-ui.min.js"></script>

@endsection