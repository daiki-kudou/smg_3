@extends('layouts.admin.app')
@section('content')


<link href="{{ asset('/css/template.css') }}" rel="stylesheet">
<script src="{{ asset('/js/template.js') }}"></script>
<script src="{{ asset('/js/ajax.js') }}"></script>
<script src="{{ asset('/js/validation.js') }}"></script>


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

<div class="container-field mt-3">
  <div class="float-right">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active">{{ Breadcrumbs::render(Route::currentRouteName()) }}</li>
      </ol>
    </nav>
  </div>
  <h1 class="mt-3 mb-5">予約　新規登録</h1>
  <hr>
</div>

{{Form::open(['url' => 'admin/reservations/create/check', 'method' => 'POST', 'id'=>'reservationCreateForm'])}}
@csrf
<div class="container-field bg-white text-dark">
  <div class="row">
    <div class="col">
      <table class="table table-bordered">
        <tr>
          <td colspan="2">予約情報</td>
        </tr>
        <tr>
          <td class="table-active form_required">利用日</td>
          <td>
            {{ Form::text('reserve_date', isset($request)?$request->reserve_date:'' ,['class'=>'form-control', 'id'=>'datepicker1', 'placeholder'=>'入力してください'] ) }}
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
                @if ($request->venue_id==$venue->id)
                selected
                @endif
                @endif
                >{{$venue->name_area}}{{$venue->name_bldg}}{{$venue->name_venue}}</option>
              @endforeach
            </select>
            <p class="is-error-venue_id" style="color: red"></p>
            <div class="price_selector">
              <div>
                <small>※料金体系を選択してください</small>
              </div>
              <div class='price_radio_selector'>
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
                <option disabled selected>選択してください</option>
                @for ($start = 0*2; $start <=23*2; $start++) <option
                  value="{{date("H:i:s", strtotime("00:00 +". $start * 30 ." minute"))}}" @if (isset($request))
                  @if($request->enter_time==(date("H:i:s", strtotime("00:00 +". $start * 30 ." minute"))))
                  selected
                  @endif
                  @endif
                  >
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
                <option disabled selected>選択してください</option>
                @for ($start = 0*2; $start <=23*2; $start++) <option
                  value="{{date("H:i:s", strtotime("00:00 +". $start * 30 ." minute"))}}" @if (isset($request))
                  @if($request->leave_time==(date("H:i:s", strtotime("00:00 +". $start * 30 ." minute"))))
                  selected
                  @endif
                  @endif
                  >
                  {{date("H時i分", strtotime("00:00 +". $start * 30 ." minute"))}}</option>
                  @endfor
              </select>
              <p class="is-error-leave_time" style="color: red"></p>
            </div>
          </td>
        </tr>
        <tr>
          <td>案内板</td>
          <td>
            <input type="radio" name="board_flag" value="0"
              {{isset($request->board_flag)?$request->board_flag==0?'checked':'':'checked',}}>無し
            <input type="radio" name="board_flag" value="1"
              {{isset($request->board_flag)?$request->board_flag==1?'checked':'':'',}}>有り
          </td>
        </tr>
        <tr>
          <td class="table-active">イベント開始時間</td>
          <td>
            <div>
              <select name="event_start" id="event_start" class="form-control">
                <option selected disabled>選択してください</option>
                @for ($start = 0*2; $start <=23*2; $start++) <option
                  value="{{date("H:i:s", strtotime("00:00 +". $start * 30 ." minute"))}}" @if (isset($request))
                  @if($request->event_start==(date("H:i:s", strtotime("00:00 +". $start * 30 ." minute"))))
                  selected
                  @endif
                  @endif
                  >
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
                <option selected disabled>選択してください</option>
                @for ($start = 0*2; $start <=23*2; $start++) <option
                  value="{{date("H:i:s", strtotime("00:00 +". $start * 30 ." minute"))}}" @if (isset($request))
                  @if($request->event_finish==(date("H:i:s", strtotime("00:00 +". $start * 30 ." minute"))))
                  selected
                  @endif
                  @endif
                  >
                  {{date("H時i分", strtotime("00:00 +". $start * 30 ." minute"))}}</option>
                  @endfor
              </select>
            </div>
          </td>
        </tr>
        <tr>
          <td class="table-active">イベント名称1</td>
          <td>
            {{ Form::text('event_name1',isset($request)?$request->event_name1:'',['class'=>'form-control', 'placeholder'=>'入力してください'] ) }}
          </td>
        </tr>
        <tr>
          <td class="table-active">イベント名称2</td>
          <td>
            {{-- <input type="text" name="event_name2"> --}}
            {{ Form::text('event_name2', isset($request)?$request->event_name2:'',['class'=>'form-control', 'placeholder'=>'入力してください'] ) }}
          </td>
        </tr>
        <tr>
          <td class="table-active">主催者名</td>
          <td>
            {{-- <input type="text" name="event_owner"> --}}
            {{ Form::text('event_owner', isset($request)?$request->event_owner:'',['class'=>'form-control', 'placeholder'=>'入力してください'] ) }}
          </td>
        </tr>
      </table>
      <div class="equipemnts">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th colspan="2">
                <div class="d-flex justify-content-between align-items-center">
                  有料備品
                  <i class="fas fa-plus icon_plus hide"></i>
                  <i class="fas fa-minus icon_minus"></i>
                </div>
              </th>
            </tr>
          </thead>
          <tbody></tbody>
        </table>
      </div>
      <div class="services">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th colspan="2">
                <div class="d-flex justify-content-between align-items-center">
                  有料サービス
                  <i class="fas fa-plus icon_plus hide"></i>
                  <i class="fas fa-minus icon_minus"></i>
                </div>
              </th>
            </tr>
          </thead>
          <tbody></tbody>
        </table>
      </div>
      <div class='layouts'>
        <table class='table table-bordered'>
          <thead>
            <tr>
              <th colspan='2'>レイアウト</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
      <div class='luggage'>
        <table class='table table-bordered'>
          <thead>
            <tr>
              <th colspan='2'>荷物預かり</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
      <div class="price_details">
      </div>
      <div id='calculate' class="btn btn-primary">計算する！！！！</div>
    </div>
    {{-- 右側 --}}
    <div class="col">
      <div class="client_mater">　
        <table class="table table-bordered name-table">
          <tr>
            <td colspan="2">
              <div class="d-flex align-items-center justify-content-between">
                <p class="title-icon">
                  <i class="far fa-id-card fa-2x fa-fw"></i>顧客情報
                </p>
                <p><a class="more_btn bg-green" href="">顧客詳細</a></p>
              </div>
            </td>
          </tr>
          <tr>
            <td class="table-active"><label for="user_id" class=" form_required">会社名/団体名</label></td>
            <td>
              <select class="form-control" name="user_id" id="user_select">
                <option disabled selected>選択してください</option>
                @foreach ($users as $user)
                <option value="{{$user->id}}" @if (isset($request)) @if($request->user_id==$user->id)
                  selected
                  @endif
                  @endif
                  >{{$user->company}} | {{$user->first_name}}{{$user->last_name}} | {{$user->email}}</option>
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
        </table>
        <table class="table table-bordered oneday-table">
          <tr>
            <td colspan="2">
              <p class="title-icon">
                <i class="fas fa-user-check fa-2x fa-fw"></i>当日の連絡できる担当者
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
        </table>
      </div>
      <table class="table table-bordered mail-table">
        <tr>
          <td colspan="2">
            <p class="title-icon">
              <i class="fas fa-envelope fa-2x fa-fw"></i>利用後の送信メール
            </p>
          </td>
        </tr>
        <tr>
          <td class="table-active"><label for="email_flag">送信メール</label></td>
          <td>
            <div class="radio-box">
              <input type="radio" name="email_flag" value="0" checked="checked">無し
              <input type="radio" name="email_flag" value="1">有り
            </div>
          </td>
        </tr>
      </table>
      <table class="table table-bordered sale-table">
        <tr>
          <td colspan="2">
            <p class="title-icon">
              <i class="fas fa-yen-sign fa-2x fa-fw"></i>売上原価（提携会場を選択した場合、提携会場で設定した原価率が適応されます）
            </p>
          </td>
        </tr>
        <tr>
          <td class="table-active"><label for="cost">原価率</label></td>
          <td class="d-flex align-items-center">
            {{-- <input class="form-control sales_percentage" name="sale" type="text" id="sale">%</td> --}}
            {{ Form::number('cost', old('cost'),['class'=>'form-control sales_percentage', 'placeholder'=>'入力してください'] ) }}%
        </tr>
      </table>
      <table class="table table-bordered note-table">
        <tr>
          <td colspan="2">
            <p class="title-icon">
              <i class="fas fa-envelope fa-2x fa-fw"></i>備考
            </p>
          </td>
        </tr>
        <tr>
          <td>
            <p>
              <input type="checkbox" id="discount" checked>
              <label for="discount">割引条件</label>
            </p>
            {{ Form::textarea('discount_condition', old('discount_condition'),['class'=>'form-control', 'placeholder'=>'入力してください'] ) }}
          </td>
        </tr>
        <tr class="caution">
          <td>
            <label for="caution">注意事項</label>
            {{ Form::textarea('attention', old('attention'),['class'=>'form-control', 'placeholder'=>'入力してください'] ) }}
          </td>
        </tr>
        <tr>
          <td>
            <label for="userNote">顧客情報の備考</label>
            {{ Form::textarea('user_details', old('user_details'),['class'=>'form-control', 'placeholder'=>'入力してください'] ) }}
          </td>
        </tr>
        <tr>
          <td>
            <label for="adminNote">管理者備考</label>
            {{ Form::textarea('admin_details', old('admin_details'),['class'=>'form-control', 'placeholder'=>'入力してください'] ) }}
          </td>
        </tr>
      </table>
    </div>
  </div>
</div>

{{-- 丸岡さんカスタム --}}
<section class="bill-wrap section-wrap">
  <div class="bill-bg">
    <div class="bill-box" style="border: solid 1px rgba(0,0,0,0.2);">
      <div class="venue_price_details">
        <table class="table table-bordered" style="table-layout:fixed;">
          <thead>
            <tr>
              <th colspan='4' style="background: #35A7A7; color:white;">会場料</th>
            </tr>
            <tr>
              <th colspan='1'>
                会場料金
                {{ Form::text('venue_price', '', ['class'=>'venue_price form-control', 'readonly']) }}
              </th>
              <th colspan='1'>
                延長料金
                {{ Form::text('extend', '', ['class'=>'extend form-control', 'readonly']) }}
              </th>
              <th colspan='2'>
                会場料金合計
                {{ Form::text('venue_extend', '', ['class'=>'venue_extend form-control text-left', 'readonly']) }}
              </th>
            </tr>
            <tr>
              <th colspan="1">
                割引率
                {{ Form::text('venue_discount_percent', '', ['class'=>'venue_discount_percent form-control', 'id'=>'venue_discount_percent' ,'min'=>'0']) }}
              </th>
              <th colspan="1">割引金額
                {{ Form::text('percent_result', '', ['class'=>'percent_result form-control', 'readonly']) }}
              </th>
              <th colspan="1">
                割引料金
                {{ Form::text('venue_dicsount_number', '', ['class'=>'venue_dicsount_number form-control', 'id'=>'venue_dicsount_number' ,'min'=>'0']) }}
              </th>
              <th colspan="1">
                割引率
                {{ Form::text('number_result', '', ['class'=>'number_result form-control', 'readonly']) }}
              </th>
            </tr>
            <tr>
              <th colspan='4'>割引後　会場料金合計
                {{ Form::text('after_discount_price', '', ['class'=>'after_discount_price form-control', 'readonly']) }}
              </th>
            </tr>
            <tr>
              <th colspan=4 style="background: gray; color:white;">料金内訳</th>
            </tr>
          </thead>
          <tbody class="table table-striped"></tbody>
        </table>
      </div>
      <table style="table-layout:fixed;" class="table table-bordered mb-0">
        <tr>
          <td>小計{{ Form::text('venue_subtotal', '', ['class'=>'venue_subtotal form-control', 'readonly']) }}</td>
          <td>消費税{{ Form::text('venue_tax', '', ['class'=>'venue_tax form-control', 'readonly']) }}</td>
          <td>請求総額{{ Form::text('venue_total', '', ['class'=>'venue_total form-control', 'readonly']) }}</td>
        </tr>
      </table>
    </div>

    {{-- 手打ち --}}
    <div class="hand_input hide">
      <h3 style="font-weight: bold;font-size: 16px;background: #840A01;color: #fff;margin-bottom: 0;padding: 0.8em;">
        会場料（手入力）</h3>
      <div class="hand_input_details">
        <table class="table table-bordered">
          <thead>
            <tr>
              <td>内容</td>
              <td>単価</td>
              <td>数量</td>
              <td>金額</td>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>会場料</td>
              <td>
                {{ Form::text('hand_input_venueprice', '', ['class'=>'form-control']) }}
              </td>
              <td>
                {{ Form::text('hand_input_count', '', ['class'=>'form-control']) }}
              </td>
              <td>
                {{ Form::text('hand_input_subtotal', '', ['class'=>'form-control', 'id'=>'handinput_venue']) }}
              </td>
            </tr>
            <tr>
              <td>延長料金</td>
              <td>
                {{ Form::text('hand_input_extendprice', '', ['class'=>'form-control']) }}
              </td>
              <td>
                {{ Form::text('hand_input_extendcount', '', ['class'=>'form-control']) }}
              </td>
              <td>
                {{ Form::text('hand_input_extendsubtotal', '', ['class'=>'form-control', 'id'=>'handinput_extend']) }}
              </td>
            </tr>
            <tr>
              <td>割引</td>
              <td>
                {{ Form::text('hand_input_discountprice', '', ['class'=>'form-control']) }}
              </td>
              <td>
                {{ Form::text('hand_input_discountcount', '', ['class'=>'form-control']) }}
              </td>
              <td>
                {{ Form::text('hand_input_discountsubtotal', '', ['class'=>'form-control','id'=>'handinput_discount']) }}
              </td>
            </tr>
          </tbody>
        </table>
        <div class="text-right">
          <p>小計
            {{ Form::text('handinput_subtotal', '', ['class'=>'form-control text-right', 'id'=>'handinput_subtotal', 'readonly']) }}
          </p>
          <p>消費税
            {{ Form::text('handinput_tax', '', ['class'=>'form-control text-right', 'id'=>'handinput_tax', 'readonly']) }}
          </p>
          <p>請求総額
            {{ Form::text('handinput_total', '', ['class'=>'form-control text-right', 'id'=>'handinput_total', 'readonly']) }}
          </p>
        </div>
      </div>
    </div>

    <!-- 請求内容 終わり---------------------------- -->
    <!-- 請求内容----------- -->
    <div class="bill-box" style="border: solid 1px rgba(0,0,0,0.2);">
      <div class="items_equipments">
        <table class="table table-bordered" style="table-layout:fixed;">
          <thead>
            <tr>
              <th colspan='4' style="background: #35A7A7; color:white;">備品その他</th>
            </tr>
            <tr>
              <th colspan='1'>
                有料備品料金
                {{ Form::text('selected_equipments_price', '', ['class'=>'selected_equipments_price form-control', 'readonly']) }}
              </th>
              <th colspan='1'>
                有料サービス料金
                {{ Form::text('selected_services_price', '', ['class'=>'selected_services_price form-control', 'readonly']) }}
              </th>
              <th colspan='1'>
                荷物預かり/返送
                {{ Form::text('selected_luggage_price', '', ['class'=>'selected_luggage_price form-control text-left', 'readonly']) }}
              </th>
              <th colspan='1'>
                有料備品＆有料サービス合計
                {{ Form::text('selected_items_total', '', ['class'=>'selected_items_total form-control text-left', 'readonly']) }}
              </th>
            </tr>
            <tr>
              <th colspan="2">
                割引料金
                {{ Form::text('discount_item', '', ['class'=>'discount_item form-control', 'id'=>'price' ,'min'=>'0']) }}
              </th>
              <th colspan="2">
                割引率
                {{ Form::text('item_discount_percent', '', ['class'=>'item_discount_percent form-control', 'readonly']) }}
              </th>
            </tr>
            <tr>
              <th colspan='4'>割引後　会場料金合計
                {{ Form::text('items_discount_price', '', ['class'=>'items_discount_price form-control', 'readonly']) }}
              </th>
            </tr>
            <tr>
              <th colspan=4 style="background: gray; color:white;">料金内訳</th>
            </tr>
          </thead>
          <tbody class="table table-striped"></tbody>
        </table>
      </div>
      <table style="table-layout:fixed;" class="table table-bordered mb-0">
        <tr>
          <td>小計{{ Form::text('items_subtotal', '', ['class'=>'items_subtotal form-control', 'readonly']) }}</td>
          <td>消費税{{ Form::text('items_tax', '', ['class'=>'items_tax form-control', 'readonly']) }}</td>
          <td>請求総額{{ Form::text('all_items_total', '', ['class'=>'all_items_total form-control', 'readonly']) }}</td>
        </tr>
      </table>
    </div>

    {{-- レイアウト --}}
    <div class="bill-box" style="border: solid 1px rgba(0,0,0,0.2);">
      <div class="selected_layouts">
        <table class="table table-bordered" style="table-layout:fixed;">
          <thead>
            <tr>
              <th colspan='4' style="background: #35A7A7; color:white;">レイアウト</th>
            </tr>
            <tr>
              <th colspan='1'>
                レイアウト準備料金
                {{ Form::text('layout_prepare_result', '', ['class'=>'layout_prepare_result form-control', 'readonly']) }}
              </th>
              <th colspan='1'>
                レイアウト片付料金
                {{ Form::text('layout_clean_result', '', ['class'=>'layout_clean_result form-control', 'readonly']) }}
              </th>
              <th colspan='1'>
                レイアウト変更合計
                {{ Form::text('layout_total', '', ['class'=>'layout_total form-control text-left', 'readonly']) }}
              </th>
            </tr>
            <tr>
              <th colspan="2">
                割引料金
                {{ Form::text('layout_discount', '', ['class'=>'layout_discount form-control' ,'min'=>'0']) }}
              </th>
              <th colspan="2">
                割引率
                {{ Form::text('layout_discount_percent', '', ['class'=>'layout_discount_percent form-control', 'readonly']) }}
              </th>
            </tr>
            <tr>
              <th colspan='4'>割引後レイアウト変更合計
                {{ Form::text('after_duscount_layouts', '', ['class'=>'after_duscount_layouts form-control', 'readonly']) }}
              </th>
            </tr>
            <tr>
              <th colspan=4 style="background: gray; color:white;">料金内訳</th>
            </tr>
          </thead>
          <tbody class="table table-striped"></tbody>
        </table>
      </div>
      <table style="table-layout:fixed;" class="table table-bordered mb-0">
        <tr>
          <td>小計{{ Form::text('layout_subtotal', '', ['class'=>'layout_subtotal form-control', 'readonly']) }}</td>
          <td>消費税{{ Form::text('layout_tax', '', ['class'=>'layout_tax form-control', 'readonly']) }}</td>
          <td>請求総額{{ Form::text('layout_total_amount', '', ['class'=>'layout_total_amount form-control', 'readonly']) }}
          </td>
        </tr>
      </table>
    </div>
    {{-- レイアウト終わり --}}



    <dl class="row bill-box_wrap total-sum">
      <div class="col-3 bill-box_cell">
        <dt>合計請求総額</dt>
      </div>
      <div class="col-3 bill-box_cell">
        <dt>合計額</dt>
        <dd> <span class="all-total-without-tax"></span>
          {{ Form::hidden('sub_total', '', ['class'=>'all-total-without-tax']) }}
          円</dd>
      </div>
      <div class="col-3 bill-box_cell">
        <dt>消費税</dt>
        <dd> <span class="all-total-tax"></span>
          {{ Form::hidden('tax', '', ['class'=>'all-total-tax']) }}
          円</dd>
      </div>
      <div class="col-3 bill-box_cell">
        <dt>税込総請求額</dt>
        <dd class="text-right"> <span class="all-total-amout"></span>
          {{ Form::hidden('total', '', ['class'=>'all-total-amout']) }}
          円</dd>
      </div>
    </dl>
  </div>
</section>


{{ Form::hidden('payment_limit',isset($request)?$request->payment_limit:'')}}
{{ Form::hidden('paid', isset($request)?$request->paid:0 ) }} {{--デフォ0で未入金--}}
{{ Form::hidden('reservation_status', isset($request)?$request->reservation_status:1 ) }}
{{-- ※注意　管理者からの予約は予約ステータスが1。予約確認中 --}}
{{ Form::hidden('double_check_status', isset($request)?$request->double_check_status:0 ) }}

{{ Form::hidden('bill_company', isset($request)?$request->bill_company:'' ) }}
{{ Form::hidden('bill_person', isset($request)?$request->bill_person:'' ) }}
{{ Form::hidden('bill_created_at', isset($request)?$request->bill_created_at:date('Y-m-d')) }}
{{ Form::hidden('bill_pay_limit', isset($request)?$request->bill_pay_limit:'' ) }}

{{Form::submit('送信', ['class'=>'btn btn-primary mx-auto', 'id'=>'check_submit'])}}

{{Form::close()}}





@endsection