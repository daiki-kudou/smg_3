@extends('layouts.admin.app')

@section('content')

<link href="{{ asset('/css/template.css') }}" rel="stylesheet">


<h2 class="mt-3 mb-3">予約状況カレンダー 会場別</h2>
<hr>

@foreach ($days as $key=>$day)
@foreach ($reservations as $reservation)
@if ($reservation->reserve_date==$day)
{{Form::hidden('start', date('Y-m-d',strtotime($reservation->reserve_date)).' '.$reservation->enter_time,['id'=>date('Y-m-d',strtotime($day)).'start'])}}
{{Form::hidden('finish', date('Y-m-d',strtotime($reservation->reserve_date)).' '.$reservation->leave_time,['id'=>date('Y-m-d',strtotime($day)).'finish'])}}
{{Form::hidden('date', date('Y-m-d',strtotime($reservation->reserve_date)))}}
{{Form::hidden('status', $reservation->bills()->first()->reservation_status)}}
@if ($reservation->user_id>0)
{{Form::hidden('company', ReservationHelper::getCompany($reservation->user_id))}}
@else
{{Form::hidden('company', ReservationHelper::getAgentCompany($reservation->agent_id))}}
@endif
{{Form::hidden('reservation_id', $reservation->id)}}
@endif
@endforeach

@foreach ($pre_reservations as $pre_reservation)
@if ($pre_reservation->reserve_date==$day)
{{Form::text('start', date('Y-m-d',strtotime($pre_reservation->reserve_date)).' '.$pre_reservation->enter_time,['id'=>date('Y-m-d',strtotime($day)).'start'])}}
{{Form::text('finish', date('Y-m-d',strtotime($pre_reservation->reserve_date)).' '.$pre_reservation->leave_time,['id'=>date('Y-m-d',strtotime($day)).'finish'])}}
{{Form::text('date', date('Y-m-d',strtotime($pre_reservation->reserve_date)))}}
{{Form::text('status', $pre_reservation->pre_bill()->first()->reservation_status)}}
@if ($pre_reservation->user_id>0)
{{Form::text('company', ReservationHelper::getCompany($pre_reservation->user_id))}}
@else
{{Form::text('company', ReservationHelper::getAgentCompany($pre_reservation->agent_id))}}
@endif
{{Form::text('reservation_id', $pre_reservation->id)}}
@endif
@endforeach
@endforeach



<section class="mt-5 bg-white">
  <div class="calender-ttl">
    <!-- <h3 class="">予約状況</h3> -->
    {{ Form::open(['url' => '/admin/calendar/venue_calendar', 'method' => 'post']) }}
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
        @for ($i = 2021; $i < 2031; $i++) <option value="{{$i}}" @if ($selected_year==$i) selected @endif>{{$i}}</option>
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

  <table class="table table-bordered calender-flame">
    <thead>
      <tr class="calender-head">
        <td class="field-title">タイトル</td>
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
<script>
  $(function() {
    var name = $('input[name="start"]');
    for (let nums = 0; nums < name.length; nums++) {
      var start = $('input[name="start"]').eq(nums).val();
      var finish = $('input[name="finish"]').eq(nums).val();
      var s_date = $('input[name="date"]').eq(nums).val();
      var status = $('input[name="status"]').eq(nums).val();
      var company = $('input[name="company"]').eq(nums).val();
      var reservation_id = $('input[name="reservation_id"]').eq(nums).val();
      var ds = new Date(start);
      ds.setMinutes(ds.getMinutes() - (60));
      var df = new Date(finish);
      var diffTime = df.getTime() - ds.getTime();
      var diffTime = Math.floor(diffTime / (1000 * 60));
      var target = diffTime / 30;

      function zeroPadding(num) {
        return ('0' + num).slice(-2);
      }
      for (let index = 0; index < target; index++) {
        ds.setMinutes(ds.getMinutes() + (30));
        var hours = ds.getHours();
        hours = zeroPadding(hours);
        var minutes = ds.getMinutes();
        minutes = zeroPadding(minutes);
        // console.log(hours+minutes);
        var result = hours + minutes;
        if (status == 3) {
          $("." + s_date + "cal" + result).addClass('bg-reserve');
          if (!$("." + s_date + "cal" + result).prev().hasClass('bg-reserve')) {
            // 始めに灰色
            $("." + s_date + "cal" + result).addClass('gray');
          }
          if ($("." + s_date + "cal" + result).prev().hasClass('gray')) {
            $("." + s_date + "cal" + result).html("<a href='/admin/reservations/" + reservation_id + "'>" + company + "</a>");
          }
        } else if (status < 3) {
          $("." + s_date + "cal" + result).addClass('bg-prereserve');
        }
      }
      // 最後に灰色
      $('.bg-reserve:last').addClass('gray');
      $('.bg-prereserve:last').addClass('gray');
    }
  })
</script>
@endsection