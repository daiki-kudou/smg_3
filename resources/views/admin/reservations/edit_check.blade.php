@extends('layouts.admin.app')
@section('content')

<link href="{{ asset('/css/template.css') }}" rel="stylesheet">
<script src="{{ asset('/js/template.js') }}"></script>

<div class="d-flex justify-content-end">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active">
        {{ Breadcrumbs::render(Route::currentRouteName(),$data['reservation_id']) }}
      </li>
    </ol>
  </nav>
</div>

{{ Form::open(['url' => 'admin/reservations/'.$data['reservation_id'], 'method'=>'PUT', 'id'=>'']) }}
@csrf
{{ Form::hidden('reservation_id', $data['reservation_id'] ,['class'=>'form-control', 'readonly'] ) }}
{{ Form::hidden('bill_id', $data['bill_id'] ,['class'=>'form-control', 'readonly'] ) }}

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
              {{ Form::text('reserve_date', $data['reserve_date'],['class'=>'form-control','readonly'] ) }}
            </td>
          </tr>
          <tr>
            <td class="table-active form_required">会場</td>
            <td>
              {{ Form::text('', ReservationHelper::getVenue($data['venue_id']),['class'=>'form-control', 'readonly'] ) }}
              {{ Form::hidden('venue_id', $data['venue_id'],['class'=>'form-control', 'readonly'] ) }}
            </td>
          </tr>
          <tr>
            <td class="table-active">料金体系</td>
            <td>
              {{ Form::text('', ReservationHelper::priceSystem($data['price_system']),['class'=>'form-control', 'readonly'] ) }}
              {{ Form::hidden('price_system', $data['price_system'],['class'=>'form-control', 'readonly'] ) }}
            </td>
          </tr>
          <tr>
            <td class="table-active form_required">入室時間</td>
            <td>
              {{ Form::text('', date('H:i',strtotime($data['enter_time'])),['class'=>'form-control', 'readonly'] ) }}
              {{ Form::hidden('enter_time', $data['enter_time'],['class'=>'form-control', 'readonly'] ) }}
            </td>
          </tr>
          <tr>
            <td class="table-active form_required">退室時間</td>
            <td>
              {{ Form::text('', date('H:i',strtotime($data['leave_time'])),['class'=>'form-control', 'readonly'] ) }}
              {{ Form::hidden('leave_time', $data['leave_time'],['class'=>'form-control', 'readonly'] ) }}
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
              {{ Form::text('', $data['board_flag']==1?"有り":"無し",['class'=>'form-control', 'readonly'] ) }}
              {{ Form::hidden('board_flag', $data['board_flag'],['class'=>'form-control', 'readonly'] ) }}
            </td>
          </tr>
          <tr>
            <td class="table-active">イベント名称1</td>
            <td>
              {{ Form::text('event_name1', $data['event_name1'],['class'=>'form-control', 'readonly'] ) }}
            </td>
          </tr>
          <tr>
            <td class="table-active">イベント名称2</td>
            <td>
              {{ Form::text('event_name2', $data['event_name2'],['class'=>'form-control', 'readonly'] ) }}
            </td>
          </tr>
          <tr>
            <td class="table-active">主催者名</td>
            <td>
              {{ Form::text('event_owner', $data['event_owner'],['class'=>'form-control', 'readonly'] ) }}
            </td>
          </tr>
          <tr>
            <td class="table-active">イベント開始時間</td>
            <td>
              @if ($data['board_flag']==1)
              {{ Form::text('', date('H:i',strtotime($data['event_start'])),['class'=>'form-control', 'readonly'] ) }}
              {{ Form::hidden('event_start', $data['event_start'],['class'=>'form-control', 'readonly'] ) }}
              @else
              {{ Form::text('', '',['class'=>'form-control', 'readonly'] ) }}
              {{ Form::hidden('event_start', '',['class'=>'form-control', 'readonly'] ) }}
              @endif
            </td>
          </tr>
          <tr>
            <td class="table-active">イベント終了時間</td>
            <td>
              @if ($data['board_flag']==1)
              {{ Form::text('', date('H:i',strtotime($data['event_finish'])),['class'=>'form-control', 'readonly'] ) }}
              {{ Form::hidden('event_finish', $data['event_start'],['class'=>'form-control', 'readonly'] ) }}
              @else
              {{ Form::text('', '',['class'=>'form-control', 'readonly'] ) }}
              {{ Form::hidden('event_finish', '',['class'=>'form-control', 'readonly'] ) }}
              @endif
            </td>
          </tr>
        </tbody>
      </table>
      <div class="equipemnts">
        <table class="table table-bordered">
          <thead class="accordion-ttl">
            <tr>
              <th colspan="2">
                <p class="title-icon fw-bolder py-1">
                  <i class="fas fa-wrench icon-size"></i>有料備品
                </p>
              </th>
            </tr>
          </thead>
          <tbody class="accordion-wrap2">
            @foreach ($venue->getEquipments() as $key=>$equipment)
            <tr>
              <td class="table-active">{{$equipment->item}}({{$equipment->price}}円)</td>
              <td>
                <div class="d-flex align-items-end">
                  {{ Form::text('equipment_breakdown[]', $data['equipment_breakdown'][$key],['class'=>'form-control equipment_breakdown','readonly'] ) }}
                  <span class="ml-1">個</span>
                </div>
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
          <tbody class="accordion-wrap2">
            @foreach ($venue->getServices() as $key=>$service)
            <tr>
              <td class="table-active">
                {{$service->item}}({{$equipment->price}}円)
              </td>
              <td>
                {{ Form::text('services_breakdown[]', (int)$data['services_breakdown'][$key]===1?"有り":"無し",['class'=>'form-control','readonly'] ) }}
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
                準備({{number_format($venue->layout_prepare)}}円)
              </td>
              <td>
                {{ Form::text('', $data['layout_prepare']==1?"有り":"無し",['class'=>'form-control', 'readonly'] ) }}
                {{ Form::hidden('layout_prepare', $data['layout_prepare'],['class'=>'form-control', 'readonly'] ) }}
              </td>
            </tr>
            <tr>
              <td class="table-active">
                片付({{number_format($venue->layout_clean)}}円)
              </td>
              <td>
                {{ Form::text('', $data['layout_clean']==1?"有り":"無し",['class'=>'form-control', 'readonly'] ) }}
                {{ Form::hidden('layout_clean', $data['layout_clean'],['class'=>'form-control', 'readonly'] ) }}
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
              <th colspan='2'>
                <p class="title-icon">
                  <i class="fas fa-suitcase-rolling icon-size"></i>荷物預り
                </p>
              </th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="table-active">荷物預かり　工藤さん！！</td>
              <td>
                <input class="form-control" type="text" value="工藤さん！ありかなしを表示" readonly>
              </td>
            </tr>
            <tr>
              <td class="table-active">事前に預かる荷物<br>（個数）</td>
              <td>
                {{ Form::text('luggage_count', $data['luggage_count'],['class'=>'form-control', 'readonly'] ) }}
              </td>
            </tr>
            <tr>
              <td class="table-active">事前荷物の到着日<br>午前指定のみ</td>
              <td>
                {{ Form::text('luggage_arrive', $data['luggage_arrive'],['class'=>'form-control', 'readonly'] ) }}
              </td>
            </tr>
            <tr>
              <td class="table-active">事後返送する荷物</td>
              <td>
                {{ Form::text('luggage_return', $data['luggage_return'],['class'=>'form-control', 'readonly'] ) }}
              </td>
            </tr>
            <tr>
              <td class="table-active">荷物預かり<br>料金</td>
              <td>
                <div class="d-flex align-items-end">
                  {{ Form::text('luggage_price', $data['luggage_price'],['class'=>'form-control', 'readonly'] ) }}
                  <span class="ml-1">円</span>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      @endif

      @if ($venue->eat_in_flag!=0)
      <div class="eat_in">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th colspan='2'>
                <p class="title-icon">
                  <i class="fas fa-utensils icon-size fa-fw"></i>室内飲食
                </p>
              </th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>
                {{$data['eat_in']==1?'あり':'なし'}}
                {{ Form::hidden('eat_in', $data['eat_in'])}}
              </td>
              <td>
                {{!empty($data['eat_in_prepare'])?($data['eat_in_prepare']==1?'手配済み':'検討中'):"なし"}}
                {{ Form::hidden('eat_in_prepare', !empty($data['eat_in_prepare'])?$data['eat_in_prepare']:"")}}
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      @endif
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
                <p>
                  <a class="more_btn user_link" target="_blank" rel="noopener"
                    href="{{url('admin/clients/'.$data['user_id'])}}">顧客詳細</a>
                </p>
              </div>
            </td>
          </tr>
          <tr>
            <td class="table-active"><label for="user_id" class=" form_required">会社名/団体名</label></td>
            <td>
              {{ Form::text('', ReservationHelper::getCompany($data['user_id']),['class'=>'form-control', 'readonly'] ) }}
              {{ Form::hidden('user_id', $data['user_id'],['class'=>'form-control', 'readonly'] ) }}
            </td>
          </tr>
          <tr>
            <td class="table-active"><label for="name">担当者氏名</label></td>
            <td>
              <p class="person">
                {{ Form::text('', ReservationHelper::getPersonName($data['user_id']),['class'=>'form-control', 'readonly'] ) }}
              </p>
            </td>
          </tr>
          <tr>
            <td class="table-active">メールアドレス</td>
            <td>
              <p class="email">
                {{ Form::text('', ReservationHelper::getPersonEmail($data['user_id']),['class'=>'form-control', 'readonly'] ) }}
              </p>
            </td>
          </tr>
          <tr>
            <td class="table-active">携帯番号</td>
            <td>
              <p class="mobile">
                {{ Form::text('', ReservationHelper::getPersonMobile($data['user_id']),['class'=>'form-control', 'readonly'] ) }}
              </p>
            </td>
          </tr>
          <tr>
            <td class="table-active">固定電話</td>
            <td>
              <p class="tel">
                {{ Form::text('', ReservationHelper::getPersonTel($data['user_id']),['class'=>'form-control', 'readonly'] ) }}
              </p>
            </td>
          </tr>
          <tr>
            <td class="table-active">割引条件</td>
            <td>
              <p class="condition">
                {{ Form::textarea('', ReservationHelper::getPersonCondition($data['user_id']),['class'=>'form-control', 'readonly'] ) }}
              </p>
            </td>
          </tr>
          <tr>
            <td class="table-active caution">注意事項</td>
            <td class="caution">
              <p class="attention">
                {{ Form::textarea('', ReservationHelper::getPersonAttention($data['user_id']),['class'=>'form-control', 'readonly'] ) }}
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
            <td class="table-active"><label for="ondayName" class=" form_required">氏名</label></td>
            <td>
              {{ Form::text('in_charge', $data['in_charge'],['class'=>'form-control', 'readonly'] ) }}
            </td>
          </tr>
          <tr>
            <td class="table-active"><label for="mobilePhone" class=" form_required">携帯番号</label></td>
            <td>
              {{ Form::text('tel', $data['tel'],['class'=>'form-control', 'readonly'] ) }}
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
              {{ Form::text('', $data['email_flag']==1?"有り":"無し",['class'=>'form-control', 'readonly'] ) }}
              {{ Form::hidden('email_flag', $data['email_flag'],['class'=>'form-control', 'readonly'] ) }}
            </td>
          </tr>
        </tbody>
      </table>

      @if ($venue->alliance_flag==1)
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
                {{ Form::text('', $data['cost'],['class'=>'form-control', 'readonly'] ) }}
                {{ Form::hidden('cost', $data['cost'],['class'=>'form-control', 'readonly'] ) }}
                <span class="ml-1">%</span>
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
                <i class="fas fa-envelope icon-size" aria-hidden="true"></i>備考
              </p>
            </td>
          </tr>
          <tr>
            <td>
              <label for="adminNote">管理者備考</label>
              {{ Form::textarea('admin_details', $data['admin_details'],['class'=>'form-control', 'readonly'] ) }}
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
                  {{number_format($data['master_total'])}}
                  円</dd>
              </dl>
            </td>
            <td>
              <dl class="ttl_box">
                <dt>支払い期日</dt>
                <dd class="total_result">
                  {{ReservationHelper::formatDate($data['payment_limit'])}}
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
              @foreach ($data['venue_breakdown_item'] as $key=>$value)
              <tr>
                <td>
                  {{ Form::text('venue_breakdown_item[]', $data['venue_breakdown_item'][$key],['class'=>'form-control', 'readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('venue_breakdown_cost[]', $data['venue_breakdown_cost'][$key],['class'=>'form-control', 'readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('venue_breakdown_count[]', $data['venue_breakdown_count'][$key],['class'=>'form-control', 'readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('venue_breakdown_subtotal[]', $data['venue_breakdown_subtotal'][$key],['class'=>'form-control', 'readonly'] ) }}
                </td>
              </tr>
              @endforeach
            </tbody>
            <tbody class="venue_result">
              <tr>
                <td colspan="3"></td>
                <td colspan="1">
                  <p class="text-left">合計</p>
                  {{ Form::text('venue_price', $data['venue_price'],['class'=>'form-control col-xs-3', 'readonly'] ) }}
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        @if (!empty($data['equipment_breakdown_item'])||!empty($data['service_breakdown_item']))
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
              @foreach ($data['equipment_breakdown_item'] as $key=>$value)
              <tr>
                <td>
                  {{ Form::text('equipment_breakdown_item[]', $data['equipment_breakdown_item'][$key],['class'=>'form-control', 'readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('equipment_breakdown_cost[]', $data['equipment_breakdown_cost'][$key],['class'=>'form-control', 'readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('equipment_breakdown_count[]', $data['equipment_breakdown_count'][$key],['class'=>'form-control', 'readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('equipment_breakdown_subtotal[]', $data['equipment_breakdown_subtotal'][$key],['class'=>'form-control', 'readonly'] ) }}
                </td>
              </tr>
              @endforeach
              @foreach ($data['service_breakdown_item'] as $key=>$value)
              <tr>
                <td>
                  {{ Form::text('service_breakdown_item[]', $data['service_breakdown_item'][$key],['class'=>'form-control', 'readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('service_breakdown_cost[]', $data['service_breakdown_cost'][$key],['class'=>'form-control', 'readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('service_breakdown_count[]', $data['service_breakdown_count'][$key],['class'=>'form-control', 'readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('service_breakdown_subtotal[]', $data['service_breakdown_subtotal'][$key],['class'=>'form-control', 'readonly'] ) }}
                </td>
              </tr>
              @endforeach
            </tbody>
            <tbody class="equipment_result">
              <tr>
                <td colspan="3"></td>
                <td colspan="1">
                  <p class="text-left">合計</p>
                  {{ Form::text('equipment_price', $data['equipment_price'],['class'=>'form-control', 'readonly'] ) }}
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        @endif

        @if (!empty($data['layout_breakdown_item']))
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
              @foreach ($data['layout_breakdown_item'] as $key=>$value)
              <tr>
                <td>
                  {{ Form::text('layout_breakdown_item[]', $data['layout_breakdown_item'][$key],['class'=>'form-control', 'readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('layout_breakdown_cost[]', $data['layout_breakdown_cost'][$key],['class'=>'form-control', 'readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('layout_breakdown_count[]', $data['layout_breakdown_count'][$key],['class'=>'form-control', 'readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('layout_breakdown_subtotal[]', $data['layout_breakdown_subtotal'][$key],['class'=>'form-control', 'readonly'] ) }}
                </td>
              </tr>
              @endforeach
            </tbody>
            <tbody class="layout_result">
              <tr>
                <td colspan="3"></td>
                <td colspan="1">
                  <p class="text-left">合計</p>
                  {{ Form::text('layout_price',$data['layout_price'],['class'=>'form-control', 'readonly'] ) }}
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        @endif

        @if (!empty($data['others_breakdown_item']))
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
              @foreach ($data['others_breakdown_item'] as $key=>$value)
              <tr>
                <td>
                  {{ Form::text('others_breakdown_item[]', $data['others_breakdown_item'][$key],['class'=>'form-control', 'readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('others_breakdown_cost[]', $data['others_breakdown_cost'][$key],['class'=>'form-control', 'readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('others_breakdown_count[]', $data['others_breakdown_count'][$key],['class'=>'form-control', 'readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('others_breakdown_subtotal[]', $data['others_breakdown_subtotal'][$key],['class'=>'form-control', 'readonly'] ) }}
                </td>
              </tr>
              @endforeach
            </tbody>
            <tbody class="others_result">
              <tr>
                <td colspan="3"></td>
                <td colspan="1">
                  <p class="text-left">合計</p>
                  {{ Form::text('others_price', $data['others_price'],['class'=>'form-control', 'readonly'] ) }}
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
                  {{ Form::text('master_subtotal', $data['master_subtotal'],['class'=>'form-control', 'readonly'] ) }}
                </td>
              </tr>
              <tr>
                <td>消費税：</td>
                <td>
                  {{ Form::text('master_tax', $data['master_tax'],['class'=>'form-control', 'readonly'] ) }}
                </td>
              </tr>
              <tr>
                <td class="font-weight-bold">合計金額</td>
                <td>
                  {{ Form::text('master_total', $data['master_total'],['class'=>'form-control', 'readonly'] ) }}
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
                <td>請求日：
                  {{ Form::text('bill_created_at', $data['bill_created_at'],['class'=>'form-control', 'readonly'] ) }}
                </td>
                <td>支払期日
                  {{ Form::text('payment_limit', $data['payment_limit'],['class'=>'form-control', 'readonly'] ) }}
                </td>
              </tr>
              <tr>
                <td>請求書宛名
                  {{ Form::text('bill_company', $data['bill_company'],['class'=>'form-control', 'readonly'] ) }}
                </td>
                <td>
                  担当者
                  {{ Form::text('bill_person', $data['bill_person'],['class'=>'form-control', 'readonly'] ) }}
                </td>
              </tr>
              <tr>
                <td colspan="2">請求書備考
                  {{ Form::textarea('bill_remark', $data['bill_remark'],['class'=>'form-control', 'readonly'] ) }}
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
                  {{Form::text('',ReservationHelper::paidStatus($data['paid']),['class'=>'form-control','readonly'])}}
                  {{Form::hidden('paid',$data['paid'],['class'=>'form-control','readonly'])}}
                </td>
                <td>
                  入金日
                  {{ Form::text('pay_day', $data['pay_day'],['class'=>'form-control', 'readonly'] ) }}
                </td>
              </tr>
              <tr>
                <td>振込人名
                  {{ Form::text('pay_person', $data['pay_person'],['class'=>'form-control','readonly'] ) }}
                </td>
                <td>入金額
                  {{ Form::text('payment', $data['payment'],['class'=>'form-control','readonly'])}}
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
  {{Form::submit('請求内訳を修正する', ['class'=>'btn more_btn4_lg d-block mr-5', 'name'=>'back'])}}
  {{Form::submit('保存する', ['class'=>'btn more_btn_lg d-block', 'id'=>'check_submit'])}}
  {{Form::close()}}

</div>


@endsection