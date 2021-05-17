@extends('layouts.reservation.app')
@section('content')
<div class="wrapper">

  <main>
    <ul class="tagBtn sticky">
      <li><a class="contact_btn" href="https://osaka-conference.com/contact/">問合わせ</a></li>
      <li><a class="reserve_btn" href="https://osaka-conference.com/reservation/">会場予約</a></li>
      <li><a class="login_btn" href="https://osaka-conference.com/reservation/">ログイン</a></li>
    </ul>

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
                    {{ Form::text('date', HomeHelper::now(),['class'=>'form-control', 'readonly', 'id'=>'datepicker'] ) }}
                  </div>
                  <p class="space5">
                    <span class="txt-indent">※複数日程検索は出来ません。</span>
                    <span class="txt-indent">※選択不可の日程につきましては、直接お問い合わせ下さい。</span>
                    <span class="txt-indent">※一部検索対応をしていない会場があります。</span></p>
                </dd>
              </dl>
              <div class="btnOrange">
                <button type="submit" class="smit">会場検索
                  <img src="https://osaka-conference.com/img/icon_serch.png" alt="検索">
                </button>
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
                  <p>
                    <span class="txt-indent">※検索対応をしていない会場や、利用月プルダウン外の日程に関しましては直接お問い合わせ下さい。</span>
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
                <a href="https://osaka-conference.com/contact/" class="cContactBtn">問い合わせ</a></div>
              {{Form::close()}}
            </div>
          </div>
        </article>
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
      $(function(){
      $("form#form02 select[name='room04'] option").filter(function(){
          return $(this).attr("disabled");
      }).remove();
      });
    </script>
    <div class="top contents"><a href="#top"><img src="https://osaka-conference.com/img/pagetop.png" alt="上に戻る"></a>
    </div>
  </main>


</div>

@endsection