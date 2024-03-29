@extends('layouts.admin.app')

@section('content')
    <script src="{{ asset('/js/template.js') }}"></script>
    <script src="{{ asset('/js/admin/pre_agent_reservation/validation.js') }}"></script>
    <script src="{{ asset('/js/lettercounter.js') }}"></script>
    <script src="{{ asset('/js/holidays.js') }}"></script>
    <link href="{{ asset('/css/template.css') }}" rel="stylesheet">

    <div class="container-field">
        <div class="float-right">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active">
                        {{ Breadcrumbs::render(Route::currentRouteName()) }}
                    </li>
                </ol>
            </nav>
        </div>
        <h2 class="mt-3 mb-3">仮押え 計算 （仲介会社）</h2>
        <hr>
    </div>

    {{ Form::open(['url' => '/admin/pre_agent_reservations/calculate', 'method' => 'POST', 'id' => 'pre_agent_reservationsSingleCalculateForm']) }}
    @csrf

    <section class="mt-5">
        <div class="selected_user">
            <table class="table table-bordered" style="table-layout: fixed;">
                <thead>
                    <tr>
                        <th>仲介会社情報</th>
                        <th colspan="3">ID：<p class="user_id d-inline">{{ ReservationHelper::fixId($agent->id) }}</p>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="table-active">会社名・団体名</td>
                        <td colspan="3">
                            <p class="company">
                                {{ ReservationHelper::getAgentCompany($agent->id) }}
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td class="table-active">担当者氏名</td>
                        <td>
                            <p class="person">
                                {{ ReservationHelper::getAgentPerson($agent->id) }}
                            </p>
                        </td>
                        <td class="table-active">メールアドレス</td>
                        <td>
                            <p class="email">
                                {{ ReservationHelper::getAgentEmail($agent->id) }}
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td class="table-active">携帯番号</td>
                        <td>
                            <p class="mobile">
                                {{ ReservationHelper::getAgentMobile($agent->id) }}
                            </p>
                        </td>
                        <td class="table-active">固定電話</td>
                        <td>
                            <p class="tel">
                                {{ ReservationHelper::getAgentTel($agent->id) }}
                            </p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="unknown_user mt-3">
            <table class="table table-bordered" style="table-layout: fixed;">
                <thead>
                    <tr>
                        <th colspan="4">エンドユーザー情報 </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="table-active">エンドユーザー</td>
                        <td>
                            {{ Form::text('pre_enduser_company', $request->pre_enduser_company, ['class' => 'form-control', '']) }}
                        </td>
                        <td class="table-active">住所</td>
                        <td>
                            {{ Form::text('pre_enduser_address', $request->pre_enduser_address, ['class' => 'form-control', '']) }}
                        </td>
                    </tr>
                    <tr>
                        <td class="table-active">連絡先</td>
                        <td>
                            {{ Form::text('pre_enduser_tel', $request->pre_enduser_tel, ['class' => 'form-control', '']) }}
                            <p class="is-error-pre_enduser_tel" style="color: red"></p>
                            <p class="annotation mt-1">※半角数字、ハイフンなしで入力下さい。</p>
                        </td>
                        <td class="table-active">メールアドレス</td>
                        <td>
                            {{ Form::text('pre_enduser_email', $request->pre_enduser_email, ['class' => 'form-control', '']) }}
                            <p class="is-error-pre_enduser_email" style="color: red"></p>
                        </td>
                    </tr>
                    <tr>
                        <td class="table-active">当日担当者</td>
                        <td>
                            {{ Form::text('pre_enduser_name', $request->pre_enduser_name, ['class' => 'form-control', '']) }}
                        </td>
                        <td class="table-active">当日連絡先</td>
                        <td>
                            {{ Form::text('pre_enduser_mobile', $request->pre_enduser_mobile, ['class' => 'form-control', '']) }}
                            <p class="is-error-pre_enduser_mobile" style="color: red"></p>
                            <p class="annotation mt-1">※半角数字、ハイフンなしで入力下さい。</p>
                        </td>
                    </tr>
                    <tr>
                        <td class="table-active">利用者属性</td>
                        <td>
                            <select name="pre_enduser_attr" class="form-control">
                                <option value="1" {{ $request->pre_enduser_attr == 1 ? 'selected' : '' }}>一般企業</option>
                                <option value="2" {{ $request->pre_enduser_attr == 2 ? 'selected' : '' }}>上場企業</option>
                                <option value="3" {{ $request->pre_enduser_attr == 3 ? 'selected' : '' }}>近隣利用</option>
                                <option value="4" {{ $request->pre_enduser_attr == 4 ? 'selected' : '' }}>個人講師</option>
                                <option value="5" {{ $request->pre_enduser_attr == 5 ? 'selected' : '' }}>MLM</option>
                                <option value="6" {{ $request->pre_enduser_attr == 6 ? 'selected' : '' }}>その他</option>
                            </select>
                            <p class="is-error-pre_enduser_attr" style="color: red"></p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="container-field mt-5">
            <div class="row">
                <div class="col">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <td colspan="2">
                                    <p class="title-icon">
                                        <i class="fas fa-info-circle icon-size"></i>仮押え情報
                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <td class="table-active">利用日</td>
                                <td>

                                    {{ Form::text('reserve_date', $request->reserve_date, ['class' => 'form-control', 'readonly']) }}
                                    <p class="is-error-reserve_date" style="color: red"></p>
                                </td>
                            </tr>
                            <tr>
                                <td class="table-active">会場</td>
                                <td>
                                    {{ Form::text('', ReservationHelper::getVenue($request->venue_id), ['class' => 'form-control', 'readonly']) }}
                                    {{ Form::hidden('venue_id', $request->venue_id, ['class' => 'form-control', 'readonly']) }}

                                    <p class="is-error-venue_id" style="color: red"></p>
                                    <div class="price_selector">
                                        <div>
                                            <small>※料金体系を選択してください</small>
                                        </div>
                                        <div class="price_radio_selector">
                                            @if ($venue->getPriceSystem()[0] == 1 && $venue->getPriceSystem()[1] == 1)
                                                <div class="d-flex justfy-content-start align-items-center">
                                                    {{ Form::radio('price_system', 1, $request->price_system == 1 ? true : false, ['id' => 'price_system_radio1', 'class' => 'mr-2']) }}
                                                    {{ Form::label('price_system_radio1', '通常(枠貸)') }}
                                                </div>
                                                <div class="d-flex justfy-content-start align-items-center">
                                                    {{ Form::radio('price_system', 2, $request->price_system == 2 ? true : false, ['id' => 'price_system_radio2', 'class' => 'mr-2']) }}
                                                    {{ Form::label('price_system_radio2', '音響HG') }}
                                                </div>
                                            @elseif($venue->getPriceSystem()[0] == 1 && $venue->getPriceSystem()[1] == 0)
                                                <div class="d-flex justfy-content-start align-items-center">
                                                    {{ Form::radio('price_system', 1, $request->price_system == 1 ? true : false, ['id' => 'price_system_radio1', 'class' => 'mr-2']) }}
                                                    {{ Form::label('price_system_radio1', '通常(枠貸)') }}
                                                </div>
                                            @elseif($venue->getPriceSystem()[0] == 0 && $venue->getPriceSystem()[1] == 1)
                                                <div class="d-flex justfy-content-start align-items-center">
                                                    {{ Form::radio('price_system', 2, $request->price_system == 2 ? true : false, ['id' => 'price_system_radio2', 'class' => 'mr-2']) }}
                                                    {{ Form::label('price_system_radio2', '音響HG') }}
                                                </div>
                                            @elseif($venue->getPriceSystem()[0] == 0 && $venue->getPriceSystem()[1] == 0)
                                                <div class="d-flex justfy-content-start align-items-center">
                                                    ※登録された料金体系がありません。料金体系を作成し再度仮押さえを作成してください
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="table-active">入室時間</td>
                                <td>
                                    <div>
                                        {{ Form::text('', date('H:i', strtotime($request->enter_time)), ['class' => 'form-control', 'readonly']) }}
                                        {{ Form::hidden('enter_time', $request->enter_time, ['class' => 'form-control', 'readonly']) }}
                                        <p class="is-error-enter_time" style="color: red"></p>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="table-active">退室時間</td>
                                <td>
                                    <div>
                                        {{ Form::text('', date('H:i', strtotime($request->leave_time)), ['class' => 'form-control', 'readonly']) }}
                                        {{ Form::hidden('leave_time', $request->leave_time, ['class' => 'form-control', 'readonly']) }}
                                        <p class="is-error-leave_time" style="color: red"></p>
                                    </div>
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
                                        {{ Form::radio('board_flag', 1, $request->board_flag == 1 ? true : false, ['id' => 'board_flag']) }}
                                        {{ Form::label('board_flag', 'あり') }}
                                    </p>
                                    <p>
                                        {{ Form::radio('board_flag', 0, $request->board_flag == 0 ? true : false, ['id' => 'no_board_flag']) }}
                                        {{ Form::label('no_board_flag', 'なし') }}
                                    </p>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="table-active" id="eventRequired">イベント名称1</td>
                            <td>
                                <div class="align-items-end d-flex">
                                    {{ Form::text('event_name1', !empty($request->event_name1) && !empty($request->board_flag) ? $request->event_name1 : null, ['class' => 'form-control', 'placeholder' => '入力してください', 'id' => 'eventname1Count']) }}
                                    <span class="ml-1 annotation count_num1"></span>
                                </div>
                                <p class="is-error-event_name1" style="color: red"></p>
                            </td>
                        </tr>
                        <tr>
                            <td class="table-active">イベント名称2</td>
                            <td>
                                <div class="align-items-end d-flex">
                                    {{ Form::text('event_name2', !empty($request->event_name2) && !empty($request->board_flag) ? $request->event_name2 : null, ['class' => 'form-control', 'placeholder' => '入力してください', 'id' => 'eventname2Count']) }}
                                    <span class="ml-1 annotation count_num2"></span>
                                </div>
                                <p class="is-error-event_name2" style="color: red"></p>
                            </td>
                        </tr>
                        <tr>
                            <td class="table-active">主催者名</td>
                            <td>
                                <div class="align-items-end d-flex">
                                    {{ Form::text('event_owner', !empty($request->event_owner) && !empty($request->board_flag) ? $request->event_owner : null, ['class' => 'form-control', 'placeholder' => '入力してください', 'id' => 'eventownerCount']) }}
                                    <span class="ml-1 annotation count_num3"></span>
                                </div>
                                <p class="is-error-event_owner" style="color: red"></p>
                            </td>
                        </tr>
                        <tr>
                            <td class="table-active">イベント開始時間</td>
                            <td>
                                <select name="event_start" id="event_start" class="form-control">
                                    @if ($request->board_flag === 0)
                                        {!! ReservationHelper::timeOptionsWithRequestAndLimit($request->enter_time, $request->enter_time, $request->leave_time) !!}
                                    @else
                                        {!! ReservationHelper::timeOptionsWithRequestAndLimit($request->event_start ?? $request->enter_time, $request->enter_time, $request->leave_time) !!}
                                    @endif
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td class="table-active">イベント終了時間</td>
                            <td>
                                <select name="event_finish" id="event_finish" class="form-control">
                                    @if ($request->board_flag === 0)
                                        {!! ReservationHelper::timeOptionsWithRequestAndLimit($request->leave_time, $request->enter_time, $request->leave_time) !!}
                                    @else
                                        {!! ReservationHelper::timeOptionsWithRequestAndLimit($request->event_finish ?? $request->leave_time, $request->enter_time, $request->leave_time) !!}
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
                                @foreach ($venue->getEquipments() as $e_key => $equipment)
                                    <tr>
                                        <td class="table-active">
                                            {{ $equipment->item }}({{ number_format($equipment->price) . '円' }})
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-end">
                                                {{ Form::number('equipment_breakdown' . $e_key, $request->{'equipment_breakdown' . $e_key}, ['class' => 'form-control equipment_validation']) }}
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
                                            <i class="fas fa-hand-holding-heart icon-size"></i>有料サービス
                                        </p>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="accordion-wrap">
                                @foreach ($venue->getServices() as $s_key => $service)
                                    <tr>
                                        <td class="table-active">
                                            {{ $service->item }}({{ number_format($service->price) . '円' }})
                                        </td>
                                        <td>
                                            <div class="radio-box">
                                                <p>
                                                    {{ Form::radio('services_breakdown' . $s_key, 1, $request->{'services_breakdown' . $s_key} == 1 ? true : false, ['id' => 'service' . $s_key . 'on']) }}
                                                    {{ Form::label('service' . $s_key . 'on', 'あり') }}
                                                </p>
                                                <p>
                                                    {{ Form::radio('services_breakdown' . $s_key, 0, $request->{'services_breakdown' . $s_key} == 0 ? true : false, ['id' => 'services_breakdown' . $s_key . 'off']) }}
                                                    {{ Form::label('services_breakdown' . $s_key . 'off', 'なし') }}
                                                </p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>


                    @if ($venue->layout != 0)
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
                                    @if (!empty($venue->getLayouts()[0]))
                                        @if ($venue->getLayouts()[0])
                                            <tr>
                                                <td class="table-active">
                                                    レイアウト準備({{ !empty($venue->layout_prepare) ? number_format($venue->layout_prepare) . '円' : null }})
                                                </td>
                                                <td>
                                                    <div class="radio-box">
                                                        <p>
                                                            {{ Form::radio('layout_prepare', 1, $request->layout_prepare == 1 ? true : false, ['id' => 'layout_prepare']) }}
                                                            {{ Form::label('layout_prepare', 'あり') }}
                                                        </p>
                                                        <p>
                                                            {{ Form::radio('layout_prepare', 0, $request->layout_prepare == 0 ? true : false, ['id' => 'no_layout_prepare']) }}
                                                            {{ Form::label('no_layout_prepare', 'なし') }}
                                                        </p>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endif
                                    @endif
                                    @if (!empty($venue->getLayouts()[1]))
                                        @if ($venue->getLayouts()[1])
                                            <tr>
                                                <td class="table-active">
                                                    レイアウト片付({{ !empty($venue->layout_clean) ? number_format($venue->layout_clean) . '円' : null }})
                                                </td>
                                                <td>
                                                    <div class="radio-box">
                                                        <p>
                                                            {{ Form::radio('layout_clean', 1, $request->layout_clean == 1 ? true : false, ['id' => 'layout_clean']) }}
                                                            {{ Form::label('layout_clean', 'あり') }}
                                                        </p>
                                                        <p>
                                                            {{ Form::radio('layout_clean', 0, $request->layout_clean == 0 ? true : false, ['id' => 'no_layout_clean']) }}
                                                            {{ Form::label('no_layout_clean', 'なし') }}
                                                        </p>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endif
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    @endif



                    @if ($venue->luggage_flag != 0)
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
                                    @if ($venue->getLuggage() == 1)
                                        <tr>
                                            <td class="table-active">荷物預かり</td>
                                            <td>
                                                <div class="radio-box">
                                                    <p>
                                                        {{ Form::radio('luggage_flag', 1, (int) $request->luggage_flag === 1 ? true : false, ['id' => 'luggage_flag', 'class' => '']) }}
                                                        {{ Form::label('luggage_flag', 'あり') }}
                                                    </p>
                                                    <p>
                                                        {{ Form::radio('luggage_flag', 0, (int) $request->luggage_flag === 0 ? true : false, ['id' => 'no_luggage_flag', 'class' => '']) }}
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
                                                {{ Form::number('luggage_count', (int) $request->luggage_flag === 1 ? $request->luggage_count : '', ['class' => 'form-control', 'id' => 'luggage_count', 'min' => 0]) }}
                                                <p class='is-error-luggage_count' style=' color: red'></p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="table-active">事前荷物の到着日<br>(平日午前指定)</td>
                                            <td>
                                                {{ Form::text('luggage_arrive', (int) $request->luggage_flag === 1 ? $request->luggage_arrive : '', ['class' => 'form-control holidays', 'id' => 'luggage_arrive']) }}
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
                                                {{ Form::number('luggage_return', (int) $request->luggage_flag === 1 ? $request->luggage_return : '', ['class' => 'form-control', 'id' => 'luggage_return', 'min' => 0]) }}
                                                <p class='is-error-luggage_return' style=' color: red'></p>
                                                <div class="mt-1 luggage_info">
                                                ※返送時の「発送伝票（元払）/返送伝票（着払）」は会場内に用意しているものを必ず使用して下さい。
                                            </div>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    @endif

                    @if ($venue->eat_in_flag == 1)
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
                                            {{ Form::radio('eat_in', 1, $request->eat_in == 1 ? true : false, ['id' => 'eat_in']) }}
                                            {{ Form::label('eat_in', 'あり') }}
                                        </td>
                                        <td>
                                            {{ Form::radio('eat_in_prepare', 1, $request->eat_in_prepare == 1 ? true : false, ['id' => 'eat_in_prepare', '']) }}
                                            {{ Form::label('eat_in_prepare', '手配済み') }}
                                            {{ Form::radio('eat_in_prepare', 2, $request->eat_in_prepare == 2 ? true : false, ['id' => 'eat_in_consider', '']) }}
                                            {{ Form::label('eat_in_consider', '検討中') }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            {{ Form::radio('eat_in', 0, $request->eat_in == 0 ? true : false, ['id' => 'no_eat_in']) }}
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
                    <table class="table table-bordered sale-table">
                        <tbody>
                            <tr>
                                <td colspan="2">
                                    <p class="title-icon">
                                        <i class="fas fa-yen-sign icon-size" aria-hidden="true"></i>エンドユーザーからの入金額(レイアウト料金は含まない)
                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <td class="table-active form_required">
                                    <label for="end_user_charge ">支払い料</label>
                                </td>
                                <td>
                                    <div class="d-flex align-items-end">
                                        {{ Form::text('end_user_charge', $request->end_user_charge, ['class' => 'form-control']) }}
                                        <span class="ml-1">円</span>
                                    </div>
                                    <p class="is-error-end_user_charge" style="color: red"></p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    @if ($venue->alliance_flag == 1)
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
                                            {{ Form::text('cost', $request->cost, ['class' => 'form-control', 'placeholder' => '入力してください']) }}
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
                                    {{ Form::textarea('admin_details', $request->admin_details, ['class' => 'form-control', 'placeholder' => '入力してください']) }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


        {{ Form::hidden('agent_id', $request->agent_id) }}
        {{ Form::submit('再計算する', ['class' => 'btn more_btn4_lg mx-auto d-block my-5', 'id' => 'check_submit']) }}
        {{ Form::close() }}



        {{ Form::open(['url' => '/admin/pre_agent_reservations/store', 'method' => 'POST', 'id' => '']) }}
        @csrf
        {{-- 以下計算結果 --}}
        <div class="bill">
            <div class="bill_head">
                <table class="table bill_table" style="table-layout: fixed">
                    <tbody>
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
                                        {{ number_format(ReservationHelper::taxAndPrice(floor($price + $layout_prepare + $layout_clean))) }}
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
                                <tr>
                                    <td>{{ Form::text('venue_breakdown_item[]', '会場料金', ['class' => 'form-control', 'readonly']) }} </td>
                                    <td>{{ Form::text('venue_breakdown_cost[]', 0, ['class' => 'form-control', 'readonly']) }}</td>
                                    <td>
                                        {{ Form::text('venue_breakdown_count[]', 1, ['class' => 'form-control', 'readonly']) }}
                                    </td>
                                    <td>
                                        {{ Form::text('venue_breakdown_subtotal[]', 0, ['class' => 'form-control', 'readonly']) }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    @if ($request_equipments !== 0 || $request_services !== 0)
                        <div class="equipment billdetails_content">
                            <table class="table table-borderless">
                                <tbody>
                                    <tr>
                                        <td colspan="4">
                                            <h4 class="billdetails_content_ttl">
                                                有料備品・サービス
                                            </h4>
                                        </td>
                                    </tr>
                                </tbody>
                                <tbody class="equipment_head">
                                    <tr>
                                        <td>内容</td>
                                        <td>単価</td>
                                        <td>数量</td>
                                        <td>金額</td>
                                    </tr>
                                </tbody>
                                <tbody class="equipment_main">
                                    @foreach ($venue->getEquipments() as $e_key => $equipment)
                                        @if ($request->{'equipment_breakdown' . $e_key} > 0)
                                            <tr>
                                                <td>
                                                    {{ Form::text('equipment_breakdown_item[]', $equipment->item, ['class' => 'form-control', 'readonly']) }}
                                                </td>
                                                <td>
                                                    {{ Form::text('equipment_breakdown_cost[]', 0, ['class' => 'form-control', 'readonly']) }}
                                                </td>
                                                <td>
                                                    {{ Form::text('equipment_breakdown_count[]', $request->{'equipment_breakdown' . $e_key}, ['class' => 'form-control', 'readonly']) }}
                                                </td>
                                                <td>
                                                    {{ Form::text('equipment_breakdown_subtotal[]', 0, ['class' => 'form-control', 'readonly']) }}
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                    @foreach ($venue->getServices() as $s_key => $service)
                                        @if ($request->{'services_breakdown' . $s_key} > 0)
                                            <tr>
                                                <td>
                                                    {{ Form::text('service_breakdown_item[]', $service->item, ['class' => 'form-control', 'readonly']) }}
                                                </td>
                                                <td>
                                                    {{ Form::text('service_breakdown_cost[]', 0, ['class' => 'form-control', 'readonly']) }}
                                                </td>
                                                <td>
                                                    {{ Form::text('service_breakdown_count[]', $request->{'services_breakdown' . $s_key}, ['class' => 'form-control', 'readonly']) }}
                                                </td>
                                                <td>
                                                    {{ Form::text('service_breakdown_subtotal[]', 0, ['class' => 'form-control', 'readonly']) }}
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    @endif

                    @if ($venue->layout != 0)
                        @if ((int) $request->layout_prepare === 1 || (int) $request->layout_clean === 1)
                            <div class="layout billdetails_content">
                                <table class="table table-borderless">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <h4 class="billdetails_content_ttl">
                                                    レイアウト
                                                </h4>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tbody class="layout_head">
                                        <tr>
                                            <td>内容</td>
                                            <td>単価</td>
                                            <td>数量</td>
                                            <td>金額</td>
                                        </tr>
                                    </tbody>
                                    <tbody class="layout_main">
                                        @if ($request->layout_prepare == 1)
                                            <tr>
                                                <td>{{ Form::text('layout_breakdown_item[]', 'レイアウト準備料金', ['class' => 'form-control', 'readonly']) }}</td>
                                                <td>
                                                    {{ Form::text('layout_breakdown_cost[]', $venue->getLayouts()[0], ['class' => 'form-control', 'readonly']) }}
                                                </td>
                                                <td>{{ Form::text('layout_breakdown_count[]', 1, ['class' => 'form-control', 'readonly']) }}</td>
                                                <td>
                                                    {{ Form::text('layout_breakdown_subtotal[]', $venue->getLayouts()[0], ['class' => 'form-control', 'readonly']) }}
                                                </td>
                                            </tr>
                                        @endif
                                        @if ($request->layout_clean == 1)
                                            <tr>
                                                <td>{{ Form::text('layout_breakdown_item[]', 'レイアウト片付料金', ['class' => 'form-control', 'readonly']) }}</td>
                                                <td>
                                                    {{ Form::text('layout_breakdown_cost[]', $venue->getLayouts()[1], ['class' => 'form-control', 'readonly']) }}
                                                </td>
                                                <td>{{ Form::text('layout_breakdown_count[]', 1, ['class' => 'form-control', 'readonly']) }}</td>
                                                <td>
                                                    {{ Form::text('layout_breakdown_subtotal[]', $venue->getLayouts()[1], ['class' => 'form-control', 'readonly']) }}
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                    @if ($request->layout_prepare == 1 || $request->layout_clean == 1)
                                        <tbody class="layouts_result">
                                            <tr>
                                                <td colspan="3"></td>
                                                <td colspan="1">
                                                    <p class="text-left">合計</p>
                                                    {{ Form::text('layout_price', $layout_total, ['class' => 'form-control', 'readonly']) }}
                                                </td>
                                            </tr>
                                        </tbody>
                                    @endif
                                </table>
                            </div>
                        @endif
                    @endif


                    <div class="bill_total">
                        <table class="table text-right" style="table-layout: fixed;">
                            <tbody>
                                <tr>
                                    <td>小計：</td>
                                    <td>
                                        {{ Form::text('master_subtotal', floor($price + $layout_total), ['class' => 'form-control text-right', 'readonly']) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>消費税：</td>
                                    <td>
                                        {{ Form::text('master_tax', ReservationHelper::getTax(floor($price + $layout_total)), ['class' => 'form-control text-right', 'readonly']) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">合計金額</td>
                                    <td>
                                        {{ Form::text('master_total', ReservationHelper::taxAndPrice(floor($price + $layout_total)), ['class' => 'form-control text-right', 'readonly']) }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>


    {{ Form::hidden('venue_id', $request->venue_id) }}
    {{ Form::hidden('reserve_date', $request->reserve_date) }}
    {{ Form::hidden('agent_id', $request->agent_id) }}
    {{ Form::hidden('price_system', $request->price_system) }}
    {{ Form::hidden('enter_time', $request->enter_time) }}
    {{ Form::hidden('leave_time', $request->leave_time) }}
    {{ Form::hidden('board_flag', $request->board_flag) }}
    {{ Form::hidden('event_start', $request->event_start) }}
    {{ Form::hidden('event_finish', $request->event_finish) }}
    {{ Form::hidden('event_name1', !empty($request->event_name1) && !empty($request->board_flag) ? $request->event_name1 : null) }}
    {{ Form::hidden('event_name2', !empty($request->event_name2) && !empty($request->board_flag) ? $request->event_name2 : null) }}
    {{ Form::hidden('event_owner', !empty($request->event_owner) && !empty($request->board_flag) ? $request->event_owner : null) }}

    {{ Form::hidden('luggage_count', $request->luggage_count) }}
    {{ Form::hidden('luggage_arrive', $request->luggage_arrive) }}
    {{ Form::hidden('luggage_return', $request->luggage_return) }}
    {{ Form::hidden('luggage_price', $request->luggage_price) }}
    {{ Form::hidden('luggage_flag', $request->luggage_flag) }}

    {{ Form::hidden('pre_enduser_company', $request->pre_enduser_company) }}
    {{ Form::hidden('pre_enduser_name', $request->pre_enduser_name) }}
    {{ Form::hidden('pre_enduser_email', $request->pre_enduser_email) }}
    {{ Form::hidden('pre_enduser_mobile', $request->pre_enduser_mobile) }}
    {{ Form::hidden('pre_enduser_tel', $request->pre_enduser_tel) }}
    {{ Form::hidden('end_user_charge', $request->end_user_charge) }}
    {{ Form::hidden('attention', $request->attention) }}
    {{ Form::hidden('user_details', $request->user_details) }}
    {{ Form::hidden('admin_details', $request->admin_details) }}

    {{ Form::hidden('pre_enduser_attr', $request->pre_enduser_attr, ['class' => 'form-control', 'readonly']) }}
    {{ Form::hidden('pre_enduser_address', $request->pre_enduser_address, ['class' => 'form-control', 'readonly']) }}

    {{ Form::hidden('eat_in_prepare', $request->eat_in_prepare) }}
    {{ Form::hidden('eat_in', $request->eat_in) }}
    {{ Form::hidden('cost', $request->cost) }}



    {{ Form::submit('登録する', ['class' => 'btn more_btn_lg d-block btn-lg mx-auto my-5', 'id' => 'check_submit']) }}
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
                    // 追加時内容クリア
                    $(this).parent().parent().next().find('td').find('input, select').eq(0).val('');
                    $(this).parent().parent().next().find('td').find('input, select').eq(1).val('');
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
                        }
                    }
                });
            });
        })

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
