@extends('layouts.admin.app')
@section('content')

    <link href="{{ asset('/css/template.css') }}" rel="stylesheet">
    <script src="{{ asset('/js/admin/agents_reservation/template.js') }}"></script>
    <script src="{{ asset('/js/lettercounter.js') }}"></script>
    <script src="{{ asset('/js/holidays.js') }}"></script>
    <script src="{{ asset('/js/admin/agents_reservation/validation.js') }}"></script>
    <script src="{{ asset('/js/ajax_agent.js') }}"></script>
    <script src="{{ asset('/js/admin/reservation/control_time_reject_self.js') }}"></script>

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

    @include('layouts.admin.breadcrumbs', ['id' => $reservation['id']])

    <div id="fullOverlay">
        <div class="frame_spinner">
            <div class="spinner-border text-primary " role="status">
                <span class="sr-only hide">Loading...</span>
            </div>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    <li>一部データに不整合があり保存に失敗しました。再度更新してください</li>
                @endforeach
            </ul>
        </div>
    @endif



    {{ Form::open(['url' => '/admin/agents_reservations/edit_check', 'method' => 'POST', 'id' => 'agents_reservations_edit', 'autocomplete' => 'off']) }}
    @csrf
    {{ Form::hidden('reservation_id', $reservation['id'], ['class' => 'form-control', 'readonly']) }}
    {{ Form::hidden('bill_id', $reservation['bills'][0]['id'], ['class' => 'form-control', 'readonly']) }}


    @if (session('flash_message'))
        <div class="alert alert-danger">
            <ul>
                <li> {!! session('flash_message') !!} </li>
            </ul>
        </div>
    @endif

    <section class="mt-5">
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
                            {{ Form::text('reserve_date', date('Y-m-d', strtotime($reservation['reserve_date'])), ['class' => 'form-control', 'readonly']) }}
                            <p class="is-error-reserve_date" style="color: red"></p>
                        </td>
                    </tr>
                    <tr>
                        <td class="table-active form_required">会場</td>
                        <td>
                            {{ Form::text('', ReservationHelper::getVenue($reservation['venue_id']), ['class' => 'form-control', 'readonly']) }}
                            {{ Form::hidden('venue_id', $reservation['venue_id'], ['class' => 'form-control', 'readonly']) }}
                            <p class="is-error-venue_id" style="color: red"></p>
                        </td>
                    </tr>
                    <tr>
                        <td class="table-active">料金体系</td>
                        <td>
                            <div class='price_radio_selector'>
                                <div class="d-flex justfy-content-start align-items-center">
                                    {{ Form::radio('price_system', 1, $reservation['price_system'] == 1 ? true : false, ['class' => 'mr-2', 'id' => 'price_system_radio1']) }}
                                    {{ Form::label('price_system_radio1', '通常（枠貸）') }}
                                </div>
                                <div class="d-flex justfy-content-start align-items-center">
                                    {{ Form::radio('price_system', 2, $reservation['price_system'] == 2 ? true : false, ['class' => 'mr-2', 'id' => 'price_system_radio2']) }}
                                    {{ Form::label('price_system_radio2', '音響HG') }}
                                </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="table-active form_required">入室時間</td>
                        <td>
                            <select name="enter_time" id="sales_start" class="form-control">
                                <option disabled selected></option>
                                {!! ReservationHelper::timeOptionsWithRequest($reservation['enter_time']) !!}
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td class="table-active form_required">退室時間</td>
                        <td>
                            <select name="leave_time" id="sales_finish" class="form-control">
                                <option disabled selected></option>
                                {!! ReservationHelper::timeOptionsWithRequest($reservation['leave_time']) !!}
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
                                    {{ Form::radio('board_flag', 1, $reservation['board_flag'] == 1 ? 'checked' : '', ['class' => '', 'id' => 'board_flag']) }}
                                    {{ Form::label('board_flag', 'あり') }}
                                </p>
                                <p>
                                    {{ Form::radio('board_flag', 0, $reservation['board_flag'] == 0 ? 'checked' : '', ['class' => '', 'id' => 'no_board_flag']) }}
                                    {{ Form::label('no_board_flag', 'なし') }}
                                </p>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="table-active" id="eventRequired">イベント名称1</td>
                        <td>
                            <div class="align-items-end d-flex">
                                {{ Form::text('event_name1', $reservation['event_name1'], ['class' => 'form-control', 'id' => 'eventname1Count']) }}
                                <span class="ml-1 annotation count_num1"></span>
                            </div>
                            <p class="is-error-event_name1" style="color: red"></p>
                        </td>
                    </tr>
                    <tr>
                        <td class="table-active">イベント名称2</td>
                        <td>
                            <div class="align-items-end d-flex">
                                {{ Form::text('event_name2', $reservation['event_name2'], ['class' => 'form-control', 'id' => 'eventname2Count']) }}
                                <span class="ml-1 annotation count_num2"></span>
                            </div>
                            <p class="is-error-event_name2" style="color: red"></p>
                        </td>
                    </tr>
                    <tr>
                        <td class="table-active">主催者名</td>
                        <td>
                            <div class="align-items-end d-flex">
                                {{ Form::text('event_owner', $reservation['event_owner'], ['class' => 'form-control', 'id' => 'eventownerCount']) }}
                                <span class="ml-1 annotation count_num3"></span>
                            </div>
                            <p class="is-error-event_owner" style="color: red"></p>
                        </td>
                    </tr>
                    <tr>
                        <td class="table-active">イベント開始時間</td>
                        <td>
                            <select name="event_start" id="event_start" class="form-control">
                                @if ($reservation['board_flag'] === 0)
                                    {!! ReservationHelper::timeOptionsWithRequestAndLimit($reservation['enter_time'], $reservation['enter_time'], $reservation['leave_time']) !!}
                                @else
                                    {!! ReservationHelper::timeOptionsWithRequestAndLimit($reservation['event_start'], $reservation['enter_time'], $reservation['leave_time']) !!}
                                @endif
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td class="table-active">イベント終了時間</td>
                        <td>
                            <select name="event_finish" id="event_finish" class="form-control">
                                @if ($reservation['board_flag'] === 0)
                                    {!! ReservationHelper::timeOptionsWithRequestAndLimit($reservation['leave_time'], $reservation['enter_time'], $reservation['leave_time']) !!}
                                @else
                                    {!! ReservationHelper::timeOptionsWithRequestAndLimit($reservation['event_finish'], $reservation['enter_time'], $reservation['leave_time']) !!}
                                @endif
                            </select>
                        </td>
                    </tr>
                </table>
                <p class="warning-text mb-3 mt-1">※イベント時間を非表示にする場合は、イベント開始・終了時間ともに「00時00分」を選択して下さい。</p>

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
                        <tbody class="accordion-wrap">
                            @foreach ($venue->getEquipments() as $key => $equipment)
                                <tr>
                                    <td class="table-active">{{ $equipment->item }}({{ $equipment->price }}円)</td>
                                    <td>
                                        <div class="d-flex align-items-end">
                                            @foreach ($reservation['bills'][0]['breakdowns'] as $key => $value)
                                                @if ($value['unit_item'] === $equipment->item)
                                                    {{ Form::number('equipment_breakdown[]', $value['unit_count'], [
                                                        'class' => 'form-control
                                                                      equipment_breakdown',
                                                    ]) }}
                                                @break

                                            @elseif($loop->last)
                                                {{ Form::number('equipment_breakdown[]', '', ['class' => 'form-control equipment_breakdown']) }}
                                            @endif
                                        @endforeach
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
                    <tbody class="accordion-wrap">
                        @foreach ($venue->getServices() as $key => $service)
                            <tr>
                                <td class="table-active">
                                    {{ $service->item }}({{ $service->price }}円)
                                </td>
                                <td>
                                    <div class="radio-box">
                                        @foreach ($reservation['bills'][0]['breakdowns'] as $s_key => $value)
                                            @if ($value['unit_item'] === $service->item)
                                                <p>
                                                    {{ Form::radio('services_breakdown[' . $key . ']', 1, true, ['id' => 'service' . $key . 'on', 'class' => '']) }}
                                                    {{ Form::label('service' . $key . 'on', 'あり') }}
                                                </p>
                                                <p>
                                                    {{ Form::radio('services_breakdown[' . $key . ']', 0, false, ['id' => 'service' . $key . 'off', 'class' => '']) }}
                                                    {{ Form::label('service' . $key . 'off', 'なし') }}
                                                </p>
                                            @break

                                        @elseif($loop->last)
                                            <p>
                                                {{ Form::radio('services_breakdown[' . $key . ']', 1, false, ['id' => 'service' . $key . 'on', 'class' => '']) }}
                                                {{ Form::label('service' . $key . 'on', 'あり') }}
                                            </p>
                                            <p>
                                                {{ Form::radio('services_breakdown[' . $key . ']', 0, true, ['id' => 'service' . $key . 'off', 'class' => '']) }}
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

        @if ($venue->layout != 0)
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
                            <td class="table-active">準備
                                ({{ number_format($venue->layout_prepare) }}
                                円)</td>
                            <td>
                                <div class="radio-box">
                                    <p>
                                        {{ Form::radio('layout_prepare', 1, collect($reservation['bills'][0]['breakdowns'])->contains('unit_item', 'レイアウト準備料金') ? true : false, ['id' => 'layout_prepare', 'class' => '']) }}
                                        <label for='layout_prepare' class="form-check-label">あり</label>
                                    </p>
                                    <p>
                                        {{ Form::radio('layout_prepare', 0, collect($reservation['bills'][0]['breakdowns'])->contains('unit_item', 'レイアウト準備料金') ? false : true, ['id' => 'no_layout_prepare', 'class' => '']) }}
                                        <label for='no_layout_prepare' class="form-check-label">なし</label>
                                    </p>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="table-active">片付
                                ({{ number_format($venue->layout_clean) }}
                                円)</td>
                            <td>
                                <div class="radio-box">
                                    <p>
                                        {{ Form::radio('layout_clean', 1, collect($reservation['bills'][0]['breakdowns'])->contains('unit_item', 'レイアウト片付料金') ? true : false, ['id' => 'layout_clean', 'class' => '']) }}
                                        <label for='layout_clean' class="form-check-label">あり</label>
                                    </p>
                                    <p>
                                        {{ Form::radio('layout_clean', 0, collect($reservation['bills'][0]['breakdowns'])->contains('unit_item', 'レイアウト片付料金') ? false : true, ['id' => 'no_layout_clean', 'class' => '']) }}
                                        <label for='no_layout_clean' class="form-check-label">なし</label>
                                    </p>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        @endif

        @if ($venue->luggage_flag != 0)
            <div class='luggage'>
                <table class='table table-bordered' style="table-layout:fixed;">
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
                                        {{ Form::radio('luggage_flag', 1, (int) $reservation['luggage_flag'] === 1 ? true : false, ['id' => 'luggage_flag']) }}
                                        {{ Form::label('luggage_flag', 'あり') }}
                                    </p>
                                    <p>
                                        {{ Form::radio('luggage_flag', 0, (int) $reservation['luggage_flag'] === 0 ? true : false, ['id' => 'no_luggage_flag']) }}
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
                                {{ Form::number('luggage_count', $reservation['luggage_count'], ['class' => 'form-control', 'id' => 'luggage_count', 'min' => 0]) }}
                                <p class="is-error-luggage_count" style="color: red"></p>
                            </td>
                        </tr>
                        <tr>
                            <td class="table-active">事前荷物の到着日<br>(平日午前指定)</td>
                            <td>
                                {{ Form::text('luggage_arrive', !empty($reservation['luggage_arrive']) ? date('Y-m-d', strtotime($reservation['luggage_arrive'])) : '', [
                                    'class' => 'form-control
                                                holidays',
                                    'id' => 'luggage_arrive',
                                ]) }}
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
                                {{ Form::number('luggage_return', $reservation['luggage_return'], ['class' => 'form-control', 'id' => 'luggage_return', 'min' => 0]) }}
                                <p class="is-error-luggage_return" style="color: red"></p>
                                <div class="mt-1 luggage_info">
                                                ※返送時の「発送伝票（元払）/返送伝票（着払）」は会場内に用意しているものを必ず使用して下さい。
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        @endif

        @if ($venue->eat_in_flag != 0)
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
                                {{ Form::radio('eat_in', 1, $reservation['eat_in'] == 1 ? true : false, ['id' => 'eat_in']) }}
                                {{ Form::label('eat_in', 'あり') }}
                            </td>
                            <td>
                                {{ Form::radio('eat_in_prepare', 1, !empty($reservation['eat_in_prepare']) ? ($reservation['eat_in_prepare'] == 1 ? true : false) : false, ['id' => 'eat_in_prepare', $reservation['eat_in'] != 1 ? 'disabled' : '']) }}
                                {{ Form::label('eat_in_prepare', '手配済み') }}
                                {{ Form::radio('eat_in_prepare', 2, !empty($reservation['eat_in_prepare']) ? ($reservation['eat_in_prepare'] == 2 ? true : false) : false, ['id' => 'eat_in_consider', $reservation['eat_in'] != 1 ? 'disabled' : '']) }}
                                {{ Form::label('eat_in_consider', '検討中') }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                {{ Form::radio('eat_in', 0, $reservation['eat_in'] == 0 ? true : false, ['id' => 'no_eat_in']) }}
                                {{ Form::label('no_eat_in', 'なし') }}
                            </td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        @endif


    </div>
    {{-- 右側 --}}
    <div class="col">
        <div class="client_mater">
            <table class="table table-bordered name-table" style="table-layout:fixed;">
                <tr>
                    <td colspan="2">
                        <div class="d-flex align-items-center justify-content-between">
                            <p class="title-icon">
                                <i class="far fa-id-card icon-size"></i>顧客情報
                            </p>
                            <p>
                                <a class="more_btn user_link" target="_blank" rel="noopener" href="{{ url('/admin/clients/' . $reservation['agent_id']) }}">顧客詳細</a>
                            </p>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="table-active"><label for="user_id" class="form_required">会社名/団体名</label></td>
                    <td>
                        <select class="form-control" name="agent_id" id="agent_select">
                            <option disabled selected>選択してください</option>
                            @foreach ($agents as $agent)
                                <option value="{{ $agent->id }}" @if ($agent->id == $reservation['agent_id']) selected @endif>{{ $agent->name }} |
                                    {{ $agent->person_firstname }}{{ $agent->person_lastname }} | {{ $agent->email }}
                                </option>
                            @endforeach
                        </select>
                        <p class="is-error-user_id" style="color: red"></p>
                    </td>
                </tr>
                <tr>
                    <td class="table-active"><label for="name">担当者氏名</label></td>
                    <td>
                        <p class="selected_person">
                            {{ ReservationHelper::getAgentPerson($reservation['agent_id']) }}
                        </p>
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
                        {{ Form::text('enduser_company', !empty($reservation['enduser']) ? $reservation['enduser']['company'] : null, ['class' => 'form-control', 'placeholder' => '入力してください', 'id' => 'enduser_company']) }}
                    </td>
                </tr>
                <tr>
                    <td class="table-active">
                        <label for="enduser_address" class=" ">住所</label>
                    </td>
                    <td>
                        {{ Form::text('enduser_address', !empty($reservation['enduser']) ? $reservation['enduser']['address'] : null, ['class' => 'form-control', 'placeholder' => '入力してください', 'id' => 'enduser_address']) }}

                    </td>
                </tr>
                <tr>
                    <td class="table-active">
                        <label for="enduser_tel" class="">連絡先</label>
                    </td>
                    <td>
                        {{ Form::text('enduser_tel', !empty($reservation['enduser']) ? $reservation['enduser']['tel'] : null, ['class' => 'form-control', 'placeholder' => '入力してください', 'id' => 'enduser_tel']) }}
                        <p class="is-error-enduser_tel" style="color: red"></p>
                        <p class="annotation mt-1">※半角数字、ハイフンなしで入力下さい。</p>
                    </td>
                </tr>
                <tr>
                    <td class="table-active">
                        <label for="enduser_mail" class=" ">メールアドレス</label>
                    </td>
                    <td>
                        {{ Form::text('enduser_mail', !empty($reservation['enduser']) ? $reservation['enduser']['email'] : null, ['class' => 'form-control', 'placeholder' => '入力してください', 'id' => 'enduser_mail']) }}

                        <p class="is-error-enduser_mail" style="color: red"></p>
                    </td>
                </tr>
                <tr>
                    <td class="table-active">
                        <label for="enduser_incharge" class="">当日担当者</label>
                    </td>
                    <td>
                        {{ Form::text('enduser_incharge', !empty($reservation['enduser']) ? $reservation['enduser']['person'] : null, ['class' => 'form-control', 'placeholder' => '入力してください', 'id' => 'enduser_incharge']) }}
                    </td>
                </tr>
                <tr>
                    <td class="table-active">
                        <label for="" class="">当日連絡先</label>
                    </td>
                    <td>
                        {{ Form::text('enduser_mobile', !empty($reservation['enduser']) ? $reservation['enduser']['mobile'] : null, ['class' => 'form-control', 'placeholder' => '入力してください', 'id' => 'enduser_mobile']) }}
                        <p class="is-error-enduser_mobile" style="color: red"></p>
                        <p class="annotation mt-1">※半角数字、ハイフンなしで入力下さい。</p>
                    </td>
                </tr>
                <tr>
                    <td class="table-active">
                        <label for="enduser_attr" class="">利用者属性</label>
                    </td>
                    <td>
                        {{ Form::select('enduser_attr', [1 => '一般企業', 2 => '上場企業', 3 => '近隣利用', 4 => '個人講師', 5 => 'MLM', 6 => 'その他'], $reservation['enduser'] ? $reservation['enduser']['attr'] : null, ['class' => 'form-control']) }}
                    </td>
                </tr>
            </table>
        </div>
        <table class="table table-bordered sale-table">
            <tr>
                <td colspan="2">
                    <p class="title-icon">
                        <i class="fas fa-yen-sign icon-size"></i>エンドユーザーからの入金額(レイアウト料金は含まない)
                    </p>
                </td>
            </tr>
            <tr>
                <td class="table-active form_required">
                    <label for="end_user_charge">支払い料</label>
                </td>
                <td>
                    <div class="d-flex align-items-center">
                        {{ Form::text('end_user_charge', $reservation['enduser']['charge'] ?: null, [
                            'class' => 'form-control
                                      ',
                            'placeholder' => '入力してください',
                        ]) }}
                        <span class="ml-1">円</span>
                    </div>
                    <p class="is-error-end_user_charge" style="color: red"></p>
                </td>
            </tr>
        </table>

        @if ($venue->alliance_flag == 1)
            <table class="table table-bordered sale-table" style="table-layout:fixed;">
                <tr>
                    <td colspan="2">
                        <p class="title-icon">
                            <i class="fas fa-yen-sign icon-size"></i>
                            売上原価
                            <span class="annotation">（提携会場を選択した場合、提携会場で設定した原価率が適応されます）</span>
                        </p>
                    </td>
                </tr>
                <tr>
                    <td class="table-active"><label for="cost">原価率</label></td>
                    <td>
                        <div class="d-flex align-items-end">
                            {{ Form::text('cost', $reservation['cost'], ['class' => 'form-control']) }}
                            <span class="ml-1">%</span>
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
                        <i class="fas fa-envelope icon-size"></i>備考
                    </p>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="adminNote">管理者備考</label>
                    <div>
                        {{ Form::textarea('admin_details', $reservation['admin_details'], ['class' => 'form-control ', 'placeholder' => '入力してください']) }}
                    </div>
                </td>
            </tr>
        </table>
    </div>
</div>
</section>
{{ Form::submit('再計算する', ['class' => 'btn more_btn4_lg mx-auto my-5 d-block', 'id' => 'check_submit', 'name' => 'edit_calc']) }}
<section class="mt-5 pt-5">
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
                        <dt>合計金額（税込）</dt>
                        <dd class="total_result">
                            {{ number_format(ReservationHelper::taxAndPrice((int) $reservation['bills'][0]['master_subtotal'] + (int) $discounts)) }}
                            円</dd>
                    </dl>
                </td>
                <td>
                    <dl class="ttl_box">
                        <dt>支払い期日</dt>
                        <dd class="total_result">
                            {{ ReservationHelper::formatDate($reservation['bills'][0]['payment_limit']) }}
                        </dd>
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
                        @foreach (collect($reservation['bills'][0]['breakdowns'])->where('unit_type', 1) as $key => $value)
                            @if (strpos($value['unit_item'], '割引料金') === false)
                                <tr>
                                    <td>
                                        {{ Form::text('venue_breakdown_item[]', $value['unit_item'], ['class' => 'form-control', 'readonly']) }}
                                    </td>
                                    <td>
                                        {{ Form::text('venue_breakdown_cost[]', '', ['class' => 'form-control', 'readonly']) }}
                                    </td>
                                    <td>
                                        {{ Form::text('venue_breakdown_count[]', $value['unit_count'], ['class' => 'form-control', 'readonly']) }}
                                    </td>
                                    <td>
                                        {{ Form::text('venue_breakdown_subtotal[]', '', ['class' => 'form-control', 'readonly']) }}
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- 以下備品 --}}
            @if (collect($reservation['bills'][0]['breakdowns'])->contains('unit_type', 2) || collect($reservation['bills'][0]['breakdowns'])->contains('unit_type', 3))
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
                            @foreach (collect($reservation['bills'][0]['breakdowns'])->where('unit_type', 2) as $key => $value)
                                @if (strpos($value['unit_item'], '割引料金') === false)
                                    <tr>
                                        <td>
                                            {{ Form::text('equipment_breakdown_item[]', $value['unit_item'], ['class' => 'form-control', 'readonly']) }}
                                        </td>
                                        <td>
                                            {{ Form::text('equipment_breakdown_cost[]', '', ['class' => 'form-control', 'readonly']) }}
                                        </td>
                                        <td>
                                            {{ Form::text('equipment_breakdown_count[]', $value['unit_count'], ['class' => 'form-control', 'readonly']) }}
                                        </td>
                                        <td>
                                            {{ Form::text('equipment_breakdown_subtotal[]', '', ['class' => 'form-control', 'readonly']) }}
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                            @foreach (collect($reservation['bills'][0]['breakdowns'])->where('unit_type', 3) as $key => $value)
                                @if (strpos($value['unit_item'], '割引料金') === false)
                                    <tr>
                                        <td>
                                            {{ Form::text('service_breakdown_item[]', $value['unit_item'], ['class' => 'form-control', 'readonly']) }}
                                        </td>
                                        <td>
                                            {{ Form::text('service_breakdown_cost[]', '', ['class' => 'form-control', 'readonly']) }}
                                        </td>
                                        <td>
                                            {{ Form::text('service_breakdown_count[]', $value['unit_count'], ['class' => 'form-control', 'readonly']) }}
                                        </td>
                                        <td>
                                            {{ Form::text('service_breakdown_subtotal[]', '', ['class' => 'form-control', 'readonly']) }}
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

            {{-- 以下、レイアウト --}}
            @if (collect($reservation['bills'][0]['breakdowns'])->contains('unit_type', 4))
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
                            @foreach (collect($reservation['bills'][0]['breakdowns'])->where('unit_type', 4) as $key => $value)
                                @if (strpos($value['unit_item'], '割引料金') === false)
                                    <tr>
                                        <td>
                                            {{ Form::text('layout_breakdown_item[]', $value['unit_item'], ['class' => 'form-control', 'readonly']) }}
                                        </td>
                                        <td>
                                            {{ Form::text('layout_breakdown_cost[]', $value['unit_cost'], ['class' => 'form-control', 'readonly']) }}
                                        </td>
                                        <td>
                                            {{ Form::text('layout_breakdown_count[]', $value['unit_count'], ['class' => 'form-control', 'readonly']) }}
                                        </td>
                                        <td>
                                            {{ Form::text('layout_breakdown_subtotal[]', $value['unit_subtotal'], ['class' => 'form-control', 'readonly']) }}
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                        <tbody class="layout_result">
                            <tr>
                                <td colspan="3"></td>
                                <td colspan="1">
                                    <p class="text-left">合計</p>
                                    @foreach (collect($reservation['bills'][0]['breakdowns'])->where('unit_type', 4) as $key => $value)
                                        @if (strpos($value['unit_item'], '割引料金') !== false)
                                            {{ Form::text('layout_price', ((int) $reservation['bills'][0]['layout_price']) + ((int) -$value['unit_cost']), [
                                                'class' => 'form-control
                                                              col-xs-3',
                                                'readonly',
                                            ]) }}
                                        @break

                                    @elseif($loop->last)
                                        {{ Form::text('layout_price', (int) $reservation['bills'][0]['layout_price'], [
                                            'class' => 'form-control
                                                          col-xs-3',
                                            'readonly',
                                        ]) }}
                                    @endif
                                @endforeach
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        @endif

        {{-- 以下、その他 --}}
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
                        <td>追加/削除</td>
                    </tr>
                </tbody>
                <tbody class="others_main">
                    @if (collect($reservation['bills'][0]['breakdowns'])->contains('unit_type', 5))
                        @foreach (collect($reservation['bills'][0]['breakdowns'])->where('unit_type', 5) as $key => $value)
                            @if (strpos($value['unit_item'], '割引料金') === false)
                                <tr>
                                    <td>
                                        {{ Form::text('others_breakdown_item[]', $value['unit_item'], ['class' => 'form-control']) }}
                                    </td>
                                    <td>
                                        {{ Form::text('others_breakdown_cost[]', 0, ['class' => 'form-control', 'readonly']) }}
                                    </td>
                                    <td>
                                        {{ Form::text('others_breakdown_count[]', $value['unit_count'], ['class' => 'form-control']) }}
                                    </td>
                                    <td>
                                        {{ Form::text('others_breakdown_subtotal[]', 0, ['class' => 'form-control', 'readonly']) }}
                                    </td>
                                    <td class="text-left">
                                        <input type="button" value="＋" class="add pluralBtn bg-blue">
                                        <input type="button" value="ー" class="del pluralBtn bg-red">
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    @else
                        <tr>
                            <td>
                                {{ Form::text('others_breakdown_item[]', '', ['class' => 'form-control']) }}
                            </td>
                            <td>
                                {{ Form::text('others_breakdown_cost[]', 0, ['class' => 'form-control', 'readonly']) }}
                            </td>
                            <td>
                                {{ Form::text('others_breakdown_count[]', 0, ['class' => 'form-control']) }}
                            </td>
                            <td>
                                {{ Form::text('others_breakdown_subtotal[]', 0, ['class' => 'form-control', 'readonly']) }}
                            </td>
                            <td class="text-left">
                                <input type="button" value="＋" class="add pluralBtn bg-blue">
                                <input type="button" value="ー" class="del pluralBtn bg-red">
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        {{-- 以下、総合計 --}}
        <div class="bill_total">
            <table class="table">
                <tr>
                    <td>小計：</td>
                    <td>
                        {{ Form::text('master_subtotal', (int) $reservation['bills'][0]['master_subtotal'] + (int) $discounts, ['class' => 'form-control text-right', 'readonly']) }}
                    </td>
                </tr>
                <tr>
                    <td>消費税：</td>
                    <td>
                        {{ Form::text('master_tax', ReservationHelper::getTax((int) $reservation['bills'][0]['master_subtotal'] + (int) $discounts), ['class' => 'form-control text-right', 'readonly']) }}
                    </td>
                </tr>
                <tr>
                    <td class="font-weight-bold">合計金額</td>
                    <td>
                        {{ Form::text('master_total', ReservationHelper::taxAndPrice((int) $reservation['bills'][0]['master_subtotal'] + (int) $discounts), ['class' => 'form-control text-right', 'readonly']) }}
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <!-- 請求内訳 終わり ------------------------------------------------------>
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
        <div class="informations billdetails_content py-3">
            <table class="table">
                <tr>
                    <td>請求日：
                        {{ Form::text('bill_created_at', date('Y-m-d', strtotime($reservation['bills'][0]['bill_created_at'])), ['class' => 'form-control', 'id' => 'datepicker6']) }}
                    </td>
                    <td>支払期日
                        {{ Form::text('payment_limit', date('Y-m-d', strtotime($reservation['bills'][0]['payment_limit'])), ['class' => 'form-control datepicker', 'id' => '']) }}
                    </td>
                </tr>
                <tr>
                    <td>
                        請求書宛名{{ Form::text('bill_company', !empty($reservation['bills'][0]['bill_company']) ? $reservation['bills'][0]['bill_company'] : '', ['class' => 'form-control']) }}
                    </td>
                    <td>
                        担当者{{ Form::text('bill_person', $reservation['bills'][0]['bill_person'], ['class' => 'form-control']) }}
                    </td>
                </tr>
                <tr>
                    <td colspan="2">請求書備考
                        {{ Form::textarea('bill_remark', $reservation['bills'][0]['bill_remark'], ['class' => 'form-control']) }}
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
        <div class="py-3 paids billdetails_content">
            <table class="table" style="table-layout: fixed;">
                <tr>
                    <td>入金状況
                        {{ Form::select('paid', ['未入金', '入金済み', '遅延', '入金不足', '入金過多', '次回繰越'], $reservation['bills'][0]['paid'], ['class' => 'form-control']) }}
                    </td>
                    <td>
                        入金日
                        {{ Form::text('pay_day', !empty($reservation['bills'][0]['pay_day']) ? date('Y-m-d', strtotime($reservation['bills'][0]['pay_day'])) : '', ['class' => 'form-control', 'id' => 'datepicker7']) }}
                    </td>
                </tr>
                <tr>
                    <td>振込名
                        {{ Form::text('pay_person', $reservation['bills'][0]['pay_person'], ['class' => 'form-control']) }}
                        <p class="is-error-pay_person" style="color: red"></p>
                    </td>
                    <td>入金額
                        {{ Form::text('payment', $reservation['bills'][0]['payment'], ['class' => 'form-control']) }}
                        <p class="is-error-payment" style="color: red"></p>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>
</div>
</section>
<div class="alert-box d-flex align-items-center mb-0 mt-5">
<p>
予約内容に変更がある場合は、再計算するボタンをクリックしてから確認画面に進んでください。
</p>
</div>

{{ Form::submit('確認する', ['class' => 'btn d-block more_btn_lg mx-auto my-5', 'id' => '']) }}
{{ Form::close() }}

<script>
    $(document).on('click', '.holidays', function() {
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
            // プラスボタンクリック
            $(document).on("click", ".add", function() {
                $(this).parent().parent().clone(true).insertAfter($(this).parent().parent());
                // 追加時内容クリア
                $(this).parent().parent().next().find('td').find('input, select').eq(0).val('');
                $(this).parent().parent().next().find('td').find('input, select').eq(1).val(0);
                $(this).parent().parent().next().find('td').find('input, select').eq(2).val('');
                $(this).parent().parent().next().find('td').find('input, select').eq(3).val(0);
            });

            // マイナスボタンクリック
            $(document).on("click", ".del", function() {
                if ($(this).parent().parent().parent().attr('class') == "others_main") {
                    var count = $('.others .others_main tr').length;
                    var target = $(this).parent().parent();
                    if (target.parent().children().length > 1) {
                        target.remove();
                    }
                }
            });
        });
    })
</script>
@endsection
