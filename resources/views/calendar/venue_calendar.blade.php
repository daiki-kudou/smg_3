<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.5.0.min.js"></script>

<link href="{{ asset('/css/template.css') }}" rel="stylesheet">

@foreach ($days as $key=>$day)
@foreach ($find_venues as $find_venue)
@if ($find_venue->reserve_date==$day)
{{Form::hidden('start', date('Y-m-d',strtotime($find_venue->reserve_date)).' '.$find_venue->enter_time,['id'=>date('Y-m-d',strtotime($day)).'start'])}}
{{Form::hidden('finish', date('Y-m-d',strtotime($find_venue->reserve_date)).' '.$find_venue->leave_time,['id'=>date('Y-m-d',strtotime($day)).'finish'])}}
{{Form::hidden('date', date('Y-m-d',strtotime($find_venue->reserve_date)))}}
{{Form::hidden('status', $find_venue->reservation_status)}}
{{Form::hidden('company', ReservationHelper::getCompany($find_venue->user_id))}}
{{Form::hidden('reservation_id', $find_venue->id)}}
@endif
@endforeach
@endforeach



<div class="container-field mt-3">
  <div class="float-right">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active">ダミーテキスト</li>
      </ol>
    </nav>
  </div>
  <h2 class="mt-3 mb-3">予約状況カレンダー</h2>
  <hr>
</div>



<div class="calender-wrap">

  <div class="calender-ttl">
    {{ Form::open(['url' => 'calender/venue_calendar', 'method' => 'get']) }}
    @csrf
    <select name="venue_id" id="venue_id">
      @foreach ($venues as $venue)
      <option value="{{$venue->id}}" @if ($venue->id==$selected_venue)
        selected
        @endif
        >{{$venue->name_area}}{{$venue->name_bldg}}{{$venue->name_venue}}</option>
      @endforeach
    </select>
    {{Form::submit('確認する')}}
    {{ Form::close() }}

    <h3>予約状況</h3>
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
        <td class="{{date('Y-m-d',strtotime($day))}}cal100 calhalf no_wrap"></td>
        <td class="{{date('Y-m-d',strtotime($day))}}cal1030 no_wrap"></td>
        <td class="{{date('Y-m-d',strtotime($day))}}cal110 calhalf no_wrap"></td>
        <td class="{{date('Y-m-d',strtotime($day))}}cal1130 no_wrap"></td>
        <td class="{{date('Y-m-d',strtotime($day))}}cal120 calhalf no_wrap"></td>
        <td class="{{date('Y-m-d',strtotime($day))}}cal1230 no_wrap"></td>
        <td class="{{date('Y-m-d',strtotime($day))}}cal130 calhalf no_wrap"></td>
        <td class="{{date('Y-m-d',strtotime($day))}}cal1330 no_wrap"></td>
        <td class="{{date('Y-m-d',strtotime($day))}}cal140 calhalf no_wrap"></td>
        <td class="{{date('Y-m-d',strtotime($day))}}cal1430 no_wrap"></td>
        <td class="{{date('Y-m-d',strtotime($day))}}cal150 calhalf no_wrap"></td>
        <td class="{{date('Y-m-d',strtotime($day))}}cal1530 no_wrap"></td>
        <td class="{{date('Y-m-d',strtotime($day))}}cal160 calhalf no_wrap"></td>
        <td class="{{date('Y-m-d',strtotime($day))}}cal1630 no_wrap"></td>
        <td class="{{date('Y-m-d',strtotime($day))}}cal170 calhalf no_wrap"></td>
        <td class="{{date('Y-m-d',strtotime($day))}}cal1730 no_wrap"></td>
        <td class="{{date('Y-m-d',strtotime($day))}}cal180 calhalf no_wrap"></td>
        <td class="{{date('Y-m-d',strtotime($day))}}cal1830 no_wrap"></td>
        <td class="{{date('Y-m-d',strtotime($day))}}cal190 calhalf no_wrap"></td>
        <td class="{{date('Y-m-d',strtotime($day))}}cal1930 no_wrap"></td>
        <td class="{{date('Y-m-d',strtotime($day))}}cal200 calhalf no_wrap"></td>
        <td class="{{date('Y-m-d',strtotime($day))}}cal2030 no_wrap"></td>
        <td class="{{date('Y-m-d',strtotime($day))}}cal210 calhalf no_wrap"></td>
        <td class="{{date('Y-m-d',strtotime($day))}}cal2130 no_wrap"></td>
        <td class="{{date('Y-m-d',strtotime($day))}}cal220 calhalf no_wrap"></td>
        <td class="{{date('Y-m-d',strtotime($day))}}cal2230 no_wrap"></td>
        <td class="{{date('Y-m-d',strtotime($day))}}cal230 calhalf no_wrap"></td>
        <td class="{{date('Y-m-d',strtotime($day))}}cal2330 no_wrap"></td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>

<style>
  .no_wrap {
    white-space: nowrap;
  }

  .gray {
    background: gray;
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

      var ds = new Date(start);
      ds.setMinutes(ds.getMinutes() - (60));
      var df = new Date(finish);
      var diffTime = df.getTime() - ds.getTime();
      var diffTime = Math.floor(diffTime / (1000 * 60));
      var target = diffTime / 30;

      for (let index = 0; index < target; index++) {
        ds.setMinutes(ds.getMinutes() + (30));
        var result = String(ds.getHours()) + String(ds.getMinutes());
        if (status == 3) {
          $("." + s_date + "cal" + result).addClass('bg-reserve');
          if (!$("." + s_date + "cal" + result).prev().hasClass('bg-reserve')) {
            // 始めに灰色
            $("." + s_date + "cal" + result).addClass('gray');
          }
        } else if (status < 3) {
          $("." + s_date + "cal" + result).addClass('bg-prereserve');
        }
      }
      // 最後に灰色
      $('.bg-reserve:last').addClass('gray');
    }
  })
</script>