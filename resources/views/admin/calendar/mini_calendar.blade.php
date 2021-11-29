<meta charset="utf-8">
<meta name="viewport" content="width=1200, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>{{ config('app.name', 'Laravel') }}</title>
<script src="{{ asset('js/app.js') }}"></script>
<link rel="dns-prefetch" href="//fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
<link href="{{ asset('css/reset.css')}}" rel="stylesheet">
<link href="{{ asset('css/adminlte.min.css')}}" rel="stylesheet">
<link href="{{ asset('css/app.css') }}" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/multi-select/0.9.12/js/jquery.multi-select.min.js"></script>
<script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>
<script src="https://kit.fontawesome.com/a98e58f6de.js" crossorigin="anonymous"></script>
<script src="{{ asset('/js/jquery.validate.min.js') }}"></script>
<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1/i18n/jquery.ui.datepicker-ja.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/wickedpicker@0.4.3/dist/wickedpicker.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/wickedpicker@0.4.3/dist/wickedpicker.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="{{ asset('/js/numeric.js') }}"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css" />
<script type="text/javascript" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<link href="{{ asset('/css/template.css') }}" rel="stylesheet">
<script src="{{ asset('/js/template.js') }}"></script>
<script>
  var rootPath="{{url('/')}}";
</script>
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
              {{ Form::open(['url' => '/admin/calendar/mini_calendar', 'method' => 'get','id'=>'yesterday']) }}
              @csrf
              {{ Form::hidden('date', $yesterday) }}
              {{ Form::close() }}
            </div>
            <div class="col">
              {{ Form::open(['url' => '/admin/calendar/mini_calendar', 'method' => 'get','id'=>'s_calendar']) }}
              @csrf
              {{ Form::text('', date('Y-m-d',strtotime($today)) ,['class'=>'form-control', 'id'=>'datepicker8',
              'placeholder'=>'入力してください'] ) }}
              {{ Form::hidden('date', $today) }}
              {{ Form::close() }}
            </div>
            <div class="col">
              <a href="javascript:$('#tomorrow').submit()" class="text-white"><i
                  class="fas fa-chevron-right fa-2x"></i></a>
              {{ Form::open(['url' => '/admin/calendar/mini_calendar', 'method' => 'get','id'=>'tomorrow']) }}
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
  <input type="hidden" name="json" value="{{$json_result}}">
  <br>
  <input type="hidden" name="pre_json" value="{{$pre_json_result}}">
</div>



<script type="text/javascript" src="https://code.jquery.com/ui/1.12.0/jquery-ui.min.js"></script>