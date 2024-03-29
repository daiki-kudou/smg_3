@extends('layouts.reservation.app')
@section('content')

    <script src="{{ asset('/js/user_reservation/validation.js') }}"></script>

    <div id="fullOverlay">
        <div class="spinner">
            <div class="loader">Loading...</div>
        </div>
    </div>


    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- カート一覧 -->

    <div class="contents">
        <div class="pagetop-text">
            <h1 class="page-title oddcolor"><span>予約カート</span></h1>
            <p>下記内容をご確認の上、本ページ下部の「予約申込をする」ボタンを押し、申込手続きを完了させて下さい。<br>
                <span class="txtRed">※複数日程の申込みをされる場合は「日程を追加する」ボタンを押して予約内容を追加作成して下さい。</span><br>
                <span class="txtRed">※本カート内の予約内容は作成後2時間を過ぎた時点で削除されます。</span>
            </p>
        </div>
    </div>

    <section class="contents">
        <!-- 予約内容 -------------------------------------------->
        @if (empty($sessions))
            <div style="margin-top:100px;margin-bottom:200px;">
                <h2>選択されている予約はありません</h2>
            </div>
        @else
            @foreach ($sessions as $key => $reservation)
                <div class="section-wrap">
                    <div class="cart-wrap">
                        <table class="table-sum">
                            <thead>
                                <tr>
                                    <th colspan="2">
                                        <div class="cart-header">
                                            <h3>予約{{ (int) $loop->index + 1 }}</h3>
                                            <ul>
                                                <li>
                                                    {{ Form::open(['url' => '/user/reservations/destroy_check', 'method' => 'POST', 'id' => '','autocomplete'=>'off',]) }}
                                                    {{ Form::hidden('session_reservation_id', $key) }}
                                                    <p>{{ Form::submit('取消', ['class' => 'confirm-btn']) }}</p>
                                                    {{ Form::close() }}
                                                </li>
                                                <li>
                                                    {{ Form::open(['url' => '/user/reservations/re_create', 'method' => 'POST', 'id' => '','autocomplete'=>'off',]) }}
                                                    {{ Form::hidden('session_reservation_id', $key) }}
                                                    <p>{{ Form::submit('編集', ['class' => 'link-btn3']) }}</p>
                                                    {{ Form::close() }}
                                                </li>
                                            </ul>
                                        </div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th class=""><label for="date">利用日</label></th>
                                    <td>
                                        <ul class="sum-list">
                                            <li>
                                                <p class="f-wb">
                                                    {{ ReservationHelper::formatDateJA($reservation[0]['date']) }}
                                                </p>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                                <tr>
                                    <th class=""><label for="date">会場</label></th>
                                    <td>
                                        <ul class="sum-list">
                                            <li>
                                                <p>
                                                    {{ ReservationHelper::getVenueForUser((int) $reservation[0]['venue_id']) }}{{ $reservation[0]['price_system'] == 2 ? '(音響HG)' : '' }}
                                                </p>
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
                                                {{-- 料金の内訳を固定で表示のため、時間の出力を非表示
                                                    {{ ReservationHelper::formatTime($reservation[0]['enter_time']) }}
                                                    ～
                                                    {{ ReservationHelper::formatTime($reservation[0]['leave_time']) }}
                                                 --}}
                                                </p>
                                                <p>
                                                    {{ number_format(ReservationHelper::jsonDecode($reservation[0]['price_result'])[0] - ReservationHelper::jsonDecode($reservation[0]['price_result'])[1]) }}<span>円</span>
                                                </p>
                                            </li>
                                            @if (ReservationHelper::jsonDecode($reservation[0]['price_result'])[1] != 0)
                                                <li>
                                                <p>延長料金</p>
                                                {{-- 長料金の内訳を固定で表示のため、時間の出力を非表示 
                                                    <p>延長{{ ReservationHelper::jsonDecode($reservation[0]['price_result'])[4] }}h
                                                --}}
                                                    </p>
                                                    <p>
                                                        {{ number_format(ReservationHelper::jsonDecode($reservation[0]['price_result'])[1]) }}<span>円</span>
                                                    </p>
                                                </li>
                                            @endif
                                        </ul>
                                    </td>
                                </tr>
                                @if (!empty(ReservationHelper::DBLJsonDecode($reservation[0]['items_results'])[1]))
                                    <tr>
                                        <th class=""><label for="equipment">有料備品</label></th>
                                        <td>
                                            <ul class="sum-list">
                                                @foreach ((object) ReservationHelper::DBLJsonDecode($reservation[0]['items_results'])[1] as $equ)
                                                    <li>
                                                        <p>{{ $equ[0] }}<span>×</span><span>{{ $equ[2] }}</span>
                                                            個</p>
                                                        <p>{{ number_format(ReservationHelper::numTimesNum($equ[1], $equ[2])) }}<span>円</span>
                                                        </p>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </td>
                                    </tr>
                                @endif
                                @if (!empty(ReservationHelper::DBLJsonDecode($reservation[0]['items_results'])[2]) || !empty($reservation[0]['luggage_flag']))
                                    <tr>
                                        <th class=""><label for="service">有料サービス</label></th>
                                        <td>
                                            <ul class="sum-list">
                                                @foreach ((object) ReservationHelper::DBLJsonDecode($reservation[0]['items_results'])[2] as $ser)
                                                    <li>
                                                        <p>{{ $ser[0] }}</p>
                                                        <p>{{ $ser[1] }}<span>円</span></p>
                                                    </li>
                                                @endforeach
                                                @if (optional($reservation[0])['luggage_flag'] || optional($reservation[0])['luggage_count'] || optional($reservation[0])['luggage_arrive'] || optional($reservation[0])['luggage_return'])
                                                    <li>
                                                        <p>荷物預かり</p>
                                                        <p>500<span>円</span></p>
                                                    </li>
                                                @endif
                                            </ul>
                                        </td>
                                    </tr>
                                @endif
                                @if (!empty($reservation[0]['layout_prepare']) || !empty($reservation[0]['layout_clean']))
                                    <tr>
                                        <th class=""><label for="service">レイアウト</label></th>
                                        <td>
                                            <ul class="sum-list">
                                                @if (!empty($reservation[0]['layout_prepare']))
                                                    <li>
                                                        <p>レイアウト準備料金</p>
                                                        <p>
                                                            {{ number_format(ReservationHelper::getLayoutPrice($reservation[0]['venue_id'])[0]) }}<span>円</span>
                                                        </p>
                                                    </li>
                                                @endif
                                                @if (!empty($reservation[0]['layout_clean']))
                                                    <li>
                                                        <p>レイアウト片付料金</p>
                                                        <p>
                                                            {{ number_format(ReservationHelper::getLayoutPrice($reservation[0]['venue_id'])[1]) }}<span>円</span>
                                                        </p>
                                                    </li>
                                                @endif
                                            </ul>
                                        </td>
                                    </tr>
                                @endif
                                <tr>

                                    <td colspan="2" class="text-right checkbox-txt"><span>小計(税抜)</span>
                                        <span class="sumText">{{ number_format($reservation[0]['master']) }}</span><span>円</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            @endforeach
        @endif

        @if (!empty($sessions))
            <div class="section-wrap">
                <table class="table-sum">
                    <thead>
                        <tr>
                            <th colspan="3">
                                <h3>総合計(<span>{{ count($sessions) }}</span><span>件</span>)</h3>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sessions as $t_key => $t_reservation)
                            <tr>
                                <th class="">
                                    <label for="date">予約{{ (int) $loop->index + 1 }}</label>
                                </th>
                                <td>
                                    <ul class="sum-list">
                                        <li>
                                            <p><span
                                                    class="f-wb">{{ ReservationHelper::formatDateJA($t_reservation[0]['date']) }}</span><br
                                                    class="sp">
                                                 {{ReservationHelper::getVenueForUser($t_reservation[0]["venue_id"])}}{{ $t_reservation[0]['price_system'] === '2' ? '(音響HG)' : '' }}
                                                 会場ご利用料
                                            </p>
                                            <p>{{ number_format($t_reservation[0]['master']) }}<span>円</span></p>
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="2">
                                <p class="checkbox-txt">
                                    <span>小計(税抜)</span>
                                    {{ number_format(ReservationHelper::numTimesNumArrays($sessions, 'master')) }}<span>円</span>
                                </p>
                                <p class="">
                                    <span>消費税</span>
                                    {{ number_format(ReservationHelper::getTax(ReservationHelper::numTimesNumArrays($sessions, 'master'))) }}円
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <span class="checkbox-txt">合計金額(税込)</span>
                                <span class="sumText">{{ number_format(ReservationHelper::taxAndPrice(ReservationHelper::numTimesNumArrays($sessions, 'master'))) }}</span>
                                <span>円</span>
                                <p class="txtRed txtLeft">
                                ※上記「総額」は確定金額ではありません。
                                変更が生じる場合は、弊社にて金額修正し、改めて確認のご連絡をさせて頂きます。<br>
                                ※荷物預かりサービスをご利用の場合、上記「総額」に規定のサービス料金が加算されます。
                                </p>
                            </td>
                        </tr>
                    </tbody>
                </table>

                {{ Form::open(['url' => '/user/reservations/store', 'method' => 'POST', 'id' => 'cartConfirm','autocomplete'=>'off',]) }}

                <dl class="attention-txt">
                    <dt>【今後の流れ】</dt>
                    <dd>本ページの「予約申込をする」ボタンをクリック後に自動メールが送信されます。
                        メールが到着しない場合は再度お申し込みをいただくか、弊社までご連絡下さい。
                    </dd>
                    <dd>
                        弊社で受付が完了しましたら「予約完了連絡」をお送りします。<br>
                        <span class="txtRed">弊社からの予約完了連絡が到着した時点で「予約完了（予約確定）」となります。</span>
                    </dd>
                    <dd>
                        原則として予約完了後の「キャンセル」「変更」にはキャンセル料金が発生します。申込前に「<a target="_blank" rel="noopener noreferrer"
                            href="https://system.osaka-conference.com/cancelpolicy/">キャンセルポリシー</a>」
                        をご確認下さい。
                    </dd>
                    <dd class="caution-area">
                        <div class="page-text">
                            <a target="_blank" rel="noopener noreferrer"
                                href="{{ asset('/img/terms_of_service.pdf') }}">利用規約</a>と利用の流れについての同意
                            <p class="checkbox-txt">
                                <label><input id="" name="policy" type="checkbox" value="">同意する</label>
                            <p class="is-error-policy" style="color: red"></p>
                            </p>
                        </div>
                    </dd>
                </dl>
                <dl class="attention-txt">
                    <dt>【個人情報の取り扱いについて】</dt>
                    <dd>当フォームにご入力いただく内容は、弊社が責任を持って保管し、その他の目的に使用いたしません。また、許可なく第三者に提供することはございません。個人情報の取り扱いに関しては、<a target="_blank" rel="noopener noreferrer"
                            href="https://system.osaka-conference.com/privacypolicy/">プライバシーポリシー</a>をご確認下さい。</dd>
                </dl>

                <div class="btn-center">
                    <p>{{ Form::submit('予約申込をする', ['class' => 'confirm-btn', 'id' => 'master_submit']) }}</p>
                    {{ Form::close() }}
                </div>

                <p class="cart-addbtn"><a class="link-btn3" href="{{ url('/') }}">日程を<br>追加する</a></p>

            </div>
        @endif

    </section>
    <div class="top contents"><a href="#top"><img src="https://system.osaka-conference.com/img/pagetop.png"
                alt="上に戻る"></a>
    </div>


@endsection
