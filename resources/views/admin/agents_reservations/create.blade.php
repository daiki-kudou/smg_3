@extends('layouts.admin.app')
@section('content')

<link href="{{ asset('/css/template.css') }}" rel="stylesheet">
<script src="{{ asset('/js/admin/reservation.js') }}"></script>
<script src="{{ asset('/js/ajax_agent.js') }}"></script>
<script src="{{ asset('/js/template.js') }}"></script>
<script src="{{ asset('/js/lettercounter.js') }}"></script>
<script src="{{ asset('/js/admin/agents_reservation/validation.js') }}"></script>
<script src="{{ asset('/js/admin/reservation/control_time.js') }}"></script>
<script src="{{ asset('/js/holidays.js') }}"></script>


<style>
  #fullOverlay {
    position: absolute;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background: rgba(100, 100, 100, .5);
    z-index: 2147483647;
    display: none;
  }

  .frame_spinner {
    max-width: 100%;
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
  }

  .hide {
    display: none !important;
  }
</style>



<div id="fullOverlay">
  <div class="frame_spinner">
    <div class="spinner-border text-primary " role="status">
      <span class="sr-only hide">Loading...</span>
    </div>
  </div>
</div>

<div class="container-field mt-3">
  @include('layouts.admin.breadcrumbs')
  <h2 class="mt-3 mb-3">予約 新規登録(仲介会社経由)</h2>
  <hr>
</div>

{{Form::open(['url' => 'admin/agents_reservations/store_session', 'method' => 'POST',
'id'=>'agentReservationCreateForm'])}}
@csrf
<section class="mt-5">
  <div class="row">
    <div class="col">
      <table class="table table-bordered reserve_table">
        <tbody>
          <tr>
            <td colspan="2">
              <p class="title-icon">
                <i class="fas fa-info-circle icon-size" aria-hidden="true"></i>予約情報
              </p>
            </td>
          </tr>
          <tr>
            <td class="table-active form_required">利用日</td>
            <td>
              {{ Form::text('reserve_date', '' ,['class'=>'form-control', 'id'=>'datepicker', 'placeholder'=>'入力してください']
              ) }}
              <p class="is-error-reserve_date" style="color: red"></p>
            </td>
          </tr>
          <tr>
            <td class="table-active form_required">会場</td>
            <td>
              <select id="venues_selector" class=" form-control" name='venue_id'>
                <option value='#' disabled selected>選択してください</option>
                @foreach ($venues as $venue)
                <option value="{{$venue->id}}" @if (isset($request->venue_id))
                  @endif
                  >{{$venue->name_area}}{{$venue->name_bldg}}{{$venue->name_venue}}</option>
                @endforeach
              </select>
              <p class="is-error-venue_id" style="color: red"></p>
              <div class="price_selector">
                <div>
                  <small>※料金体系を選択してください</small>
                </div>
                <div class="price_radio_selector">
                  <div class="d-flex justfy-content-start align-items-center" id="price_system1">
                    {{ Form::radio('price_system', 1,
                    isset($request->price_system)?$request->price_system==1?true:false:'', ['class'=>'mr-2',
                    'id'=>'price_system_radio1']) }}
                    {{Form::label('price_system_radio1','通常（枠貸）')}}
                  </div>
                  <div class="d-flex justfy-content-start align-items-center" id="price_system2">
                    {{ Form::radio('price_system', 2,
                    isset($request->price_system)?$request->price_system==2?true:false:'',
                    ['class'=>'mr-2','id'=>'price_system_radio2']) }}
                    {{Form::label('price_system_radio2','音響HG')}}
                  </div>
                </div>
              </div>
            </td>
          </tr>
          <tr>
            <td class="table-active form_required">入室時間</td>
            <td>
              <div>
                <select name="enter_time" id="sales_start" class="form-control">
                  <option disabled selected></option>
                  {!!ReservationHelper::timeOptions()!!}
                </select>
                <p class="is-error-enter_time" style="color: red"></p>
              </div>
            </td>
          </tr>
          <tr>
            <td class="table-active form_required">退室時間</td>
            <td>
              <div>
                <select name="leave_time" id="sales_finish" class="form-control">
                  <option disabled selected></option>
                  {!!ReservationHelper::timeOptions()!!}
                </select>
                <p class="is-error-leave_time" style="color: red"></p>
              </div>
            </td>
          </tr>
        </tbody>
      </table>

      <table class="table table-bordered board-table">
        <tbody>
          <tr>
            <td colspan="2">
              <div class="d-flex align-items-center justify-content-between">
                <p class="title-icon">
                  <i class="fas fa-clipboard icon-size" aria-hidden="true"></i>案内版
                </p>
              </div>
            </td>
          </tr>
          <tr>
            <td class="table-active">案内板</td>
            <td class="d-flex align-items-center">
              <div class="radio-box">
                <p>
                  <input type="radio" name="board_flag" value="1" id="board_flag" class="mr-1"
                    {{isset($request->board_flag)?$request->board_flag==1?'checked':'':'',}}>有り
                </p>
                <p class="mr-3">
                  <input type="radio" name="board_flag" value="0" id="no_board_flag" class="mr-1"
                    {{isset($request->board_flag)?$request->board_flag==0?'checked':'':'checked',}}>無し
                </p>
              </div>
            </td>
          </tr>
          <tr>
            <td class="table-active">イベント名称1</td>
            <td>
              <div class="align-items-end d-flex">
                {{ Form::text('event_name1','',['class'=>'form-control', 'placeholder'=>'入力してください',
                'id'=>'eventname1Count'] ) }}
                <span class="ml-1 annotation count_num1"></span>
              </div>
              <p class="is-error-event_name1" style="color: red"></p>
            </td>
          </tr>
          <tr>
            <td class="table-active">イベント名称2</td>
            <td>
              <div class="align-items-end d-flex">
                {{ Form::text('event_name2', '',['class'=>'form-control', 'placeholder'=>'入力してください',
                'id'=>'eventname2Count'] ) }}
                <span class="ml-1 annotation count_num2"></span>
              </div>
              <p class="is-error-event_name2" style="color: red"></p>
            </td>
          </tr>
          <tr>
            <td class="table-active">主催者名</td>
            <td>
              <div class="align-items-end d-flex">
                {{ Form::text('event_owner', '',['class'=>'form-control', 'placeholder'=>'入力してください',
                'id'=>'eventownerCount'] ) }}
                <span class="ml-1 annotation count_num3"></span>
              </div>
              <p class="is-error-event_owner" style="color: red"></p>
            </td>
          </tr>
          <tr>
            <td class="table-active">イベント開始時間</td>
            <td>
              <div>
                <select name="event_start" id="event_start" class="form-control">
                  <option disabled>選択してください</option>
                  {!!ReservationHelper::timeOptions()!!}
                </select>
              </div>
            </td>
          </tr>
          <tr>
            <td class="table-active">イベント終了時間</td>
            <td>
              <div>
                <select name="event_finish" id="event_finish" class="form-control">
                  <option disabled>選択してください</option>
                  {!!ReservationHelper::timeOptions()!!}
                </select>
              </div>
            </td>
          </tr>
        </tbody>
      </table>

      <div class="equipemnts">
        <table class="table table-bordered">
          <thead class="accordion-ttl">
            <tr>
              <th colspan="2">
                <p class="title-icon fw-bolder">
                  <i class="fas fa-wrench icon-size" aria-hidden="true"></i>有料備品
                </p>
              </th>
            </tr>
          </thead>
          <tbody class="accordion-wrap"></tbody>
        </table>
      </div>
      <div class="services">
        <table class="table table-bordered">
          <thead class="accordion-ttl">
            <tr>
              <th colspan="2">
                <p class="title-icon fw-bolder">
                  <i class="fas fa-hand-holding-heart icon-size" aria-hidden="true"></i>有料サービス
                </p>
              </th>
            </tr>
          </thead>
          <tbody class="accordion-wrap"></tbody>
        </table>
      </div>
      <div class="layouts">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th colspan="2">
                <p class="title-icon">
                  <i class="fas fa-th icon-size fa-fw" aria-hidden="true"></i>レイアウト
                </p>
              </th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
      <div class="luggage">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th colspan="2">
                <p class="title-icon">
                  <i class="fas fa-suitcase-rolling icon-size fa-fw" aria-hidden="true"></i>荷物預り
                </p>
              </th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>

      <div class="eat_in">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th colspan='2'>
                <p class="title-icon">
                  <i class="fas fa-utensils icon-size fa-fw"></i>室内飲食
                </p>
              </th>
            </tr>
          </thead>
          <tbody class="eat_in">
            <tr>
              <td>
                {{Form::radio('eat_in', 1, false , ['id' => 'eat_in'])}}
                {{Form::label('eat_in',"あり")}}
              </td>
              <td>
                {{Form::radio('eat_in_prepare', 1, false , ['id' => 'eat_in_prepare', 'disabled'])}}
                {{Form::label('eat_in_prepare',"手配済み")}}
                {{Form::radio('eat_in_prepare', 2, false , ['id' => 'eat_in_consider','disabled'])}}
                {{Form::label('eat_in_consider',"検討中")}}
              </td>
            </tr>
            <tr>
              <td>
                {{Form::radio('eat_in', 0, true , ['id' => 'no_eat_in'])}}
                {{Form::label('no_eat_in',"なし")}}
              </td>
              <td></td>
            </tr>
          </tbody>
        </table>
      </div>

      <div class="price_details">
      </div>
    </div>

    <div class="col">
      <table class="table table-bordered name-table">
        <tbody>
          <tr>
            <td colspan="2">
              <div class="d-flex align-items-center justify-content-between">
                <p class="title-icon">
                  <i class="far fa-id-card icon-size" aria-hidden="true"></i>仲介会社情報
                </p>
                <p class="agent_link">
                </p>
              </div>
            </td>
          </tr>
          <tr>
            <td class="table-active">
              <label for="agent_id" class=" form_required">サービス名称</label>
            </td>
            <td>
              <select class="form-control" name="agent_id" id="agent_select">
                <option disabled selected>選択してください</option>
                @foreach ($agents as $agent)
                <option value="{{$agent->id}}">{{$agent->name}} |
                  {{$agent->person_firstname}}{{$agent->person_lastname}} | {{$agent->email}}
                </option>
                @endforeach
              </select>
              <p class="is-error-agent_id" style="color: red"></p>
            </td>
          </tr>
          <tr>
            <td class="table-active"><label for="name">担当者氏名<br></label></td>
            <td>
              <p class="selected_person"></p>
            </td>
          </tr>
        </tbody>
      </table>
      <table class="table table-bordered oneday-table">
        <tbody>
          <tr>
            <td colspan="2">
              <p class="title-icon">
                <i class="fas fa-user-check icon-size" aria-hidden="true"></i>エンドユーザー情報
              </p>
            </td>
          </tr>
          <tr>
            <td class="table-active">
              <label for="enduser_company" class="">エンドユーザー</label>
            </td>
            <td>
              {{ Form::text('enduser_company', old('enduser_company'),['class'=>'form-control',
              'placeholder'=>'入力してください','id'=>'enduser_company'] ) }}
            </td>
          </tr>
          <tr>
            <td class="table-active">
              <label for="enduser_address" class=" ">住所</label>
            </td>
            <td>
              {{ Form::text('enduser_address', old('enduser_address'),['class'=>'form-control',
              'placeholder'=>'入力してください','id'=>'enduser_address'] ) }}
            </td>
          </tr>
          <tr>
            <td class="table-active">
              <label for="enduser_tel" class="">連絡先</label>
            </td>
            <td>
              {{ Form::text('enduser_tel', old('enduser_tel'),['class'=>'form-control', 'placeholder'=>'入力してください',
              'id'=>'enduser_tel'] ) }}
              <p class="is-error-enduser_tel" style="color: red"></p>
            </td>
          </tr>
          <tr>
            <td class="table-active">
              <label for="enduser_mail" class=" ">メールアドレス</label>
            </td>
            <td>
              {{ Form::text('enduser_mail', old('enduser_mail'),['class'=>'form-control', 'placeholder'=>'入力してください',
              'id'=>'enduser_mail'] ) }}
              <p class="is-error-enduser_mail" style="color: red"></p>
            </td>
          </tr>
          <tr>
            <td class="table-active">
              <label for="enduser_incharge" class="">当日担当者</label>
            </td>
            <td>
              {{ Form::text('enduser_incharge', old('enduser_incharge'),['class'=>'form-control',
              'placeholder'=>'入力してください', 'id'=>'enduser_incharge'] ) }}
            </td>
          </tr>
          <tr>
            <td class="table-active">
              <label for="enduser_mobile" class="">当日連絡先</label>
            </td>
            <td>
              {{ Form::text('enduser_mobile', old('enduser_mobile'),['class'=>'form-control', 'placeholder'=>'入力してください',
              'id'=>'enduser_mobile'] ) }}
              <p class="is-error-enduser_mobile" style="color: red"></p>
            </td>
          </tr>
          <tr>
            <td class="table-active">
              <label for="enduser_attr" class="">利用者属性</label>
            </td>
            <td>
              <select name="enduser_attr" class="form-control">
                <option value="1">一般企業</option>
                <option value="2">上場企業</option>
                <option value="3">近隣利用</option>
                <option value="4">個人講師</option>
                <option value="5">MLM</option>
                <option value="6">その他</option>
              </select>
            </td>
          </tr>
        </tbody>
      </table>
      <table class="table table-bordered sale-table">
        <tbody>
          <tr>
            <td colspan="2">
              <p class="title-icon">
                <i class="fas fa-yen-sign icon-size" aria-hidden="true"></i>エンドユーザーからの入金額(レイアウト料金は含まない)
              </p>
            </td>
          </tr>
          <tr>
            <td class="table-active form_required">
              <label for="end_user_charge ">支払い料</label>
            </td>
            <td>
              <div class="d-flex align-items-end">
                {{ Form::text('end_user_charge', old('end_user_charge'),['class'=>'form-control ',
                'placeholder'=>'入力してください'] ) }}
                <span class="ml-1">円</span>
              </div>
              <p class="is-error-end_user_charge" style="color: red"></p>
            </td>
          </tr>
        </tbody>
      </table>

      <table class="table table-bordered sale-table" id="user_cost">
        <tbody>
          <tr>
            <td colspan="2">
              <p class="title-icon">
                <i class="fas fa-yen-sign icon-size" aria-hidden="true"></i>売上原価<span
                  class="annotation">（提携会場を選択した場合、提携会場で設定した原価率が適応されます）</span>
              </p>
            </td>
          </tr>
          <tr>
            <td class="table-active"><label for="cost">原価率</label></td>
            <td class="d-flex align-items-center">
              {{Form::text('cost','',['class'=>'form-control sales_percentage'])}}
              <span class="ml-1">%</span>
              <p class="is-error-cost" style="color: red"></p>
            </td>
          </tr>
        </tbody>
      </table>

      <table class="table table-bordered note-table">
        <tbody>
          <tr>
            <td colspan="2">
              <p class="title-icon">
                <i class="fas fa-envelope icon-size" aria-hidden="true"></i>備考
              </p>
            </td>
          </tr>
          <tr>
            <td>
              <label for="adminNote">管理者備考</label>
              {{ Form::textarea('admin_details', old('admin_details'),['class'=>'form-control',
              'placeholder'=>'入力してください'] ) }}
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</section>

{{Form::submit('計算する', ['class'=>'btn more_btn_lg mx-auto d-block btn-lg',"name"=>'submit', 'id'=>'check_submit'])}}

{{Form::close()}}

<script>
  function checkForm($this) {
          var str = $this.value;
          while (str.match(/[^A-Z^a-z\d\-]/)) {
            str = str.replace(/[^A-Z^a-z\d\-]/, "");
          }
          $this.value = str;
        }
  $(document).on(' click', '.holidays', function () {
  getHolidayCalendar($('.holidays'), $('input[name="reserve_date"]'));
});

// 日付を変更されたら、再度荷物の到着日の再計算
$(document).on('change', 'input[name="reserve_date"]', function () {
  getHolidayCalendar($('.holidays'), $('input[name="reserve_date"]'), 0);
});

  $(function() {
    $(document).on("click", "input:radio[name='eat_in']", function() {
      var radioTarget = $('input:radio[name="eat_in"]:checked').val();
      if (radioTarget == 1) {
        $('input:radio[name="eat_in_prepare"]').prop('disabled', false);
        $('input[name=eat_in_prepare]:eq(0)').prop('checked', true);
      } else {
        $('input:radio[name="eat_in_prepare"]').prop('disabled', true);
        $('input:radio[name="eat_in_prepare"]').val("");
      }
    })
  })
</script>
@endsection