@extends('layouts.admin.app')
@section('content')

<link href="{{ asset('/css/template.css') }}" rel="stylesheet">
<script src="{{ asset('/js/template.js') }}"></script>

  {{ Form::open(['url' => 'admin/reservations/'.$id, 'method'=>'PUT', 'id'=>'agents_calculate_form']) }}
  @csrf
  <section class="mt-5">
    <div class="row">
      <div class="col">
        <table class="table table-bordered">
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
              <td class="table-active">料金体系</td>
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
          </tbody>
        </table>
        <div class="equipemnts">
          <table class="table table-bordered" style="table-layout: fixed;">
          <thead class="accordion-ttl">
              <tr>
                <th colspan="2">
                  <p class="title-icon fw-bolder py-1">
                    <i class="fas fa-wrench icon-size"></i>有料備品
                  </p>
                </th>
              </tr>
            </thead>
            <tbody class="accordion-wrap">
              @foreach ($venue->getEquipments() as $key=>$equipment)
              <tr>
                <td>{{$equipment->item}}</td>
                <td class="table-active">
                  @for ($i = 0; $i < $equ_breakdowns; $i++) @if ($equipment->
                    item==$request->{"equipment_breakdown_item".$i})
                    {{ Form::text('equipment_breakdown'.$key, $request->{'equipment_breakdown_count'.$i},['class'=>'form-control', 'readonly'] ) }}
                    @break
                    @elseif($i==$equ_breakdowns-1)
                    {{ Form::text('equipment_breakdown'.$key, "0",['class'=>'form-control', 'readonly'] ) }}
                    @endif
                    @endfor
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        <div class="services">
          <table class="table table-bordered" style="table-layout: fixed;">
          <thead class="accordion-ttl">
              <tr>
                <th colspan="2">
                  <p class="title-icon fw-bolder py-1">
                    <i class="fas fa-hand-holding-heart icon-size"></i>有料サービス
                  </p>
                </th>
              </tr>
            </thead>
            <tbody class="accordion-wrap">
              @foreach ($venue->getServices() as $key=>$service)
              <tr>
                <td class="table-active">{{$service->item}}</td>
                <td>
                  @for ($i = 0; $i < $ser_breakdowns; $i++) @if ($service->
                    item==$request->{"services_breakdown_item".$i})
                    {{ Form::text('services_breakdown'.$key, $request->{'services_breakdown_count'.$i},['class'=>'form-control', 'readonly'] ) }}
                    @break
                    @elseif($i==$ser_breakdowns-1)
                    {{ Form::text('services_breakdown'.$key, 0,['class'=>'form-control', 'readonly'] ) }}
                    @endif
                    @endfor
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        <div class="layouts">
          <table class="table table-bordered" style="table-layout:fixed;">
          <thead>
              <tr>
                <th colspan='2'>
                  <p class="title-icon py-1">
                    <i class="fas fa-th icon-size"></i>レイアウト
                  </p>
                </th>
              </tr>
            </thead>
            <tbody>
              <tr>
              <td class="table-active">
                  準備
                </td>
                <td>
                  {{ Form::text('', $request->layout_prepare_count==1?"有り":"無し",['class'=>'form-control', 'readonly'] ) }}
                  {{ Form::hidden('layout_prepare', $request->layout_prepare,['class'=>'form-control', 'readonly'] ) }}
                </td>
              </tr>
              <tr>
                <td class="table-active">片付</td>
                <td>
                  {{ Form::text('', $request->layout_clean_count==1?"有り":"無し",['class'=>'form-control', 'readonly'] ) }}
                  {{ Form::hidden('layout_clean', $request->layout_clean,['class'=>'form-control', 'readonly'] ) }}
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="luggage">
          <table class="table table-bordered" style="table-layout:fixed;">
          <thead>
              <tr>
                <th colspan='2'>
                  <p class="title-icon">
                    <i class="fas fa-suitcase-rolling icon-size"></i>荷物預り
                  </p>
                </th>
              </tr>
            </thead>
            <tbody>
              @if ($request->luggage_count)
              <tr>
                <td class="table-active">事前に預かる荷物<br>（個数）</td>
                <td>
                  {{ Form::text('luggage_count', $request->luggage_count,['class'=>'form-control', 'readonly'] ) }}
                </td>
              </tr>
              @endif
              @if ($request->luggage_arrive)
              <tr>
                <td class="table-active">事前荷物の到着日<br>午前指定のみ</td>
                <td>
                  {{ Form::text('luggage_arrive', $request->luggage_arrive,['class'=>'form-control', 'readonly'] ) }}
                </td>
              </tr>
              @endif
              @if ($request->luggage_return)
              <tr>
                <td class="table-active">事後返送する荷物</td>
                <td>
                  {{ Form::text('luggage_return', $request->luggage_return,['class'=>'form-control', 'readonly'] ) }}
                </td>
              </tr>
              @endif
              @if ($request->luggage_price)
              <tr>
                <td class="table-active">荷物預り/返送<br>料金</td>
                <td>
                  {{ Form::text('luggage_price', $request->luggage_price,['class'=>'form-control', 'readonly'] ) }}
                </td>
              </tr>
              @endif
            </tbody>
          </table>
        </div>
      </div>

      <div class="col">
        <table class="table table-bordered name-table" style="table-layout:fixed;">
          <tbody>
            <tr>
              <td colspan="2">
                <div class="d-flex align-items-center justify-content-between">
                  <p class="title-icon">
                    <i class="far fa-id-card icon-size" aria-hidden="true"></i>顧客情報
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
          </tbody>
        </table>
        <table class="table table-bordered oneday-table" style="table-layout:fixed;">
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
                {{ Form::text('in_charge', $request->in_charge,['class'=>'form-control', 'readonly'] ) }}
              </td>
            </tr>
            <tr>
              <td class="table-active"><label for="mobilePhone" class=" form_required">携帯番号</label></td>
              <td>
                {{ Form::text('tel', $request->tel,['class'=>'form-control', 'readonly'] ) }}
              </td>
            </tr>
          </tbody>
        </table>

        <table class="table table-bordered mail-table" style="table-layout:fixed;">
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
                {{ Form::text('', $request->email_flag==1?"有り":"無し",['class'=>'form-control', 'readonly'] ) }}
                {{ Form::hidden('email_flag', $request->email_flag,['class'=>'form-control', 'readonly'] ) }}
              </td>
            </tr>
          </tbody>
        </table>
        <table class="table table-bordered sale-table" style="table-layout:fixed;">
          <tbody>
            <tr>
              <td colspan="2">
                <p class="title-icon">
                  <i class="fas fa-yen-sign icon-size" aria-hidden="true"></i>
                  売上原価
                  <span class="annotation">（提携会場を選択した場合、提携会場で設定した原価率が適応されます）</span>
                </p>
              </td>
            </tr>
            <tr>
              <td class="table-active"><label for="cost">原価率</label></td>
              <td>
                {{ Form::text('', $request->cost."%",['class'=>'form-control', 'readonly'] ) }}
                {{ Form::hidden('cost', $request->cost,['class'=>'form-control', 'readonly'] ) }}
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
                  <i class="fas fa-envelope icon-size" aria-hidden="true"></i>備考
                </p>
              </td>
            </tr>
            <tr>
              <td>
                <label for="userNote">申し込みフォーム備考</label>
                {{ Form::textarea('user_details', $request->user_details,['class'=>'form-control', 'readonly'] ) }}
              </td>
            </tr>
            <tr>
              <td>
                <label for="adminNote">管理者備考</label>
                {{ Form::textarea('admin_details', $request->admin_details,['class'=>'form-control', 'readonly'] ) }}
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </section>

  <section class="mt-5">
    <div class="bill">
      <div class="bill_head">
        <table class="table bill_table">
          <tbody>
            <tr>
              <td>
                <h2 class="text-white">
                  請求書No
                </h2>
              </td>
              <td>
                <dl class="ttl_box">
                  <dt>合計金額</dt>
                  <dd class="total_result">{{number_format($request->master_total)}}円</dd>
                </dl>
              </td>
              <td>
                <dl class="ttl_box">
                  <dt>支払い期日</dt>
                  <dd class="total_result">
                    {{ReservationHelper::formatDate($request->pay_limit)}}
                  </dd>
                </dl>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="bill_details">
        <div class="head d-flex">
          <div class="accordion_btn">
            <i class="fas fa-plus bill_icon_size hide" aria-hidden="true"></i>
            <i class="fas fa-minus bill_icon_size" aria-hidden="true"></i>
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
              <tbody>
                <tr>
                  <td>
                    <h4 class="billdetails_content_ttl">
                      会場料
                    </h4>
                  </td>
                </tr>
              </tbody>
              <tbody class="venue_head">
                <tr>
                  <td>内容</td>
                  <td>単価</td>
                  <td>数量</td>
                  <td>金額</td>
                </tr>
              </tbody>
              <tbody class="venue_main">
                @for ($i = 0; $i < $venue_details; $i++) <tr>
                  <td>
                    {{ Form::text('venue_breakdown_item'.$i, $request->{'venue_breakdown_item'.$i},['class'=>'form-control', 'readonly'] ) }}
                  </td>
                  <td>
                    {{ Form::text('venue_breakdown_cost'.$i, $request->{'venue_breakdown_cost'.$i},['class'=>'form-control', 'readonly'] ) }}
                  </td>
                  <td>
                    {{ Form::text('venue_breakdown_count'.$i, $request->{'venue_breakdown_count'.$i},['class'=>'form-control', 'readonly'] ) }}
                  </td>
                  <td>
                    {{ Form::text('venue_breakdown_subtotal'.$i, $request->{'venue_breakdown_subtotal'.$i},['class'=>'form-control', 'readonly'] ) }}
                  </td>
                  </tr>
                  @endfor
                  @if ($request->venue_breakdown_discount_item)
                  <tr>
                    <td>
                      {{ Form::text('venue_breakdown_discount_item', $request->venue_breakdown_discount_item,['class'=>'form-control', 'readonly'] ) }}
                    </td>
                    <td>
                      {{ Form::text('venue_breakdown_discount_cost', $request->venue_breakdown_discount_cost,['class'=>'form-control', 'readonly'] ) }}
                    </td>
                    <td>
                      {{ Form::text('venue_breakdown_discount_count', $request->venue_breakdown_discount_count,['class'=>'form-control', 'readonly'] ) }}
                    </td>
                    <td>
                      {{ Form::text('venue_breakdown_discount_subtotal', $request->venue_breakdown_discount_subtotal,['class'=>'form-control', 'readonly'] ) }}
                    </td>
                  </tr>

                  @endif
              </tbody>
              <tbody class="venue_result">
                <tr>
                  <td colspan="2"></td>
                  <td colspan="2">
                    <p class="text-right">
                      <span>合計：</span>
                      {{ Form::text('venue_price', $request->venue_price,['class'=>'form-control col-xs-3', 'readonly'] ) }}
                    </p>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>

          @if ($equipment_details!="" ||$service_details!="" ||$request->luggage_price)
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
                @for ($ii = 0; $ii < $equipment_details; $ii++) <tr>
                  <td>
                    {{ Form::text('equipment_breakdown_item'.$ii, $request->{'equipment_breakdown_item'.$ii},['class'=>'form-control', 'readonly'] ) }}
                  </td>
                  <td>
                    {{ Form::text('equipment_breakdown_cost'.$ii, $request->{'equipment_breakdown_cost'.$ii},['class'=>'form-control', 'readonly'] ) }}
                  </td>
                  <td>
                    {{ Form::text('equipment_breakdown_count'.$ii, $request->{'equipment_breakdown_count'.$ii},['class'=>'form-control', 'readonly'] ) }}
                  </td>
                  <td>
                    {{ Form::text('equipment_breakdown_subtotal'.$ii, $request->{'equipment_breakdown_subtotal'.$ii},['class'=>'form-control', 'readonly'] ) }}
                  </td>
                  </tr>
                  @endfor

                  @for ($ss = 0; $ss < $service_details; $ss++) <tr>
                    <td>
                      {{ Form::text('service_breakdown_item'.$ss, $request->{'services_breakdown_item'.$ss},['class'=>'form-control', 'readonly'] ) }}
                    </td>
                    <td>
                      {{ Form::text('service_breakdown_cost'.$ss, $request->{'services_breakdown_cost'.$ss},['class'=>'form-control', 'readonly'] ) }}
                    </td>
                    <td>
                      {{ Form::text('service_breakdown_count'.$ss, $request->{'services_breakdown_count'.$ss},['class'=>'form-control', 'readonly'] ) }}
                    </td>
                    <td>
                      {{ Form::text('service_breakdown_subtotal'.$ss, $request->{'services_breakdown_subtotal'.$ss},['class'=>'form-control', 'readonly'] ) }}
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
                    @if ($request->equipment_breakdown_discount_item)
                    <tr>
                      <td>
                        {{ Form::text('equipment_breakdown_discount_item', $request->equipment_breakdown_discount_item,['class'=>'form-control', 'readonly'] ) }}
                      </td>
                      <td>
                        {{ Form::text('equipment_breakdown_discount_cost', $request->equipment_breakdown_discount_cost,['class'=>'form-control', 'readonly'] ) }}
                      </td>
                      <td>
                        {{ Form::text('equipment_breakdown_discount_count', $request->equipment_breakdown_discount_count,['class'=>'form-control', 'readonly'] ) }}
                      </td>
                      <td>
                        {{ Form::text('equipment_breakdown_discount_subtotal', $request->equipment_breakdown_discount_subtotal,['class'=>'form-control', 'readonly'] ) }}
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

          @if ($request->layout_prepare_subtotal||$request->layout_clean_subtotal)
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

          @if ($others_details!="")
          <div class="others billdetails_content">
            <table class="table table-borderless">
            <tr>
                <td>
                  <h4 class="billdetails_content_ttl">
                    その他
                  </h4>
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
                @for ($other = 0; $other < $others_details; $other++) <tr>
                  <td>
                    {{ Form::text('others_breakdown_item'.$other, $request->{'others_input_item'.$other},['class'=>'form-control', 'readonly'] ) }}
                  </td>
                  <td>
                    {{ Form::text('others_breakdown_cost'.$other, $request->{'others_input_cost'.$other},['class'=>'form-control', 'readonly'] ) }}
                  </td>
                  <td>
                    {{ Form::text('others_breakdown_count'.$other, $request->{'others_input_count'.$other},['class'=>'form-control', 'readonly'] ) }}
                  </td>
                  <td>
                    {{ Form::text('others_breakdown_subtotal'.$other, $request->{'others_input_subtotal'.$other},['class'=>'form-control', 'readonly'] ) }}
                  </td>
                  </tr>
                  @endfor
              </tbody>
              <tbody class="others_result">
                <tr>
                  <td colspan="3"></td>
                  <td colspan="1">合計
                    {{ Form::text('others_price', $request->others_price,['class'=>'form-control', 'readonly'] ) }}
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          @endif

          <div class="bill_total">
            <table class="table">
              <tbody>
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
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>


    <div class="information">
      <div class="information_details">
        <div class="head d-flex">
          <div class="accordion_btn">
            <i class="fas fa-plus bill_icon_size hide" aria-hidden="true"></i>
            <i class="fas fa-minus bill_icon_size" aria-hidden="true"></i>
          </div>
          <div class="billdetails_ttl">
            <h3>
              請求書情報
            </h3>
          </div>
        </div>
        <div class="main">
          <div class="informations billdetails_content py-3">
            <table class="table">
              <tbody>
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
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <div class="paid">
      <div class="paid_details">
        <div class="head d-flex">
          <div class="d-flex align-items-center">
            <h3 class="pl-3">
              入金情報
            </h3>
          </div>
        </div>
        <div class="main">
          <div class="paids billdetails_content py-3">
            <table class="table" style="table-layout: fixed;">
              <tbody>
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
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </section>

  <div class="container-field d-flex justify-content-center mt-5">
    <a href="javascript:$('#back').submit()" class="btn more_btn4_lg d-block mr-5">請求内訳を修正する</a>

    {{Form::submit('保存する', ['class'=>'btn more_btn_lg d-block', 'id'=>'check_submit'])}}
    {{Form::close()}}

  </div>

  <style>
    .test_post {
      display: none !important;
    }
  </style>

  {{ Form::open(['url' => 'admin/reservations/'.$id.'/edit_calculate', 'method'=>'POST', 'id'=>'back']) }}
  @csrf
  {{ Form::hidden('reserve_date', $request->reserve_date,['class'=>'form-control','readonly'] ) }}
  {{ Form::hidden('venue_id', $request->venue_id ) }}
  {{ Form::hidden('price_system', $request->price_system ) }}
  {{ Form::hidden('enter_time', $request->enter_time ) }}
  {{ Form::hidden('leave_time', $request->leave_time ) }}
  {{ Form::hidden('board_flag', $request->board_flag ) }}
  {{ Form::hidden('event_start', $request->event_start ) }}
  {{ Form::hidden('event_finish', $request->event_finish ) }}
  {{ Form::hidden('event_name1', $request->event_name1 ) }}
  {{ Form::hidden('event_name2', $request->event_name2 ) }}
  {{ Form::hidden('event_owner', $request->event_owner ) }}

  @foreach ($venue->getEquipments() as $key=>$equipment)
  @for ($i = 0; $i < $equ_breakdowns; $i++) @if ($equipment->
    item==$request->{"equipment_breakdown_item".$i})
    {{ Form::hidden('equipment_breakdown'.$key, $request->{'equipment_breakdown_count'.$i} ) }}
    @break
    @elseif($i==$equ_breakdowns-1)
    {{ Form::hidden('equipment_breakdown'.$key, "0" ) }}
    @endif
    @endfor
    @endforeach



    @foreach ($venue->getServices() as $key=>$service)
    @for ($i = 0; $i < $ser_breakdowns; $i++) @if ($service->item==$request->{"services_breakdown_item".$i})
      {{ Form::hidden('services_breakdown'.$key, $request->{'services_breakdown_count'.$i} ) }}
      @break
      @elseif($i==$ser_breakdowns-1)
      {{ Form::hidden('services_breakdown'.$key, 0 ) }}
      @endif
      @endfor
      @endforeach




      {{ Form::hidden('layout_prepare', $request->layout_prepare ) }}
      {{ Form::hidden('layout_clean', $request->layout_clean ) }}
      @if ($request->luggage_count)
      {{ Form::hidden('luggage_count', $request->luggage_count ) }}
      @endif
      @if ($request->luggage_arrive)
      {{ Form::hidden('luggage_arrive', $request->luggage_arrive ) }}
      @endif
      @if ($request->luggage_return)
      {{ Form::hidden('luggage_return', $request->luggage_return ) }}
      @endif
      @if ($request->luggage_price)
      {{ Form::hidden('luggage_price', $request->luggage_price ) }}
      @endif
      {{ Form::hidden('user_id', $request->user_id ) }}
      {{ Form::hidden('in_charge', $request->in_charge ) }}
      {{ Form::hidden('tel', $request->tel ) }}
      {{ Form::hidden('email_flag', $request->email_flag ) }}
      {{ Form::hidden('cost', $request->cost ) }}
      {{ Form::hidden('discount_condition', $request->discount_condition ) }}
      {{ Form::hidden('attention', $request->attention ) }}
      {{ Form::hidden('user_details', $request->user_details ) }}
      {{ Form::hidden('admin_details', $request->admin_details ) }}
      {{Form::close()}}
@endsection