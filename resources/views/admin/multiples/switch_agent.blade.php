@extends('layouts.admin.app')

@section('content')

<link href="{{ asset('/css/template.css') }}" rel="stylesheet">
<script src="{{ asset('/js/template.js') }}"></script>
<script src="{{ asset('/js/admin/validation.js') }}"></script>

<div id="fullOverlay">
  <div class="frame_spinner">
    <div class="spinner-border text-primary " role="status">
      <span class="sr-only hide">Loading...</span>
    </div>
  </div>
</div>


{{ Form::open(['url' => 'admin/multiples/agent_switch_cfm/'.$multiple->id, 'method'=>'POST', 'id'=>'multipleagent_switch']) }}
@csrf

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
        <div class="user_selector">
          <h3 class="mb-2">仲介会社検索</h3>
          <select name="agent_id" id="agent_id">
            @foreach ($agents as $agent)
            <option value="{{$agent->id}}" @if ($agent->id==$multiple->pre_reservations()->first()->user_id)
              selected
              @endif
              >
              {{$agent->company}}・{{ReservationHelper::getAgentPerson($agent->id)}}・{{ReservationHelper::getAgentEmail($agent->id)}}
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
                    仲介会社情報
                  </p>
                </div>
              </td>
            </tr>
          </thead>
          <tbody class="agent_info">
            <tr>
              <th class="table-active" width="25%">
                <label for="company">会社名・団体名</label>
              </th>
              <td>
                {{ReservationHelper::getAgentCompany($multiple->pre_reservations()->first()->agent_id)}}
              </td>
              <th class="table-active">
                <label for="name">担当者氏名</label>
              </th>
              <td>
                {{ReservationHelper::getAgentPerson($multiple->pre_reservations()->first()->agent_id)}}
              </td>
            </tr>
            <tr>
              <th class="table-active" scope="row">
                <label for="email">担当者メールアドレス</label>
              </th>
              <td>
                {{ReservationHelper::getAgentEmail($multiple->pre_reservations()->first()->agent_id)}}
              </td>
              <th class="table-active" scope="row">
                <label for="mobile">携帯番号</label>
              </th>
              <td>
                {{ReservationHelper::getAgentMobile($multiple->pre_reservations()->first()->agent_id)}}
              </td>
            </tr>
            <tr>
              <th class="table-active" scope="row">
                <label for="tel">固定電話</label>
              </th>
              <td>
                {{ReservationHelper::getAgentTel($multiple->pre_reservations()->first()->agent_id)}}
              </td>
            </tr>
          </tbody>
        </table>
        <table class="table table-bordered" style="table-layout: fixed;">
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
              <td class="table-active" width="25%">
                <label for="onedayCompany">エンドユーザー</label>
              </td>
              <td>
                {{Form::text("end_user_company",!empty($pre_enduser)?$pre_enduser->company:'',["class"=>"form-control"])}}
              </td>
              <td class="table-active">
                <label for="">住所</label>
              </td>
              <td>
                {{Form::text("end_user_address",!empty($pre_enduser)?$pre_enduser->address:'',["class"=>"form-control"])}}
              </td>
            </tr>

            <tr>
              <td class="table-active" scope="row">
                <label for="onedayTel">連絡先</label>
              </td>
              <td>
                {{Form::text("end_user_tel",!empty($pre_enduser)?$pre_enduser->tel:'',["class"=>"form-control"])}}
                <p class="is-error-end_user_tel" style="color: red"></p>
              </td>
              <td class="table-active" scope="row">
                <label for="onedayEmail">メールアドレス</label>
              </td>
              <td>
                {{Form::text("end_user_email",!empty($pre_enduser)?$pre_enduser->email:'',["class"=>"form-control"])}}
                <p class="is-error-end_user_email" style="color: red"></p>
              </td>
            </tr>
            <tr>
              <td class="table-active">
                <label for="onedayName">当日担当者</label>
              </td>
              <td>
                {{Form::text("end_user_name",!empty($pre_enduser)?$pre_enduser->person:'',["class"=>"form-control"])}}
              </td>
              <td class="table-active" scope="row">
                <label for="onedayMobile">当日連絡先</label>
              </td>
              <td>
                {{Form::text("end_user_mobile",!empty($pre_enduser)?$pre_enduser->mobile:'',["class"=>"form-control"])}}
                <p class="is-error-end_user_mobile" style="color: red"></p>
              </td>
            </tr>
            <tr>
              <td class="table-active form_required">利用者属性</td>
              <td>
                <select name="end_user_attr" class="form-control">
                  @if (!empty($pre_enduser->attr))
                  <option value=""></option>
                  <option value="1" {{($pre_enduser->attr==1)?"selected":''}}>一般企業</option>
                  <option value="2" {{($pre_enduser->attr==2)?"selected":''}}>上場企業</option>
                  <option value="3" {{($pre_enduser->attr==3)?"selected":''}}>近隣利用</option>
                  <option value="4" {{($pre_enduser->attr==4)?"selected":''}}>個人講師</option>
                  <option value="5" {{($pre_enduser->attr==5)?"selected":''}}>MLM</option>
                  <option value="6" {{($pre_enduser->attr==6)?"selected":''}}>その他</option>
                  @else
                  <option value=""></option>
                  <option value="1">一般企業</option>
                  <option value="2">上場企業</option>
                  <option value="3">近隣利用</option>
                  <option value="4">個人講師</option>
                  <option value="5">MLM</option>
                  <option value="6">その他</option>
                  @endif

                </select>
                <p class="is-error-pre_enduser_attr" style="color: red"></p>
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
    $(document).on("change", "#agent_id", function() {
      var agent_id = Number($('#agent_id').val());
      ajaxGetAgent(agent_id);
    });
    function ajaxGetAgent($agent_id) {
      $.ajax({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          url: '/admin/agents/get_agent',
          type: 'POST',
          data: {
            'agent_id': $agent_id,
          },
          dataType: 'json',
          beforeSend: function() {
            $('#fullOverlay').css('display', 'block');
          },
        })
        .done(function($agent) {
          $('#fullOverlay').css('display', 'none');
          console.log($agent);
          $(".agent_info").find('tr').eq(0).find('td').eq(0).text("").text($agent["company"]);
          $(".agent_info").find('tr').eq(0).find('td').eq(1).text("").text($agent["person_firstname"] + $agent["person_lastname"]);
          $(".agent_info").find('tr').eq(1).find('td').eq(0).text("").text($agent["email"]);
          $(".agent_info").find('tr').eq(1).find('td').eq(1).text("").text($agent["person_mobile"]);
          $(".agent_info").find('tr').eq(2).find('td').eq(0).text("").text($agent["person_tel"]);
        })
        .fail(function($user) {
          $('#fullOverlay').css('display', 'none');
          console.log("エラーです");
        });
    };
  })
</script>


@endsection