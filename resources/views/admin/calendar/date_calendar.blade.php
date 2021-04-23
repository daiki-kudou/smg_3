@extends('layouts.admin.app')

@section('content')

<link href="{{ asset('/css/template.css') }}" rel="stylesheet">
<script src="{{ asset('/js/template.js') }}"></script>


<h2 class="mt-3 mb-3">予約状況カレンダー 利用日別</h2>
<hr>

<section class="mt-5 bg-white">
  <div class="date_calender_wrapper" id="date_calender_wrapper">
    <div class="calender-ttl">
      <!-- <h3>予約状況</h3> -->
      <div class="d-flex align-items-center">
        <div class="row w-100">
          <div class="col text-right">
            <a href="javascript:$('#yesterday').submit()" class="text-white"><i
                class="fas fa-chevron-left fa-2x"></i></a>
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
  </div>
</section>

<iframe class="mt-5" src="/admin/note" frameborder="0" width="100%" height="500px;" scrolling="no"></iframe>
{{-- {{ Form::open(['url' => 'admin/note', 'method' => 'post','id'=>'add_note_form']) }}
@csrf
<section class="mt-5">
  <div class="">
    <p class="more_btn3"><input type="button" value="メモを追加する" class="add_button btn"></p>
    <p><input type="button" value="メモを編集する" class="edit_button"></p>
  </div>
  <table class="table table-bordered calender-note">
    <tbody>
      <tr>
        <td>時間</td>
        <td>会場</td>
        <td>会社名</td>
        <td>対応内容</td>
        <td>編集</td>
      </tr>
    </tbody>
    <tbody id="sortableArea" class="main_table" style="table-layout: fixed;">
      @foreach ($note as $item)
      <tr>
        <td>{{$item->hour}}</td>
        <td>{{$item->venue}}</td>
        <td>{{$item->company}}</td>
        <td>{!!nl2br(e($item->content))!!}</td>
        <td>
          <a class="delete" href="{{url('admin/note/delete/'.$item->id)}}">削除</a>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</section>

{{ Form::close() }}
--}}


@foreach ($reservations as $reservation)
<input type="hidden" name="reservation_id" value="{{$reservation->id}}">
<input type="hidden" name="venue_id" value="{{$reservation->venue_id}}">
<input type="hidden" name="venue_name" value="{{ReservationHelper::getVenue($reservation->venue_id)}}">
<input type="hidden" name="user_id" value="{{$reservation->user_id}}">
<input type="hidden" name="start" value="{{date('H:i',strtotime($reservation->enter_time))}}">
<input type="hidden" name="finish" value="{{date('H:i',strtotime($reservation->leave_time)) }}">
<input type="hidden" name="status" value="{{$reservation->bills()->first()->reservation_status }}">
@endforeach



<script type="text/javascript" src="https://code.jquery.com/ui/1.12.0/jquery-ui.min.js"></script>
<script>
  $(function(){
  $('.delete').on('click', function() {
      if (!confirm('本当に削除しますか？')) {
        return false;
      }
    })
})

  $(document).on("click", ".add_button", function() {
    var data="<tr>"+
        "<td><input name='hour' type='text' class='form-control'></td>"+
        "<td><input name='venue' type='text' class='form-control'></td>"+
        "<td><input name='company' type='text' class='form-control'></td>"+
        
        "<td><textarea name='content' class='form-control'></textarea></td>"+
        "<td>"+
          "<input type='submit' value='保存'>"+
        "</td>"+
      "</tr>";
    $('.main_table').append(data);
    $(this).remove();
  })

  $(function() {
    $('#datepicker8').on('change', function() {
      $('input[name="date"]').val($(this).val());
      $('#s_calendar').submit();
    })
  })


  $(function() {
    for (let index = 0; index < $('input[name="start"]').length; index++) {
      var reservation_id = $('input[name="reservation_id"]').eq(index).val();
      var venue_id = $('input[name="venue_id"]').eq(index).val();
      var venue_name = $('input[name="venue_name"]').eq(index).val();
      var user_id = $('input[name="user_id"]').eq(index).val();
      var start = $('input[name="start"]').eq(index).val();
      var finish = $('input[name="finish"]').eq(index).val();
      var status = $('input[name="status"]').eq(index).val();

      var json_result = JSON.parse('<?php echo $json_result; ?>');
      var target_length = (json_result[index]).length;
      for (let index2 = 0; index2 < target_length; index2++) {
        //最後のみ描写しないためbreak
        if (index2 == target_length - 1) {
          break;
        }
        // 以下ステータス別色分け
        if (status == 1) {
          $("." + venue_name + "cal" + json_result[index][index2]).addClass('bg-prereserve');
        } else if (status == 3) {
          $("." + venue_name + "cal" + json_result[index][index2]).addClass('bg-reserve');
        }
      }
      $('.bg-reserve:last').css('background', 'gray');
    }

  })

  //   ドラッグアンドドロップ------------------------------------------
  $(function() {
  $("#sortableArea").sortable();
});
</script>


@endsection