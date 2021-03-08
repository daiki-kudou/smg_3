@extends('layouts.admin.app')
@section('content')


<link href="{{ asset('/css/template.css') }}" rel="stylesheet">
<script src="{{ asset('/js/template.js') }}"></script>

<div class="container-field">
  <div class="float-right">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active">
          ダミーテキスト
        </li>
      </ol>
    </nav>
  </div>
  <h2 class="mt-3 mb-3">仮押さえ　編集</h2>
  <hr>
</div>

{{ Form::open(['url' => 'admin/pre_reservations/'.$request->id.'/re_calculate', 'method'=>'POST', 'id'=>'']) }}
@csrf
<section class="section-wrap">
  <div class="selected_user">
    <table class="table table-bordered" style="table-layout: fixed;">
      <thead>
        <tr>
          <th>顧客情報</th>
          <th colspan="3">顧客ID：<p class="user_id d-inline">{{$request->user_id}}</p>
          </th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td class="table-active">会社名・団体名</td>
          <td colspan="3">
            <p class="company">{{$request->user_id==999?"":ReservationHelper::getCompany($request->user_id)}}</p>
          </td>
        </tr>
        <tr>
          <td class="table-active">担当者氏名</td>
          <td>
            <p class="person">{{$request->user_id==999?"":ReservationHelper::getPersonName($request->user_id)}}</p>
          </td>
          <td class="table-active">メールアドレス</td>
          <td>
            <p class="email">{{$request->user_id==999?"":ReservationHelper::getPersonEmail($request->user_id)}}</p>

          </td>
        </tr>
        <tr>
          <td class="table-active">携帯番号</td>
          <td>
            <p class="mobile">{{$request->user_id==999?"":ReservationHelper::getPersonMobile($request->user_id)}}</p>

          </td>
          <td class="table-active">固定電話</td>
          <td>
            <p class="tel">{{$request->user_id==999?"":ReservationHelper::getPersonTel($request->user_id)}}</p>
          </td>
        </tr>
      </tbody>
    </table>
  </div>

  <div class="unknown_user mt-5">
    <table class="table table-bordered" style="table-layout: fixed;">
      <thead>
        <tr>
          <th colspan="4">顧客情報（顧客登録がされていない場合）</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td class="table-active">会社名・団体名</td>
          <td colspan="3">
            {{ Form::text('unknown_user_company', empty($request->unknown_user->unknown_user_company)?'':$request->unknown_user->unknown_user_company,['class'=>'form-control', ''] ) }}
          </td>
        </tr>
        <tr>
          <td class="table-active">担当者氏名</td>
          <td>
            {{ Form::text('unknown_user_name', empty($request->unknown_user->unknown_user_name)?"":$request->unknown_user->unknown_user_name,['class'=>'form-control', ''] ) }}
          </td>
          <td class="table-active">メールアドレス</td>
          <td>
            {{ Form::text('unknown_user_email', empty($request->unknown_user->unknown_user_email)?"":$request->unknown_user->unknown_user_email,['class'=>'form-control', ''] ) }}
          </td>
        </tr>
        <tr>
          <td class="table-active">携帯番号</td>
          <td>
            {{ Form::text('unknown_user_mobile', empty($request->unknown_user->unknown_user_mobile)?"":$request->unknown_user->unknown_user_mobile,['class'=>'form-control', ''] ) }}
          </td>
          <td class="table-active">固定電話</td>
          <td>
            {{ Form::text('unknown_user_tel', empty($request->unknown_user->unknown_user_tel)?"":$request->unknown_user->unknown_user_tel,['class'=>'form-control', ''] ) }}
          </td>
        </tr>
      </tbody>
    </table>
  </div>


  {{-- 以下、詳細入力 --}}
  <div class="container-field bg-white text-dark mt-5 mb-5">
    <div class="row">
      <div class="col">
        <table class="table table-bordered">
          <tbody>
            <tr>
              <td colspan="2">
                <p class="title-icon">
                  <i class="fas fa-info-circle icon-size" aria-hidden="true"></i>
                  仮押さえ情報
                </p>
              </td>
            </tr>
            <tr>
              <td class="table-active form_required">利用日</td>
              <td>
                {{ Form::text('reserve_date', date('Y-m-d',strtotime($request->reserve_date)),['class'=>'form-control', 'readonly'] ) }}
              </td>
            </tr>
            <tr>
              <td class="table-active form_required">会場</td>
              <td>
                {{ Form::text('', ReservationHelper::getVenue($request->venue_id),['class'=>'form-control', 'readonly'] ) }}
                {{ Form::hidden('venue_id', $request->venue_id,['class'=>'form-control'] ) }}
                <div class="price_selector">
                  <div>
                    <small>料金体系</small>
                  </div>
                  <div class="form-check form-check-inline">
                    {{Form::radio('price_system', 1, $request->price_system==1?true:false , ['id' => 'price_system_radio1', 'class' => 'form-check-input'])}}
                    <label for="{{'price_system_radio1'}}" class="form-check-label">時間貸し</label>
                    {{Form::radio('price_system', 2, $request->price_system==2?true:false, ['id' => 'price_system_radio2', 'class' => 'form-check-input'])}}
                    <label for="{{'price_system_radio2'}}" class="form-check-label">アクセア仕様</label>
                  </div>
                </div>
              </td>
            </tr>
            <tr>
              <td class="table-active form_required">入室時間</td>
              <td>
                <select name="enter_time" id="enter_time" class="form-control">
                  <option value=""></option>
                  @for ($start = 0*2; $start <=23*2; $start++) <option value="{{date("H:i:s", strtotime("00:00 +". $start * 30 ." minute"))}}" @if (date("H:i:s", strtotime("00:00 +". $start * 30 ." minute"))==$request->enter_time)
                    selected
                    @endif
                    >
                    {{date("H時i分", strtotime("00:00 +". $start * 30 ." minute"))}}
                    </option>
                    @endfor
                </select>
              </td>
            </tr>
            <tr>
              <td class="table-active form_required">退室時間</td>
              <td>
                <select name="leave_time" id="leave_time" class="form-control">
                  <option value=""></option>
                  @for ($start = 0*2; $start <=23*2; $start++) <option value="{{date("H:i:s", strtotime("00:00 +". $start * 30 ." minute"))}}" @if (date("H:i:s", strtotime("00:00 +". $start * 30 ." minute"))==$request->leave_time)
                    selected
                    @endif
                    >
                    {{date("H時i分", strtotime("00:00 +". $start * 30 ." minute"))}}
                    </option>
                    @endfor
                </select>
              </td>
            </tr>
          </tbody>
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
                  {{Form::radio('board_flag', 1, $request->board_flag==1?true:false , ['id' => 'board_flag'.'on'])}}
                  <label for="{{'board_flag'.'on'}}" class="form-check-label"><span>有り</span></label>
                </p>
                <p>
                  {{Form::radio('board_flag', 0, $request->board_flag==0?true:false, ['id' => 'board_flag'.'off'])}}
                  <label for="{{'board_flag'.'off'}}" class="form-check-label"><span>無し</span></label>
                </p>
              </div>
            </td>
          </tr>
          <tr>
            <td class="table-active">イベント開始時間</td>
            <td>
              <select name="event_start" id="event_start" class="form-control">
                <option value=""></option>
                @for ($start = 0*2; $start <=23*2; $start++) <option value="{{date("H:i:s", strtotime("00:00 +". $start * 30 ." minute"))}}" @if (date("H:i:s", strtotime("00:00 +". $start * 30 ." minute"))==$request->event_start)
                  selected
                  @endif
                  >
                  {{date("H時i分", strtotime("00:00 +". $start * 30 ." minute"))}}
                  </option>
                  @endfor
              </select>
            </td>
          </tr>
          <tr>
            <td class="table-active">イベント終了時間</td>
            <td>
              <select name="event_finish" id="event_finish" class="form-control">
                <option value=""></option>
                @for ($start = 0*2; $start <=23*2; $start++) <option value="{{date("H:i:s", strtotime("00:00 +". $start * 30 ." minute"))}}" @if (date("H:i:s", strtotime("00:00 +". $start * 30 ." minute"))==$request->event_finish)
                  selected
                  @endif
                  >
                  {{date("H時i分", strtotime("00:00 +". $start * 30 ." minute"))}}
                  </option>
                  @endfor
              </select>
            </td>
          </tr>
          <tr>
            <td class="table-active">イベント名称1</td>
            <td>
              {{ Form::text('event_name1', $request->event_name1,['class'=>'form-control', ''] ) }}
            </td>
          </tr>
          <tr>
            <td class="table-active">イベント名称2</td>
            <td>
              {{ Form::text('event_name2', $request->event_name2,['class'=>'form-control', ''] ) }}
            </td>
          </tr>
          <tr>
            <td class="table-active">主催者名</td>
            <td>
              {{ Form::text('event_owner', $request->event_owner,['class'=>'form-control', ''] ) }}
            </td>
          </tr>
        </table>

        <div class="equipemnts">
          <table class="table table-bordered" style="table-layout: fixed;">
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
              @foreach ($equipments as $key=>$equipment)
              <tr>
                <td class="table-active">
                  {{$equipment->item}}
                </td>
                <td>
                  @foreach ($s_equipment as $e)
                  @if ($e->unit_item==$equipment->item)
                  {{ Form::text('equipment_breakdown'.$key,$e->unit_count,['class'=>'form-control'] ) }}
                  @break
                  @elseif ($loop->last)
                  {{ Form::text('equipment_breakdown'.$key,'',['class'=>'form-control'] ) }}
                  @endif
                  @endforeach
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
              @foreach ($services as $key=>$service)
              <tr>
                <td class="table-active">
                  {{$service->item}}
                </td>
                <td>
                  @foreach ($s_services as $s)
                  @if ($service->item==$s->unit_item)
                  <div class="form-check form-check-inline">
                    {{Form::radio('services_breakdown'.$key, 1, true, ['id' => 'service'.$key.'on', 'class' => 'form-check-input'])}}
                    <label for="{{'service'.$key.'on'}}" class="form-check-label">有り</label>
                    {{Form::radio('services_breakdown'.$key, 0, false, ['id' => 'services_breakdown'.$key.'off', 'class' => 'form-check-input'])}}
                    <label for="{{'services_breakdown'.$key.'off'}}" class="form-check-label">無し</label>
                  </div>
                  @break
                  @elseif ($loop->last)
                  <div class="form-check form-check-inline">
                    {{Form::radio('services_breakdown'.$key, 1, false, ['id' => 'service'.$key.'on', 'class' => 'form-check-input'])}}
                    <label for="{{'service'.$key.'on'}}" class="form-check-label">有り</label>
                    {{Form::radio('services_breakdown'.$key, 0, true, ['id' => 'services_breakdown'.$key.'off', 'class' => 'form-check-input'])}}
                    <label for="{{'services_breakdown'.$key.'off'}}" class="form-check-label">無し</label>
                  </div>
                  @endif
                  @endforeach
                </td>
              </tr>
              @endforeach

            </tbody>
          </table>
        </div>
        <div class="layouts">
          <table class="table table-bordered">
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
                <td class="table-active">準備</td>
                <td>
                  @foreach ($s_layouts as $l)
                  @if ($l->unit_item=="レイアウト準備料金")
                  <div class="form-check form-check-inline">
                    {{Form::radio('layout_prepare', 1, true , ['id' => 'layout_prepare', 'class' => 'form-check-input'])}}
                    <label for="{{'layout_prepare'}}" class="form-check-label">有り</label>
                    {{Form::radio('layout_prepare', 0, false, ['id' => 'no_layout_prepare', 'class' => 'form-check-input'])}}
                    <label for="{{'no_layout_prepare'}}" class="form-check-label">無し</label>
                  </div>
                  @break
                  @elseif($loop->last)
                  <div class="form-check form-check-inline">
                    {{Form::radio('layout_prepare', 1, false , ['id' => 'layout_prepare', 'class' => 'form-check-input'])}}
                    <label for="{{'layout_prepare'}}" class="form-check-label">有り</label>
                    {{Form::radio('layout_prepare', 0, true, ['id' => 'no_layout_prepare', 'class' => 'form-check-input'])}}
                    <label for="{{'no_layout_prepare'}}" class="form-check-label">無し</label>
                  </div>
                  @endif
                  @endforeach
                </td>
              </tr>
              <tr>
                <td class="table-active">片付</td>
                <td>
                  @foreach ($s_layouts as $l)
                  @if ($l->unit_item=="レイアウト片付料金")
                  <div class="form-check form-check-inline">
                    {{Form::radio('layout_clean', 1, true, ['id' => 'layout_clean', 'class' => 'form-check-input'])}}
                    <label for='layout_clean' class="form-check-label">有り</label>
                    {{Form::radio('layout_clean', 0, false, ['id' => 'no_layout_clean', 'class' => 'form-check-input'])}}
                    <label for='no_layout_clean' class="form-check-label">無し</label>
                  </div>
                  @break
                  @elseif($loop->last)
                  <div class="form-check form-check-inline">
                    {{Form::radio('layout_clean', 1, false, ['id' => 'layout_clean', 'class' => 'form-check-input'])}}
                    <label for='layout_clean' class="form-check-label">有り</label>
                    {{Form::radio('layout_clean', 0, true, ['id' => 'no_layout_clean', 'class' => 'form-check-input'])}}
                    <label for='no_layout_clean' class="form-check-label">無し</label>
                  </div>
                  @endif
                  @endforeach

                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="luggage">
          <table class="table table-bordered">
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
                <td class="table-active">事前に預かる荷物<br>（個数）</td>
                <td>
                  {{ Form::text('luggage_count', $request->luggage_count,['class'=>'form-control'] ) }}
                </td>
              </tr>
              <tr>
                <td class="table-active">事前荷物の到着日<br>午前指定のみ</td>
                <td>
                  {{ Form::text('luggage_arrive', date('Y-m-d',strtotime($request->luggage_arrive)),['class'=>'form-control'] ) }}
                </td>
              </tr>
              <tr>
                <td class="table-active">事後返送する荷物</td>
                <td>
                  {{ Form::text('luggage_return', $request->luggage_return,['class'=>'form-control'] ) }}
                </td>
              </tr>
              <tr>
                <td class="table-active">荷物預かり/返送<br>料金</td>
                <td>
                  {{ Form::text('luggage_price', empty($request->pre_breakdowns()->where('unit_item','荷物預かり/返送')->first()->unit_cost)?"":$request->pre_breakdowns()->where('unit_item','荷物預かり/返送')->first()->unit_cost,['class'=>'form-control'] ) }}
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <div class="col">
        <table class="table table-bordered">
          <tbody>
            <tr>
              <td colspan="2">
                <p class="title-icon">
                  <i class="fas fa-user-check icon-size" aria-hidden="true"></i>
                  当日の連絡できる担当者
                </p>
              </td>
            </tr>
            <tr>
              <td class="table-active">
                <label for="ondayName" class=" form_required">氏名</label>
              </td>
              <td>
                {{ Form::text('in_charge', $request->in_charge,['class'=>'form-control'] ) }}
                <p class="is-error-in_charge" style="color: red"></p>
              </td>
            </tr>
            <tr>
              <td class="table-active"><label for="mobilePhone" class=" form_required">携帯番号</label></td>
              <td>
                {{ Form::text('tel', $request->tel,['class'=>'form-control'] ) }}
                <p class="is-error-tel" style="color: red"></p>
              </td>
            </tr>
          </tbody>
        </table>

        <table class="table table-bordered mail-table">
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
                @if ($request->email_flag!=0)
                <div class="radio-box">
                  <p>
                    {{Form::radio('email_flag', 1, true , ['id' => 'email_flag'])}}
                    <label for="{{'email_flag'}}" class="form-check-label"><span>有り</span></label>
                  </p>
                  <p>
                    {{Form::radio('email_flag', 0, false, ['id' => 'no_email_flag'])}}
                    <label for="{{'no_email_flag'}}" class="form-check-label"><span>無し</span></label>
                  </p>
                </div>
                @else
                <div class="radio-box">
                  <p>
                    {{Form::radio('email_flag', 1, false , ['id' => 'email_flag', 'class' => 'form-check-input'])}}
                    <label for="{{'email_flag'}}" class="form-check-label"><span>有り</span></label>
                  </p>
                  <p>
                    {{Form::radio('email_flag', 0, true, ['id' => 'no_email_flag', 'class' => 'form-check-input'])}}
                    <label for="{{'no_email_flag'}}" class="form-check-label"><span>無し</span></label>
                  </p>
                </div>
                @endif
              </td>
            </tr>
          </tbody>
        </table>
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
                {{ Form::textarea('user_details', $request->user_details,['class'=>'form-control', 'placeholder'=>'入力してください'] ) }}
              </td>
            </tr> -->
            <tr>
              <td>
                <label for="adminNote">管理者備考</label>
                {{ Form::textarea('admin_details', $request->admin_details,['class'=>'form-control', 'placeholder'=>'入力してください'] ) }}
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <div class="submit_btn">
    <div class="d-flex justify-content-center">
      {{-- 単発仮押さえか？一括仮押さえか？ --}}
      {{ Form::hidden('judge_count', 1 ) }}
      {{-- ユーザー --}}
      {{ Form::hidden('user_id', $request->user_id ) }}
      {{ Form::hidden('id', $request->id ) }}
      {{Form::submit('再計算する', ['class'=>'btn more_btn4_lg mx-auto d-block my-5', 'id'=>'check_submit'])}}
    </div>
  </div>

  <div class="spin_btn hide">
    <div class="d-flex justify-content-center">
      <button class="btn btn-primary btn-lg" type="button" disabled>
        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
        Loading...
      </button>
    </div>
  </div>

  {{Form::close()}}

  {{ Form::open(['url' => 'admin/pre_reservations/'.$request->id, 'method'=>'PUT']) }}
  @csrf
  {{-- 以下、計算結果 --}}
  <div class="container-fluid">
    <div class="bill">
      <div class="bill_head">
        <table class="table" style="table-layout: fixed">
          <tr>
            <td>
              <h2 class="text-white">
                請求書No
              </h2>
            </td>
            <td>
              <dl class="ttl_box">
                <dt>合計金額</dt>
                <dd class="total_result">{{number_format($request->pre_bill->first()->master_total)}}円</dd>
              </dl>
            </td>
          </tr>
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
                  <td>単価</td>
                  <td>数量</td>
                  <td>金額</td>
                </tr>
              </tbody>
              <tbody class="venue_main">
                @foreach ($s_venues as $key=>$v)
                <tr>
                  <td>
                    {{ Form::text('venue_breakdown_item'.$key, $v->unit_item,['class'=>'form-control col-xs-3', 'readonly'] ) }}
                  </td>
                  <td>
                    {{ Form::text('venue_breakdown_cost'.$key, $v->unit_cost,['class'=>'form-control col-xs-3', 'readonly'] ) }}
                  </td>
                  <td>
                    {{ Form::text('venue_breakdown_count'.$key, $v->unit_count,['class'=>'form-control col-xs-3', 'readonly'] ) }}
                  </td>
                  <td>
                    {{ Form::text('venue_breakdown_subtotal'.$key, $v->unit_subtotal,['class'=>'form-control col-xs-3', 'readonly'] ) }}
                  </td>
                </tr>
                @endforeach
              </tbody>
              <tbody class="venue_result">
                <tr>
                  <td colspan="2"></td>
                  <td colspan="2">合計
                    {{ Form::text('venue_price', $request->pre_bill()->first()->venue_price,['class'=>'form-control col-xs-3', 'readonly'] ) }}
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
                    <div class="d-flex">
                      {{ Form::text('venue_number_discount', $request->venue_number_discount?$request->venue_number_discount:'',['class'=>'form-control'] ) }}
                      <p>円</p>
                    </div>
                  </td>
                  <td>
                    <p>
                      割引率
                    </p>
                    <div class="d-flex">
                      {{ Form::text('venue_percent_discount', $request->venue_percent_discount?$request->venue_percent_discount:'',['class'=>'form-control'] ) }}
                      <p>%</p>
                    </div>
                  </td>
                  <td>
                    <input class="btn more_btn venue_discount_btn" type="button" value="計算する">
                  </td>
                </tr>
              </tbody>
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
                @foreach ($s_equipment as $key=>$equ)
                <tr>
                  <td>
                    {{ Form::text('equipment_breakdown_item'.$key, $equ->unit_item,['class'=>'form-control', 'readonly'] ) }}
                  </td>
                  <td>
                    {{ Form::text('equipment_breakdown_cost'.$key, $equ->unit_cost,['class'=>'form-control', 'readonly'] ) }}
                  </td>
                  <td>
                    {{ Form::text('equipment_breakdown_count'.$key, $equ->unit_count,['class'=>'form-control', 'readonly'] ) }}
                  </td>
                  <td>
                    {{ Form::text('equipment_breakdown_subtotal'.$key, $equ->unit_subtotal,['class'=>'form-control', 'readonly'] ) }}
                  </td>
                </tr>
                @endforeach
                @foreach ($s_services as $key=>$ser)
                <tr>
                  <td>
                    {{ Form::text('services_breakdown_item'.$key, $ser->unit_item,['class'=>'form-control', 'readonly'] ) }}
                  </td>
                  <td>
                    {{ Form::text('services_breakdown_cost'.$key, $ser->unit_cost,['class'=>'form-control', 'readonly'] ) }}
                  </td>
                  <td>
                    {{ Form::text('services_breakdown_count'.$key, $ser->unit_count,['class'=>'form-control', 'readonly'] ) }}
                  </td>
                  <td>
                    {{ Form::text('services_breakdown_subtotal'.$key, $ser->unit_subtotal,['class'=>'form-control', 'readonly'] ) }}
                  </td>
                </tr>
                @endforeach
              </tbody>
              <tbody class="equipment_result">
                <tr>
                  <td colspan="2"></td>
                  <td colspan="2">合計
                    {{ Form::text('equipment_price',$request->pre_bill()->first()->equipment_price  ,['class'=>'form-control', 'readonly'] ) }}
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
                    <div class="d-flex">
                      {{ Form::text('equipment_number_discount', $request->equipment_number_discount?$request->equipment_number_discount:'',['class'=>'form-control'] ) }}
                      <p>円</p>
                    </div>
                  </td>
                  <td>
                    <p>
                      割引率
                    </p>
                    <div class="d-flex">
                      {{ Form::text('equipment_percent_discount', $request->equipment_percent_discount?$request->equipment_percent_discount:'',['class'=>'form-control'] ) }}
                      <p>%</p>
                    </div>
                  </td>
                  <td>
                    <input class="btn more_btn equipment_discount_btn" type="button" value="計算する">
                  </td>
                </tr>
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
                @foreach ($s_layouts as $key=>$lay)
                <tr>
                  <td>
                    {{ Form::text('layout_breakdown_item'.$key, $lay->unit_item,['class'=>'form-control', 'readonly'] )}}
                  </td>
                  <td>
                    {{ Form::text('layout_breakdown_cost'.$key, $lay->unit_cost,['class'=>'form-control', 'readonly'] )}}
                  </td>
                  <td>
                    {{ Form::text('layout_breakdown_count'.$key, $lay->unit_count,['class'=>'form-control', 'readonly'] )}}
                  </td>
                  <td>
                    {{ Form::text('layout_breakdown_subtotal'.$key, $lay->unit_subtotal,['class'=>'form-control', 'readonly'] )}}
                  </td>
                </tr>
                @endforeach
              </tbody>
              <tbody class="layout_result">
                <tr>
                  <td colspan="2"></td>
                  <td colspan="2">合計
                    {{ Form::text('layout_price',$request->pre_bill()->first()->layout_price ,['class'=>'form-control', 'readonly'] ) }}
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
                    <div class="d-flex">
                      {{ Form::text('layout_number_discount', $request->layout_number_discount?$request->layout_number_discount:'',['class'=>'form-control'] ) }}
                      <p>円</p>
                    </div>
                  </td>
                  <td>
                    <p>
                      割引率
                    </p>
                    <div class="d-flex">
                      {{ Form::text('layout_percent_discount', $request->layout_percent_discount?$request->layout_percent_discount:'',['class'=>'form-control'] ) }}
                      <p>%</p>
                    </div>
                  </td>
                  <td>
                    <input class="btn more_btn layout_discount_btn" type="button" value="計算する">
                  </td>
                </tr>
              </tbody>
            </table>
          </div>

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
                @foreach ($s_others as $key=>$oth)
                <tr>
                  <td>{{ Form::text('others_input_item'.$key, $oth->unit_item,['class'=>'form-control', 'readonly'] )}}
                  </td>
                  <td>{{ Form::text('others_input_cost'.$key, $oth->unit_cost,['class'=>'form-control', 'readonly'] )}}
                  </td>
                  <td>{{ Form::text('others_input_count'.$key, $oth->unit_count,['class'=>'form-control', 'readonly'] )}}
                  </td>
                  <td>
                    {{ Form::text('others_input_subtotal'.$key, $oth->unit_subtotal,['class'=>'form-control', 'readonly'] )}}
                  </td>
                </tr>
                @endforeach
              </tbody>
              <tbody class="others_result">
                <tr>
                  <td colspan="2"></td>
                  <td colspan="3">合計
                    {{ Form::text('others_price', $request->pre_bill()->first()->others_price,['class'=>'form-control', 'readonly'] ) }}
                  </td>
                </tr>
              </tbody>
            </table>
          </div>

          <div class="bill_total">
            <table class="table text-right">
              <tr>
                <td>小計：</td>
                <td>
                  {{ Form::text('master_subtotal',$request->pre_bill()->first()->master_subtotal ,['class'=>'form-control text-right', 'readonly'] ) }}
                </td>
              </tr>
              <tr>
                <td>消費税：</td>
                <td>
                  {{ Form::text('master_tax',$request->pre_bill()->first()->master_tax ,['class'=>'form-control text-right', 'readonly'] ) }}
                </td>
              </tr>
              <tr>
                <td class="font-weight-bold">合計金額</td>
                <td>
                  {{ Form::text('master_total',$request->pre_bill()->first()->master_total ,['class'=>'form-control text-right', 'readonly'] ) }}
                </td>
              </tr>
            </table>
          </div>
        </div>
      </div>
    </div>

  </div>

  {{-- 単発仮押さえか？一括仮押さえか？ --}}
  {{ Form::hidden('judge_count', 1 ) }}
  {{Form::hidden('user_id', $request->user_id)}}
  {{Form::hidden('venue_id', $request->venue_id)}}
  {{Form::hidden('reserve_date', $request->reserve_date)}}
  {{Form::hidden('price_system', $request->price_system)}}
  {{Form::hidden('enter_time', $request->enter_time)}}
  {{Form::hidden('leave_time', $request->leave_time)}}
  {{Form::hidden('board_flag', $request->board_flag)}}
  {{Form::hidden('email_flag', $request->email_flag)}}
  {{Form::hidden('in_charge', $request->in_charge)}}
  {{Form::hidden('tel', $request->tel)}}

  {{Form::hidden('event_start', $request->event_start)}}
  {{Form::hidden('event_finish', $request->event_finish)}}
  {{Form::hidden('event_name1', $request->event_name1)}}
  {{Form::hidden('event_name2', $request->event_name2)}}
  {{Form::hidden('event_owner', $request->event_owner)}}
  {{Form::hidden('luggage_arrive', $request->luggage_arrive)}}
  {{Form::hidden('luggage_return', $request->luggage_return)}}
  {{Form::hidden('discount_condition', $request->discount_condition)}}
  {{Form::hidden('attention', $request->attention)}}
  {{Form::hidden('user_details', $request->user_details)}}
  {{Form::hidden('admin_details', $request->admin_details)}}

  {{Form::hidden('unknown_user_company', $request->unknown_user_company)}}
  {{Form::hidden('unknown_user_name', $request->unknown_user_name)}}
  {{Form::hidden('unknown_user_email', $request->unknown_user_email)}}
  {{Form::hidden('unknown_user_tel', $request->unknown_user_tel)}}
  {{Form::hidden('unknown_user_mobile', $request->unknown_user_mobile)}}


  {{Form::submit('保存する', ['class'=>'btn more_btn_lg mx-auto d-block my-5', 'id'=>'check_submit'])}}

</section>
{{Form::close()}}

<script>
  $(function() {
    $("html,body").animate({
      scrollTop: $('.bill').offset().top
    });

    $(function() {
      // プラスボタンクリック
      $(document).on("click", ".add", function() {
        $(this).parent().parent().clone(true).insertAfter($(this).parent().parent());
        addThisTr('.others .others_main tr', 'others_input_item', 'others_input_cost', 'others_input_count', 'others_input_subtotal');
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