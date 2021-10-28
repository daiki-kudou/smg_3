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

    $(function() {
      // プラスボタンクリック
      $(document).on("click", ".add", function() {
        $(this).parent().parent().clone(true).insertAfter($(this).parent().parent());
        addThisTr('.others .others_main tr', 'others_input_item', 'others_input_cost', 'others_input_count','others_input_subtotal');
        addThisTr('.venue_main tr', 'venue_breakdown_item', 'venue_breakdown_cost', 'venue_breakdown_count','venue_breakdown_subtotal');
                // 追加時内容クリア
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



{{Form::open(['url' => 'admin/agents_reservations/calculate', 'method' => 'POST', 'id'=>''])}}
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
            {{ Form::text('reserve_date', $all_requests['reserve_date'] ,['class'=>'form-control', 'id'=>'datepicker1', 'placeholder'=>'入力してください'] ) }}
            <p class="is-error-reserve_date" style="color: red"></p>
          </td>
        </tr>
        <tr>
          <td class="table-active form_required">会場</td>
          <td>
            <select id="venues_selector" class=" form-control" name='venue_id'>
              <option value='#' disabled selected>選択してください</option>
              @foreach ($venues as $venue)
              <option value="{{$venue->id}}" @if (($all_requests['venue_id']==$venue->id))
                selected
                @endif
                >{{$venue->name_area}}{{$venue->name_bldg}}{{$venue->name_venue}}
              </option>
              @endforeach
            </select>
            <p class="is-error-venue_id" style="color: red"></p>
          </td>
        </tr>
        <tr>
          <td>料金体系</td>
          <td>
            <div class='price_radio_selector'>
              <div class="d-flex justfy-content-start align-items-center">
                {{ Form::radio('price_system', 1, $all_requests['price_system']==1?true:false, ['class'=>'mr-2', 'id'=>'price_system_radio1']) }}
                {{Form::label('price_system_radio1','通常（枠貸）')}}
              </div>
              <div class="d-flex justfy-content-start align-items-center">
                {{ Form::radio('price_system', 2, $all_requests['price_system']==2?true:false, ['class'=>'mr-2','id'=>'price_system_radio2']) }}
                {{Form::label('price_system_radio2','音響HG')}}
              </div>
          </td>
        </tr>
        <tr>
          <td class="table-active form_required">入室時間</td>
          <td>
            <select name="enter_time" id="sales_start" class="form-control">
              <option disabled selected></option>
              {!!ReservationHelper::timeOptionsWithRequest($all_requests['enter_time'])!!}
            </select>
          </td>
        </tr>
        <tr>
          <td class="table-active form_required">退室時間</td>
          <td>
            <select name="leave_time" id="sales_finish" class="form-control">
              <option disabled selected></option>
              {!!ReservationHelper::timeOptionsWithRequest($all_requests['leave_time'])!!}
            </select>
          </td>
        </tr>
        <tr>
          <td>案内板</td>
          <td>
            <input type="radio" name="board_flag" value="0" {{$all_requests['board_flag']==0?'checked':''}}>無し
            <input type="radio" name="board_flag" value="1" {{$all_requests['board_flag']==1?'checked':''}}>有り
          </td>
        </tr>
        <tr>
          <td class="table-active">イベント開始時間</td>
          <td>
            <select name="event_start" id="event_start" class="form-control">
              <option disabled>選択してください</option>
              {!!ReservationHelper::timeOptionsWithRequest($all_requests['event_start'])!!}
            </select>
          </td>
        </tr>
        <tr>
          <td class="table-active">イベント終了時間</td>
          <td>
            <select name="event_finish" id="event_finish" class="form-control">
              <option disabled>選択してください</option>
              {!!ReservationHelper::timeOptionsWithRequest($all_requests['event_finish'])!!}
            </select>
          </td>
        </tr>
        <tr>
          <td class="table-active">イベント名称1</td>
          <td>
            {{ Form::text('event_name1', $all_requests['event_name1'],['class'=>'form-control'] ) }}
          </td>
        </tr>
        <tr>
          <td class="table-active">イベント名称2</td>
          <td>
            {{ Form::text('event_name2', $all_requests['event_name2'],['class'=>'form-control'] ) }}
          </td>
        </tr>
        <tr>
          <td class="table-active">主催者名</td>
          <td>
            {{ Form::text('event_owner', $all_requests['event_owner'],['class'=>'form-control'] ) }}
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
                @if (!empty($all_requests['equipment_breakdown_count'.$key]))
                {{ Form::text('equipment_breakdown'.$key, $all_requests['equipment_breakdown_count'.$key],['class'=>'form-control'] ) }}
                @else
                {{ Form::text('equipment_breakdown'.$key, 0,['class'=>'form-control'] ) }}
                @endif
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

            @if (!empty(array_filter($s_services)))
            @foreach ($services as $key=>$service)
            <tr>
              <td>
                {{$service->item}}
              </td>
              <td>
                @if (empty($s_services[$key]))
                <div class="form-check form-check-inline">
                  {{Form::radio('services_breakdown'.$key, 1, false , ['id' => 'service'.$key.'on', 'class' => 'form-check-input'])}}
                  <label for="{{'service'.$key.'on'}}" class="form-check-label">有り</label>
                  {{Form::radio('services_breakdown'.$key, 0, true, ['id' => 'services_breakdown'.$key.'off', 'class' => 'form-check-input'])}}
                  <label for="{{'services_breakdown'.$key.'off'}}" class="form-check-label">無し</label>
                </div>
                @else
                <div class="form-check form-check-inline">
                  {{Form::radio('services_breakdown'.$key, 1, $s_services[$key]==1?true:false , ['id' => 'service'.$key.'on', 'class' => 'form-check-input'])}}
                  <label for="{{'service'.$key.'on'}}" class="form-check-label">有り</label>
                  {{Form::radio('services_breakdown'.$key, 0, $s_services[$key]==0?true:false, ['id' => 'services_breakdown'.$key.'off', 'class' => 'form-check-input'])}}
                  <label for="{{'services_breakdown'.$key.'off'}}" class="form-check-label">無し</label>
                </div>
                @endif
              </td>
            </tr>
            @endforeach
            @else
            @foreach ($services as $key=>$service)
            <tr>
              <td>
                {{$service->item}}
              </td>
              <td>
                <div class="form-check form-check-inline">
                  {{Form::radio('services_breakdown'.$key, 1,false , ['id' => 'service'.$key.'on', 'class' => 'form-check-input'])}}
                  <label for="{{'service'.$key.'on'}}" class="form-check-label">有り</label>
                  {{Form::radio('services_breakdown'.$key, 0, true, ['id' => 'service'.$key.'off', 'class' => 'form-check-input'])}}
                  <label for="{{'service'.$key.'off'}}" class="form-check-label">無し</label>
                </div>
              </td>
            </tr>
            @endforeach
            @endif

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
            @if (!empty($all_requests['layout_prepare_count']))
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
            @if (!empty($all_requests['layout_clean_count']))
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
        <table class='table table-bordered' style="table-layout:fixed;">
          <thead>
            <tr>
              <th colspan='2'>荷物預り</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>事前に預かる荷物<br>（個数）</td>
              <td>
                {{ Form::text('luggage_count', empty($all_requests['luggage_count'])?"":$all_requests['luggage_count'],['class'=>'form-control'] ) }}
              </td>
            </tr>
            <tr>
              <td>事前荷物の到着日<br>午前指定のみ</td>
              <td>
                {{ Form::text('luggage_arrive', empty($all_requests['luggage_arrive'])?"":$all_requests['luggage_arrive'],['class'=>'form-control'] ) }}
              </td>
            </tr>
            <tr>
              <td>事後返送する荷物</td>
              <td>
                {{ Form::text('luggage_return', empty($all_requests['luggage_return'])?"":$all_requests['luggage_return'],['class'=>'form-control'] ) }}

              </td>
            </tr>
            <tr>
              <td>荷物預かり<br>料金</td>
              <td>
                {{ Form::text('luggage_price', empty($all_requests['luggage_price'])?"":$all_requests['luggage_price'],['class'=>'form-control'] ) }}
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

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
                <option value="{{$agent->id}}" @if ($agent->id==$all_requests['agent_id'])
                  selected
                  @endif
                  >{{$agent->name}} |{{ReservationHelper::getAgentPerson($agent->id)}}| {{$agent->email}}
                </option>
                @endforeach
              </select>
              <p class="is-error-user_id" style="color: red"></p>
            </td>
          </tr>
          <tr>
            <td class="table-active"><label for="name" class=" form_required">担当者氏名<br></label></td>
            <td>
              <p class="selected_person">{{ReservationHelper::getAgentPerson($all_requests['agent_id'])}}</p>
            </td>
          </tr>
        </table>
        <table class="table table-bordered oneday-table">
          <tr>
            <td colspan="2">
              <p class="title-icon">
                <i class="fas fa-user-check fa-2x fa-fw"></i>エンドユーザー
              </p>
            </td>
          </tr>
          <tr>
            <td class="table-active">
              <label for="enduser_company" class="">会社名・団体名</label>
            </td>
            <td>
              {{ Form::text('enduser_company', $all_requests['enduser_company'],['class'=>'form-control', 'placeholder'=>'入力してください','id'=>'enduser_company'] ) }}

            </td>
          </tr>
          <tr>
            <td class="table-active">
              <label for="enduser_incharge" class="">担当者氏名</label>
            </td>
            <td>
              {{ Form::text('enduser_incharge', $all_requests['enduser_incharge'],['class'=>'form-control', 'placeholder'=>'入力してください', 'id'=>'enduser_incharge'] ) }}

            </td>
          </tr>
          <tr>
            <td class="table-active">
              <label for="enduser_address" class=" ">住所</label>
            </td>
            <td>
              {{ Form::text('enduser_address', $all_requests['enduser_address'],['class'=>'form-control', 'placeholder'=>'入力してください', 'id'=>'enduser_address'] ) }}
            </td>
          </tr>
          <tr>
            <td class="table-active">
              <label for="enduser_tel" class="">電話番号</label>
            </td>
            <td>
              {{ Form::text('enduser_tel', $all_requests['enduser_tel'],['class'=>'form-control', 'placeholder'=>'入力してください', 'maxlength'=>13, 'id'=>'enduser_tel'] ) }}
            </td>
          </tr>
          <tr>
            <td class="table-active">
              <label for="enduser_mail" class=" ">メールアドレス</label>
            </td>
            <td>
              {{ Form::text('enduser_mail', $all_requests['enduser_mail'],['class'=>'form-control', 'placeholder'=>'入力してください', 'maxlength'=>13,'id'=>'enduser_mail'] ) }}
            </td>
          </tr>
          <tr>
            <td class="table-active">
              <label for="enduser_attr" class="">利用者属性</label>
            </td>
            <td>
              {{ Form::text('enduser_attr', $all_requests['enduser_attr'],['class'=>'form-control', 'placeholder'=>'入力してください', 'maxlength'=>13, 'id'=>'enduser_attr'] ) }}
            </td>
          </tr>
        </table>
      </div>
      <table class="table table-bordered sale-table">
        <tr>
          <td colspan="2">
            <p class="title-icon">
              <i class="fas fa-yen-sign fa-2x fa-fw"></i>エンドユーザーへの支払い料
            </p>
          </td>
        </tr>
        <tr>
          <td class="table-active form_required">
            <label for="end_user_charge ">支払い料</label>
          </td>
          <td class="d-flex align-items-center">
            {{ Form::text('end_user_charge', $all_requests['end_user_charge'],['class'=>'form-control sales_percentage', 'placeholder'=>'入力してください'] ) }}円

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
            {{ Form::textarea('attention', $all_requests['attention'],['class'=>'form-control', 'placeholder'=>'入力してください'] ) }}
          </td>
        </tr>
        <tr>
          <td>
            <label for="userNote">顧客情報の備考</label>
            {{ Form::textarea('user_details', $all_requests['user_details'],['class'=>'form-control', 'placeholder'=>'入力してください'] ) }}
          </td>
        </tr>
        <tr>
          <td>
            <label for="adminNote">管理者備考</label>
            {{ Form::textarea('admin_details', $all_requests['admin_details'],['class'=>'form-control', 'placeholder'=>'入力してください'] ) }}
          </td>
        </tr>
      </table>
    </div>
  </div>
</div>

{{Form::submit('再計算する', ['class'=>'btn btn-danger mx-auto d-block btn-lg mt-5 mb-5', 'id'=>'check_submit'])}}
{{Form::close()}}

{{ Form::open(['url' => 'admin/reservations/check', 'method'=>'POST', 'id'=>'agents_calculate_form']) }}
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
              <div class="total_result">{{number_format($all_requests['master_total'])}}円</div>
            </div>
          </td>
        </tr>
        <tr>
          <td></td>
          <td style="font-size: 16px;">
            <div class="bg-white d-flex justify-content-around align-items-center" style="height: 60px;">
              <div>支払い期日</div>
              <div>{{ReservationHelper::formatDate($all_requests['pay_limit'])}}</div>
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
                <td>
                  {{ Form::text('venue_breakdown_item0', $all_requests['venue_breakdown_item0'],['class'=>'form-control', 'readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('venue_breakdown_count0', $all_requests['venue_breakdown_count0'],['class'=>'form-control', 'readonly'] ) }}
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
            </tbody>
          </table>
        </div>

        @if ($all_requests['layout_prepare_count']>0||$all_requests['layout_clean_count']>0)
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
              @if (!empty($all_requests['layout_prepare_count']))
              @if ($all_requests['layout_prepare_count']>0)
              <tr>
                <td>{{ Form::text('layout_prepare_item', "レイアウト準備料金",['class'=>'form-control', 'readonly'] ) }}</td>
                <td>
                  {{ Form::text('layout_prepare_cost', $all_requests['layout_prepare_cost'],['class'=>'form-control', 'readonly'] )}}
                </td>
                <td>{{ Form::text('layout_prepare_count', 1,['class'=>'form-control', 'readonly'] )}}</td>
                <td>
                  {{ Form::text('layout_prepare_subtotal', $all_requests['layout_prepare_cost'],['class'=>'form-control', 'readonly'] )}}
                </td>
              </tr>
              @endif
              @endif
              @if (!empty($all_requests['layout_clean_count']))
              @if ($all_requests['layout_clean_count']>0)
              <tr>
                <td>{{ Form::text('layout_clean_item', "レイアウト片付料金",['class'=>'form-control', 'readonly'] ) }}</td>
                <td>
                  {{ Form::text('layout_clean_cost', $all_requests['layout_clean_cost'],['class'=>'form-control', 'readonly'] )}}
                </td>
                <td>{{ Form::text('layout_clean_count', 1,['class'=>'form-control', 'readonly'] )}}</td>
                <td>
                  {{ Form::text('layout_clean_subtotal', $all_requests['layout_clean_cost'],['class'=>'form-control', 'readonly'] )}}
                </td>
              </tr>
              @endif
              @endif
            </tbody>
            <tbody class="layout_result">
              <tr>
                <td colspan="2"></td>
                <td colspan="2">合計
                  {{ Form::text('layout_price',$all_requests['layout_price'] ,['class'=>'form-control', 'readonly'] ) }}
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        @endif


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
                <td>追加/削除</td>
              </tr>
            </tbody>
            <tbody class="others_main">
            </tbody>
            <tbody class="others_result">
              <tr>
                <td colspan="2"></td>
                <td colspan="3">合計
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
                  {{ Form::text('master_subtotal',$all_requests['master_subtotal'] ,['class'=>'form-control text-right', 'readonly'] ) }}
                </td>
              </tr>
              <tr>
                <td>消費税：</td>
                <td>
                  {{ Form::text('master_tax',ReservationHelper::getTax($all_requests['master_tax']) ,['class'=>'form-control text-right', 'readonly'] ) }}

                </td>
              </tr>
              <tr>
                <td class="font-weight-bold">合計金額</td>
                <td>
                  {{ Form::text('master_total',ReservationHelper::taxAndPrice($all_requests['master_total']) ,['class'=>'form-control text-right', 'readonly'] ) }}
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
              </td>
            </tr>
            <tr>
              <td>
              </td>
            </tr>
            <tr>
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
{{ Form::hidden('venue_id', $all_requests['venue_id'] )}}
{{ Form::hidden('reserve_date', $all_requests['reserve_date'] )}}
{{ Form::hidden('price_system', $all_requests['price_system'] )}}
{{ Form::hidden('enter_time', $all_requests['enter_time'] )}}
{{ Form::hidden('leave_time', $all_requests['leave_time'] )}}
{{ Form::hidden('board_flag', $all_requests['board_flag'] )}}
{{ Form::hidden('event_start', $all_requests['event_start'] )}}
{{ Form::hidden('event_finish', $all_requests['event_finish'] )}}
{{ Form::hidden('event_name1', $all_requests['event_name1'] )}}
{{ Form::hidden('event_name2', $all_requests['event_name2'] )}}
{{ Form::hidden('event_owner', $all_requests['event_owner'] )}}

{{Form::submit('確認する', ['class'=>'btn btn-primary d-block btn-lg mx-auto mt-5 mb-5', 'id'=>'check_submit'])}}
{{Form::close()}}




<script>
  $(function(){
    $('.venue_discount_btn,.equipment_discount_btn, .layout_discount_btn').click();
  })
</script>








@endsection