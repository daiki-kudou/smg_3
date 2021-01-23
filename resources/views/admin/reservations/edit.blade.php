@extends('layouts.admin.app')

@section('content')


<link href="{{ asset('/css/template.css') }}" rel="stylesheet">
<script src="{{ asset('/js/template.js') }}"></script>
<script src="{{ asset('/js/edit_ajax.js') }}"></script>


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


{{ Form::model($reservation, ['route'=> ['admin.reservations.update',$reservation->id],'method' => 'PUT' ]) }}
@csrf
<div class="container-field bg-white text-dark">
  <div class="row">
    <div class="col">
      <table class="table table-bordered">
        <tr>
          <td colspan="2">予約情報</td>
        </tr>
        <tr>
          <td class="table-active">利用日</td>
          <td>

            {{ Form::text('reserve_date', date("Y-m-d",strtotime($reservation->reserve_date)) ,['class'=>'form-control', 'id'=>'datepicker1', 'placeholder'=>'入力してください'] ) }}
          </td>
        </tr>
        <tr>
          <td class="table-active">会場</td>
          <td>
            <select id="venues_selector" class=" form-control" name='venue_id'>
              <option value='#'>選択してください</option>
              @foreach ($venues as $venue)
              <option value="{{$venue->id}}" @if ($venue->id==$reservation->venue_id)
                selected
                @endif
                >{{$venue->name_area}}{{$venue->name_bldg}}{{$venue->name_venue}}</option>
              @endforeach
            </select>
            <div class="price_selector">
              <div>
                <small>※料金体系を選択してください</small>
              </div>
              <div class='price_radio_selector'>
                <div class="d-flex justfy-content-start align-items-center">
                  {{ Form::radio('price_system', 1, $reservation->price_system==1?true:false, ['class'=>'mr-2', 'id'=>'price_system_radio1']) }}
                  {{Form::label('price_system_radio1','通常（枠貸）')}}
                </div>
                <div class="d-flex justfy-content-start align-items-center">
                  {{ Form::radio('price_system', 2, $reservation->price_system==2?true:false, ['class'=>'mr-2','id'=>'price_system_radio2']) }}
                  {{Form::label('price_system_radio2','アクセア（時間貸）')}}
                </div>
              </div>
            </div>
          </td>
        </tr>
        <tr>
          <td class="table-active">入室時間</td>
          <td>
            <div>
              <select name="enter_time" id="sales_start" class="form-control">
                <option disabled>選択してください</option>
                @for ($start = 0*2; $start <=23*2; $start++) <option value="{{date("H:i:s", strtotime("00:00 +". $start * 30 ." minute"))}}" @if($reservation->
                  enter_time==(date("H:i:s", strtotime("00:00 +". $start * 30 ." minute"))))
                  selected
                  @endif
                  >
                  {{date("H時i分", strtotime("00:00 +". $start * 30 ." minute"))}}
                  </option>
                  @endfor
              </select>
            </div>
          </td>
        </tr>
        <tr>
          <td class="table-active">退室時間</td>
          <td>
            <div>
              <select name="leave_time" id="sales_finish" class="form-control">
                <option disabled>選択してください</option>
                @for ($start = 0*2; $start <=23*2; $start++) <option value="{{date("H:i:s", strtotime("00:00 +". $start * 30 ." minute"))}}" @if($reservation->
                  leave_time==(date("H:i:s", strtotime("00:00 +". $start * 30 ." minute"))))
                  selected
                  @endif
                  >
                  {{date("H時i分", strtotime("00:00 +". $start * 30 ." minute"))}}</option>
                  @endfor
              </select>
            </div>
          </td>
        </tr>
        <tr>
          <td>案内板</td>
          <td>
            <input type="radio" name="board_flag" value="0" {{$reservation->board_flag==0?'checked':''}}>無し
            <input type="radio" name="board_flag" value="1" {{$reservation->board_flag==1?'checked':''}}>有り
          </td>
        </tr>
        <tr>
          <td class="table-active">イベント開始時間</td>
          <td>
            <div>
              <select name="event_start" id="event_start" class="form-control">
                <option selected disabled>選択してください</option>
                @for ($start = 0*2; $start <=23*2; $start++) <option value="{{date("H:i:s", strtotime("00:00 +". $start * 30 ." minute"))}}" @if($reservation->
                  event_start==(date("H:i:s", strtotime("00:00 +". $start * 30 ." minute"))))
                  selected
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
                @for ($start = 0*2; $start <=23*2; $start++) <option value="{{date("H:i:s", strtotime("00:00 +". $start * 30 ." minute"))}}" @if($reservation->
                  event_finish==(date("H:i:s", strtotime("00:00 +". $start * 30 ." minute"))))
                  selected
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
            {{ Form::text('event_name1',$reservation->event_name1,['class'=>'form-control', 'placeholder'=>'入力してください'] ) }}
          </td>
        </tr>
        <tr>
          <td class="table-active">イベント名称2</td>
          <td>
            {{ Form::text('event_name2',$reservation->event_name2,['class'=>'form-control', 'placeholder'=>'入力してください'] ) }}
          </td>
        </tr>
        <tr>
          <td class="table-active">主催者名</td>
          <td>
            {{ Form::text('event_owner', $reservation->event_owner,['class'=>'form-control', 'placeholder'=>'入力してください'] ) }}
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
          <tbody>
            @foreach ($reservation->venue->equipments as $key=>$equipment)
            <tr>
              <td>
                {{$equipment->item}}
              </td>
              <td>
                <input type="text" class="form-control" name="{{'equipments'.$key}}" @foreach ($reservation->breakdowns
                as $breakdown)
                @if ($breakdown->unit_item==$equipment->item)
                {{print "value='".$breakdown->unit_count."'"}}
                @endif
                @endforeach
                >
              </td>
            </tr>
            @endforeach
          </tbody>
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
          <tbody>

            @foreach ($reservation->venue->services as $key=>$service)
            <tr>
              <td>
                {{$service->item}}
              </td>
              <td>
                <input type='radio' value='0' name='{{'services'.$key}}' checked>無し
                <input type='radio' value='1' name='{{'services'.$key}}' @foreach ($reservation->breakdowns as
                $breakdown)
                @if ($breakdown->unit_item==$service->item)
                checked
                @endif
                @endforeach
                >有り
              </td>
            </tr>
            @endforeach
          </tbody>
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
            @if ($reservation->venue->layout==1)
            <tr>
              <td>レイアウト準備料金</td>
              <td>
                <input type="radio" value="0" name="layout_prepare" checked>無し
                <input type="radio" value="1" name="layout_prepare" @foreach ($reservation->breakdowns as $breakdown)
                @if ($breakdown->unit_item=='レイアウト準備')
                checked
                @endif
                @endforeach
                >有り
              </td>
            </tr>
            <tr>
              <td>レイアウト片付料金</td>
              <td>
                <input type="radio" value="0" name="layout_clean">無し
                <input type="radio" value="1" name="layout_clean" @foreach ($reservation->breakdowns as $breakdown)
                @if ($breakdown->unit_item=='レイアウト片付')
                checked
                @endif
                @endforeach
                >有り
              </td>
            </tr>
            @endif
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
            <tr class='luggage_input_price'>
              <td>事前に預かる荷物<br>（個数）</td>
              <td>
                {{ Form::text('luggage_count', $reservation->luggage_count,['class'=>'form-control luggage_count', 'placeholder'=>'入力してください'] ) }}
              </td>
            </tr>
            <tr class='luggage_input_price'>
              <td>事前荷物の到着日<br>午前指定のみ</td>
              <td>
                {{ Form::text('luggage_arrive', isset($reservation->luggage_arrive)?date('Y-m-d',strtotime($reservation->luggage_arrive)):'',['class'=>'form-control luggage_arrive', 'placeholder'=>'入力してください'] ) }}
              </td>
            </tr>
            <tr class='luggage_input_price'>
              <td>事後返送する荷物</td>
              <td>
                {{ Form::text('luggage_return', $reservation->luggage_return,['class'=>'form-control luggage_return', 'placeholder'=>'入力してください'] ) }}
              </td>
            </tr>
            <tr class='luggage_input_price'>
              <td>荷物預かり/返送<br>料金</td>
              <td>
                {{ Form::text('luggage_price', '',['class'=>'form-control luggage_price', 'placeholder'=>'入力してください'] ) }}

                {{-- @foreach ($reservation->breakdowns as $breakdown)
                @if ($breakdown->unit_item=='荷物預かり/返送')
                {{ Form::text('luggage_price', $breakdown->unit_cost,['class'=>'form-control luggage_price', 'placeholder'=>'入力してください'] ) }}
                @else
                {{ Form::text('luggage_price', '',['class'=>'form-control luggage_price', 'placeholder'=>'入力してください'] ) }}
                @endif
                @endforeach --}}
              </td>
            </tr>
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
            <td class="table-active"><label for="user_id">会社名・団体名</label></td>
            <td>
              <select class="form-control" name="user_id" id="user_select">
                <option disabled selected>選択してください</option>
                @foreach ($users as $user)
                <option value="{{$user->id}}" @if($reservation->user_id==$user->id)
                  selected
                  @endif
                  >{{$user->company}} | {{$user->first_name}}{{$user->last_name}} | {{$user->email}}</option>
                @endforeach
              </select>
            </td>
          </tr>
          <tr>
            <td class="table-active"><label for="name">担当者氏名</label></td>
            <td>
              <p class="selected_person">
              </p>
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
            <td class="table-active"><label for="ondayName">氏名</label></td>
            <td>
              {{ Form::text('in_charge', $reservation->in_charge,['class'=>'form-control', 'placeholder'=>'入力してください'] ) }}
            </td>
          </tr>
          <tr>
            <td class="table-active"><label for="mobilePhone">携帯番号</label></td>
            <td>
              {{ Form::text('tel', $reservation->tel,['class'=>'form-control', 'placeholder'=>'入力してください'] ) }}
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
              <input type="radio" name="email_flag" value="0" {{$reservation->email_flag==0?'checked':''}}>無し
              <input type="radio" name="email_flag" value="1" {{$reservation->email_flag==1?'checked':''}}>有り
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
            {{ Form::number('cost', $reservation->cost,['class'=>'form-control sales_percentage', 'placeholder'=>'入力してください'] ) }}%
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
            {{ Form::textarea('discount_condition', $reservation->discount_condition,['class'=>'form-control', 'placeholder'=>'入力してください'] ) }}
          </td>
        </tr>
        <tr class="caution">
          <td>
            <label for="caution">注意事項</label>
            {{ Form::textarea('attention', $reservation->attention,['class'=>'form-control', 'placeholder'=>'入力してください'] ) }}
          </td>
        </tr>
        <tr>
          <td>
            <label for="userNote">顧客情報の備考</label>
            {{ Form::textarea('user_details', $reservation->user_details,['class'=>'form-control', 'placeholder'=>'入力してください'] ) }}
          </td>
        </tr>
        <tr>
          <td>
            <label for="adminNote">管理者備考</label>
            {{ Form::textarea('admin_details', $reservation->admin_details,['class'=>'form-control', 'placeholder'=>'入力してください'] ) }}
          </td>
        </tr>
      </table>
    </div>
  </div>
</div>

{{-- 丸岡さんカスタム --}}
<section class="bill-wrap section-wrap">
  <div class="bill-bg">
    <div class="bill-box">
      <h3 class="row">会場料</h3>
      <dl class="row bill-box_wrap">
        <div class="col-3 bill-box_cell">
          <dt>会場料金</dt>
          <dd class="venue_price"></dd>
          {{ Form::hidden('venue_price', '', ['class'=>'venue_price']) }}
        </div>
        <div class="col-3 bill-box_cell">
          <dt>延長料金</dt>
          <dd class="extend"></dd>
          {{ Form::hidden('extend', '', ['class'=>'extend']) }}
        </div>
        <div class="col-6 bill-box_cell">
          <dt>会場料金合計</dt>
          <dd class="text-right venue_extend" style="font-size: 20px"></dd>
        </div>
        <div class="col-6">
          <div class="row">
            <div class="col-4 bill-box_cell cell-gray">
              <p>割引率</p>
            </div>
            <div class="col-5 bill-box_cell">
              <dd class="text-right d-flex">
                <input type="text" name="venue_discount_percent" class="form-control venue_discount_percent" id="venue_discount_percent" value="{{$reservation->bills()->first()->venue_discount_percent}}" min=0><span>%</span>
              </dd>
            </div>
            <div class="col-3 bill-box_cell">
              <p class="text-right">割引金額: <span class="percent_result"></span></p>
              {{ Form::hidden('percent_result', '', ['class'=>'percent_result']) }}
            </div>
          </div>
        </div>
        <div class="col-6">
          <div class="row">
            <div class="col-4 bill-box_cell cell-gray">
              <p>割引料金</p>
            </div>
            <div class="col-5 bill-box_cell">
              <p class="text-right">
                <input type="text" name="venue_dicsount_number" class="form-control venue_dicsount_number" id="venue_dicsount_number" min=0 value="{{$reservation->bills()->first()->venue_dicsount_number}}">
              </p>
            </div>
            <div class="col-3 bill-box_cell">
              <p class="text-right">割引率: <span class="number_result"></span>%</p>
              {{ Form::hidden('number_result', '', ['class'=>'number_result']) }}
            </div>
          </div>
        </div>
        <div class="col-12 bill-box_cell d-flex justify-content-end">
          <span class="font-weight-bold mr-3">割引後 会場料金合計</span>
          <p class="text-right after_discount_price"></p>円
          {{ Form::hidden('after_discount_price', '', ['class'=>'after_discount_price']) }}

        </div>
      </dl>
      <!-- 料金内訳-------------------------------------------------------------- -->
      <h3 class="row" style="background: #F3F3F3;color:black">料金内訳</h3>
      <div class="row venue_price_details">
        <table class="table table-bordered">
          <thead>
            <tr>
              <td>内容</td>
              <td>単価</td>
              <td>数量</td>
              <td>金額</td>
            </tr>
          </thead>
          <tbody></tbody>
        </table>
      </div>
      <div class="row bill-box_wrap price-sum bill-box_cell flex-column">
        <p class="text-right"><span class="font-weight-bold">小計</span>
          <span class="venue_subtotal"></span>円
          {{ Form::hidden('venue_subtotal', '', ['class'=>'venue_subtotal']) }}
        </p>
        <p class="text-right"><span>消費税</span>
          <span class="venue_tax"></span>
          {{ Form::hidden('venue_tax', '', ['class'=>'venue_tax']) }}
          円
        </p>
        <p class="text-right"><span class="font-weight-bold">請求総額</span>
          <span class="venue_total"></span>
          {{ Form::hidden('venue_total', '', ['class'=>'venue_total']) }}
          円
        </p>
      </div>
    </div>
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
            <td><input type="text" class="form-control"></td>
            <td><input type="text" class="form-control"></td>
            <td><input type="text" class="form-control" id='handinput_venue'></td>
          </tr>
          <tr>
            <td>延長料金</td>
            <td><input type="text" class="form-control"></td>
            <td><input type="text" class="form-control"></td>
            <td><input type="text" class="form-control" id="handinput_extend"></td>
          </tr>
          <tr>
            <td>割引</td>
            <td><input type="text" class="form-control"></td>
            <td><input type="text" class="form-control"></td>
            <td><input type="text" class="form-control" id="handinput_discount"></td>
          </tr>
        </tbody>
      </table>
      <div class="text-right">
        <p>小計 <span id="handinput_subtotal"></span></p>
        <p>消費税<span id="handinput_tax"></span></p>
        <p>請求総額<span id="handinput_total"></span></p>
      </div>
    </div>
  </div>

  <!-- 請求内容 終わり---------------------------- -->
  <!-- 請求内容----------- -->
  <div class="bill-box">
    <h3 class="row">備品その他</h3>
    <dl class="row bill-box_wrap">
      <div class="col-3 bill-box_cell">
        <dt>有料備品料金</dt>
        <dd><span class="selected_equipments_price"></span>円</dd>
        {{ Form::hidden('selected_equipments_price', '', ['class'=>'selected_equipments_price']) }}
      </div>
      <div class="col-3 bill-box_cell">
        <dt>有料サービス料金</dt>
        <dd><span class="selected_services_price"></span>円</dd>
        {{ Form::hidden('selected_services_price', '', ['class'=>'selected_services_price']) }}
      </div>
      <div class="col-3 bill-box_cell">
        <dt>荷物預かり/返送</dt>
        <dd class="d-flex align-items-center">
        <dd><span class="selected_luggage_price"></span>円</dd>
        {{ Form::hidden('selected_luggage_price', '', ['class'=>'selected_luggage_price']) }}
        </dd>
      </div>
      <div class="col-3 bill-box_cell">
        <dt>有料備品＆有料サービス合計</dt>
        <dd class="text-right"><span class="selected_items_total"></span>円</dd>
        {{ Form::hidden('selected_items_total', '', ['class'=>'selected_items_total']) }}
      </div>
      <div class="col-6">
        <div class="row">
          <div class="col-4 bill-box_cell cell-gray">
            <p>割引料金</p>
          </div>
          <div class="col-5 bill-box_cell">
            <p class="text-right">
              <input type="text" name="discount_item" class="form-control discount_item" id="price" value="{{$reservation->bills()->first()->discount_item}}">
            </p>
          </div>
          <div class="col-3 bill-box_cell text-right">
            <p>割引率:<span class="item_discount_percent"></span>%</p>
            {{ Form::hidden('item_discount_percent', '', ['class'=>'item_discount_percent']) }}
          </div>
        </div>
      </div>
      <div class="col-6 bill-box_cell text-right">
        <p><span class="font-weight-bold mr-3">割引後 有料備品＆有料サービス合計</span> <span class="items_discount_price"></span> 円</p>
        {{ Form::hidden('items_discount_price', '', ['class'=>'items_discount_price']) }}
      </div>
    </dl>
    <!-- 料金内訳-------------------------------------------------------------- -->
    <div class="bill-list">
      <h3 class="row">料金内訳</h3>
      <div class="row items_equipments">
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
          </tbody>
        </table>
      </div>
      <div class="row bill-box_wrap price-sum bill-box_cell flex-column">
        <p class="text-right"><span class="font-weight-bold">小計</span>
          <span class="items_subtotal"></span>
          {{ Form::hidden('items_subtotal', '', ['class'=>'items_subtotal']) }}
          円
        </p>
        <p class="text-right"><span>消費税</span> <span class="items_tax"></span>
          {{ Form::hidden('items_tax', '', ['class'=>'items_tax']) }}
          円
        </p>
        <p class="text-right"><span class="font-weight-bold">請求総額</span>
          <span class="all_items_total"></span>
          {{ Form::hidden('all_items_total', '', ['class'=>'all_items_total']) }}
          円
        </p>
      </div>
    </div>
    <!-- 料金内訳 終わり---------------------------- -->
  </div>
  <!-- 請求内容 終わり---------------------------- -->
  {{-- レイアウト --}}
  <div class="layout_price_list" style="margin-bottom: 100px">
    <h3 style="font-weight: bold;font-size: 16px;background: #35A7A7;color: #fff;margin-bottom: 0;padding: 0.8em;">レイアウト
    </h3>
    <div class="border">
      <div class="d-flex" style="height: 70px">
        <div style="width: 33%">レイアウト準備料金： <p class="layout_prepare_result"></p>
          {{ Form::hidden('layout_prepare_result', '', ['class'=>'layout_prepare_result']) }}
        </div>
        <div style="width: 33%">レイアウト片付料金： <p class="layout_clean_result"></p>
          {{ Form::hidden('layout_clean_result', '', ['class'=>'layout_clean_result']) }}
        </div>
        <div style="width:34px%">レイアウト変更合計： <p class="layout_total"></p>
          {{ Form::hidden('layout_total', '', ['class'=>'layout_total']) }}
        </div>
      </div>
      <div class="d-flex" style="height: 70px">
        <div style="width: 33%">割引料金
          <input type="text" class="layout_discount d-block" name="layout_discount" value="{{$reservation->bills()->first()->layout_discount}}">
        </div>
        <div style="width: 33%">割引率：<p class="layout_discount_percent"><span>%</span></p>
          {{ Form::hidden('layout_discount_percent', '', ['class'=>'layout_discount_percent']) }}
        </div>
        <div style="width: 34%">割引後レイアウト変更合計：<p class="after_duscount_layouts"></p>
          {{ Form::hidden('after_duscount_layouts', '', ['class'=>'after_duscount_layouts']) }}
        </div>
      </div>
    </div>
    <div class="selected_layouts">
      <table class="table table-bordered">
        <thead>
          <tr>
            <td>内容</td>
            <td>単価</td>
            <td>数量</td>
            <td>金額</td>
          </tr>
        </thead>
        <tbody></tbody>
      </table>
    </div>

    <div style="margin-top: 50px;" class="text-right">
      小計：<p class="layout_subtotal"></p>
      {{ Form::hidden('layout_subtotal', '', ['class'=>'layout_subtotal']) }}
      消費税：<p class="layout_tax"></p>
      {{ Form::hidden('layout_tax', '', ['class'=>'layout_tax']) }}
      合計金額：<p class="layout_total_amount"></p>
      {{ Form::hidden('layout_total_amount', '', ['class'=>'layout_total_amount']) }}
    </div>
  </div>
  {{-- レイアウト終わり --}}

  <!-- 請求書内容変更----------- -->
  <div class="bill-box">
    <h3 class="row">請求書内容</h3>
    <dl class="row bill-box_wrap">
      <div class="col-6 bill-box_cell">
        <dt><label for="billCompany">請求書の会社名</label></dt>
        <dd>
          {{ Form::text('bill_company', $reservation->user()->first()->company, ['class'=>'form-control', 'id'=>'billCompany']) }}
        </dd>
      </div>
      <div class="col-6 bill-box_cell">
        <dt><label for="billCustomer">請求書の担当者名</label></dt>
        <dd>
          {{ Form::text('bill_person', $reservation->user()->first()->first_name.$reservation->user()->first()->last_name, ['class'=>'form-control', 'id'=>'billCustomer']) }}
        </dd>
      </div>
      <div class="col-6 bill-box_cell">
        <dt><label for="billDate">請求日</label></dt>
        <dd>
          {{ Form::text('bill_created_at', date('Y-m-d',strtotime($reservation->bill_created_at)), ['class'=>'form-control', 'id'=>'datepicker4']) }}
        </dd>
      </div>
      <div class="col-6 bill-box_cell">
        <dt><label for="billDue">支払期日</label></dt>
        <dd>
          {{ Form::text('bill_pay_limit', date('Y-m-d',strtotime($reservation->bill_pay_limit)), ['class'=>'form-control', 'id'=>'datepicker5']) }}
        </dd>
      </div>
      <div class="col-12 bill-box_cell">
        <dt><label for="billNote">備考</label></dt>
        <dd>
          {{ Form::textarea('bill_remark', $reservation->bill_remark, ['class'=>'form-control']) }}
        </dd>
      </div>
    </dl>
  </div>
  <!-- 請求書内容変更 終わり---------------------------- -->


  <dl class="row bill-box_wrap total-sum">
    <div class="col-3 bill-box_cell">
      <dt>合計請求総額</dt>
    </div>
    <div class="col-3 bill-box_cell">
      <dt>合計額</dt>
      <dd> <span class="all-total-without-tax"></span>
        {{ Form::hidden('sub_total', '', ['class'=>'all-total-without-tax']) }}
        円
      </dd>
    </div>
    <div class="col-3 bill-box_cell">
      <dt>消費税</dt>
      <dd> <span class="all-total-tax"></span>
        {{ Form::hidden('tax', '', ['class'=>'all-total-tax']) }}
        円
      </dd>
    </div>
    <div class="col-3 bill-box_cell">
      <dt>税込総請求額</dt>
      <dd class="text-right"> <span class="all-total-amout"></span>
        {{ Form::hidden('total', '', ['class'=>'all-total-amout']) }}
        円
      </dd>
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

{{-- 小計 --}}
{{-- {{ Form::hidden('sub_total', isset($request)?$request->sub_total:'', ['id'=>'sub_total']) }} --}}
{{-- 税金 --}}
{{-- {{ Form::hidden('tax', isset($request)?$request->tax:'', ['id'=>'tax']) }} --}}
{{-- 総合計 --}}
{{-- {{ Form::hidden('total', isset($request)?$request->total:'', ['id'=>'total']) }} --}}





{{Form::submit('送信', ['class'=>'btn btn-primary mx-auto', 'id'=>'check_submit'])}}



{{ Form::close() }}



@endsection