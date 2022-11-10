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
        <h2 class="mt-3 mb-3">仮押え 詳細入力画面 （仲介会社）</h2>
        <hr>
    </div>


    {{ Form::open(['url' => '/admin/pre_agent_reservations/calculate', 'method' => 'POST', 'id' => 'pre_agent_reservationsSingleCheckForm', 'autocomplete' => 'off']) }}
    @csrf

    <section class="mt-5">
        <div class="selected_user">
            <table class="table table-bordered" style="table-layout: fixed;">
                <thead>
                    <tr>
                        <th>仲介会社情報</th>
                        <th colspan="3">仲介会社ID：<p class="user_id d-inline">{{ ReservationHelper::fixId($request->agent_id) }}</p>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="table-active">会社名・団体名</td>
                        <td colspan="3">
                            <p class="company">
                                {{ ReservationHelper::getAgentCompany($request->agent_id) }}
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td class="table-active">担当者氏名</td>
                        <td>
                            <p class="person">
                                {{ ReservationHelper::getAgentPerson($request->agent_id) }}
                            </p>
                        </td>
                        <td class="table-active">メールアドレス</td>
                        <td>
                            <p class="email">
                                {{ ReservationHelper::getAgentEmail($request->agent_id) }}
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td class="table-active">携帯番号</td>
                        <td>
                            <p class="mobile">
                                {{ ReservationHelper::getAgentMobile($request->agent_id) }}
                            </p>
                        </td>
                        <td class="table-active">固定電話</td>
                        <td>
                            <p class="tel">
                                {{ ReservationHelper::getAgentTel($request->agent_id) }}
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
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        {{-- 以下、詳細入力 --}}
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
                                    {{ Form::text('reserve_date', $request->pre_date0, ['class' => 'form-control', 'readonly']) }}
                                    <p class="is-error-reserve_date" style="color: red"></p>
                                </td>
                            </tr>
                            <tr>
                                <td class="table-active">会場</td>
                                <td>
                                    {{ Form::text('', ReservationHelper::getVenue($request->pre_venue0), ['class' => 'form-control', 'readonly']) }}
                                    {{ Form::hidden('venue_id', $request->pre_venue0, ['class' => 'form-control', 'readonly']) }}

                                    <p class="is-error-venue_id" style="color: red"></p>
                                    <div class="price_selector">
                                        <div>
                                            <small>※料金体系を選択してください</small>
                                        </div>
                                        <div class="form-check">
                                            @if ($venue->getPriceSystem()[0] == 1 && $venue->getPriceSystem()[1] == 1)
                                                <p>
                                                    {{ Form::radio('price_system', 1, true, ['id' => 'price_system', 'class' => 'form-check-input']) }}
                                                    {{ Form::label('price_system', '通常(枠貸)') }}
                                                </p>
                                                <p>
                                                    {{ Form::radio('price_system', 2, false, ['id' => 'price_system_off', 'class' => 'form-check-input']) }}
                                                    {{ Form::label('price_system_off', '音響HG') }}
                                                </p>
                                            @elseif($venue->getPriceSystem()[0] == 1 && $venue->getPriceSystem()[1] == 0)
                                                <p>
                                                    {{ Form::radio('price_system', 1, true, ['id' => 'price_system', 'class' => 'form-check-input']) }}
                                                    {{ Form::label('price_system', '通常(枠貸)') }}
                                                </p>
                                            @elseif($venue->getPriceSystem()[0] == 0 && $venue->getPriceSystem()[1] == 1)
                                                <p>
                                                    {{ Form::radio('price_system', 2, true, ['id' => 'price_system_off', 'class' => 'form-check-input']) }}
                                                    {{ Form::label('price_system_off', '音響HG') }}
                                                </p>
                                            @elseif($venue->getPriceSystem()[0] == 0 && $venue->getPriceSystem()[1] == 0)
                                                <p>
                                                    ※登録された料金体系がありません。料金体系を作成し再度仮押さえを作成してください
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="table-active">入室時間</td>
                                <td>
                                    <div>
                                        {{ Form::text('', date('H:i', strtotime($request->pre_enter0)), ['class' => 'form-control', 'readonly']) }}
                                        {{ Form::hidden('enter_time', $request->pre_enter0, ['class' => 'form-control', 'readonly']) }}
                                        <p class="is-error-enter_time" style="color: red"></p>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="table-active">退室時間</td>
                                <td>
                                    <div>
                                        {{ Form::text('', date('H:i', strtotime($request->pre_leave0)), ['class' => 'form-control', 'readonly']) }}
                                        {{ Form::hidden('leave_time', $request->pre_leave0, ['class' => 'form-control', 'readonly']) }}

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
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="table-active">案内板</td>
                            <td>
                                <div class="radio-box">
                                    <p>
                                        {{ Form::radio('board_flag', 1, false, ['id' => 'board_flag']) }}
                                        {{ Form::label('board_flag', 'あり') }}
                                    </p>
                                    <p>
                                        {{ Form::radio('board_flag', 0, true, ['id' => 'no_board_flag']) }}
                                        {{ Form::label('no_board_flag', 'なし') }}
                                    </p>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="table-active">イベント名称1</td>
                            <td>
                                <div class="align-items-end d-flex">
                                    {{ Form::text('event_name1', '', ['class' => 'form-control', 'placeholder' => '入力してください', 'id' => 'eventname1Count']) }}
                                    <span class="ml-1 annotation count_num1"></span>
                                </div>
                                <p class="is-error-event_name1" style="color: red"></p>
                            </td>
                        </tr>
                        <tr>
                            <td class="table-active">イベント名称2</td>
                            <td>
                                <div class="align-items-end d-flex">
                                    {{ Form::text('event_name2', '', ['class' => 'form-control', 'placeholder' => '入力してください', 'id' => 'eventname2Count']) }}
                                    <span class="ml-1 annotation count_num2"></span>
                                </div>
                                <p class="is-error-event_name2" style="color: red"></p>
                            </td>
                        </tr>
                        <tr>
                            <td class="table-active">主催者名</td>
                            <td>
                                <div class="align-items-end d-flex">
                                    {{ Form::text('event_owner', '', ['class' => 'form-control', 'placeholder' => '入力してください', 'id' => 'eventownerCount']) }}
                                    <span class="ml-1 annotation count_num3"></span>
                                </div>
                                <p class="is-error-event_owner" style="color: red"></p>
                            </td>
                        </tr>
                        <tr>
                            <td class="table-active">イベント開始時間</td>
                            <td>
                                <div>
                                    <select name="event_start" id="event_start" class="form-control">
                                        <option disabled>選択してください</option>
                                        {!! ReservationHelper::timeOptionsWithRequestAndLimit($request->pre_enter0, $request->pre_enter0, $request->pre_leave0) !!}
                                    </select>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="table-active">イベント終了時間</td>
                            <td>
                                <div>
                                    <select name="event_finish" id="event_finish" class="form-control">
                                        <option disabled>選択してください</option>
                                        {!! ReservationHelper::timeOptionsWithRequestAndLimit($request->pre_leave0, $request->pre_enter0, $request->pre_leave0) !!}
                                    </select>
                                </div>
                            </td>
                        </tr>
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
                            <tbody class="accordion-wrap">
                                @foreach ($venue->getEquipments() as $key => $equipment)
                                    <tr>
                                        <td class="table-active">
                                            {{ $equipment->item }}({{ number_format($equipment->price) . '円' }})
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-end">
                                                {{ Form::number('equipment_breakdown' . $key, '', ['class' => 'form-control equipment_validation']) }}
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
                                @foreach ($venue->getServices() as $key => $service)
                                    <tr>
                                        <td class="table-active">
                                            {{ $service->item }}({{ number_format($service->price) . '円' }})
                                        </td>
                                        <td>
                                            <div class="radio-box">
                                                <p>
                                                    {{ Form::radio('services_breakdown' . $key, 1, false, ['id' => 'service' . $key . 'on']) }}
                                                    {{ Form::label('service' . $key . 'on', 'あり') }}
                                                </p>
                                                <p>
                                                    {{ Form::radio('services_breakdown' . $key, 0, true, ['id' => 'services_breakdown' . $key . 'off']) }}
                                                    {{ Form::label('services_breakdown' . $key . 'off', 'なし') }}
                                                </p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="layouts">
                        <table class="table table-bordered">
                            @if ($venue->getLayouts() != 0)
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
                                    @if ($venue->getLayouts()[0])
                                        <tr>
                                            <td class="table-active">
                                                レイアウト準備({{ !empty($venue->layout_prepare) ? number_format($venue->layout_prepare) . '円' : null }})
                                            </td>
                                            <td>
                                                <div class="radio-box">
                                                    <p>
                                                        {{ Form::radio('layout_prepare', 1, false, ['id' => 'layout_prepare']) }}
                                                        {{ Form::label('layout_prepare', 'あり') }}
                                                    </p>
                                                    <p>
                                                        {{ Form::radio('layout_prepare', 0, true, ['id' => 'no_layout_prepare']) }}
                                                        {{ Form::label('no_layout_prepare', 'なし') }}
                                                    </p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endif
                                    @if ($venue->getLayouts()[1])
                                        <tr>
                                            <td class="table-active">
                                                レイアウト片付({{ !empty($venue->layout_clean) ? number_format($venue->layout_clean) . '円' : null }})
                                            </td>
                                            <td>
                                                <div class="radio-box">
                                                    <p>
                                                        {{ Form::radio('layout_clean', 1, false, ['id' => 'layout_clean']) }}
                                                        {{ Form::label('layout_clean', 'あり') }}
                                                    </p>
                                                    <p>
                                                        {{ Form::radio('layout_clean', 0, true, ['id' => 'no_layout_clean']) }}
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
                    <div class="luggage">
                        <table class="table table-bordered">
                            @if ($venue->getLuggage() == 1)
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
                                                    {{ Form::radio('luggage_flag', 1, false, ['id' => 'luggage_flag', 'class' => '']) }}
                                                    {{ Form::label('luggage_flag', 'あり') }}
                                                </p>
                                                <p>
                                                    {{ Form::radio('luggage_flag', 0, true, ['id' => 'no_luggage_flag', 'class' => '']) }}
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
                                            {{ Form::number('luggage_count', '', ['class' => 'form-control', 'id' => 'luggage_count', 'min' => 0]) }}
                                            <p class='is-error-luggage_count' style=' color: red'></p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="table-active">事前荷物の到着日<br>(平日午前指定)</td>
                                        <td>
                                            {{ Form::text('luggage_arrive', '', ['class' => 'form-control holidays', 'id' => 'luggage_arrive']) }}
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
                                            {{ Form::number('luggage_return', '', ['class' => 'form-control', 'id' => 'luggage_return', 'min' => 0]) }}
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
                                            {{ Form::radio('eat_in', 1, false, ['id' => 'eat_in']) }}
                                            {{ Form::label('eat_in', 'あり') }}
                                        </td>
                                        <td>
                                            {{ Form::radio('eat_in_prepare', 1, true, ['id' => 'eat_in_prepare', 'disabled']) }}
                                            {{ Form::label('eat_in_prepare', '手配済み') }}
                                            {{ Form::radio('eat_in_prepare', 2, false, ['id' => 'eat_in_consider', 'disabled']) }}
                                            {{ Form::label('eat_in_consider', '検討中') }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            {{ Form::radio('eat_in', 0, true, ['id' => 'no_eat_in']) }}
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
                                        {{ Form::text('end_user_charge', '', ['class' => 'form-control']) }}
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
                                    <td class="d-flex align-items-center">
                                        {{ Form::text('cost', $venue->cost, ['class' => 'form-control', 'placeholder' => '入力してください']) }}
                                        <span class="ml-2">%</span>
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
                                    {{ Form::textarea('admin_details', '', ['class' => 'form-control', 'placeholder' => '入力してください']) }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <div class="submit_btn">
        <div class="d-flex justify-content-center">
            {{-- 単発仮押えか？一括仮押えか？ --}}
            {{ Form::hidden('judge_count', 1) }}
            {{-- ユーザー --}}
            {{ Form::hidden('agent_id', $request->agent_id) }}
            @if ($venue->getPriceSystems() == 0)
                <div class="">
                    <p class="d-block">選択された会場は料金が設定されていません。会場管理/料金管理に戻り設定してください</p>
                    <a href="{{ url('/admin/frame_prices') }}" class="btn more_btn_lg mt-5 d-flex justify-content-center">料金管理画面へ</a>
                </div>
            @else
                {{ Form::submit('計算する', ['class' => 'btn more_btn_lg mx-auto d-block', 'id' => 'check_submit']) }}
            @endif
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


    <script>
        $(document).on(' click', '.holidays', function() {
            getHolidayCalendar($('.holidays'), $('input[name="reserve_date"]'));
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
