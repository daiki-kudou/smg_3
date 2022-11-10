@extends('layouts.reservation.app')
@section('content')

    @include('layouts.user.overlay')

    <link href="{{ asset('/css/template.css') }}" rel="stylesheet">
    <script src="{{ asset('/js/edit_luggage_date.js') }}"></script>

<div class="contents">
  <div class="pagetop-text">
    <h1 class="page-title oddcolor"><span>下記内容を取り消してもよろしいでしょうか。</span></h1>
  </div>
</div>
<section class="contents">
  {{ Form::open(['url' => '/user/reservations/session_destroy', 'method'=>'POST', 'id'=>'','autocomplete'=>'off',]) }}
  <!-- 予約内容 -------------------------------------------->
  <h2>予約1</h2>
  <div class="bgColorGray">
    <table class="table-box">
      <tr>
        <th>利用日</th>
        <td>
          {{ReservationHelper::formatDate($slctSession[0]['date'])}}
        </td>
      </tr>
      <tr>
        <th>利用時間</th>
        <td>
          <ul class="form-cell">
            <li class="form-cell">
              <p>入室</p>
              <p> {{ReservationHelper::formatTime($slctSession[0]['enter_time'])}} </p>
            </li>
            <li>～</li>
            <li class="form-cell">
              <p>退室</p>
              <p> {{ReservationHelper::formatTime($slctSession[0]['leave_time'])}} </p>
            </li>
          </ul>
        </td>
      </tr>
      <tr>
        <th>利用会場</th>
        <td>
          {{ReservationHelper::getVenueForUser($slctSession[0]['venue_id'])}}
        </td>
      </tr>
      <tr>
        <th>当日連絡できる担当者名</th>
        <td>
          {{$slctSession[0]['in_charge']}}
        </td>
      </tr>
      <tr>
        <th>当日連絡できる担当者携帯</th>
        <td>
          {{$slctSession[0]['tel']}}
        </td>
      </tr>


                    @if ($venue->frame_prices->count() != 0 && $venue->time_prices->count() != 0)
                        <tr>
                            <th>音響ハイグレード</th>
                            <td class="">
                                {{ $slctSession[0]['price_system'] == 2 ? 'する' : 'しない' }}
                            </td>
                        </tr>
                    @else
                        @if ($venue->frame_prices->count() != 0)
                            {{ Form::hidden('price_system', 1) }}
                        @else
                            {{ Form::hidden('price_system', 2) }}
                        @endif
                    @endif
                    <tr>
                        <th>案内板</th>
                        <td>
                            <ul class="from-list">
                                <li>
                                    {{ $slctSession[0]['board_flag'] == 1 ? 'あり' : 'なし' }}
                                </li>
                                @if ($slctSession[0]['board_flag'] == 1)
                                    <li>
                                        <p>イベント名称1</p>
                                        <p>{{ $slctSession[0]['event_name1'] ?? '' }}</p>
                                    </li>
                                    <li>
                                        <p>イベント名称2</p>
                                        <p>{{ $slctSession[0]['event_name2'] ?? '' }}</p>
                                    </li>
                                    <li>
                                        <p>主催者名</p>
                                        <p>{{ $slctSession[0]['event_owner'] ?? '' }}</p>
                                    </li>
                                    <li>
                                        <p>イベント開始時間</p>
                                        <p>{{ ReservationHelper::formatTime($slctSession[0]['event_start'] ?? '') }}</p>
                                    </li>
                                    <li>
                                        <p>イベント終了時間</p>
                                        <p>{{ ReservationHelper::formatTime($slctSession[0]['event_finish'] ?? '') }}</p>
                                    </li>
                                @endif
                        </td>
                    </tr>


                    @if (!empty($slctSession[0]['eat_in']))
                        <tr>
                            <th>室内飲食</th>
                            <td>
                                {{ $slctSession[0]['eat_in'] == 1 ? 'あり：' : 'なし' }}
                                @if ($slctSession[0]['eat_in'] == 1)
                                    @if ($slctSession[0]['eat_in_prepare'] == 1)
                                        手配済み
                                    @else
                                        検討中
                                    @endif
                                @endif
                            </td>
                        </tr>
                    @endif



                    @if (json_decode($slctSession[0]['items_results'])[0] != 0)
                        <tr>
                            <th>有料備品</th>
                            <td class="spec-space">
                                <ul class="option-list">
                                    @foreach (json_decode($slctSession[0]['items_results'])[1] as $equ)
                                        <li class="form-cell2">
                                            <p>{{ $equ[0] }}<span>×</span><span>{{ $equ[2] }}</span></p>
                                            <p>
                                                {{ number_format(ReservationHelper::numTimesNum($equ[1], $equ[2])) }}
                                                <span>円</span>
                                            </p>
                                        </li>
                                    @endforeach
                                </ul>
                            </td>
                        </tr>
                    @endif

                    <tr>
                        <th>有料サービス</th>
                        <td class="spec-space">
                            <ul class="option-list">
                                @foreach (json_decode($slctSession[0]['items_results'])[2] as $ser)
                                    <li>
                                        {{ $ser[0] }} {{ $ser[1] }}円
                                    </li>
                                @endforeach
                            </ul>
                        </td>
                    </tr>

                    @if ($venue->layout != 0)
                        @if (!empty($slctSession[0]['layout_prepare']) && !empty($slctSession[0]['layout_clean']))
                            <tr>
                                <th>レイアウト</th>
                                <td class="spec-space">
                                    <ul class="option-list">
                                        @if ($venue->layout != 0)
                                            <li>
                                                <dl class="form-cell2">
                                                    <dt>レイアウト準備：</dt>
                                                    <dd>
                                                        {{ !empty($slctSession[0]['layout_prepare']) ? 'あり' : 'なし' }}
                                                    </dd>
                                                </dl>
                                                <dl class="form-cell2">
                                                    <dt>レイアウト片付：</dt>
                                                    <dd>
                                                        {{ !empty($slctSession[0]['layout_clean']) ? 'あり' : 'なし' }}
                                                    </dd>
                                                </dl>
                                            </li>
                                        @endif
                                    </ul>
                                </td>
                            </tr>
                        @endif
                    @endif

                    @if ($venue->luggage_flag != 0)
                        @if (!empty($slctSession[0]['luggage_count']) || !empty($slctSession[0]['luggage_arrive']) || !empty($slctSession[0]['luggage_return']))
                            <tr>
                                <th>荷物預かり</th>
                                <td class="spec-space">
                                    <ul class="option-list">
                                        <li>
                                            @if (!empty($slctSession[0]['luggage_count']))
                                                <dl class="form-cell2">
                                                    <dt>事前荷物の個数：</dt>
                                                    <dd>
                                                        {{ $slctSession[0]['luggage_count'] ?? '' }}<span>個</span>
                                                    </dd>
                                                </dl>
                                            @endif
                                            @if (!empty($slctSession[0]['luggage_arrive']))
                                                <dl class="form-cell2">
                                                    <dt>事前荷物の到着日：</dt>
                                                    <dd>
                                                        <p>{{ $slctSession[0]['luggage_arrive'] ?? '' }}<span id="changeLuggageArriveDate"></span></p>
                                                        {{ Form::hidden('luggage_arrive', $slctSession[0]['luggage_arrive'], ['id' => 'datepicker2']) }}
                                                    </dd>
                                                </dl>
                                            @endif
                                            @if (!empty($slctSession[0]['luggage_return']))
                                                <dl class="form-cell2">
                                                    <dt>事後返送する荷物の個数：</dt>
                                                    <dd>
                                                        {{ $slctSession[0]['luggage_return'] ?? '' }}
                                                        <span>個</span>
                                                    </dd>
                                                </dl>
                                            @endif
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                        @endif
                    @endif
                    <tr>
                        <th>備考</th>
                        <td>
                            {{ $slctSession[0]['remark'] }}
                        </td>
                    </tr>
                </tbody>
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
                                    <p> {{ ReservationHelper::formatDate($slctSession[0]['date']) }}
                                    </p>
                                </li>
                            </ul>
                        </td>
                    </tr>
                    <tr>
                        <th class=""><label for="venueFee">会場料金</label></th>
                        <td>
                            <ul class="sum-list">
                                @if ($slctSession[0]['enter_time'][1] == 0)
                                    <li>
                                        <p>
                                        会場料金
                                        {{-- 料金の内訳を固定で表示のため、時間の出力を非表示
                                        {{ ReservationHelper::formatTime($slctSession[0]['enter_time']) }}
                                            ～
                                            {{ ReservationHelper::formatTime($slctSession[0]['leave_time']) }}
                                        --}}
                                        </p>

                                        <p>{{ number_format(json_decode($slctSession[0]['price_result'])[0]) }}<span>円</span></p>
                                    </li>
                                @else
                                    <li>
                                        <p>
                                            会場料金
                                            {{-- 料金の内訳を固定で表示のため、時間の出力を非表示
                                            {{ ReservationHelper::formatTime($slctSession[0]['enter_time']) }}
                                            ～
                                            {{ ReservationHelper::formatTime($slctSession[0]['leave_time']) }}
                                            --}}
                                        </p>
                                        <p>{{ number_format(json_decode($slctSession[0]['price_result'])[0]) }}<span>円</span></p>
                                    </li>
                                    <li>
                                        <p>延長料金</p>
                                         {{--<p>延長{{ json_decode($slctSession[0]['price_result'])[4] }}h</p>--}}
                                        <p>{{ number_format(json_decode($slctSession[0]['price_result'])[1]) }}<span>円</span></p>
                                    </li>
                                @endif

                            </ul>
                        </td>
                    </tr>

                    <tr>
                        <th class=""><label for="equipment">有料備品</label></th>
                        <td>
                            <ul class="sum-list">
                                @foreach (json_decode($slctSession[0]['items_results'])[1] as $b_equ)
                                    <li>
                                        <p>{{ $b_equ[0] }}<span>×</span><span>{{ $b_equ[2] }}</span></p>
                                        <p>{{ number_format(ReservationHelper::numTimesNum($b_equ[1], $b_equ[2])) }}<span>円</span></p>
                                    </li>
                                @endforeach
                            </ul>
                        </td>
                    </tr>

                    <tr>
                        <th class=""><label for="service">有料サービス</label></th>
                        <td>
                            <ul class="sum-list">
                                @foreach (json_decode($slctSession[0]['items_results'])[2] as $b_ser)
                                    <li>
                                        <p>{{ $b_ser[0] }}</p>
                                        <p>{{ number_format($b_ser[1]) }}<span>円</span></p>
                                    </li>
                                @endforeach
                                @if ($slctSession[0]['luggage_flag'])
                                    <li>
                                        <p>荷物預かり/返送</p>
                                        <p>500<span>円</span></p>
                                    </li>
                                @endif
                            </ul>
                        </td>
                    </tr>


                    @if ($venue->layout != 0)
                        <tr>
                            <th class=""><label for="service">レイアウト</label></th>
                            <td>
                                <ul class="sum-list">
                                    @if (!empty($slctSession[0]['layout_prepare']))
                                        <li>
                                            <p>レイアウト準備料金</p>
                                            <p>{{ $venue->getLayouts()[0] }}<span>円</span></p>
                                        </li>
                                    @endif
                                    @if (!empty($slctSession[0]['layout_clean']))
                                        <li>
                                            <p>レイアウト片付料金</p>
                                            <p>{{ $venue->getLayouts()[1] }}<span>円</span></p>
                                        </li>
                                    @endif
                                </ul>
                            </td>
                        </tr>
                    @endif

                    <tr>
                        <td colspan="2" class="text-right">
                            <p class="checkbox-txt"><span>小計(税抜)</span>{{ number_format($slctSession[0]['master']) }}<span>円</span></p>
                            <p class="checkbox-txt"><span>消費税</span>
                                {{ number_format(ReservationHelper::getTax($slctSession[0]['master'])) }}<span>円</span></p>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" class="text-right">
                            <span class="checkbox-txt">合計金額(税込)</span>
                            <span class="sumText">
                                {{ number_format(ReservationHelper::taxAndPrice($slctSession[0]['master'])) }}</span>
                            <span class="checkbox-txt">円</span>
                            <p class="txtRed txtLeft">
                                ※上記「総額」は確定金額ではありません。
                                変更が生じる場合は、弊社にて金額修正し、改めて確認のご連絡をさせて頂きます。<br>
                                ※荷物預かりサービスをご利用の場合、上記「総額」に規定のサービス料金が加算されます。
                            </p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- 予約内容 終わり------------------------------------------->
        <!-- 総合計金額 --------------------------------------------------------->
        <div class="section-wrap">
            <ul class="btn-wrapper">
                <li>
                    <p><a class="link-btn" href="{{ url('/user/reservations/cart') }}">カートに戻る</a></p>
                </li>
                <li>
                    {{ Form::hidden('session_reservation_id', $session_id) }}
                    <p>{{ Form::submit('取り消す', ['class' => 'btn confirm-btn']) }}</p>
                </li>
            </ul>
        </div>
        {{ Form::close() }}
    </section>
    <div class="top contents"><a href="#top"><img src="https://system.osaka-conference.com/img/pagetop.png" alt="上に戻る"></a>
    </div>

    <script>
        $('input[type="submit"]').on('click', function() {
            $('#userFullOverlay').css('display', 'block');
        })
    </script>

@endsection
