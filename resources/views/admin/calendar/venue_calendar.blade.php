@extends('layouts.admin.app')

@section('content')

<link href="{{ asset('/css/template.css') }}" rel="stylesheet">
<script src="{{ asset('/js/venue_calendar.js') }}"></script>

<div class="container-field">
  @include('layouts.admin.breadcrumbs')
  <h2 class="mt-3 mb-3">予約状況カレンダー 会場別</h2>
  <hr>


  {{Form::hidden('each_json', ($json_result))}}<br>

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
          @for ($i = Carbon\Carbon::today()->year; $i < Carbon\Carbon::today()->addYears(3)->year; $i++)
            <option value="{{$i}}" @if ($selected_year==$i) selected @endif>
              {{$i}}
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
        @foreach ($days as $key=>$day)
        <tr class="calender-data">
          <td class="field-title">{{ReservationHelper::formatDate($day)}}</td>
          <td class="{{date('Y-m-d',strtotime($day))}}cal0800 calhalf no_wrap"></td>
          <td class="{{date('Y-m-d',strtotime($day))}}cal0830 no_wrap"></td>
          <td class="{{date('Y-m-d',strtotime($day))}}cal0900 calhalf no_wrap"></td>
          <td class="{{date('Y-m-d',strtotime($day))}}cal0930 no_wrap"></td>
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

  table a {
    text-decoration: none;
    color: black;
  }
</style>

@endsection