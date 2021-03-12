@extends('layouts.admin.app')
@section('content')
<script src="{{ asset('/js/template.js') }}"></script>
<script src="{{ asset('/js/admin/validation.js') }}"></script>
<link href="{{ asset('/css/template.css') }}" rel="stylesheet">

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
  <h2 class="mt-3 mb-3">仮押え　詳細入力画面</h2>
  <hr>
</div>

{{ Form::open(['url' => 'admin/pre_reservations/calculate', 'method'=>'POST', 'id'=>'pre_reservationSingleCheckForm']) }}
@csrf

<section class="section-wrap">
  <div class="selected_user">
    <table class="table table-bordered" style="table-layout: fixed;">
      <thead>
        <tr>
          <th>顧客情報</th>
          <th colspan="3">顧客ID：<p class="user_id d-inline">{{$request->user_id}}</p>
          </th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td class="table-active">会社名・団体名</td>
          <td colspan="3">
            <p class="company">{{$request->user_id==999?"":ReservationHelper::getCompany($request->user_id)}}</p>
          </td>
        </tr>
        <tr>
          <td class="table-active">担当者氏名</td>
          <td>
            <p class="person">{{$request->user_id==999?"":ReservationHelper::getPersonName($request->user_id)}}</p>
          </td>
          <td class="table-active">メールアドレス</td>
          <td>
            <p class="email">{{$request->user_id==999?"":ReservationHelper::getPersonEmail($request->user_id)}}</p>

          </td>
        </tr>
        <tr>
          <td class="table-active">携帯番号</td>
          <td>
            <p class="mobile">{{$request->user_id==999?"":ReservationHelper::getPersonMobile($request->user_id)}}</p>

          </td>
          <td class="table-active">固定電話</td>
          <td>
            <p class="tel">{{$request->user_id==999?"":ReservationHelper::getPersonTel($request->user_id)}}</p>
          </td>
        </tr>
      </tbody>
    </table>
  </div>

  <div class="unknown_user mt-5">
    <table class="table table-bordered" style="table-layout: fixed;">
      <thead>
        <tr>
          <th colspan="4">仮で入力する顧客情報</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td class="table-active">会社名・団体名</td>
          <td colspan="3">
            {{ Form::text('unknown_user_company', ($request->unknown_user_company),['class'=>'form-control', 'readonly'] ) }}
          </td>
        </tr>
        <tr>
          <td class="table-active">担当者氏名</td>
          <td>
            {{ Form::text('unknown_user_name', ($request->unknown_user_name),['class'=>'form-control', 'readonly'] ) }}
          </td>
          <td class="table-active">メールアドレス</td>
          <td>
            {{ Form::text('unknown_user_email', ($request->unknown_user_email),['class'=>'form-control', 'readonly'] ) }}
          </td>
        </tr>
        <tr>
          <td class="table-active">携帯番号</td>
          <td>
            {{ Form::text('unknown_user_mobile', ($request->unknown_user_mobile),['class'=>'form-control', 'readonly'] ) }}
          </td>
          <td class="table-active">固定電話</td>
          <td>
            {{ Form::text('unknown_user_tel', ($request->unknown_user_tel),['class'=>'form-control', 'readonly'] ) }}
          </td>
        </tr>
      </tbody>
    </table>
  </div>


  {{-- 以下、詳細入力 --}}
  <div class="container-field bg-white text-dark mt-5 mb-5">
    <div class="row">
      <div class="col">
        <table class="table table-bordered">
          <tbody>
            <tr>
              <td colspan="2">
                <p class="title-icon">
                  <i class="fas fa-info-circle icon-size"></i>仮押え情報
                </p>
              </td>
            </tr>
            <tr>
              <td class="table-active">利用日</td>
              <td>
                {{ Form::text('reserve_date', $request->reserve_date,['class'=>'form-control', 'id'=>'datepicker1'] ) }}
              </td>
            </tr>
            <tr>
              <td class="table-active">会場</td>
              <td>
                <select name="venue_id" id="venue_id">
                  <option value=""></option>
                  @foreach ($venues as $venue)
                  <option value="{{$venue->id}}" {{$venue->id==$request->venue_id?'selected':''}}>
                    {{ReservationHelper::getVenue($venue->id)}}
                  </option>
                  @endforeach

                </select>
                <div class="price_selector">
                  <div>
                    <small>料金体系</small>
                  </div>
                  <div class="form-check form-check-inline">
                    {{Form::radio('price_system', 1, $request->price_system==1?true:false , ['id' => 'price_system_radio1', 'class' => 'form-check-input'])}}
                    <label for="{{'price_system_radio1'}}" class="form-check-label">時間貸し</label>
                    {{Form::radio('price_system', 2, $request->price_system==2?true:false, ['id' => 'price_system_radio2', 'class' => 'form-check-input'])}}
                    <label for="{{'price_system_radio2'}}" class="form-check-label">アクセア仕様</label>
                  </div>
                </div>
              </td>
            </tr>
            <tr>
              <td class="table-active">入室時間</td>
              <td>
                <select name="enter_time" id="enter_time" class="form-control">
                  <option value=""></option>
                  @for ($start = 0*2; $start <=23*2; $start++) <option
                    value="{{date("H:i:s", strtotime("00:00 +". $start * 30 ." minute"))}}" @if (date("H:i:s",
                    strtotime("00:00 +". $start * 30 ." minute"))==$request->enter_time)
                    selected
                    @endif
                    >
                    {{date("H時i分", strtotime("00:00 +". $start * 30 ." minute"))}}
                    </option>
                    @endfor
                </select>
              </td>
            </tr>
            <tr>
              <td class="table-active">退室時間</td>
              <td>
                <select name="leave_time" id="leave_time" class="form-control">
                  <option value=""></option>
                  @for ($start = 0*2; $start <=23*2; $start++) <option
                    value="{{date("H:i:s", strtotime("00:00 +". $start * 30 ." minute"))}}" @if (date("H:i:s",
                    strtotime("00:00 +". $start * 30 ." minute"))==$request->leave_time)
                    selected
                    @endif
                    >
                    {{date("H時i分", strtotime("00:00 +". $start * 30 ." minute"))}}
                    </option>
                    @endfor
                </select>
              </td>
            </tr>

          </tbody>
        </table>

        <table class="table table-bordered board-table">
          <tr>
            <td colspan="2">
              <div class="d-flex align-items-center justify-content-between">
                <p class="title-icon">
                  <i class="fas fa-clipboard icon-size"></i>案内版
                </p>
              </div>
            </td>
          </tr>
          <tr>
            <td class="table-active">案内板</td>
            <td>
              <div class="radio-box">
                <p>
                  {{Form::radio('board_flag',1,$request->board_flag==1?true:false,['id'=>'board_flag'])}}
                  {{Form::label('board_flag',"有り")}}
                </p>
                <p>
                  {{Form::radio('board_flag',0,$request->board_flag==0?true:false,['id'=>'no_board_flag'])}}
                  {{Form::label('no_board_flag',"無し")}}
                </p>
              </div>
            </td>
          </tr>
          <tr>
            <td class="table-active">イベント開始時間</td>
            <td>
              <select name="event_start" id="event_start" class="form-control">
                <option disabled>選択してください</option>
                @for ($start = 0*2; $start <=23*2; $start++) <option
                  value="{{date("H:i:s", strtotime("00:00 +". $start * 30 ." minute"))}}"
                  @if(date("H:i:s",strtotime("00:00 +". $start * 30 ." minute"))<$request->enter_time)
                  disabled
                  @elseif(date("H:i:s", strtotime("00:00 +". $start * 30 ." minute"))>$request->leave_time)
                  disabled
                  @elseif(date("H:i:s",strtotime("00:00 +". $start * 30 ." minute"))==$request->event_start)
                  selected
                  @endif
                  >
                  {{date("H時i分", strtotime("00:00 +". $start * 30 ." minute"))}}</option>
                  @endfor
              </select>
            </td>
          </tr>
          <tr>
            <td class="table-active">イベント終了時間</td>
            <td>
              <select name="event_finish" id="event_finish" class="form-control">
                <option disabled>選択してください</option>
                @for ($start = 0*2; $start <=23*2; $start++) <option
                  value="{{date("H:i:s", strtotime("00:00 +". $start * 30 ." minute"))}}"
                  @if(date("H:i:s",strtotime("00:00 +". $start * 30 ." minute"))<$request->enter_time)
                  disabled
                  @elseif(date("H:i:s", strtotime("00:00 +". $start * 30 ." minute"))>$request->leave_time)
                  disabled
                  @elseif(date("H:i:s",strtotime("00:00 +". $start * 30 ." minute"))==$request->event_finish)
                  selected
                  @endif
                  >
                  {{date("H時i分", strtotime("00:00 +". $start * 30 ." minute"))}}</option>
                  @endfor
              </select> </td>
          </tr>
          <tr>
            <td class="table-active">イベント名称1</td>
            <td>
              {{ Form::text('event_name1', $request->event_name1,['class'=>'form-control'] ) }}
            </td>
          </tr>
          <tr>
            <td class="table-active">イベント名称2</td>
            <td>
              {{ Form::text('event_name2', $request->event_name2,['class'=>'form-control'] ) }}
            </td>
          </tr>
          <tr>
            <td class="table-active">主催者名</td>
            <td>
              {{ Form::text('event_owner', $request->event_owner,['class'=>'form-control'] ) }}
            </td>
          </tr>
        </table>


        <div class="equipemnts">
          <table class="table table-bordered" style="table-layout: fixed;">
            <thead class="accordion-ttl">
              <tr>
                <th colspan="2">
                  <p class="title-icon fw-bolder py-1">
                    <i class="fas fa-wrench icon-size fa-fw"></i>有料備品
                  </p>
                </th>
              </tr>
            </thead>
            <tbody class="accordion-wrap">
              @foreach ($equipments as $key=>$equipment)
              <tr>
                <td class="table-active">
                  {{$equipment->item}}
                </td>
                <td>
                  {{ Form::text('equipment_breakdown'.$key, $request->{'equipment_breakdown'.$key},['class'=>'form-control'] ) }}
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        <div class="services">
          <table class="table table-bordered">
            <thead class="accordion-ttl">
              <tr>
                <th colspan="2">
                  <p class="title-icon fw-bolder py-1">
                    <i class="fas fa-hand-holding-heart icon-size fa-fw"></i>有料サービス
                  </p>
                </th>
              </tr>
            </thead>
            <tbody class="accordion-wrap">
              @foreach ($services as $key=>$service)
              <tr>
                <td class="table-active">
                  {{$service->item}}
                </td>
                <td>
                  <div class="form-check form-check-inline">
                    {{Form::radio('services_breakdown'.$key, 1, $request->{'services_breakdown'.$key}==1?true:false , ['id' => 'service'.$key.'on', 'class' => 'form-check-input'])}}
                    <label for="{{'service'.$key.'on'}}" class="form-check-label">有り</label>
                    {{Form::radio('services_breakdown'.$key, 0, $request->{'services_breakdown'.$key}==0?true:false, ['id' => 'services_breakdown'.$key.'off', 'class' => 'form-check-input'])}}
                    <label for="{{'services_breakdown'.$key.'off'}}" class="form-check-label">無し</label>
                  </div>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>

        @if ($SpVenue->layout==1)
        <div class="layouts">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th colspan='2'>
                  <p class="title-icon py-1">
                    <i class="fas fa-th icon-size fa-fw"></i>レイアウト
                  </p>
                </th>
              </tr>
            </thead>
            <tbody>
              @if ($request->layout_prepare==1)
              <tr>
                <td class="table-active">
                  準備
                </td>
                <td>
                  <div class="form-check form-check-inline">
                    {{Form::radio('layout_prepare', 1, true , ['id' => 'layout_prepare', 'class' => 'form-check-input'])}}
                    <label for="{{'layout_prepare'}}" class="form-check-label">有り</label>
                    {{Form::radio('layout_prepare', 0, false, ['id' => 'no_layout_prepare', 'class' => 'form-check-input'])}}
                    <label for="{{'no_layout_prepare'}}" class="form-check-label">無し</label>
                  </div>
                </td>
              </tr>
              @else
              <tr>
                <td class="table-active">
                  準備
                </td>
                <td>
                  <div class="form-check form-check-inline">
                    {{Form::radio('layout_prepare', 1, false , ['id' => 'layout_prepare', 'class' => 'form-check-input'])}}
                    <label for="{{'layout_prepare'}}" class="form-check-label">有り</label>
                    {{Form::radio('layout_prepare', 0, true, ['id' => 'no_layout_prepare', 'class' => 'form-check-input'])}}
                    <label for="{{'no_layout_prepare'}}" class="form-check-label">無し</label>
                  </div>
                </td>
              </tr>
              @endif
              @if ($request->layout_clean==1)
              <tr>
                <td class="table-active">
                  片付け
                </td>
                <td>
                  <div class="form-check form-check-inline">
                    {{Form::radio('layout_clean', 1, true, ['id' => 'layout_clean', 'class' => 'form-check-input'])}}
                    <label for='layout_clean' class="form-check-label">有り</label>
                    {{Form::radio('layout_clean', 0, false, ['id' => 'no_layout_clean', 'class' => 'form-check-input'])}}
                    <label for='no_layout_clean' class="form-check-label">無し</label>
                  </div>
                </td>
              </tr>
              @else
              <tr>
                <td class="table-active">
                  片付け
                </td>
                <td>
                  <div class="form-check form-check-inline">
                    {{Form::radio('layout_clean', 1, false, ['id' => 'layout_clean', 'class' => 'form-check-input'])}}
                    <label for='layout_clean' class="form-check-label">有り</label>
                    {{Form::radio('layout_clean', 0, true, ['id' => 'no_layout_clean', 'class' => 'form-check-input'])}}
                    <label for='no_layout_clean' class="form-check-label">無し</label>
                  </div>
                </td>
              </tr>
              @endif
            </tbody>
          </table>
        </div>
        @endif


        @if ($SpVenue->luggage_flag==1)
        <div class="luggage">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th colspan='2'>
                  <p class="title-icon">
                    <i class="fas fa-suitcase-rolling icon-size fa-fw"></i>荷物預かり
                  </p>
                </th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td class="table-active">事前に預かる荷物<br>（個数）</td>
                <td>
                  {{ Form::text('luggage_count', $request->luggage_count,['class'=>'form-control'] ) }}
                </td>
              </tr>
              <tr>
                <td class="table-active">事前荷物の到着日<br>午前指定のみ</td>
                <td>
                  {{ Form::text('luggage_arrive', $request->luggage_arrive,['class'=>'form-control','id'=>'datepicker9'] ) }}
                </td>
              </tr>
              <tr>
                <td class="table-active">事後返送する荷物</td>
                <td>
                  {{ Form::text('luggage_return', $request->luggage_return,['class'=>'form-control'] ) }}
                </td>
              </tr>
              <tr>
                <td class="table-active">荷物預かり/返送<br>料金</td>
                <td>
                  {{ Form::text('luggage_price', $request->luggage_price,['class'=>'form-control'] ) }}
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        @endif


        @if ($SpVenue->eat_in_flag==1)
        <div class="eat_in">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th colspan='2'>
                  <p class="title-icon">
                    <i class="fas fa-suitcase-rolling icon-size fa-fw"></i>室内飲食
                  </p>
                </th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>
                  {{Form::radio('eat_in', 1, $request->eat_in==1?true:false , ['id' => 'eat_in'])}}
                  {{Form::label('eat_in',"あり")}}
                </td>
                <td>
                  @if (empty($request->eat_in_prepare))
                  {{Form::radio('eat_in_prepare', 1, false , ['id' => 'eat_in_prepare', 'disabled'])}}
                  {{Form::label('eat_in_prepare',"手配済み")}}
                  {{Form::radio('eat_in_prepare', 2, false , ['id' => 'eat_in_consider','disabled'])}}
                  {{Form::label('eat_in_consider',"検討中")}}
                  @else
                  {{Form::radio('eat_in_prepare', 1, $request->eat_in_prepare==1?true:false , ['id' => 'eat_in_prepare' ])}}
                  {{Form::label('eat_in_prepare',"手配済み")}}
                  {{Form::radio('eat_in_prepare', 2, $request->eat_in_prepare==2?true:false , ['id' => 'eat_in_consider'])}}
                  {{Form::label('eat_in_consider',"検討中")}}
                  @endif
                </td>
              </tr>
              <tr>
                <td>
                  {{Form::radio('eat_in', 0, $request->eat_in==0?true:false , ['id' => 'no_eat_in'])}}
                  {{Form::label('no_eat_in',"なし")}}
                </td>
                <td></td>
              </tr>
            </tbody>
          </table>
        </div>
        @endif


      </div>

      <div class="col">
        <table class="table table-bordered">
          <tbody>
            <tr>
              <td colspan="2">
                <p class="title-icon">
                  <i class="fas fa-user-check icon-size" aria-hidden="true"></i>
                  当日の連絡できる担当者
                </p>
              </td>
            </tr>
            <tr>
              <td class="table-active">
                <label for="ondayName" class=" form_required">氏名</label>
              </td>
              <td>
                {{ Form::text('in_charge', $request->in_charge,['class'=>'form-control'] ) }}
                <p class="is-error-in_charge" style="color: red"></p>
              </td>
            </tr>
            <tr>
              <td class="table-active"><label for="mobilePhone" class=" form_required">携帯番号</label></td>
              <td>
                {{ Form::text('tel', $request->tel,['class'=>'form-control'] ) }}
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
                @if ($request->email_flag!=0)
                <div class="radio-box">
                  <p>
                    {{Form::radio('email_flag', 1, true , ['id' => 'email_flag'])}}
                    <label for="{{'email_flag'}}" class="form-check-label">有り</label>
                  </p>
                  <p>
                    {{Form::radio('email_flag', 0, false, ['id' => 'no_email_flag'])}}
                    <label for="{{'no_email_flag'}}" class="form-check-label">無し</label>
                  </p>
                </div>
                @else
                <div class="radio-box">
                  <p>
                    {{Form::radio('email_flag', 1, false , ['id' => 'email_flag'])}}
                    <label for="{{'email_flag'}}" class="form-check-label">有り</label>
                  </p>
                  <p>
                    {{Form::radio('email_flag', 0, true, ['id' => 'no_email_flag'])}}
                    <label for="{{'no_email_flag'}}" class="form-check-label">無し</label>
                  </p>
                </div>
                @endif
              </td>
            </tr>
          </tbody>
        </table>

        @if ($SpVenue->alliance_flag==1)
        <table class="table table-bordered cost-table">
          <tbody>
            <tr>
              <td colspan="2">
                <p class="title-icon">
                  <i class="fas fa-yen-sign icon-size" aria-hidden="true"></i>売上原価
                </p>
              </td>
            </tr>
            <tr>
              <td class="table-active"><label for="">原価率</label></td>
              <td>
                {{ Form::text('cost', $request->cost,['class'=>'form-control', 'placeholder'=>'入力してください'] ) }}%
              </td>
            </tr>
          </tbody>
        </table>
        @endif

        <table class="table table-bordered note-table">
          <tbody>
            <tr>
              <td colspan="2">
                <p class="title-icon">
                  <i class="fas fa-file-alt icon-size" aria-hidden="true"></i>備考
                </p>
              </td>
            </tr>
            <!-- <td>
              <label for="userNote">申し込みフォーム備考</label>
              {{ Form::textarea('user_details', $request->user_details,['class'=>'form-control', 'placeholder'=>'入力してください'] ) }}
            </td> -->
            </tr>
            <tr>
              <td>
                <label for="adminNote">管理者備考</label>
                {{ Form::textarea('admin_details', $request->admin_details,['class'=>'form-control', 'placeholder'=>'入力してください'] ) }}
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <div class="submit_btn">
    <div class="d-flex justify-content-center">
      {{-- {{Form::submit('計算する', ['class'=>'btn more_btn_lg mx-auto d-block my-5', 'id'=>'check_submit'])}} --}}
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



  <div class="submit_btn">
    <div class="d-flex justify-content-center">
      {{-- 単発仮押えか？一括仮押えか？ --}}
      {{ Form::hidden('judge_count', 1 ) }}
      {{-- ユーザー --}}
      {{ Form::hidden('user_id', $request->user_id ) }}
      {{Form::submit('再計算する', ['class'=>'btn more_btn4_lg mx-auto d-block my-5', 'id'=>'check_submit'])}}
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

  {{Form::close()}}


  {{ Form::open(['url' => 'admin/pre_reservations', 'method'=>'POST', 'id'=>'']) }}
  @csrf

  {{-- 以下、計算結果 --}}
  <div class="container-fluid">
    <div class="bill">
      <div class="bill_head">
        <table class="table bill_table">
          <tr>
            <td>
              <h2 class="text-white">
                請求書No
              </h2>
            </td>
            <td>
              <dl class="ttl_box">
                <dt>合計金額</dt>
                <dd class="total_result">{{number_format($masters)}}円</dd>
              </dl>
            </td>
            <!-- <td>
              <dl class="ttl_box">
                <dt>支払い期日</dt>
                <dd class="total_result">{{ReservationHelper::formatDate($pay_limit)}}</dd>
              </dl>
            </td> -->
          </tr>
          <!-- <tr>
            <td></td>
            <td>
              <div class="bg-white d-flex justify-content-around align-items-center" style="height: 60px;">
                <div>支払い期日</div>
                <div>{{ReservationHelper::formatDate($pay_limit)}}</div>
              </div>
            </td>
          </tr> -->
        </table>
      </div>
      <div class="bill_details">
        <div class="head d-flex">
          <div class="accordion_btn">
            <i class="fas fa-plus bill_icon_size hide"></i>
            <i class="fas fa-minus bill_icon_size"></i>
          </div>
          <div class="billdetails_ttl">
            <h3>
              請求内訳
            </h3>
          </div>
        </div>
        <div class="main">
          <div class="venues billdetails_content">
            <table class="table table-borderless">
              <tr>
                <td>
                  <h4 class="billdetails_content_ttl">
                    会場料
                  </h4>
                </td>
              </tr>
              <tbody class="venue_head">
                <tr>
                  <td>内容</td>
                  <td>単価</td>
                  <td>数量</td>
                  <td>金額</td>
                </tr>
              </tbody>
              @if ($price_details!=0)
              <tbody class="venue_main">
                @if ($price_details[1])
                <tr>
                  <td>{{ Form::text('venue_breakdown_item0', "会場料金",['class'=>'form-control', 'readonly'] ) }} </td>
                  <td>
                    {{ Form::text('venue_breakdown_cost0', $price_details[0]-$price_details[1],['class'=>'form-control', 'readonly'] ) }}
                  </td>
                  <td>
                    {{ Form::text('venue_breakdown_count0', $price_details[3],['class'=>'form-control', 'readonly'] ) }}
                  </td>
                  <td>
                    {{ Form::text('venue_breakdown_subtotal0', $price_details[0]-$price_details[1],['class'=>'form-control', 'readonly'] ) }}
                  </td>
                </tr>
                <tr>
                  <td>{{ Form::text('venue_breakdown_item1', "延長料金",['class'=>'form-control', 'readonly'] ) }} </td>
                  <td>
                    {{ Form::text('venue_breakdown_cost1', $price_details[1],['class'=>'form-control', 'readonly'] ) }}
                  </td>
                  <td>
                    {{ Form::text('venue_breakdown_count1', $price_details[4],['class'=>'form-control', 'readonly'] ) }}
                  </td>
                  <td>
                    {{ Form::text('venue_breakdown_subtotal1', $price_details[1],['class'=>'form-control', 'readonly'] ) }}
                  </td>
                </tr>
                @else
                <tr>
                  <td>{{ Form::text('venue_breakdown_item0', "会場料金",['class'=>'form-control', 'readonly'] ) }} </td>
                  <td>
                    {{ Form::text('venue_breakdown_cost0', $price_details[0],['class'=>'form-control', 'readonly'] ) }}
                  </td>
                  <td>
                    {{ Form::text('venue_breakdown_count0', $price_details[3],['class'=>'form-control', 'readonly'] ) }}
                  </td>
                  <td>
                    {{ Form::text('venue_breakdown_subtotal0', $price_details[0],['class'=>'form-control', 'readonly'] ) }}
                  </td>
                </tr>
                @endif
              </tbody>
              <tbody class="venue_result">
                <tr>
                  <td colspan="2"></td>
                  <td colspan="2">合計
                    {{ Form::text('venue_price', $price_details[0],['class'=>'form-control col-xs-3', 'readonly'] ) }}
                  </td>
                </tr>
              </tbody>
              <!-- <tbody class="venue_discount">
                <tr>
                  <td>割引計算欄</td>
                  <td>
                    <p>
                      割引金額
                    </p>
                    <div class="d-flex">
                      {{ Form::text('venue_number_discount', $request->venue_number_discount?$request->venue_number_discount:'',['class'=>'form-control'] ) }}
                      <p>円</p>
                    </div>
                  </td>
                  <td>
                    <p>
                      割引率
                    </p>
                    <div class="d-flex">
                      {{ Form::text('venue_percent_discount', $request->venue_percent_discount?$request->venue_percent_discount:'',['class'=>'form-control'] ) }}
                      <p>%</p>
                    </div>
                  </td>
                  <td>
                    <input class="btn more_btn venue_discount_btn" type="button" value="計算する">
                  </td>
                </tr>
              </tbody> -->
              @else
              <span class="text-red">※料金体系がないため、手打ちで会場料を入力してください</span>
              <tbody class="venue_main">
                <tr>
                  <td>
                    {{ Form::text('venue_breakdown_item0', '',['class'=>'form-control'] ) }}
                  </td>
                  <td>
                    {{ Form::text('venue_breakdown_cost0', '',['class'=>'form-control'] ) }}
                  </td>
                  <td>
                    {{ Form::text('venue_breakdown_count0', '',['class'=>'form-control'] ) }}
                  </td>
                  <td>
                    {{ Form::text('venue_breakdown_subtotal0', '',['class'=>'form-control'] ) }}
                  </td>
                  <td>
                    <input type="button" value="＋" class="add pluralBtn">
                    <input type="button" value="ー" class="del pluralBtn">
                  </td>
                </tr>
              </tbody>
              <tbody class="venue_result">
                <tr>
                  <td colspan="2"></td>
                  <td colspan="2">合計
                    {{ Form::text('venue_price', '',['class'=>'form-control col-xs-3', 'readonly'] ) }}
                  </td>
                </tr>
              </tbody>
              @endif
            </table>
          </div>

          @if(ReservationHelper::judgeArrayEmpty($item_details)==1||$request->luggage_price)
          <div class="equipment billdetails_content">
            <table class="table table-borderless">
              <tr>
                <td colspan="4">
                  <h4 class="billdetails_content_ttl">
                    有料備品・サービス
                  </h4>
                </td>
              </tr>
              <tbody class="equipment_head">
                <tr>
                  <td>内容</td>
                  <td>単価</td>
                  <td>数量</td>
                  <td>金額</td>
                </tr>
              </tbody>
              <tbody class="equipment_main">
                @foreach ($item_details[1] as $key=>$item)
                <tr>
                  <td>
                    {{ Form::text('equipment_breakdown_item'.$key, $item[0],['class'=>'form-control', 'readonly'] ) }}
                  </td>
                  <td>
                    {{ Form::text('equipment_breakdown_cost'.$key, $item[1],['class'=>'form-control', 'readonly'] ) }}
                  </td>
                  <td>
                    {{ Form::text('equipment_breakdown_count'.$key, $item[2],['class'=>'form-control', 'readonly'] ) }}
                  </td>
                  <td>
                    {{ Form::text('equipment_breakdown_subtotal'.$key, $item[1]*$item[2],['class'=>'form-control', 'readonly'] ) }}
                  </td>
                </tr>
                @endforeach
                @foreach ($item_details[2] as $key=>$item)
                <tr>
                  <td>
                    {{ Form::text('services_breakdown_item'.$key, $item[0],['class'=>'form-control', 'readonly'] ) }}
                  </td>
                  <td>
                    {{ Form::text('services_breakdown_cost'.$key, $item[1],['class'=>'form-control', 'readonly'] ) }}
                  </td>
                  <td>
                    {{ Form::text('services_breakdown_count'.$key, $item[2],['class'=>'form-control', 'readonly'] ) }}
                  </td>
                  <td>
                    {{ Form::text('services_breakdown_subtotal'.$key, $item[1]*$item[2],['class'=>'form-control', 'readonly'] ) }}
                  </td>
                </tr>
                @endforeach
                @if ($request->luggage_price)
                <tr>
                  <td>
                    {{ Form::text('luggage_item', '荷物預かり/返送',['class'=>'form-control', 'readonly'] ) }}
                  </td>
                  <td>
                    {{ Form::text('luggage_cost', $request->luggage_price,['class'=>'form-control', 'readonly'] ) }}
                  </td>
                  <td>
                    {{ Form::text('luggage_count', 1,['class'=>'form-control', 'readonly'] ) }}
                  </td>
                  <td>
                    {{ Form::text('luggage_subtotal', $request->luggage_price,['class'=>'form-control', 'readonly'] ) }}
                  </td>
                </tr>
                @endif
              </tbody>
              <tbody class="equipment_result">
                <tr>
                  <td colspan="2"></td>
                  <td colspan="2">合計
                    {{ Form::text('equipment_price', ($item_details[0]+$request->luggage_price),['class'=>'form-control', 'readonly'] ) }}
                  </td>
                </tr>
              </tbody>

            </table>
          </div>
          @endif


          @if ($SpVenue->layout==1)
          <div class="layout billdetails_content">
            <table class="table table-borderless">
              <tr>
                <td>
                  <h4 class="billdetails_content_ttl">
                    レイアウト
                  </h4>
                </td>
              </tr>
              <tbody class="layout_head">
                <tr>
                  <td>内容</td>
                  <td>単価</td>
                  <td>数量</td>
                  <td>金額</td>
                </tr>
              </tbody>
              <tbody class="layout_main">
                @if ($layouts_details[0])
                <tr>
                  <td>{{ Form::text('layout_prepare_item', "レイアウト準備料金",['class'=>'form-control', 'readonly'] ) }}</td>
                  <td>{{ Form::text('layout_prepare_cost', $layouts_details[0],['class'=>'form-control', 'readonly'] )}}
                  </td>
                  <td>{{ Form::text('layout_prepare_count', 1,['class'=>'form-control', 'readonly'] )}}</td>
                  <td>
                    {{ Form::text('layout_prepare_subtotal', $layouts_details[0],['class'=>'form-control', 'readonly'] )}}
                  </td>
                </tr>
                @endif
                @if ($layouts_details[1])
                <tr>
                  <td>{{ Form::text('layout_clean_item', "レイアウト片付料金",['class'=>'form-control', 'readonly'] ) }}</td>
                  <td>{{ Form::text('layout_clean_cost', $layouts_details[1],['class'=>'form-control', 'readonly'] )}}
                  </td>
                  <td>{{ Form::text('layout_clean_count', 1,['class'=>'form-control', 'readonly'] )}}</td>
                  <td>
                    {{ Form::text('layout_clean_subtotal', $layouts_details[1],['class'=>'form-control', 'readonly'] )}}
                  </td>
                </tr>
                @endif
              </tbody>
              <tbody class="layout_result">
                <tr>
                  <td colspan="2"></td>
                  <td colspan="2">合計
                    {{ Form::text('layout_price',$layouts_details[2] ,['class'=>'form-control', 'readonly'] ) }}
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          @endif



          <div class="bill_total">
            <table class="table text-right">
              <tr>
                <td>小計：</td>
                <td>
                  {{ Form::text('master_subtotal',$masters ,['class'=>'form-control text-right', 'readonly'] ) }}
                </td>
              </tr>
              <tr>
                <td>消費税：</td>
                <td>
                  {{ Form::text('master_tax',ReservationHelper::getTax($masters) ,['class'=>'form-control text-right', 'readonly'] ) }}
                </td>
              </tr>
              <tr>
                <td class="font-weight-bold">合計金額</td>
                <td>
                  {{ Form::text('master_total',ReservationHelper::taxAndPrice($masters) ,['class'=>'form-control text-right', 'readonly'] ) }}
                </td>
              </tr>
            </table>
          </div>
        </div>
      </div>
    </div>

  </div>
</section>

{{-- 単発仮押えか？一括仮押えか？ --}}
{{ Form::hidden('judge_count', 1 ) }}
{{Form::hidden('user_id', $request->user_id)}}
{{Form::hidden('venue_id', $request->venue_id)}}
{{Form::hidden('reserve_date', $request->reserve_date)}}
{{Form::hidden('price_system', $request->price_system)}}
{{Form::hidden('enter_time', $request->enter_time)}}
{{Form::hidden('leave_time', $request->leave_time)}}
{{Form::hidden('board_flag', $request->board_flag)}}
{{Form::hidden('email_flag', $request->email_flag)}}
{{Form::hidden('in_charge', $request->in_charge)}}
{{Form::hidden('tel', $request->tel)}}

{{Form::hidden('event_start', $request->event_start)}}
{{Form::hidden('event_finish', $request->event_finish)}}
{{Form::hidden('event_name1', $request->event_name1)}}
{{Form::hidden('event_name2', $request->event_name2)}}
{{Form::hidden('event_owner', $request->event_owner)}}
{{Form::hidden('luggage_arrive', $request->luggage_arrive)}}
{{Form::hidden('luggage_return', $request->luggage_return)}}
{{Form::hidden('discount_condition', $request->discount_condition)}}
{{Form::hidden('attention', $request->attention)}}
{{Form::hidden('user_details', $request->user_details)}}
{{Form::hidden('admin_details', $request->admin_details)}}

{{Form::hidden('eat_in', $request->eat_in)}}
{{Form::hidden('eat_in_prepare', $request->eat_in_prepare)}}

{{Form::hidden('unknown_user_company', $request->unknown_user_company)}}
{{Form::hidden('unknown_user_name', $request->unknown_user_name)}}
{{Form::hidden('unknown_user_email', $request->unknown_user_email)}}
{{Form::hidden('unknown_user_tel', $request->unknown_user_tel)}}
{{Form::hidden('unknown_user_mobile', $request->unknown_user_mobile)}}


{{Form::submit('登録する', ['class'=>'btn more_btn_lg d-block btn-lg mx-auto my-5', 'id'=>'check_submit'])}}
{{Form::close()}}


<script>
  $(function() {
    $("html,body").animate({
      scrollTop: $('.bill').offset().top
    });

    $(function() {
      // プラスボタンクリック
      $(document).on("click", ".add", function() {
        $(this).parent().parent().clone(true).insertAfter($(this).parent().parent());
        addThisTr('.others .others_main tr', 'others_input_item', 'others_input_cost', 'others_input_count', 'others_input_subtotal');
        addThisTr('.venue_main tr', 'venue_breakdown_item', 'venue_breakdown_cost', 'venue_breakdown_count', 'venue_breakdown_subtotal');
        // 追加時内容クリア
        $(this).parent().parent().next().find('td').find('input, select').eq(0).val('');
        $(this).parent().parent().next().find('td').find('input, select').eq(1).val('');
        $(this).parent().parent().next().find('td').find('input, select').eq(2).val('');
        $(this).parent().parent().next().find('td').find('input, select').eq(3).val('');
      });

      function addThisTr($targetTr, $TItem, $TCost, $TCount, $TSubtotal) {
        var count = $($targetTr).length;
        for (let index = 0; index < count; index++) {
          $($targetTr).eq(index).find('td').eq(0).find('input').attr('name', $TItem + index);
          $($targetTr).eq(index).find('td').eq(1).find('input').attr('name', $TCost + index);
          $($targetTr).eq(index).find('td').eq(2).find('input').attr('name', $TCount + index);
          $($targetTr).eq(index).find('td').eq(3).find('input').attr('name', $TSubtotal + index);
        }
      }

      // マイナスボタンクリック
      $(document).on("click", ".del", function() {
        if ($(this).parent().parent().parent().attr('class') == "others_main") {
          var count = $('.others .others_main tr').length;
          var target = $(this).parent().parent();
          if (target.parent().children().length > 1) {
            target.remove();
          }
          for (let index = 0; index < count; index++) {
            // console.log(index);
            $('.others_main tr').eq(index).find('td').eq(0).find('input').attr('name', 'others_input_item' + index);
            $('.others_main tr').eq(index).find('td').eq(1).find('input').attr('name', 'others_input_cost' + index);
            $('.others_main tr').eq(index).find('td').eq(2).find('input').attr('name', 'others_input_count' + index);
            $('.others_main tr').eq(index).find('td').eq(3).find('input').attr('name', 'others_input_subtotal' + index);
          }
          var re_count = $('.others .others_main tr').length;
          var total_val = 0;
          for (let index2 = 0; index2 < re_count; index2++) {
            var num1 = $('input[name="others_input_cost' + index2 + '"]').val();
            var num2 = $('input[name="others_input_count' + index2 + '"]').val();
            var num3 = $('input[name="others_input_subtotal' + index2 + '"]');
            num3.val(num1 * num2);
            total_val = total_val + Number(num3.val());
          }
          var total_target = $('input[name="others_price"]');
          total_target.val(total_val);

          var venue = $('input[name="venue_price"]').val() ? Number($('input[name="venue_price"]').val()) : 0;
          var equipment = $('input[name="equipment_price"]').val() ? Number($('input[name="equipment_price"]').val()) : 0;
          var layout = $('input[name="layout_price"]').val() ? Number($('input[name="layout_price"]').val()) : 0;
          var others = $('input[name="others_price"]').val() == "" ? 0 : Number($('input[name="others_price"]').val());
          var result = venue + equipment + layout + others;
          var result_tax = Math.floor(result * 0.1);
          $('.total_result').text('').text(result);
          $('input[name="master_subtotal"]').val(result);
          $('input[name="master_tax"]').val(result_tax);
          $('input[name="master_total"]').val(result + result_tax);
        } else if ($(this).parent().parent().parent().attr('class') == "venue_main") {
          var count = $('.venue_main tr').length;
          var target = $(this).parent().parent();
          if (target.parent().children().length > 1) {
            target.remove();
          }
          for (let index = 0; index < count; index++) {
            $('.venue_main tr').eq(index).find('td').eq(0).find('input').attr('name', 'venue_breakdown_item' + index);
            $('.venue_main tr').eq(index).find('td').eq(1).find('input').attr('name', 'venue_breakdown_cost' + index);
            $('.venue_main tr').eq(index).find('td').eq(2).find('input').attr('name', 'venue_breakdown_count' + index);
            $('.venue_main tr').eq(index).find('td').eq(3).find('input').attr('name', 'venue_breakdown_subtotal' + index);
          }
          var re_count = $(' .venue_main tr').length;
          var total_val = 0;
          for (let index2 = 0; index2 < re_count; index2++) {
            var num1 = $('input[name="venue_breakdown_cost' + index2 + '"]').val();
            var num2 = $('input[name="venue_breakdown_count' + index2 + '"]').val();
            var num3 = $('input[name="venue_breakdown_subtotal' + index2 + '"]');
            num3.val(num1 * num2);
            total_val = total_val + Number(num3.val());
          }
          var total_target = $('input[name="venue_price"]');
          total_target.val(total_val);

          var venue = $('input[name="venue_price"]').val() ? Number($('input[name="venue_price"]').val()) : 0;
          var equipment = $('input[name="equipment_price"]').val() ? Number($('input[name="equipment_price"]').val()) : 0;
          var layout = $('input[name="layout_price"]').val() ? Number($('input[name="layout_price"]').val()) : 0;
          var others = $('input[name="others_price"]').val() == "" ? 0 : Number($('input[name="others_price"]').val());
          var result = venue + equipment + layout + others;
          var result_tax = Math.floor(result * 0.1);
          $('.total_result').text('').text(result);
          $('input[name="master_subtotal"]').val(result);
          $('input[name="master_tax"]').val(result_tax);
          $('input[name="master_total"]').val(result + result_tax);
        }
      });
    });
  })

  $(function(){
    $(document).on("click", "input:radio[name='eat_in']", function() {
      var radioTarget=$('input:radio[name="eat_in"]:checked').val();
      if (radioTarget==1) {
        $('input:radio[name="eat_in_prepare"]').prop('disabled',false);
      }else{
        $('input:radio[name="eat_in_prepare"]').prop('disabled',true);
        $('input:radio[name="eat_in_prepare"]').val("");
      }
    })
  })


  $(function(){
    var maxTarget=$('input[name="reserve_date"]').val();
    $('#datepicker9').datepicker({
      dateFormat: 'yy-mm-dd',
      minDate: 0,
      maxDate:maxTarget,
      autoclose: true,
    });
  })

</script>

@endsection