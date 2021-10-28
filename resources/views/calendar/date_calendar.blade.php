<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<link href="{{ asset('/css/app.css') }}" rel="stylesheet">
<link href="{{ asset('/css/template.css') }}" rel="stylesheet">
<script src="{{ asset('/js/date_calendar_for_user.js') }}"></script>
<script src="https://kit.fontawesome.com/a98e58f6de.js" crossorigin="anonymous"></script>

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

<div class="container-field">

  <h2 class="mt-3 mb-3">予約状況カレンダー 利用日別</h2>
  <hr>

  <section class="mt-5 bg-white">
    <div class="date_calender_wrapper" id="date_calender_wrapper">
      <div class="calender-ttl">
        <h3 class="font-weight-bold">{{ReservationHelper::formatDate($today)}}の予約状況</h3>
        <div class="d-flex align-items-center">
          <div class="row w-100">
            <div class="col">
              {{ Form::open(['url' => 'calendar/date_calendar', 'method' => 'get','id'=>'s_calendar']) }}
              @csrf
              {{ Form::hidden('date', $today) }}
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

      <div class="calender-wrap">
        <table class="table table-bordered calender-flame" style="table-layout: fixed">
          <thead>
            <tr class="calender-head">
              <td class="field-title">会議室</td>
              <td colspan="2">08:00</td>
              <td colspan="2">09:00</td>
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
            @if ($venue->id===10||$venue->id===11||$venue->id===12||$venue->id===13||$venue->id===16||$venue->id===17)
            @continue
            @else
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
            @endif
            @endforeach
          </tbody>
          <tfoot>
            <tr class="calender-head">
              <td class="field-title">会議室</td>
              <td colspan="2">08:00</td>
              <td colspan="2">09:00</td>
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
          </tfoot>
        </table>
      </div>
    </div>
  </section>


  <input type="hidden" name="json" value="{{$json_result}}">


  <input type="hidden" name="pre_json" value="{{$pre_json_result}}">




</div>