@extends('layouts.admin.app')
@section('content')
    <script src="{{ asset('/js/template.js') }}"></script>
    <script src="{{ asset('/js/admin/pre_reservation/validation.js') }}"></script>
    <script src="{{ asset('/js/lettercounter.js') }}"></script>
    <script src="{{ asset('/js/holidays.js') }}"></script>
    <link href="{{ asset('/css/template.css') }}" rel="stylesheet">

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
    </style>

    <div id="fullOverlay">
        <div class="frame_spinner">
            <div class="spinner-border text-primary " role="status">
                <span class="sr-only hide">Loading...</span>
            </div>
        </div>
    </div>


<div class="container-field">
  <div class="float-right">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active">
          {{ Breadcrumbs::render(Route::currentRouteName(),$PreReservation->id) }}
        </li>
      </ol>
    </nav>
  </div>
  <h2 class="mt-3 mb-3">仮押え 編集</h2>
  <hr>
</div>

    <section class="mt-5">
        {{ Form::open(['url' => '/admin/pre_reservations/' . $PreReservation->id . '/re_calculate', 'method' => 'POST', 'id' => 'pre_reservationSingleEditForm', 'autocomplete' => 'off']) }}
        @csrf
        <div class="selected_user">
            <table class="table table-bordered" style="table-layout: fixed;">
                <thead>
                    <tr>
                        <th class="align-middle">顧客情報</th>
                        <td colspan="3">
                            <div class="d-flex align-items-center">
                                <p class="w-25">顧客ID：<span class="selected_user_id">{{ ReservationHelper::fixId($PreReservation->user_id) }}</span></p>
                                <select name="user_id" id="user_id">
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}" @if ($PreReservation->user_id == $user->id) selected @endif>
                                            {{ ReservationHelper::getCompany($user->id) }} ・ {{ ReservationHelper::getPersonName($user->id) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </td>
                    </tr>
                </thead>
                <tbody class="user_info">
                    <tr>
                        <td class="table-active">会社名・団体名</td>
                        <td>
                            <p class="company">
                                {{ $PreReservation->user_id == 999 ? '' : ReservationHelper::getCompany($PreReservation->user_id) }}
                            </p>
                        </td>
                        <td class="table-active">担当者氏名</td>
                        <td>
                            <p class="person">
                                {{ $PreReservation->user_id == 999 ? '' : ReservationHelper::getPersonName($PreReservation->user_id) }}
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td class="table-active">メールアドレス</td>
                        <td>
                            <p class="email">
                                {{ $PreReservation->user_id == 999 ? '' : ReservationHelper::getPersonEmail($PreReservation->user_id) }}
                            </p>
                        </td>
                        <td class="table-active">携帯番号</td>
                        <td>
                            <p class="mobile">
                                {{ $PreReservation->user_id == 999 ? '' : ReservationHelper::getPersonMobile($PreReservation->user_id) }}
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td class="table-active">固定電話</td>
                        <td>
                            <p class="tel">
                                {{ $PreReservation->user_id == 999 ? '' : ReservationHelper::getPersonTel($PreReservation->user_id) }}
                            </p>
                        </td>
                        <td class="table-active" scope="row"><label for="">割引条件</label></td>
                        <td>
                            <p class="condition">{!! nl2br(e($PreReservation->user->condition)) !!}</p>
                        </td>
                    </tr>
                    <tr>
                        <td class="table-active caution" scope="row"><label for="">注意事項</label></td>
                        <td class="caution" colspan="3">
                            <p class="attention">{!! nl2br(e($PreReservation->user->attention)) !!}</p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="unknown_user">
            <table class="table table-bordered" style="table-layout: fixed;">
                <thead>
                    <tr>
                        <th colspan="4">仮で入力する顧客情報</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="table-active">会社・団体名(仮)</td>
                        <td>
                            {{ Form::text('unknown_user_company', empty($PreReservation->unknown_user->unknown_user_company) ? '' : $PreReservation->unknown_user->unknown_user_company, ['class' => 'form-control']) }}
                        </td>
                        <td class="table-active">担当者名(仮)</td>
                        <td>
                            {{ Form::text('unknown_user_name', empty($PreReservation->unknown_user->unknown_user_name) ? '' : $PreReservation->unknown_user->unknown_user_name, ['class' => 'form-control']) }}
                        </td>
                    </tr>
                    <tr>
                        <td class="table-active">固定電話</td>
                        <td>
                            {{ Form::text('unknown_user_tel', empty($PreReservation->unknown_user->unknown_user_tel) ? '' : $PreReservation->unknown_user->unknown_user_tel, ['class' => 'form-control', 'placeholder' => '半角数字、ハイフンなしで入力してください']) }}
                            <p class="is-error-unknown_user_tel" style="color: red"></p>
                            <p class="annotation mt-1">※半角数字、ハイフンなしで入力下さい。</p>
                        </td>
                        <td class="table-active">携帯番号</td>
                        <td>
                            {{ Form::text('unknown_user_mobile', empty($PreReservation->unknown_user->unknown_user_mobile) ? '' : $PreReservation->unknown_user->unknown_user_mobile, ['class' => 'form-control', 'placeholder' => '半角数字、ハイフンなしで入力してください']) }}
                            <p class="is-error-unknown_user_mobile" style="color: red"></p>
                            <p class="annotation mt-1">※半角数字、ハイフンなしで入力下さい。</p>
                        </td>
                    </tr>
                    <tr>
                        <td class="table-active">メールアドレス</td>
                        <td>
                            {{ Form::text('unknown_user_email', empty($PreReservation->unknown_user->unknown_user_email) ? '' : $PreReservation->unknown_user->unknown_user_email, ['class' => 'form-control']) }}
                            <p class="is-error-unknown_user_email" style="color: red"></p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>


        {{-- 以下、詳細入力 --}}
        <div class="container-field mt-5 mb-5">
            <div class="row">
                <div class="col">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <td colspan="2">
                                    <p class="title-icon">
                                        <i class="fas fa-info-circle icon-size" aria-hidden="true"></i>
                                        仮押え情報
                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <td class="table-active">利用日</td>
                                <td>
                                    {{ Form::text('reserve_date', date('Y-m-d', strtotime($PreReservation->reserve_date)), ['class' => 'form-control', 'readonly']) }}
                                </td>
                            </tr>
                            <tr>
                                <td class="table-active">会場</td>
                                <td>
                                    {{ Form::text('', ReservationHelper::getVenue($PreReservation->venue_id), ['class' => 'form-control', 'readonly']) }}
                                    {{ Form::hidden('venue_id', $PreReservation->venue_id, ['class' => 'form-control']) }}
                                    <div class="price_selector">
                                        <div>
                                            <small>料金体系</small>
                                        </div>
                                        @if ($SPVenue->getPriceSystem()[0] == 1 && $SPVenue->getPriceSystem()[1] == 1)
                                            <div class="form-check">
                                                <p>
                                                    {{ Form::radio('price_system', 1, $PreReservation->price_system == 1 ? true : false, ['class' => 'mr-2', 'id' => 'price_system_radio1']) }}
                                                    {{ Form::label('price_system_radio1', '通常（枠貸）') }}
                                                </p>
                                                <p>
                                                    {{ Form::radio('price_system', 2, $PreReservation->price_system == 2 ? true : false, ['class' => 'mr-2', 'id' => 'price_system_radio2']) }}
                                                    {{ Form::label('price_system_radio2', '音響HG') }}
                                                </p>
                                            </div>
                                        @elseif($SPVenue->getPriceSystem()[0] == 1 && $SPVenue->getPriceSystem()[1] == 0)
                                            <div class="form-check">
                                                <p>
                                                    {{ Form::radio('price_system', 1, true, ['class' => 'mr-2', 'id' => 'price_system_radio1']) }}
                                                    {{ Form::label('price_system_radio1', '通常（枠貸）') }}
                                                </p>
                                            </div>
                                        @elseif($SPVenue->getPriceSystem()[0] == 0 && $SPVenue->getPriceSystem()[1] == 1)
                                            <div class="form-check">
                                                <p>
                                                    {{ Form::radio('price_system', 2, true, ['class' => 'mr-2', 'id' => 'price_system_radio2']) }}
                                                    {{ Form::label('price_system_radio2', '音響HG') }}
                                                </p>
                                            </div>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="table-active">入室時間</td>
                                <td>
                                    {{ Form::text('', ReservationHelper::formatTime($PreReservation->enter_time), ['class' => 'form-control', 'readonly']) }}
                                    {{ Form::hidden('enter_time', $PreReservation->enter_time) }}
                                </td>
                            </tr>
                            <tr>
                                <td class="table-active">退室時間</td>
                                <td>
                                    {{ Form::text('', ReservationHelper::formatTime($PreReservation->leave_time), ['class' => 'form-control', 'readonly']) }}
                                    {{ Form::hidden('leave_time', $PreReservation->leave_time) }}
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
                                    <p>
                                        <a target="_blank" rel="noopener noreferrer" href="https://system.osaka-conference.com/welcomboard/">
                                        <i class="fas fa-external-link-alt form-icon"></i>
                                        案内板サンプルはこちら
                                        </a>
                                    </p>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="table-active form_required">案内板</td>
                            <td>
                                <div class="radio-box">
                                    <p>
                                        {{ Form::radio('board_flag', 1, $PreReservation->board_flag == 1 ? true : false, ['id' => 'board_flag']) }}
                                        {{ Form::label('board_flag', 'あり') }}
                                    </p>
                                    <p>
                                        {{ Form::radio('board_flag', 0, $PreReservation->board_flag == 0 ? true : false, ['id' => 'no_board_flag']) }}
                                        {{ Form::label('no_board_flag', 'なし') }}
                                    </p>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="table-active" id="eventRequired">イベント名称1</td>
                            <td>
                                <div class="align-items-end d-flex">
                                    {{ Form::text('event_name1', $PreReservation->event_name1, ['class' => 'form-control', 'id' => 'eventname1Count']) }}
                                    <span class="ml-1 annotation count_num1"></span>
                                </div>
                                <p class="is-error-event_name1" style="color: red"></p>
                            </td>
                        </tr>
                        <tr>
                            <td class="table-active">イベント名称2</td>
                            <td>
                                <div class="align-items-end d-flex">
                                    {{ Form::text('event_name2', $PreReservation->event_name2, ['class' => 'form-control', 'id' => 'eventname2Count']) }}
                                    <span class="ml-1 annotation count_num2"></span>
                                </div>
                                <p class="is-error-event_name2" style="color: red"></p>
                            </td>
                        </tr>
                        <tr>
                            <td class="table-active">主催者名</td>
                            <td>
                                <div class="align-items-end d-flex">
                                    {{ Form::text('event_owner', $PreReservation->event_owner, ['class' => 'form-control', 'id' => 'eventownerCount']) }}
                                    <span class="ml-1 annotation count_num3"></span>
                                </div>
                                <p class="is-error-event_owner" style="color: red"></p>
                            </td>
                        </tr>
                        <tr>
                            <td class="table-active">イベント開始時間</td>
                            <td>
                                <select name="event_start" id="event_start" class="form-control">
                                    @if ($PreReservation->board_flag === 0)
                                        {!! ReservationHelper::timeOptionsWithRequestAndLimit($PreReservation->enter_time, $PreReservation->enter_time, $PreReservation->leave_time) !!}
                                    @else
                                        {!! ReservationHelper::timeOptionsWithRequestAndLimit($PreReservation->event_start, $PreReservation->enter_time, $PreReservation->leave_time) !!}
                                    @endif
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td class="table-active">イベント終了時間</td>
                            <td>
                                <select name="event_finish" id="event_finish" class="form-control">
                                    @if ($PreReservation->board_flag === 0)
                                        {!! ReservationHelper::timeOptionsWithRequestAndLimit($PreReservation->leave_time, $PreReservation->enter_time, $PreReservation->leave_time) !!}
                                    @else
                                        {!! ReservationHelper::timeOptionsWithRequestAndLimit($PreReservation->event_finish, $PreReservation->enter_time, $PreReservation->leave_time) !!}
                                    @endif

                                </select>
                            </td>
                        </tr>
                    </table>
                    <p class="warning-text mb-3 mt-1">※イベント時間を非表示にする場合は、イベント開始・終了時間ともに「00時00分」を選択して下さい。</p>

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
                                @foreach ($SPVenue->getEquipments() as $key => $equ)
                                    <tr>
                                        <td class="table-active">
                                            {{ $equ->item }}({{ number_format($equ->price) }}円)
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-end">
                                                @foreach ($PreReservation->pre_breakdowns()->get() as $s_equ)
                                                    @if ($s_equ->unit_item == $equ->item)
                                                        {{ Form::number('equipment_breakdown' . $key, $s_equ->unit_count, ['class' => 'form-control equipment_breakdowns equipment_validation']) }}
                                                    @break

                                                @elseif($loop->last)
                                                    {{ Form::number('equipment_breakdown' . $key, '', ['class' => 'form-control equipment_breakdowns equipment_validation']) }}
                                                @endif
                                            @endforeach
                                            <span class="ml-1">個</span>
                                        </div>
                                        <p class='{{ ' is-error-equipment_breakdown' . $key }}' style='color: red'></p>
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
                                        <i class="fas fa-hand-holding-heart icon-size"></i>有料サービス
                                    </p>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="accordion-wrap">
                            @foreach ($SPVenue->getServices() as $key => $ser)
                                <tr>
                                    <td class="table-active">
                                        {{ $ser->item }}({{ number_format($ser->price) . '円' }})
                                    </td>
                                    <td>
                                        <div class="radio-box">
                                            @foreach ($PreReservation->pre_breakdowns()->get() as $s_ser)
                                                @if ($s_ser->unit_item == $ser->item)
                                                    <p>
                                                        {{ Form::radio('services_breakdown' . $key, 1, true, ['id' => 'service' . $key . 'on']) }}
                                                        {{ Form::label('service' . $key . 'on', 'あり') }}
                                                    </p>
                                                    <p>
                                                        {{ Form::radio('services_breakdown' . $key, 0, false, ['id' => 'service' . $key . 'off']) }}
                                                        {{ Form::label('service' . $key . 'off', 'なし') }}
                                                    </p>
                                                @break

                                            @elseif($loop->last)
                                                <p>
                                                    {{ Form::radio('services_breakdown' . $key, 1, false, ['id' => 'service' . $key . 'on']) }}
                                                    {{ Form::label('service' . $key . 'on', 'あり') }}
                                                </p>
                                                <p>
                                                    {{ Form::radio('services_breakdown' . $key, 0, true, ['id' => 'service' . $key . 'off']) }}
                                                    {{ Form::label('service' . $key . 'off', 'なし') }}
                                                </p>
                                            @endif
                                        @endforeach
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if ($SPVenue->layout == 1)
                <div class="layouts">
                    <table class="table table-bordered">
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
                                    レイアウト準備({{ !empty($SPVenue->layout_prepare) ? number_format($SPVenue->layout_prepare) . '円' : null }})
                                </td>
                                <td>
                                    <div class="radio-box">
                                        @foreach ($PreReservation->pre_breakdowns()->get() as $s_lay_pre)
                                            @if ($s_lay_pre->unit_item == 'レイアウト準備料金')
                                                <p>
                                                    {{ Form::radio('layout_prepare', 1, true, ['id' => 'layout_prepare']) }}
                                                    {{ Form::label('layout_prepare', 'あり') }}
                                                </p>
                                                <p>
                                                    {{ Form::radio('layout_prepare', 0, false, ['id' => 'no_layout_prepare']) }}
                                                    {{ Form::label('no_layout_prepare', 'なし') }}
                                                </p>
                                            @break

                                        @elseif($loop->last)
                                            <p>
                                                {{ Form::radio('layout_prepare', 1, false, ['id' => 'layout_prepare']) }}
                                                {{ Form::label('layout_prepare', 'あり') }}
                                            </p>
                                            <p>
                                                {{ Form::radio('layout_prepare', 0, true, ['id' => 'no_layout_prepare']) }}
                                                {{ Form::label('no_layout_prepare', 'なし') }}
                                            </p>
                                        @endif
                                    @endforeach
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="table-active">
                                レイアウト片付({{ !empty($SPVenue->layout_clean) ? number_format($SPVenue->layout_clean) . '円' : null }})
                            </td>
                            <td>
                                <div class="radio-box">
                                    @foreach ($PreReservation->pre_breakdowns()->get() as $s_lay_cle)
                                        @if ($s_lay_cle->unit_item == 'レイアウト片付料金')
                                            <p>
                                                {{ Form::radio('layout_clean', 1, true, ['id' => 'layout_clean']) }}
                                                {{ Form::label('layout_clean', 'あり') }}
                                            </p>
                                            <p>
                                                {{ Form::radio('layout_clean', 0, false, ['id' => 'no_layout_clean']) }}
                                                {{ Form::label('no_layout_clean', 'なし') }}
                                            </p>
                                        @break

                                    @elseif($loop->last)
                                        <p>
                                            {{ Form::radio('layout_clean', 1, false, ['id' => 'layout_clean']) }}
                                            {{ Form::label('layout_clean', 'あり') }}
                                        </p>
                                        <p>
                                            {{ Form::radio('layout_clean', 0, true, ['id' => 'no_layout_clean']) }}
                                            {{ Form::label('no_layout_clean', 'なし') }}
                                        </p>
                                    @endif
                                @endforeach
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    @endif
    @if ($SPVenue->luggage_flag == 1)
        <div class="luggage">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th colspan='2'>
                            <p class="title-icon">
                                <i class="fas fa-suitcase-rolling icon-size"></i>荷物預かり
                            </p>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="table-active">荷物預かり</td>
                        <td>
                            <div class="radio-box">
                                <p>
                                    {{ Form::radio('luggage_flag', 1, (int) $PreReservation->luggage_flag === 1 ? true : false, ['id' => 'luggage_flag']) }}
                                    {{ Form::label('luggage_flag', 'あり') }}
                                </p>
                                <p>
                                    {{ Form::radio('luggage_flag', 0, (int) $PreReservation->luggage_flag === 0 ? true : false, ['id' => 'no_luggage_flag']) }}
                                    {{ Form::label('no_luggage_flag', 'なし') }}
                                </p>
                            </div>
                            <div class="mt-2 luggage-border">
                                            【事前・事後】預かりの荷物について<br>
                                            事前預かり/事後返送ともに<span class="f-s20">5個</span>まで。<br>
                                            6個以上は要相談。その際は事前に必ずお問い合わせ下さい。<br>
                                            荷物外寸合計(縦・横・奥行)120cm以下/個
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="table-active">事前に預かる荷物<br>(目安)</td>
                        <td>
                            {{ Form::number('luggage_count', $PreReservation->luggage_count, ['class' => 'form-control', 'id' => 'luggage_count', 'min' => 0]) }}
                            <p class='is-error-luggage_count' style='color: red'></p>
                        </td>
                    </tr>
                    <tr>
                        <td class="table-active">事前荷物の到着日<br>(平日午前指定)</td>
                        <td>
                            {{ Form::text('luggage_arrive', !empty($PreReservation->luggage_arrive) ? date('Y-m-d', strtotime($PreReservation->luggage_arrive)) : '', ['class' => 'form-control holidays', 'id' => 'luggage_arrive']) }}
                            <div class="mt-1 luggage_info">
                                                ※利用日3日前～前日（平日のみ）を到着日に指定下さい<br>
                                                ※送付詳細 / 伝票記載方法は該当会場詳細ページ「備品 / サービス」タブの「荷物預かり / 返送 PDF」をご確認下さい。<br>
                                                ※発送伝票（元払）/ 返送伝票（着払）は各自ご用意下さい。<br>
                                                ※貴重品等のお預りはできかねます。<br>
                                                ※事前荷物は入室時間迄に弊社が会場搬入します。
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="table-active">事後返送する荷物</td>
                        <td>
                            {{ Form::number('luggage_return', $PreReservation->luggage_return, ['class' => 'form-control', 'id' => 'luggage_return', 'min' => 0]) }}
                            <p class='is-error-luggage_return' style='color: red'></p>
                            <div class="mt-1 luggage_info">
                                ※返送時の「発送伝票（元払）/返送伝票（着払）」は会場内に用意しているものを必ず使用して下さい。
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="table-active">荷物預り料金(税抜)</td>
                        <td>
                            <p class="annotation">※仮押え時点では、料金の設定ができません。<br>予約へ切り替え後に料金の設定が可能です。</p>

                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    @endif
    @if ($SPVenue->eat_in_flag == 1)
        <div class="eat_in">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th colspan='2'>
                            <p class="title-icon">
                                <i class="fas fa-utensils icon-size"></i>室内飲食
                            </p>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            {{ Form::radio('eat_in', 1, $PreReservation->eat_in == 1 ? true : false, ['id' => 'eat_in']) }}
                            {{ Form::label('eat_in', 'あり') }}
                        </td>
                        <td>
                            @if (empty($PreReservation->eat_in_prepare))
                                {{ Form::radio('eat_in_prepare', 1, true, ['id' => 'eat_in_prepare', 'disabled']) }}
                                {{ Form::label('eat_in_prepare', '手配済み') }}
                                {{ Form::radio('eat_in_prepare', 2, false, ['id' => 'eat_in_consider', 'disabled']) }}
                                {{ Form::label('eat_in_consider', '検討中') }}
                            @else
                                {{ Form::radio('eat_in_prepare', 1, $PreReservation->eat_in_prepare == 1 ? true : false, ['id' => 'eat_in_prepare']) }}
                                {{ Form::label('eat_in_prepare', '手配済み') }}
                                {{ Form::radio('eat_in_prepare', 2, $PreReservation->eat_in_prepare == 2 ? true : false, ['id' => 'eat_in_consider']) }}
                                {{ Form::label('eat_in_consider', '検討中') }}
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>
                            {{ Form::radio('eat_in', 0, $PreReservation->eat_in == 0 ? true : false, ['id' => 'no_eat_in']) }}
                            {{ Form::label('no_eat_in', 'なし') }}
                        </td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>
    @endif
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
                    <label for="ondayName" class="">氏名</label>
                </td>
                <td>
                    {{ Form::text('in_charge', $PreReservation->in_charge, ['class' => 'form-control']) }}
                    <p class="is-error-in_charge" style="color: red"></p>
                </td>
            </tr>
            <tr>
                <td class="table-active"><label for="mobilePhone" class="">携帯番号</label></td>
                <td>
                    {{ Form::text('tel', $PreReservation->tel, ['class' => 'form-control', 'placeholder' => '半角数字、ハイフンなしで入力してください']) }}
                    <p class="is-error-tel" style="color: red"></p>
                    <p class="annotation mt-1">※半角数字、ハイフンなしで入力下さい。</p>
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
                    @if ($PreReservation->email_flag != 0)
                        <div class="radio-box">
                            <p>
                                {{ Form::radio('email_flag', 1, true, ['id' => 'email_flag']) }}
                                <label for="{{ 'email_flag' }}" class="form-check-label">あり</label>
                            </p>
                            <p>
                                {{ Form::radio('email_flag', 0, false, ['id' => 'no_email_flag']) }}
                                <label for="{{ 'no_email_flag' }}" class="form-check-label">なし</label>
                            </p>
                        </div>
                    @else
                        <div class="radio-box">
                            <p>
                                {{ Form::radio('email_flag', 1, false, ['id' => 'email_flag']) }}
                                <label for="{{ 'email_flag' }}" class="form-check-label">あり</label>
                            </p>
                            <p>
                                {{ Form::radio('email_flag', 0, true, ['id' => 'no_email_flag']) }}
                                <label for="{{ 'no_email_flag' }}" class="form-check-label">なし</label>
                            </p>
                        </div>
                    @endif
                </td>
            </tr>
        </tbody>
    </table>

    @if ($SPVenue->alliance_flag == 1)
        <table class="table table-bordered cost-table">
            <tbody>
                <tr>
                    <td colspan="2">
                        <p class="title-icon">
                            <i class="fas fa-yen-sign icon-size" aria-hidden="true"></i>売上原価
                        </p>
                    </td>
                </tr>
                <tr>
                    <td class="table-active"><label for="">原価率</label></td>
                    <td>
                        <div class="d-flex align-items-center">
                            {{ Form::text('cost', $PreReservation->cost ? $PreReservation->cost : $SPVenue->cost, ['class' => 'form-control']) }}
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
                        <i class="fas fa-file-alt icon-size" aria-hidden="true"></i>備考
                    </p>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="adminNote">管理者備考</label>
                    {{ Form::textarea('admin_details', $PreReservation->admin_details, ['class' => 'form-control', 'placeholder' => '入力してください']) }}
                </td>
            </tr>
        </tbody>
    </table>
</div>
</div>
</div>
<div class="submit_btn">
<div class="d-flex justify-content-center">
{{-- 単発仮押えか？一括仮押えか？ --}}
{{ Form::hidden('judge_count', 1) }}
{{-- ユーザー --}}
{{ Form::hidden('user_id', $PreReservation->user_id) }}
{{ Form::hidden('id', $PreReservation->id) }}
{{ Form::submit('再計算する', ['class' => 'btn more_btn4_lg mx-auto d-block my-5', 'id' => 'check_submit']) }}
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
{{ Form::close() }}


{{ Form::open(['url' => '/admin/pre_reservations/' . $PreReservation->id, 'method' => 'PUT', 'autocomplete' => 'off']) }}
@csrf
{{-- 以下、計算結果 --}}
<div class="bill">
<div class="bill_head py-0">
<table class="table mb-0" style="table-layout: fixed">
    <tr>
        <td>
            <h2 class="text-white">
                請求書No
            </h2>
        </td>
        <td>
            <dl class="ttl_box">
                <dt>合計金額（税込）</dt>
                <dd class="total_result">{{ number_format($PreReservation->pre_bill->master_total) }}円</dd>
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
                @foreach ($PreReservation->pre_breakdowns()->where('unit_type', 1)->get() as $key => $v_break)
                    <tr>
                        <td>
                            {{ Form::text('venue_breakdown_item' . $key, $v_break->unit_item, ['class' => 'form-control col-xs-3', 'readonly']) }}
                        </td>
                        <td>
                            {{ Form::text('venue_breakdown_cost' . $key, $v_break->unit_cost, ['class' => 'form-control col-xs-3', 'readonly']) }}
                        </td>
                        <td>
                            {{ Form::text('venue_breakdown_count' . $key, 1, ['class' => 'form-control col-xs-3', 'readonly']) }}
                        </td>
                        <td>
                            {{ Form::text('venue_breakdown_subtotal' . $key, $v_break->unit_subtotal, ['class' => 'form-control col-xs-3', 'readonly']) }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tbody class="venue_result">
                <tr>
                    <td colspan="3"></td>
                    <td colspan="1">
                        <p class="text-left">合計</p>
                        {{ Form::text('venue_price', $PreReservation->pre_bill->venue_price, ['class' => 'form-control col-xs-3', 'readonly']) }}
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
                @foreach ($PreReservation->pre_breakdowns()->where('unit_type', 2)->get() as $key => $e_break)
                    <tr>
                        <td>
                            {{ Form::text('equipment_breakdown_item' . $key, $e_break->unit_item, ['class' => 'form-control col-xs-3', 'readonly']) }}
                        </td>
                        <td>
                            {{ Form::text('equipment_breakdown_cost' . $key, $e_break->unit_cost, ['class' => 'form-control col-xs-3', 'readonly']) }}
                        </td>
                        <td>
                            {{ Form::text('equipment_breakdown_count' . $key, $e_break->unit_count, ['class' => 'form-control col-xs-3', 'readonly']) }}
                        </td>
                        <td>
                            {{ Form::text('equipment_breakdown_subtotal' . $key, $e_break->unit_subtotal, ['class' => 'form-control col-xs-3', 'readonly']) }}
                        </td>
                    </tr>
                @endforeach
                @foreach ($PreReservation->pre_breakdowns()->where('unit_type', 3)->get() as $key => $s_break)
                    <tr>
                        <td>
                            {{ Form::text('services_breakdown_item' . $key, $s_break->unit_item, ['class' => 'form-control col-xs-3', 'readonly']) }}
                        </td>
                        <td>
                            {{ Form::text('services_breakdown_cost' . $key, $s_break->unit_cost, ['class' => 'form-control col-xs-3', 'readonly']) }}
                        </td>
                        <td>
                            {{ Form::text('services_breakdown_count' . $key, $s_break->unit_count, ['class' => 'form-control col-xs-3', 'readonly']) }}
                        </td>
                        <td>
                            {{ Form::text('services_breakdown_subtotal' . $key, $s_break->unit_subtotal, ['class' => 'form-control col-xs-3', 'readonly']) }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tbody class="equipment_result">
                <tr>
                    <td colspan="3"></td>
                    <td colspan="1">
                        <p class="text-left">合計</p>
                        {{ Form::text('equipment_price', $PreReservation->pre_bill->first()->equipment_price, ['class' => 'form-control', 'readonly']) }}
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
                @foreach ($PreReservation->pre_breakdowns()->where('unit_type', 4)->get() as $key => $l_break)
                    <tr>
                        <td>
                            {{ Form::text('layout_breakdown_item' . $key, $l_break->unit_item, ['class' => 'form-control col-xs-3', 'readonly']) }}
                        </td>
                        <td>
                            {{ Form::text('layout_breakdown_cost' . $key, $l_break->unit_cost, ['class' => 'form-control col-xs-3', 'readonly']) }}
                        </td>
                        <td>
                            {{ Form::text('layout_breakdown_count' . $key, $l_break->unit_count, ['class' => 'form-control col-xs-3', 'readonly']) }}
                        </td>
                        <td>
                            {{ Form::text('layout_breakdown_subtotal' . $key, $l_break->unit_subtotal, [
                                'class' => 'form-control
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          col-xs-3',
                                'readonly',
                            ]) }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tbody class="layout_result">
                <tr>
                    <td colspan="3"></td>
                    <td colspan="1">
                        <p class="text-left">合計</p>
                        {{ Form::text('layout_price', $PreReservation->pre_bill->first()->layout_price, ['class' => 'form-control', 'readonly']) }}
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
                    {{ Form::text('master_subtotal', $PreReservation->pre_bill->master_subtotal, [
                        'class' => 'form-control
                                                                                                                                                                                                                                                                                                                                                                                                                                                                        text-right',
                        'readonly',
                    ]) }}
                </td>
            </tr>
            <tr>
                <td>消費税：</td>
                <td>
                    {{ Form::text('master_tax', $PreReservation->pre_bill->master_tax, ['class' => 'form-control text-right', 'readonly']) }}
                </td>
            </tr>
            <tr>
                <td class="font-weight-bold">合計金額</td>
                <td>
                    {{ Form::text('master_total', $PreReservation->pre_bill->master_total, [
                        'class' => 'form-control
                                                                                                                                                                                                                                                                                                                                                                                                                                                                        text-right',
                        'readonly',
                    ]) }}
                </td>
            </tr>
        </table>
    </div>
</div>
</div>
</div>


{{-- 単発仮押えか？一括仮押えか？ --}}
{{ Form::hidden('judge_count', 1) }}
{{ Form::hidden('user_id', $PreReservation->user_id) }}
{{ Form::hidden('venue_id', $PreReservation->venue_id) }}
{{ Form::hidden('reserve_date', $PreReservation->reserve_date) }}
{{ Form::hidden('price_system', $PreReservation->price_system) }}
{{ Form::hidden('enter_time', $PreReservation->enter_time) }}
{{ Form::hidden('leave_time', $PreReservation->leave_time) }}
{{ Form::hidden('board_flag', $PreReservation->board_flag) }}
{{ Form::hidden('email_flag', $PreReservation->email_flag) }}
{{ Form::hidden('in_charge', $PreReservation->in_charge) }}
{{ Form::hidden('tel', $PreReservation->tel) }}
{{ Form::hidden('eat_in', $PreReservation->eat_in) }}
{{ Form::hidden('eat_in_prepare', $PreReservation->eat_in_prepare) }}

{{ Form::hidden('event_start', $PreReservation->event_start) }}
{{ Form::hidden('event_finish', $PreReservation->event_finish) }}
{{ Form::hidden('event_name1', $PreReservation->event_name1) }}
{{ Form::hidden('event_name2', $PreReservation->event_name2) }}
{{ Form::hidden('event_owner', $PreReservation->event_owner) }}
{{ Form::hidden('luggage_arrive', $PreReservation->luggage_arrive) }}
{{ Form::hidden('luggage_return', $PreReservation->luggage_return) }}
{{ Form::hidden('luggage_flag', $PreReservation->luggage_flag) }}
{{ Form::hidden('discount_condition', $PreReservation->discount_condition) }}
{{ Form::hidden('attention', $PreReservation->attention) }}
{{ Form::hidden('user_details', $PreReservation->user_details) }}
{{ Form::hidden('admin_details', $PreReservation->admin_details) }}

{{ Form::hidden('unknown_user_company', $PreReservation->unknown_user_company) }}
{{ Form::hidden('unknown_user_name', $PreReservation->unknown_user_name) }}
{{ Form::hidden('unknown_user_email', $PreReservation->unknown_user_email) }}
{{ Form::hidden('unknown_user_tel', $PreReservation->unknown_user_tel) }}
{{ Form::hidden('unknown_user_mobile', $PreReservation->unknown_user_mobile) }}

</section>
{{ Form::close() }}

<script>
    $(document).on(' click', '.holidays', function() {
        getHolidayCalendar($('.holidays'), $('input[name="reserve_date"]'));
    });

    $(function() {
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

    $(function() {
        $(document).on("change", "#user_id", function() {
            var user_id = Number($('#user_id').val());
            if (user_id == 999) {
                $('.company').text('');
                $('.person').text('');
                $('.email').text('');
                $('.mobile').text('');
                $('.tel').text('');
            } else {
                ajaxGetuser(user_id);
            }
        });

        function ajaxGetuser($user_id) {
            $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: rootPath + '/admin/pre_reservations/get_user',
                    type: 'POST',
                    data: {
                        'user_id': $user_id,
                    },
                    dataType: 'json',
                    beforeSend: function() {
                        $('#fullOverlay').css('display', 'block');
                    },
                })
                .done(function($user) {
                    console.log($user);
                    $('#fullOverlay').css('display', 'none');
                    $(".company").text($user[1]);
                    $(".person").text($user[2] + $user[3]);
                    $(".email").text($user[4]);
                    $(".mobile").text($user[5]);
                    $(".tel").text($user[6]);
                    // $(".condition").text($user[7]);
                    $(".attention").text($user[9]);
                    $('input[name="user_id"]').val($user[0]);
                    $('.selected_user_id').text("").text(('000000' + $user[0]).slice(-6));
                })
                .fail(function($user) {
                    $('#fullOverlay').css('display', 'none');
                    console.log("ajax failed", $user);
                });
        };
    });

    $(function() {
        var maxTarget = $('input[name="reserve_date"]').val();
        $('#datepicker9').datepicker({
            dateFormat: 'yy-mm-dd',
            minDate: 0,
            maxDate: maxTarget,
            autoclose: true,
        });
    })

    $(function() {
        $(document).on("click", "input:radio[name='eat_in']", function() {
            var radioTarget = $('input:radio[name="eat_in"]:checked').val();
            if (radioTarget == 1) {
                $('input:radio[name="eat_in_prepare"]').prop('disabled', false);
            } else {
                $('input:radio[name="eat_in_prepare"]').prop('disabled', true);
                $('input:radio[name="eat_in_prepare"]').prop('checked', false);
            }
        })
    })
</script>

@endsection
