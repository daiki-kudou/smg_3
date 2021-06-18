@extends('layouts.admin.app')
@section('content')
<script src="{{ asset('/js/template.js') }}"></script>
<script src="{{ asset('/js/admin/pre_reservation/validation.js') }}"></script>
<link href="{{ asset('/css/template.css') }}" rel="stylesheet">
<script src="{{ asset('/js/admin/pre_reservation/control_time.js') }}"></script>



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
          {{ Breadcrumbs::render(Route::currentRouteName()) }}
        </li>
      </ol>
    </nav>
  </div>
  <h2 class="mt-3 mb-3">仮押え 新規登録</h2>
  <hr>
</div>

<section class="mt-5">
  <div class="calendar">
    <iframe frameborder="0" src="{{url('admin/calendar/date_calendar')}}" width="100%" height="500"></iframe>
  </div>


  {{Form::open(['url' => 'admin/pre_reservations/check', 'method' => 'POST', 'id'=>'pre_reservationCreateForm'])}}
  @csrf

  <div class="user_selector mt-5">
    <h3 class="mb-2 form_required">顧客検索</h3>
    <select name="user_id" id="user_id">
      <option value="">選択してください</option>
      @foreach ($users as $user)
      <option value="{{$user->id}}">
        {{ReservationHelper::fixId($user->id)}} | {{ReservationHelper::getCompany($user->id)}} |
        {{ReservationHelper::getPersonName($user->id)}} |
        {{$user->email}} | {{$user->tel}} | {{$user->mobile}}
      </option>
      @endforeach
    </select>
    <p class="is-error-user_id" style="color: red"></p>
  </div>

  <div class="selected_user mt-4">
    <table class="table table-bordered client_info" style="table-layout: fixed;">
      <thead>
        <tr>
          <th>顧客情報</th>
          <th colspan="3">顧客ID：<p class="user_id d-inline"></p>
          </th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td class="table-active">会社名・団体名</td>
          <td>
            <p class="company"></p>
          </td>
          <td class="table-active">担当者氏名</td>
          <td>
            <p class="person"></p>
          </td>
        </tr>
        <tr>
          <td class="table-active">メールアドレス</td>
          <td>
            <p class="email"></p>
          </td>
          <td class="table-active">携帯番号</td>
          <td>
            <p class="mobile"></p>
          </td>
        </tr>
        <tr>
          <td class="table-active">固定電話</td>
          <td>
            <p class="tel"></p>
          </td>
          <td class="table-active">割引条件</td>
          <td>
            <p class="condition">

            </p>
          </td>
        </tr>
        <tr>
          <td class="table-active caution">注意事項</td>
          <td colspan="3" class="caution">
            <p class="attention"></p>
          </td>
        </tr>
      </tbody>
    </table>
  </div>

  <div class="unknown_user mt-4">
    <table class="table table-bordered" style="table-layout: fixed;">
      <thead>
        <tr>
          <th colspan="4">仮で入力する顧客情報</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td class="table-active">会社・団体名(仮)</td>
          <td>
            {{ Form::text('unknown_user_company', '',['class'=>'form-control'] ) }}
          </td>
          <td class="table-active">担当者名(仮)</td>
          <td>
            {{ Form::text('unknown_user_name', '',['class'=>'form-control'] ) }}
          </td>
        </tr>
        <tr>
          <td class="table-active">固定電話</td>
          <td>
            {{ Form::text('unknown_user_tel', '',['class'=>'form-control', 'placeholder' => '半角数字、ハイフンなしで入力してください'] ) }}
            <p class="is-error-unknown_user_tel" style="color: red"></p>
          </td>
          <td class="table-active">携帯番号</td>
          <td>
            {{ Form::text('unknown_user_mobile', '',['class'=>'form-control', 'placeholder' => '半角数字、ハイフンなしで入力してください'] ) }}
            <p class="is-error-unknown_user_mobile" style="color: red"></p>
          </td>
        </tr>
        <tr>
          <td class="table-active">メールアドレス</td>
          <td>
            {{ Form::text('unknown_user_email', '',['class'=>'form-control'] ) }}
            <p class="is-error-unknown_user_email" style="color: red"></p>
          </td>
        </tr>
      </tbody>
    </table>
  </div>

  <div class="date_selector pt-4">
    <hr>
    <h3 class="mb-2 pt-3">日程選択</h3>
    <table class="table table-bordered PreResCre" style="table-layout: fixed;">
      <thead>
        <tr>
          <td class="form_required">日付</td>
          <td class="form_required">会場名</td>
          <td class="form_required">入室時間</td>
          <td class="form_required">退室時間</td>
          <td>追加・削除</td>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>{{ Form::text('pre_date0', '',['class'=>'form-control', 'id'=>"pre_datepicker", ""] ) }}
            <p class="is-error-pre_date0" style="color: red"></p>
          </td>
          <td>
            <select name="pre_venue0" id="pre_venue">
              @foreach ($venues as $venue)
              <option value="{{$venue->id}}">{{ReservationHelper::getVenue($venue->id)}}</option>
              @endforeach
            </select>
          </td>
          <td>
            <select name="pre_enter0" id="pre_enter0" class="enter_control_pre_reservation0 form-control">
              <option value=""></option>
              {!!ReservationHelper::timeOptions()!!}
            </select>
            <p class="is-error-pre_enter0" style="color: red"></p>
          </td>
          <td>
            <select name="pre_leave0" id="pre_leave0" class="leave_control_pre_reservation0 form-control">
              <option value=""></option>
              {!!ReservationHelper::timeOptions()!!}
            </select>
            <p class="is-error-pre_leave0" style="color: red"></p>
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
    {{Form::submit('日程をおさえる', ['class'=>'btn more_btn_lg mx-auto d-block', 'id'=>'check_submit'])}}
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

            $('.condition').text("");
            $('.attention').text("");

            if ($user['condition']!==null) {
            $('.condition').html($user['condition'].replace(/\n/g, '<br>'));
            }
            if ($user['attention']!==null) {
            $('.attention').html($user['attention'].replace(/\n/g, '<br>'));
            }
          } else {
            $('.client_info p').text('');
          }
        })
        .fail(function($user) {
          $('#fullOverlay').css('display', 'none');
          console.log("失敗");
          $('.client_info p').text('');
          // swal('顧客情報取得に失敗しました。リロードして再度取得してください');
        });
    })
  })
  // select2, datepicker 初期表示用
  $(function() {
    $('#pre_venue').select2({
      width: '100%'
    });
    $('#pre_datepicker').datepicker({
      dateFormat: 'yy-mm-dd',
      autoclose: true,
      minDate: 0
    });
  })
  // 入退室初期時間選択desabled設定
  //プラスマイナスボタン
  $(function() {
    $(document).on("click", ".add", function() {
      var valid=$("#pre_reservationCreateForm").validate();
      valid.destroy();
      // すべてのselect2初期化
      for (let destroy = 0; destroy < $('.date_selector tbody tr').length; destroy++) {
        $('.date_selector tbody tr').eq(destroy).find('td').eq(1).find('select').select2("destroy");
      }
      var base_venue = $(this).parent().parent().find('td').eq(1).find('select').val();
      var base_date = $(this).parent().parent().find('td').eq(0).find('input').val().split('-');
      var dt = new Date(base_date);
      dt.setDate(dt.getDate() + 1);
      var next_day=dt.getFullYear()+'-'+(dt.getMonth() + 1)+'-'+dt.getDate();

      $(this).parent().parent().clone(true).insertAfter($(this).parent().parent());
      $(this).parent().parent().next().find("td").eq(1).find("select option[value=" + base_venue + "]").prop('selected', true);
      if (base_date=="") {
        $(this).parent().parent().next().find("td").eq(0).find('input').val('');
      }else{
        $(this).parent().parent().next().find("td").eq(0).find('input').val(next_day);
      }

      var count = $(this).parent().parent().parent().find('tr').length;
      var target = $(this).parent().parent().parent().find('tr');
      for (let index = 0; index < count; index++) {
        // name属性
        $(target).eq(index).find('td').eq(0).find('input').attr('name', "pre_date" + index);
        $(target).eq(index).find('td').eq(1).find('select').attr('name', "pre_venue" + index);
        $(target).eq(index).find('td').eq(2).find('select').attr('name', "pre_enter" + index);
        $(target).eq(index).find('td').eq(3).find('select').attr('name', "pre_leave" + index);
        // id属性
        $(target).eq(index).find('td').eq(0).find('input').attr('id', "pre_datepicker" + index);
        $(target).eq(index).find('td').eq(1).find('select').attr('id', "pre_venue" + index);
        $(target).eq(index).find('td').eq(2).find('select').attr('id', "pre_enter" + index);
        $(target).eq(index).find('td').eq(3).find('select').attr('id', "pre_leave" + index);
        // class属性
        $(target).eq(index).find('td').eq(2).find('select').attr('class', "enter_control_pre_reservation" + index+" form-control");
        $(target).eq(index).find('td').eq(3).find('select').attr('class', "leave_control_pre_reservation" + index+" form-control ");

        // dapicker付与
        $('#pre_datepicker' + index).removeClass('hasDatepicker').datepicker({
          dateFormat: 'yy-mm-dd',
          minDate: 0,
        });
        // select2付与
        $(target).eq(index).find('td').eq(1).find('select').select2({
          width: '100%'
        });
        // 時間の入力を初期化
        // 意図しない一番最後がクリアされるため一旦、コメントアウト
        //if (index == count - 1) {
        //  $(target).eq(index).find('td').eq(2).find('input, select').val('');
        //  $(target).eq(index).find('td').eq(3).find('input, select').val('');
        //}
        $(target).eq(index).find('td').eq(0).find('p').remove();
        $(target).eq(index).find('td').eq(2).find('p').remove();
        $(target).eq(index).find('td').eq(3).find('p').remove();
        $(target).eq(index).find('td').eq(0).find('span').remove();
        $(target).eq(index).find('td').eq(2).find('span').remove();
        $(target).eq(index).find('td').eq(3).find('span').remove();
        $("input").removeClass('is-error');
        $("input").attr('aria-describedby',"");
        $("select").removeClass('is-error');
        $("select").attr('aria-describedby',"");
        $(target).eq(index).find('td').eq(0).append("<p class='is-error-pre_date"+index+"' style='color: red'></p>");
        $(target).eq(index).find('td').eq(2).append("<p class='is-error-pre_enter"+index+"' style='color: red'></p>");
        $(target).eq(index).find('td').eq(3).append("<p class='is-error-pre_leave"+index+"' style='color: red'></p>");
      }
        $("#pre_reservationCreateForm").validate({
          rules: {
            user_id: { required: true },
            unknown_user_email: { email: true },
            unknown_user_mobile: { number: true, minlength: 11 },
            unknown_user_tel: { number: true, minlength: 10 },
          },
          messages: {
            user_id: { required: "※必須項目です" },
            unknown_user_email: { email: '※Emailの形式で入力してください', },
            unknown_user_mobile: { number: '※半角英数字を入力してください', minlength: '※最低桁数は11です', },
            unknown_user_tel: { number: '※半角英数字を入力してください', minlength: '※最低桁数は10です', },
          },
          errorPlacement: function (error, element) {
            var name = element.attr('name');
            if (element.attr('name') === 'category[]') {
              error.appendTo($('.is-error-category'));
            } else if (element.attr('name') === name) {
              error.appendTo($('.is-error-' + name));
            }
          },
          errorElement: "span",
          errorClass: "is-error",
          //送信前にLoadingを表示
          submitHandler: function (form) {
            $('.spin_btn').removeClass('hide');
            $('.submit_btn').addClass('hide');
            form.submit();
          }
        });
        $('input').on('blur', function () {
          $(this).valid();
        });
        for (let index_a = 0; index_a < count; index_a++) {
          $("input[name='pre_date"+index_a+"']").rules("add", {
          required: true,
          messages: { required: "※必須項目です" },
          });
          $("select[name='pre_enter"+index_a+"']").rules("add", {
          required: true,
          messages: { required: "※必須項目です" },
          });
          $("select[name='pre_leave"+index_a+"']").rules("add", {
          required: true,
          messages: { required: "※必須項目です" },
          });
        }
    })
    // マイナスボタン
    $(document).on("click", ".del", function() {
      var valid=$("#pre_reservationCreateForm").validate();
      valid.destroy();
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
        $('.date_selector tbody tr').eq(index).find('td').eq(0).find('p').remove();
        $('.date_selector tbody tr').eq(index).find('td').eq(2).find('p').remove();
        $('.date_selector tbody tr').eq(index).find('td').eq(3).find('p').remove();
        $("input").removeClass('is-error');
        $("input").attr('aria-describedby',"");
        $("select").removeClass('is-error');
        $("select").attr('aria-describedby',"");
        $('.date_selector tbody tr').eq(index).find('td').eq(0).find('span').remove();
        $('.date_selector tbody tr').eq(index).find('td').eq(2).find('span').remove();
        $('.date_selector tbody tr').eq(index).find('td').eq(3).find('span').remove();
        $('.date_selector tbody tr').eq(index).find('td').eq(0).append("<p class='is-error-pre_date"+index+"' style='color: red'></p>");
        $('.date_selector tbody tr').eq(index).find('td').eq(2).append("<p class='is-error-pre_enter"+index+"' style='color: red'></p>");
        $('.date_selector tbody tr').eq(index).find('td').eq(3).append("<p class='is-error-pre_leave"+index+"' style='color: red'></p>");
      }
      $("#pre_reservationCreateForm").validate({
          rules: {
            user_id: { required: true },
            unknown_user_email: { email: true },
            unknown_user_mobile: { number: true, minlength: 11 },
            unknown_user_tel: { number: true, minlength: 10 },
          },
          messages: {
            user_id: { required: "※必須項目です" },
            unknown_user_email: { email: '※Emailの形式で入力してください', },
            unknown_user_mobile: { number: '※半角英数字を入力してください', minlength: '※最低桁数は11です', },
            unknown_user_tel: { number: '※半角英数字を入力してください', minlength: '※最低桁数は10です', },
          },
          errorPlacement: function (error, element) {
            var name = element.attr('name');
            if (element.attr('name') === 'category[]') {
              error.appendTo($('.is-error-category'));
            } else if (element.attr('name') === name) {
              error.appendTo($('.is-error-' + name));
            }
          },
          errorElement: "span",
          errorClass: "is-error",
          //送信前にLoadingを表示
          submitHandler: function (form) {
            $('.spin_btn').removeClass('hide');
            $('.submit_btn').addClass('hide');
            form.submit();
          }
        });
        $('input').on('blur', function () {
          $(this).valid();
        });
        for (let index_b = 0; index_b < count2; index_b++) {
          $("input[name='pre_date"+index_b+"']").rules("add", {
          required: true,
          messages: { required: "※必須項目です" },
          });
          $("select[name='pre_enter"+index_b+"']").rules("add", {
          required: true,
          messages: { required: "※必須項目です" },
          });
          $("select[name='pre_leave"+index_b+"']").rules("add", {
          required: true,
          messages: { required: "※必須項目です" },
          });
        }
    })
  })
</script>
@endsection