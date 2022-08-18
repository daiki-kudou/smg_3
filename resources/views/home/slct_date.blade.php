@extends('layouts.reservation.app')
@section('content')

@include('layouts.user.overlay')

<script src="{{ asset('/js/user_reservation/validation.js') }}"></script>
<script src="{{ asset('/js/user_reservation/control_time.js') }}"></script>

<div id="fullOverlay">
  <div class="spinner">
    <div class="loader">Loading...</div>
  </div>
</div>

<!-- 会場予約 -->
<div class="contents">
  <div class="pagetop-text">
    <h1 class="page-title oddcolor"><span>会場予約</span></h1>
    <p>希望日時に空きがあることをご確認の上、お申込み下さい。</p>
  </div>
</div>
<section class="contents">
  <div class="borderBox">
    <article>
      <ul class="sp tabBtn clearfix">
        <li>利用日から選ぶ</li>
        <li class="trigger">会場から選ぶ</li>
      </ul>
      <div class="flexBetween">
        <div class="grayBox spmt20">
          <p class="txtCenter"><em>利用日から選ぶ</em></p>
          {{Form::open(['url' => '/slct_date', 'method' => 'get', 'id'=>'form01', 'class'=>'search','autocomplete'=>'off',])}}
          @csrf
          <dl>
            <dt><label>利用日</label></dt>
            <dd>
              <div class="riyoubi">
                {{ Form::text('date', $request->date?$request->date:$today,['class'=>'form-control text6', 'readonly',
                'id'=>'datepicker'] ) }}
              </div>
              <p class="space5">
                <span class="txt-indent f-s90">※複数日程検索は出来ません。</span>
                <span class="txt-indent f-s90">※選択不可の日程につきましては、直接お問い合わせ下さい。</span>
                <span class="txt-indent f-s90">※一部検索対応をしていない会場があります。</span>
              </p>
            </dd>
          </dl>
          <div class="btnOrange"><button type="submit" class="smit">会場検索<img
                src="https://system.osaka-conference.com/img/icon_serch.png" alt="検索"></button>
          </div>
          {{Form::close()}}
        </div>
        <div class="grayBox btn-row">
          <p class="txtCenter"><em>会場から選ぶ</em></p>
          {{Form::open(['url' => '/slct_venue', 'method' => 'get', 'id'=>'form02', 'class'=>'search','autocomplete'=>'off',])}}
          @csrf
          <dl class="m-b20">
            <dt><label>会場</label></dt>
            <dd>
              <div class="selectWrap">
                <select name="room04" id="changeSelect">
                  @foreach ($venues as $venue)
                  <option value="{{$venue->id}}">{{ReservationHelper::getVenue($venue->id)}}</option>
                  @endforeach
                </select>
              </div>
              <p><span class="txt-indent f-s90">※検索対応をしていない会場や、利用月プルダウン外の日程に関しましては直接お問い合わせ下さい。</span>
              </p>
            </dd>
          </dl>
          <dl>
            <dt><label>利用月</label></dt>
            <dd class="">
              <div class="selectWrap">
                {{ Form::select('mon',HomeHelper::getMonths(),old('mon'),['id'=>'changeSelectpoint']) }}
              </div>
            </dd>
          </dl>
          <dl class="m-b20">
            <dt></dt>
            <dd>
              <p><span class="txt-indent f-s90">※選択不可の日程につきましては、直接お問い合わせ下さい。</span></p>
            </dd>
          </dl>
          <p class="txtCenter"><button type="submit" class="smit search_btn">空室状況検索<img
                src="https://system.osaka-conference.com/img/icon_serch.png" alt="検索"></button>
          </p>
          {{Form::close()}}
        </div>
      </div>
    </article>
    <div class="calenderframe">
      <iframe src="{{url('/calendar/date_calendar')}}" width="100%"></iframe>
    </div>

    {{Form::open(['url' => '/user/reservations/create', 'method' => 'get', 'class'=>'search','id'=>'slct_date_form','autocomplete'=>'off',])}}
    <h2 class="sub-ttl">申込み内容</h2>
    <div class="bgColorGray first">
      <table>
        <tr>
          <th>利用日</th>
          <td>
            {{ReservationHelper::formatDate($request->date?$request->date:$today)}}
            {{ Form::hidden('date', date('Y-m-d',strtotime($request->date?$request->date:$today))) }}
          </td>
        </tr>
        <tr>
          <th>利用会場 <span class="txtRed">＊</span></th>
          <td>
            <div class="selectWrap long">
              <select name="venue_id" id="venue_id">
                <option value=""></option>
                @foreach ($venues as $venue)
                <option value="{{$venue->id}}">{{ReservationHelper::getVenue($venue->id)}}</option>
                @endforeach
              </select>
            </div>
            <a name="a-room01" class="error-r"></a>
          </td>
        </tr>
        <tr>
          <th>入室時間
            <span class="txtRed">＊</span>
          </th>
          <td class="form-cell3">
            <div class="m-r10">
              <div class="selectWrap">
                <select name="enter_time" class="timeScale" id="enter_time">
                </select>
              </div>
              <p class="is-error-enter_time" style="color: red"></p>
            </div>
            <div>
              <p class="txtRed">
                <span>入室時間より以前に入室はできません。</span>
              </p>
              <p class="checkbox-txt txtRed">
                <span class="txtRed">＊</span>
                {{Form::checkbox('q1', 1, false, ['class'=>'','id'=>'checkbox'])}}
                <label for="checkbox">確認しました</label>
              </p>
              <p class="is-error-q1" style="color: red"></p>
            </div>
          </td>
        </tr>
        <tr>
          <th>退室時間 <span class="txtRed">＊</span></th>
          <td>
            <div class="selectWrap">
              <select name="leave_time" class="timeScale" id="leave_time">
              </select>
            </div>
            <p class="is-error-leave_time" style="color: red"></p>
          </td>
        </tr>
      </table>
    </div>

    <p class="txtCenter">{{ Form::submit('詳細情報の入力', ['class' => 'btn confirm-btn margin-auto']) }}</p>
    {{Form::close()}}
  </div>
</section>

<article class="contents">
  <div class="page-text">
    <p class="caution-text">カレンダーにない日程の予約に関してはお電話にてお問合せください。</p>
  </div>
  <div class="contactinfo">
    <div class="info">
      <p class="title">問い合わせの前に</p>
      <p>お客様よりいただく<span class="faq"><a href="../faq/">よくある質問</a></span>をご参考下さい。</p>
    </div>
    <div class="telInfo">
      <p class="title">電話での問い合わせ（10時～18時）</p>
      <div class="telNo pc">06-6556-6462</div>
      <div class="telNo sp"><a href="tel:06-6556-6462"
          onclick="gtag('event','tel-tap',{'event_category':'click'});">06-6556-6462</a></div>
      <p>ご予約、お問い合わせ専用番号となります。<br class="sp">会場アクセスやイベント内容についてのお問い合わせはお控え下さい。</p>
    </div>
  </div>
</article>


<script>
  $("form[name='calendar02'] select[name='room04']").val($("form[name='calendar02'] select[name='room04'] option").first().val());
    $(function () {
        $("form#form02 select[name='room04'] option").filter(function () {
            return $(this).attr("disabled");
        }).remove();
    });

    $(window).on('load', function() {
      var origin_date=$('input[name="date"]').val();
      var target =origin_date.replaceAll('/','-');
      const iframe = $('iframe').contents();
      iframe.find('input[name="date"]').val(target);
      iframe.find('#datepicker8').val(target);
      iframe.find('#s_calendar').submit();
      });
</script>
<div class="top contents"><a href="#top"><img src="https://system.osaka-conference.com/img/pagetop.png" alt="上に戻る"></a>
</div>
<script>
  $('button[type="submit"]').on('click',function(){
    $('#userFullOverlay').css('display','block');
  })
</script>
@endsection