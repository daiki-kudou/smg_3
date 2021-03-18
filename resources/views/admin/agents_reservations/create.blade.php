@extends('layouts.admin.app')
@section('content')

<link href="{{ asset('/css/template.css') }}" rel="stylesheet">
<script src="{{ asset('/js/admin/reservation.js') }}"></script>
<script src="{{ asset('/js/ajax.js') }}"></script>
<script src="{{ asset('/js/admin/validation.js') }}"></script>

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
    display: none;
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
  <div class="float-right">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active">ダミーテキスト</li>
      </ol>
    </nav>
  </div>
  <h2 class="mt-3 mb-3">仲介会社経由の予約 新規登録</h2>
  <hr>
</div>

{{Form::open(['url' => 'admin/agents_reservations/calculate', 'method' => 'POST', 'id'=>'agentReservationCreateForm'])}}
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
              {{ Form::text('reserve_date', '' ,['class'=>'form-control', 'id'=>'datepicker', 'placeholder'=>'入力してください'] ) }}
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
                  <div class="d-flex justfy-content-start align-items-center">
                    {{ Form::radio('price_system', 1, isset($request->price_system)?$request->price_system==1?true:false:'', ['class'=>'mr-2', 'id'=>'price_system_radio1']) }}
                    {{Form::label('price_system_radio1','通常（枠貸）')}}
                  </div>
                  <div class="d-flex justfy-content-start align-items-center">
                    {{ Form::radio('price_system', 2, isset($request->price_system)?$request->price_system==2?true:false:'', ['class'=>'mr-2','id'=>'price_system_radio2']) }}
                    {{Form::label('price_system_radio2','アクセア（時間貸）')}}
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
                  @for ($start = 0*2; $start <=23*2; $start++) <option value="{{date("H:i:s", strtotime("00:00 +". $start * 30 ." minute"))}}" @if (isset($request)) @endif>
                    {{date("H時i分", strtotime("00:00 +". $start * 30 ." minute"))}}
                    </option>
                    @endfor
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
                  @for ($start = 0*2; $start <=23*2; $start++) <option value="{{date("H:i:s", strtotime("00:00 +". $start * 30 ." minute"))}}" @if (isset($request)) @endif>
                    {{date("H時i分", strtotime("00:00 +". $start * 30 ." minute"))}}</option>
                    @endfor
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
              <p class="mr-3">
                <input type="radio" name="board_flag" value="0" {{isset($request->board_flag)?$request->board_flag==0?'checked':'':'checked',}}>無し
              </p>
              <p>
                <input type="radio" name="board_flag" value="1" {{isset($request->board_flag)?$request->board_flag==1?'checked':'':'',}}>有り
              </p>
            </td>
          </tr>
          <tr>
            <td class="table-active">イベント開始時間</td>
            <td>
              <div>
                <select name="event_start" id="event_start" class="form-control">
                  <option disabled>選択してください</option>
                  @for ($start = 0*2; $start <=23*2; $start++) <option value="{{date("H:i:s", strtotime("00:00 +". $start * 30 ." minute"))}}" @if (isset($request)) @endif>
                    {{date("H時i分", strtotime("00:00 +". $start * 30 ." minute"))}}</option>
                    @endfor
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
                  @for ($start = 0*2; $start <=23*2; $start++) <option value="{{date("H:i:s", strtotime("00:00 +". $start * 30 ." minute"))}}" @if (isset($request)) @endif>
                    {{date("H時i分", strtotime("00:00 +". $start * 30 ." minute"))}}</option>
                    @endfor
                </select>
              </div>
            </td>
          </tr>
          <tr>
            <td class="table-active">イベント名称1</td>
            <td>
              {{ Form::text('event_name1','',['class'=>'form-control', 'placeholder'=>'入力してください'] ) }}
            </td>
          </tr>
          <tr>
            <td class="table-active">イベント名称2</td>
            <td>
              {{ Form::text('event_name2', '',['class'=>'form-control', 'placeholder'=>'入力してください'] ) }}
            </td>
          </tr>
          <tr>
            <td class="table-active">主催者名</td>
            <td>
              {{ Form::text('event_owner', '',['class'=>'form-control', 'placeholder'=>'入力してください'] ) }}
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
                  <i class="fas fa-suitcase-rolling icon-size fa-fw" aria-hidden="true"></i>荷物預かり
                </p>
              </th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
      <div class="price_details">
      </div>
    </div>

    <div class="col">
      <!-- <div class="client_mater">　 -->
      <table class="table table-bordered name-table">
        <tbody>
          <tr>
            <td colspan="2">
              <div class="d-flex align-items-center justify-content-between">
                <p class="title-icon">
                  <i class="far fa-id-card icon-size" aria-hidden="true"></i>仲介会社情報
                </p>
                <p><a class="more_btn bg-green" href="">仲介会社詳細</a></p>
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
              <p class="is-error-user_id" style="color: red"></p>
            </td>
          </tr>
          <tr>
            <td class="table-active"><label for="name" class=" form_required">担当者氏名<br></label></td>
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
              {{ Form::text('enduser_company', old('enduser_company'),['class'=>'form-control', 'placeholder'=>'入力してください','id'=>'enduser_company'] ) }}
            </td>
          </tr>
          <tr>
            <td class="table-active">
              <label for="enduser_address" class=" ">住所</label>
            </td>
            <td>
              {{ Form::text('enduser_address', old('enduser_address'),['class'=>'form-control', 'placeholder'=>'入力してください', 'maxlength'=>13,'id'=>'enduser_address'] ) }}
            </td>
          </tr>
          <tr>
            <td class="table-active">
              <label for="enduser_tel" class="">連絡先</label>
            </td>
            <td>
              {{ Form::text('enduser_tel', old('enduser_tel'),['class'=>'form-control', 'placeholder'=>'入力してください', 'maxlength'=>13, 'id'=>'enduser_tel'] ) }}
            </td>
          </tr>
          <tr>
            <td class="table-active">
              <label for="enduser_mail" class=" ">メールアドレス</label>
            </td>
            <td>
              {{ Form::text('enduser_mail', old('enduser_mail'),['class'=>'form-control', 'placeholder'=>'入力してください', 'maxlength'=>13,'id'=>'enduser_mail'] ) }}
            </td>
          </tr>
          <tr>
            <td class="table-active">
              <label for="enduser_incharge" class="">当日担当者</label>
            </td>
            <td>
              {{ Form::text('enduser_incharge', old('enduser_incharge'),['class'=>'form-control', 'placeholder'=>'入力してください', 'maxlength'=>13, 'id'=>'enduser_incharge'] ) }}
            </td>
          </tr>
          <tr>
            <td class="table-active">
              <label for="enduser_mobile" class="">当日連絡先</label>
            </td>
            <td>
              <input class="form-control" placeholder="入力してください" maxlength="13" id="enduser_mobile" name="enduser_mobile" type="text">
            </td>
          </tr>
          <tr>
            <td class="table-active">
              <label for="enduser_attr" class="">利用者属性</label>
            </td>
            <td>
              <select name="enduser_attr">
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
      <!-- </div> -->
      <table class="table table-bordered sale-table">
        <tbody>
          <tr>
            <td colspan="2">
              <p class="title-icon">
                <i class="fas fa-yen-sign icon-size" aria-hidden="true"></i>エンドユーザーからの入金額
              </p>
            </td>
          </tr>
          <tr>
            <td class="table-active form_required">
              <label for="enduser_charge ">支払い料</label>
            </td>
            <td class="d-flex align-items-end">
              {{ Form::text('enduser_charge', old('enduser_charge'),['class'=>'form-control sales_percentage', 'placeholder'=>'入力してください'] ) }}
              <span class="ml-1">円</span>

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
              {{ Form::textarea('admin_details', old('admin_details'),['class'=>'form-control', 'placeholder'=>'入力してください'] ) }}
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</section>

{{Form::submit('計算する', ['class'=>'btn more_btn_lg mx-auto d-block btn-lg', 'id'=>'check_submit'])}}

{{Form::close()}}
@endsection