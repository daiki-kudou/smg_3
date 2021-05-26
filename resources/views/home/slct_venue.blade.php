@extends('layouts.reservation.app')
@section('content')
<main>
  <!-- <ul class="tagBtn sticky">
    <li><a href ="https://osaka-conference.com/contact/"><span><img src="https://osaka-conference.com/img/link_conact.png" alt="問い合わせ"></span></a></li>
    <li><a href ="https://osaka-conference.com/reservation/"><img src="https://osaka-conference.com/img/link_entry.png" alt="本申込"></a></li>
</ul> -->

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
            {{Form::open(['url' => 'slct_date', 'method' => 'get', 'id'=>'form01', 'class'=>'search'])}}
            @csrf
            <dl>
              <dt><label>利用日</label></dt>
              <dd>
                <div class="riyoubi">
                  {{ Form::text('date', HomeHelper::now(),['class'=>'form-control text6', 'readonly', 'id'=>'datepicker'] ) }}
                </div>
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
            {{Form::open(['url' => 'slct_venue', 'method' => 'get', 'id'=>'form02', 'class'=>'search'])}}
            @csrf
            <dl>
              <dt><label>会場</label></dt>
              <dd>
                <div class="selectWrap">
                  <select name="room04" id="changeSelect">
                    @foreach ($venues as $venue)
                    @if ($request->room04==$venue->id)
                    <option value="{{$venue->id}}" selected>{{ReservationHelper::getVenueForUser($venue->id)}}</option>
                    @else
                    <option value="{{$venue->id}}">{{ReservationHelper::getVenueForUser($venue->id)}}</option>
                    @endif
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
                    @if ($request->mon==$month[0])
                    <option value="{{$month[0]}}" selected>{{$month[1]}}</option>
                    @else
                    <option value="{{$month[0]}}">{{$month[1]}}</option>
                    @endif
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
            </form>
          </div>
        </div>
      </article>
      <div class="calenderframe">
        <iframe src="{{url('/calendar/venue_calendar')}}" width="100%" height="800px"></iframe>

      </div>

      {{Form::close()}}

      <h2 class="sub-ttl">選択した日程</h2>
      <div class="bgColorGray first">
        <table>
          <tr>
            <th>利用会場</th>
            <td>
              四ツ橋・サンワールドビル2号室
            </td>
          </tr>
          <tr>
            <th>年月日 <span class="txtRed">＊</span></th>
            <td>
              <div class="riyoubi">
                <input type="text" name="date" id="datepicker" readonly>
                <img class="ui-datepicker-trigger" src="https://osaka-conference.com/img/icon_calender.png" alt="..."
                  title="...">
              </div>
              <a name="a-date" class="error-r"></a>
              <p><span class="txt-indent">翌々日以降の利用日から受付可能です。</span></p>
              <p><span>直近の日程は選択できません。お電話にて問い合わせ下さい。</span></p>
            </td>
          </tr>
          <tr>
            <th>入室時間 <span class="txtRed">＊</span></th>
            <td>
              <div class="selectWrap">
                <select name="" class="timeScale"></select>
              </div>
              <a name="a-time01" class="error-r"></a>
              <p><span>入室時間より以前に入室はできません。<br>確認の上、チェックボックスをクリックしてください。</span></p>
              <p class="checkbox-txt"><span class="txtRed">＊</span><input type="checkbox" name="q1" value="確認しました">
                確認しました</p>
            </td>
          </tr>

          <tr>
            <th>退室時間 <span class="txtRed">＊</span></th>
            <td>
              <div class="selectWrap">
                <select name="" class="timeScale"></select>
              </div>
              <a name="a-time03" class="error-r"></a>
            </td>
          </tr>
        </table>
      </div>
      </form>

      <div class="btn-wrapper2">
        <p class="confirm-btn"><a href="">日時を選択する</a></p>
      </div>

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

    $(window).on('load', function() {
    var origin_venue=$('select[name="room04"] option:selected').val();
    console.log(origin_month);
    // var target =origin_date.replaceAll('/','-');
    // const iframe = $('iframe').contents();
    // iframe.find('input[name="date"]').val(target);
    // iframe.find('#datepicker8').val(target);
    // iframe.find('#s_calendar').submit();
    });

  </script>
  <div class="top contents"><a href="#top"><img src="https://osaka-conference.com/img/pagetop.png" alt="上に戻る"></a>
  </div>
</main>


@endsection