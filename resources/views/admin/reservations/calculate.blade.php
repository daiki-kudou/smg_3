@extends('layouts.admin.app')
@section('content')

<link href="{{ asset('/css/template.css') }}" rel="stylesheet">
<script src="{{ asset('/js/template.js') }}"></script>
<script src="{{ asset('/js/lettercounter.js') }}"></script>
<script src="{{ asset('/js/admin/reservation/validation.js') }}"></script>
<script src="{{ asset('/js/admin/reservation/control_time.js') }}"></script>
<script src="{{ asset('/js/holidays.js') }}"></script>


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
        {{ Breadcrumbs::render(Route::currentRouteName()) }}
      </li>
    </ol>
  </nav>
</div>

{{Form::open(['url' => 'admin/reservations/store_session', 'method' => 'post', 'id'=>'reservationCreateForm'])}}

@csrf
<section class="mt-4">
  <div class="row">
    <div class="col">
      <table class="table table-bordered reserve_table">
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
              {{ Form::text('reserve_date', $value["reserve_date"] ,['class'=>'form-control',
                  'id'=>'', 'placeholder'=>'入力してください','readonly'] ) }}
              <p class="is-error-reserve_date" style="color: red"></p>
            </td>
          </tr>
          <tr>
            <td class="table-active form_required">会場</td>
            <td>
              {{ Form::text('', ReservationHelper::getVenue($value['venue_id']) ,['class'=>'form-control','readonly'] ) }}
              {{ Form::hidden('venue_id', ($value['venue_id']) ,['class'=>'form-control','readonly'] ) }}
              <p class="is-error-venue_id" style="color: red"></p>
            </td>
          </tr>
          <tr>
            <td class="table-active">料金体系</td>
            <td>
              {{ Form::text('', $value['price_system']==1?"通常（枠貸）":"アクセア（時間貸）" ,['class'=>'form-control','readonly'] ) }}
              {{ Form::hidden('price_system', $value['price_system'] ,['class'=>'form-control','readonly'] ) }}
            </td>
          </tr>
          <tr>
            <td class="table-active form_required">入室時間</td>
            <td>
              <select name="enter_time" id="sales_start" class="form-control">
                <option disabled selected></option>
                {!!ReservationHelper::timeOptionsWithRequest($value['enter_time'])!!}
                {{-- @for ($start = 0*2; $start <=23*2; $start++) <option
                  value="{{date("H:i:s", strtotime("00:00 +". $start * 30 ." minute"))}}" @if (date("H:i:s",
                strtotime("00:00 +". $start * 30 ." minute"))==$value['enter_time']) selected @endif>
                {{date("H時i分", strtotime("00:00 +". $start * 30 ." minute"))}}
                </option>
                @endfor --}}
              </select>
            </td>
          </tr>
          <tr>
            <td class="table-active form_required">退室時間</td>
            <td>
              <select name="leave_time" id="sales_finish" class="form-control">
                <option disabled selected></option>
                {!!ReservationHelper::timeOptionsWithRequest($value['leave_time'])!!}
                {{-- @for ($start = 0*2; $start <=23*2; $start++) <option
                  value="{{date("H:i:s", strtotime("00:00 +". $start * 30 ." minute"))}}" @if (date("H:i:s",
                strtotime("00:00 +". $start * 30 ." minute"))==$value['leave_time']) selected @endif>
                {{date("H時i分", strtotime("00:00 +". $start * 30 ." minute"))}}</option>
                @endfor --}}
              </select>
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
              <div class="radio-box">
                <p>
                  <input type="radio" name="board_flag" value="1" id="board_flag"
                    {{$value['board_flag']==1?"checked":""}}>
                  {{Form::label('board_flag','有り')}}
                </p>
                <p>
                  <input type="radio" name="board_flag" value="0" id="no_board_flag"
                    {{$value['board_flag']==0?"checked":""}}>
                  {{Form::label('no_board_flag','無し')}}
                </p>
              </div>
            </td>
          </tr>

          <tr>
            <td class="table-active">イベント名称1</td>
            <td>
              <div class="align-items-end d-flex">
                @if (!empty($value['event_name1']))
                {{ Form::text('event_name1', $value['event_name1'],['class'=>'form-control','id'=>'eventname1Count'] ) }}
                @else
                {{ Form::text('event_name1', "",['class'=>'form-control','id'=>'eventname1Count'] ) }}
                @endif
                <span class="ml-1 annotation count_num1"></span>
              </div>
              <p class="is-error-event_name1" style="color: red"></p>
            </td>
          </tr>
          <tr>
            <td class="table-active">イベント名称2</td>
            <td>
              <div class="align-items-end d-flex">
                @if (!empty($value['event_name1']))
                {{ Form::text('event_name2', $value['event_name2'],['class'=>'form-control', 'id'=>'eventname2Count'] ) }}
                @else
                {{ Form::text('event_name2', '',['class'=>'form-control', 'id'=>'eventname2Count'] ) }}
                @endif
                <span class="ml-1 annotation count_num2"></span>
              </div>
              <p class="is-error-event_name2" style="color: red"></p>
            </td>
          </tr>
          <tr>
            <td class="table-active">主催者名</td>
            <td>
              <div class="align-items-end d-flex">
                @if (!empty($value['event_name1']))
                {{ Form::text('event_owner', $value['event_owner'],['class'=>'form-control', 'id'=>'eventownerCount'] ) }}
                @else
                {{ Form::text('event_owner', '',['class'=>'form-control', 'id'=>'eventownerCount'] ) }}
                @endif
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
                @if ($value['board_flag']==1)
                <option value="" disabled>選択してください</option>
                {!!ReservationHelper::timeOptionsWithRequestAndLimit($value['event_start'],$value['enter_time'],$value['leave_time'])!!}
                @else
                <option value="" selected></option>
                {!!ReservationHelper::timeOptionsWithRequestAndLimit("",$value['enter_time'],$value['leave_time'])!!}
                @endif
              </select>
            </td>
          </tr>

          <tr>
            <td class="table-active">イベント終了時間</td>
            <td>
              <select name="event_finish" id="event_finish" class="form-control">
                <option disabled>選択してください</option>
                {{-- {!!ReservationHelper::timeOptionsWithRequest($value['event_finish'])!!} --}}
                @if ($value['board_flag']==1)
                <option value="" disabled>選択してください</option>
                {!!ReservationHelper::timeOptionsWithRequestAndLimit($value['event_finish'],$value['enter_time'],$value['leave_time'])!!}
                @else
                <option value="" selected></option>
                {!!ReservationHelper::timeOptionsWithRequestAndLimit("",$value['enter_time'],$value['leave_time'])!!}
                @endif
                {{-- @for ($start = 0*2; $start <=23*2; $start++) <option
                  value="{{date("H:i:s", strtotime("00:00 +". $start * 30 ." minute"))}}"
                @if(!empty($value['event_finish'])) @if (date("H:i:s", strtotime("00:00 +". $start * 30
                ."minute"))==$value['event_finish']) selected @endif @endif>
                {{date("H時i分", strtotime("00:00 +". $start * 30 ." minute"))}}
                </option>
                @endfor --}}
              </select>
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
                  <i class="fas fa-wrench icon-size fa-fw"></i>有料備品
                </p>
              </th>
            </tr>
          </thead>
          <tbody class="accordion-wrap">
            @foreach ($spVenue->getEquipments() as $key=>$equipment)
            <tr>
              <td class="table-active">{{$equipment->item}}({{$equipment->price}}円)</td>
              <td>
                <div class="d-flex align-items-end">
                  {{ Form::number('equipment_breakdown'.$key, $value['equipment_breakdown'.$key],['class'=>'form-control equipment_breakdown equipment_validation'] ) }}
                  <span class="ml-1">個</span>
                </div>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <div class="services">
        <table class="table table-bordered">
          <thead class="accordion-ttl">
            <tr>
              <th colspan="2">
                <p class="title-icon fw-bolder py-1">
                  <i class="fas fa-hand-holding-heart icon-size fa-fw"></i>有料サービス
                </p>
              </th>
            </tr>
          </thead>
          <tbody class="accordion-wrap">
            @foreach ($spVenue->getServices() as $key=>$service)
            <tr>
              <td class="table-active">
                {{$service->item}}({{$service->price}}円)
              </td>
              <td>
                <div class="radio-box">
                  <p>
                    {{Form::radio('services_breakdown'.$key, 1, $value['services_breakdown'.$key]==1?true:false , ['id' => 'service'.$key.'on'])}}
                    <label for="{{'service'.$key.'on'}}" class="form-check-label">有り</label>
                  </p>
                  <p>
                    {{Form::radio('services_breakdown'.$key, 0, $value['services_breakdown'.$key]==0?true:false, ['id' => 'services_breakdown'.$key.'off'])}}
                    <label for="{{'services_breakdown'.$key.'off'}}" class="form-check-label">無し</label>
                  </p>
                </div>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>

      @if ($spVenue->layout!=0)
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
              <td class="table-active">準備({{number_format($spVenue->layout_prepare)}}円)</td>
              <td>
                <div class="radio-box">
                  <p>
                    {{Form::radio('layout_prepare', 1, $value['layout_prepare']==1?true:false, ['id' => 'layout_prepare'])}}
                    <label for='layout_prepare' class="form-check-label">有り</label>
                  </p>
                  <p>
                    {{Form::radio('layout_prepare', 0, $value['layout_prepare']==0?true:false, ['id' => 'no_layout_prepare'])}}
                    <label for='no_layout_prepare' class="form-check-label">無し</label>
                  </p>
                </div>
              </td>
            </tr>
            <tr>
              <td class="table-active">片付({{number_format($spVenue->layout_clean)}}円)</td>
              <td>
                <div class="radio-box">
                  <p>
                    {{Form::radio('layout_clean', 1, $value['layout_clean']==1?true:false, ['id' => 'layout_clean'])}}
                    <label for='layout_clean' class="form-check-label">有り</label>
                  </p>
                  <p>
                    {{Form::radio('layout_clean', 0, $value['layout_clean']==0?true:false, ['id' => 'no_layout_clean'])}}
                    <label for='no_layout_clean' class="form-check-label">無し</label>
                  </p>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      @endif

      @if ($spVenue->luggage_flag!=0)
      <div class="luggage">
        <table class="table table-bordered" style="table-layout:fixed;">
          <thead>
            <tr>
              <th colspan="2">
                <p class="title-icon">
                  <i class="fas fa-suitcase-rolling icon-size fa-fw" aria-hidden="true"></i>荷物預かり
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
                  {{ Form::number('luggage_count', !empty($value['luggage_count'])?$value['luggage_count']:"",['class'=>'form-control','id'=>'luggage_count'] ) }}
                  <p class="is-error-luggage_count" style="color: red"></p>
                </td>
              </tr>
            <tr>
              <td class="table-active">事前荷物の到着日<br>午前指定のみ</td>
              <td>
                {{ Form::text('luggage_arrive', !empty($value['luggage_arrive'])?$value['luggage_arrive']:"",['class'=>'form-control holidays','id'=>'luggage_arrive'] ) }}
              </td>
            </tr>
            <tr>
              <td class="table-active">事後返送する荷物</td>
              <td>
                {{ Form::number('luggage_return', !empty($value['luggage_return'])?$value['luggage_return']:"",['class'=>'form-control','id'=>'luggage_return'] ) }}
                <p class="is-error-luggage_return" style="color: red"></p>
              </td>
            </tr>
            <tr>
              <td class="table-active">荷物預かり<br>料金</td>
              <td>
                <div class="d-flex align-items-end">
                  {{ Form::text('luggage_price', !empty($value['luggage_price'])?$value['luggage_price']:"",['class'=>'form-control','id'=>'luggage_price'] ) }}
                  <span class="ml-1 annotation">円</span>
                </div>
                <p class="is-error-luggage_price" style="color: red"></p>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      @endif

      @if ($spVenue->eat_in_flag!=0)
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
                {{Form::radio('eat_in', 1, $value['eat_in']==1?true:false , ['id' => 'eat_in'])}}
                {{Form::label('eat_in',"あり")}}
              </td>
              <td>
                {{Form::radio('eat_in_prepare', 1, $value['eat_in']==1&&$value['eat_in_prepare']==1?true:false , ['id' => 'eat_in_prepare', $value['eat_in']!=1?"disabled":""])}}
                {{Form::label('eat_in_prepare',"手配済み")}}
                {{Form::radio('eat_in_prepare', 2, $value['eat_in']==1&&$value['eat_in_prepare']==2?true:false , ['id' => 'eat_in_consider',$value['eat_in']!=1?"disabled":""])}}
                {{Form::label('eat_in_consider',"検討中")}}
              </td>
            </tr>
            <tr>
              <td>
                {{Form::radio('eat_in', 0, $value['eat_in']==0?true:false , ['id' => 'no_eat_in'])}}
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
      <table class="table table-bordered name-table" style="table-layout:fixed;">
        <tbody>
          <tr>
            <td colspan="2">
              <div class="d-flex align-items-center justify-content-between">
                <p class="title-icon">
                  <i class="far fa-id-card icon-size" aria-hidden="true"></i>顧客情報
                </p>
                <p class="user_link">
                  <a class="more_btn" target="_blank" rel="noopener"
                    href="/admin/clients/{{(int)$value['user_id']}}">顧客詳細</a>
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
                <option value="{{$user->id}}" @if ((int)$value['user_id']==$user->id)
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
            <td class="table-active"><label for="name">担当者氏名<br></label></td>
            <td class="person">
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
            <td class="condition">
              {!! nl2br(e(ReservationHelper::getPersonCondition($value['user_id']))) !!}
            </td>
          </tr>
          <tr>
            <td class="table-active caution">注意事項</td>
            <td class="caution">
              <p class="attention">
                {!! nl2br(e(ReservationHelper::getPersonAttention($value['user_id']))) !!}
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
              {{ Form::text('in_charge', $value['in_charge'],['class'=>'form-control'] ) }}
              <p class="is-error-in_charge" style="color: red"></p>
            </td>
          </tr>
          <tr>
            <td class="table-active"><label for="mobilePhone" class=" form_required">携帯番号</label></td>
            <td>
              {{ Form::text('tel', $value['tel'],['class'=>'form-control'] ) }}
              <p class="is-error-tel" style="color: red"></p>
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
              {{-- {{ Form::text('', $value['email_flag']==1?"有り":"無し",['class'=>'form-control'] ) }}
              {{ Form::hidden('email_flag', $value['email_flag'],['class'=>'form-control'] ) }} --}}
              {{Form::radio('email_flag', 1, $value['email_flag']==1?true:false, ['class'=>'','id'=>'email_flag1'])}}
              {{Form::label("email_flag1","有り")}}
              {{Form::radio('email_flag', 0, $value['email_flag']==0?true:false, ['class'=>'','id'=>'email_flag2'])}}
              {{Form::label("email_flag2","無し")}}
            </td>
          </tr>
        </tbody>
      </table>

      @if (!empty($value['cost']))
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
                {{ Form::text('cost', $value['cost'],['class'=>'form-control'] ) }}
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
          <tr>
            <td>
              <!-- <label for="userNote">申し込みフォーム備考</label> -->
              {{ Form::hidden('user_details', $value['user_details'],['class'=>'form-control'] ) }}
            </td>
          </tr>
          <tr>
            <td>
              <label for="adminNote">管理者備考</label>
              {{ Form::textarea('admin_details', $value['admin_details'],['class'=>'form-control'] ) }}
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</section>

{{Form::submit('再計算する', ['class'=>'btn more_btn4_lg mx-auto my-5 d-block', 'id'=>'check_submit'])}}
{{Form::close()}}


{{ Form::open(['url' => 'admin/reservations/check_session', 'method'=>'POST', 'id'=>'reservations_calculate_form']) }}
@csrf
<section class="">
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
                <dd class="total_result">{{number_format($priceResult['masters'])}}円</dd>
              </dl>
            </td>
            <td>
              <dl class="ttl_box">
                <dt>支払い期日</dt>
                <dd class="pay_limit">{{ReservationHelper::formatDate($priceResult['pay_limit'])}}</dd>
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
          @if ($errors->any())
          <div class="alert alert-danger">
            <ul>
              @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
          @endif

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
            @if ($priceResult['price_details']!=0)
            <tbody class="venue_main">
              @if ($priceResult['price_details'][1])
              <tr>
                <td>{{ Form::text('venue_breakdown_item0', "会場料金",['class'=>'form-control', 'readonly'] ) }} </td>
                <td>
                  {{ Form::text('venue_breakdown_cost0', $priceResult['price_details'][0]-$priceResult['price_details'][1],['class'=>'form-control', 'readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('venue_breakdown_count0', 1,['class'=>'form-control', 'readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('venue_breakdown_subtotal0', $priceResult['price_details'][0]-$priceResult['price_details'][1],['class'=>'form-control', 'readonly'] ) }}
                </td>
              </tr>
              <tr>
                <td>{{ Form::text('venue_breakdown_item1', "延長料金",['class'=>'form-control', 'readonly'] ) }} </td>
                <td>
                  {{ Form::text('venue_breakdown_cost1', $priceResult['price_details'][1],['class'=>'form-control', 'readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('venue_breakdown_count1', 1,['class'=>'form-control', 'readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('venue_breakdown_subtotal1', $priceResult['price_details'][1],['class'=>'form-control', 'readonly'] ) }}
                </td>
              </tr>
              @else
              <tr>
                <td>{{ Form::text('venue_breakdown_item0', "会場料金",['class'=>'form-control', 'readonly'] ) }} </td>
                <td>
                  {{ Form::text('venue_breakdown_cost0', $priceResult['price_details'][0],['class'=>'form-control', 'readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('venue_breakdown_count0', 1,['class'=>'form-control', 'readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('venue_breakdown_subtotal0', $priceResult['price_details'][0],['class'=>'form-control', 'readonly'] ) }}
                </td>
              </tr>
              @endif
            </tbody>
            <tbody class="venue_result">
              <tr>
                <td colspan="3"></td>
                <td colspan="1">
                  <p class="text-left">合計</p>
                  {{ Form::text('venue_price', $priceResult['price_details'][0],['class'=>'form-control col-xs-3', 'readonly'] ) }}
                </td>
              </tr>
            </tbody>
            <tbody class="venue_discount">
              <tr>
                <td>割引計算欄</td>
                <td>
                  <p>
                    割引金額
                  </p>
                  <div class="d-flex align-items-end">
                    {{ Form::text('venue_number_discount', !empty($checkInfo['venue_number_discount'])?$checkInfo['venue_number_discount']:"",['class'=>'form-control'] ) }}
                    <p class="ml-1">円</p>
                  </div>
                  <p class="is-error-venue_number_discount" style="color: red"></p>
                </td>
                <td>
                  <p>
                    割引率
                  </p>
                  <div class="d-flex align-items-end">
                    {{ Form::text('venue_percent_discount', !empty($checkInfo['venue_percent_discount'])?$checkInfo['venue_percent_discount']:"",['class'=>'form-control'] ) }}
                    <p class="ml-1">%</p>
                  </div>
                  <p class="is-error-venue_percent_discount" style="color: red"></p>
                </td>
                <td>
                  <input class="btn more_btn venue_discount_btn" type="button" value="計算する">
                </td>
              </tr>
            </tbody>
            @else
            <span class="text-red">※料金体系がないため、手打ちで会場料を入力してください</span>
            <tbody class="venue_main">
              <tr>
                <td>
                  {{ Form::text('venue_breakdown_item0', '会場料金',['class'=>'form-control'] ) }}
                </td>
                <td>
                  {{ Form::text('venue_breakdown_cost0', 0,['class'=>'form-control'] ) }}
                </td>
                <td>
                  {{ Form::text('venue_breakdown_count0', 1,['class'=>'form-control'] ) }}
                </td>
                <td>
                  {{ Form::text('venue_breakdown_subtotal0', 0,['class'=>'form-control'] ) }}
                </td>
                <td>
                  <input type="button" value="＋" class="add pluralBtn">
                  <input type="button" value="ー" class="del pluralBtn">
                </td>
              </tr>
            </tbody>
            <tbody class="venue_result">
              <tr>
                <td colspan="4"></td>
                <td colspan="1">
                  <p class="text-left">合計</p>
                  {{ Form::text('venue_price', '',['class'=>'form-control col-xs-3', 'readonly'] ) }}
                  <p class="is-error-venue_price" style="color: red"></p>
                </td>
              </tr>
            </tbody>
            @endif
          </table>
        </div>

        @if(!empty($priceResult['item_details'])||$request->luggage_price)
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
              @foreach ($priceResult['item_details'][1] as $key=>$item)
              <tr>
                <td>
                  {{ Form::text('equipment_breakdown_item'.$key, $item[0],['class'=>'form-control', 'readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('equipment_breakdown_cost'.$key, $item[1],['class'=>'form-control', 'readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('equipment_breakdown_count'.$key, $item[2],['class'=>'form-control', 'readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('equipment_breakdown_subtotal'.$key, $item[1]*$item[2],['class'=>'form-control', 'readonly'] ) }}
                </td>
              </tr>
              @endforeach
              @foreach ($priceResult['item_details'][2] as $key=>$item)
              <tr>
                <td>
                  {{ Form::text('services_breakdown_item'.$key, $item[0],['class'=>'form-control', 'readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('services_breakdown_cost'.$key, $item[1],['class'=>'form-control', 'readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('services_breakdown_count'.$key, $item[2],['class'=>'form-control', 'readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('services_breakdown_subtotal'.$key, $item[1]*$item[2],['class'=>'form-control', 'readonly'] ) }}
                </td>
              </tr>
              @endforeach
              @if (!empty($value['luggage_price']))
              <tr>
                <td>
                  {{ Form::text('luggage_item', '荷物預かり',['class'=>'form-control', 'readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('luggage_cost', $value['luggage_price'],['class'=>'form-control', 'readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('luggage_count', 1,['class'=>'form-control', 'readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('luggage_subtotal', $value['luggage_price'],['class'=>'form-control', 'readonly'] ) }}
                </td>
              </tr>
              @endif
            </tbody>
            <tbody class="equipment_result">
              <tr>
                <td colspan="3"></td>
                <td colspan="1">
                  <p class="text-left">合計</p>
                  {{ Form::text('equipment_price', ($priceResult['item_details'][0]+(!empty($value["luggage_price"])?$value["luggage_price"]:0)),['class'=>'form-control', 'readonly'] ) }}
                </td>
              </tr>
            </tbody>
            <tbody class="equipment_discount">
              <tr>
                <td>割引計算欄</td>
                <td>
                  <p>
                    割引金額
                  </p>
                  <div class="d-flex align-items-end">
                    {{ Form::text('equipment_number_discount', !empty($checkInfo['equipment_number_discount'])?$checkInfo['equipment_number_discount']:"",['class'=>'form-control'] ) }}
                    <p class="ml-1">円</p>
                  </div>
                  <p class="is-error-equipment_number_discount" style="color: red"></p>
                </td>
                <td>
                  <p>
                    割引率
                  </p>
                  <div class="d-flex align-items-end">
                    {{ Form::text('equipment_percent_discount', !empty($checkInfo['equipment_percent_discount'])?$checkInfo['equipment_percent_discount']:"",['class'=>'form-control'] ) }}
                    <p class="ml-1">%</p>
                  </div>
                  <p class="is-error-equipment_percent_discount" style="color: red"></p>
                </td>
                <td>
                  <input class="btn more_btn equipment_discount_btn" type="button" value="計算する">
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        @endif

        @if ($priceResult['layouts_details'][0]||$priceResult['layouts_details'][1])
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
              @if ($priceResult['layouts_details'][0])
              <tr>
                <td>{{ Form::text('layout_prepare_item', "レイアウト準備料金",['class'=>'form-control', 'readonly'] ) }}</td>
                <td>
                  {{ Form::text('layout_prepare_cost', $priceResult['layouts_details'][0],['class'=>'form-control', 'readonly'] )}}
                </td>
                <td>{{ Form::text('layout_prepare_count', 1,['class'=>'form-control', 'readonly'] )}}</td>
                <td>
                  {{ Form::text('layout_prepare_subtotal', $priceResult['layouts_details'][0],['class'=>'form-control', 'readonly'] )}}
                </td>
              </tr>
              @endif
              @if ($priceResult['layouts_details'][1])
              <tr>
                <td>{{ Form::text('layout_clean_item', "レイアウト片付料金",['class'=>'form-control', 'readonly'] ) }}</td>
                <td>
                  {{ Form::text('layout_clean_cost', $priceResult['layouts_details'][1],['class'=>'form-control', 'readonly'] )}}
                </td>
                <td>{{ Form::text('layout_clean_count', 1,['class'=>'form-control', 'readonly'] )}}</td>
                <td>
                  {{ Form::text('layout_clean_subtotal', $priceResult['layouts_details'][1],['class'=>'form-control', 'readonly'] )}}
                </td>
              </tr>
              @endif
            </tbody>
            <tbody class="layout_result">
              <tr>
                <td colspan="3"></td>
                <td colspan="1">
                  <p class="text-left">合計</p>
                  {{ Form::text('layout_price',$priceResult['layouts_details'][2] ,['class'=>'form-control', 'readonly'] ) }}
                </td>
              </tr>
            </tbody>
            <tbody class="layout_discount">
              <tr>
                <td>割引計算欄</td>
                <td>
                  <p>
                    割引金額
                  </p>
                  <div class="d-flex align-items-end">
                    {{ Form::text('layout_number_discount', !empty($checkInfo['layout_number_discount'])?$checkInfo['layout_number_discount']:"",['class'=>'form-control'] ) }}
                    <p class="ml-1">円</p>
                  </div>
                  <p class="is-error-layout_number_discount" style="color: red"></p>
                </td>
                <td>
                  <p>
                    割引率
                  </p>
                  <div class="d-flex align-items-end">
                    {{ Form::text('layout_percent_discount', !empty($checkInfo['layout_percent_discount'])?$checkInfo['layout_percent_discount']:"",['class'=>'form-control'] ) }}
                    <p class="ml-1">%</p>
                  </div>
                  <p class="is-error-layout_percent_discount" style="color: red"></p>
                </td>
                <td>
                  <input class="btn more_btn layout_discount_btn" type="button" value="計算する">
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        @endif
        <div class="others billdetails_content">
          <table class="table table-borderless">
            <tbody>
              <tr>
                <td colspan="5">
                  <h4 class="billdetails_content_ttl">
                    その他
                  </h4>
                </td>
              </tr>
            </tbody>
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
              <tr>
                <td>{{ Form::text('others_breakdown_item0', '',['class'=>'form-control'] ) }}</td>
                <td>{{ Form::text('others_breakdown_cost0', '',['class'=>'form-control'] ) }}</td>
                <td>{{ Form::text('others_breakdown_count0', '',['class'=>'form-control'] ) }}</td>
                <td>{{ Form::text('others_breakdown_subtotal0', '',['class'=>'form-control', 'readonly'] ) }}</td>
                <td class="text-left">
                  <input type="button" value="＋" class="add pluralBtn bg-blue">
                  <input type="button" value="ー" class="del pluralBtn bg-red">
                </td>
              </tr>
            </tbody>
            <tbody class="others_result">
              <tr>
                <td colspan="4"></td>
                <td colspan="1">
                  <p class="text-left">合計</p>
                  {{ Form::text('others_price', '',['class'=>'form-control', 'readonly'] ) }}
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <div class="bill_total">
          <table class="table">
            <tbody>
              <tr>
                <td>小計：</td>
                <td>
                  {{ Form::text('master_subtotal',$priceResult['masters'] ,['class'=>'form-control text-right', 'readonly'] ) }}
                </td>
              </tr>
              <tr>
                <td>消費税：</td>
                <td>
                  {{ Form::text('master_tax',ReservationHelper::getTax($priceResult['masters']) ,['class'=>'form-control text-right', 'readonly'] ) }}
                </td>
              </tr>
              <tr>
                <td class="font-weight-bold">合計金額</td>
                <td>
                  {{ Form::text('master_total',ReservationHelper::taxAndPrice($priceResult['masters']) ,['class'=>'form-control text-right', 'readonly'] ) }}
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <!-- 請求内訳 終わり ------------------------------------------------------>
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
                {{ Form::text('bill_created_at', date('Y-m-d'),['class'=>'form-control', 'id'=>'datepicker6'] ) }}
              </td>
              <td>支払期日
                {{ Form::text('pay_limit', $priceResult['pay_limit'],['class'=>'form-control datepicker', 'id'=>''] ) }}
              </td>
            </tr>
            <tr>
              <td>請求書宛名
                {{ Form::text('pay_company', $users->find($value['user_id'])->company,['class'=>'form-control'] ) }}
              </td>
              <td>
                担当者
                {{ Form::text('bill_person', ReservationHelper::getPersonName($value['user_id']),['class'=>'form-control'] ) }}
              </td>
            </tr>
            <tr>
              <td colspan="2">請求書備考{{ Form::textarea('bill_remark', '',['class'=>'form-control'] ) }}</td>
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
              <td>入金状況{{Form::select('paid', ['未入金', '入金済み','遅延','入金不足','入金過多','次回繰越'],null,['class'=>'form-control'])}}
              </td>
              <td>
                入金日{{ Form::text('pay_day', null,['class'=>'form-control', 'id'=>'datepicker7'] ) }}
              </td>
            </tr>
            <tr>
              <td>振込人名{{ Form::text('pay_person', null,['class'=>'form-control'] ) }}
                <p class="is-error-pay_person" style="color: red"></p>
              </td>
              <td>入金額{{ Form::text('payment', null,['class'=>'form-control'] ) }}
                <p class="is-error-payment" style="color: red"></p>
              </td>
            </tr>
          </table>
        </div>
      </div>
    </div>
  </div>
</section>

{{Form::submit('確認する', ['class'=>'btn d-block more_btn_lg mx-auto my-5', 'id'=>'check_submit'])}}
{{Form::close()}}

<script>
  function checkForm($this) {
          var str = $this.value;
          while (str.match(/[^A-Z^a-z\d\-]/)) {
            str = str.replace(/[^A-Z^a-z\d\-]/, "");
          }
          $this.value = str;
        }

  $(document).on(' click', '.holidays', function () {
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

  $(document).on("change", '#user_select', function () {
    var user_id=$('#user_select').val();
    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      url: '/admin/clients/getclients',
      type: 'POST',
      data: {
        'user_id': user_id
      },
      dataType: 'json',
      beforeSend: function () {
        $('#fullOverlay').css('display', 'block');
      },
    })
      .done(function ($user_results) {
        $('#fullOverlay').css('display', 'none');
        $('.person').text('').text($user_results[0]);
        $('.email').text('').text($user_results[1]);
        $('.mobile').text('').text($user_results[2]);
        $('.tel').text('').text($user_results[3]);
        $user_results[4]?$('.condition').html('').html($user_results[4].replace(/\n/g, "<br>")):"";
        $user_results[5]?$('.attention').html('').html($user_results[5].replace(/\n/g, "<br>")):"";
        $('.user_link').html('');
        $('.user_link').append("<a class='more_btn' target='_blank' rel='noopener' href='/admin/clients/" + $user_results[6] + "'>顧客詳細</a>")
      })
      .fail(function ($user_results) {
        $('#fullOverlay').css('display', 'none');
        console.log('ajaxGetClients 失敗', $user_results)
      });
  });

  $(function(){
    var $maxDate =$('#datepicker1').val(); 
    $('#datepicker3').datepicker({
       dateFormat: 'yy-mm-dd', 
       minDate: 0, 
       maxDate: $maxDate
       });
    })
  $(function() {

    $(function() {
      // プラスボタンクリック
      $(document).on("click", ".add", function() {
        $(this).parent().parent().clone(true).insertAfter($(this).parent().parent());
        addThisTr('.others .others_main tr', 'others_breakdown_item', 'others_breakdown_cost', 'others_breakdown_count', 'others_breakdown_subtotal');
        addThisTr('.venue_main tr', 'venue_breakdown_item', 'venue_breakdown_cost', 'venue_breakdown_count', 'venue_breakdown_subtotal');
        // 追加時内容クリア
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

      // マイナスボタンクリック
      $(document).on("click", ".del", function() {
        if ($(this).parent().parent().parent().attr('class') == "others_main") {
          var count = $('.others .others_main tr').length;
          var target = $(this).parent().parent();
          if (target.parent().children().length > 1) {
            target.remove();
          }
          for (let index = 0; index < count; index++) {
            // console.log(index);
            $('.others_main tr').eq(index).find('td').eq(0).find('input').attr('name', 'others_breakdown_item' + index);
            $('.others_main tr').eq(index).find('td').eq(1).find('input').attr('name', 'others_breakdown_cost' + index);
            $('.others_main tr').eq(index).find('td').eq(2).find('input').attr('name', 'others_breakdown_count' + index);
            $('.others_main tr').eq(index).find('td').eq(3).find('input').attr('name', 'others_breakdown_subtotal' + index);
          }
          var re_count = $('.others .others_main tr').length;
          var total_val = 0;
          for (let index2 = 0; index2 < re_count; index2++) {
            var num1 = $('input[name="others_breakdown_cost' + index2 + '"]').val();
            var num2 = $('input[name="others_breakdown_count' + index2 + '"]').val();
            var num3 = $('input[name="others_breakdown_subtotal' + index2 + '"]');
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
          // $('.total_result').text('').text(result);
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
          // $('.total_result').text('').text(result);
          $('input[name="master_subtotal"]').val(result);
          $('input[name="master_tax"]').val(result_tax);
          $('input[name="master_total"]').val(result + result_tax);
        }
      });
    });
  })

  $(window).on('load', function() {
    $('.venue_discount_btn').click();
    $('.equipment_discount_btn').click();
    $('.equipment_discount_btn').click();
    $('.layout_discount_btn').click();
  });
</script>

@endsection