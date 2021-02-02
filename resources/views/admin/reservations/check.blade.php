@extends('layouts.admin.app')
@section('content')

<link href="{{ asset('/css/template.css') }}" rel="stylesheet">
<script src="{{ asset('/js/template.js') }}"></script>



{{ Form::open(['url' => 'admin/reservations', 'method'=>'POST', 'id'=>'agents_calculate_form']) }}
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
            {{ Form::text('reserve_date', $request->reserve_date,['class'=>'form-control','readonly'] ) }}
          </td>
        </tr>
        <tr>
          <td class="table-active form_required">会場</td>
          <td>
            {{ Form::text('', ReservationHelper::getVenue($request->venue_id),['class'=>'form-control', 'readonly'] ) }}
            {{ Form::hidden('venue_id', $request->venue_id,['class'=>'form-control', 'readonly'] ) }}
          </td>
        </tr>
        <tr>
          <td>料金体系</td>
          <td>
            {{ Form::text('', ReservationHelper::priceSystem($request->price_system),['class'=>'form-control', 'readonly'] ) }}
            {{ Form::hidden('price_system', $request->price_system,['class'=>'form-control', 'readonly'] ) }}
          </td>
        </tr>
        <tr>
          <td class="table-active form_required">入室時間</td>
          <td>
            {{ Form::text('', date('H:i',strtotime($request->enter_time)),['class'=>'form-control', 'readonly'] ) }}
            {{ Form::hidden('enter_time', $request->enter_time,['class'=>'form-control', 'readonly'] ) }}
          </td>
        </tr>
        <tr>
          <td class="table-active form_required">退室時間</td>
          <td>
            {{ Form::text('', date('H:i',strtotime($request->leave_time)),['class'=>'form-control', 'readonly'] ) }}
            {{ Form::hidden('leave_time', $request->leave_time,['class'=>'form-control', 'readonly'] ) }}
          </td>
        </tr>
        <tr>
          <td>案内板</td>
          <td>
            {{ Form::text('', $request->board_flag==1?"有り":"無し",['class'=>'form-control', 'readonly'] ) }}
            {{ Form::hidden('board_flag', $request->board_flag,['class'=>'form-control', 'readonly'] ) }}
          </td>
        </tr>
        <tr>
          <td class="table-active">イベント開始時間</td>
          <td>
            {{ Form::text('', date('H:i',strtotime($request->event_start)),['class'=>'form-control', 'readonly'] ) }}
            {{ Form::hidden('event_start', $request->event_start,['class'=>'form-control', 'readonly'] ) }}
          </td>
        </tr>
        <tr>
          <td class="table-active">イベント終了時間</td>
          <td>
            {{ Form::text('', date('H:i',strtotime($request->event_finish)),['class'=>'form-control', 'readonly'] ) }}
            {{ Form::hidden('event_finish', $request->event_finish,['class'=>'form-control', 'readonly'] ) }}
          </td>
        </tr>
        <tr>
          <td class="table-active">イベント名称1</td>
          <td>
            {{ Form::text('event_name1', $request->event_name1,['class'=>'form-control', 'readonly'] ) }}
          </td>
        </tr>
        <tr>
          <td class="table-active">イベント名称2</td>
          <td>
            {{ Form::text('event_name2', $request->event_name2,['class'=>'form-control', 'readonly'] ) }}
          </td>
        </tr>
        <tr>
          <td class="table-active">主催者名</td>
          <td>
            {{ Form::text('event_owner', $request->event_owner,['class'=>'form-control', 'readonly'] ) }}
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
            @if ($s_equipment)
            @foreach ($s_equipment as $key=>$equipment)
            <tr>
              <td>{{$equipment[0]}}</td>
              <td>
                {{ Form::text('', $equipment[2],['class'=>'form-control', 'readonly'] ) }}
              </td>
            </tr>
            @endforeach
            @endif
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
            @if ($s_services)
            @foreach ($s_services as $key=>$service)
            <tr>
              <td>{{$service[0]}}</td>
              <td>
                {{ Form::text('', $service[2]==1?"有り":"無し",['class'=>'form-control', 'readonly'] ) }}
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
            @if ($request->layout_prepare)
            <tr>
              <td>レイアウト準備</td>
              <td>
                {{ Form::text('', $request->layout_prepare==1?"有り":"無し",['class'=>'form-control', 'readonly'] ) }}
                {{ Form::hidden('layout_prepare', $request->layout_prepare,['class'=>'form-control', 'readonly'] ) }}
              </td>
            </tr>
            @endif
            @if ($request->layout_clean)
            <tr>
              <td>レイアウト準備</td>
              <td>
                {{ Form::text('', $request->layout_clean==1?"有り":"無し",['class'=>'form-control', 'readonly'] ) }}
                {{ Form::hidden('layout_clean', $request->layout_clean,['class'=>'form-control', 'readonly'] ) }}
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
            @if ($request->luggage_count)
            <tr>
              <td>事前に預かる荷物<br>（個数）</td>
              <td>
                {{ Form::text('luggage_count', $request->luggage_count,['class'=>'form-control', 'readonly'] ) }}
              </td>
            </tr>
            @endif
            @if ($request->luggage_arrive)
            <tr>
              <td>事前荷物の到着日<br>午前指定のみ</td>
              <td>
                {{ Form::text('luggage_arrive', $request->luggage_arrive,['class'=>'form-control', 'readonly'] ) }}
              </td>
            </tr>
            @endif
            @if ($request->luggage_return)
            <tr>
              <td>事後返送する荷物</td>
              <td>
                {{ Form::text('luggage_return', $request->luggage_return,['class'=>'form-control', 'readonly'] ) }}
              </td>
            </tr>
            @endif
            @if ($request->luggage_price)
            <tr>
              <td>荷物預かり/返送<br>料金</td>
              <td>
                {{ Form::text('luggage_price', $request->luggage_price,['class'=>'form-control', 'readonly'] ) }}
              </td>
            </tr>
            @endif
          </tbody>
        </table>
      </div>

    </div>
    {{-- 右側 --}}
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
              {{ Form::text('', ReservationHelper::getCompany($request->user_id),['class'=>'form-control', 'readonly'] ) }}
              {{ Form::hidden('user_id', $request->user_id,['class'=>'form-control', 'readonly'] ) }}
            </td>
          </tr>
          <tr>
            <td class="table-active"><label for="name" class=" form_required">担当者氏名<br></label></td>
            <td>
              {{ Form::text('', ReservationHelper::getPersonName($request->user_id),['class'=>'form-control', 'readonly'] ) }}
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
              {{ Form::text('in_charge', $request->in_charge,['class'=>'form-control', 'readonly'] ) }}
            </td>
          </tr>
          <tr>
            <td class="table-active"><label for="mobilePhone" class=" form_required">携帯番号</label></td>
            <td>
              {{ Form::text('tel', $request->tel,['class'=>'form-control', 'readonly'] ) }}
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
            {{ Form::text('', $request->email_flag==1?"有り":"無し",['class'=>'form-control', 'readonly'] ) }}
            {{ Form::hidden('email_flag', $request->email_flag,['class'=>'form-control', 'readonly'] ) }}
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
            {{ Form::text('', $request->cost."%",['class'=>'form-control', 'readonly'] ) }}
            {{ Form::hidden('cost', $request->cost,['class'=>'form-control', 'readonly'] ) }}
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
            {{ Form::textarea('discount_condition', $request->discount_condition,['class'=>'form-control', 'readonly'] ) }}
          </td>
        </tr>
        <tr class="caution">
          <td>
            <label for="caution">注意事項</label>
            {{ Form::textarea('attention', $request->attention,['class'=>'form-control', 'readonly'] ) }}
          </td>
        </tr>
        <tr>
          <td>
            <label for="userNote">顧客情報の備考</label>
            {{ Form::textarea('user_details', $request->user_details,['class'=>'form-control', 'readonly'] ) }}
          </td>
        </tr>
        <tr>
          <td>
            <label for="adminNote">管理者備考</label>
            {{ Form::textarea('admin_details', $request->admin_details,['class'=>'form-control', 'readonly'] ) }}
          </td>
        </tr>
      </table>
    </div>
  </div>
</div>
<style>
  .bill_head {
    background: #127059;
    table-layout: fixed;
    border: solid 1px gray;
  }

  .bill_head p {
    height: 50px;
  }

  .plus_acordion::before {
    content: '＋';
  }

  .minus_acordion::before {
    content: '-';
  }

  .head {
    background: #C1C1C2;
    table-layout: fixed;
    border: solid 1px gray;
    height: 60px;
  }

  .venue_head,
  .equipment_head,
  .layout_head {
    border-bottom: solid 1px gray !important;
  }

  .venue_discount,
  .equipment_discount,
  .layout_discount,
  .others_discount {
    border: solid 1px gray !important;
  }

  .bill {
    border: solid 1px gray;
  }

  .information .main {
    border: solid 1px gray;
  }

  .paid .head {
    background: #EB9C32;
    color: white;
  }

  .paid .main {
    border: solid 1px gray;
  }
</style>
{{-- 丸岡さんカスタム --}}
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
              <div class="total_result">{{number_format($request->master_total)}}円</div>
            </div>
          </td>
        </tr>
        <tr>
          <td></td>
          <td style="font-size: 16px;">
            <div class="bg-white d-flex justify-content-around align-items-center" style="height: 60px;">
              <div>支払い期日</div>
              <div>
                {{ReservationHelper::formatDate($request->pay_limit)}}
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
                  ■会場料金
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
              @for ($i = 0; $i < (count($venue_details)/4); $i++) <tr>
                <td>
                  {{ Form::text('venue_breakdown_item'.$i, $venue_details[$i*4],['class'=>'form-control', 'readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('venue_breakdown_cost'.$i, $venue_details[($i*4)+1],['class'=>'form-control', 'readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('venue_breakdown_count'.$i, $venue_details[($i*4)+2],['class'=>'form-control', 'readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('venue_breakdown_subtotal'.$i, $venue_details[($i*4)+3],['class'=>'form-control', 'readonly'] ) }}
                </td>
                </tr>
                @endfor
            </tbody>
            <tbody class="venue_result">
              <tr>
                <td colspan="2"></td>
                <td colspan="2">合計
                  {{ Form::text('venue_price', $request->venue_price,['class'=>'form-control col-xs-3', 'readonly'] ) }}
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        {{-- 以下備品 --}}
        @if ($equipment_details)
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
              @for ($i = 0; $i < (count($equipment_details)/4); $i++) <tr>
                <td>
                  {{ Form::text('equipment_breakdown_item'.$i, $equipment_details[$i*4],['class'=>'form-control', 'readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('equipment_breakdown_cost'.$i, $equipment_details[($i*4)+1],['class'=>'form-control', 'readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('equipment_breakdown_count'.$i, $equipment_details[($i*4)+2],['class'=>'form-control', 'readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('equipment_breakdown_subtotal'.$i, $equipment_details[($i*4)+3],['class'=>'form-control', 'readonly'] ) }}
                </td>
                </tr>
                @endfor

                @for ($i = 0; $i < (count($service_details)/4); $i++) <tr>
                  <td>
                    {{ Form::text('service_breakdown_item'.$i, $service_details[$i*4],['class'=>'form-control', 'readonly'] ) }}
                  </td>
                  <td>
                    {{ Form::text('service_breakdown_cost'.$i, $service_details[($i*4)+1],['class'=>'form-control', 'readonly'] ) }}
                  </td>
                  <td>
                    {{ Form::text('service_breakdown_count'.$i, $service_details[($i*4)+2],['class'=>'form-control', 'readonly'] ) }}
                  </td>
                  <td>
                    {{ Form::text('service_breakdown_subtotal'.$i, $service_details[($i*4)+3],['class'=>'form-control', 'readonly'] ) }}
                  </td>
                  </tr>
                  @endfor
                  @if ($request->luggage_subtotal)
                  <tr>
                    <td>
                      {{ Form::text('luggage_item', $request->luggage_item,['class'=>'form-control', 'readonly'] ) }}
                    </td>
                    <td>
                      {{ Form::text('luggage_cost', $request->luggage_cost,['class'=>'form-control', 'readonly'] ) }}
                    </td>
                    <td>
                      {{ Form::text('', 1,['class'=>'form-control', 'readonly'] ) }}
                    </td>
                    <td>
                      {{ Form::text('luggage_subtotal', $request->luggage_subtotal,['class'=>'form-control', 'readonly'] ) }}
                    </td>
                  </tr>
                  @endif
            </tbody>
            <tbody class="equipment_result">
              <tr>
                <td colspan="2"></td>
                <td colspan="2">合計
                  {{ Form::text('equipment_price', $request->equipment_price,['class'=>'form-control', 'readonly'] ) }}
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        @endif


        {{-- 以下、レイアウト --}}
        @if ($request->layout_prepare_subtotal||$request->layout_clean_subtotal)
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
              @if ($request->layout_prepare_subtotal)
              <tr>
                <td>
                  {{ Form::text('layout_prepare_item', $request->layout_prepare_item,['class'=>'form-control', 'readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('layout_prepare_cost', $request->layout_prepare_cost,['class'=>'form-control', 'readonly'] )}}
                </td>
                <td>
                  {{ Form::text('layout_prepare_count', $request->layout_prepare_count,['class'=>'form-control', 'readonly'] )}}
                </td>
                <td>
                  {{ Form::text('layout_prepare_subtotal', $request->layout_prepare_subtotal,['class'=>'form-control', 'readonly'] )}}
                </td>
              </tr>
              @endif
              @if ($request->layout_clean_subtotal)
              <tr>
                <td>
                  {{ Form::text('layout_clean_item', $request->layout_clean_item,['class'=>'form-control', 'readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('layout_clean_cost', $request->layout_clean_cost,['class'=>'form-control', 'readonly'] )}}
                </td>
                <td>
                  {{ Form::text('layout_clean_count', $request->layout_clean_count,['class'=>'form-control', 'readonly'] )}}
                </td>
                <td>
                  {{ Form::text('layout_clean_subtotal', $request->layout_clean_subtotal,['class'=>'form-control', 'readonly'] )}}
                </td>
              </tr>
              @endif
              @if ($request->layout_breakdown_discount_subtotal)
              <tr>
                <td>
                  {{ Form::text('layout_breakdown_discount_item', $request->layout_breakdown_discount_item,['class'=>'form-control', 'readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('layout_breakdown_discount_cost', $request->layout_breakdown_discount_cost,['class'=>'form-control', 'readonly'] )}}
                </td>
                <td>
                  {{ Form::text('layout_breakdown_discount_count', $request->layout_breakdown_discount_count,['class'=>'form-control', 'readonly'] )}}
                </td>
                <td>
                  {{ Form::text('layout_breakdown_discount_subtotal', $request->layout_breakdown_discount_subtotal,['class'=>'form-control', 'readonly'] )}}
                </td>
              </tr>
              @endif
            </tbody>
            <tbody class="layout_result">
              <tr>
                <td colspan="2"></td>
                <td colspan="2">合計
                  {{ Form::text('layout_price',$request->layout_price,['class'=>'form-control', 'readonly'] ) }}
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        @endif

        {{-- 以下、その他 --}}
        @if (ReservationHelper::judgeArrayEmpty($others_details))
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
              @for ($i = 0; $i < (count($others_details)/4); $i++) <tr>
                <td>
                  {{ Form::text('others_breakdown_item'.$i, $others_details[$i*4],['class'=>'form-control', 'readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('others_breakdown_cost'.$i, $others_details[($i*4)+1],['class'=>'form-control', 'readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('others_breakdown_count'.$i, $others_details[($i*4)+2],['class'=>'form-control', 'readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('others_breakdown_subtotal'.$i, $others_details[($i*4)+3],['class'=>'form-control', 'readonly'] ) }}
                </td>
                </tr>
                @endfor
            </tbody>
            <tbody class="others_result">
              <tr>
                <td colspan="2"></td>
                <td colspan="3">合計
                  {{ Form::text('others_price', $request->others_price,['class'=>'form-control', 'readonly'] ) }}
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        @endif
        {{-- 以下、総合計 --}}
        <div class="bill_total d-flex justify-content-end"
          style="padding: 80px 0px 80px 0px; width:90%; margin:0 auto;">
          <div style="width: 60%;">
            <table class="table text-right" style="table-layout: fixed; font-size:16px;">
              <tr>
                <td>小計：</td>
                <td>
                  {{ Form::text('master_subtotal', $request->master_subtotal,['class'=>'form-control', 'readonly'] ) }}
                </td>
              </tr>
              <tr>
                <td>消費税：</td>
                <td>
                  {{ Form::text('master_tax', $request->master_tax,['class'=>'form-control', 'readonly'] ) }}
                </td>
              </tr>
              <tr>
                <td class="font-weight-bold">合計金額</td>
                <td>
                  {{ Form::text('master_total', $request->master_total,['class'=>'form-control', 'readonly'] ) }}
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
              <td>支払期日
                {{ Form::text('payment_limit', $request->pay_limit,['class'=>'form-control', 'readonly'] ) }}
              </td>
            </tr>
            <tr>
              <td>請求書宛名
                {{ Form::text('bill_company', $request->pay_company,['class'=>'form-control', 'readonly'] ) }}
              </td>
              <td>
                担当者
                {{ Form::text('bill_person', $request->bill_person,['class'=>'form-control', 'readonly'] ) }}

              </td>
            </tr>
            <tr>
              <td colspan="2">請求書備考
                {{ Form::textarea('bill_remark', $request->bill_remark,['class'=>'form-control', 'readonly'] ) }}
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
          <table class="table" style="table-layout: fixed;">
            <tr>
              <td>入金状況
                {{Form::text('',$request->paid==1?"支払済":"未払",['class'=>'form-control','readonly'])}}
                {{Form::hidden('paid',$request->paid,['class'=>'form-control','readonly'])}}
              </td>
              <td>
                入金日{{ Form::text('pay_day', $request->pay_day,['class'=>'form-control', 'readonly'] ) }}
              </td>
            </tr>
            <tr>
              <td>振込人名
                {{ Form::text('pay_person', $request->pay_person,['class'=>'form-control','readonly'] ) }}
              </td>
              <td>入金額
                {{ Form::text('payment', $request->payment,['class'=>'form-control','readonly'])}}
              </td>
            </tr>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>



<div class="container-field d-flex justify-content-center" style="margin-top: 80px;">
  <a href="javascript:$('#test_post').submit()" class="btn btn-danger btn-lg d-block mr-5">請求内訳を修正する</a>

  {{Form::submit('予約を作成する', ['class'=>'d-block btn btn-primary btn-lg', 'id'=>'check_submit'])}}
  {{Form::close()}}

</div>

<style>
  .test_post {
    display: none !important;
  }
</style>


{{Form::open(['route' => 'admin.reservations.create', 'method' => 'GET','id'=>'test_post'])}}
{{ Form::hidden('all_requests', json_encode($request->all()),['class'=>'form-control','readonly'])}}
{{ Form::hidden('venue_number_discount', $request->venue_number_discount,['class'=>'form-control','readonly'])}}
{{Form::submit('', ['class'=>'d-block btn btn-primary btn-lg test_post', 'id'=>'check_submit'])}}
{{Form::close()}}





@endsection