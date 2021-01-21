@extends('layouts.admin.app')
@section('content')

<link href="{{ asset('/css/template.css') }}" rel="stylesheet">
<script src="{{ asset('/js/template.js') }}"></script>
<script src="{{ asset('/js/ajax.js') }}"></script>


{{ Form::open(['url' => 'admin/reservations', 'method'=>'POST']) }}
@csrf

<div class="content">
  <div class="container-fluid">

    <div class="container-field mt-3">
      <div class="float-right">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item active"><a href="http://staging-smg2.herokuapp.com/admin/home">ホーム</a> >
              予約登録　確認
            </li>
          </ol>
        </nav>
      </div>
      <h1 class="mt-3 mb-5">予約登録　確認</h1>
    </div>

    <!-- 予約詳細--------------------------------------------------------　 -->
    <div class="section-wrap">

      <div class="ttl-box d-flex align-items-center">
        <div class="col-9 d-flex justify-content-between">
          <h2>予約概要</h2>
          <p>予約ID:00001</p>
          <p>予約一括ID:00001</p>
        </div>
      </div>

      <section class="register-wrap">

        <div class="row">
          <!-- 左側の項目------------------------------------------------------------------------ -->
          <div class="col-6">
            <table class="table table-bordered">
              <tr>
                <td colspan="2">
                  <p class="title-icon">
                    <i class="fas fa-info-circle icon-size"></i>
                    予約情報
                  </p>
                </td>
              </tr>
              <tr>
                <td class="table-active"><label for="date">利用日</label></td>
                <td>{{$reserve_date}}</td>
                {{ Form::hidden('reserve_date', $reserve_date,['class'=>''] ) }}
              </tr>
              <tr>
                <td class="table-active"><label for="venue">会場</label></td>
                <td>
                  <p>{{$venue->name_area}}</p>
                  <p>{{$venue->name_bldg}}{{$venue->name_venue}}</p>
                  {{ Form::hidden('venue_id', $venue_id,['class'=>''] ) }}
                </td>
              </tr>
              <tr>
                <td class="table-active"><label for="venue">料金体系</label></td>
                <td>
                  <p>{{$price_system==1?'通常(枠貸)':'アクセア(時間貸)'}}</p>
                  {{ Form::hidden('price_system', $price_system,['class'=>''] ) }}
                </td>
              </tr>
              <tr>
                <td class="table-active"><label for="start">入室時間</label></td>
                <td>{{$enter_time}}</td>
                {{ Form::hidden('enter_time', $enter_time,['class'=>''] ) }}
              </tr>
              <tr>
                <td class="table-active"><label for="finish">退室時間</label></td>
                <td>{{$leave_time}}</td>
                {{ Form::hidden('leave_time', $leave_time,['class'=>''] ) }}
              </tr>
              <tr>
                <td class="table-active"><label for="direction">案内板</label></td>
                <td class="d-flex justify-content-between">
                  <p>{{$board_flag}}</p>
                  {{ Form::hidden('board_flag', $board_flag,['class'=>''] ) }}
                </td>
              </tr>
              <tr>
                <td class="table-active"><label for="eventTime">イベント時間記載</label></td>
                <td>
                  あり or なし
                </td>
              </tr>
              <tr>
                <td class="table-active"><label for="eventStart">イベント開始時間</label></td>
                <td>{{$event_start}}</td>
                {{ Form::hidden('event_start', $event_start,['class'=>''] ) }}
              </tr>
              <tr>
                <td class="table-active"><label for="eventFinish">イベント終了時間</label></td>
                <td>{{$event_finish}}</td>
                {{ Form::hidden('event_finish', $event_finish,['class'=>''] ) }}
              </tr>
              <tr>
                <td class="table-active"><label for="eventName1">イベント名称1</label></td>
                <td>{{$event_name1}}</td>
                {{ Form::hidden('event_name1', $event_name1,['class'=>''] ) }}
              </tr>
              <tr>
                <td class="table-active"><label for="eventName2">イベント名称2</label></td>
                <td>{{$event_name2}}</td>
                {{ Form::hidden('event_name2', $event_name2,['class'=>''] ) }}
              </tr>
              <tr>
                <td class="table-active"><label for="organizer">主催者名</label></td>
                <td>{{$event_owner}}</td>
                {{ Form::hidden('event_owner', $event_owner,['class'=>''] ) }}
              </tr>
            </table>

            <table class="table table-bordered equipment-table">
              <thead class="accordion-ttl">
                <tr>
                  <td colspan="2">
                    <p class="title-icon active">有料備品</p>
                  </td>
                </tr>
              </thead>
              <tbody class="accordion-wrap">
                @foreach ($venue->equipments as $key=>$value)
                <tr>
                  <td class="d-flex justify-content-between">
                    <p>{{$value->item}} </p>
                    <p style="width:50px;">{{$simple_v_input[$key]}}</p>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>

            <table class="table table-bordered equipment-table">
              <thead class="accordion-ttl">
                <tr>
                  <td colspan="2">
                    <p class="title-icon active">有料サービス</p>
                  </td>
                </tr>
              </thead>
              <tbody class="accordion-wrap">
                @foreach ($venue->services as $key=>$value)
                <tr>
                  <td class="d-flex justify-content-between">
                    <p>{{$value->item}} </p>
                    <p style="width:50px;">{{$simple_s_input[$key]==1?'有り':'無し'}}</p>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>

            <table class="table table-bordered equipment-table">
              <thead class="accordion-ttl">
                <tr>
                  <td colspan="2">
                    <p class="title-icon active">レイアウト</p>
                  </td>
                </tr>
              </thead>
              <tbody class="accordion-wrap">
                <tr>
                  <td class="d-flex justify-content-between">
                    <p>レイアウト準備 </p>
                    <p>{{$layout_prepare==1?'有り':'無し'}}</p>
                  </td>
                </tr>
                <tr>
                  <td class="d-flex justify-content-between">
                    <p>レイアウト片付</p>
                    <p>{{$layout_clean==1?'有り':'無し'}}</p>
                  </td>
                </tr>
              </tbody>
            </table>

            <table class="table table-bordered equipment-table">
              <thead class="accordion-ttl">
                <tr>
                  <td colspan="2">
                    <p class="title-icon active">荷物片付</p>
                  </td>
                </tr>
              </thead>
              <tbody class="accordion-wrap">
                <tr>
                  <td class="d-flex justify-content-between">
                    <p>事前に預かる荷物<br>（個数）</p>
                    <p>{{$luggage_count}}</p>
                    {{ Form::hidden('luggage_count', $luggage_count,['class'=>''] ) }}
                  </td>
                </tr>
                <tr>
                  <td class="d-flex justify-content-between">
                    <p>事前荷物の到着日<br>午前指定のみ</p>
                    <p>{{$luggage_arrive}}</p>
                    {{ Form::hidden('luggage_arrive', $luggage_arrive,['class'=>''] ) }}
                  </td>
                </tr>
                <tr>
                  <td class="d-flex justify-content-between">
                    <p>事後返送する荷物 </p>
                    <p>{{$luggage_return}}</p>
                    {{ Form::hidden('luggage_return', $luggage_return,['class'=>''] ) }}
                  </td>
                </tr>
                <tr>
                  <td class="d-flex justify-content-between">
                    <p>荷物預かり/返送　料金 </p>
                    <p>{{$luggage_price}}</p>
                  </td>
                </tr>
              </tbody>
            </table>

            <table class="table table-bordered eating-table">
              <tr>
                <td>
                  <p class="title-icon">室内飲食</p>
                </td>
              </tr>
              <tr>
                <td>
                  なし
                </td>
              </tr>
            </table>
          </div>
          <!-- 左側の項目 終わり-------------------------------------------------- -->
          <!-- 右側の項目-------------------------------------------------- -->
          <div class="col-6">
            <div class="customer-table">
              <table class="table table-bordered name-table">
                <tr>
                  <td colspan="2">
                    <div class="d-flex align-items-center justify-content-between">
                      <p class="title-icon">
                        <i class="far fa-address-card icon-size"></i>
                        顧客情報
                      </p>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td class="table-active"><label for="company">会社名・団体名</label></td>
                  <td>
                    {{$user->company}}
                    {{ Form::hidden('user_id', $user_id,['class'=>''] ) }}
                  </td>
                </tr>
                <tr>
                  <td class="table-active"><label for="name">担当者氏名</label></td>
                  <td>
                    {{$user->first_name}}{{$user->last_name}}
                  </td>
                </tr>
                <tr>
                  <td class="table-active">担当者氏名(フリガナ)</td>
                  <td>
                    {{$user->first_name_kana}}{{$user->last_name_kana}}
                  </td>
                </tr>
                <tr>
                  <td class="table-active">電話番号</td>
                  <td>
                    <ul class="table-cell-box">
                      <li>
                        <p>携帯番号</p>
                        <p>{{$user->mobile}}</p>
                      </li>
                      <li>
                        <p>固定番号</p>
                        <p>{{$user->tel}}</p>
                      </li>
                    </ul>
                  </td>
                </tr>
                <tr>
                  <td class="table-active">メールアドレス</td>
                  <td>{{$user->email}}</td>
                </tr>
                <tr>
                  <td class="table-active">顧客属性</td>
                  <td>
                    {{$user->attr}}
                  </td>
                </tr>
              </table>

              <table class="table table-bordered oneday-table">
                <tr>
                  <td colspan="2">
                    <p class="title-icon">
                      <i class="fas fa-user icon-size"></i>
                      当日の連絡できる担当者
                    </p>
                  </td>
                </tr>
                <tr>
                  <td class="table-active"><label for="ondayName">氏名</label></td>
                  <td>{{$in_charge}}</td>
                  {{ Form::hidden('in_charge', $in_charge,['class'=>''] ) }}
                </tr>
                <tr>
                  <td class="table-active"><label for="mobilePhone">携帯番号</label></td>
                  <td>{{$tel}}</td>
                  {{ Form::hidden('tel', $tel,['class'=>''] ) }}
                </tr>
              </table>
            </div>

            <table class="table table-bordered mail-table">
              <tr>
                <td colspan="2">
                  <p class="title-icon">
                    <i class="fas fa-envelope icon-size"></i>
                    利用後の送信メール
                  </p>
                </td>
              </tr>
              <tr>
                <td class="table-active"><label for="sendMail">送信メール</label></td>
                <td>{{$email_flag}}</td>
                {{ Form::hidden('email_flag', $email_flag,['class'=>''] ) }}
              </tr>
            </table>

            <table class="table table-bordered sale-table">
              <tr>
                <td colspan="2">
                  <p class="title-icon">
                    <i class="fas fa-yen-sign icon-size"></i>
                    売上原価
                  </p>
                </td>
              </tr>
              <tr>
                <td class="table-active"><label for="sale">原価率</label></td>
                <td>
                  {{$cost}}
                  {{ Form::hidden('cost', $cost,['class'=>''] ) }}
                </td>
              </tr>
            </table>

            <table class="table table-bordered note-table">
              <tr>
                <td colspan="2">
                  <p class="title-icon">
                    <i class="fas fa-file-alt icon-size"></i>
                    備考
                  </p>
                </td>
              </tr>
              <tr>
                <td>
                  <p>
                    割引条件
                  </p>
                  <p>{{$discount_condition}}</p>
                  {{ Form::hidden('discount_condition', $discount_condition,['class'=>''] ) }}
                </td>
              </tr>
              <tr class="caution">
                <td>
                  <p>注意事項</p>
                  <p>{{$attention}}</p>
                  {{ Form::hidden('attention', $attention,['class'=>''] ) }}
                </td>
              </tr>
              <tr>
                <td>
                  <p>顧客情報の備考</p>
                  <p>{{$user_details}}</p>
                  {{ Form::hidden('user_details', $user_details,['class'=>''] ) }}
                </td>
              </tr>
              <tr>
                <td>
                  <p>管理者備考</p>
                  <p>{{$admin_details}}</p>
                  {{ Form::hidden('admin_details', $admin_details,['class'=>''] ) }}
                </td>
              </tr>
            </table>
          </div>
          <!-- 右側の項目 終わり-------------------------------------------------- -->
        </div>
        <!-- 請求セクション------------------------------------------------------------------- -->
        <section class="bill-wrap section-wrap section-bg">
          <div class="bill-bg">
            <!-- 請求内容----------- -->
            <!-- 請求書情報-------- -->
            <div class="bill-ttl mb-5">
              <div class="section-ttl-box d-flex align-items-center">
                <div class="col-6">
                  <h3 class="">請求情報</h3>
                </div>
              </div>
            </div>
            <!-- 請求書情報 終わり---------------------------- -->
            <!-- 会場料請求内容----------- -->

            @if (!$request->venue_price&&!$request->venue_subtotal&&!$request->venue_total)
            {{-- ここが手打ち版の表示領域 --}}
            <div class="hand_input">
              <h3
                style="font-weight: bold;font-size: 16px;background: #840A01;color: #fff;margin-bottom: 0;padding: 0.8em;">
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
                        {{ Form::text('hand_input_venueprice',$request->hand_input_venueprice,['class'=>'form-control', 'readonly'] )}}
                      </td>
                      <td>
                        {{ Form::text('hand_input_count',$request->hand_input_count,['class'=>'form-control', 'readonly'] )}}
                      </td>
                      <td>
                        {{ Form::text('hand_input_subtotal',$request->hand_input_subtotal,['class'=>'form-control', 'readonly'] )}}
                      </td>
                    </tr>
                    <tr>
                      <td>延長料金</td>
                      <td>
                        {{ Form::text('hand_input_extendprice',$request->hand_input_extendprice,['class'=>'form-control', 'readonly'] )}}
                      </td>
                      <td>
                        {{ Form::text('hand_input_extendcount',$request->hand_input_extendcount,['class'=>'form-control', 'readonly'] )}}
                      </td>
                      <td>
                        {{ Form::text('hand_input_extendsubtotal',$request->hand_input_extendsubtotal,['class'=>'form-control', 'readonly'] )}}
                      </td>
                    </tr>
                    <tr>
                      <td>割引料金</td>
                      <td>
                        {{ Form::text('hand_input_discountprice',$request->hand_input_discountprice,['class'=>'form-control', 'readonly'] )}}
                      </td>
                      <td>
                        {{ Form::text('hand_input_discountcount',$request->hand_input_discountcount,['class'=>'form-control', 'readonly'] )}}
                      </td>
                      <td>
                        {{ Form::text('hand_input_discountsubtotal',$request->hand_input_discountsubtotal,['class'=>'form-control', 'readonly'] )}}
                      </td>
                    </tr>
                  </tbody>
                </table>
                <div class="text-right">
                  <p>小計
                    {{ Form::text('venue_total',$request->handinput_subtotal,['class'=>'form-control text-right','id'=>'handinput_subtotal', 'readonly'] )}}
                  </p>
                  <p>消費税
                    {{ Form::text('############',$request->handinput_tax,['class'=>'form-control text-right','id'=>'handinput_tax', 'readonly'] )}}
                  </p>
                  <p>請求総額
                    {{ Form::text('discount_venue_total',$request->handinput_total,['class'=>'form-control text-right','id'=>'handinput_total', 'readonly'] )}}
                  </p>
                </div>
              </div>
            </div>
            @else
            {{-- ここが正規の部分の表示領域 --}}
            <div class="bill-box">
              <h3 class="row">会場料</h3>
              <dl class="row bill-box_wrap">
                <div class="col-3 bill-box_cell">
                  <dt>会場料金</dt>
                  <dd>{{$request->venue_price}}</dd>
                </div>
                <div class="col-3 bill-box_cell">
                  <dt>延長料金</dt>
                  <dd>{{$request->extend}}</dd>
                </div>
                <div class="col-6 bill-box_cell">
                  <dt>会場料金合計</dt>
                  <dd class="text-right">{{intval($request->venue_price)+intval($request->extend)}}</dd>
                  {{ Form::hidden('venue_total',intval($request->venue_price)+intval($request->extend) )}}
                </div>
                <div class="col-6">
                  <div class="row">
                    <div class="col-4 bill-box_cell cell-gray">
                      <p>割引率</p>
                    </div>
                    <div class="col-5 bill-box_cell">
                      <p class="text-right">{{$request->venue_discount_percent}}%</p>
                      {{ Form::hidden('venue_discount_percent',intval($request->venue_discount_percent) )}}
                    </div>
                    <div class="col-3 bill-box_cell text-right">
                      <p>割引金額</p>
                      <p class="">{{$request->percent_result}}<span>円</span></p>
                    </div>
                  </div>
                </div>
                <div class="col-6">
                  <div class="row">
                    <div class="col-4 bill-box_cell cell-gray">
                      <p>割引料金</p>
                    </div>
                    <div class="col-5 bill-box_cell">
                      <p class="text-right">{{$request->venue_dicsount_number}}</p>
                      {{ Form::hidden('venue_dicsount_number',intval($request->venue_dicsount_number) )}}
                    </div>
                    <div class="col-3 bill-box_cell text-right">
                      <p>割引率</p>
                      <p class="">{{$request->number_result}}<span>%</span></p>
                    </div>
                  </div>
                </div>
                <div class="col-12 bill-box_cell text-right">
                  <p class="font-weight-bold">割引後会場料金合計</p>
                  <p class="">{{$request->after_discount_price}}</p>
                  {{ Form::hidden('discount_venue_total',$request->after_discount_price)}}
                </div>
              </dl>
              <!-- 料金内訳-------------------------------------------------------------- -->
              <div class="bill-list">
                <h3 class="row">料金内訳</h3>
                <div class="col-12 venue_price_details">
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
                      @if ($v_d_counts)
                      @for ($i = 0; $i < (count($v_d_counts)/4); $i++) <tr>
                        <td>{{$v_d_counts[$i*4]}}</td>
                        <td>{{$v_d_counts[($i*4)+1]}}</td>
                        <td>{{$v_d_counts[($i*4+2)]}}</td>
                        <td>{{$v_d_counts[($i*4+3)]}}</td>
                        </tr>
                        {{ Form::hidden('v_breakdowns['.$i.'][unit_item]', $v_d_counts[$i*4],['class'=>''] ) }}
                        {{ Form::hidden('v_breakdowns['.$i.'][unit_cost]', $v_d_counts[($i*4)+1],['class'=>''] ) }}
                        {{ Form::hidden('v_breakdowns['.$i.'][unit_count]', $v_d_counts[($i*4)+2],['class'=>''] ) }}
                        {{ Form::hidden('v_breakdowns['.$i.'][unit_subtotal]', $v_d_counts[($i*4)+3],['class'=>''] ) }}
                        {{ Form::hidden('v_breakdowns['.$i.'][unit_type]', 1,['class'=>''] ) }}
                        {{-- unit typeは 1会場　2その他備品　3レイアウト --}}
                        @endfor
                        @endif
                    </tbody>
                  </table>
                </div>
                <div class="row bill-box_wrap price-sum bill-box_cell flex-column">
                  <p class="text-right"><span class="font-weight-bold">小計</span>{{$request->venue_subtotal}}</p>
                  <p class="text-right"><span>消費税</span>{{$request->venue_tax}}円</p>
                  <p class="text-right"><span class="font-weight-bold">合計金額</span>{{$request->venue_total}}円</p>
                </div>
              </div>
              <!-- 料金内訳 終わり---------------------------- -->
            </div>
            <!-- 請求内容 終わり---------------------------- -->
            @endif



            <!-- 備品その他　請求内容----------- -->
            <div class="bill-box">
              <h3 class="row">備品その他</h3>
              <dl class="row bill-box_wrap">
                <div class="col-3 bill-box_cell">
                  <dt>有料備品料金</dt>
                  <dd>{{$request->selected_equipments_price}}</dd>
                  {{ Form::hidden('selected_equipments_price',isset($request->selected_equipments_price)?$request->selected_equipments_price:0 )}}
                </div>
                <div class="col-3 bill-box_cell">
                  <dt>有料サービス料金</dt>
                  <dd>{{$request->selected_services_price}}</dd>
                  {{ Form::hidden('selected_services_price',isset($request->selected_services_price)?$request->selected_services_price:0 )}}
                </div>
                <div class="col-3 bill-box_cell">
                  <dt>荷物預かり/返送</dt>
                  <dd class="d-flex align-items-center">{{$request->selected_luggage_price}}
                    {{ Form::hidden('selected_luggage_price',isset($request->selected_luggage_price)?$request->selected_luggage_price:0 )}}
                  </dd>
                </div>
                <div class="col-3 bill-box_cell">
                  <dt>備品その他合計</dt>
                  <dd class="text-right">{{$request->selected_items_total}}</dd>
                  {{ Form::hidden('selected_items_total',isset($request->selected_items_total)?$request->selected_items_total:0 )}}
                </div>

                <div class="col-6">
                  <div class="row">
                    <div class="col-4 bill-box_cell cell-gray">
                      <p>割引料金</p>
                    </div>
                    <div class="col-5 bill-box_cell">
                      <p class="text-right">{{$request->discount_item}}</p>
                      {{ Form::hidden('discount_item',intval($request->discount_item) )}}
                    </div>
                    <div class="col-3 bill-box_cell text-right">
                      <p>割引率</p>
                      <p class="">{{$request->item_discount_percent}}<span>%</span></p>
                    </div>
                  </div>
                </div>

                <div class="col-6 bill-box_cell text-right">
                  <p class="font-weight-bold">割引後備品その他合計</p>
                  <p class="">{{$request->items_discount_price}}</p>
                  {{ Form::hidden('discount_equipment_service_total',isset($request->items_discount_price)?$request->items_discount_price:0 )}}
                </div>
              </dl>

              <!-- 料金内訳-------------------------------------------------------------- -->
              <div class="bill-list">
                <h3 class="row">料金内訳</h3>
                <div class="col-12 items_equipments">
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
                      @if ($e_d_counts)
                      @for ($i = 0; $i < (count($e_d_counts)/4); $i++) <tr>
                        <td>{{$e_d_counts[$i*4]}}</td>
                        <td>{{$e_d_counts[($i*4)+1]}}</td>
                        <td>{{$e_d_counts[($i*4+2)]}}</td>
                        <td>{{$e_d_counts[($i*4+3)]}}</td>
                        </tr>
                        {{ Form::hidden('e_breakdowns['.$i.'][unit_item]', $e_d_counts[$i*4],['class'=>''] ) }}
                        {{ Form::hidden('e_breakdowns['.$i.'][unit_cost]', $e_d_counts[($i*4)+1],['class'=>''] ) }}
                        {{ Form::hidden('e_breakdowns['.$i.'][unit_count]', $e_d_counts[($i*4)+2],['class'=>''] ) }}
                        {{ Form::hidden('e_breakdowns['.$i.'][unit_subtotal]', $e_d_counts[($i*4)+3],['class'=>''] ) }}
                        {{ Form::hidden('e_breakdowns['.$i.'][unit_type]', 2,['class'=>''] ) }}
                        {{-- unit typeは 1会場　2その他備品　3レイアウト --}}
                        @endfor
                        @endif
                    </tbody>
                  </table>
                </div>

                <div class="row bill-box_wrap price-sum bill-box_cell flex-column">
                  <p class="text-right"><span class="font-weight-bold">小計</span>{{$request->items_subtotal}}円</p>
                  <p class="text-right"><span>消費税</span>{{$request->items_tax}}円</p>
                  <p class="text-right"><span class="font-weight-bold">合計金額</span>{{$request->all_items_total}}円</p>
                </div>



              </div>
              <!-- 料金内訳 終わり---------------------------- -->


            </div>
            <!-- 請求内容 終わり---------------------------- -->

            <!-- レイアウト変更 請求内容----------- -->
            <div class="bill-box layout_price_list">
              <h3 class="row">レイアウト変更</h3>
              <dl class="row bill-box_wrap">
                <div class="col-4 bill-box_cell">
                  <dt>レイアウト準備料金</dt>
                  <dd>
                    <p class="layout_prepare_result">{{$request->layout_prepare_result}}</p>
                  </dd>
                </div>
                <div class="col-4 bill-box_cell">
                  <dt>レイアウト片付料金</dt>
                  <dd>
                    <p class="layout_clean_result">{{$request->layout_clean_result}}</p>
                  </dd>
                </div>
                <div class="col-4 bill-box_cell">
                  <dt>レイアウト変更合計</dt>
                  <dd class="text-right">
                    <p class="layout_total">{{$request->layout_total}}</p>
                    {{ Form::hidden('layout_total',isset($request->layout_total)?$request->layout_total:0 )}}
                  </dd>
                </div>

                <div class="col-6">
                  <div class="row">
                    <div class="col-4 bill-box_cell cell-gray">
                      <p>割引料金</p>
                    </div>
                    <div class="col-5 bill-box_cell">
                      <p class="text-right">{{$request->layout_discount}}</p>
                      {{ Form::hidden('layout_discount',intval($request->layout_discount) )}}
                    </div>
                    <div class="col-3 bill-box_cell text-right">
                      <p>割引率</p>
                      <p class="layout_discount_percent">{{$request->layout_discount_percent}}<span>%</span></p>
                    </div>
                  </div>
                </div>

                <div class="col-6 bill-box_cell text-right">
                  <p class="font-weight-bold">割引後レイアウト変更合計</p>
                  <p class="after_duscount_layouts">{{$request->after_duscount_layouts}}</p>
                  {{ Form::hidden('after_duscount_layouts',isset($request->after_duscount_layouts)?$request->after_duscount_layouts:0 )}}
                </div>
              </dl>


              <!-- 料金内訳-------------------------------------------------------------- -->
              <div class="bill-list">
                <h3 class="row">料金内訳</h3>
                <div class="col-12 items_equipments">
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
                      @if ($l_d_counts)
                      @for ($i = 0; $i < (count($l_d_counts)/4); $i++) <tr>
                        <td>{{$l_d_counts[$i*4]}}</td>
                        <td>{{$l_d_counts[($i*4)+1]}}</td>
                        <td>{{$l_d_counts[($i*4+2)]}}</td>
                        <td>{{$l_d_counts[($i*4+3)]}}</td>
                        </tr>
                        {{ Form::hidden('l_breakdowns['.$i.'][unit_item]', $l_d_counts[$i*4],['class'=>''] ) }}
                        {{ Form::hidden('l_breakdowns['.$i.'][unit_cost]', $l_d_counts[($i*4)+1],['class'=>''] ) }}
                        {{ Form::hidden('l_breakdowns['.$i.'][unit_count]', $l_d_counts[($i*4)+2],['class'=>''] ) }}
                        {{ Form::hidden('l_breakdowns['.$i.'][unit_subtotal]', $l_d_counts[($i*4)+3],['class'=>''] ) }}
                        {{ Form::hidden('l_breakdowns['.$i.'][unit_type]', 3,['class'=>''] ) }}
                        {{-- unit typeは 1会場　2その他備品　3レイアウト --}}

                        @endfor
                        @endif
                    </tbody>
                  </table>
                </div>

                <div class="row bill-box_wrap price-sum bill-box_cell flex-column">
                  <p class="text-right"><span class="font-weight-bold">小計</span>
                    {{$request->layout_subtotal}}
                    円</p>
                  <p class="text-right"><span>消費税</span>
                    {{$request->layout_tax}}
                  </p>
                  <p class="text-right"><span class="font-weight-bold">合計金額</span>
                    {{$request->layout_total_amount}}
                  </p>
                </div>



              </div>
              <!-- 料金内訳 終わり---------------------------- -->


            </div>
            <!-- 請求内容 終わり---------------------------- -->
          </div>
        </section>





      </section>
    </div>

    <!-- 予約詳細   終わり--------------------------------------------------　 -->

    <!-- 合計請求額------------------------------------------------------------------- -->
    <div class="total-sum section-wrap">
      <table class="table table-bordered">
        <thead>
          <tr class="bg-green">
            <td colspan="2">
              合計請求額
            </td>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="table-active"><label for="venueFee">会場料</label></td>
            <td class="text-right">
              {{$request->after_discount_price}}
            </td>
          </tr>
          <tr>
            <td class="table-active"><label for="serviceFee">備品その他</label></td>
            <td class="text-right">
              {{$request->items_discount_price}}
            </td>
          </tr>
          <tr>
            <td class="table-active"><label for="layoutFee">レイアウト変更</label></td>
            <td class="text-right">
              {{$request->after_duscount_layouts}}
            </td>
          </tr>
          <tr>
            <td colspan="2" class="text-right">
              <p><span class="font-weight-bold">小計</span>
                {{$sub_total}}
                {{ Form::hidden('sub_total', $sub_total,['class'=>''] ) }}
              </p>
              <p><span>消費税</span>
                {{$tax}}
                {{ Form::hidden('tax', $tax,['class'=>''] ) }}
              </p>
            </td>
          </tr>
          <tr>
            <td colspan="2" class="text-right"><span class="font-weight-bold">請求総額</span>
              {{$total}}
              {{ Form::hidden('total', $total,['class'=>''] ) }}
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <!-- チェックボックス ----------------------------------------------------------------------------->
    {{-- <div class="confirm-box section-wrap">
      <p class="text-center">上記の内容で、登録してもいいでしょうか。</p>
      <dl>
        <dd>
          <p class="text-right"><a class="more_btn" href="">もどる</a></p>
        </dd>
        <dd>
          <p><a class="more_btn" href="">登録する</a></p>
        </dd>
      </dl>
    </div> --}}
  </div>
</div>

{{-- 内訳の配列 --}}


{{ Form::hidden('payment_limit', $payment_limit,['class'=>''] ) }}
{{-- {{ Form::hidden('paid', $paid,['class'=>''] ) }} --}}
{{-- {{ Form::hidden('reservation_status', $reservation_status,['class'=>''] ) }} --}}
{{-- {{ Form::hidden('double_check_status', $double_check_status,['class'=>''] ) }} --}}
{{ Form::hidden('bill_company', $bill_company,['class'=>''] ) }}
{{ Form::hidden('bill_person', $bill_person,['class'=>''] ) }}
{{ Form::hidden('bill_created_at', $bill_created_at,['class'=>''] ) }}
{{ Form::hidden('bill_pay_limit', $bill_pay_limit,['class'=>''] ) }}

<a href="{{ url('/admin/reservations/create'.
'?reserve_date='.$reserve_date.
'&venue_id='.$venue_id.
'&enter_time='.$enter_time.
'&leave_time='.$leave_time.
'&board_flag='.$board_flag.
'&event_start='.$event_start.
'&event_finish='.$event_finish.
'&event_name1='.$event_name1.
'&event_name2='.$event_name2.
'&event_owner='.$event_owner.
'&user_id='.$user_id.
'&in_charge='.$in_charge.
'&tel='.$tel.
'&email_flag='.$email_flag.
'&cost='.$cost.
'&discount_condition='.$discount_condition.
'&attention='.$attention.
'&user_details='.$user_details.
'&admin_details='.$admin_details.
'&payment_limit='.$payment_limit.
// '&paid='.$paid.
// '&reservation_status='.$reservation_status.
// '&double_check_status='.$double_check_status.
'&bill_company='.$bill_company.
'&bill_person='.$bill_person.
'&bill_created_at='.$bill_created_at.
'&bill_pay_limit='.$bill_pay_limit.
'&sub_total='.$sub_total.
'&tax='.$tax.
'&total='.$total
)}}" class="btn btn-danger">戻る</a>

{!! Form::submit('登録', ['class' => 'btn btn-primary']) !!}
{{ Form::close() }}




@endsection