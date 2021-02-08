@extends('layouts.admin.app')
@section('content')

<h1>仲介会社　予約 計算</h1>

<link href="{{ asset('/css/template.css') }}" rel="stylesheet">
{{-- <script src="{{ asset('/js/template.js') }}"></script> --}}
<script src="{{ asset('/js/ajax.js') }}"></script>
{{-- <script src="{{ asset('/js/validation.js') }}"></script> --}}

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

<script>
  $(function() {
    $("html,body").animate({
      scrollTop: $('.bill').offset().top
    });

    $(function() {
      // プラスボタンクリック
      $(document).on("click", ".add", function() {
        $(this).parent().parent().clone(true).insertAfter($(this).parent().parent());
        addThisTr('.others .others_main tr', 'others_input_item', 'others_input_cost', 'others_input_count','others_input_subtotal');
                // 追加時内容クリア
        $(this).parent().parent().next().find('td').find('input, select').eq(0).val('');
        $(this).parent().parent().next().find('td').find('input, select').eq(1).val('');
      });

      function addThisTr($targetTr, $TItem, $TCost,$TCount, $TSubtotal){
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
        if ($(this).parent().parent().parent().attr('class')=="others_main") {
          var count = $('.others .others_main tr').length;
          var target = $(this).parent().parent();
          if (target.parent().children().length > 1) {
            target.remove();
          }
          for (let index = 0; index < count; index++) {
            // console.log(index);
            $('.others_main tr').eq(index).find('td').eq(0).find('input').attr('name', 'others_input_item' + index);
            $('.others_main tr').eq(index).find('td').eq(1).find('input').attr('name', 'others_input_cost' + index);
          }
        }
      });
    });
  })
</script>

<div id="fullOverlay">
  <div class="frame_spinner">
    <div class="spinner-border text-primary " role="status">
      <span class="sr-only hide">Loading...</span>
    </div>
  </div>
</div>

{{Form::open(['url' => 'admin/agents_reservations/calculate', 'method' => 'POST', 'id'=>'agentReservationCreateForm'])}}
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
            {{ Form::text('reserve_date', $requests['reserve_date'] ,['class'=>'form-control', 'id'=>'datepicker1', 'placeholder'=>'入力してください'] ) }}
            <p class="is-error-reserve_date" style="color: red"></p>
          </td>
        </tr>
        <tr>
          <td class="table-active form_required">会場</td>
          <td>
            <select id="venues_selector" class=" form-control" name='venue_id'>
              <option value='#' disabled selected>選択してください</option>
              @foreach ($venues as $venue)
              <option value="{{$venue->id}}" @if ($requests['venue_id']==$venue->id)
                selected
                @endif
                >
                {{$venue->name_area}}{{$venue->name_bldg}}{{$venue->name_venue}}</option>
              @endforeach
            </select>
            <p class="is-error-venue_id" style="color: red"></p>
            <div class="price_selector">
              <div>
                <small>※料金体系を選択してください</small>
              </div>
              <div class='price_radio_selector'>
                <div class="d-flex justfy-content-start align-items-center">
                  {{ Form::radio('price_system', 1, $requests['price_system']==1?true:false, ['class'=>'mr-2', 'id'=>'price_system_radio1']) }}
                  {{Form::label('price_system_radio1','通常（枠貸）')}}
                </div>
                <div class="d-flex justfy-content-start align-items-center">
                  {{ Form::radio('price_system', 2, $requests['price_system']==2?true:false, ['class'=>'mr-2','id'=>'price_system_radio2']) }}
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
                @for ($start = 0*2; $start <=23*2; $start++) <option
                  value="{{date("H:i:s", strtotime("00:00 +". $start * 30 ." minute"))}}"
                  @if(!empty($requests['enter_time'])) @if($requests['enter_time']==date("H:i:s", strtotime("00:00
                  +".$start * 30 ." minute"))) selected @endif @endif>
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
                @for ($start = 0*2; $start <=23*2; $start++) <option
                  value="{{date("H:i:s", strtotime("00:00 +". $start * 30 ." minute"))}}"
                  @if(!empty($requests['leave_time'])) @if($requests['leave_time']==date("H:i:s", strtotime("00:00
                  +".$start * 30 ." minute"))) selected @endif @endif>
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
            {{ Form::radio('board_flag', 0, $requests['board_flag']==0?true:false, ['class'=>'mr-2', 'id'=>'board_flag1']) }}
            {{Form::label('board_flag1','無し')}}
            {{ Form::radio('board_flag', 1, $requests['board_flag']==1?true:false, ['class'=>'mr-2', 'id'=>'board_flag2']) }}
            {{Form::label('board_flag2','有り')}}
          </td>
        </tr>
        <tr>
          <td class="table-active">イベント開始時間</td>
          <td>
            <div>
              <select name="event_start" id="event_start" class="form-control">
                <option disabled>選択してください</option>
                @for ($start = 0*2; $start <=23*2; $start++) <option
                  value="{{date("H:i:s", strtotime("00:00 +". $start * 30 ." minute"))}}"
                  @if(!empty($requests['event_start'])) @if($requests['event_start']==date("H:i:s", strtotime("00:00 +".
                  $start * 30 ." minute"))) selected @endif @endif>
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
                @for ($start = 0*2; $start <=23*2; $start++) <option
                  value="{{date("H:i:s", strtotime("00:00 +". $start * 30 ." minute"))}}"
                  @if(!empty($requests['event_finish'])) @if($requests['event_finish']==date("H:i:s", strtotime("00:00
                  +". $start * 30 ." minute"))) selected @endif @endif>
                  {{date("H時i分", strtotime("00:00 +". $start * 30 ." minute"))}}</option>
                  @endfor
              </select>
            </div>
          </td>
        </tr>
        <tr>
          <td class="table-active">イベント名称1</td>
          <td>
            {{ Form::text('event_name1',$requests['event_name1'],['class'=>'form-control', 'placeholder'=>'入力してください'] ) }}

          </td>
        </tr>
        <tr>
          <td class="table-active">イベント名称2</td>
          <td>
            {{ Form::text('event_name2',$requests['event_name2'],['class'=>'form-control', 'placeholder'=>'入力してください'] ) }}
          </td>
        </tr>
        <tr>
          <td class="table-active">主催者名</td>
          <td>
            {{ Form::text('event_owner',$requests['event_owner'],['class'=>'form-control', 'placeholder'=>'入力してください'] ) }}
          </td>
        </tr>
      </table>
      <div class="equipemnts">
        <table class="table table-bordered" style="table-layout: fixed;">
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
            @foreach ($equipments as $key=>$equipment)
            <tr>
              <td>{{$equipment->item}}</td>
              <td>
                @if (!empty($requests['equipment_breakdown'.$key]))
                {{ Form::text('equipment_breakdown'.$key,$requests['equipment_breakdown'.$key],['class'=>'form-control', 'placeholder'=>'入力してください'] ) }}
                @else
                {{ Form::text('equipment_breakdown'.$key,0,['class'=>'form-control', 'placeholder'=>'入力してください'] ) }}
                @endif
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
            @foreach ($services as $key=>$service)
            <tr>
              <td>{{$service->item}}</td>
              <td>
                @if (!empty($requests['services_breakdown'.$key]))
                <div class="form-check form-check-inline">
                  {{Form::radio('services_breakdown'.$key, 1,true , ['id' => 'service'.$key.'on', 'class' => 'form-check-input'])}}
                  <label for="{{'service'.$key.'on'}}" class="form-check-label">有り</label>
                  {{Form::radio('services_breakdown'.$key, 0, false, ['id' => 'service'.$key.'off', 'class' => 'form-check-input'])}}
                  <label for="{{'service'.$key.'off'}}" class="form-check-label">無し</label>
                </div>
                @else
                <div class="form-check form-check-inline">
                  {{Form::radio('services_breakdown'.$key, 1,false , ['id' => 'service'.$key.'on', 'class' => 'form-check-input'])}}
                  <label for="{{'service'.$key.'on'}}" class="form-check-label">有り</label>
                  {{Form::radio('services_breakdown'.$key, 0, true, ['id' => 'service'.$key.'off', 'class' => 'form-check-input'])}}
                  <label for="{{'service'.$key.'off'}}" class="form-check-label">無し</label>
                </div>
                @endif
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

            @if ($requests['layout_prepare']==1)
            <tr>
              <td>レイアウト準備</td>
              <td>
                <div class="form-check form-check-inline">
                  {{Form::radio('layout_prepare', 1, true, ['id' => 'layout_prepare', 'class' => 'form-check-input'])}}
                  <label for='layout_prepare' class="form-check-label">有り</label>
                  {{Form::radio('layout_prepare', 0, false, ['id' => 'no_layout_prepare', 'class' => 'form-check-input'])}}
                  <label for='no_layout_prepare' class="form-check-label">無し</label>
                </div>
              </td>
            </tr>
            @else
            <tr>
              <td>レイアウト準備</td>
              <td>
                <div class="form-check form-check-inline">
                  {{Form::radio('layout_prepare', 1, false, ['id' => 'layout_prepare', 'class' => 'form-check-input'])}}
                  <label for='layout_prepare' class="form-check-label">有り</label>
                  {{Form::radio('layout_prepare', 0, true, ['id' => 'no_layout_prepare', 'class' => 'form-check-input'])}}
                  <label for='no_layout_prepare' class="form-check-label">無し</label>
                </div>
              </td>
            </tr>
            @endif
            @if ($requests['layout_clean']==1)
            <tr>
              <td>レイアウト準備</td>
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
              <td>レイアウト準備</td>
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
      <div class='luggage'>
        <table class='table table-bordered'>
          <thead>
            <tr>
              <th colspan='2'>荷物預かり</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>事前に預かる荷物<br>（個数）</td>
              <td>
                {{ Form::text('luggage_count', $requests['luggage_count']?$requests['luggage_count']:0,['class'=>'form-control'] ) }}
              </td>
            </tr>
            <tr>
              <td>事前荷物の到着日<br>午前指定のみ</td>
              <td>
                {{ Form::text('luggage_arrive', $requests['luggage_arrive']?$requests['luggage_arrive']:0,['class'=>'form-control'] ) }}
              </td>
            </tr>

            <tr>
              <td>事後返送する荷物</td>
              <td>
                {{ Form::text('luggage_return', $requests['luggage_return']?$requests['luggage_return']:0,['class'=>'form-control'] ) }}
              </td>
            </tr>
            <tr>
              <td>荷物預かり/返送<br>料金</td>
              <td>
                {{ Form::text('luggage_price', $requests['luggage_price']?$requests['luggage_price']:0,['class'=>'form-control'] ) }}
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="price_details">
      </div>
    </div>
    {{-- 右側 --}}
    <div class="col">
      <div class="client_mater">　
        <table class="table table-bordered name-table">
          <tr>
            <td colspan="2">
              <div class="d-flex align-items-center justify-content-between">
                <p class="title-icon">
                  <i class="far fa-id-card fa-2x fa-fw"></i>仲介会社情報
                </p>
                <p><a class="more_btn bg-green" href="">仲介会社詳細</a></p>
              </div>
            </td>
          </tr>
          <tr>
            <td class="table-active">
              <label for="agent_id" class=" form_required">サービス名称</label></td>
            <td>
              <select class="form-control" name="agent_id" id="agent_select">
                <option disabled selected>選択してください</option>
                @foreach ($agents as $agent)
                <option value="{{$agent->id}}" @if ($agent->id==$requests['agent_id'])
                  selected
                  @endif
                  >{{$agent->name}} |{{$agent->person_firstname}}{{$agent->person_lastname}}
                  | {{$agent->email}}
                </option>
                @endforeach
              </select>
              <p class="is-error-user_id" style="color: red"></p>
            </td>
          </tr>
          <tr>
            <td class="table-active"><label for="name" class=" form_required">担当者氏名<br></label></td>
            <td>
              <p class="selected_person">{{ReservationHelper::getAgentPerson($requests['agent_id'])}}</p>
            </td>
          </tr>
        </table>
        <table class="table table-bordered oneday-table">
          <tr>
            <td colspan="2">
              <p class="title-icon">
                <i class="fas fa-user-check fa-2x fa-fw"></i>仲介会社の顧客
              </p>
            </td>
          </tr>
          <tr>
            <td class="table-active">
              <label for="enduser_company" class="">会社名・団体名</label>
            </td>
            <td>
              {{ Form::text('enduser_company', $requests['enduser_company'],['class'=>'form-control', 'placeholder'=>'入力してください','id'=>'enduser_company'] ) }}
            </td>
          </tr>
          <tr>
            <td class="table-active">
              <label for="enduser_incharge" class="">担当者氏名</label>
            </td>
            <td>
              {{ Form::text('enduser_incharge', $requests['enduser_incharge'],['class'=>'form-control', 'placeholder'=>'入力してください', 'id'=>'enduser_incharge'] ) }}
            </td>
          </tr>
          <tr>
            <td class="table-active">
              <label for="enduser_address" class=" ">住所</label>
            </td>
            <td>
              {{ Form::text('enduser_address', $requests['enduser_address'],['class'=>'form-control', 'placeholder'=>'入力してください', 'id'=>'enduser_address'] ) }}
            </td>
          </tr>
          <tr>
            <td class="table-active">
              <label for="enduser_tel" class="">電話番号</label>
            </td>
            <td>
              {{ Form::text('enduser_tel', $requests['enduser_tel'],['class'=>'form-control', 'placeholder'=>'入力してください', 'maxlength'=>13, 'id'=>'enduser_tel'] ) }}
            </td>
          </tr>
          <tr>
            <td class="table-active">
              <label for="enduser_mail" class=" ">メールアドレス</label>
            </td>
            <td>
              {{ Form::text('enduser_mail', $requests['enduser_mail'],['class'=>'form-control', 'placeholder'=>'入力してください', 'maxlength'=>13,'id'=>'enduser_mail'] ) }}
            </td>
          </tr>
          <tr>
            <td class="table-active">
              <label for="enduser_attr" class="">利用者属性</label>
            </td>
            <td>
              {{ Form::text('enduser_attr', $requests['enduser_attr'],['class'=>'form-control', 'placeholder'=>'入力してください', 'maxlength'=>13, 'id'=>'enduser_attr'] ) }}
            </td>
          </tr>
        </table>
      </div>
      <table class="table table-bordered sale-table">
        <tr>
          <td colspan="2">
            <p class="title-icon">
              <i class="fas fa-yen-sign fa-2x fa-fw"></i>仲介会社の顧客への支払い料
            </p>
          </td>
        </tr>
        <tr>
          <td class="table-active form_required">
            <label for="enduser_charge ">支払い料</label>
          </td>
          <td class="d-flex align-items-center">
            {{ Form::text('enduser_charge', $requests['enduser_charge'],['class'=>'form-control sales_percentage', 'placeholder'=>'入力してください'] ) }}円
          </td>
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
        <tr class="caution">
          <td>
            <label for="caution">注意事項</label>
            {{ Form::textarea('attention', $requests['attention'],['class'=>'form-control', 'placeholder'=>'入力してください'] ) }}
          </td>
        </tr>
        <tr>
          <td>
            <label for="userNote">顧客情報の備考</label>
            {{ Form::textarea('user_details', $requests['user_details'],['class'=>'form-control', 'placeholder'=>'入力してください'] ) }}
          </td>
        </tr>
        <tr>
          <td>
            <label for="adminNote">管理者備考</label>
            {{ Form::textarea('admin_details', $requests['admin_details'],['class'=>'form-control', 'placeholder'=>'入力してください'] ) }}
          </td>
        </tr>
      </table>
    </div>
  </div>
</div>

{{Form::submit('再計算する', ['class'=>'btn btn-danger mx-auto d-block btn-lg', 'id'=>'check_submit'])}}

{{Form::close()}}


{{-- 以下、詳細内訳 --}}
{{ Form::open(['url' => 'admin/agents_reservations/check', 'method'=>'POST', 'id'=>'agents_calculate_form']) }}
@csrf
<div class="container-fluid">
  <div class="bill">
    <div class="bill_head">
      <table class="table" style="table-layout: fixed">
        <tr>
          <td>
            <h1 class="text-white">
              請求書No
            </h1>
          </td>
          <td style="font-size: 16px;">
            <div class="bg-white d-flex justify-content-around align-items-center" style="height: 60px;">
              <div>合計金額</div>
              <div class="total_result">{{number_format($price)}}円
              </div>
            </div>
          </td>
        </tr>
        <tr>
          <td></td>
          <td style="font-size: 16px;">
            <div class="bg-white d-flex justify-content-around align-items-center" style="height: 60px;">
              <div>支払い期日</div>
              <div>{{ReservationHelper::formatDate($payment_limit)}}
              </div>
            </div>
          </td>
        </tr>
      </table>
    </div>
    <div class="bill_details">
      <div class="head d-flex">
        <div style="width: 80px; background:gray;" class="d-flex justify-content-center align-items-center">
          <i class="fas fa-plus fa-3x hide" style="color: white;"></i>
          <i class="fas fa-minus fa-3x" style="color: white;"></i>
        </div>
        <div style="font-size: 30px; width:200px;" class="d-flex justify-content-center align-items-center">
          <p>
            請求内訳
          </p>
        </div>
      </div>
      <div class="main">
        <div class="venues" style="padding-top: 80px; width:90%; margin:0 auto;">
          <table class="table table-borderless">
            <tr>
              <td>
                <h1>
                  ■会場料
                </h1>
              </td>
            </tr>
            <tbody class="venue_head">
              <tr>
                <td>内容</td>
                <td>数量</td>
              </tr>
            </tbody>
            <tbody class="venue_main">
              <tr>
                <td>{{ Form::text('venue_breakdown_item0', "会場料金",['class'=>'form-control', 'readonly'] ) }} </td>
                <td>{{ Form::text('venue_breakdown_count0', $usage_hours."h",['class'=>'form-control', 'readonly'] ) }}
                </td>
              </tr>
            </tbody>
            {{-- <tbody class="venue_result">
              <tr>
                <td colspan="2"></td>
                <td colspan="2">合計
                </td>
              </tr>
            </tbody> --}}
            {{-- <tbody class="venue_discount">
              <tr>
                <td>割引計算欄</td>
                <td>
                  <p>
                    割引金額
                  </p>
                  <div class="d-flex">

                    <p>円</p>
                  </div>
                </td>
                <td>
                  <p>
                    割引率
                  </p>
                  <div class="d-flex">
                    <p>%</p>
                  </div>
                </td>
                <td>
                  <input class="btn btn-success venue_discount_btn" type="button" value="計算する">
                </td>
              </tr>
            </tbody> --}}
          </table>
        </div>

        {{-- 以下備品 --}}
        <div class="equipment" style="padding-top: 80px; width:90%; margin:0 auto;">
          <table class="table table-borderless">
            <tr>
              <td>
                <h1>
                  ■有料備品・サービス
                </h1>
              </td>
            </tr>
            <tbody class="equipment_head">
              <tr>
                <td>内容</td>
                <td>数量</td>
              </tr>
            </tbody>
            <tbody class="equipment_main">
              @foreach ($equipments as $key=>$equipment)
              @if ($requests['equipment_breakdown'.$key]!=0)
              <tr>
                <td>
                  {{ Form::text('equipment_breakdown_item'.$key, $equipment->item,['class'=>'form-control', 'readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('equipment_breakdown_count'.$key, $requests['equipment_breakdown'.$key],['class'=>'form-control', 'readonly'] ) }}
                </td>
              </tr>
              @endif
              @endforeach
              @foreach ($services as $key=>$service)
              @if ($requests['services_breakdown'.$key]!=0)
              <tr>
                <td>
                  {{ Form::text('service_breakdown_item'.$key, $service->item,['class'=>'form-control', 'readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('service_breakdown_count'.$key, $requests['services_breakdown'.$key],['class'=>'form-control', 'readonly'] ) }}
                </td>
              </tr>
              @endif
              @endforeach
              @if (!empty($requests['luggage_price']))
              <tr>
                <td>
                  {{ Form::text('luggage_item', '荷物預かり/返送',['class'=>'form-control', 'readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('luggage_count', $requests['luggage_price'],['class'=>'form-control', 'readonly'] ) }}
                </td>
              </tr>

              @endif
            </tbody>
          </table>
        </div>
        {{-- 以下、レイアウト --}}
        <div class="layout" style="padding-top: 80px; width:90%; margin:0 auto;">
          <table class="table table-borderless">
            <tr>
              <td>
                <h1>
                  ■レイアウト
                </h1>
              </td>
            </tr>
            <tbody class="layout_head">
              <tr>
                <td>内容</td>
                <td>単価</td>
              </tr>
            </tbody>
            <tbody class="layout_main">
              @if ($requests['layout_prepare']!=0)
              <tr>
                <td>{{ Form::text('layout_prepare_item', "レイアウト準備料金",['class'=>'form-control', 'readonly'] ) }}</td>
                <td>{{ Form::text('layout_prepare_count', 1,['class'=>'form-control', 'readonly'] )}}</td>
              </tr>
              @endif
              @if ($requests['layout_clean']!=0)
              <tr>
                <td>{{ Form::text('layout_clean_item', "レイアウト片付料金",['class'=>'form-control', 'readonly'] ) }}</td>
                <td>{{ Form::text('layout_clean_count', 1,['class'=>'form-control', 'readonly'] )}}</td>
              </tr>
              @endif
            </tbody>
          </table>
        </div>

        {{-- 以下、その他 --}}
        <div class="others" style="padding: 80px 0px 80px 0px; width:90%; margin:0 auto;">
          <table class="table table-borderless">
            <tr>
              <td>
                <h1>
                  ■その他
                </h1>
              </td>
            </tr>
            <tbody class="others_head">
              <tr>
                <td>内容</td>
                <td>数量</td>
                <td>追加/削除</td>
              </tr>
            </tbody>
            <tbody class="others_main">
              <tr>
                <td>{{ Form::text('others_input_item0', '',['class'=>'form-control'] ) }}</td>
                <td>{{ Form::text('others_input_count0', '',['class'=>'form-control'] ) }}</td>
                <td>
                  <input type="button" value="＋" class="add pluralBtn">
                  <input type="button" value="ー" class="del pluralBtn">
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        {{-- 以下、総合計 --}}
        <div class="bill_total d-flex justify-content-end"
          style="padding: 80px 0px 80px 0px; width:90%; margin:0 auto;">
          <div style="width: 60%;">
            <table class="table text-right" style="table-layout: fixed; font-size:16px;">
              <tr>
                <td>小計：</td>
                <td>
                  {{ Form::text('master_subtotal',$price ,['class'=>'form-control text-right', 'readonly'] ) }}
                </td>
              </tr>
              <tr>
                <td>消費税：</td>
                <td>
                  {{ Form::text('master_tax',ReservationHelper::getTax($price) ,['class'=>'form-control text-right', 'readonly'] ) }}

                </td>
              </tr>
              <tr>
                <td class="font-weight-bold">合計金額</td>
                <td>
                  {{ Form::text('master_total',ReservationHelper::taxAndPrice($price) ,['class'=>'form-control text-right', 'readonly'] ) }}

                </td>
              </tr>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- 以下、請求情報 --}}
  <div class="information">
    <div class="information_details">
      <div class="head d-flex">
        <div style="width: 80px; background:gray;" class="d-flex justify-content-center align-items-center">
          <i class="fas fa-plus fa-3x hide" style="color: white;"></i>
          <i class="fas fa-minus fa-3x" style="color: white;"></i>
        </div>
        <div style="font-size: 30px; width:200px;" class="d-flex justify-content-center align-items-center">
          <p>
            請求書情報
          </p>
        </div>
      </div>
      <div class="main">
        <div class="informations" style="padding-top: 20px; width:90%; margin:0 auto;">
          <table class="table">
            <tr>
              <td>請求日：</td>
              <td>支払期日 {{ Form::text('pay_limit', $payment_limit,['class'=>'form-control', 'id'=>'datepicker6'] ) }}
              </td>
            </tr>
            <tr>
              <td>
                請求書宛名{{ Form::text('pay_company', $agents->find($requests['agent_id'])->name,['class'=>'form-control'] ) }}
              </td>
              <td>
                担当者{{ Form::text('bill_person', ReservationHelper::getAgentPerson($requests['agent_id']),['class'=>'form-control'] ) }}
              </td>
            </tr>
            <tr>
              <td colspan="2">請求書備考{{ Form::textarea('bill_remark', '',['class'=>'form-control'] ) }}</td>
            </tr>
          </table>
        </div>
      </div>
    </div>
  </div>

  {{-- 以下、入金情報 --}}
  <div class="paid">
    <div class="paid_details">
      <div class="head d-flex">
        <div style="width: 80px; background:#ff782d;" class="d-flex justify-content-center align-items-center">
        </div>
        <div style="font-size: 30px; width:200px;" class="d-flex justify-content-center align-items-center">
          <p>
            入金情報
          </p>
        </div>
      </div>
      <div class="main">
        <div class="paids" style="padding-top: 20px; width:90%; margin:0 auto;">
          <table class="table" style="table-layout: fixed;">
            <tr>
              <td>入金状況{{Form::select('paid', ['未入金', '入金済み'],null,['class'=>'form-control'])}}</td>
              <td>
                入金日{{ Form::text('pay_day', null,['class'=>'form-control', 'id'=>'datepicker7'] ) }}
              </td>
            </tr>
            <tr>
              <td>振込人名{{ Form::text('pay_person', null,['class'=>'form-control'] ) }}</td>
              <td>入金額{{ Form::text('payment', null,['class'=>'form-control'] ) }}</td>
            </tr>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
{{ Form::hidden('venue_id', $requests['venue_id'] )}}
{{ Form::hidden('reserve_date', $requests['reserve_date'] )}}
{{ Form::hidden('agent_id', $requests['agent_id'] )}}
{{ Form::hidden('price_system', $requests['price_system'] )}}
{{ Form::hidden('enter_time', $requests['enter_time'] )}}
{{ Form::hidden('leave_time', $requests['leave_time'] )}}
{{ Form::hidden('board_flag', $requests['board_flag'] )}}
{{ Form::hidden('event_start', !empty($requests['event_start'])?$requests['event_start']:"" )}}
{{ Form::hidden('event_finish', $requests['event_finish'] )}}
{{ Form::hidden('event_name1', $requests['event_name1'] )}}
{{ Form::hidden('event_name2', $requests['event_name2'] )}}
{{ Form::hidden('event_owner', $requests['event_owner'] )}}
{{-- {{ Form::hidden('in_charge', $requests['in_charge'] )}} --}}
{{-- {{ Form::hidden('tel', $requests['tel'] )}} --}}
{{-- {{ Form::hidden('email_flag', $requests['email_flag'] )}} --}}
{{-- {{ Form::hidden('cost', $requests['cost'] )}} --}}

{{ Form::hidden('luggage_arrive', $requests['luggage_arrive'] )}}
{{ Form::hidden('luggage_return', $requests['luggage_return'] )}}
{{ Form::hidden('luggage_return', $requests['luggage_return'] )}}
{{ Form::hidden('luggage_price', $requests['luggage_price'] )}}

{{ Form::hidden('enduser_company', $requests['enduser_company'] ) }}
{{ Form::hidden('enduser_incharge', $requests['enduser_incharge']) }}
{{ Form::hidden('enduser_address', $requests['enduser_address']) }}
{{ Form::hidden('enduser_tel', $requests['enduser_tel']) }}
{{ Form::hidden('enduser_mail', $requests['enduser_mail']) }}
{{ Form::hidden('enduser_attr', $requests['enduser_attr']) }}
{{ Form::hidden('enduser_charge', $requests['enduser_charge']) }}



{{Form::submit('確認する', ['class'=>'btn btn-primary d-block btn-lg mx-auto mt-5 mb-5', 'id'=>'check_submit'])}}
{{Form::close()}}





@endsection