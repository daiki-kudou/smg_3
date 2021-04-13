@extends('layouts.admin.app')
@section('content')


<link href="{{ asset('/css/template.css') }}" rel="stylesheet">
<script src="{{ asset('/js/admin/reservation.js') }}"></script>
<script src="{{ asset('/js/ajax.js') }}"></script>
<script src="{{ asset('/js/template.js') }}"></script>
<script src="{{ asset('/js/admin/validation.js') }}"></script>


{{-- ajax画面変遷時の待機画面 --}}
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

<div class="container-field">
  <div class="float-right">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active"><a href="https://staging-smg2.herokuapp.com/admin/home">ホーム</a> &gt;
          予約　新規登録
        </li>
      </ol>
    </nav>
  </div>

  <h2 class="mt-3 mb-3">予約　新規登録</h2>
  <hr>


  {{Form::open(['url' => 'admin/reservations/calculate', 'method' => 'POST', 'id'=>'reservationCreateForm'])}}
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
            </tr>
            <tr>
              <td class="table-active form_required">会場</td>
              <td>
                <select id="venues_selector" class=" form-control" name='venue_id'>
                  <option value='#' selected>選択してください</option>
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
                      {{ Form::radio('price_system', 1, isset($request->price_system)?$request->price_system==1?true:false:'', ['class'=>'mr-2', 'id'=>'price_system_radio1']) }}
                      {{Form::label('price_system_radio1','通常（枠貸）')}}
                    </div>
                    <div class="d-flex justfy-content-start align-items-center" id="price_system2">
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
                    <option selected></option>
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
              <td>
                <div class="radio-box">
                  <p>
                    <input type="radio" name="board_flag" value="1" id="board_flag" {{isset($request->board_flag)?$request->board_flag==1?'checked':'':'',}}>
                    <span class="ml-1">有り</span>
                  </p>
                  <p>
                    <input type="radio" name="board_flag" value="0" id="no_board_flag" {{isset($request->board_flag)?$request->board_flag==0?'checked':'':'checked',}}>
                    <span class="ml-1">無し</span>
                  </p>

                </div>
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
                <div class="align-items-end d-flex">
                  {{ Form::text('event_name1','',['class'=>'form-control', 'placeholder'=>'入力してください', 'id'=>'eventname1Count'] ) }}
                  <span class="ml-1 annotation count_num1"></span>
                </div>
                <p class="is-error-event_name1" style="color: red"></p>
              </td>
            </tr>
            <tr>
              <td class="table-active">イベント名称2</td>
              <td>
                <div class="align-items-end d-flex">
                  {{ Form::text('event_name2', '',['class'=>'form-control', 'placeholder'=>'入力してください', 'id'=>'eventname2Count'] ) }}
                  <span class="ml-1 annotation count_num2"></span>
                </div>
                <p class="is-error-event_name2" style="color: red"></p>
              </td>
            </tr>
            <tr>
              <td class="table-active">主催者名</td>
              <td>
                <div class="align-items-end d-flex">
                  {{ Form::text('event_owner', '',['class'=>'form-control', 'placeholder'=>'入力してください', 'id'=>'eventownerCount'] ) }}
                  <span class="ml-1 annotation count_num3"></span>
                </div>
                <p class="is-error-event_owner" style="color: red"></p>
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
                    <i class="fas fa-wrench icon-size fa-fw"></i>有料備品
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
                    <i class="fas fa-hand-holding-heart icon-size fa-fw"></i>有料サービス
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
                    <i class="far fa-id-card icon-size" aria-hidden="true"></i>顧客情報
                  </p>
                  <p><a class="more_btn" href="">顧客詳細工藤さん！！リンク</a></p>
                </div>
              </td>
            </tr>
            <tr>
              <td class="table-active" width="33%"><label for="user_id" class=" form_required">会社名/団体名</label></td>
              <td>
                <select class="form-control" name="user_id" id="user_select">
                  <option disabled selected>選択してください</option>
                  @foreach ($users as $user)
                  <option value="{{$user->id}}" @if (isset($request)) @endif>{{$user->company}} |
                    {{$user->first_name}}{{$user->last_name}} | {{$user->email}}
                  </option>
                  @endforeach
                </select>
                <p class="is-error-user_id" style="color: red"></p>
              </td>
            </tr>
            <tr>
              <td class="table-active"><label for="name">担当者氏名　工藤さん！！</label></td>
              <td>
                <p class="person"></p>
              </td>
            </tr>
            <tr>
              <td class="table-active">メールアドレス 工藤さん！！</td>
              <td>
                <p class="email"></p>
              </td>
            </tr>
            <tr>
              <td class="table-active">携帯番号 工藤さん！！</td>
              <td>
                <p class="mobile"></p>
              </td>
            </tr>
            <tr>
              <td class="table-active">固定電話 工藤さん！！</td>
              <td>
                <p class="tel"></p>
              </td>
            </tr>
            <tr>
              <td class="table-active">割引条件 工藤さん！！</td>
              <td>
                <p class="condition">
                </p>
              </td>
            </tr>
            <tr>
              <td class="table-active caution">注意事項 工藤さん！！</td>
              <td class="caution">
                <p class="attention"></p>
              </td>
            </tr>
          </tbody>
        </table>
        <table class="table table-bordered oneday-table">
          <tbody>
            <tr>
              <td colspan="2">
                <p class="title-icon">
                  <i class="fas fa-user-check icon-size" aria-hidden="true"></i>当日の連絡できる担当者
                </p>
              </td>
            </tr>
            <tr>
              <td class="table-active"><label for="ondayName" class=" form_required">氏名</label></td>
              <td>
                {{ Form::text('in_charge', old('in_charge'),['class'=>'form-control', 'placeholder'=>'入力してください'] ) }}
                <p class="is-error-in_charge" style="color: red"></p>
              </td>
            </tr>
            <tr>
              <td class="table-active"><label for="mobilePhone" class=" form_required">携帯番号</label></td>
              <td>
                {{ Form::text('tel', old('tel'),['class'=>'form-control', 'placeholder'=>'入力してください', 'maxlength'=>13] ) }}
                <p class="is-error-tel" style="color: red"></p>
              </td>
            </tr>
          </tbody>
        </table>

        <table class="table table-bordered mail-table">
          <tbody>
            <tr>
              <td colspan="2">
                <p class="title-icon">
                  <i class="fas fa-envelope icon-size" aria-hidden="true"></i>利用後の送信メール
                </p>
              </td>
            </tr>
            <tr>
              <td class="table-active"><label for="email_flag">送信メール</label></td>
              <td>
                <div class="radio-box">
                  <p>
                    {{Form::radio('email_flag', '1', false, ['id' => 'no_email_flag', 'class' => ''])}}
                    {{Form::label('no_email_flag',"有り")}}
                  </p>
                  <p>
                    {{Form::radio('email_flag', '0', true, ['id' => 'email_flag', 'class' => ''])}}
                    {{Form::label('email_flag', "無し")}}
                  </p>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
        <table class="table table-bordered sale-table">
          <tbody>
            <tr>
              <td colspan="2">
                <p class="title-icon">
                  <i class="fas fa-yen-sign icon-size" aria-hidden="true"></i>売上原価<span class="annotation">（提携会場を選択した場合、提携会場で設定した原価率が適応されます）</span>
                </p>
              </td>
            </tr>
            <tr>
              <td class="table-active"><label for="cost">原価率</label></td>
              <td class="d-flex align-items-center">
                {{ Form::number('cost', old('cost'),['class'=>'form-control sales_percentage', 'placeholder'=>'入力してください'] ) }}
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
                  <i class="fas fa-file-alt icon-size" aria-hidden="true"></i>備考
                </p>
              </td>
            </tr>
            <tr>
              <td>
                <label for="userNote">申し込みフォーム備考</label>
                {{ Form::textarea('user_details', old('user_details'),['class'=>'form-control', 'placeholder'=>'入力してください'] ) }}
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


    <div class="submit_btn">
      <div class="d-flex justify-content-center">
        {{Form::submit('計算する', ['class'=>'btn more_btn_lg mt-5 ', 'id'=>''])}}
      </div>
    </div>

    <div class="spin_btn hide">
      <div class="d-flex justify-content-center">
        <button class="btn btn-primary btn-lg" type="button" disabled="">
          <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
          Loading...
        </button>
      </div>
    </div>



  </section>
  {{Form::close()}}
</div>

@endsection