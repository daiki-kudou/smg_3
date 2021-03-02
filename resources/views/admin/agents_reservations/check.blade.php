@extends('layouts.admin.app')
@section('content')


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

<!-- <h1>仲介会社　予約 計算</h1> -->


{{Form::open(['url' => 'admin/agents_reservations', 'method' => 'POST', 'id'=>'agentReservationCreateForm'])}}
@csrf
<section class="section-wrap">
  <div class="row">
    <div class="col">
      <table class="table table-bordered">
        <tr>
          <td colspan="2">
            <p class="title-icon">
              <i class="fas fa-info-circle icon-size"></i>予約情報
            </p>
          </td>
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
      </table>

      <table class="table table-bordered board-table">
        <tr>
          <td colspan="2">
            <div class="d-flex align-items-center justify-content-between">
              <p class="title-icon">
                <i class="fas fa-clipboard icon-size"></i>案内版
              </p>
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
        <table class="table table-bordered">
          <thead>
            <tr>
              <th colspan="2">
                <div class="d-flex justify-content-between align-items-center">
                  <p class="title-icon fw-bolder py-1">
                    <i class="fas fa-wrench icon-size fa-fw"></i>有料備品
                  </p>
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
        <table class="table table-bordered">
          <thead>
            <tr>
              <th colspan="2">
                <div class="d-flex justify-content-between align-items-center">
                  <p class="title-icon fw-bolder py-1">
                    <i class="fas fa-hand-holding-heart icon-size fa-fw"></i>有料サービス
                  </p>
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
        <table class='table table-bordered'>
          <thead>
            <tr>
              <th colspan='2'>
                <p class="title-icon">
                  <i class="fas fa-th icon-size fa-fw"></i>レイアウト
                </p>
              </th>
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
        <table class='table table-bordered'>
          <thead>
            <tr>
              <th colspan='2'>
                <p class="title-icon">
                  <i class="fas fa-suitcase-rolling icon-size fa-fw"></i>荷物預かり
                </p>
              </th>
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
    </div>
    {{-- 右側 --}}
    <div class="col">
      <!-- <div class="client_mater">　 -->
      <table class="table table-bordered name-table">
        <tr>
          <td colspan="2">
            <div class="d-flex align-items-center justify-content-between">
              <p class="title-icon">
                <i class="far fa-id-card icon-size"></i>仲介会社情報
              </p>
              <p><a class="more_btn bg-green" href="">仲介会社詳細</a></p>
            </div>
          </td>
        </tr>
        <tr>
          <td class="table-active">
            <label for="agent_id" class=" form_required">サービス名称</label>
          </td>
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
      <table class="table table-bordered oneday-table">
        <tr>
          <td colspan="2">
            <p class="title-icon">
              <i class="fas fa-user-check icon-size"></i>仲介会社の顧客
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
            <label for="enduser_mobile" class="">当日連絡先</label>
          </td>
          <td>
          {{ Form::text('enduser_mobile', $request->enduser_mobile,['class'=>'form-control', 'readonly'] ) }}
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
      <!-- </div> -->
      <table class="table table-bordered sale-table">
        <tr>
          <td colspan="2">
            <p class="title-icon">
              <i class="fas fa-yen-sign icon-size"></i>仲介会社の顧客への支払い料
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
      <table class="table table-bordered note-table">
        <tr>
          <td colspan="2">
            <p class="title-icon">
              <i class="fas fa-envelope icon-size"></i>備考
            </p>
          </td>
        </tr>
        <!-- <tr class="caution">
          <td>
            <label for="caution">注意事項</label>
            {{ Form::textarea('attention', $request->attention,['class'=>'form-control', 'placeholder'=>'入力してください'] ) }}
          </td>
        </tr>
        <tr>
          <td>
            <label for="userNote">顧客情報の備考</label>
            {{ Form::textarea('user_details', $request->user_details,['class'=>'form-control', 'placeholder'=>'入力してください'] ) }}
          </td>
        </tr> -->
        <tr>
          <td>
            <label for="adminNote">管理者備考</label>
            {{ Form::textarea('admin_details', $request->admin_details,['class'=>'form-control', 'placeholder'=>'入力してください'] ) }}

          </td>
        </tr>
      </table>
    </div>
  </div>
</section>


{{-- 以下、詳細内訳 --}}
<section class="section-wrap">
  <div class="bill">
    <div class="bill_head">
      <table class="table">
        <tr>
          <td>
            <h2 class="text-white">
              請求書No
            </h2>
          </td>
          <td>
            <dl class="ttl_box">
              <dt>合計金額</dt>
              <dd class="total_result">{{number_format($request->master_subtotal)}}円</dd>
            </dl>
          </td>
          <td>
            <dl class="ttl_box">
              <dt>支払い期日</dt>
              <dd class="total_result">{{ReservationHelper::formatDate($request->pay_limit)}}</dd>
            </dl>
          </td>
        </tr>
        <!-- <tr>
          <td></td>
          <td style="font-size: 16px;">
            <div class="bg-white d-flex justify-content-around align-items-center" style="height: 60px;">
              <div>支払い期日</div>
              <div>{{ReservationHelper::formatDate($request->pay_limit)}}
              </div>
            </div>
          </td>
        </tr> -->
      </table>
    </div>
    <div class="bill_details">
      <div class="head d-flex">
        <div class="accordion_btn">
          <i class="fas fa-plus bill_icon_size hide"></i>
          <i class="fas fa-minus bill_icon_size"></i>
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
            <tr>
              <td>
                <h4 class="billdetails_content_ttl">
                  会場料
                </h4>
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
                    {{ Form::text('service_breakdown_item'.$i, $s_services[$i*2] ,['class'=>'form-control','readonly'] ) }}
                  </td>
                  <td>
                    {{ Form::text('service_breakdown_count'.$i, $s_services[$i*2+1] ,['class'=>'form-control','readonly'] ) }}
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
              @if ($request->layout_prepare_count==1)
              <tr>
                <td>
                  {{ Form::text('layout_prepare_item', $request->layout_prepare_item ,['class'=>'form-control','readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('layout_prepare_cost', $request->layout_prepare_cost ,['class'=>'form-control','readonly'] ) }}
                </td>
                </td>
                <td>
                  {{ Form::text('layout_prepare_count', $request->layout_prepare_count ,['class'=>'form-control','readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('layout_prepare_subtotal', $request->layout_prepare_subtotal ,['class'=>'form-control','readonly'] ) }}
                </td>
              </tr>
              @endif
              @if ($request->layout_clean_count==1)
              <tr>
                <td>
                  {{ Form::text('layout_clean_item', $request->layout_clean_item ,['class'=>'form-control','readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('layout_clean_cost', $request->layout_clean_cost ,['class'=>'form-control','readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('layout_clean_count', $request->layout_clean_count ,['class'=>'form-control','readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('layout_clean_subtotal', $request->layout_clean_subtotal ,['class'=>'form-control','readonly'] ) }}
                </td>
              </tr>
              @endif
            </tbody>
            <tbody class="layouts_result">
              <tr>
                <td colspan="2"></td>
                <td colspan="2">合計
                  {{ Form::text('layouts_price', $request->layouts_price,['class'=>'form-control', 'readonly'] ) }}
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        {{-- 以下、その他 --}}
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
        <div class="bill_total">
          <table class="table text-right">
            <tr>
              <td>小計：</td>
              <td>
                {{ Form::text('master_subtotal',$request->master_subtotal ,['class'=>'form-control text-right', 'readonly'] ) }}
              </td>
            </tr>
            <tr>
              <td>消費税：</td>
              <td>
                {{ Form::text('master_tax',$request->master_tax ,['class'=>'form-control text-right', 'readonly'] ) }}
              </td>
            </tr>
            <tr>
              <td class="font-weight-bold">合計金額</td>
              <td>
                {{ Form::text('master_total',$request->master_total ,['class'=>'form-control text-right', 'readonly'] ) }}
              </td>
            </tr>
          </table>
        </div>
      </div>
    </div>
  </div>

  {{-- 以下、請求情報 --}}
  <div class="information">
    <div class="information_details">
      <div class="head d-flex">
        <div class="accordion_btn">
          <i class="fas fa-plus bill_icon_size hide"></i>
          <i class="fas fa-minus bill_icon_size"></i>
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
        <div class="d-flex align-items-center">
          <h3 class="pl-3">
            入金情報
          </h3>
        </div>
      </div>
      <div class="main">
        <div class="paids billdetails_content">
          <table class="table">
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
</section>

<div class="container-field d-flex justify-content-center mt-5">
  <a href="javascript:$('#test_post').submit()" class="btn more_btn4_lg d-block mr-5">請求内訳を修正する</a>
  {{Form::submit('作成する', ['class'=>'d-block btn more_btn_lg', 'id'=>'check_submit'])}}
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