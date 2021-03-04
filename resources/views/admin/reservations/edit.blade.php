@extends('layouts.admin.app')
@section('content')


<link href="{{ asset('/css/template.css') }}" rel="stylesheet">
<script src="{{ asset('/js/template.js') }}"></script>
<script src="{{ asset('/js/ajax.js') }}"></script>

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

<script>
  $(function() {
    $("html,body").animate({
      scrollTop: $('.bill').offset().top
    });

    $(function() {
      $(document).on("click", ".add", function() {
        $(this).parent().parent().clone(true).insertAfter($(this).parent().parent());
        addThisTr('.others .others_main tr', 'others_input_item', 'others_input_cost', 'others_input_count','others_input_subtotal');
        addThisTr('.venue_main tr', 'venue_breakdown_item', 'venue_breakdown_cost', 'venue_breakdown_count','venue_breakdown_subtotal');
        $(this).parent().parent().next().find('td').find('input, select').eq(0).val('');
        $(this).parent().parent().next().find('td').find('input, select').eq(1).val('');
        $(this).parent().parent().next().find('td').find('input, select').eq(2).val('');
        $(this).parent().parent().next().find('td').find('input, select').eq(3).val('');
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

      $(document).on("click", ".del", function() {
        if ($(this).parent().parent().parent().attr('class')=="others_main") {
          var count = $('.others .others_main tr').length;
          var target = $(this).parent().parent();
          if (target.parent().children().length > 1) {
            target.remove();
          }
          for (let index = 0; index < count; index++) {
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
  
          var venue = $('input[name="venue_price"]').val()?Number($('input[name="venue_price"]').val()):0;
          var equipment = $('input[name="equipment_price"]').val()?Number($('input[name="equipment_price"]').val()):0;
          var layout = $('input[name="layout_price"]').val()?Number($('input[name="layout_price"]').val()):0;
          var others = $('input[name="others_price"]').val() == "" ? 0 : Number($('input[name="others_price"]').val());
          var result = venue + equipment + layout + others;
          var result_tax = Math.floor(result * 0.1);
          $('.total_result').text('').text(result);
          $('input[name="master_subtotal"]').val(result);
          $('input[name="master_tax"]').val(result_tax);
          $('input[name="master_total"]').val(result + result_tax);
        }else if($(this).parent().parent().parent().attr('class')=="venue_main"){
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
  
          var venue = $('input[name="venue_price"]').val()?Number($('input[name="venue_price"]').val()):0;
          var equipment = $('input[name="equipment_price"]').val()?Number($('input[name="equipment_price"]').val()):0;
          var layout = $('input[name="layout_price"]').val()?Number($('input[name="layout_price"]').val()):0;
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
</script>


{{Form::open(['url' => 'admin/reservations/'.$reservation->id.'/edit_calculate', 'method' => 'POST', 'id'=>''])}}
@csrf
{{ Form::hidden('reservation_id',  $reservation->id) }}

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
            {{ Form::text('reserve_date', date('Y-m-d', strtotime($reservation->reserve_date)) ,['class'=>'form-control',  'readonly'] ) }}
            <p class="is-error-reserve_date" style="color: red"></p>
          </td>
        </tr>
        <tr>
          <td class="table-active form_required">会場</td>
          <td>
            {{ Form::text('',  ReservationHelper::getVenue($reservation->venue_id),['class'=>'form-control',  'readonly'] ) }}
            {{ Form::hidden('venue_id',  $reservation->venue_id,['class'=>'form-control',  'readonly'] ) }}
            <p class="is-error-venue_id" style="color: red"></p>
          </td>
        </tr>
        <tr>
          <td>料金体系</td>
          <td>
            <div class='price_radio_selector'>
              <div class="d-flex justfy-content-start align-items-center">
                {{ Form::radio('price_system', 1, isset($reservation->price_system)?$reservation->price_system==1?true:false:'', ['class'=>'mr-2', 'id'=>'price_system_radio1']) }}
                {{Form::label('price_system_radio1','通常（枠貸）')}}
              </div>
              <div class="d-flex justfy-content-start align-items-center">
                {{ Form::radio('price_system', 2, isset($reservation->price_system)?$reservation->price_system==2?true:false:'', ['class'=>'mr-2','id'=>'price_system_radio2']) }}
                {{Form::label('price_system_radio2','アクセア（時間貸）')}}
              </div>
          </td>
        </tr>
        <tr>
          <td class="table-active form_required">入室時間</td>
          <td>
            <select name="enter_time" id="sales_start" class="form-control">
              <option disabled selected></option>
              @for ($start = 0*2; $start <=23*2; $start++) <option
                value="{{date("H:i:s", strtotime("00:00 +". $start * 30 ." minute"))}}" @if (date("H:i:s",
                strtotime("00:00 +". $start * 30 ." minute"))==$reservation->enter_time)
                selected
                @endif>
                {{date("H時i分", strtotime("00:00 +". $start * 30 ." minute"))}}
                </option>
                @endfor
            </select>
          </td>
        </tr>
        <tr>
          <td class="table-active form_required">退室時間</td>
          <td>
            <select name="leave_time" id="sales_finish" class="form-control">
              <option disabled selected></option>
              @for ($start = 0*2; $start <=23*2; $start++) <option
                value="{{date("H:i:s", strtotime("00:00 +". $start * 30 ." minute"))}}" @if (date("H:i:s",
                strtotime("00:00 +". $start * 30 ." minute"))==$reservation->leave_time)
                selected
                @endif
                >
                {{date("H時i分", strtotime("00:00 +". $start * 30 ." minute"))}}</option>
                @endfor
            </select>
          </td>
        </tr>
        <tr>
          <td>案内板</td>
          <td>
            <input type="radio" name="board_flag" value="0"
              {{isset($reservation->board_flag)?$reservation->board_flag==0?'checked':'':'checked',}}>無し
            <input type="radio" name="board_flag" value="1"
              {{isset($reservation->board_flag)?$reservation->board_flag==1?'checked':'':'',}}>有り
          </td>
        </tr>
        <tr>
          <td class="table-active">イベント開始時間</td>
          <td>
            <select name="event_start" id="event_start" class="form-control">
              <option disabled>選択してください</option>
              @for ($start = 0*2; $start <=23*2; $start++) <option
                value="{{date("H:i:s", strtotime("00:00 +". $start * 30 ." minute"))}}" @if (date("H:i:s",
                strtotime("00:00 +". $start * 30 ." minute"))==$reservation->event_start)
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
                value="{{date("H:i:s", strtotime("00:00 +". $start * 30 ." minute"))}}" @if (date("H:i:s",
                strtotime("00:00 +". $start * 30 ." minute"))==$reservation->event_finish)
                selected
                @endif
                >
                {{date("H時i分", strtotime("00:00 +". $start * 30 ." minute"))}}</option>
                @endfor
            </select>

          </td>
        </tr>
        <tr>
          <td class="table-active">イベント名称1</td>
          <td>
            {{ Form::text('event_name1', $reservation->event_name1,['class'=>'form-control'] ) }}
          </td>
        </tr>
        <tr>
          <td class="table-active">イベント名称2</td>
          <td>
            {{ Form::text('event_name2', $reservation->event_name2,['class'=>'form-control'] ) }}
          </td>
        </tr>
        <tr>
          <td class="table-active">主催者名</td>
          <td>
            {{ Form::text('event_owner', $reservation->event_owner,['class'=>'form-control'] ) }}
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
            @foreach ($venues->find($reservation->venue_id)->equipments()->get() as $key=>$equipment)
            <tr>
              <td>
                {{$equipment->item}}
              </td>
              <td>
                <input type="text" class="form-control" name="{{'equipment_breakdown'.$key}}"
                  @foreach($reservation->bills()->first()->breakdowns()->where('unit_type',[2])->get() as $item)
                @if ($item->unit_item==$equipment->item)
                value="{{$item->unit_count}}"
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
        <table class="table table-bordered" style="table-layout: fixed;">
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
                @if ($s_services[$key]==1)
                <div class="form-check form-check-inline">
                  {{Form::radio('services_breakdown'.$key, 1, true , ['id' => 'service'.$key.'on', 'class' => 'form-check-input'])}}
                  <label for="{{'service'.$key.'on'}}" class="form-check-label">有り</label>
                  {{Form::radio('services_breakdown'.$key, 0, false, ['id' => 'service'.$key.'off', 'class' => 'form-check-input'])}}
                  <label for="{{'service'.$key.'off'}}" class="form-check-label">無し</label>
                </div>
                @else
                <div class="form-check form-check-inline">
                  {{Form::radio('services_breakdown'.$key, 1, false , ['id' => 'service'.$key.'on', 'class' => 'form-check-input'])}}
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
        <table class='table table-bordered' style="table-layout:fixed;">
          <thead>
            <tr>
              <th colspan='2'>レイアウト</th>
            </tr>
          </thead>
          <tbody>
            @if ($s_layouts[0]==1)
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

            @if ($s_layouts[1]==1)
            <tr>
              <td>レイアウト片付</td>
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
              <td>レイアウト片付</td>
              <td>
                <div class="form-check form-check-inline">
                  {{Form::radio('layout_clean', 1, false, ['id' => 'layout_clean', 'class' => 'form-check-input'])}}
                  <label for='layout_clean' class="form-check-label">有り</label>
                  {{Form::radio('no_layout_clean', 0, true, ['id' => 'no_layout_clean', 'class' => 'form-check-input'])}}
                  <label for='no_layout_clean' class="form-check-label">無し</label>
                </div>
              </td>
            </tr>
            @endif

          </tbody>
        </table>
      </div>
      <div class='luggage'>
        <table class='table table-bordered' style="table-layout:fixed;">
          <thead>
            <tr>
              <th colspan='2'>荷物預かり</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>事前に預かる荷物<br>（個数）</td>
              <td>
                {{ Form::text('luggage_count', $reservation->luggage_count,['class'=>'form-control'] ) }}
              </td>
            </tr>
            <tr>
              <td>事前荷物の到着日<br>午前指定のみ</td>
              <td>
                {{ Form::text('luggage_arrive', $reservation->luggage_arrive,['class'=>'form-control'] ) }}
              </td>
            </tr>
            <tr>
              <td>事後返送する荷物</td>
              <td>
                {{ Form::text('luggage_return', $reservation->luggage_return,['class'=>'form-control'] ) }}
              </td>
            </tr>
            <tr>
              <td>荷物預かり/返送<br>料金</td>
              <td>
                @if ($s_luggage==1)
                {{ Form::text('luggage_price', $reservation->bills()->first()->breakdowns()->where('unit_item', '荷物預かり/返送')->first()->unit_cost,['class'=>'form-control'] ) }}
                @else
                {{ Form::text('luggage_price', '',['class'=>'form-control'] ) }}
                @endif
              </td>
            </tr>
          </tbody>
        </table>
      </div>

    </div>
    <div class="col">
      <div class="client_mater">　
        <table class="table table-bordered name-table" style="table-layout:fixed;">
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
                <option value="{{$user->id}}" @if ($reservation->user_id==$user->id)
                  selected
                  @endif
                  >
                  {{$user->company}} ・ {{ReservationHelper::getPersonName($user->id)}} ・ {{$user->email}}
                </option>
                @endforeach
              </select>
              <p class="is-error-user_id" style="color: red"></p>
            </td>
          </tr>
          <tr>
            <td class="table-active"><label for="name" class=" form_required">担当者氏名<br></label></td>
            <td>
              {{ Form::text('', $reservation->user_id?ReservationHelper::getPersonName($reservation->user_id):'',['class'=>'form-control'] ) }}
            </td>
          </tr>
        </table>
        <table class="table table-bordered oneday-table" style="table-layout:fixed;">
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
              {{ Form::text('in_charge', $reservation->in_charge,['class'=>'form-control'] ) }}
            </td>
          </tr>
          <tr>
            <td class="table-active"><label for="mobilePhone" class=" form_required">携帯番号</label></td>
            <td>
              {{ Form::text('tel', $reservation->tel,['class'=>'form-control'] ) }}
            </td>
          </tr>
        </table>
      </div>
      <table class="table table-bordered mail-table" style="table-layout:fixed;">
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
            {{ Form::text('', $reservation->email_flag==1?"有り":"無し",['class'=>'form-control'] ) }}
            {{ Form::hidden('email_flag', $reservation->email_flag,['class'=>'form-control'] ) }}
          </td>
        </tr>
      </table>
      <table class="table table-bordered sale-table" style="table-layout:fixed;">
        <tr>
          <td colspan="2">
            <p class="title-icon">
              <i class="fas fa-yen-sign fa-2x fa-fw"></i>売上原価（提携会場を選択した場合、提携会場で設定した原価率が適応されます）
            </p>
          </td>
        </tr>
        <tr>
          <td class="table-active"><label for="cost">原価率</label></td>
          <td>
            {{ Form::text('', $reservation->cost."%",['class'=>'form-control'] ) }}
            {{ Form::hidden('cost', $reservation->cost,['class'=>'form-control'] ) }}
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
        <tr>
          <td>
            <input type="checkbox" id="discount" checked>
            <label for="discount">割引条件</label>
            {{ Form::textarea('discount_condition', $reservation->discount_condition,['class'=>'form-control'] ) }}
          </td>
        </tr>
        <tr class="caution">
          <td>
            <label for="caution">注意事項</label>
            {{ Form::textarea('attention', $reservation->attention,['class'=>'form-control'] ) }}
          </td>
        </tr>
        <tr>
          <td>
            <label for="userNote">顧客情報の備考</label>
            {{ Form::textarea('user_details', $reservation->user_details,['class'=>'form-control'] ) }}
          </td>
        </tr>
        <tr>
          <td>
            <label for="adminNote">管理者備考</label>
            {{ Form::textarea('admin_details', $reservation->admin_details,['class'=>'form-control'] ) }}
          </td>
        </tr>
      </table>
    </div>
  </div>
</div>
{{Form::submit('再計算する', ['class'=>'btn btn-danger mx-auto d-block btn-lg mt-5 mb-5', 'id'=>'check_submit'])}}
{{Form::close()}}

{{-- 丸岡さんカスタム --}}
{{ Form::open(['url' => '###################', 'method'=>'POST', 'id'=>'agents_calculate_form']) }}
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
              <div class="total_result">{{number_format($reservation->bills()->first()->master_total)}}円
              </div>
            </div>
          </td>
        </tr>
        <tr>
          <td></td>
          <td style="font-size: 16px;">
            <div class="bg-white d-flex justify-content-around align-items-center" style="height: 60px;">
              <div>支払い期日</div>
              <div>{{ReservationHelper::formatDate($reservation->bills()->first()->payment_limit)}}
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
                <td>単価</td>
                <td>数量</td>
                <td>金額</td>
              </tr>
            </tbody>
            <tbody class="venue_main">
              @foreach ($venue_prices as $key=>$venue_price)
              <tr>
                <td>
                  {{ Form::text('venue_breakdown_item'.$key, $venue_price->unit_item,['class'=>'form-control', 'readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('venue_breakdown_cost'.$key, $venue_price->unit_cost,['class'=>'form-control', 'readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('venue_breakdown_count'.$key, $venue_price->unit_count,['class'=>'form-control', 'readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('venue_breakdown_subtotal'.$key, $venue_price->unit_subtotal,['class'=>'form-control', 'readonly'] ) }}
                </td>
              </tr>
              @endforeach
            </tbody>
            <tbody class="venue_result">
              <tr>
                <td colspan="2"></td>
                <td colspan="2">合計
                  {{ Form::text('venue_price', $reservation->bills()->first()->venue_price,['class'=>'form-control col-xs-3', 'readonly'] ) }}
                </td>
              </tr>
            </tbody>
            <tbody class="venue_discount">
              <tr>
                <td>割引計算欄</td>
                <td>
                  <p>
                    割引金額
                  </p>
                  <div class="d-flex">
                    {{ Form::text('venue_number_discount', '',['class'=>'form-control'] ) }}
                    <p>円</p>
                  </div>
                </td>
                <td>
                  <p>
                    割引率
                  </p>
                  <div class="d-flex">
                    {{ Form::text('venue_percent_discount', '',['class'=>'form-control'] ) }}
                    <p>%</p>
                  </div>
                </td>
                <td>
                  <input class="btn btn-success venue_discount_btn" type="button" value="計算する">
                </td>
              </tr>
            </tbody>
          </table>
        </div>

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
                <td>単価</td>
                <td>数量</td>
                <td>金額</td>
              </tr>
            </tbody>
            <tbody class="equipment_main">
              @foreach ($equipments_prices as $key=>$equipment_price)
              <tr>
                <td>
                  {{ Form::text('equipment_breakdown_item'.$key, $equipment_price->unit_item,['class'=>'form-control', 'readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('equipment_breakdown_cost'.$key, $equipment_price->unit_cost,['class'=>'form-control', 'readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('equipment_breakdown_count'.$key, $equipment_price->unit_count,['class'=>'form-control', 'readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('equipment_breakdown_subtotal'.$key, $equipment_price->unit_subtotal,['class'=>'form-control', 'readonly'] ) }}
                </td>
              </tr>
              @endforeach
              @foreach ($services_prices as $key=>$service_price)
              <tr>
                <td>
                  {{ Form::text('equipment_breakdown_item'.$key, $service_price->unit_item,['class'=>'form-control', 'readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('equipment_breakdown_cost'.$key, $service_price->unit_cost,['class'=>'form-control', 'readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('equipment_breakdown_count'.$key, $service_price->unit_count,['class'=>'form-control', 'readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('equipment_breakdown_subtotal'.$key, $service_price->unit_subtotal,['class'=>'form-control', 'readonly'] ) }}
                </td>
              </tr>
              @endforeach
            </tbody>
            <tbody class="equipment_result">
              <tr>
                <td colspan="2"></td>
                <td colspan="2">合計
                  {{ Form::text('equipment_price', $reservation->bills()->first()->equipment_price,['class'=>'form-control', 'readonly'] ) }}
                </td>
              </tr>
            </tbody>
            <tbody class="equipment_discount">
              <tr>
                <td>割引計算欄</td>
                <td>
                  <p>
                    割引金額
                  </p>
                  <div class="d-flex">
                    {{ Form::text('equipment_number_discount', '',['class'=>'form-control'] ) }}
                    <p>円</p>
                  </div>
                </td>
                <td>
                  <p>
                    割引率
                  </p>
                  <div class="d-flex">
                    {{ Form::text('equipment_percent_discount', '',['class'=>'form-control'] ) }}
                    <p>%</p>
                  </div>
                </td>
                <td>
                  <input class="btn btn-success equipment_discount_btn" type="button" value="計算する">
                </td>
              </tr>
            </tbody>
          </table>
        </div>

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
                <td>数量</td>
                <td>金額</td>
              </tr>
            </tbody>
            <tbody class="layout_main">
              @foreach ($layouts_prices as $key=>$layouts_price)
              <tr>
                <td>
                  {{ Form::text('layout_breakdown_item'.$key, $layouts_price->unit_item,['class'=>'form-control', 'readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('layout_breakdown_cost'.$key, $layouts_price->unit_cost,['class'=>'form-control', 'readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('layout_breakdown_count'.$key, $layouts_price->unit_count,['class'=>'form-control', 'readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('layout_breakdown_subtotal'.$key, $layouts_price->unit_subtotal,['class'=>'form-control', 'readonly'] ) }}
                </td>

              </tr>
              @endforeach
            </tbody>
            <tbody class="layout_result">
              <tr>
                <td colspan="2"></td>
                <td colspan="2">合計
                  {{ Form::text('layout_price',$reservation->bills()->first()->layout_price ,['class'=>'form-control', 'readonly'] ) }}
                </td>
              </tr>
            </tbody>
            <tbody class="layout_discount">
              <tr>
                <td>割引計算欄</td>
                <td>
                  <p>
                    割引金額
                  </p>
                  <div class="d-flex">
                    {{ Form::text('layout_number_discount', '',['class'=>'form-control'] ) }}
                    <p>円</p>
                  </div>
                </td>
                <td>
                  <p>
                    割引率
                  </p>
                  <div class="d-flex">
                    {{ Form::text('layout_percent_discount', '',['class'=>'form-control'] ) }}
                    <p>%</p>
                  </div>
                </td>
                <td>
                  <input class="btn btn-success layout_discount_btn" type="button" value="計算する">
                </td>
              </tr>
            </tbody>
          </table>
        </div>

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
                <td>単価</td>
                <td>数量</td>
                <td>金額</td>
              </tr>
            </tbody>
            <tbody class="others_main">
              @foreach ($others_prices as $key=>$others_price)
              <tr>
                <td>
                  {{ Form::text('others_input_item'.$key, $others_price->unit_item,['class'=>'form-control', 'readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('others_input_cost'.$key, $others_price->unit_cost,['class'=>'form-control', 'readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('others_input_count'.$key, $others_price->unit_count,['class'=>'form-control', 'readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('others_input_subtotal'.$key, $others_price->unit_subtotal,['class'=>'form-control', 'readonly'] ) }}
                </td>
              </tr>
              @endforeach
            </tbody>
            <tbody class="others_result">
              <tr>
                <td colspan="2"></td>
                <td colspan="3">合計
                  {{ Form::text('others_price', $reservation->bills()->first()->others_price,['class'=>'form-control', 'readonly'] ) }}
                </td>
              </tr>
            </tbody>
            <tbody class="others_discount">
              <tr>
                <td>割引計算欄</td>
                <td>
                  <p>
                    割引金額
                  </p>
                  <div class="d-flex">
                    {{ Form::text('others_number_discount', '',['class'=>'form-control'] ) }}
                    <p>円</p>
                  </div>
                </td>
                <td>
                  <p>
                    割引率
                  </p>
                  <div class="d-flex">
                    {{ Form::text('others_percent_discount', '',['class'=>'form-control'] ) }}
                    <p>%</p>
                  </div>
                </td>
                <td>
                  <input class="btn btn-success others_discount_btn" type="button" value="計算する">
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="bill_total d-flex justify-content-end"
          style="padding: 80px 0px 80px 0px; width:90%; margin:0 auto;">
          <div style="width: 60%;">
            <table class="table text-right" style="table-layout: fixed; font-size:16px;">
              <tr>
                <td>小計：</td>
                <td>
                  {{ Form::text('master_subtotal', $reservation->bills()->first()->master_subtotal,['class'=>'form-control', 'readonly'] ) }}
                </td>
              </tr>
              <tr>
                <td>消費税：</td>
                <td>
                  {{ Form::text('master_tax', $reservation->bills()->first()->master_tax,['class'=>'form-control', 'readonly'] ) }}
                </td>
              </tr>
              <tr>
                <td class="font-weight-bold">合計金額</td>
                <td>
                  {{ Form::text('master_total', $reservation->bills()->first()->master_total,['class'=>'form-control', 'readonly'] ) }}

                </td>
              </tr>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

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
              <td>支払期日
                {{ Form::text('pay_limit', $reservation->bills()->first()->pay_limit,['class'=>'form-control', 'id'=>'datepicker6'] ) }}
              </td>
            </tr>
            <tr>
              <td>請求書宛名{{ Form::text('pay_company', $user->company,['class'=>'form-control'] ) }}</td>
              <td>
                担当者{{ Form::text('bill_person', ReservationHelper::getPersonName($reservation->user_id),['class'=>'form-control'] ) }}
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
              <td>入金状況
                <select name="paid" class="form-control">
                  <option value="#" disabled>選択してください</option>
                  <option value="0" {{$reservation->bills()->first()->paid==0?'selected':''}}>未入金</option>
                  <option value="1" {{$reservation->bills()->first()->paid==1?'selected':''}}>入金済み</option>
                </select>
              </td>
              <td>
                入金日{{ Form::text('pay_day', $reservation->bills()->first()->pay_day,['class'=>'form-control', 'id'=>'datepicker7'] ) }}
              </td>
            </tr>
            <tr>
              <td>
                振込人名{{ Form::text('pay_person', $reservation->bills()->first()->pay_person,['class'=>'form-control'] ) }}
              </td>
              <td>入金額{{ Form::text('payment', $reservation->bills()->first()->payment,['class'=>'form-control'] ) }}
              </td>
            </tr>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
{{Form::submit('確認する', ['class'=>'btn btn-primary d-block btn-lg mx-auto mt-5 mb-5', 'id'=>'check_submit'])}}
{{Form::close()}}






@endsection