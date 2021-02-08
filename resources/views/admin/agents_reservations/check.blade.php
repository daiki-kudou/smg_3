@extends('layouts.admin.app')
@section('content')

<h1>仲介会社　予約 計算</h1>

<link href="{{ asset('/css/template.css') }}" rel="stylesheet">
<script src="{{ asset('/js/template.js') }}"></script>
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

{{-- <script>
  $(function() {
    $("html,body").animate({
      scrollTop: $('.bill').offset().top
    });

    $(function() {
      // プラスボタンクリック
      $(document).on("click", ".add", function() {
        $(this).parent().parent().clone(true).insertAfter($(this).parent().parent());
        addThisTr('.others .others_main tr', 'others_input_item', 'others_input_cost', 'others_input_count','others_input_subtotal');
        addThisTr('.venue_main tr', 'venue_breakdown_item', 'venue_breakdown_cost', 'venue_breakdown_count','venue_breakdown_subtotal');
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
</script> --}}

<div id="fullOverlay">
  <div class="frame_spinner">
    <div class="spinner-border text-primary " role="status">
      <span class="sr-only hide">Loading...</span>
    </div>
  </div>
</div>

{{Form::open(['url' => 'admin/agents_reservations', 'method' => 'POST', 'id'=>'agentReservationCreateForm'])}}
@csrf
<div class="container-field bg-white text-dark">
  <div class="row">
    <div class="col">
      <table class="table table-bordered" style="table-layout: fixed;">
        <tr>
          <td colspan="2">予約情報</td>
        </tr>
        <tr>
          <td class="table-active form_required">利用日</td>
          <td>
            {{ Form::text('reserve_date', $request->reserve_date ,['class'=>'form-control', 'id'=>'datepicker1', 'placeholder'=>'入力してください', 'readonly'] ) }}
            <p class="is-error-reserve_date" style="color: red"></p>
          </td>
        </tr>
        <tr>
          <td class="table-active form_required">会場</td>
          <td>
            {{ Form::text('', ReservationHelper::getVenue($request->venue_id) ,['class'=>'form-control', 'placeholder'=>'入力してください','readonly'] ) }}
            {{ Form::hidden('venue_id', $request->venue_id ,['class'=>'form-control', 'placeholder'=>'入力してください','readonly'] ) }}
            <p class="is-error-venue_id" style="color: red"></p>
          </td>
        </tr>
        <tr>
          <td>料金体系</td>
          <td>
            {{ Form::text('price_system', ReservationHelper::priceSystem($request->price_system) ,['class'=>'form-control', 'placeholder'=>'入力してください','readonly'] ) }}
            {{ Form::hidden('price_system', $request->price_system ,['class'=>'form-control', 'placeholder'=>'入力してください','readonly'] ) }}
          </td>
        </tr>
        <tr>
          <td class="table-active form_required">入室時間</td>
          <td>
            {{ Form::text('', date('H:i',strtotime($request->enter_time)) ,['class'=>'form-control','readonly'] ) }}
            {{ Form::hidden('enter_time', $request->enter_time ,['class'=>'form-control','readonly'] ) }}
          </td>
        </tr>
        <tr>
          <td class="table-active form_required">退室時間</td>
          <td>
            <div>
              {{ Form::text('', date('H:i',strtotime($request->leave_time)) ,['class'=>'form-control','readonly'] ) }}
              {{ Form::hidden('leave_time', $request->leave_time ,['class'=>'form-control','readonly'] ) }}
              <p class="is-error-leave_time" style="color: red"></p>
            </div>
          </td>
        </tr>
        <tr>
          <td>案内板</td>
          <td>
            {{ Form::text('', $request->board_flag==1?"有り":"無し" ,['class'=>'form-control','readonly'] ) }}
            {{ Form::hidden('board_flag', $request->board_flag ,['class'=>'form-control','readonly'] ) }}
          </td>
        </tr>
        <tr>
          <td class="table-active">イベント開始時間</td>
          <td>
            <div>
              {{ Form::text('', date('H:i',strtotime($request->event_start)) ,['class'=>'form-control','readonly'] ) }}
              {{ Form::hidden('event_start', $request->event_start ,['class'=>'form-control','readonly'] ) }}
            </div>
          </td>
        </tr>
        <tr>
          <td class="table-active">イベント終了時間</td>
          <td>
            {{ Form::text('', date('H:i',strtotime($request->event_finish)) ,['class'=>'form-control','readonly'] ) }}
            {{ Form::hidden('event_finish', $request->event_start ,['class'=>'form-control','readonly'] ) }}
          </td>
        </tr>
        <tr>
          <td class="table-active">イベント名称1</td>
          <td>
            {{ Form::text('event_name1', $request->event_name1 ,['class'=>'form-control','readonly'] ) }}
          </td>
        </tr>
        <tr>
          <td class="table-active">イベント名称2</td>
          <td>
            {{ Form::text('event_name2', $request->event_name2 ,['class'=>'form-control','readonly'] ) }}
          </td>
        </tr>
        <tr>
          <td class="table-active">主催者名</td>
          <td>
            {{ Form::text('event_owner', $request->event_owner ,['class'=>'form-control','readonly'] ) }}
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
            @for ($i = 0; $i < count($s_equipments)/2; $i++) <tr>
              <td>{{$s_equipments[$i*2]}}</td>
              <td>
                {{ Form::text('', $s_equipments[$i*2+1] ,['class'=>'form-control','readonly'] ) }}
              </td>
              </tr>
              @endfor
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
            @for ($i = 0; $i < count($s_services)/2; $i++) <tr>
              <td>{{$s_services[$i*2]}}</td>
              <td>
                {{ Form::text('', $s_services[$i*2+1] ,['class'=>'form-control','readonly'] ) }}
              </td>
              </tr>
              @endfor
          </tbody>
        </table>
      </div>
      <div class='layouts'>
        <table class='table table-bordered' style="table-layout: fixed;">
          <thead>
            <tr>
              <th colspan='2'>レイアウト</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>レイアウト準備</td>
              <td>
                {{ Form::text('', $request->layout_prepare_count ,['class'=>'form-control','readonly'] ) }}
              </td>
            </tr>
            <tr>
              <td>レイアウト片付</td>
              <td>
                {{ Form::text('', $request->layout_clean_count ,['class'=>'form-control','readonly'] ) }}
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class='luggage'>
        <table class='table table-bordered' style="table-layout: fixed;">
          <thead>
            <tr>
              <th colspan='2'>荷物預かり</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>事前に預かる荷物<br>（個数）</td>
              <td>
                {{ Form::text('luggage_count', $request->luggage_count,['class'=>'form-control', 'readonly'] ) }}
              </td>
            </tr>
            <tr>
              <td>事前荷物の到着日<br>午前指定のみ</td>
              <td>
                {{ Form::text('luggage_arrive', $request->luggage_arrive,['class'=>'form-control', 'readonly'] ) }}
              </td>
            </tr>

            <tr>
              <td>事後返送する荷物</td>
              <td>
                {{ Form::text('luggage_return', $request->luggage_return,['class'=>'form-control', 'readonly'] ) }}
              </td>
            </tr>
            <tr>
              <td>事後返送する荷物</td>
              <td>
                {{ Form::text('luggage_price', $request->luggage_price,['class'=>'form-control', 'readonly'] ) }}
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
        <table class="table table-bordered name-table" style="table-layout: fixed;">
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
              {{ Form::text('', ReservationHelper::getAgentCompany($request->agent_id),['class'=>'form-control', 'readonly'] ) }}
              {{ Form::hidden('agent_id', $request->agent_id,['class'=>'form-control'] ) }}
              <p class="is-error-user_id" style="color: red"></p>
            </td>
          </tr>
          <tr>
            <td class="table-active"><label for="name" class=" form_required">担当者氏名<br></label></td>
            <td>
              {{ Form::text('', ReservationHelper::getAgentPerson($request->agent_id),['class'=>'form-control', 'readonly'] ) }}
            </td>
          </tr>
        </table>
        <table class="table table-bordered oneday-table" style="table-layout: fixed;">
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
              {{ Form::text('enduser_company', $request->enduser_company,['class'=>'form-control', 'readonly'] ) }}
            </td>
          </tr>
          <tr>
            <td class="table-active">
              <label for="enduser_incharge" class="">担当者氏名</label>
            </td>
            <td>
              {{ Form::text('enduser_incharge', $request->enduser_incharge,['class'=>'form-control', 'readonly'] ) }}
            </td>
          </tr>
          <tr>
            <td class="table-active">
              <label for="enduser_address" class=" ">住所</label>
            </td>
            <td>
              {{ Form::text('enduser_address', $request->enduser_address,['class'=>'form-control', 'readonly'] ) }}
            </td>
          </tr>
          <tr>
            <td class="table-active">
              <label for="enduser_tel" class="">電話番号</label>
            </td>
            <td>
              {{ Form::text('enduser_tel', $request->enduser_tel,['class'=>'form-control', 'readonly'] ) }}
            </td>
          </tr>
          <tr>
            <td class="table-active">
              <label for="enduser_mail" class=" ">メールアドレス</label>
            </td>
            <td>
              {{ Form::text('enduser_mail', $request->enduser_mail,['class'=>'form-control', 'readonly'] ) }}
            </td>
          </tr>
          <tr>
            <td class="table-active">
              <label for="enduser_attr" class="">利用者属性</label>
            </td>
            <td>
              {{ Form::text('enduser_attr', $request->enduser_attr,['class'=>'form-control', 'readonly'] ) }}
            </td>
          </tr>
        </table>
      </div>
      <table class="table table-bordered sale-table" style="table-layout: fixed;">
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
            {{ Form::text('enduser_charge', $request->enduser_charge,['class'=>'form-control', 'readonly'] ) }}

          </td>
        </tr>
      </table>
      <table class="table table-bordered note-table" style="table-layout: fixed;">
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
            {{-- {{ Form::textarea('attention', $requests['attention'],['class'=>'form-control', 'placeholder'=>'入力してください'] ) }}
            --}}
          </td>
        </tr>
        <tr>
          <td>
            <label for="userNote">顧客情報の備考</label>
            {{-- {{ Form::textarea('user_details', $requests['user_details'],['class'=>'form-control', 'placeholder'=>'入力してください'] ) }}
            --}}
          </td>
        </tr>
        <tr>
          <td>
            <label for="adminNote">管理者備考</label>
            {{-- {{ Form::textarea('admin_details', $requests['admin_details'],['class'=>'form-control', 'placeholder'=>'入力してください'] ) }}
            --}}
          </td>
        </tr>
      </table>
    </div>
  </div>
</div>




{{-- 以下、詳細内訳 --}}
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
              <div class="total_result">{{number_format($request->master_subtotal)}}円
              </div>
            </div>
          </td>
        </tr>
        <tr>
          <td></td>
          <td style="font-size: 16px;">
            <div class="bg-white d-flex justify-content-around align-items-center" style="height: 60px;">
              <div>支払い期日</div>
              <div>{{ReservationHelper::formatDate($request->pay_limit)}}
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
          <table class="table table-borderless" style="table-layout: fixed;">
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
                  {{ Form::text('venue_breakdown_item0', $request->venue_breakdown_item0,['class'=>'form-control', 'readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('venue_breakdown_count0', $request->venue_breakdown_count0,['class'=>'form-control', 'readonly'] ) }}
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        {{-- 以下備品 --}}
        <div class="equipment" style="padding-top: 80px; width:90%; margin:0 auto;">
          <table class="table table-borderless" style="table-layout: fixed;">
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
              @for ($i = 0; $i < count($s_equipments)/2; $i++) <tr>
                <td>
                  {{ Form::text('equipment_breakdown_item'.$i, $s_equipments[$i*2] ,['class'=>'form-control','readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('equipment_breakdown_count'.$i, $s_equipments[$i*2+1] ,['class'=>'form-control','readonly'] ) }}
                </td>
                </tr>
                @endfor
                @for ($i = 0; $i < count($s_services)/2; $i++) <tr>
                  <td>
                    {{ Form::text('equipment_breakdown_item'.$i, $s_services[$i*2] ,['class'=>'form-control','readonly'] ) }}
                  </td>
                  <td>
                    {{ Form::text('equipment_breakdown_count'.$i, $s_services[$i*2+1] ,['class'=>'form-control','readonly'] ) }}
                  </td>
                  </tr>
                  @endfor

                  @if ($request->luggage_count)
                  <tr>
                    <td>
                      {{ Form::text('luggage_item', $request->luggage_item ,['class'=>'form-control','readonly'] ) }}
                    </td>
                    <td>
                      {{ Form::text('luggage_count', $request->luggage_count ,['class'=>'form-control','readonly'] ) }}
                    </td>
                  </tr>
                  @endif
            </tbody>
          </table>
        </div>
        {{-- 以下、レイアウト --}}
        <div class="layout" style="padding-top: 80px; width:90%; margin:0 auto;">
          <table class="table table-borderless" style="table-layout: fixed;">
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
                <td>数量</td>
              </tr>
            </tbody>
            <tbody class="layout_main">
              @if ($request->layout_prepare_count==1)
              <tr>
                <td>
                  {{ Form::text('layout_prepare_item', $request->layout_prepare_item ,['class'=>'form-control','readonly'] ) }}
                </td>
                </td>
                <td>
                  {{ Form::text('layout_prepare_count', $request->layout_prepare_count ,['class'=>'form-control','readonly'] ) }}
                </td>
              </tr>
              @endif
              @if ($request->layout_clean_count==1)
              <tr>
                <td>
                  {{ Form::text('layout_clean_item', $request->layout_clean_item ,['class'=>'form-control','readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('layout_clean_count', $request->layout_clean_count ,['class'=>'form-control','readonly'] ) }}
                </td>
              </tr>
              @endif

            </tbody>
          </table>
        </div>

        {{-- 以下、その他 --}}
        <div class="others" style="padding: 80px 0px 80px 0px; width:90%; margin:0 auto;">
          <table class="table table-borderless" style="table-layout: fixed;">
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
              </tr>
            </tbody>
            <tbody class="others_main">
              @if (!empty($judge))
              @for ($i = 0; $i < count($s_others)/2; $i++) <tr>
                <td>
                  {{ Form::text('others_breakdown_item'.$i, $s_others[$i*2] ,['class'=>'form-control','readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('others_breakdown_count'.$i, $s_others[$i*2+1] ,['class'=>'form-control','readonly'] ) }}
                </td>
                </tr>
                @endfor
                @endif
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
                  {{ Form::text('master_subtotal',$request->master_subtotal ,['class'=>'form-control text-right', 'readonly'] ) }}
                </td>
              </tr>
              <tr>
                <td>消費税：</td>
                <td>
                  {{ Form::text('master_tax',ReservationHelper::getTax($request->master_tax) ,['class'=>'form-control text-right', 'readonly'] ) }}

                </td>
              </tr>
              <tr>
                <td class="font-weight-bold">合計金額</td>
                <td>
                  {{ Form::text('master_total',ReservationHelper::taxAndPrice($request->master_total) ,['class'=>'form-control text-right', 'readonly'] ) }}
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
          <table class="table" style="table-layout: fixed;">
            <tr>
              <td>請求日：</td>
              <td>支払期日
                {{ Form::text('pay_limit', $request->pay_limit,['class'=>'form-control', 'id'=>'datepicker6', 'readonly'] ) }}
              </td>
            </tr>
            <tr>
              <td>
                請求書宛名{{ Form::text('pay_company', $request->pay_company,['class'=>'form-control', 'readonly'] ) }}
              </td>
              <td>
                担当者{{ Form::text('bill_person', ReservationHelper::getAgentPerson($request->agent_id),['class'=>'form-control', 'readonly'] ) }}

              </td>
            </tr>
            <tr>
              <td colspan="2">
                請求書備考{{ Form::textarea('bill_remark', $request->bill_remark,['class'=>'form-control', 'readonly'] ) }}
              </td>
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
          <table class="table" style="table-layout: fixed;">s
            <tr>
              <td>入金状況
                {{ Form::text('paid', $request->paid,['class'=>'form-control', 'readonly'] ) }}
              </td>
              <td>
                入金日
                {{ Form::text('pay_day', $request->pay_day,['class'=>'form-control', 'readonly'] ) }}
              </td>
            </tr>
            <tr>
              <td>振込人名{{ Form::text('pay_person', $request->pay_day,['class'=>'form-control', 'readonly'] ) }}</td>
              <td>入金額{{ Form::text('payment', $request->payment,['class'=>'form-control', 'readonly'] ) }}</td>
            </tr>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="container-field d-flex justify-content-center" style="margin-top: 80px;">
  <a href="javascript:$('#test_post').submit()" class="mt-5 mb-5 btn btn-danger btn-lg mr-5">請求内訳を修正する</a>
  {{Form::submit('確認する', ['class'=>'btn btn-primary d-block btn-lg mt-5 mb-5', 'id'=>'check_submit'])}}
  {{Form::close()}}
</div>
<style>
  .test_post {
    display: none !important;
  }
</style>
{{Form::open(['route' => 'admin.agents_reservations.recalculate', 'method' => 'POST','id'=>'test_post'])}}
{{ Form::hidden('all_requests', json_encode($request->all()),['class'=>'form-control','readonly'])}}
{{-- {{ Form::hidden('others_details', json_encode($others_details),['class'=>'form-control','readonly'])}} --}}
{{Form::submit('', ['class'=>'d-block btn btn-primary btn-lg test_post', 'id'=>'check_submit'])}}
{{Form::close()}}





@endsection