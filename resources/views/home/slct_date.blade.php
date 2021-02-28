@extends('layouts.reservation.app')
@section('content')

<script src="{{ asset('/js/user_reservation/validation.js') }}"></script>


<main>
  <!--コロナ対策中お知らせ非表示-->
  <section class="contents news pc">
    <dl class="information contents">
      <dt>重要なお知らせ</dt>
      <dd><a href="https://osaka-conference.com/corona/">新型コロナウィルスに対する取り組みについて</a></dd>
    </dl>
  </section>
  <section class="contents news sp">
    <dl class="information indexNews">
      <dt>重要なお知らせ</dt>
      <dd><a href="https://osaka-conference.com/corona/">新型コロナウィルスに対する取り組みについて</a></dd>
    </dl>
  </section>
  <!--コロナ対策中お知らせ非表示-->




  <!------パンクズ-------->
  <nav class="contents">
    <ol class="bread" itemscope itemtype="http://schema.org/BreadcrumbList">
      <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
        <a itemscope itemtype="http://schema.org/Thing" itemprop="item" href="https://osaka-conference.com/">
          <span itemprop="name"><img src="https://osaka-conference.com/img/icon_bread.png" alt="HOME"></span></a>
        <meta itemprop="position" content="1">
      </li>
      <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
        <a itemscope itemtype="http://schema.org/Thing" itemprop="item" href="https://osaka-conference.com/calendar/">
          <span itemprop="name"><span class="changeTtl">カレンダー（空室確認）</span></span></a>
        <meta itemprop="position" content="2">
      </li>
    </ol>
  </nav>


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
            {{Form::open(['url' => 'slct_date', 'method' => 'post', 'id'=>'form01', 'class'=>'search'])}}
            @csrf
            <dl>
              <dt><label>利用日</label></dt>
              <dd>
                <div class="riyoubi">
                  {{ Form::text('date', $request->date,['class'=>'form-control text6', 'readonly', 'id'=>'datepicker'] ) }}
                </div>
                <p class="space5"><span class="txt-indent">※複数日程検索は出来ません。</span>
                  <span class="txt-indent">※一部検索対応をしていない会場があります。</span></p>
              </dd>
            </dl>
            <div class="btnOrange"><button type="submit" class="smit">会場検索<img
                  src="https://osaka-conference.com/img/icon_serch.png" alt="検索"></button>
            </div>
            {{Form::close()}}
          </div>
          <div class="grayBox btn-row">
            <p class="txtCenter"><em>会場から選ぶ</em></p>
            {{Form::open(['url' => 'slct_venue', 'method' => 'post', 'id'=>'form02', 'class'=>'search'])}}
            @csrf
            <dl>
              <dt><label>会場</label></dt>
              <dd>
                <div class="selectWrap">
                  <select name="room04" id="changeSelect">
                    @foreach ($venues as $venue)
                    <option value="{{$venue->id}}">{{ReservationHelper::getVenue($venue->id)}}</option>
                    @endforeach
                  </select>
                </div>
                <p><span class="txt-indent">※検索対応をしていない会場や、利用月プルダウン外の日程に関しましては直接お問い合わせ下さい。</span>
                </p>
              </dd>
            </dl>
            <dl>
              <dt><label>利用月</label></dt>
              <dd class="short">
                <div class="selectWrap">
                  <select name="mon" id="changeSelectpoint">
                    @foreach (HomeHelper::getMonths() as $month)
                    <option value="{{$month[0]}}">{{$month[1]}}</option>
                    @endforeach
                  </select>
                </div>

              </dd>
            </dl>
            <dl>
              <dt></dt>
              <dd>
                <p><span class="txt-indent">※選択不可の日程につきましては、直接お問い合わせ下さい。</span></p>
              </dd>
            </dl>
            <div class="btnOrange"><button type="submit" class="smit">空室状況検索<img
                  src="https://osaka-conference.com/img/icon_serch.png" alt="検索"></button>
              <a href="https://osaka-conference.com/contact/" class="cContactBtn">問い合わせ</a>
            </div>
            {{Form::close()}}
          </div>
        </div>
      </article>
      <div class="calenderframe">
        <iframe src="{{url('').'/admin/calendar/date_calendar'}}" width="100%" height="400px"></iframe>
      </div>

      {{-- <form name="form" id="form" action="https://osaka-conference.com/contact/check.php" next="false"
            method="post"> --}}
      {{Form::open(['url' => 'user/reservations/create', 'method' => 'get', 'class'=>'search','id'=>'slct_date_form'])}}
      @csrf
      <h2 class="sub-ttl">選択した日程</h2>
      <div class="bgColorGray first">
        <table>
          <tr>
            <th>利用日</th>
            <td>
              {{ReservationHelper::formatDate($request->date)}}
              {{ Form::hidden('date', date('Y-m-d',strtotime($request->date))) }}
            </td>
          </tr>
          <tr>
            <th>利用会場 <span class="txtRed">＊</span></th>
            <td>
              <div class="selectWrap long">
                <select name="venue_id" id="venue_id">
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
            <td>
              <div class="selectWrap">
                <select name="enter_time" class="timeScale" id="enter_time">
                  <option value=""></option>
                  {{!!ReservationHelper::timeOptionsWithDefault()!!}}
                </select>
              </div>
              <p class="is-error-enter_time" style="color: red"></p>
              <p>
                <span>入室時間より以前に入室はできません。
                  <br>
                  確認の上、チェックボックスをクリックしてください。</span>
              </p>
              <p class="checkbox-txt">
                <span class="txtRed">＊</span>
                {{-- <input type="checkbox" name="q1" value="確認しました" id="checkbox"> --}}
                {{Form::checkbox('q1', 1, false, ['class'=>'custom-control-input','id'=>'checkbox'])}}
                <label for="checkbox">確認しました</label>
              </p>
              <p class="is-error-q1" style="color: red"></p>
            </td>
          </tr>
          <tr>
            <th>退室時間 <span class="txtRed">＊</span></th>
            <td>
              <div class="selectWrap">
                <select name="leave_time" class="timeScale" id="leave_time">
                  <option value=""></option>
                  {{!!ReservationHelper::timeOptionsWithDefault()!!}}
                </select>
              </div>
              <p class="is-error-leave_time" style="color: red"></p>
            </td>
          </tr>
        </table>
      </div>
      <div class="btn-wrapper2">
        <p class="confirm-btn">
          {{ Form::submit('日時を選択する', ['class' => 'btn btn-primary']) }}
        </p>
      </div>
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
    $("form[name='calendar02'] select[name='room04']").val($(
                    "form[name='calendar02'] select[name='room04'] option").first().val());
                $(function () {
                    $("form#form02 select[name='room04'] option").filter(function () {
                        return $(this).attr("disabled");
                    }).remove();
                });
  </script>
  <div class="top contents"><a href="#top"><img src="https://osaka-conference.com/img/pagetop.png" alt="上に戻る"></a>
  </div>
</main>
@endsection