@extends('layouts.admin.app')
@section('content')


<link href="{{ asset('/css/template.css') }}" rel="stylesheet">
<script src="{{ asset('/js/template.js') }}"></script>
<script src="{{ asset('/js/ajax.js') }}"></script>
<script src="{{ asset('/js/lettercounter.js') }}"></script>
<script src="{{ asset('/js/holidays.js') }}"></script>
<script src="{{ asset('/js/admin/reservation/validation.js') }}"></script>



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

<div class="d-flex justify-content-end">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active">
        {{ Breadcrumbs::render(Route::currentRouteName(),$reservation->id) }}
      </li>
    </ol>
  </nav>
</div>

<div class="alert-box d-flex align-items-center mb-0 mt-5">
  <p>
    編集を行う場合は、必ず計算するボタンをクリックしてください。<br>
    請求書内容は、計算するボタンをクリック後の画面で編集できます。
  </p>
</div>　

{{Form::open(['url' => 'admin/reservations/session_for_edit_calculate', 'method' => 'POST', 'id'=>'reservations_edit'])}}
@csrf

<section class="mt-3">
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
            {{ Form::text('', date('Y-m-d', strtotime($reservation->reserve_date)) ,['class'=>'form-control',  'readonly'] ) }}
            {{ Form::hidden('reserve_date', $reservation->reserve_date ,['class'=>'form-control',  'readonly'] ) }}
            <p class="is-error-reserve_date" style="color: red"></p>
          </td>
        </tr>
        <tr>
          <td class="table-active form_required">会場</td>
          <td>
            {{ Form::text('',  ReservationHelper::getVenue($reservation->venue_id),['class'=>'form-control',  'readonly'] ) }}
            {{ Form::hidden('venue_id',  ($reservation->venue_id),['class'=>'form-control',  'readonly'] ) }}
            <p class="is-error-venue_id" style="color: red"></p>
          </td>
        </tr>
        <tr>
          <td class="table-active">料金体系</td>
          <td>
            @if ($venue->getPriceSystem()[0]==1&&$venue->getPriceSystem()[1]==1)
            <div class='price_radio_selector'>
              <div class="d-flex justfy-content-start align-items-center">
                {{ Form::radio('price_system', 1, isset($reservation->price_system)?$reservation->price_system==1?true:false:'', ['class'=>'mr-2', 'id'=>'price_system_radio1']) }}
                {{Form::label('price_system_radio1','通常（枠貸）')}}
              </div>
              <div class="d-flex justfy-content-start align-items-center">
                {{ Form::radio('price_system', 2, isset($reservation->price_system)?$reservation->price_system==2?true:false:'', ['class'=>'mr-2','id'=>'price_system_radio2']) }}
                {{Form::label('price_system_radio2','アクセア（時間貸）')}}
              </div>
            </div>
            @elseif($venue->getPriceSystem()[0]==1&&$venue->getPriceSystem()[1]==0)
            <div class='price_radio_selector'>
              <div class="d-flex justfy-content-start align-items-center">
                {{ Form::radio('price_system', 1, true, ['class'=>'mr-2', 'id'=>'price_system_radio1']) }}
                {{Form::label('price_system_radio1','通常（枠貸）')}}
              </div>
            </div>
            @elseif($venue->getPriceSystem()[0]==0&&$venue->getPriceSystem()[1]==1)
            <div class='price_radio_selector'>
              <div class="d-flex justfy-content-start align-items-center">
                {{ Form::radio('price_system', 2, true, ['class'=>'mr-2','id'=>'price_system_radio2']) }}
                {{Form::label('price_system_radio2','アクセア（時間貸）')}}
              </div>
            </div>
            @endif
          </td>
        </tr>
        <tr>
          <td class="table-active form_required">入室時間</td>
          <td>
            <select name="enter_time" id="sales_start" class="form-control">
              <option disabled selected></option>
              {!!ReservationHelper::timeOptionsWithRequest($reservation->enter_time)!!}
            </select>
          </td>
        </tr>
        <tr>
          <td class="table-active form_required">退室時間</td>
          <td>
            <select name="leave_time" id="sales_finish" class="form-control">
              <option disabled selected></option>
              {!!ReservationHelper::timeOptionsWithRequest($reservation->leave_time)!!}
            </select>
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
            <div class="radio-box">
              <p>
                <input type="radio" name="board_flag" value="1" id="board_flag"
                  {{isset($reservation->board_flag)?$reservation->board_flag==1?'checked':'':'',}}>
                <span>有り</span>
              </p>
              <p>
                <input type="radio" name="board_flag" value="0" id="no_board_flag"
                  {{isset($reservation->board_flag)?$reservation->board_flag==0?'checked':'':'checked',}}>
                <span>無し</span>
              </p>
            </div>
          </td>
        </tr>
        <tr>
          <td class="table-active">イベント名称1</td>
          <td>
            <div class="align-items-end d-flex">
              {{ Form::text('event_name1', $reservation->event_name1,['class'=>'form-control', 'id'=>'eventname1Count'] ) }}
              <span class="ml-1 annotation count_num1"></span>
            </div>
            <p class="is-error-event_name1" style="color: red"></p>
          </td>
        </tr>
        <tr>
          <td class="table-active">イベント名称2</td>
          <td>
            <div class="align-items-end d-flex">
              {{ Form::text('event_name2', $reservation->event_name2,['class'=>'form-control', 'id'=>'eventname2Count'] ) }}
              <span class="ml-1 annotation count_num2"></span>
            </div>
            <p class="is-error-event_name2" style="color: red"></p>
          </td>
        </tr>
        <tr>
          <td class="table-active">主催者名</td>
          <td>
            <div class="align-items-end d-flex">
              {{ Form::text('event_owner', $reservation->event_owner,['class'=>'form-control', 'id'=>'eventownerCount'] ) }}
              <span class="ml-1 annotation count_num3"></span>
            </div>
            <p class="is-error-event_owner" style="color: red"></p>
          </td>
        </tr>
        <tr>
          <td class="table-active">イベント開始時間</td>
          <td>
            <select name="event_start" id="event_start" class="form-control">
              <option disabled>選択してください</option>
              {!!ReservationHelper::timeOptionsWithRequest($reservation->event_start)!!}
            </select>
          </td>
        </tr>
        <tr>
          <td class="table-active">イベント終了時間</td>
          <td>

            <select name="event_finish" id="event_finish" class="form-control">
              <option disabled>選択してください</option>
              {!!ReservationHelper::timeOptionsWithRequest($reservation->event_finish)!!}

            </select>
          </td>
        </tr>
      </table>
      <div class="equipemnts">
        <table class="table table-bordered">
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
            @foreach ($venue->getEquipments() as $key=>$equ)
            <tr>
              <td class="table-active">
                {{$equ->item}}({{$equ->price}}円)
              </td>
              <td>
                <div class="d-flex align-items-end">
                  <input type="text" class="form-control equipment_breakdown" name="{{'equipment_breakdown'.$key}}"
                    @foreach($bill->breakdowns->where('unit_type',2) as $e_break)
                  @if ($e_break->unit_item==$equ->item)
                  value="{{$e_break->unit_count}}"
                  @endif
                  @endforeach
                  ><span class="ml-1">個</span>
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
                <p class="title-icon fw-bolder">
                  <i class="fas fa-hand-holding-heart icon-size" aria-hidden="true"></i>有料サービス
                </p>
              </th>
            </tr>
          </thead>
          <tbody class="accordion-wrap">
            @foreach ($venue->getServices() as $key=>$ser)
            <tr>
              <td class="table-active">{{$ser->item}}({{$ser->price}}円)</td>
              <td>
                <div class="radio-box">
                  <p>
                    {{Form::radio('services_breakdown'.$key, 1, $bill->breakdowns->contains('unit_item',$ser->item)?true:false , ['id' => 'service'.$key.'on'])}}
                    {{Form::label('service'.$key.'on',"有り")}}
                  </p>
                  <p>
                    {{Form::radio('services_breakdown'.$key, 0, $bill->breakdowns->contains('unit_item',$ser->item)?false:true, ['id' => 'service'.$key.'off'])}}
                    {{Form::label('service'.$key.'off',"無し")}}
                  </p>
                </div>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>

      @if ($venue->layout!=0)
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
            <tr>
              <td class="table-active">準備({{number_format($venue->layout_prepare)}}円)</td>
              <td>
                <div class="radio-box">
                  @if ($bill->breakdowns->where('unit_item','レイアウト準備料金')->count()!=0)
                  <p>
                    {{Form::radio('layout_prepare', 1, true, ['id' => 'layout_prepare'])}}
                    {{Form::label('layout_prepare',"有り")}}
                  </p>
                  <p>
                    {{Form::radio('layout_prepare', 0, false, ['id' => 'no_layout_prepare'])}}
                    {{Form::label('no_layout_prepare',"無し")}}
                  </p>
                  @else
                  <p>
                    {{Form::radio('layout_prepare', 1, false, ['id' => 'layout_prepare'])}}
                    {{Form::label('layout_prepare',"有り")}}
                  </p>
                  <p>
                    {{Form::radio('layout_prepare', 0, true, ['id' => 'no_layout_prepare'])}}
                    {{Form::label('no_layout_prepare',"無し")}}
                  </p>
                </div>
              </td>
            </tr>
            @endif
            <tr>
              <td class="table-active">片付({{number_format($venue->layout_clean)}}円)</td>
              <td>
                <div class="radio-box">
                  @if ($bill->breakdowns->where('unit_item','レイアウト片付料金')->count()!=0)
                  <p>
                    {{Form::radio('layout_clean', 1, true, ['id' => 'layout_clean'])}}
                    {{Form::label('layout_clean',"有り")}}
                  </p>
                  <p>
                    {{Form::radio('layout_clean', 0, false, ['id' => 'no_layout_clean'])}}
                    {{Form::label('no_layout_clean',"無し")}}
                  </p>
                  @else
                  <p>
                    {{Form::radio('layout_clean', 1, false, ['id' => 'layout_clean'])}}
                    {{Form::label('layout_clean',"有り")}}
                  </p>
                  <p>
                    {{Form::radio('layout_clean', 0, true, ['id' => 'no_layout_clean'])}}
                    {{Form::label('no_layout_clean',"無し")}}
                  </p>
                  @endif
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      @endif


      @if ($venue->luggage_flag!=0)
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
              <td class="table-active">荷物預かり 工藤さん！！こちら</td>
              <td>
                <div class="radio-box">
                  <p>
                    <input id="luggage_flag" name="luggage_flag" type="radio" value="1">
                    <label for="" class="form-check-label">有り</label>
                  </p>
                  <p>
                    <input id="no_luggage_flag" name="luggage_flag" type="radio" value="0">
                    <label for="" class="form-check-label">無し</label>
                  </p>
                </div>
              </td>
            </tr>
            <tr>
              <td class="table-active">事前に預かる荷物<br>（個数）</td>
              <td>
                {{ Form::text('luggage_count', $reservation->luggage_count,['class'=>'form-control','id'=>'luggage_count'] ) }}
                <p class="is-error-luggage_count" style="color: red"></p>
              </td>
            </tr>
            <tr>
              <td class="table-active">事前荷物の到着日<br>午前指定のみ</td>
              <td>
                {{ Form::text('luggage_arrive', date('Y-m-d',strtotime($reservation->luggage_arrive)),['class'=>'form-control holidays','id'=>'luggage_arrive'] ) }}
              </td>
            </tr>
            <tr>
              <td class="table-active">事後返送する荷物</td>
              <td>
                {{ Form::text('luggage_return', $reservation->luggage_return,['class'=>'form-control','id'=>'luggage_return'] ) }}
                <p class="is-error-luggage_return" style="color: red"></p>
              </td>
            </tr>
            <tr>
              <td class="table-active">荷物預り/返送<br>料金</td>
              <td>
                @foreach ($bill->breakdowns()->get() as $l_prices)
                @if ($l_prices->unit_item=="荷物預り/返送")
                <div class="d-flex align-items-end">
                  {{ Form::text('luggage_price', $l_prices->unit_cost,['class'=>'form-control','id'=>'luggage_price'] ) }}
                  <span class="ml-1 annotation">円</span>
                </div>
                @break
                @elseif($loop->last)
                {{ Form::text('luggage_price', "",['class'=>'form-control'] ) }}
                @endif
                @endforeach
                <p class="is-error-luggage_price" style="color: red"></p>
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
                {{Form::radio('eat_in', 1, $reservation->eat_in==1?true:false , ['id' => 'eat_in'])}}
                {{Form::label('eat_in',"あり")}}
              </td>
              <td>
                {{Form::radio('eat_in_prepare', 1, $reservation->eat_in_prepare==1?true:false , ['id' => 'eat_in_prepare', 'disabled'])}}
                {{Form::label('eat_in_prepare',"手配済み")}}
                {{Form::radio('eat_in_prepare', 2, $reservation->eat_in_prepare==2?true:false , ['id' => 'eat_in_consider','disabled'])}}
                {{Form::label('eat_in_consider',"検討中")}}
              </td>
            </tr>
            <tr>
              <td>
                {{Form::radio('eat_in', 0, $reservation->eat_in==0?true:false , ['id' => 'no_eat_in'])}}
                {{Form::label('no_eat_in',"なし")}}
              </td>
              <td></td>
            </tr>
          </tbody>
        </table>
      </div>
      @endif


    </div>
    <div class="col">
      <div class="client_mater">
        <table class="table table-bordered name-table" style="table-layout:fixed;">
          <tr>
            <td colspan="2">
              <div class="d-flex align-items-center justify-content-between">
                <p class="title-icon">
                  <i class="far fa-id-card icon-size"></i>顧客情報
                </p>
                <p class="user_link">
                  <a class="more_btn" target="_blank" rel="noopener"
                    href="{{url('admin/clients/'.$reservation->user_id)}}">顧客詳細</a>
                </p>
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
            <td class="table-active"><label for="name">担当者氏名</label></td>
            <td>
              <p class="person">
                {{ReservationHelper::getPersonName($reservation->user->id)}}
              </p>
            </td>
          </tr>
          <tr>
            <td class="table-active">メールアドレス</td>
            <td>
              <p class="email">{{ReservationHelper::getPersonEmail($reservation->user->id)}}</p>
            </td>
          </tr>
          <tr>
            <td class="table-active">携帯番号</td>
            <td>
              <p class="mobile">
                {{ReservationHelper::getPersonMobile($reservation->user->id)}}
              </p>
            </td>
          </tr>
          <tr>
            <td class="table-active">固定電話</td>
            <td>
              <p class="tel">
                {{ReservationHelper::getPersonTel($reservation->user->id)}}
              </p>
            </td>
          </tr>
          <tr>
            <td class="table-active">割引条件</td>
            <td>
              <p class="condition">
                {!!nl2br(e(ReservationHelper::getPersonCondition($reservation->user->id)))!!}
              </p>
            </td>
          </tr>
          <tr>
            <td class="table-active caution">注意事項</td>
            <td class="caution">
              <p class="attention">
                {!!nl2br(e(ReservationHelper::getPersonAttention($reservation->user->id)))!!}
              </p>
            </td>
          </tr>
        </table>
        <table class="table table-bordered oneday-table" style="table-layout:fixed;">
          <tr>
            <td colspan="2">
              <p class="title-icon">
                <i class="fas fa-user-check icon-size"></i>当日の連絡できる担当者
              </p>
            </td>
          </tr>
          <tr>
            <td class="table-active"><label for="ondayName" class=" form_required">氏名</label></td>
            <td>
              {{ Form::text('in_charge', $reservation->in_charge,['class'=>'form-control'] ) }}
              <p class="is-error-in_charge" style="color: red"></p>
            </td>
          </tr>
          <tr>
            <td class="table-active"><label for="mobilePhone" class=" form_required">携帯番号</label></td>
            <td>
              {{ Form::text('tel', $reservation->tel,['class'=>'form-control'] ) }}
              <p class="is-error-tel" style="color: red"></p>
            </td>
          </tr>
        </table>
      </div>
      <table class="table table-bordered mail-table" style="table-layout:fixed;">
        <tr>
          <td colspan="2">
            <p class="title-icon">
              <i class="fas fa-envelope icon-size"></i>利用後の送信メール
            </p>
          </td>
        </tr>
        <tr>
          <td class="table-active"><label for="email_flag">送信メール</label></td>
          <td>
            <div class="radio-box">
              <p>
                {{Form::radio('email_flag', '1', $reservation->email_flag==1?true:false, ['id' => 'no_email_flag', 'class' => ''])}}
                {{Form::label('no_email_flag',"有り")}}
              </p>
              <p>
                {{Form::radio('email_flag', '0', $reservation->email_flag==0?true:false, ['id' => 'email_flag', 'class' => ''])}}
                {{Form::label('email_flag', "無し")}}
              </p>
            </div>
            {{-- {{ Form::text('', $reservation->email_flag==1?"有り":"無し",['class'=>'form-control'] ) }}
            {{ Form::hidden('email_flag', $reservation->email_flag,['class'=>'form-control'] ) }} --}}
          </td>
        </tr>
      </table>

      @if ($venue->alliance_flag==1)
      <table class="table table-bordered sale-table" style="table-layout:fixed;">
        <tr>
          <td colspan="2">
            <p class="title-icon">
              <i class="fas fa-yen-sign icon-size"></i>売上原価
              <span class="annotation">
                （提携会場を選択した場合、提携会場で設定した原価率が適応されます）
              </span>
            </p>
          </td>
        </tr>
        <tr>
          <td class="table-active"><label for="cost">原価率</label></td>
          <td>
            <div class="d-flex align-items-end">
              {{ Form::text('', $reservation->cost,['class'=>'form-control'] ) }}
              {{ Form::hidden('cost', $reservation->cost,['class'=>'form-control'] ) }}
              <span class="ml-1 annotation">%</span>
            </div>
            <p class="is-error-cost" style="color: red"></p>
          </td>
        </tr>
      </table>
      @endif

      <table class="table table-bordered note-table">
        <tr>
          <td colspan="2">
            <p class="title-icon">
              <i class="fas fa-file-alt icon-size"></i>備考
            </p>
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
</section>
{{Form::submit('計算する', ['class'=>'btn more_btn_lg mx-auto d-block mt-5 mb-5', 'id'=>'check_submit'])}}
{{Form::close()}}




<script>
  $(document).on('click', '.holidays', function () {
  getHolidayCalendar($('.holidays'), $('input[name="reserve_date"]'));
});

  $(function() {
    $(document).on("click", "input:radio[name='eat_in']", function() {
      var radioTarget = $('input:radio[name="eat_in"]:checked').val();
      if (radioTarget == 1) {
        $('input:radio[name="eat_in_prepare"]').prop('disabled', false);
      } else {
        $('input:radio[name="eat_in_prepare"]').prop('disabled', true);
        $('input:radio[name="eat_in_prepare"]').val("");
      }
    })
  })

  $(function() {

    $(function() {
      $(document).on("click", ".add", function() {
        $(this).parent().parent().clone(true).insertAfter($(this).parent().parent());
        addThisTr('.others .others_main tr', 'others_input_item', 'others_input_cost', 'others_input_count', 'others_input_subtotal');
        addThisTr('.venue_main tr', 'venue_breakdown_item', 'venue_breakdown_cost', 'venue_breakdown_count', 'venue_breakdown_subtotal');
        $(this).parent().parent().next().find('td').find('input, select').eq(0).val('');
        $(this).parent().parent().next().find('td').find('input, select').eq(1).val('');
        $(this).parent().parent().next().find('td').find('input, select').eq(2).val('');
        $(this).parent().parent().next().find('td').find('input, select').eq(3).val('');
      });

      function addThisTr($targetTr, $TItem, $TCost, $TCount, $TSubtotal) {
        var count = $($targetTr).length;
        for (let index = 0; index < count; index++) {
          $($targetTr).eq(index).find('td').eq(0).find('input').attr('name', $TItem + index);
          $($targetTr).eq(index).find('td').eq(1).find('input').attr('name', $TCost + index);
          $($targetTr).eq(index).find('td').eq(2).find('input').attr('name', $TCount + index);
          $($targetTr).eq(index).find('td').eq(3).find('input').attr('name', $TSubtotal + index);
        }
      }

      $(document).on("click", ".del", function() {
        if ($(this).parent().parent().parent().attr('class') == "others_main") {
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

          var venue = $('input[name="venue_price"]').val() ? Number($('input[name="venue_price"]').val()) : 0;
          var equipment = $('input[name="equipment_price"]').val() ? Number($('input[name="equipment_price"]').val()) : 0;
          var layout = $('input[name="layout_price"]').val() ? Number($('input[name="layout_price"]').val()) : 0;
          var others = $('input[name="others_price"]').val() == "" ? 0 : Number($('input[name="others_price"]').val());
          var result = venue + equipment + layout + others;
          var result_tax = Math.floor(result * 0.1);
          $('.total_result').text('').text(result);
          $('input[name="master_subtotal"]').val(result);
          $('input[name="master_tax"]').val(result_tax);
          $('input[name="master_total"]').val(result + result_tax);
        } else if ($(this).parent().parent().parent().attr('class') == "venue_main") {
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

          var venue = $('input[name="venue_price"]').val() ? Number($('input[name="venue_price"]').val()) : 0;
          var equipment = $('input[name="equipment_price"]').val() ? Number($('input[name="equipment_price"]').val()) : 0;
          var layout = $('input[name="layout_price"]').val() ? Number($('input[name="layout_price"]').val()) : 0;
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
@endsection