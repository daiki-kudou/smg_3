@extends('layouts.admin.app')
@section('content')
<script src="{{ asset('/js/template.js') }}"></script>
<script src="{{ asset('/js/admin/validation.js') }}"></script>
<link href="{{ asset('/css/template.css') }}" rel="stylesheet">

<div id="fullOverlay">
  <div class="frame_spinner">
    <div class="spinner-border text-primary " role="status">
      <span class="sr-only hide">Loading...</span>
    </div>
  </div>
</div>
<div class="container-field">
  <div class="float-right">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active">
          ダミーダミーダミー
        </li>
      </ol>
    </nav>
  </div>
  <h2 class="mt-3 mb-3">仲介会社　仮押え 新規登録</h2>
  <hr>
</div>


<section class="mt-5">
  <div class="calendar">
    <iframe frameborder="0" src="{{url('admin/calendar/date_calendar')}}" width="100%" height="500">Your browser isn't
      compatible</iframe>
  </div>

  {{Form::open(['url' => 'admin/pre_agent_reservations/check', 'method' => 'POST', 'id'=>'pre_agent_reservationsCreateForm'])}}
  @csrf

  <div class="user_selector mt-5">
    <h3 class="mb-2">仲介会社情報</h3>
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


  <div class="unknown_user mt-3">
    <table class="table table-bordered" style="table-layout: fixed;">
      <thead>
        <tr>
          <th colspan="4">エンドユーザー情報</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td class="table-active">会社名・団体名</td>
          <td>
            {{ Form::text('pre_enduser_company', '',['class'=>'form-control'] ) }}
          </td>
          <td class="table-active">担当者氏名</td>
          <td>
            {{ Form::text('pre_enduser_name', '',['class'=>'form-control'] ) }}
          </td>
        </tr>
        <tr>
          <td class="table-active">住所</td>
          <td>
            {{ Form::text('pre_enduser_address', '',['class'=>'form-control'] ) }}
          </td>
          <td class="table-active">電話番号</td>
          <td>
            {{ Form::text('pre_enduser_tel', '',['class'=>'form-control', 'placeholder' => '半角数字、ハイフンなしで入力してください'] ) }}
            <p class="is-error-pre_enduser_tel" style="color: red"></p>
          </td>
        </tr>
        <tr>
          <td class="table-active">当日連絡先</td>
          <td>
            {{ Form::text('pre_enduser_mobile', '',['class'=>'form-control', 'placeholder' => '半角数字、ハイフンなしで入力してください'] ) }}
            <p class="is-error-pre_enduser_mobile" style="color: red"></p>
          </td>
          <td class="table-active">メールアドレス</td>
          <td>
            {{ Form::text('pre_enduser_email', '',['class'=>'form-control'] ) }}
            <p class="is-error-pre_enduser_email" style="color: red"></p>
          </td>
        </tr>
        <tr>
          <td class="table-active">利用者属性</td>
          <td>
            {{ Form::select('pre_enduser_attr', ['一般企業','上場企業','近隣利用','個人講師','MLM','その他'],0,['class'=>'form-control'] ) }}
          </td>
        </tr>
      </tbody>
    </table>
  </div>

  <div class="date_selector mt-5">
    <h3 class="mb-2 pt-3">日程選択</h3>
    <table class="table table-bordered" style="table-layout: fixed;">
      <thead>
        <tr>
          <td>日付</td>
          <td>会場名</td>
          <td>入室時間</td>
          <td>退室時間</td>
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
      {{Form::submit('日程をおさえる', ['class'=>'btn more_btn_lg d-block btn-lg mx-auto my-5', 'id'=>'check_submit'])}}
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

</section>
{{Form::close()}}

<script defer="defer">
  // 初期カレンダーのside var 非表示
  $(function() {
    $("iframe").on("load", function() {
      $("iframe").contents().find('.main-sidebar').css("display", "none");
      $("iframe").contents().find('.content-wrapper').css("margin-left", "0px");
      $("iframe").contents().find('.main-header').css("margin-top", "-48px");
    });
  })


  // select2, datepicker 初期表示用
  $(function() {
    $('#pre_venue').select2({
      width: '100%'
    });
    $('#pre_datepicker').datepicker({
      dateFormat: 'yy-mm-dd',
      autoclose: true
    });
  })
  // 入退室初期時間選択desabled設定
  //プラスマイナスボタン
  $(function() {
    $(document).on("click", ".add", function() {
      // すべてのselect2初期化
      for (let destroy = 0; destroy < $('.date_selector tbody tr').length; destroy++) {
        console.log($('.date_selector tbody tr').eq(destroy).find('td').eq(1).find('select').select2("destroy"));
      }

      $(this).parent().parent().clone(true).insertAfter($(this).parent().parent());
      var count = $(this).parent().parent().parent().find('tr').length;
      var target = $(this).parent().parent().parent().find('tr');

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
        $('#pre_datepicker' + index).removeClass('hasDatepicker').datepicker({
          dateFormat: 'yy-mm-dd',
          minDate: 0,
        });
        // select2付与
        $(target).eq(index).find('td').eq(1).find('select').select2({
          width: '100%'
        });

        if (index == count - 1) {
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
        $('#pre_datepicker' + index).removeClass('hasDatepicker').datepicker({
          dateFormat: 'yy-mm-dd',
          minDate: 0,
        });
      }
    })
  })
  // 入室時間選択トリガー
  // $(function () {
  //   $(document).on("click", "select", function () {
  //     var this_tr = $(this).parent().parent();
  //     var target = $(this).parent().index();
  //     if (target == 2) {
  //       var date = this_tr.find('td').eq(0).find('input').val();
  //       var venue = this_tr.find('td').eq(1).find('select').val();
  //       if (date.length && venue.length) {
  //         $(this).find('option').prop('disabled', false);
  //         var options = $(this).find('option');
  //         $.ajax({
  //           headers: {
  //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  //           },
  //           url: '/admin/reservations/getsaleshours',
  //           type: 'POST',
  //           data: { 'venue_id': venue, 'dates': date },
  //           dataType: 'json',
  //           beforeSend: function () {
  //             $('#fullOverlay').css('display', 'block');
  //           },
  //         }).done(function ($times) {
  //           $('#fullOverlay').css('display', 'none');
  //           for (let index = 0; index < $times[0].length; index++) {
  //             options.each(function ($result) {
  //               if ($times[0][index] == options.eq($result).val()) {
  //                 options.eq($result).prop('disabled', true);
  //               }
  //             });
  //           };
  //         }).fail(function ($times) {
  //           $('#fullOverlay').css('display', 'none');
  //         });
  //       } else {
  //         $(this).find('option').prop('disabled', true);
  //       }
  //     }else if(target == 3){
  //       var date = this_tr.find('td').eq(0).find('input').val();
  //       var venue = this_tr.find('td').eq(1).find('select').val();
  //       if (date.length && venue.length) {
  //         $(this).find('option').prop('disabled', false);
  //         var options = $(this).find('option');
  //         $.ajax({
  //           headers: {
  //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  //           },
  //           url: '/admin/reservations/getsaleshours',
  //           type: 'POST',
  //           data: { 'venue_id': venue, 'dates': date },
  //           dataType: 'json',
  //           beforeSend: function () {
  //             $('#fullOverlay').css('display', 'block');
  //           },
  //         }).done(function ($times) {
  //           $('#fullOverlay').css('display', 'none');
  //           for (let index = 0; index < $times[0].length; index++) {
  //             options.each(function ($result) {
  //               if ($times[0][index] == options.eq($result).val()) {
  //                 options.eq($result).prop('disabled', true);
  //               }
  //             });
  //           };
  //         }).fail(function ($times) {
  //           $('#fullOverlay').css('display', 'none');
  //         });
  //       } else {
  //         $(this).find('option').prop('disabled', true);
  //       }
  //     }
  //   })
  // })
</script>
@endsection