@extends('layouts.admin.app')

@section('content')


<link href="{{ asset('/css/template.css') }}" rel="stylesheet">
<script src="{{ asset('/js/template.js') }}"></script>

<div id="fullOverlay">
  <div class="frame_spinner">
    <div class="spinner-border text-primary " role="status">
      <span class="sr-only hide">Loading...</span>
    </div>
  </div>
</div>



<h1>仲介会社　仮押さえ 新規作成</h1>

<div class="calendar">
  <iframe src="{{url('admin/calendar/date_calendar')}}" width="100%" height="500">Your browser isn't compatible</iframe>
</div>

{{Form::open(['url' => 'admin/pre_agent_reservations/check', 'method' => 'POST', 'id'=>''])}}
@csrf

<div class="user_selector mt-5">
  <h1>仲介会社情報</h1>
  <select name="agent_id" id="agent_id">
    <option value="">選択してください</option>
    @foreach ($agents as $agent)
    <option value="{{$agent->id}}">
      {{$agent->id}} | {{$agent->name}} | {{$agent->getName()}}
      |
      {{$agent->email}} | {{$agent->person_tel}} | {{$agent->person_mobile}}
    </option>
    @endforeach
  </select>
</div>


<div class="unknown_user mt-5">
  <table class="table table-bordered" style="table-layout: fixed;">
    <thead>
      <tr>
        <th colspan="4">仲介会社の顧客情報</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td class="table-active">会社名・団体名</td>
        <td>
          {{ Form::text('pre_enduser_company', '',['class'=>'form-control'] ) }}
        </td>
        <td colspan="2"></td>
      </tr>
      <tr>
        <td class="table-active">担当者指名</td>
        <td>
          {{ Form::text('pre_enduser_name', '',['class'=>'form-control'] ) }}
        </td>
        <td class="table-active">メールアドレス</td>
        <td>
          {{ Form::text('pre_enduser_email', '',['class'=>'form-control'] ) }}
        </td>
      </tr>
      <tr>
        <td class="table-active">携帯番号</td>
        <td>
          {{ Form::text('pre_enduser_mobile', '',['class'=>'form-control'] ) }}
        </td>
        <td class="table-active">固定電話</td>
        <td>
          {{ Form::text('pre_enduser_tel', '',['class'=>'form-control'] ) }}
        </td>
      </tr>
    </tbody>
  </table>
</div>

<div class="date_selector">
  <h1>日程選択</h1>
  <table class="table table-bordered" style="table-layout: fixed;">
    <thead>
      <tr>
        <td>日付</td>
        <td>会場名</td>
        <td>入室時間</td>
        <td>体質時間</td>
        <td>追加・削除</td>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>{{ Form::text('pre_date0', '',['class'=>'form-control', 'id'=>"pre_datepicker"] ) }}</td>
        <td>
          <select name="pre_venue0" id="pre_venue">
            @foreach ($venues as $venue)
            <option value="{{$venue->id}}">{{ReservationHelper::getVenue($venue->id)}}</option>
            @endforeach
          </select>
        </td>
        <td>
          <select name="pre_enter0" id="pre_enter0" class="form-control">
            <option value=""></option>
            {!!ReservationHelper::timeOptions()!!}
          </select>
        </td>
        <td>
          <select name="pre_leave0" id="pre_leave0" class="form-control">
            <option value=""></option>
            {!!ReservationHelper::timeOptions()!!}
          </select>
        </td>
        <td>
          <input type="button" value="＋" class="add pluralBtn">
          <input type="button" value="ー" class="del pluralBtn">
        </td>
      </tr>
    </tbody>
  </table>
</div>

<div class="submit_btn">
  <div class="d-flex justify-content-center">
    {{Form::submit('確認する', ['class'=>'btn btn-primary btn-lg ', 'id'=>'check_submit'])}}
  </div>
</div>

<div class="spin_btn hide">
  <div class="d-flex justify-content-center">
    <button class="btn btn-primary btn-lg" type="button" disabled>
      <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
      Loading...
    </button>
  </div>
</div>


{{Form::close()}}




<script defer="defer">
  // 初期カレンダーのside var 非表示
    $(function(){
        $("iframe").on("load",function(){
        $("iframe").contents().find('.main-sidebar').css("display","none");
        $("iframe").contents().find('.content-wrapper').css("margin-left","0px");
        $("iframe").contents().find('.main-header').css("margin-top","-48px");
        });
    })


    // select2, datepicker 初期表示用
    $(function(){
      $('#pre_venue').select2({ width: '100%' });
      $('#pre_datepicker').datepicker({
        dateFormat: 'yy-mm-dd',
        autoclose: true
      });
    })
    // 入退室初期時間選択desabled設定
  //プラスマイナスボタン
    $(function(){
      $(document).on("click", ".add", function() {
        // すべてのselect2初期化
        for (let destroy = 0; destroy < $('.date_selector tbody tr').length; destroy++) {
          console.log($('.date_selector tbody tr').eq(destroy).find('td').eq(1).find('select').select2("destroy"));
        }

        $(this).parent().parent().clone(true).insertAfter($(this).parent().parent());
        var count = $(this).parent().parent().parent().find('tr').length;
        var target =$(this).parent().parent().parent().find('tr');

        for (let index = 0; index < count; index++) {
          // name属性
          $(target).eq(index).find('td').eq(0).find('input, select').attr('name', "pre_date" + index);
          $(target).eq(index).find('td').eq(1).find('input, select').attr('name', "pre_venue" + index);
          $(target).eq(index).find('td').eq(2).find('input, select').attr('name', "pre_enter" + index);
          $(target).eq(index).find('td').eq(3).find('input, select').attr('name', "pre_leave" + index);
          // id属性
          $(target).eq(index).find('td').eq(0).find('input, select').attr('id', "pre_datepicker" + index);
          $(target).eq(index).find('td').eq(1).find('input, select').attr('id', "pre_venue" + index);
          $(target).eq(index).find('td').eq(2).find('input, select').attr('id', "pre_enter" + index);
          $(target).eq(index).find('td').eq(3).find('input, select').attr('id', "pre_leave" + index);
          // dapicker付与
          $('#pre_datepicker'+index).removeClass('hasDatepicker').datepicker({
            dateFormat: 'yy-mm-dd',
            minDate: 0,
          });
          // select2付与
          $(target).eq(index).find('td').eq(1).find('select').select2({width: '100%'});
          
          if (index==count-1) {
            $(target).eq(index).find('td').eq(2).find('input, select').val('');
            $(target).eq(index).find('td').eq(3).find('input, select').val('');
          }
        }
      })
      // マイナスボタン
      $(document).on("click", ".del", function() {
      var master = $(this).parent().parent().parent().find('tr').length;
      var target = $(this).parent().parent();
      var re_target = target.parent();
      if (master > 1) {
        target.remove();
      }

      var count2 = $('.date_selector tbody tr').length;
      console.log(count2);
      for (let index = 0; index < count2; index++) {
          $('.date_selector tbody tr').eq(index).find('td').eq(0).find('input, select').attr('name', "pre_date" + index);
          $('.date_selector tbody tr').eq(index).find('td').eq(1).find('input, select').attr('name', "pre_venue" + index);
          $('.date_selector tbody tr').eq(index).find('td').eq(2).find('input, select').attr('name', "pre_enter" + index);
          $('.date_selector tbody tr').eq(index).find('td').eq(3).find('input, select').attr('name', "pre_leave" + index);
          // id属性
          $('.date_selector tbody tr').eq(index).find('td').eq(0).find('input, select').attr('id', "pre_datepicker" + index);
          $('.date_selector tbody tr').eq(index).find('td').eq(1).find('input, select').attr('id', "pre_venue" + index);
          $('.date_selector tbody tr').eq(index).find('td').eq(2).find('input, select').attr('id', "pre_enter" + index);
          $('.date_selector tbody tr').eq(index).find('td').eq(3).find('input, select').attr('id', "pre_leave" + index);
          $('#pre_datepicker'+index).removeClass('hasDatepicker').datepicker({
            dateFormat: 'yy-mm-dd',
            minDate: 0,
          });
        }
    })
    })
    // 入室時間選択トリガー
  $(function () {
    $(document).on("click", "select", function () {
      var this_tr = $(this).parent().parent();
      var target = $(this).parent().index();
      if (target == 2) {
        var date = this_tr.find('td').eq(0).find('input').val();
        var venue = this_tr.find('td').eq(1).find('select').val();
        if (date.length && venue.length) {
          $(this).find('option').prop('disabled', false);
          var options = $(this).find('option');
          $.ajax({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '/admin/reservations/getsaleshours',
            type: 'POST',
            data: { 'venue_id': venue, 'dates': date },
            dataType: 'json',
            beforeSend: function () {
              $('#fullOverlay').css('display', 'block');
            },
          }).done(function ($times) {
            $('#fullOverlay').css('display', 'none');
            for (let index = 0; index < $times[0].length; index++) {
              options.each(function ($result) {
                if ($times[0][index] == options.eq($result).val()) {
                  options.eq($result).prop('disabled', true);
                }
              });
            };
          }).fail(function ($times) {
            $('#fullOverlay').css('display', 'none');
          });
        } else {
          $(this).find('option').prop('disabled', true);
        }
      }else if(target == 3){
        var date = this_tr.find('td').eq(0).find('input').val();
        var venue = this_tr.find('td').eq(1).find('select').val();
        if (date.length && venue.length) {
          $(this).find('option').prop('disabled', false);
          var options = $(this).find('option');
          $.ajax({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '/admin/reservations/getsaleshours',
            type: 'POST',
            data: { 'venue_id': venue, 'dates': date },
            dataType: 'json',
            beforeSend: function () {
              $('#fullOverlay').css('display', 'block');
            },
          }).done(function ($times) {
            $('#fullOverlay').css('display', 'none');
            for (let index = 0; index < $times[0].length; index++) {
              options.each(function ($result) {
                if ($times[0][index] == options.eq($result).val()) {
                  options.eq($result).prop('disabled', true);
                }
              });
            };
          }).fail(function ($times) {
            $('#fullOverlay').css('display', 'none');
          });
        } else {
          $(this).find('option').prop('disabled', true);
        }
      }
    })
  })


</script>
@endsection