@extends('layouts.admin.app')
@section('content')

<link href="{{ asset('/css/template.css') }}" rel="stylesheet">
<script src="{{ asset('/js/template.js') }}"></script>
<script src="{{ asset('/js/admin/validation.js') }}"></script>

@if (session('flash_message'))
<div class="alert alert-danger">
  <ul>
    <li> {!! session('flash_message') !!} </li>
  </ul>
</div>
@endif



{{ Form::open(['url' => 'admin/reservations', 'method'=>'POST', 'id'=>'agents_calculate_form']) }}
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
            <td class="table-active">利用日</td>
            <td>
              {{$value["reserve_date"]}}
            </td>
          </tr>
          <tr>
            <td class="table-active">会場</td>
            <td>
              {{ReservationHelper::getVenue($value["venue_id"])}}
            </td>
          </tr>
          <tr>
            <td class="table-active">料金体系</td>
            <td>
              {{ReservationHelper::priceSystem($value['price_system']) }}
            </td>
          </tr>
          <tr>
            <td class="table-active">入室時間</td>
            <td>
              {{date('H:i',strtotime($value['enter_time'])) }}
            </td>
          </tr>
          <tr>
            <td class="table-active">退室時間</td>
            <td>
              {{date('H:i',strtotime($value['leave_time'])) }}
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
              {{$value['board_flag']==1?"有り":"無し" }}
            </td>
          </tr>
          <tr>
            <td class="table-active">イベント開始時間</td>
            <td>
              @if (!empty($value['event_start']))
              {{date('H:i',strtotime($value['event_start']))}}
              @endif
            </td>
          </tr>
          <tr>
            <td class="table-active">イベント終了時間</td>
            <td>
              @if (!empty($value['event_finish']))
              {{date('H:i',strtotime($value['event_finish']))}}
              @endif
            </td>
          </tr>
          <tr>
            <td class="table-active">イベント名称1</td>
            <td>
              @if (!empty($value['event_name1']))
              {{date('H:i',strtotime($value['event_name1']))}}
              @endif
            </td>
          </tr>
          <tr>
            <td class="table-active">イベント名称2</td>
            <td>
              @if (!empty($value['event_name2']))
              {{date('H:i',strtotime($value['event_name2']))}}
              @endif
            </td>
          </tr>
          <tr>
            <td class="table-active">主催者名</td>
            <td>
              @if (!empty($value['event_owner']))
              {{date('H:i',strtotime($value['event_owner']))}}
              @endif
            </td>
          </tr>
        </tbody>
      </table>
      <div class="equipemnts">
        <table class="table table-bordered" style="table-layout: fixed;">
          <thead class="accordion-ttl">
            <tr>
              <th colspan="2">
                <p class="title-icon fw-bolder">
                  <i class="fas fa-wrench icon-size fa-fw" aria-hidden="true"></i>有料備品
                </p>
              </th>
            </tr>
          </thead>
          <tbody class="accordion-wrap">
            @foreach ($venue->getEquipments() as $key=>$equipment)
            <tr>
              <td class="table-active">{{$equipment->item}}</td>
              <td>
                {{$value['equipment_breakdown'.$key]}}
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
                <p class="title-icon fw-bolder">
                  <i class="fas fa-hand-holding-heart icon-size" aria-hidden="true"></i>有料サービス
                </p>
              </th>
            </tr>
          </thead>
          <tbody class="accordion-wrap">
            @foreach ($venue->getServices() as $key=>$service)
            <tr>
              <td class="table-active">{{$service->item}}</td>
              <td>
                {{$value['services_breakdown'.$key]==1?"あり":"なし"}}
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>

      @if ($venue->layout!=0)
      <div class="layouts">
        <table class="table table-bordered" style="table-layout:fixed;">
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
            <tr>
              <td class="table-active">準備</td>
              <td>
                {{$value['layout_prepare']==1?"あり":"なし"}}

              </td>
            </tr>
            <tr>
              <td class="table-active">片付</td>
              <td>
                {{$value['layout_clean']==1?"あり":"なし"}}
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      @endif

      @if ($venue->luggage_flag!=0)
      <div class="luggage">
        <table class="table table-bordered" style="table-layout:fixed;">
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
            @if ($value['luggage_count'])
            <tr>
              <td class="table-active">事前に預かる荷物<br>（個数）</td>
              <td>
                {{$value['luggage_count']}}
              </td>
            </tr>
            @endif
            @if ($value['luggage_arrive'])
            <tr>
              <td class="table-active">事前荷物の到着日<br>午前指定のみ</td>
              <td>
                {{ReservationHelper::formatDate($value['luggage_arrive'])}}
              </td>
            </tr>
            @endif
            @if ($value['luggage_return'])
            <tr>
              <td class="table-active">事後返送する荷物</td>
              <td>
                {{$value['luggage_return']}}
              </td>
            </tr>
            @endif
            @if ($value['luggage_price'])
            <tr>
              <td class="table-active">荷物預り/返送<br>料金</td>
              <td>
                <div class="d-flex align-items-end">
                  {{$value['luggage_price']}}
                  <span class="ml-1 annotation">円</span>
                </div>
              </td>
            </tr>
            @endif
          </tbody>
        </table>
      </div>
      @endif


      <div class="eat_in">
        <table class="table table-bordered eating-table">
          <tbody>
            <tr>
              <td colspan="2">
                <p class="title-icon">
                  <i class="fas fa-utensils icon-size fa-fw"></i>室内飲食工藤さん！追加項目です。
                </p>
              </td>
            </tr>
            <tr>
              <td>
                ありかなし
              </td>
            </tr>
            <tr>
              <td>
                手配済みか検討中
              </td>
            </tr>
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

              </div>
            </td>
          </tr>
          <tr>
            <td class="table-active"><label for="user_id" class="">会社名/団体名</label></td>
            <td>
              {{ReservationHelper::getCompany($value['user_id'])}}
            </td>
          </tr>
          <tr>
            <td class="table-active"><label for="name">担当者氏名<br></label></td>
            <td>
              {{ReservationHelper::getPersonName($value['user_id'])}}
            </td>
          </tr>
          <tr>
            <td class="table-active">メールアドレス</td>
            <td>
              <p class="email">
                {{ReservationHelper::getPersonEmail($value['user_id'])}}
              </p>
            </td>
          </tr>
          <tr>
            <td class="table-active">携帯番号</td>
            <td>
              <p class="mobile">
                {{ReservationHelper::getPersonMobile($value['user_id'])}}
              </p>
            </td>
          </tr>
          <tr>
            <td class="table-active">固定電話</td>
            <td>
              <p class="tel">
                {{ReservationHelper::getPersonTel($value['user_id'])}}
              </p>
            </td>
          </tr>
          <tr>
            <td class="table-active">割引条件</td>
            <td>
              <p class="condition">
                {!!nl2br(e(ReservationHelper::getPersonCondition($value['user_id'])))!!}
              </p>
            </td>
          </tr>
          <tr>
            <td class="table-active caution">注意事項</td>
            <td class="caution">
              <p class="attention">
                {{ReservationHelper::getPersonAttention($value['user_id'])}}
              </p>
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
            <td class="table-active"><label for="ondayName" class="">氏名</label></td>
            <td>
              {{$value['in_charge']}}
            </td>
          </tr>
          <tr>
            <td class="table-active"><label for="mobilePhone" class="">携帯番号</label></td>
            <td>
              {{$value['tel']}}
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
              {{$value['email_flag']==1?"あり":"なし"}}
            </td>
          </tr>
        </tbody>
      </table>



      @if (!empty($value['email_flag']))
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
              <div class="d-flex align-items-end">
                {{$value['cost']}}
                <span class="ml-1 annotation">%</span>
              </div>
              <p class="is-error-cost" style="color: red"></p>
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
          <!-- <tr>
            <td>
              <label for="userNote">申し込みフォーム備考</label>
              {!!nl2br($value['user_details'])!!}
            </td>
          </tr> -->
          <tr>
            <td>
              <label for="adminNote">管理者備考</label>
              {!!nl2br($value['admin_details'])!!}
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
                <dd class="total_result">
                  {{number_format($checkInfo['master_total'])}}円
                </dd>
              </dl>
            </td>
            <td>
              <dl class="ttl_box">
                <dt>支払い期日</dt>
                <dd class="total_result">
                  {{ReservationHelper::formatDate($checkInfo['pay_limit'])}}
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
              @for ($i = 0; $i < $v_cnt; $i++) <tr>
                <td>
                  {{ Form::text('venue_breakdown_item'.$i, $checkInfo['venue_breakdown_item'.$i],['class'=>'form-control', 'readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('venue_breakdown_cost'.$i, $checkInfo['venue_breakdown_cost'.$i],['class'=>'form-control', 'readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('venue_breakdown_count'.$i, $checkInfo['venue_breakdown_count'.$i],['class'=>'form-control', 'readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('venue_breakdown_subtotal'.$i, $checkInfo['venue_breakdown_subtotal'.$i],['class'=>'form-control', 'readonly'] ) }}
                </td>
                </tr>
                @endfor
                @if (!empty($checkInfo['venue_breakdown_discount_item']))
                <tr>
                  <td>
                    {{ Form::text('venue_breakdown_discount_item', $checkInfo['venue_breakdown_discount_item'],['class'=>'form-control', 'readonly'] ) }}
                  </td>
                  <td>
                    {{ Form::text('venue_breakdown_discount_cost', $checkInfo['venue_breakdown_discount_cost'],['class'=>'form-control', 'readonly'] ) }}
                  </td>
                  <td>
                    {{ Form::text('venue_breakdown_discount_count', $checkInfo['venue_breakdown_discount_count'],['class'=>'form-control', 'readonly'] ) }}
                  </td>
                  <td>
                    {{ Form::text('venue_breakdown_discount_subtotal', $checkInfo['venue_breakdown_discount_subtotal'],['class'=>'form-control', 'readonly'] ) }}
                  </td>
                </tr>
                @endif
            </tbody>
            <tbody class="venue_result">
              <tr>
                <td colspan="3"></td>
                <td colspan="1">
                  <p class="text-left">合計</p>
                  {{ Form::text('venue_price', $checkInfo['venue_price'],['class'=>'form-control col-xs-3', 'readonly'] ) }}
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        @if ($e_cnt!=0 ||$s_cnt!=0 ||!empty($checkInfo['luggage_price']))
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
              @for ($e = 0; $e < $e_cnt; $e++) <tr>
                <td>
                  {{ Form::text('equipment_breakdown_item'.$e, $checkInfo['equipment_breakdown_item'.$e],['class'=>'form-control', 'readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('equipment_breakdown_cost'.$e, $checkInfo['equipment_breakdown_cost'.$e],['class'=>'form-control', 'readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('equipment_breakdown_count'.$e, $checkInfo['equipment_breakdown_count'.$e],['class'=>'form-control', 'readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('equipment_breakdown_subtotal'.$e, $checkInfo['equipment_breakdown_subtotal'.$e],['class'=>'form-control', 'readonly'] ) }}
                </td>
                </tr>
                @endfor
                @for ($s = 0; $s < $s_cnt; $s++) <tr>
                  <td>
                    {{ Form::text('service_breakdown_item'.$s, $checkInfo['services_breakdown_item'.$s],['class'=>'form-control', 'readonly'] ) }}
                  </td>
                  <td>
                    {{ Form::text('service_breakdown_cost'.$s, $checkInfo['services_breakdown_cost'.$s],['class'=>'form-control', 'readonly'] ) }}
                  </td>
                  <td>
                    {{ Form::text('service_breakdown_count'.$s, $checkInfo['services_breakdown_count'.$s],['class'=>'form-control', 'readonly'] ) }}
                  </td>
                  <td>
                    {{ Form::text('service_breakdown_subtotal'.$s, $checkInfo['services_breakdown_subtotal'.$s],['class'=>'form-control', 'readonly'] ) }}
                  </td>
                  </tr>
                  @endfor
                  @if (!empty($checkInfo['luggage_subtotal']))
                  <tr>
                    <td>
                      {{ Form::text('luggage_item', $checkInfo['luggage_item'],['class'=>'form-control', 'readonly'] ) }}
                    </td>
                    <td>
                      {{ Form::text('luggage_cost', $checkInfo['luggage_cost'],['class'=>'form-control', 'readonly'] ) }}
                    </td>
                    <td>
                      {{ Form::text('', 1,['class'=>'form-control', 'readonly'] ) }}
                    </td>
                    <td>
                      {{ Form::text('luggage_subtotal', $checkInfo['luggage_subtotal'],['class'=>'form-control', 'readonly'] ) }}
                    </td>
                  </tr>
                  @endif
                  @if (!empty($checkInfo['equipment_breakdown_discount_item']))
                  <tr>
                    <td>
                      {{ Form::text('equipment_breakdown_discount_item', $checkInfo['equipment_breakdown_discount_item'],['class'=>'form-control', 'readonly'] ) }}
                    </td>
                    <td>
                      {{ Form::text('equipment_breakdown_discount_cost', $checkInfo['equipment_breakdown_discount_cost'],['class'=>'form-control', 'readonly'] ) }}
                    </td>
                    <td>
                      {{ Form::text('equipment_breakdown_discount_count', $checkInfo['equipment_breakdown_discount_count'],['class'=>'form-control', 'readonly'] ) }}
                    </td>
                    <td>
                      {{ Form::text('equipment_breakdown_discount_subtotal', $checkInfo['equipment_breakdown_discount_subtotal'],['class'=>'form-control', 'readonly'] ) }}
                    </td>
                  </tr>
                  @endif
            </tbody>
            <tbody class="equipment_result">
              <tr>
                <td colspan="3"></td>
                <td colspan="1">
                  <p class="text-left">合計</p>
                  {{ Form::text('equipment_price', $checkInfo['equipment_price']+$value['luggage_price'],['class'=>'form-control', 'readonly'] ) }}
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        @endif

        @if (!empty($checkInfo['layout_prepare_subtotal'])||!empty($checkInfo['layout_clean_subtotal']))
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
              @if (!empty($checkInfo['layout_prepare_subtotal']))
              <tr>
                <td>
                  {{ Form::text('layout_prepare_item', $checkInfo['layout_prepare_item'],['class'=>'form-control', 'readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('layout_prepare_cost', $checkInfo['layout_prepare_cost'],['class'=>'form-control', 'readonly'] )}}
                </td>
                <td>
                  {{ Form::text('layout_prepare_count', $checkInfo['layout_prepare_count'],['class'=>'form-control', 'readonly'] )}}
                </td>
                <td>
                  {{ Form::text('layout_prepare_subtotal', $checkInfo['layout_prepare_subtotal'],['class'=>'form-control', 'readonly'] )}}
                </td>
              </tr>
              @endif
              @if (!empty($checkInfo['layout_clean_subtotal']))
              <tr>
                <td>
                  {{ Form::text('layout_clean_item', $checkInfo['layout_clean_item'],['class'=>'form-control', 'readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('layout_clean_cost', $checkInfo['layout_clean_cost'],['class'=>'form-control', 'readonly'] )}}
                </td>
                <td>
                  {{ Form::text('layout_clean_count', $checkInfo['layout_clean_count'],['class'=>'form-control', 'readonly'] )}}
                </td>
                <td>
                  {{ Form::text('layout_clean_subtotal', $checkInfo['layout_clean_subtotal'],['class'=>'form-control', 'readonly'] )}}
                </td>
              </tr>
              @endif
              @if (!empty($checkInfo['layout_breakdown_discount_subtotal']))
              <tr>
                <td>
                  {{ Form::text('layout_breakdown_discount_item', $checkInfo['layout_breakdown_discount_item'],['class'=>'form-control', 'readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('layout_breakdown_discount_cost', $checkInfo['layout_breakdown_discount_cost'],['class'=>'form-control', 'readonly'] )}}
                </td>
                <td>
                  {{ Form::text('layout_breakdown_discount_count', $checkInfo['layout_breakdown_discount_count'],['class'=>'form-control', 'readonly'] )}}
                </td>
                <td>
                  {{ Form::text('layout_breakdown_discount_subtotal', $checkInfo['layout_breakdown_discount_subtotal'],['class'=>'form-control', 'readonly'] )}}
                </td>
              </tr>
              @endif
            </tbody>
            <tbody class="layout_result">
              <tr>
                <td colspan="3"></td>
                <td colspan="1">
                  <p class="text-left">合計</p>
                  {{ Form::text('layout_price',$checkInfo['layout_price'],['class'=>'form-control', 'readonly'] ) }}
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        @endif

        @if ($o_cnt!=0)
        <div class="others billdetails_content">
          <table class="table table-borderless">
            <tr>
              <td colspan="4">
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
              @for ($o = 0; $o < $o_cnt; $o++) <tr>
                <td>
                  {{ Form::text('others_breakdown_item'.$o, $checkInfo['others_input_item'.$o],['class'=>'form-control', 'readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('others_breakdown_cost'.$o, $checkInfo['others_input_cost'.$o],['class'=>'form-control', 'readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('others_breakdown_count'.$o, $checkInfo['others_input_count'.$o],['class'=>'form-control', 'readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('others_breakdown_subtotal'.$o, $checkInfo['others_input_subtotal'.$o],['class'=>'form-control', 'readonly'] ) }}
                </td>
                </tr>
                @endfor
            </tbody>
            <tbody class="others_result">
              <tr>
                <td colspan="3"></td>
                <td colspan="1">
                  <p class="text-left">合計</p>
                  {{ Form::text('others_price', $checkInfo['others_price'],['class'=>'form-control', 'readonly'] ) }}
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
                  {{ Form::text('master_subtotal', $checkInfo['master_subtotal'],['class'=>'form-control', 'readonly'] ) }}
                </td>
              </tr>
              <tr>
                <td>消費税：</td>
                <td>
                  {{ Form::text('master_tax', $checkInfo['master_tax'],['class'=>'form-control', 'readonly'] ) }}
                </td>
              </tr>
              <tr>
                <td class="font-weight-bold">合計金額</td>
                <td>
                  {{ Form::text('master_total', $checkInfo['master_total'],['class'=>'form-control', 'readonly'] ) }}
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
        <div class="informations billdetails_content">
          <table class="table">
            <tbody>
              <tr>
                <td>請求日
                  {{ Form::text('bill_created_at', $checkInfo['bill_created_at'],['class'=>'form-control', 'readonly'] ) }}
                </td>
                <td>支払期日
                  {{ Form::text('payment_limit', $checkInfo['pay_limit'],['class'=>'form-control', 'readonly'] ) }}
                </td>
              </tr>
              <tr>
                <td>請求書宛名
                  {{ Form::text('bill_company', $checkInfo['pay_company'],['class'=>'form-control', 'readonly'] ) }}
                </td>
                <td>
                  担当者
                  {{ Form::text('bill_person', $checkInfo['bill_person'],['class'=>'form-control', 'readonly'] ) }}
                </td>
              </tr>
              <tr>
                <td colspan="2">請求書備考
                  {{ Form::textarea('bill_remark', $checkInfo['bill_remark'],['class'=>'form-control', 'readonly'] ) }}
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
        <div class="paids billdetails_content">
          <table class="table" style="table-layout: fixed;">
            <tbody>
              <tr>
                <td>入金状況
                  {{Form::text('',$checkInfo['paid']==1?"支払済":"未払",['class'=>'form-control','readonly'])}}
                </td>
                <td>
                  入金日{{ Form::text('pay_day', $checkInfo['pay_day'],['class'=>'form-control', 'readonly'] ) }}
                </td>
              </tr>
              <tr>
                <td>振込人名
                  {{ Form::text('pay_person', $checkInfo['pay_person'],['class'=>'form-control', 'readonly'] ) }}
                </td>
                <td>入金額
                  {{ Form::text('payment', $checkInfo['payment'],['class'=>'form-control', 'readonly'] ) }}
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
  <a href="{{route('admin.reservations.calculate')}}" class="btn more_btn4_lg d-block mr-5">請求内訳を修正する</a>
  {{Form::submit('予約を登録する', ['class'=>'d-block btn more_btn_lg', 'id'=>'check_submit'])}}
  {{Form::close()}}
</div>



@endsection