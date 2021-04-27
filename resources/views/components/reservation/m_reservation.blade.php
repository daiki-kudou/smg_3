{{$form_open1}}
<section class="mt-5">
  <div class="row">
    <div class="col">
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
          <td class="table-active form_required">利用日</td>
          <td>
            {{$reserve_date}}
            {{-- {{ Form::text('reserve_date', date('Y-m-d', strtotime($reservation->reserve_date)) ,['class'=>'form-control',  'readonly'] ) }}
            --}}
            <p class="is-error-reserve_date" style="color: red"></p>
          </td>
        </tr>
        <tr>
          <td class="table-active form_required">会場</td>
          <td>
            {{$venue}}
            {{$venue_hidden}}
            <p class="is-error-venue_id" style="color: red"></p>
          </td>
        </tr>
        <tr>
          <td class="table-active">料金体系</td>
          <td>
            <div class='price_radio_selector'>
              <div class="d-flex justfy-content-start align-items-center">
                {{$price_system1}}
              </div>
              <div class="d-flex justfy-content-start align-items-center">
                {{$price_system2}}
              </div>
          </td>
        </tr>
        <tr>
          <td class="table-active form_required">入室時間</td>
          <td>
            {{$enter_time_loop}}
          </td>
        </tr>
        <tr>
          <td class="table-active form_required">退室時間</td>
          <td>
            {{$leave_time_loop}}
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
          <td class="table-active">案内板</td>
          <td>
            {{$board_flag}}
          </td>
        </tr>
        <tr>
          <td class="table-active">イベント開始時間</td>
          <td>
            {{$event_start_loop}}
          </td>
        </tr>
        <tr>
          <td class="table-active">イベント終了時間</td>
          <td>
            {{$event_finish_loop}}
          </td>
        </tr>
        <tr>
          <td class="table-active">イベント名称1</td>
          <td>
            <div class="align-items-end d-flex">
              {{$event_name1}}
              {{-- {{ Form::text('event_name1', $reservation->event_name1,['class'=>'form-control', 'id'=>'eventname1Count'] ) }}
              --}}
              <span class="ml-1 annotation count_num1"></span>
            </div>
            <p class="is-error-event_name1" style="color: red"></p>
          </td>
        </tr>
        <tr>
          <td class="table-active">イベント名称2</td>
          <td>
            <div class="align-items-end d-flex">
              {{$event_name2}}
              {{-- {{ Form::text('event_name2', $reservation->event_name2,['class'=>'form-control', 'id'=>'eventname2Count'] ) }}
              --}}
              <span class="ml-1 annotation count_num2"></span>
            </div>
            <p class="is-error-event_name2" style="color: red"></p>
          </td>
        </tr>
        <tr>
          <td class="table-active">主催者名</td>
          <td>
            <div class="align-items-end d-flex">
              {{$event_owner}}
              {{-- {{ Form::text('event_owner', $reservation->event_owner,['class'=>'form-control', 'id'=>'eventownerCount'] ) }}
              --}}
              <span class="ml-1 annotation count_num3"></span>
            </div>
            <p class="is-error-event_owner" style="color: red"></p>
          </td>
        </tr>
      </table>
      <div class="equipemnts">
        <table class="table table-bordered" style="table-layout: fixed;">
          <thead class="accordion-ttl">
            <tr>
              <th colspan="2">
                <p class="title-icon fw-bolder">
                  <i class="fas fa-wrench icon-size" aria-hidden="true"></i>有料備品
                </p>
              </th>
            </tr>
          </thead>
          <tbody class="accordion-wrap">
            {{$m_equipment_loop}}
            {{-- @foreach ($venue->getEquipments() as $key=>$equ)
            <tr>
              <td class="table-active">
                {{$equ->item}}
            </td>
            <td>
              <input type="text" class="form-control equipment_breakdown" name="{{'equipment_breakdown'.$key}}"
                @foreach($bill->breakdowns()->where('unit_type',2)->get() as $e_break)
              @if ($e_break->unit_item==$equ->item)
              value="{{$e_break->unit_count}}"
              @endif
              @endforeach --}}
              {{-- >
            </td>
            </tr> --}}
              {{-- @endforeach --}}
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
            {{$m_service_loop}}
            {{-- @if ($checkItem[0][1]>0)
            @foreach ($venue->getServices() as $key=>$ser)
            <tr>
              <td class="table-active">{{$ser->item}}</td>
            <td>
              <div class="radio-box">
                @foreach ($bill->breakdowns()->where('unit_type',3)->get() as $s_break)
                @if ($s_break->unit_item==$ser->item)
                <p>
                  {{Form::radio('services_breakdown'.$key, 1, true , ['id' => 'service'.$key.'on'])}}
                  {{Form::label('service'.$key.'on',"有り")}}
                </p>
                <p>
                  {{Form::radio('services_breakdown'.$key, 0, false, ['id' => 'service'.$key.'off'])}}
                  {{Form::label('service'.$key.'off',"無し")}}
                </p>
                @break
                @elseif($loop->last)
                <p>
                  {{Form::radio('services_breakdown'.$key, 1, false , ['id' => 'service'.$key.'on'])}}
                  {{Form::label('service'.$key.'on',"有り")}}
                </p>
                <p>
                  {{Form::radio('services_breakdown'.$key, 0, true, ['id' => 'service'.$key.'off'])}}
                  {{Form::label('service'.$key.'off',"無し")}}
                </p>
                @endif
                @endforeach
              </div>
            </td>
            </tr>
            @endforeach
            @else
            @foreach ($venue->getServices() as $key=>$ser)
            <tr>
              <td>{{$ser->item}}</td>
              <td>
                <div class="radio-box">
                  <p>
                    {{Form::radio('services_breakdown'.$key, 1, false , ['id' => 'service'.$key.'on'])}}
                    {{Form::label('service'.$key.'on',"有り")}}
                  </p>
                  <p>
                    {{Form::radio('services_breakdown'.$key, 0, true, ['id' => 'service'.$key.'off'])}}
                    {{Form::label('service'.$key.'off',"無し")}}
                  </p>
                </div>
              </td>
            </tr>
            @endforeach
            @endif --}}
          </tbody>
        </table>
      </div>
      <div class='layouts'>
        <table class='table table-bordered' style="table-layout:fixed;">
          <thead>
            <tr>
              <th colspan='2'>
                <p class="title-icon py-1">
                  <i class="fas fa-th icon-size fa-fw"></i>レイアウト
                </p>
              </th>
            </tr>
          </thead>
          <tbody>
            {{$m_layout_loop}}
          </tbody>
        </table>
      </div>
      <div class='luggage'>
        <table class='table table-bordered' style="table-layout:fixed;">
          <thead>
            <tr>
              <th colspan='2'>
                <p class="title-icon">
                  <i class="fas fa-suitcase-rolling icon-size fa-fw"></i>荷物預り
                </p>
              </th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="table-active">事前に預かる荷物<br>（個数）</td>
              <td>
                {{$luggage_count}}
                {{-- {{ Form::text('luggage_count', $reservation->luggage_count,['class'=>'form-control'] ) }} --}}
                <p class="is-error-luggage_count" style="color: red"></p>
              </td>
            </tr>
            <tr>
              <td class="table-active">事前荷物の到着日<br>午前指定のみ</td>
              <td>
                {{$luggage_arrive}}
                {{-- {{ Form::text('luggage_arrive', $reservation->luggage_arrive,['class'=>'form-control'] ) }} --}}
              </td>
            </tr>
            <tr>
              <td class="table-active">事後返送する荷物</td>
              <td>
                {{$luggage_return}}
                {{-- {{ Form::text('luggage_return', $reservation->luggage_return,['class'=>'form-control'] ) }} --}}
                <p class="is-error-luggage_return" style="color: red"></p>
              </td>
            </tr>
          </tbody>
        </table>
      </div>


      {{$eat_in1}}


    </div>
    <div class="col">
      <div class="client_mater">
        <table class="table table-bordered name-table">
          <tr>
            <td colspan="2">
              <div class="d-flex align-items-center justify-content-between">
                <p class="title-icon">
                  <i class="far fa-id-card icon-size"></i>仲介会社情報
                </p>
                <p>
                  {{$client_link}}
                  {{-- <a class="more_btn" href="">仲介会社詳細工藤さん！リンク</a> --}}
                </p>
              </div>
            </td>
          </tr>
          <tr>
            <td class="table-active">
              <label for="agent_id">サービス名称</label>
            </td>
            <td>
              {{$agent_select}}
              <p class="is-error-user_id" style="color: red"></p>
            </td>
          </tr>
          <tr>
            <td class="table-active"><label for="name">担当者氏名<br></label></td>
            <td>
              {{$agent_person}}
              <p class="selected_person"></p>
            </td>
          </tr>
        </table>
        <table class="table table-bordered oneday-table">
          <tr>
            <td colspan="2">
              <p class="title-icon">
                <i class="fas fa-user-check icon-size"></i>エンドユーザー情報
              </p>
            </td>
          </tr>
          <tr>
            <td class="table-active">
              <label for="enduser_company" class="">エンドユーザー</label>
            </td>
            <td>
              {{-- {{$reservation->enduser->company}} --}}
              {{$end_user}}
            </td>
          </tr>
          <tr>
            <td class="table-active">
              <label for="enduser_address" class=" ">住所</label>
            </td>
            <td>
              {{$end_user_address}}
              {{-- {{$reservation->enduser->address}} --}}
            </td>
          </tr>
          <tr>
            <td class="table-active">
              <label for="enduser_tel" class="">連絡先</label>
            </td>
            <td>
              {{$end_user_tel}}
              {{-- {{$reservation->enduser->tel}} --}}
            </td>
          </tr>
          <tr>
            <td class="table-active">
              <label for="enduser_mail" class=" ">メールアドレス</label>
            </td>
            <td>
              {{$end_user_email}}
              {{-- {{$reservation->enduser->email}} --}}
            </td>
          </tr>
          <tr>
            <td class="table-active">
              <label for="enduser_incharge" class="">当日担当者</label>
            </td>
            <td>
              {{$end_user_person}}
              {{-- {{$reservation->enduser->person}} --}}
            </td>
          </tr>
          <tr>
            <td class="table-active">
              <label for="" class="">当日連絡先</label>
            </td>
            <td>
              {{$end_user_mobile}}
              {{-- {{$reservation->enduser->mobile}} --}}
            </td>
          </tr>
          <tr>
            <td class="table-active">
              <label for="enduser_attr" class="">利用者属性</label>
            </td>
            <td>
              {{$end_user_attr}}
              {{-- {{$reservation->enduser->attr}} --}}
            </td>
          </tr>
        </table>
      </div>
      <table class="table table-bordered sale-table">
        <tr>
          <td colspan="2">
            <p class="title-icon">
              <i class="fas fa-yen-sign icon-size"></i>エンドユーザーへの支払い料
            </p>
          </td>
        </tr>
        <tr>
          <td class="table-active form_required">
            <label for="enduser_charge">支払い料</label>
          </td>
          <td class="d-flex align-items-center">
            {{$end_user_charge}}円
            <p class="is-error-end_user_charge" style="color: red"></p>
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
        {{-- <tr>
          <td>
            <label for="userNote">申し込みフォーム備考</label>
            <div>
              {{$user_details}}
    </div>
    </td>
    </tr> --}}
    <tr>
      <td>
        <label for="adminNote">管理者備考</label>
        <div>
          {{$admin_details}}
          {{-- {{$reservation->admin_details}} --}}
        </div>
      </td>
    </tr>
    </table>
  </div>
  </div>
</section>
{{$form_submit1}}
{{$form_close1}}
{{-- {{Form::submit('再計算する', ['class'=>'btn more_btn4_lg mx-auto d-block mt-5 mb-5', 'id'=>'check_submit'])}} --}}
{{-- {{Form::close()}} --}}

{{$form_open2}}
{{-- {{ Form::open(['url' => '###################', 'method'=>'POST', 'id'=>'reservations_calculate_form']) }} --}}
{{-- @csrf --}}
<section class="mt-5">
  <div class="bill">
    <div class="bill_head">
      <table class="table bill_table">
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
                {{$master_total1}}
                {{-- {{number_format($reservation->bills()->first()->master_total)}} --}}
                円</dd>
            </dl>
          </td>
          <td>
            <dl class="ttl_box">
              <dt>支払い期日</dt>
              <dd class="total_result">
                {{$payment_limit}}
                {{-- {{ReservationHelper::formatDate($bill->payment_limit)}} --}}
              </dd>
            </dl>
          </td>
        </tr>
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
                <td>単価</td>
                <td>数量</td>
                <td>金額</td>
              </tr>
            </tbody>
            <tbody class="venue_main">
              {{$venue_breakdown_loop}}
            </tbody>
            {{-- <tbody class="venue_result">
              <tr>
                <td colspan="3"></td>
                <td colspan="1">
                  <p class="text-left">合計</p>
                </td>
              </tr>
            </tbody> --}}
          </table>
        </div>

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
              {{$equipment_breakdown_loop}}
              {{$service_breakdown_loop}}
              {{-- @foreach ($checkItem[1][1] as $key=>$equipment_price)
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
              @foreach ($checkItem[1][2] as $key=>$service_price)
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
              @endforeach --}}
            </tbody>
          </table>
        </div>

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
              {{$layout_breakdown_loop}}
            </tbody>
            <tbody class="layout_result">
              <tr>
                <td colspan="3"></td>
                <td colspan="1">
                  <p class="text-left">合計</p>
                  {{$layout_price}}
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <div class="others billdetails_content">
          <table class="table table-borderless">
            <tr>
              <td colspan="5">
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
                {!!empty(preg_match('/edit_check/',url()->current()))?"<td>追加/削除</td>":""!!}
              </tr>
            </tbody>
            <tbody class="others_main">
              {{$others_breakdown_loop}}
              {{-- @foreach ($checkItem[1][4] as $key=>$others_price)
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
              <td>工藤さん！！！追加と削除のボタンの実装</td>
              </tr>
              @endforeach --}}
            </tbody>

          </table>
        </div>
        <div class="bill_total">
          <table class="table text-right">
            <tr>
              <td>小計：</td>
              <td>
                {{$master_subtotal}}
                {{-- {{ Form::text('master_subtotal', $bill->master_subtotal,['class'=>'form-control', 'readonly'] ) }}
                --}}
              </td>
            </tr>
            <tr>
              <td>消費税：</td>
              <td>
                {{$master_tax}}
                {{-- {{ Form::text('master_tax', $bill->master_tax,['class'=>'form-control', 'readonly'] ) }} --}}
              </td>
            </tr>
            <tr>
              <td class="font-weight-bold">合計金額</td>
              <td>
                {{$master_total2}}
                {{-- {{ Form::text('master_total', $bill->master_total,['class'=>'form-control', 'readonly'] ) }} --}}
              </td>
            </tr>
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
            <tr>
              <td>請求日
                {{$bill_created_at}}
                {{-- {{ Form::text('bill_created_at', $bill->bill_created_at,['class'=>'form-control', 'id'=>'datepicker6'] ) }}
                --}}
              </td>
              <td>支払期日
                {{$pay_limit}}
                {{-- {{ Form::text('pay_limit', $bill->pay_limit,['class'=>'form-control', 'id'=>'datepicker6'] ) }}
                --}}
              </td>
            </tr>
            <tr>
              <td>請求書宛名
                {{$pay_company}}
                {{-- {{ Form::text('pay_company', $user->company,['class'=>'form-control'] ) }} --}}
              </td>
              <td>
                担当者
                {{$bill_person}}
                {{-- {{ Form::text('bill_person', $bill->pay_person,['class'=>'form-control'] ) }} --}}
              </td>
            </tr>
            <tr>
              <td colspan="2">請求書備考
                {{$bill_remark}}
                {{-- {{ Form::textarea('bill_remark', '',['class'=>'form-control'] ) }} --}}
              </td>
            </tr>
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
        <div class="paids billdetails_content pt-3">
          <table class="table" style="table-layout: fixed;">
            <tr>
              <td>入金状況
                {{$paid_select}}
              </td>
              <td>
                入金日
                {{$pay_day}}
              </td>
            </tr>
            <tr>
              <td>
                振込人名
                {{-- {{ Form::text('pay_person', $bill->pay_person,['class'=>'form-control'] ) }} --}}
                {{$pay_person}}
                <p class="is-error-pay_person" style="color: red"></p>
              </td>
              <td>入金額
                {{$payment}}
                {{-- {{ Form::text('payment', $bill->payment,['class'=>'form-control'] ) }} --}}
                <p class="is-error-payment" style="color: red"></p>
              </td>
            </tr>
          </table>
        </div>
      </div>
    </div>
  </div>
</section>

{{$form_submit2}}
{{$form_close2}}


<script>
  $(function() {
    $(document).on("click", "input:radio[name='eat_in']", function() {
      var radioTarget = $('input:radio[name="eat_in"]:checked').val();
      if (radioTarget == 1) {
        $('input:radio[name="eat_in_prepare"]').prop('disabled', false);
        $('input:radio[name="eat_in_prepare"]:first-child').prop('checked', true);
      } else {
        $('input:radio[name="eat_in_prepare"]').prop('disabled', true);
        $('input:radio[name="eat_in_prepare"]').val("");
      }
    })
  })
</script>