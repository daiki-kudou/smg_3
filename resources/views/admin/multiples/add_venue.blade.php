@extends('layouts.admin.app')

@section('content')
<link href="{{ asset('/css/template.css') }}" rel="stylesheet">
<script src="{{ asset('/js/template.js') }}"></script>
<script src="{{ asset('/js/multiples/calculate.js') }}"></script>

<div class="container-field mt-3">
  <div class="float-right">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active">
          {{ Breadcrumbs::render(Route::currentRouteName(),$multiple->id) }}
        </li>
      </ol>
    </nav>
  </div>
  <h2 class="mt-3 mb-3">一括仮押さえ　日程の追加</h2>
  <hr>
</div>

<section class="mt-5">
  <table class="table ttl_head mb-0">
    <tbody>
      <tr>
        <td class="text-white d-flex align-items-center p-3">
          <h3>
            仮押え一括ID:<span class="mr-3">{{ReservationHelper::fixId($multiple->id)}}</span>
          </h3>
        </td>
      </tr>
    </tbody>
  </table>
  <div class="border-inwrap bg-white">
    <table class="table table-bordered customer-table mb-3" style="table-layout: fixed;">
      <tbody>
        <tr>
          <td colspan="4">
            <div class="d-flex align-items-center justify-content-between">
              <p class="title-icon">
                <i class="far fa-address-card icon-size" aria-hidden="true"></i>
                顧客情報
              </p>
            </div>
          </td>
        </tr>
        <tr>
          <th class="table-active" width="25%"><label for="company">会社名・団体名</label></th>
          <td>
            {{ReservationHelper::getCompany($multiple->pre_reservations()->first()->user_id)}}
          </td>
          <td class="table-active"><label for="name">担当者氏名</label></td>
          <td>
            {{ReservationHelper::getPersonName($multiple->pre_reservations()->first()->user_id)}}
          </td>
        </tr>
        <tr>
          <td class="table-active" scope="row"><label for="email">担当者メールアドレス</label></td>
          <td>
            {{ReservationHelper::getPersonEmail($multiple->pre_reservations()->first()->user_id)}}
          </td>
          <td class="table-active" scope="row"><label for="mobile">携帯番号</label></td>
          <td>
            {{ReservationHelper::getPersonMobile($multiple->pre_reservations()->first()->user_id)}}
          </td>
        </tr>
        <tr>
          <td class="table-active" scope="row"><label for="tel">固定電話</label>
          </td>
          <td>
            {{ReservationHelper::getPersonTel($multiple->pre_reservations()->first()->user_id)}}
          </td>
        </tr>
      </tbody>
    </table>
    <table class="table table-bordered oneday-customer-table" style="table-layout: fixed;">
      <tbody>
        <tr>
          <td colspan="4">
            <p class="title-icon">
              <i class="fas fa-user icon-size" aria-hidden="true"></i>
              仮で入力する顧客情報
            </p>
          </td>
        </tr>
        <tr>
          <td class="table-active" width="25%"><label for="onedayCompany">会社・団体名(仮)</label></td>
          <td>
            @if (!empty($multiple->pre_reservations()->first()->unknown_user->unknown_user_company))
            {{$multiple->pre_reservations()->first()->unknown_user->unknown_user_company}}
            @endif
          </td>
          <td class="table-active"><label for="onedayName">担当者名(仮)</label></td>
          <td>
            @if (!empty($multiple->pre_reservations()->first()->unknown_user->unknown_user_name))
            {{$multiple->pre_reservations()->first()->unknown_user->unknown_user_name}}
            @endif
          </td>
        </tr>
        <tr>
          <td class="table-active" scope="row"><label for="onedayTel">固定電話</label></td>
          <td>
            @if (!empty($multiple->pre_reservations()->first()->unknown_user->unknown_user_tel))
            {{$multiple->pre_reservations()->first()->unknown_user->unknown_user_tel}}
            @endif
          </td>
          <td class="table-active" scope="row"><label for="onedayMobile">携帯番号</label></td>
          <td>
            @if (!empty($multiple->pre_reservations()->first()->unknown_user->unknown_user_mobile))
            {{$multiple->pre_reservations()->first()->unknown_user->unknown_user_mobile}}
            @endif
          </td>
        </tr>
        <tr>
          <td class="table-active" scope="row"><label for="onedayEmail">メールアドレス</label></td>
          <td>
            @if (!empty($multiple->pre_reservations()->first()->unknown_user->unknown_user_email))
            {{$multiple->pre_reservations()->first()->unknown_user->unknown_user_email}}
            @endif
          </td>
        </tr>
      </tbody>
    </table>
    <table class="table table-bordered mt-5">
      <thead>
        <tr class="table_row">
          <th>一括仮押さえID</th>
          <th>作成日</th>
          <th>利用会場</th>
          <th>総件数</th>
          <th>件数</th>
        </tr>
      </thead>
      <tbody>
        @for ($i = 0; $i < $venue_count; $i++) @if ($i==0) <tr>
          <td rowspan="{{$venue_count}}">{{$multiple->id}}</td>
          <td rowspan="{{$venue_count}}">{{ReservationHelper::formatDate($multiple->created_at)}}</td>
          <td>{{ReservationHelper::getVenue($venues[$i]->venue_id)}}</td>
          <td rowspan="{{$venue_count}}">
            {{$multiple->pre_reservations()->get()->count()}}
          </td>
          <td>
            {{$multiple->pre_reservations()->where('venue_id',$venues[$i]->venue_id)->get()->count()}}
          </td>
          </tr>
          @else
          <tr>
            <td>{{ReservationHelper::getVenue($venues[$i]->venue_id)}}</td>
            <td>
              {{$multiple->pre_reservations()->where('venue_id',$venues[$i]->venue_id)->get()->count()}}
            </td>
          </tr>
          @endif
          @endfor
      </tbody>
    </table>
  </div>

  <div class="calendar mt-5">
    <iframe frameborder="0" src="{{url('admin/calendar/date_calendar')}}" width="100%" height="500">Your browser isn't
      compatible</iframe>
  </div>
  {{Form::open(['url' => 'admin/multiples/'.$multiple->id.'/add_venue_store', 'method' => 'POST', 'id'=>''])}}
  @csrf
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
          <td>
            {{Form::text('pre_date0', "",['class'=>'form-control','id'=>'datepicker1'])}}
          </td>
          <td>
            <select name="pre_venue0" id="pre_venue0" class="form-control">
              @foreach ($_venues as $_venues)
              <option value="{{$_venues->id}}">{{ReservationHelper::getVenue($_venues->id)}}</option>
              @endforeach
            </select>
          </td>
          <td>
            <select name="pre_enter0" id="pre_enter0" class="form-control">
              <option value=""></option>
              @for ($start = 0*2; $start <=23*2; $start++) <option
                value="{{date("H:i:s", strtotime("00:00 +". $start * 30 ." minute"))}}">
                {{date("H時i分", strtotime("00:00 +". $start * 30 ." minute"))}}
                </option>
                @endfor
            </select>
          </td>
          <td>
            <select name="pre_leave0" id="pre_leave0" class="form-control">
              <option value=""></option>
              @for ($start = 0*2; $start <=23*2; $start++) <option
                value="{{date("H:i:s", strtotime("00:00 +". $start * 30 ." minute"))}}">
                {{date("H時i分", strtotime("00:00 +". $start * 30 ." minute"))}}
                </option>
                @endfor
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

  <div class="submit_btn mt-5">
    {{Form::hidden('multiple_id',$multiple->id)}}
    {{Form::hidden('user_id',$multiple->pre_reservations()->first()->user_id)}}
    {{ Form::submit('登録する', ['class' => 'btn more_btn_lg mx-auto d-block']) }}
  </div>
  {{ Form::close() }}

</section>


<script defer="defer">
  // 初期カレンダーのside var 非表示
  $(function() {
    $("iframe").on("load", function() {
      $("iframe").contents().find('.main-sidebar').css("display", "none");
      $("iframe").contents().find('.content-wrapper').css("margin-left", "0px");
      $("iframe").contents().find('.main-header').css("margin-top", "-48px");
    });
  })
  $(function() {
    $('.unknown_user input').attr('readonly', true);
  })
  // 顧客検索
  $(function() {
    $('#user_id').on('input', function() {
      var user_id = $(this).val();
      // ajax
      $.ajax({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          url: '/admin/pre_reservations/getuser',
          type: 'POST',
          data: {
            'user_id': user_id
          },
          dataType: 'json',
          beforeSend: function() {
            $('#fullOverlay').css('display', 'block');
          },
        })
        .done(function($user) {
          $('#fullOverlay').css('display', 'none');
          if ($user['id'] != 999) {
            $('.user_id').text($user['id']);
            $('.company').text($user['company'])
            $('.person').text($user['first_name'] + $user['last_name'])
            $('.email').text($user['email']);
            $('.mobile').text($user['mobile']);
            $('.tel').text($user['tel']);
            $('.unknown_user input').attr('readonly', true);
          } else {
            $('p').text('');
            $('.unknown_user input').attr('readonly', false);
          }
        })
        .fail(function($user) {
          $('#fullOverlay').css('display', 'none');
          console.log("失敗");
          $('p').text('');
          swal('顧客情報取得に失敗しました。リロードして再度取得してください');
        });
    })
  })
  // select2, datepicker 初期表示用
  $(function() {
    $('#pre_venue0').select2({
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
      var base_venue = $(this).parent().parent().find('td').eq(1).find('select').val();
      $(this).parent().parent().clone(true).insertAfter($(this).parent().parent());
      $(this).parent().parent().next().find("td").eq(1).find("select option[value=" + base_venue + "]").prop('selected', true);
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
  // $(function() {
  //   $(document).on("click", "select", function() {
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
  //           data: {
  //             'venue_id': venue,
  //             'dates': date
  //           },
  //           dataType: 'json',
  //           beforeSend: function() {
  //             $('#fullOverlay').css('display', 'block');
  //           },
  //         }).done(function($times) {
  //           $('#fullOverlay').css('display', 'none');
  //           for (let index = 0; index < $times[0].length; index++) {
  //             options.each(function($result) {
  //               if ($times[0][index] == options.eq($result).val()) {
  //                 options.eq($result).prop('disabled', true);
  //               }
  //             });
  //           };
  //         }).fail(function($times) {
  //           $('#fullOverlay').css('display', 'none');
  //         });
  //       } else {
  //         $(this).find('option').prop('disabled', true);
  //       }
  //       var masterTr = $('.date_selector tbody tr').length;
  //       for (let trs = 0; trs < masterTr; trs++) {
  //         var targetDate = $('.date_selector tbody tr').eq(trs).find('td').eq(0).find('input').val();
  //         var targetVenue = $('.date_selector tbody tr').eq(trs).find('td').eq(1).find('select').val();
  //         var targetEnter = $('.date_selector tbody tr').eq(trs).find('td').eq(2).find('select').val();
  //         var targetLeave = $('.date_selector tbody tr').eq(trs).find('td').eq(3).find('select').val();
  //         // console.log(['日付だよ',targetDate], ['会場だよ',targetVenue], ['入室だよ',targetEnter],['退室だよ',targetLeave]);
  //         var cmpTargetDate = $(this).parent().parent().find('td').eq(0).find('input').val();
  //         var cmpTargetVenue = $(this).parent().parent().find('td').eq(1).find('select').val();
  //         // console.log(['target日付',cmpTargetDate], ['cmpTarget会場',cmpTargetVenue]);
  //         if (cmpTargetDate == targetDate && cmpTargetVenue == targetVenue) {
  //           var thisoption = $(this).find('option');
  //           $.ajax({
  //             headers: {
  //               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  //             },
  //             url: '/admin/pre_reservations/reject_same_time',
  //             type: 'POST',
  //             data: {
  //               'targetEnter': targetEnter,
  //               'targetLeave': targetLeave
  //             },
  //             dataType: 'json',
  //             beforeSend: function() {
  //               $('#fullOverlay').css('display', 'block');
  //             },
  //           }).done(function($targettimes) {
  //             $('#fullOverlay').css('display', 'none');
  //             var arrays = [];
  //             thisoption.each(function($index, $value) {
  //               if ($($value).val() == $targettimes[1]) {
  //                 $($value).prop('disabled', true);
  //                 for (let counts = $index; counts < $index + ($targettimes[0] + 1); counts++) {
  //                   arrays.push(counts);
  //                 }
  //               }
  //             });
  //             $.each(arrays, function($i, $v) {
  //               thisoption.eq($v).prop('disabled', true);
  //             });
  //           }).fail(function($targettimes) {
  //             $('#fullOverlay').css('display', 'none');
  //             console.log($targettimes);
  //           });
  //         }
  //       }
  //     } else if (target == 3) {}
  //   })
  // })
</script>

@endsection