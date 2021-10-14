@extends('layouts.admin.app')

@section('content')
<link href="{{ asset('/css/template.css') }}" rel="stylesheet">
<script src="{{ asset('/js/admin/multiples/add_venue_validation.js') }}"></script>
<script src="{{ asset('/js/admin/pre_reservation/control_time.js') }}"></script>

<div id="fullOverlay">
  <div class="frame_spinner">
    <div class="spinner-border text-primary " role="status">
      <span class="sr-only hide">Loading...</span>
    </div>
  </div>
</div>

@if ($errors->any())
<div class="alert alert-danger">
  <ul>
    <li>追加する日付・会場・入退室時間は必須です</li>
  </ul>
</div>
@endif

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
  <!-- <h2 class="mt-3 mb-3">一括仮押さえ　新しい会場の追加</h2> -->
  <h2 class="mt-3 mb-3">仲介会社　一括仮押さえ　日程の追加</h2>
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
                仲介会社
              </p>
            </div>
          </td>
        </tr>
        <tr>
          <th class="table-active" width="25%"><label for="company">会社名・団体名</label></th>
          <td>
            {{ReservationHelper::getAgentCompany($multiple->pre_reservations()->first()->agent_id)}}
          </td>
          <td class="table-active"><label for="name">担当者氏名</label></td>
          <td>
            {{ReservationHelper::getAgentPerson($multiple->pre_reservations()->first()->agent_id)}}
          </td>
        </tr>
        <tr>
          <td class="table-active" scope="row"><label for="email">担当者メールアドレス</label></td>
          <td>
            {{ReservationHelper::getAgentEmail($multiple->pre_reservations()->first()->agent_id)}}
          </td>
          <td class="table-active" scope="row"><label for="mobile">携帯番号</label></td>
          <td>
            {{ReservationHelper::getAgentMobile($multiple->pre_reservations()->first()->agent_id)}}
          </td>
        </tr>
        <tr>
          <td class="table-active" scope="row"><label for="tel">固定電話</label>
          </td>
          <td>
            {{ReservationHelper::getAgentTel($multiple->pre_reservations()->first()->agent_id)}}
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
              エンドユーザー
            </p>
          </td>
        </tr>
        <tr>
          <td class="table-active" width="25%"><label for="onedayCompany">会社名・団体名</label></td>
          <td>
            @if (!empty($multiple->pre_reservations()->first()->pre_enduser->company))
            {{$multiple->pre_reservations()->first()->pre_enduser->company}}
            @endif
          </td>
          <td class="table-active"><label for="onedayName">担当者氏名</label></td>
          <td>
            @if (!empty($multiple->pre_reservations()->first()->pre_enduser->person))
            {{$multiple->pre_reservations()->first()->pre_enduser->person}}
            @endif
          </td>
        </tr>
        <tr>
          <td class="table-active" scope="row"><label for="onedayEmail">担当者メールアドレス</label></td>
          <td>
            @if (!empty($multiple->pre_reservations()->first()->pre_enduser->email))
            {{$multiple->pre_reservations()->first()->pre_enduser->email}}
            @endif
          </td>
          <td class="table-active" scope="row"><label for="onedayMobile">携帯番号</label></td>
          <td>
            @if (!empty($multiple->pre_reservations()->first()->pre_enduser->mobile))
            {{$multiple->pre_reservations()->first()->pre_enduser->mobile}}
            @endif
          </td>
        </tr>
        <tr>
          <td class="table-active" scope="row"><label for="onedayTel">固定電話</label></td>
          <td>
            @if (!empty($multiple->pre_reservations()->first()->pre_enduser->tel))
            {{$multiple->pre_reservations()->first()->pre_enduser->tel}}
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
    <iframe src="{{url('admin/calendar/date_calendar')}}" width="100%" height="500">Your browser isn't
      compatible</iframe>
  </div>


  {{Form::open(['url' => 'admin/multiples/agent/'.$multiple->id.'/add_venue_store', 'method' => 'POST',
  'id'=>'add_venue'])}}
  @csrf
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
      <tbody id="pre_reservation_select_dates">
        <tr>
          <td>{{ Form::text('pre_date0', '',['class'=>'form-control', 'id'=>"pre_datepicker", ""] ) }}
            <p class="is-error-pre_date0" style="color: red"></p>
          </td>
          <td>
            <select name="pre_venue0" id="pre_venue" class="form-control">
              <option value=""></option>
              @foreach ($_venues as $venue)
              <option value="{{$venue->id}}">{{ReservationHelper::getVenue($venue->id)}}</option>
              @endforeach
            </select>
            <p class="is-error-pre_venue0" style="color: red"></p>
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
    {{Form::hidden('multiple_id',$multiple->id)}}
    {{Form::hidden('agent_id',$multiple->pre_reservations()->first()->agent_id)}}
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
  
  // 顧客検索
  
  // select2, datepicker 初期表示用
  $(function() {
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
      var valid=$("#add_venue").validate();
      valid.destroy();
      var base_venue = $(this).parent().parent().find('td').eq(1).find('select').val();
      var base_date = $(this).parent().parent().find('td').eq(0).find('input').val().split('-');
      var dt = new Date(base_date);
      dt.setDate(dt.getDate() + 1);
      var next_day=dt.getFullYear()+'-'+(( '00' + (dt.getMonth() + 1) ).slice( -2 ))+'-'+dt.getDate();
      console.log(next_day);

      $(this).parent().parent().clone(true).insertAfter($(this).parent().parent());
      if (base_venue=="") {
        $(this).parent().parent().next().find("td").eq(1).find("select option[value='']").prop('selected', true);
      }else{
        $(this).parent().parent().next().find("td").eq(1).find("select option[value=" + base_venue + "]").prop('selected', true);
      }

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
        $(target).eq(index).find('td').eq(0).find('p').remove();
        $(target).eq(index).find('td').eq(1).find('p').remove();
        $(target).eq(index).find('td').eq(2).find('p').remove();
        $(target).eq(index).find('td').eq(3).find('p').remove();
        $(target).eq(index).find('td').eq(0).find('span').remove();
        $(target).eq(index).find('td').eq(1).find('span').remove();
        $(target).eq(index).find('td').eq(2).find('span').remove();
        $(target).eq(index).find('td').eq(3).find('span').remove();
        $("input").removeClass('is-error');
        $("input").attr('aria-describedby',"");
        $("select").removeClass('is-error');
        $("select").attr('aria-describedby',"");
        $(target).eq(index).find('td').eq(0).append("<p class='is-error-pre_date"+index+"' style='color: red'></p>");
        $(target).eq(index).find('td').eq(1).append("<p class='is-error-pre_venue"+index+"' style='color: red'></p>");
        $(target).eq(index).find('td').eq(2).append("<p class='is-error-pre_enter"+index+"' style='color: red'></p>");
        $(target).eq(index).find('td').eq(3).append("<p class='is-error-pre_leave"+index+"' style='color: red'></p>");
      }
        $("#add_venue").validate({
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
        $('input').on('blur change', function () {
          $(this).valid();
        });
        for (let index_a = 0; index_a < count; index_a++) {
          $("input[name='pre_date"+index_a+"']").rules("add", {
          required: true,
          messages: { required: "※必須項目です" },
          });
          $("select[name='pre_venue"+index_a+"']").rules("add", {
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
      var valid=$("#add_venue").validate();
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
        $('.date_selector tbody tr').eq(index).find('td').eq(1).find('p').remove();
        $('.date_selector tbody tr').eq(index).find('td').eq(2).find('p').remove();
        $('.date_selector tbody tr').eq(index).find('td').eq(3).find('p').remove();
        $("input").removeClass('is-error');
        $("input").attr('aria-describedby',"");
        $("select").removeClass('is-error');
        $("select").attr('aria-describedby',"");
        $('.date_selector tbody tr').eq(index).find('td').eq(0).find('span').remove();
        $('.date_selector tbody tr').eq(index).find('td').eq(1).find('span').remove();
        $('.date_selector tbody tr').eq(index).find('td').eq(2).find('span').remove();
        $('.date_selector tbody tr').eq(index).find('td').eq(3).find('span').remove();
        $('.date_selector tbody tr').eq(index).find('td').eq(0).append("<p class='is-error-pre_date"+index+"' style='color: red'></p>");
        $('.date_selector tbody tr').eq(index).find('td').eq(1).append("<p class='is-error-pre_venue"+index+"' style='color: red'></p>");
        $('.date_selector tbody tr').eq(index).find('td').eq(2).append("<p class='is-error-pre_enter"+index+"' style='color: red'></p>");
        $('.date_selector tbody tr').eq(index).find('td').eq(3).append("<p class='is-error-pre_leave"+index+"' style='color: red'></p>");
      }
      $("#add_venue").validate({
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
        $('input').on('blur change', function () {
          $(this).valid();
        });
        for (let index_b = 0; index_b < count2; index_b++) {
          $("input[name='pre_date"+index_b+"']").rules("add", {
          required: true,
          messages: { required: "※必須項目です" },
          });
          $("select[name='pre_venue"+index_b+"']").rules("add", {
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