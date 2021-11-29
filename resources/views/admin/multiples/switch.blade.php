@extends('layouts.admin.app')

@section('content')

<link href="{{ asset('/css/template.css') }}" rel="stylesheet">
<script src="{{ asset('/js/template.js') }}"></script>
<script src="{{ asset('/js/admin/multiples/validation.js') }}"></script>

<div id="fullOverlay">
  <div class="frame_spinner">
    <div class="spinner-border text-primary " role="status">
      <span class="sr-only hide">Loading...</span>
    </div>
  </div>
</div>

{{ Form::open(['url' => '/admin/multiples/switch_cfm/'.$multiple->id, 'method'=>'POST', 'id'=>'multiple_switch']) }}
@csrf

<div class="container-fluid">
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
    <h2 class="mt-3 mb-3">一括仮押え　顧客情報情報編集</h2>
    <hr>
  </div>

  <!-- 仮押え登録--------------------------------------------------------　 -->
  <section class="mt-5">
    <div class="row">
      <table class="table ttl_head mb-0">
        <tbody>
          <tr>
            <td>
              <h3 class="text-white py-2">
                仮押え一括ID：{{ReservationHelper::fixId($multiple->id)}}
              </h3>
            </td>
        </tbody>
      </table>

      <div class="border-wrap2 p-4">
        <div class="user_selector mb-3">
          <h3 class="mb-2">顧客検索</h3>
          <select name="user_id" id="user_id">
            @foreach ($users as $user)
            <option value="{{$user->id}}" @if ($user->id==$multiple->pre_reservations()->first()->user_id)
              selected
              @endif
              >
              {{$user->company}}・{{ReservationHelper::getPersonName($user->id)}}・{{ReservationHelper::getPersonEmail($user->id)}}
            </option>
            @endforeach
          </select>
        </div>

        <table class="table table-bordered customer-table mb-5" style="table-layout: fixed;">
          <thead>
            <tr>
              <td colspan="4">
                <div class="d-flex align-items-center justify-content-between">
                  <p class="title-icon">
                    <i class="far fa-address-card icon-size" aria-hidden="true"></i>
                    顧客ID：{{ ReservationHelper::fixId($multiple->pre_reservations->first()->user->id) }}　顧客情報
                  </p>
                </div>
              </td>
            </tr>
          </thead>
          <tbody class="user_info">
            <tr>
              <th class="table-active" width="25%"><label for="company">会社名・団体名</label></th>
              <td>
                {{ReservationHelper::getCompany($multiple->pre_reservations()->first()->user_id)}}
              </td>
              <th class="table-active"><label for="name">担当者氏名</label></th>
              <td>
                {{ReservationHelper::getPersonName($multiple->pre_reservations()->first()->user_id)}}
              </td>
            </tr>
            <tr>
              <th class="table-active" scope="row"><label for="email">担当者メールアドレス</label></th>
              <td>
                {{ReservationHelper::getPersonEmail($multiple->pre_reservations()->first()->user_id)}}
              </td>
              <th class="table-active" scope="row"><label for="mobile">携帯番号</label></th>
              <td>
                {{ReservationHelper::getPersonMobile($multiple->pre_reservations()->first()->user_id)}}
              </td>
            </tr>
            <tr>
              <th class="table-active" scope="row"><label for="tel">固定電話</label></th>
              <td>
                {{ReservationHelper::getPersonTel($multiple->pre_reservations()->first()->user_id)}}
              </td>
              <th class="table-active" scope="row"><label for="">割引条件</label></th>
              <td>
                <p class="condition">
                  {!!nl2br(e($multiple->pre_reservations->first()->user->condition))!!}
                </p>
              </td>
            </tr>
            <tr>
              <th class="table-active caution" scope="row"><label for="">注意事項</label></th>
              <td class="caution" colspan="3">
                <p class="attention">
                  {!!nl2br(e($multiple->pre_reservations->first()->user->attention))!!}
                </p>
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
                {{Form::text("unknown_user_company",optional($multiple->pre_reservations()->first()->unknown_user)->unknown_user_company,["class"=>"form-control"])}}
              </td>
              <td class="table-active"><label for="onedayName">担当者名(仮)</label></td>
              <td>
                {{Form::text("unknown_user_name",optional($multiple->pre_reservations()->first()->unknown_user)->unknown_user_name,["class"=>"form-control"])}}
              </td>
            </tr>
            <tr>
              <td class="table-active" scope="row"><label for="onedayTel">固定電話</label></td>
              <td>
                {{Form::text("unknown_user_tel",optional($multiple->pre_reservations()->first()->unknown_user)->unknown_user_tel,["class"=>"form-control",
                'placeholder' => '半角数字、ハイフンなしで入力してください'])}}
                <p class="is-error-unknown_user_tel" style="color: red"></p>
              </td>
              <td class="table-active" scope="row"><label for="onedayMobile">携帯番号</label></td>
              <td>
                {{Form::text("unknown_user_mobile",optional($multiple->pre_reservations()->first()->unknown_user)->unknown_user_mobile,["class"=>"form-control",
                'placeholder' => '半角数字、ハイフンなしで入力してください'])}}
                <p class="is-error-unknown_user_mobile" style="color: red"></p>
              </td>
            </tr>
            <tr>
              <td class="table-active" scope="row"><label for="onedayEmail">メールアドレス</label></td>
              <td>
                {{Form::text("unknown_user_email",optional($multiple->pre_reservations()->first()->unknown_user)->unknown_user_email,["class"=>"form-control"])}}
                <p class="is-error-unknown_user_email" style="color: red"></p>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </section>
</div>
<div class="btn_wrapper">
  <p class="text-center">
    {{ Form::submit('変更する', ['class' => 'btn more_btn_lg']) }}
  </p>
</div>
{{ Form::close() }}






<script>
  $(function() {
    $(document).on("change", "#user_id", function() {
      var user_id = Number($('#user_id').val());
      ajaxGetuser(user_id);
    });
    function ajaxGetuser($user_id) {
      $.ajax({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          url: rootPath+'/admin/pre_reservations/get_user',
          type: 'POST',
          data: {
            'user_id': $user_id,
          },
          dataType: 'json',
          beforeSend: function() {
            $('#fullOverlay').css('display', 'block');
          },
        })
        .done(function($user) {
          $('#fullOverlay').css('display', 'none');

          $(".user_info").find('tr').eq(0).find('td').eq(0).text("").text($user[0]);
          $(".user_info").find('tr').eq(0).find('td').eq(1).text("").text($user[1] + $user[2]);
          $(".user_info").find('tr').eq(1).find('td').eq(0).text("").text($user[3]);
          $(".user_info").find('tr').eq(1).find('td').eq(1).text("").text($user[4]);
          $(".user_info").find('tr').eq(2).find('td').eq(0).text("").text($user[4]);
          $(".user_info").find('tr').eq(2).find('td').eq(0).text("").text($user[4]);
          $('input[name="user_id"]').val($user[6]);

          $(".condition").text("");
          $(".attention").text("");

          if ($user[7]!==null) {
            $(".condition").html($user[7].replace(/\n/g, '<br>'));
          }
          if ($user[8]!==null) {
            $(".attention").html($user[8].replace(/\n/g, '<br>'));
          }


        })
        .fail(function($user) {
          $('#fullOverlay').css('display', 'none');
          console.log("ajax failed", $user);
        });
    };
  })
</script>



@endsection