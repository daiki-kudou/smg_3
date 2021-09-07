@extends('layouts.reservation.app')
@section('content')


<div id="fullOverlay">
  <div class="spinner">
    <div class="loader">Loading...</div>
  </div>
</div>


  <!-- カート一覧 -->
  <div class="contents">
    <div class="pagetop-text">
      <h1 class="page-title oddcolor"><span>カート</span></h1>
      <p>下記内容をご確認の上、本ページ下部の「予約申し込みをする」ボタンを押し、申込手続きを完了させてください。</p>
      <p class="txtRed">※複数日程の申込をされる場合は「日程を追加する」ボタンを押して予約内容を追加作成して下さい。</p>
      <p class="txtRed">※本カート内の予約内容は作成後○○時間を過ぎた時点で削除されます。</p>
    </div>
  </div>

  <section class="contents">
    <!-- 予約内容 -------------------------------------------->
    @if (empty($sessions))
    <div style="margin-top:100px;margin-bottom:200px;">
      <h2>選択されている予約はありません</h2>
    </div>
    @else
    @foreach ($sessions as $key=>$reservation)
    
    <div class="cart-wrap">
      <table class="table-sum">
        <thead>
          <tr>
            <th colspan="2">
              <div class="cart-header">
                <h3>予約{{(int) $loop->index+1}}</h3>
                <ul>
                  <li>
                    {{ Form::open(['url' => 'user/reservations/destroy_check', 'method'=>'POST', 'id'=>'']) }}
                    {{ Form::hidden("session_reservation_id",$key )}}
                    {{Form::submit('取消', ['class' => 'confirm-btn'])}}
                    {{Form::close()}}
                  </li>
                  <li>
                    {{ Form::open(['url' => 'user/reservations/re_create', 'method'=>'POST', 'id'=>'']) }}
                    {{ Form::hidden("session_reservation_id",$key )}}
                    {{Form::submit('編集', ['class' => 'link-btn3'])}}
                    {{Form::close()}}
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
              <ul class="sum-list f-wb">
                <li>
                  <p>
                    {{ReservationHelper::formatDateJA($reservation[0]['date'])}}
                  </p>
                </li>
              </ul>
            </td>
          </tr>
          <tr>
            <th>会場</th>
            <td class="txtLeft">{{ReservationHelper::getVenueForUser($reservation[0]['venue_id'])}}</td>
          </tr>
          <tr>
            <th class=""><label for="venueFee">会場料金</label></th>
            <td>
              <ul class="sum-list">
                <li>
                  <p>
                    {{ReservationHelper::formatTime($reservation[0]['enter_time'])}}
                    ～
                    {{ReservationHelper::formatTime($reservation[0]['leave_time'])}}
                  </p>
                  <p>
                    {{number_format(ReservationHelper::jsonDecode($reservation[0]['price_result'])[0])}}<span>円</span>
                  </p>
                </li>
                @if (ReservationHelper::jsonDecode($reservation[0]['price_result'])[1]!=0)
                <li>
                  <p>延長{{ReservationHelper::jsonDecode($reservation[0]['price_result'])[4]}}h</p>
                  <p>
                    {{number_format(ReservationHelper::jsonDecode($reservation[0]['price_result'])[1])}}<span>円</span>
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
                @foreach ((object)ReservationHelper::DBLJsonDecode($reservation[0]['items_results'])[1] as $equ)
                <li>
                  <p>{{$equ[0]}}<span>×</span><span>{{$equ[2]}}</span> 個</p>
                  <p>{{number_format(ReservationHelper::numTimesNum($equ[1],$equ[2]))}}<span>円</span></p>
                </li>
                @endforeach
              </ul>
            </td>
          </tr>
          @endif

          @if (!empty(ReservationHelper::DBLJsonDecode($reservation[0]['items_results'])[2]))
          <tr>
            <th class=""><label for="service">有料サービス</label></th>
            <td>
              <ul class="sum-list">
                @foreach ((object)ReservationHelper::DBLJsonDecode($reservation[0]['items_results'])[2] as $ser)
                <li>
                  <p>{{$ser[0]}}</p>
                  <p>{{$ser[1]}}<span>円</span></p>
                </li>
                @endforeach
                @if($reservation[0]['luggage_count']||$reservation[0]['luggage_arrive']||$reservation[0]['luggage_return'])
                <li>
                  <p>荷持預り/返送</p>
                  <p>500<span>円</span></p>
                </li>
                @endif
              </ul>
            </td>
          </tr>
          @endif


          @if (!empty($reservation[0]['layout_prepare'])||!empty($reservation[0]['layout_clean']))
          <tr>
            <th class=""><label for="service">レイアウト</label></th>
            <td>
              <ul class="sum-list">
                @if (!empty($reservation[0]['layout_prepare']))
                <li>
                  <p>レイアウト準備料金</p>
                  <p>
                    {{number_format(ReservationHelper::getLayoutPrice($reservation[0]['venue_id'])[0])}}<span>円</span>
                  </p>
                </li>
                @endif
                @if (!empty($reservation[0]['layout_clean']))
                <li>
                  <p>レイアウト片付料金</p>
                  <p>
                    {{number_format(ReservationHelper::getLayoutPrice($reservation[0]['venue_id'])[1])}}<span>円</span>
                  </p>
                </li>
                @endif
              </ul>
            </td>
          </tr>
          @endif


          <tr>
            <td colspan="2" class="text-right">
              <p><span class="f-wb m-r10">小計(税抜)</span><span class="caution-text">{{number_format($reservation[0]['master'])}}</span><span class="f-wb">円</span></p>
              {{-- <p class="checkbox-txt">
                <span>消費税</span>{{number_format(ReservationHelper::getTax($reservation[0]['master']))}}<span>円</span>
              </p> --}}
            </td>
          </tr>
          {{-- <tr>
            <td colspan="2" class="text-right">
              <span class="checkbox-txt">合計金額(税込)</span>
              <span class="sumText">{{number_format(ReservationHelper::taxAndPrice($reservation[0]['master']))}}</span>
              <span>円</span>
            </td>
          </tr> --}}
        </tbody>
      </table>

    </div>
    @endforeach
    @endif

    @if (!empty($sessions))
    <div class="section-wrap">
      <table class="table-sum totalsum-table">
        <thead>
          <tr>
            <th colspan="3">
              <p>総合計(<span>{{count($sessions)}}</span><span>件</span>)</p>
            </th>
          </tr>
        </thead>
        <tbody>
          @foreach ($sessions as $t_key=>$t_reservation)
          <tr>
            <th class="">
              予約{{(int) $loop->index+1}}
            </th>
            <td>
              <ul class="sum-list">
                <li>
                  <p><span class="f-wb">{{ReservationHelper::formatDateJA($t_reservation[0]["date"])}}</span> <br class="sp">{{ReservationHelper::getVenueForUser($t_reservation[0]["venue_id"])}} 会場ご利用料</p>
                  <p>{{number_format($t_reservation[0]['master'])}}<span>円</span></p>
                </li>
              </ul>
            </td>
          </tr>
          @endforeach
          <tr>
            <td colspan="2">
                <p class="checkbox-txt"><span>小計(税抜)</span>
                {{number_format(ReservationHelper::numTimesNumArrays($sessions, "master"))}}<span>円</span>
              </p>
              <p class="checkbox-txt"><span>消費税</span>
                {{number_format(ReservationHelper::getTax(ReservationHelper::numTimesNumArrays($sessions, "master")))}}<span>円</span>
              </p>
            </td>
          </tr>
          <tr>
            <td colspan="2">
              <span class="checkbox-txt">総額(税込)</span>
              <span class="sumText">
                {{number_format(ReservationHelper::taxAndPrice(ReservationHelper::numTimesNumArrays($sessions, "master")))}}
              </span>
              <span class="checkbox-txt">円</span>
              <p class="txtRight txtRed">
                ※上記「総額」は確定金額ではありません。<br>
                変更が生じる場合は弊社にて金額を修正し、改めて確認のご連絡をさせて頂きます。</p>
              <p class="txtRight txtRed">※荷物預かりサービスをご利用の場合、上記「総額」に既定のサービス料金が加算されます。</p>
            </td>
          </tr>
        </tbody>
      </table>

      <dl class="attention-txt">
        <dt>【今後の流れ】</dt>
        <dd>本ページの「予約申込をする」ボタンをクリック後に自動メールが送信されます。メールが到着しない場合は再度お申込を頂くか、弊社までご連絡下さい。</dd>
        <dd>弊社で受付が完了しましたら、「予約完了連絡」をお送りします。<br>
        <span class="f-c1">弊社からの予約完了連絡が到着した時点で「予約完了(予約確定)」となります。</span>
        </dd>
        <dd>原則として予約完了後の「キャンセル」「変更」にはキャンセル料金が発生します。申込前に「<a href="https://osaka-conference.com/cancelpolicy/">キャンセルポリシー</a>」をご確認下さい。</dd>
        <div class="page-text caution-area">
          <p class="checkbox-txt">
            <input class="" id="" name="flowcheck" type="checkbox">
            <label for="flowcheck">今後の流れを確認しました</label>
          </p>
          <p class="checkbox-txt">
            <input class="" id="" name="termcheck" type="checkbox">
            <label for="termcheck">
              <a href="https://osaka-conference.com/rental/about/TermsOfService.pdf">利用規約</a>に同意します</label>
          </p>
        </div>
      </dl>
  
      <dl class="attention-txt">
        <dt>【個人情報の利用目的】</dt>
        <dd>当フォームにご入力いただく内容は、弊社が責任を持って保管し、その他の目的に使用いたしません。また、許可なく第三者に提供することはございません。個人情報の取り扱いに関しては、<a href="https://osaka-conference.com/privacypolicy/">プライバシーポリシー</a>をご確認下さい。</dd>
    </dl>

    {{ Form::open(['url' => 'user/reservations/store', 'method'=>'POST', 'id'=>'']) }}
    <p class="m-t10">
      {{Form::submit('予約申込をする', ['class' => 'btn confirm-btn margin-auto','id'=>'master_submit'])}}
    </p>
    {{Form::close()}}

    <p class="cart-addbtn"><a class="link-btn3" href="/">日程を<br>追加する</a></p>

      {{-- <ul class="btn-wrapper">
        <li>
          <p><a class="link-btn3" href="/">他の日程を予約する</a></p>
        </li>
        <li>
          {{ Form::open(['url' => 'user/reservations/store', 'method'=>'POST', 'id'=>'']) }}
          <p>{{Form::submit('予約申込をする', ['class' => 'confirm-btn','id'=>'master_submit'])}}</p>
          {{Form::close()}}
        </li>
      </ul> --}}
    </div>
    @endif


  </section>
  <div class="top contents"><a href="#top"><img src="https://osaka-conference.com/img/pagetop.png" alt="上に戻る"></a>
  </div>

<script>
  $(function(){
    $('#master_submit').on('click',function(){
      if(!confirm('予約を確定しますか？')){
        return false;
    }else{
        $('#fullOverlay').css('display', 'block');
      }
    })
  })
</script>
@endsection