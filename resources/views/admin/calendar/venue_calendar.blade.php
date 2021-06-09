@extends('layouts.admin.app')

@section('content')

<link href="{{ asset('/css/template.css') }}" rel="stylesheet">
<script src="{{ asset('/js/venue_calendar.js') }}"></script>

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


  <h2 class="mt-3 mb-3">予約状況カレンダー 会場別</h2>
  <hr>

  @foreach ($reservations as $key=>$reservation)
  {{Form::hidden('reservation_id', $reservation->id)}}
  {{Form::hidden('start', date('Hi',strtotime($reservation->enter_time)))}}
  {{Form::hidden('finish', date('Hi',strtotime($reservation->leave_time)))}}
  {{Form::hidden('date', date('Y-m-d',strtotime($reservation->reserve_date)))}}
  {{Form::hidden('status', $reservation->bills->sortBy("id")->first()->reservation_status)}}
  {{Form::hidden('user_id', $reservation->user_id)}}
  {{Form::hidden('agent_id', $reservation->agent_id)}}
  {{Form::hidden('company', ReservationHelper::checkAgentOrUserCompany($reservation->user_id,$reservation->agent_id))}}
  @endforeach
  {{Form::hidden('each_json', ($json_result))}}<br>

  @foreach ($pre_reservations as $key=>$pre_reservation)
  {{Form::hidden('pre_reservation_id', $pre_reservation->id)}}
  {{Form::hidden('pre_start', date('Hi',strtotime($pre_reservation->enter_time)))}}
  {{Form::hidden('pre_finish', date('Hi',strtotime($pre_reservation->leave_time)))}}
  {{Form::hidden('pre_date', date('Y-m-d',strtotime($pre_reservation->reserve_date)))}}
  {{Form::hidden('pre_user_id', $pre_reservation->user_id)}}
  {{Form::hidden('pre_agent_id', $pre_reservation->agent_id)}}
  {{Form::hidden('pre_status', $pre_reservation->status)}}
  {{Form::hidden('pre_company', ReservationHelper::checkAgentOrUserCompany($pre_reservation->user_id,$pre_reservation->agent_id))}}
  {{Form::hidden('multiple_id', $pre_reservation->multiple_reserve_id)}}
  @endforeach
  {{Form::hidden('pre_each_json', ($pre_json_result))}}<br>

  <section class="mt-5 bg-white">
    <div class="calender-ttl">
      {{ Form::open(['url' => '/admin/calendar/venue_calendar', 'method' => 'get']) }}
      @csrf
      <div class="d-flex align-items-center">
        <select name="venue_id" id="venue_id" class="form-control">
          @foreach ($venues as $venue)
          <option value="{{$venue->id}}" @if ($venue->id==$selected_venue)
            selected
            @endif
            >{{$venue->name_area}}{{$venue->name_bldg}}{{$venue->name_venue}}</option>
          @endforeach
        </select>
        <select name="selected_year" id="selected_year" class="form-control w-25 ml-2">
          @for ($i = 2021; $i < 2031; $i++) <option value="{{$i}}" @if ($selected_year==$i) selected @endif>{{$i}}
            </option>
            @endfor
        </select>
        <select name="selected_month" id="selected_month" class="form-control w-25 mx-2">
          @for ($ii = 1; $ii <= 12; $ii++) <option value="{{$ii}}" @if ($selected_month==$ii) selected @endif>{{$ii}}月
            </option>
            @endfor
        </select>
        {{Form::submit('予約状況を確認する', ['class' => 'btn more_btn'])}}
      </div>
      {{ Form::close() }}

    </div>
    <ul class="calender-color">
      <li class="li-bg-reserve">予約済み</li>
      <li class="li-bg-prereserve">仮予約</li>
      <li class="li-bg-empty">空室</li>
      <li class="li-bg-closed">休業日</li>
    </ul>

    <table class="table table-bordered calender-flame" style="table-layout: fixed">
      <thead>
        <tr class="calender-head">
          <td class="field-title">日付</td>
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
        @foreach ($days as $key=>$day)
        <tr class="calender-data">
          <td class="field-title">{{ReservationHelper::formatDate($day)}}</td>
          <td class="{{date('Y-m-d',strtotime($day))}}cal1000 calhalf no_wrap"></td>
          <td class="{{date('Y-m-d',strtotime($day))}}cal1030 no_wrap"></td>
          <td class="{{date('Y-m-d',strtotime($day))}}cal1100 calhalf no_wrap"></td>
          <td class="{{date('Y-m-d',strtotime($day))}}cal1130 no_wrap"></td>
          <td class="{{date('Y-m-d',strtotime($day))}}cal1200 calhalf no_wrap"></td>
          <td class="{{date('Y-m-d',strtotime($day))}}cal1230 no_wrap"></td>
          <td class="{{date('Y-m-d',strtotime($day))}}cal1300 calhalf no_wrap"></td>
          <td class="{{date('Y-m-d',strtotime($day))}}cal1330 no_wrap"></td>
          <td class="{{date('Y-m-d',strtotime($day))}}cal1400 calhalf no_wrap"></td>
          <td class="{{date('Y-m-d',strtotime($day))}}cal1430 no_wrap"></td>
          <td class="{{date('Y-m-d',strtotime($day))}}cal1500 calhalf no_wrap"></td>
          <td class="{{date('Y-m-d',strtotime($day))}}cal1530 no_wrap"></td>
          <td class="{{date('Y-m-d',strtotime($day))}}cal1600 calhalf no_wrap"></td>
          <td class="{{date('Y-m-d',strtotime($day))}}cal1630 no_wrap"></td>
          <td class="{{date('Y-m-d',strtotime($day))}}cal1700 calhalf no_wrap"></td>
          <td class="{{date('Y-m-d',strtotime($day))}}cal1730 no_wrap"></td>
          <td class="{{date('Y-m-d',strtotime($day))}}cal1800 calhalf no_wrap"></td>
          <td class="{{date('Y-m-d',strtotime($day))}}cal1830 no_wrap"></td>
          <td class="{{date('Y-m-d',strtotime($day))}}cal1900 calhalf no_wrap"></td>
          <td class="{{date('Y-m-d',strtotime($day))}}cal1930 no_wrap"></td>
          <td class="{{date('Y-m-d',strtotime($day))}}cal2000 calhalf no_wrap"></td>
          <td class="{{date('Y-m-d',strtotime($day))}}cal2030 no_wrap"></td>
          <td class="{{date('Y-m-d',strtotime($day))}}cal2100 calhalf no_wrap"></td>
          <td class="{{date('Y-m-d',strtotime($day))}}cal2130 no_wrap"></td>
          <td class="{{date('Y-m-d',strtotime($day))}}cal2200 calhalf no_wrap"></td>
          <td class="{{date('Y-m-d',strtotime($day))}}cal2230 no_wrap"></td>
          <td class="{{date('Y-m-d',strtotime($day))}}cal2300 calhalf no_wrap"></td>
          <td class="{{date('Y-m-d',strtotime($day))}}cal2330 no_wrap"></td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </section>
</div>

<style>
  .no_wrap {
    white-space: nowrap;
  }

  .gray {
    background: gray;
  }

  a {
    text-decoration: none;
    color: black;
  }
</style>

@endsection