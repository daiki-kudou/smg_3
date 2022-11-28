@extends('layouts.reservation.app')
@section('content')

    @include('layouts.user.overlay')

    <link href="{{ asset('/css/template.css') }}" rel="stylesheet">
    <script src="{{ asset('/js/edit_luggage_date.js') }}"></script>

    <div class="contents">
        <div class="pagetop-text">
            <h1 class="page-title oddcolor"><span>入力内容</span></h1>
        </div>
    </div>
    <section class="contents">
        <h2>予約1</h2>

        {{ Form::open(['url' => '/user/reservations/store_session', 'method' => 'POST', 'id' => '', 'autocomplete' => 'off']) }}
        <div class="bgColorGray first">
            <table>
                <tr>
                    <th>利用日</th>
                    <td>
                        {{ ReservationHelper::formatDate($request->date) }}
                    </td>
                </tr>
                <tr>
                    <th>利用時間</th>
                    <td>
                        <ul class="form-cell">
                            <li class="form-cell">
                                <p>入室</p>
                                <p>{{ ReservationHelper::formatTime($request->enter_time) }}</p>
                            </li>
                            <li>～</li>
                            <li class="form-cell">
                                <p>退室</p>
                                <p>{{ ReservationHelper::formatTime($request->leave_time) }}</p>
                            </li>
                        </ul>
                    </td>
                </tr>
                <tr>
                    <th>利用会場</th>
                    <td>
                        {{ ReservationHelper::getVenueForUser($request->venue_id) }}
                        {{ Form::hidden('venue_id', $request->venue_id) }}
                    </td>
                </tr>
                <tr>
                    <th>当日連絡できる担当者名</th>
                    <td>
                        {{ $request->in_charge }}
                        {{ Form::hidden('in_charge', $request->in_charge) }}
                        <br class="spOnlyunder">
                        <a name="a-nam" class="error-r"></a>
                    </td>
                </tr>
                <tr>
                    <th>当日連絡できる担当者携帯</th>
                    <td>
                        {{ $request->tel }}
                        {{ Form::hidden('tel', $request->tel) }}
                        <br class="spOnlyunder">
                        <a name="a-nam" class="error-r"></a>
                    </td>
                </tr>

                @if ($request->price_system == 2)
                    <tr>
                        <th>音響ハイグレード</th>
                        <td class="">
                            <ul>
                                <li>
                                    {{ $request->price_system == 1 ? 'しない' : 'する' }}
                                </li>
                            </ul>
                            <a name="a-selectTime1" class="error-r"></a>
                        </td>
                    </tr>
                @endif
                {{ Form::hidden('price_system', $request->price_system) }}
                <tr>
                    <th>案内板</th>
                    <td class="">
                        <ul>
                            <li>
                                {{ $request->board_flag == 1 ? 'あり' : 'なし' }}
                                {{ Form::hidden('board_flag', $request->board_flag) }}
                            </li>
                            @if ($request->board_flag == 1)
                                <li class="cell-margin">
                                    <div class="m-b10">
                                        <p>【イベント名称1】</p>
                                        {{ $request->event_name1 }}
                                        {{ Form::hidden('event_name1', $request->event_name1) }}
                                    </div>
                                    <div class="m-b10">
                                        <p>【イベント名称2】</p>
                                        {{ $request->event_name2 }}
                                        {{ Form::hidden('event_name2', $request->event_name2) }}
                                    </div>
                                    <div class="m-b10">
                                        <p>【主催者名】</p>
                                        {{ $request->event_owner }}
                                        {{ Form::hidden('event_owner', $request->event_owner) }}
                                    </div>
                                    <ul class="">
                                        <li class="m-b10">
                                            <p>【イベント開始時間】</p>
                                            {{ ReservationHelper::formatTime($request->event_start) }}
                                            {{ Form::hidden('event_start', $request->event_start) }}
                                        </li>
                                        <li>
                                            <p>【イベント終了時間】</p>
                                            {{ ReservationHelper::formatTime($request->event_finish) }}
                                            {{ Form::hidden('event_finish', $request->event_finish) }}
                                        </li>
                                    </ul>
                                </li>
                            @endif
                    </td>
                    </li>
                    </ul>
                    </td>
                </tr>

                @if ($venue->eat_in_flag != 0)
                    <tr>
                        <th>室内飲食</th>
                        <td>
                            <p>
                                {{ $request->eat_in == 1 ? 'あり：' : 'なし' }}
                                {{ Form::hidden('eat_in', $request->eat_in) }}
                                <span>
                                    @if ($request->eat_in == 1)
                                        @if ($request->eat_in_prepare == 1)
                                            手配済み
                                            {{ Form::hidden('eat_in_prepare', $request->eat_in_prepare) }}
                                        @else
                                            検討中
                                            {{ Form::hidden('eat_in_prepare', $request->eat_in_prepare) }}
                                        @endif
                                    @endif
                                </span>
                            </p>
                        </td>
                    </tr>
                @endif



                @if ($venue->getEquipments()->count() != 0)
                    <tr>
                        <th>有料備品</th>
                        <td class="spec-space">
                            <ul>
                                @foreach ($venue->getEquipments() as $e_key => $eqpt)
                                    @if ($request->{'equipment_breakdown' . $e_key} == 0 || $request->{'equipment_breakdown' . $e_key} == '')
                                        @continue
                                    @else
                                        <li class="form-cell4">
                                            <p class="text5">{{ $eqpt->item }}<br>{{ number_format($eqpt->price) }}円<span class="annotation">(税抜)</span></p>
                                            <p class="text4">{{ $request->{'equipment_breakdown' . $e_key} }}個</p>
                                            {{ Form::hidden('equipment_breakdown' . $e_key, $request->{'equipment_breakdown' . $e_key}, ['class' => '']) }}
                                            </p>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </td>
                    </tr>
                @endif

                @if ($venue->getServices()->count() != 0)
                    <tr>
                        <th>有料サービス</th>
                        <td class="spec-space">
                            <ul>
                                @foreach ($venue->getServices() as $s_key => $serv)
                                    @if ($request->{'services_breakdown' . $s_key} != 0)
                                        <li class="form-cell2">
                                            <span class="">{{ $serv->item }} {{ number_format($serv->price) }}円<span class="annotation">(税抜)</span></span>
                                            {{ Form::hidden('services_breakdown' . $s_key, $request->{'services_breakdown' . $s_key}) }}
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </td>
                    </tr>
                @endif


                <tr>
                    @if ((int) $request->layout_prepare === 1 || (int) $request->layout_clean === 1)
                        <th>レイアウト変更</th>
                        <td class="spec-space">
                            <div class="m-b10">
                                <p>レイアウト準備 {{ !empty($venue->layout_prepare) ? '(' . number_format($venue->layout_prepare) . '円)' : '' }}</p>
                                {{ $request->layout_prepare == 1 ? 'あり' : 'なし' }}
                                {{ Form::hidden('layout_prepare', $request->layout_prepare) }}
                                <a name="a-selectTime1" class="error-r"></a>
                            </div>
                    @endif
                    @if ($request->layout_clean == 1)
                        <div class="m-b10">
                            <p>レイアウト片付 {{ !empty($venue->layout_clean) ? '(' . number_format($venue->layout_clean) . '円)' : '' }}</p>
                            {{ $request->layout_clean == 1 ? 'あり' : 'なし' }}
                            {{ Form::hidden('layout_clean', $request->layout_clean) }}
                            <a name="a-selectTime1" class="error-r"></a>
                        </div>
                    @endif
                    </td>
                </tr>

                @if ($venue->getLuggage() != 0)
                    <tr>
                        <th>荷物預かり</th>
                        <td class="spec-space">
                            <div class="m-b10">
                                {{-- 荷物フラグ --}}
                                {{ $request->luggage_flag == 1 ? 'あり' : 'なし' }}
                                {{ Form::hidden('luggage_flag', $request->luggage_flag) }}
                            </div>
                            @if ($request->luggage_flag == 1)
                                <div class="m-b10">
                                    <p>【事前に預かる荷物】</p>
                                    <div class="">
                                        <p class="luggage_space">目安：{{ $request->luggage_count }}個</p>
                                        {{ Form::hidden('luggage_count', $request->luggage_count) }}
                                    </div>
                                </div>
                                <div class="m-b10">
                                    <p>【事前荷物の到着日】</p>
                                    <p>{{ $request->luggage_arrive }}<span id="changeLuggageArriveDate"></span></p>
                                    {{ Form::hidden('luggage_arrive', $request->luggage_arrive, ['id' => 'datepicker2']) }}
                                </div>
                                <div class="m-b10">
                                    <p>【事後返送する荷物】</p>
                                    <div class="">
                                        <p class="luggage_space">目安：{{ $request->luggage_return }}個</p>
                                        {{ Form::hidden('luggage_return', $request->luggage_return) }}
                                    </div>
                                </div>
                                <a name="a-baggagedate" class="error-r"></a>
                            @endif
                        </td>
                    </tr>
                @endif


                <tr>
                    <th>備考</th>
                    <td>
                        <p col='30' rows='10'>{!! nl2br(e($request->remark)) !!}</p>
                        {{ Form::hidden('remark', $request->remark) }}
                        <a name="a-nam" class="error-r"></a>
                    </td>
                </tr>
            </table>
        </div>

        <div class="section-wrap">
            <table class="table-sum">
                <thead>
                    <tr>
                        <th colspan="2">
                            料金内訳
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th class=""><label for="date">利用日</label></th>
                        <td>
                            <ul class="sum-list">
                                <li>
                                    <p>{{ ReservationHelper::formatDate($request->date) }}</p>
                                    {{ Form::hidden('date', date('Y-m-d', strtotime($request->date))) }}
                                </li>
                            </ul>
                        </td>
                    </tr>
                    <tr>
                        <th class=""><label for="venueFee">会場料金</label></th>
                        <td>
                            <ul class="sum-list">
                                <li>
                                    <p>
                                    会場料金
                                    {{ Form::hidden('enter_time', $request->enter_time) }}
                                    {{ Form::hidden('leave_time', $request->leave_time) }}
                                    {{-- 料金の内訳を固定で表示のため、時間の出力を非表示
                                        {{ ReservationHelper::formatTime($request->enter_time) }}
                                        {{ Form::hidden('enter_time', $request->enter_time) }}
                                        ～
                                        {{ ReservationHelper::formatTime($request->leave_time) }}
                                        {{ Form::hidden('leave_time', $request->leave_time) }}
                                    --}}
                                    </p>
                                    <p>{{ number_format($price_result[0] - $price_result[1]) }}<span>円</span></p>
                                    {{ Form::hidden('venue_breakdown_item[]', '会場料金') }}
                                    {{ Form::hidden('venue_breakdown_cost[]', $price_result[0] - $price_result[1]) }}
                                    {{ Form::hidden('venue_breakdown_count[]', 1) }}
                                    {{ Form::hidden('venue_breakdown_subtotal[]', $price_result[0] - $price_result[1]) }}
                                </li>
                                @if ($price_result[1] != 0)
                                    <li>
                                        <p>延長料金</p>
                                        {{-- 延長料金の内訳を固定で表示のため、時間の出力を非表示 
                                            <p>延長{{ $price_result[4] }}h</p>
                                        --}}
                                        <p>{{ number_format($price_result[1]) }}<span>円</span></p>
                                        {{ Form::hidden('venue_breakdown_item[]', '延長料金') }}
                                        {{ Form::hidden('venue_breakdown_cost[]', $price_result[1]) }}
                                        {{ Form::hidden('venue_breakdown_count[]', 1) }}
                                        {{ Form::hidden('venue_breakdown_subtotal[]', $price_result[1]) }}
                                    </li>
                                @endif
                            </ul>
                        </td>
                    </tr>

                    @if (ReservationHelper::checkEquipmentBreakdowns($request->all()) != 0)
                        <tr>
                            <th class=""><label for="equipment">有料備品</label></th>
                            <td>
                                <ul class="sum-list">
                                    @foreach ($items_results[1] as $i_key => $item_result)
                                        <li>
                                            <p>{{ $item_result[0] }}<span>×</span><span>{{ $item_result[2] }}</span></p>
                                            <p>
                                                {{ number_format(ReservationHelper::numTimesNum($item_result[1], $item_result[2])) }}
                                                <span>円</span>
                                            </p>
                                            {{ Form::hidden('equipment_breakdown_item[]', $item_result[0]) }}
                                            {{ Form::hidden('equipment_breakdown_cost[]', $item_result[1]) }}
                                            {{ Form::hidden('equipment_breakdown_count[]', $item_result[2]) }}
                                            {{ Form::hidden('equipment_breakdown_subtotal[]', ReservationHelper::numTimesNum($item_result[1], $item_result[2])) }}
                                        </li>
                                    @endforeach
                                </ul>
                            </td>
                        </tr>
                    @endif
                    @if (ReservationHelper::checkServiceBreakdowns($request->all()) != 0 || $request->luggage_flag || $request->luggage_count || $request->luggage_arrive || $request->luggage_return)
                        <tr>
                            <th class=""><label for="service">有料サービス</label></th>
                            <td>
                                <ul class="sum-list">
                                    @foreach ($items_results[2] as $s_key => $service_result)
                                        <li>
                                            <p>{{ $service_result[0] }}</p>
                                            <p>{{ number_format($service_result[1]) }}<span>円</span></p>
                                        </li>
                                        {{ Form::hidden('service_breakdown_item[]', $service_result[0]) }}
                                        {{ Form::hidden('service_breakdown_cost[]', $service_result[1]) }}
                                        {{ Form::hidden('service_breakdown_count[]', $service_result[2]) }}
                                        {{ Form::hidden('service_breakdown_subtotal[]', ReservationHelper::numTimesNum($service_result[1], $service_result[2])) }}
                                    @endforeach
                                    @if ($request->luggage_flag)
                                        <li>
                                            <p>荷物預かり</p>
                                            <p>500<span>円</span></p>
                                        </li>
                                        {{ Form::hidden('service_breakdown_item[]', '荷物預かり') }}
                                        {{ Form::hidden('service_breakdown_cost[]', 500) }}
                                        {{ Form::hidden('service_breakdown_count[]', 1) }}
                                        {{ Form::hidden('service_breakdown_subtotal[]', 500) }}
                                    @endif
                                </ul>
                            </td>
                        </tr>
                    @endif

                    @if ((int) $request->layout_prepare !== 0 || (int) $request->layout_clean !== 0)
                        <tr>
                            <th class=""><label for="service">レイアウト変更</label></th>
                            <td>
                                <ul class="sum-list">
                                    @if ($request->layout_prepare == 1)
                                        <li>
                                            <p>レイアウト準備料金</p>
                                            <p>{{ number_format($venue->layout_prepare) }}<span>円</span></p>
                                            {{ Form::hidden('layout_breakdown_item[]', 'レイアウト準備料金') }}
                                            {{ Form::hidden('layout_breakdown_cost[]', $venue->layout_prepare) }}
                                            {{ Form::hidden('layout_breakdown_count[]', 1) }}
                                            {{ Form::hidden('layout_breakdown_subtotal[]', $venue->layout_prepare) }}
                                        </li>
                                    @endif
                                    @if ($request->layout_clean == 1)
                                        <li>
                                            <p>レイアウト片付料金</p>
                                            <p>{{ number_format($venue->layout_clean) }}<span>円</span></p>
                                            {{ Form::hidden('layout_breakdown_item[]', 'レイアウト片付料金') }}
                                            {{ Form::hidden('layout_breakdown_cost[]', $venue->layout_clean) }}
                                            {{ Form::hidden('layout_breakdown_count[]', 1) }}
                                            {{ Form::hidden('layout_breakdown_subtotal[]', $venue->layout_clean) }}
                                        </li>
                                    @endif
                                </ul>
                            </td>
                        </tr>
                    @endif

                    <tr>
                        <td colspan="2" class="text-right">
                            <p class="checkbox-txt"><span>小計(税抜)</span><span class="">{{ number_format($master) }}</span>円</p>
                            <p class=""><span>消費税</span>{{ number_format(ReservationHelper::getTax($master)) }}円</p>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" class="">
                            <span>合計金額</span>
                            <span class="sumText">{{ number_format(ReservationHelper::taxAndPrice($master)) }}</span><span>円</span>
                            <p class="txtRed txtLeft">
                                ※上記「総額」は確定金額ではありません。
                                変更が生じる場合は、弊社にて金額修正し、改めて確認のご連絡をさせて頂きます。<br>
                                ※荷物預かりサービスをご利用の場合、上記「総額」に規定のサービス料金が加算されます。
                            </p>
                    </tr>
                </tbody>
            </table>
        </div>

        <ul class="btn-wrapper">
            <li>
                <div id="back" class="link-btn">修正する</button>
            </li>
            <li>
                {{ Form::hidden('price_result', json_encode($price_result)) }}
                {{ Form::hidden('items_results', json_encode($items_results)) }}
                {{ Form::hidden('master', $master) }}
                {{ Form::hidden('select_id', $request->select_id) }}
                {{ Form::hidden('cost', $request->cost ?? 0) }}
                {{ Form::submit('カートに入れる', ['class' => 'confirm-btn', 'style' => 'width:100%;', 'name' => 'store']) }}
            </li>
        </ul>
        {{ Form::close() }}
    </section>

    <form action="{{ url('user/reservations/re_create') }}" method="post" id="backform">
        @csrf
        {{ Form::hidden('venue_id', $request->venue_id) }}
        {{ Form::hidden('in_charge', $request->in_charge) }}
        {{ Form::hidden('tel', $request->tel) }}
        {{ Form::hidden('price_system', $request->price_system) }}
        {{ Form::hidden('board_flag', $request->board_flag) }}
        @if ($request->board_flag == 1)
            {{ Form::hidden('event_name1', $request->event_name1) }}
            {{ Form::hidden('event_name2', $request->event_name2) }}
            {{ Form::hidden('event_owner', $request->event_owner) }}
            {{ Form::hidden('event_start', $request->event_start) }}
            {{ Form::hidden('event_finish', $request->event_finish) }}
        @endif

        @if ($venue->eat_in_flag != 0)
            {{ Form::hidden('eat_in', $request->eat_in) }}
            @if ($request->eat_in == 1)
                @if ($request->eat_in_prepare == 1)
                    {{ Form::hidden('eat_in_prepare', $request->eat_in_prepare) }}
                @else
                    {{ Form::hidden('eat_in_prepare', $request->eat_in_prepare) }}
                @endif
            @endif
        @endif

        @if ($venue->getEquipments()->count() != 0)
            @foreach ($venue->getEquipments() as $e_key => $eqpt)
                @if ($request->{'equipment_breakdown' . $e_key} == 0 || $request->{'equipment_breakdown' . $e_key} == '')
                    @continue
                @else
                    {{ Form::hidden('equipment_breakdown' . $e_key, $request->{'equipment_breakdown' . $e_key}, ['class' => '']) }}
                @endif
            @endforeach
        @endif

        @if ($venue->getServices()->count() != 0)
            @foreach ($venue->getServices() as $s_key => $serv)
                @if ($request->{'services_breakdown' . $s_key} != 0)
                    {{ Form::hidden('services_breakdown' . $s_key, $request->{'services_breakdown' . $s_key}) }}
                @endif
            @endforeach
        @endif

        @if ((int) $request->layout_prepare === 1 || (int) $request->layout_clean === 1)
            {{ Form::hidden('layout_prepare', $request->layout_prepare) }}
        @endif
        @if ($request->layout_clean == 1)
            {{ Form::hidden('layout_clean', $request->layout_clean) }}
        @endif

        @if ($venue->getLuggage() != 0)
            {{ Form::hidden('luggage_flag', $request->luggage_flag) }}
            @if ($request->luggage_flag == 1)
                {{ Form::hidden('luggage_count', $request->luggage_count) }}
                {{ Form::hidden('luggage_arrive', $request->luggage_arrive) }}
                {{ Form::hidden('luggage_return', $request->luggage_return) }}
            @endif
        @endif


        {{ Form::hidden('remark', $request->remark) }}
        {{ Form::hidden('date', date('Y-m-d', strtotime($request->date))) }}

        {{ Form::hidden('enter_time', $request->enter_time) }}
        {{ Form::hidden('leave_time', $request->leave_time) }}
        {{ Form::hidden('venue_breakdown_item[]', '会場料金') }}
        {{ Form::hidden('venue_breakdown_cost[]', $price_result[0] - $price_result[1]) }}
        {{ Form::hidden('venue_breakdown_count[]', 1) }}
        {{ Form::hidden('venue_breakdown_subtotal[]', $price_result[0] - $price_result[1]) }}
        @if ($price_result[1] != 0)
            {{ Form::hidden('venue_breakdown_item[]', '延長料金') }}
            {{ Form::hidden('venue_breakdown_cost[]', $price_result[1]) }}
            {{ Form::hidden('venue_breakdown_count[]', 1) }}
            {{ Form::hidden('venue_breakdown_subtotal[]', $price_result[1]) }}
        @endif

        @if (ReservationHelper::checkEquipmentBreakdowns($request->all()) != 0)
            @foreach ($items_results[1] as $i_key => $item_result)
                {{ Form::hidden('equipment_breakdown_item[]', $item_result[0]) }}
                {{ Form::hidden('equipment_breakdown_cost[]', $item_result[1]) }}
                {{ Form::hidden('equipment_breakdown_count[]', $item_result[2]) }}
                {{ Form::hidden('equipment_breakdown_subtotal[]', ReservationHelper::numTimesNum($item_result[1], $item_result[2])) }}
            @endforeach
        @endif

        @if (ReservationHelper::checkServiceBreakdowns($request->all()) != 0)
            @foreach ($items_results[2] as $s_key => $service_result)
                {{ Form::hidden('service_breakdown_item[]', $service_result[0]) }}
                {{ Form::hidden('service_breakdown_cost[]', $service_result[1]) }}
                {{ Form::hidden('service_breakdown_count[]', $service_result[2]) }}
                {{ Form::hidden('service_breakdown_subtotal[]', ReservationHelper::numTimesNum($service_result[1], $service_result[2])) }}
            @endforeach
            @if ($request->luggage_count || $request->luggage_arrive || $request->luggage_return)
                {{ Form::hidden('service_breakdown_item[]', '荷物預かり') }}
                {{ Form::hidden('service_breakdown_cost[]', 500) }}
                {{ Form::hidden('service_breakdown_count[]', 1) }}
                {{ Form::hidden('service_breakdown_subtotal[]', 500) }}
            @endif
        @endif

        @if ((int) $request->layout_prepare !== 0 || (int) $request->layout_clean !== 0)
            @if ($request->layout_prepare == 1)
                {{ Form::hidden('layout_breakdown_item[]', 'レイアウト準備料金') }}
                {{ Form::hidden('layout_breakdown_cost[]', $venue->layout_prepare) }}
                {{ Form::hidden('layout_breakdown_count[]', 1) }}
                {{ Form::hidden('layout_breakdown_subtotal[]', $venue->layout_prepare) }}
            @endif
            @if ($request->layout_clean == 1)
                {{ Form::hidden('layout_breakdown_item[]', 'レイアウト片付料金') }}
                {{ Form::hidden('layout_breakdown_cost[]', $venue->layout_clean) }}
                {{ Form::hidden('layout_breakdown_count[]', 1) }}
                {{ Form::hidden('layout_breakdown_subtotal[]', $venue->layout_clean) }}
            @endif
        @endif
        {{ Form::hidden('price_result', json_encode($price_result)) }}
        {{ Form::hidden('items_results', json_encode($items_results)) }}
        {{ Form::hidden('master', $master) }}
        {{ Form::hidden('session_reservation_id', $request->select_id) }}
        {{ Form::hidden('cost', $request->cost ?? 0) }}
        {{ Form::hidden('form_back', 1) }}
    </form>

    <div class="top contents"><a href="#top"><img src="https://system.osaka-conference.com/img/pagetop.png" alt="上に戻る"></a>
    </div>

    <script>
        $('input[name="store"]').on('click', function() {
            $('#userFullOverlay').css('display', 'block');
        })

        $('#back').on('click', function() {
            $('#backform').submit();
        })
    </script>
@endsection
