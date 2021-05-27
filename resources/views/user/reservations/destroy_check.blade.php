@extends('layouts.reservation.app')
@section('content')
<main>
  <!-- ログイン、会員登録 -->
  <div class="contents">
    <div class="pagetop-text">
      <h1 class="page-title oddcolor"><span>予約の取り消し</span></h1>
      <p>
        下記の予約を取り消してもよろしいでしょうか。
      </p>
    </div>
  </div>
  <section class="contents">

    <!-- 予約内容 -------------------------------------------->
    <h2>予約1</h2>
    <form name="form" id="form" action="https://osaka-conference.com/contact/check.php" next="false" method="post">
      <div class="bgColorGray">
        <table class="table-box">
          <tr>
            <th>利用日</th>
            <td>
              {{$slctSession[0]['date']}}
            </td>
          </tr>
          <tr>
            <th>利用時間</th>
            <td>
              <ul class="form-cell">
                <li class="form-cell">
                  <p>入室</p>
                  <p> {{$slctSession[0]['enter_time']}} </p>
                </li>
                <li>～</li>
                <li class="form-cell">
                  <p>退室</p>
                  <p> {{$slctSession[0]['leave_time']}} </p>
                </li>
              </ul>
            </td>
          </tr>
          <tr>
            <th>利用会場</th>
            <td>
              {{$slctSession[0]['venue_id']}}
            </td>
          </tr>
          <tr>
            <th>当日の担当者</th>
            <td>
              {{$slctSession[0]['in_charge']}}
            </td>
          </tr>
          <tr>
            <th>当日の担当者連絡先</th>
            <td>
              {{$slctSession[0]['tel']}}
            </td>
          </tr>
          <tr>
            <th>音響ハイグレード</th>
            <td class="">
              {{$slctSession[0]['price_system']}}
            </td>
          </tr>
          <tr>
            <th>案内板</th>
            <td>
              <ul class="from-list">
                <li>
                  {{$slctSession[0]['board_flag']}}
                </li>
                <li>
                  <p>イベント名称1行目</p>
                  <p>{{$slctSession[0]['event_name1']}}</p>
                </li>
                <li>
                  <p>イベント名称2行目</p>
                  <p>{{$slctSession[0]['event_name2']}}</p>
                </li>
                <li>
                  <p>主催者名</p>
                  <p>{{$slctSession[0]['event_owner']}}</p>
                </li>
                <li>
                  <p>イベント開始時間</p>
                  <p>{{$slctSession[0]['event_start']}}</p>
                </li>
                <li>
                  <p>イベント終了時間</p>
                  <p>{{$slctSession[0]['event_finish']}}</p>
                </li>
            </td>
          </tr>

          <tr>
            <th>室内飲食</th>
            <td>
              あり
            </td>
          </tr>


          @if (json_decode($slctSession[0]["items_results"])[0]!=0)
          <tr>
            <th>有料備品</th>
            <td class="spec-space">
              <ul class="option-list">
                @foreach (json_decode($slctSession[0]['items_results'])[1] as $equ)
                <li class="form-cell2">
                  <p>{{$equ[0]}}<span>×</span><span>{{$equ[2]}}</span></p>
                  <p>
                    {{number_format(ReservationHelper::numTimesNum($equ[1], $equ[2]))}}
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
                  {{$ser[0]}} {{$ser[1]}}円
                </li>
                @endforeach

                <li>
                  {{-- <p>
                    荷物預り/返送
                  </p> --}}
                  <dl class="form-cell2">
                    <dt>事前荷物の個数：</dt>
                    <dd>
                      {{$slctSession[0]['luggage_count']}}<span>個</span>
                    </dd>
                  </dl>
                  <dl class="form-cell2">
                    <dt>事前荷物の到着日：</dt>
                    <dd>
                      {{$slctSession[0]['luggage_arrive']}}
                    </dd>
                  </dl>
                  <dl class="form-cell2">
                    <dt>事後返送する荷物の個数：</dt>
                    <dd>
                      工藤さん！こちらお願いします。<span>個</span>
                    </dd>
                  </dl>
                </li>
                <li>
                  <dl class="form-cell2">
                    <dt>レイアウト準備：</dt>
                    <dd>
                      {{!empty($slctSession[0]['layout_prepare'])?"あり":"なし"}}
                    </dd>
                  </dl>
                  <dl class="form-cell2">
                    <dt>レイアウト片付：</dt>
                    <dd>
                      {{!empty($slctSession[0]['layout_clean'])?"あり":"なし"}}
                    </dd>
                  </dl>
                </li>
              </ul>
            </td>
          </tr>
          <tr>
            <th>備考</th>
            <td>
              {{$slctSession[0]['remark']}}
            </td>
          </tr>
        </table>
      </div>
    </form>

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
                  <p> {{$slctSession[0]['luggage_arrive']}}
                  </p>
                  <p>{{ReservationHelper::getVenueForUser($slctSession[0]['venue_id'])}}</p>
                </li>
              </ul>
            </td>
          </tr>
          <tr>
            <th class=""><label for="venueFee">会場料金</label></th>
            <td>
              <ul class="sum-list">
                @if ($slctSession[0]['enter_time'][1]==0)
                <li>
                  <p>{{ReservationHelper::formatTime($slctSession[0]['enter_time'])}}
                    ～
                    {{ReservationHelper::formatTime($slctSession[0]['leave_time'])}}</p>
                  <p>{{number_format(json_decode($slctSession[0]["price_result"])[0])}}<span>円</span></p>
                </li>
                @else
                <li>
                  <p>{{ReservationHelper::formatTime($slctSession[0]['enter_time'])}}
                    ～
                    {{ReservationHelper::formatTime($slctSession[0]['leave_time'])}}</p>
                  <p>{{json_decode($slctSession[0]["price_result"])[0]}}<span>円</span></p>
                </li>
                <li>
                  <p>延長{{json_decode($slctSession[0]["price_result"])[4]}}h</p>
                  <p>{{number_format(json_decode($slctSession[0]["price_result"])[1])}}<span>円</span></p>
                </li>
                @endif

              </ul>
            </td>
          </tr>

          <tr>
            <th class=""><label for="equipment">有料備品</label></th>
            <td>
              <ul class="sum-list">
                @foreach (json_decode($slctSession[0]["items_results"])[1] as $b_equ)
                <li>
                  <p>{{$b_equ[0]}}<span>×</span><span>{{$b_equ[2]}}</span></p>
                  <p>{{number_format(ReservationHelper::numTimesNum($b_equ[1],$b_equ[2]))}}<span>円</span></p>
                </li>
                @endforeach
              </ul>
            </td>
          </tr>

          <tr>
            <th class=""><label for="service">有料サービス</label></th>
            <td>
              <ul class="sum-list">
                @foreach (json_decode($slctSession[0]["items_results"])[2] as $b_ser)
                <li>
                  <p>{{$b_ser[0]}}</p>
                  <p>{{$b_ser[1]}}<span>円</span></p>
                </li>
                @endforeach
              </ul>
            </td>
          </tr>

          <tr>
            <th class=""><label for="service">レイアウト</label></th>
            <td>
              <ul class="sum-list">
                @if (!empty($slctSession[0]['layout_prepare']))
                <li>
                  <p>レイアウト準備料金</p>
                  <p>{{$venue->getLayouts()[0]}}<span>円</span></p>
                </li>
                @endif
                @if (!empty($slctSession[0]['layout_clean']))
                <li>
                  <p>レイアウト片付料金</p>
                  <p>{{$venue->getLayouts()[1]}}<span>円</span></p>
                </li>
                @endif
              </ul>
            </td>
          </tr>

          <tr>
            <td colspan="2" class="text-right">
              <p class="checkbox-txt"><span>小計</span>{{number_format($slctSession[0]['master'])}}円</p>
              <p class="checkbox-txt"><span>消費税</span>
                {{number_format(ReservationHelper::getTax($slctSession[0]['master']))}}円</p>
            </td>
          </tr>
          <tr>
            <td colspan="2" class="text-right checkbox-txt"><span>合計金額</span>
              <span class="sumText">
                {{number_format(ReservationHelper::taxAndPrice($slctSession[0]['master']))}}
              </span><span>円</span>
              <p class="txtRight">※上記合計金額にケータリングは入っておりません。<br>
                ※お申込み内容によっては、弊社からご連絡の上で、合計金額が変更となる場合がございます</p>
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
          <p><a class="link-btn" href="{{url('user/reservations/cart')}}">予約一覧にもどる</a></p>
        </li>
        <li>
          {{ Form::open(['url' => 'user/reservations/session_destroy', 'method'=>'POST', 'id'=>'']) }}
          {{ Form::hidden("session_reservation_id",$session_id )}}
          <p>{{Form::submit('予約を取り消す', ['class' => 'btn confirm-btn'])}}</p>
          {{Form::close()}}
        </li>
      </ul>

    </div>
  </section>
  <div class="top contents"><a href="#top"><img src="https://osaka-conference.com/img/pagetop.png" alt="上に戻る"></a>
  </div>
</main>
@endsection