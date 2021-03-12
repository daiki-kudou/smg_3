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


{{ Form::open(['url' => 'admin/multiples/switch_cfm/'.$multiple->id, 'method'=>'POST', 'id'=>'']) }}
@csrf

<div class="content">
  <div class="container-fluid">
    <div class="container-field mt-3">
      <div class="float-right">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item active">ダミーダミーダミー
            </li>
          </ol>
        </nav>
      </div>
      <h2 class="mt-3 mb-3">一括仮押え　詳細</h2>
      <hr>
    </div>

    <!-- 仮押え登録--------------------------------------------------------　 -->
    <section class="section-wrap">
      <div class="row">
        <table class="table ttl_head mb-0">
          <tbody>
            <tr>
              <td>
                <h3 class="text-white py-2">
                  仮押え一括ID：{{$multiple->id}}
                </h3>
              </td>
              <!-- <td>
                  <dl class="ttl_box">
                    <dt>仮押え一括ID:</dt>
                    <dd class="total_result">{{$multiple->id}}</dd>
                  </dl>
                </td> -->
          </tbody>
        </table>

        <div class="border-wrap2 p-4">
          <div class="user_selector">
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
                      顧客情報
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
                <td class="table-active" scope="row"><label for="tel">固定電話</label></td>
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
                  @if ($multiple->pre_reservations()->first()->id==999)
                  {{$multiple->pre_reservations()->first()->unknown_user()->unknown_user_company}}
                  @endif
                </td>
                <td class="table-active"><label for="onedayName">担当者名(仮)</label></td>
                <td>
                  @if ($multiple->pre_reservations()->first()->id==999)
                  {{$multiple->pre_reservations()->first()->unknown_user()->unknown_user_name}}
                  @endif
                </td>
              </tr>
              <tr>
              <td class="table-active" scope="row"><label for="onedayTel">固定電話</label></td>
                <td>
                  @if ($multiple->pre_reservations()->first()->id==999)
                  {{$multiple->pre_reservations()->first()->unknown_user()->unknown_user_tel}}
                  @endif
                </td>
                <td class="table-active" scope="row"><label for="onedayMobile">携帯番号</label></td>
                <td>
                  @if ($multiple->pre_reservations()->first()->id==999)
                  {{$multiple->pre_reservations()->first()->unknown_user()->unknown_user_mobile}}
                  @endif
                </td>
              </tr>
              <tr>
              <td class="table-active" scope="row"><label for="onedayEmail">メールアドレス</label></td>
                <td>
                  @if ($multiple->pre_reservations()->first()->id==999)
                  {{$multiple->pre_reservations()->first()->unknown_user()->unknown_user_email}}
                  @endif
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
          url: '/admin/pre_reservations/get_user',
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
          console.log($user);
          $(".user_info").find('tr').eq(0).find('td').eq(1).text("");
          $(".user_info").find('tr').eq(0).find('td').eq(1).text($user[0]);
          $(".user_info").find('tr').eq(1).find('td').eq(1).text("");
          $(".user_info").find('tr').eq(1).find('td').eq(1).text($user[1] + $user[2]);
          $(".user_info").find('tr').eq(1).find('td').eq(3).text("");
          $(".user_info").find('tr').eq(1).find('td').eq(3).text($user[3]);
          $(".user_info").find('tr').eq(2).find('td').eq(1).text("");
          $(".user_info").find('tr').eq(2).find('td').eq(1).text($user[4]);
          $(".user_info").find('tr').eq(2).find('td').eq(3).text("");
          $(".user_info").find('tr').eq(2).find('td').eq(3).text($user[5]);
          $('input[name="user_id"]').val($user[6]);
        })
        .fail(function($user) {
          $('#fullOverlay').css('display', 'none');
          console.log("エラーです");
        });
    };
  })
</script>



@endsection