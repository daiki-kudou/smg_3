<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<link href="{{ asset('/css/app.css') }}" rel="stylesheet">
<link href="{{ asset('/css/template.css') }}" rel="stylesheet">
<script src="{{ asset('/js/venue_calendar.js') }}"></script>


<div class="container-field">
  <h2 class="mt-3 mb-3">予約状況カレンダー 会場別</h2>
  <hr>
  @foreach ($days as $key=>$day)
  @foreach ($reservations as $reservation)
  @if ($reservation->reserve_date==$day)
  {{Form::hidden('start', date('Y-m-d',strtotime($reservation->reserve_date)).' '.$reservation->enter_time,['id'=>date('Y-m-d',strtotime($day)).'start'])}}
  {{Form::hidden('finish', date('Y-m-d',strtotime($reservation->reserve_date)).' '.$reservation->leave_time,['id'=>date('Y-m-d',strtotime($day)).'finish'])}}
  {{Form::hidden('date', date('Y-m-d',strtotime($reservation->reserve_date)))}}
  {{Form::hidden('status', $reservation->bills->sortBy("id")->first()->reservation_status)}}
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
  {{Form::hidden('pre_start', date('Y-m-d',strtotime($pre_reservation->reserve_date)).' '.$pre_reservation->enter_time,['id'=>date('Y-m-d',strtotime($day)).'start'])}}
  {{Form::hidden('pre_finish', date('Y-m-d',strtotime($pre_reservation->reserve_date)).' '.$pre_reservation->leave_time,['id'=>date('Y-m-d',strtotime($day)).'finish'])}}
  {{Form::hidden('pre_date', date('Y-m-d',strtotime($pre_reservation->reserve_date)))}}
  @if ($pre_reservation->user_id>0)
  {{Form::hidden('pre_company', ReservationHelper::getCompany($pre_reservation->user_id))}}
  @else
  {{Form::hidden('pre_company', ReservationHelper::getAgentCompany($pre_reservation->agent_id))}}
  @endif
  {{Form::hidden('pre_reservation_id', $pre_reservation->id)}}
  @endif
  @endforeach

  @endforeach

  <section class="mt-5 bg-white">
    <div class="calender-ttl">
      <h2>{{ReservationHelper::getVenueForUser($selected_venue)}}</h2>
      {{ Form::open(['url' => 'calendar/venue_calendar', 'method' => 'get','id'=>'v_calendar']) }}
      @csrf
      <div class="d-flex align-items-center">
        {{Form::hidden("venue_id", "")}}
        {{Form::hidden("selected_year", "")}}
        {{Form::hidden("selected_month", "")}}
      </div>
      {{ Form::close() }}

    </div>
    <ul class="calender-color">
      <li class="li-bg-reserve">予約済み</li>
      <li class="li-bg-prereserve">仮予約</li>
      <li class="li-bg-empty">空室</li>
      <li class="li-bg-closed">休業日</li>
    </ul>

    <div class="calender-wrap">
      <table class="table table-bordered calender-flame">
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
    </div>
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