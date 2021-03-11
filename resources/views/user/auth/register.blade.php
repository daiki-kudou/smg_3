<!DOCTYPE html>
<html>

<head>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>カレンダー一覧|[大阪格安貸し会議室]SMGアクセア貸し会議室</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, maximum-scale=1.0, user-scalable=yes">


  <meta name="keywords" content="" />
  <meta name="description"
    content="SMGアクセア貸し会議室のカレンダー一覧（空室確認）ページです。会場は大阪市内の各主要駅から徒歩0～2分。JR大阪/新大阪/地下鉄梅田駅からアクセス抜群。知名度が高いエリアの視認性の良いビル内に5～200名収容の豊富なバリエーション会場を多数ご用意しています。格安料金体系＆プロジェクター・スクリーンなどの備品無料多数。説明会・セミナー・研修・勉強会・懇親会などに最適です。また音響設備・プロジェクターがグレードアップした講演や説明会等に最適な臨場感溢れる「音響グレードアップ会場」もございます。" />

  <link rel="canonical" href="https://osaka-conference.com/calendar/">
  <link rel="shortcut icon" href="https://osaka-conference.com/img/favicon.ico?ver=20201225" />
  <link rel="stylesheet" media="all" type="text/css"
    href="https://osaka-conference.com/css/ress.min.css?ver=20201225" />
  <link rel="stylesheet" media="all" type="text/css" href="https://osaka-conference.com/css/style.css?ver=20201225" />
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.1/css/all.css?ver=20201225">
  <link rel="stylesheet" media="all" type="text/css"
    href="https://osaka-conference.com/css/contents.css?ver=20201225" />
  <link rel="stylesheet" media="all" type="text/css" href="https://osaka-conference.com/css/sp.css?ver=20201225" />
  <link rel="stylesheet" media="all" type="text/css"
    href="https://osaka-conference.com/css/lightcase.css?ver=20201225" />

  <link rel="stylesheet" href="https://osaka-conference.com/css/validationEngine.jquery.css?ver=20201225">
  <link rel="stylesheet"
    href="https://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/redmond/jquery-ui.css?ver=20201225">

  <!-- システムcss -->
  {{-- <link rel="stylesheet" href="../css/style.css"> --}}


  <!--[if lt IE 9]>
  <script src="//cdn.jsdelivr.net/html5shiv/3.7.2/html5shiv.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.min.js"></script>
  <![endif]-->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

  <script src="https://osaka-conference.com/js/flexibility.js?ver=20201225"></script>
  <script src="https://osaka-conference.com/js/wideslider.js?ver=20201225"></script>
  <script src="https://osaka-conference.com/js/functions.js?ver=20201225"></script>
  <script src="https://osaka-conference.com/js/lightcase.js?ver=20201225"></script>
  <script src="https://osaka-conference.com/js/jquery.matchHeight.js?ver=20201225"></script>


  <script>
    jQuery(document).ready(function ($) {
      $('a[data-rel^=lightcase]').lightcase({
        maxWidth: 1000,
        maxHeight: 800,
        swipe: true,
        breakBeforeShow: true
      });
    });
  </script>
  <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
  <script src="https://osaka-conference.com/js/jquery.heightLine.js?ver=20201225"></script>
  <script>
    $(window).load(function () {
      $(".box0>li").heightLine();
      //$(".box01>li").heightLine();
      if (window.matchMedia('(min-width: 751px)').matches) {
        $(".room-data").heightLine();
        $(".conference-roominner>.conference-roomdata").heightLine();
        $(".top-characteristic-index .contents .featurelist .three dl>dt").heightLine();
      }
    });
    $(function () {
      if (window.matchMedia('(min-width: 751px)').matches) {
        setTimeout(function () {
          $('#tablist .r-tabs-tab a.r-tabs-anchor').on('click', function () {
            $('.other-servicelist>.item-block').heightLine();
          });
        }, 10);
      }
    });
  </script>
  <script>
    if ($().Stickyfill) {
      $('.sticky').Stickyfill();
    }
  </script>
  <script src="https://osaka-conference.com/js/jquery.responsiveTabs.js" type="text/javascript"></script>
  <script type="text/javascript">
    $(document).ready(function () {
      var $tabs = $('#horizontalTab');
      $tabs.responsiveTabs({
        rotate: false,
        startCollapsed: 'accordion',
        collapsible: 'accordion',
        active: 1
      });
    });
  </script>
  <script type="text/javascript">
    $(document).ready(function () {
      var $tabs = $('#horizontalTab02');
      $tabs.responsiveTabs({
        rotate: false,
        startCollapsed: 'accordion',
        collapsible: 'accordion',
        active: 0
      });
    });
  </script>
  <script src="https://osaka-conference.com/js/search.js"></script>
  <script src="https://osaka-conference.com/js/searchTpl.js"></script>




  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1/jquery-ui.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1/i18n/jquery.ui.datepicker-ja.min.js"></script>
  {{-- <script src="https://osaka-conference.com/js/jquery.validationEngine-ja.js"></script>
  <script src="https://osaka-conference.com/js/jquery.validationEngine.js"></script> --}}
  <script src="https://osaka-conference.com/js/form.js"></script>
  <script type="text/javascript">
    $(function () {
      var today = new Date();
      var dd = today.getDate();
      $("#datepicker").datepicker({
        showOn: "both",
        buttonImage: "https://osaka-conference.com/img/icon_calender.png",
        buttonImageOnly: true,
        minDate: "+3",
        maxDate: "+3M -" + dd,
        beforeShow: function (input, inst) { // カレンダーを必ず下側へ表示させるための表示位置計算function
          var top = $(this).offset().top + $(this).outerHeight();
          var left = $(this).offset().left;
          setTimeout(function () {
            inst.dpDiv.css({
              'top': top,
              'left': left
            });
          }, 10) // 10msec
        }
      });
      $("ul.tabBtn li").mouseover(function () {
        if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator
            .userAgent)) {
          $(this).click();
        }
      });
      $(".hasDatepicker, .ui-datepicker, .ui-datepicker-trigger").click(function (event) {
        event.stopPropagation();
      });
      $(".contents").bind("click touchstart, touchmove", function (event) {
        $('.ui-datepicker').hide();
        $('.hasDatepicker').blur();
      });
    });
  </script>

  <style>
    @media screen and (max-width:750px) {
      .tabBtn li {
        z-index: 1;
        /*5;*/
      }
    }
  </style>
  <link href="{{ asset('/css/homepage/style.css') }}" rel="stylesheet">

</head>

<body id="top" class="calender contactpage tentative vacancy">
  <div class="wrapper">

    <!-- header.html -->
    <header>
      　<span class="head-login sp"><a href="">ログイン</a></span>
      <span class="head-mail sp"><a href="https://osaka-conference.com/contact/">問合せ</a></span>
      <span class="btn"><span></span></span>
      <div class="contents">
        <p class="logo">
          <a href="https://osaka-conference.com/"><img src="https://osaka-conference.com/img/logo.jpg"
              alt="株式会社SMG"><span class="sp head_smgaccea">SMGアクセア貸し会議室</span></a>
        </p>
        <div class="headerInfo">
          <p class="txt"><span
              class="head_smgaccea">SMGアクセア貸し会議室</span><br>大阪市内主要駅(新大阪・梅田)から好アクセス・駅近。～100名の中小会場が格安で基本備品無料！</p>
          <div class="head_dl_btn">
            <div><a href="https://osaka-conference.com/application/">用紙ダウンロード</a></div>
          </div>
          <div class="tel">
            <p><em>06-6556-6462</em><br>
              予約専用：10時～18時</p>
          </div>
        </div>
      </div>

      <nav>
        <ul class="mainNav">
          <li><a href="https://osaka-conference.com/"><img src="https://osaka-conference.com/img/icon_home.png"
                alt="HOME" class="off"><img src="https://osaka-conference.com/img/icon_home_on.png" alt="HOME"
                class="on"></a></li>
          <li><a href="https://osaka-conference.com/rental/">会場一覧</a></li>
          <li><a href="https://osaka-conference.com/price/">料金表</a></li>
          <li class="active"><a href="https://osaka-conference.com/calendar/">カレンダー</a></li>
          <li><a href="https://osaka-conference.com/flow/">利用の流れ</a></li>
          <li><a href="https://osaka-conference.com/characteristic/">特徴</a></li>
          <li><a href="https://osaka-conference.com/faq/">よくある質問</a></li>
          <li><a href="https://osaka-conference.com/contact/">問い合わせ</a></li>
          <li>
            <ul class="sp formBtnBlock">
              <li><a href="https://osaka-conference.com/contact/#book"><img
                    src="https://osaka-conference.com/img/ico_file01@2x.png" alt="仮予約">仮予約</a></li>

              <li><a href="https://osaka-conference.com/reservation/"><img
                    src="https://osaka-conference.com/img/ico_form02@2x.png" alt="本申込み">本申込み</a></li>
            </ul>
            <div class="sp contactBlock">
              <div class="tel">
                <div class="sp"><span>お電話でのお問い合わせ(10時～18時)</span></div>
                <p class="telNo"><em>06-6556-6462</em></p>
                <p class="note">ご予約、お問合せ専用番号となります。<br>
                  会場アクセスやイベント内容についてのお問い合わせはお控え下さい。</p>
              </div>
              <div class="allbtn green"><a href="https://osaka-conference.com/contact/"><img
                    src="https://osaka-conference.com/img/icon_mail.png" alt="問い合わせ"><span>問い合わせ</span></a></div>
            </div>
          </li>
        </ul>
      </nav>

      <div class="contents headTxt sp">
        <p>大阪市内の格安・駅チカ貸し会議室・<a href="https://osaka-conference.com/characteristic/free-equipment/">無料備品多数</a></p>
      </div>
      <div class="contents subNavi sp">
        <ul>
          <li><a href="https://osaka-conference.com/rental/">会場一覧</a></li>
          <li><a href="https://osaka-conference.com/price/">料金表</a></li>
          <li><a href="https://osaka-conference.com/characteristic/">8つの特徴</a></li>
          <li><a href="https://osaka-conference.com/reservation/">本申込み</a></li>
        </ul>
      </div>

    </header>
    <main>

      <!-- パンくずなど.html -->
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
            <a itemscope itemtype="http://schema.org/Thing" itemprop="item"
              href="https://osaka-conference.com/calendar/">
              <span itemprop="name"><span class="changeTtl">カレンダー（空室確認）</span></span></a>
            <meta itemprop="position" content="2">
          </li>
        </ol>
      </nav>


      <!-- ログイン、会員登録 -->
      <div class="contents">
        <div class="pagetop-text">
          <h1 class="page-title oddcolor"><span>会員登録</span></h1>
          <p>下記フォームの入力をお願いします。</p>
        </div>
      </div>
      <section class="contents">
        <!-- <h2 class="sub-ttl">会員登録情報</h2> -->

        {{-- <form name="form" id="form" action="https://osaka-conference.com/contact/check.php" next="false" method="post"> --}}
        {{-- <form method="POST" action="{{ route('user.register') }}"> --}}
        {{ Form::open(['route' => 'user.preusers.registercheck', 'method'=>'POST']) }}
        @csrf
        <div class="bgColorGray first">
          <table>
            <tr>
              <th>会社・団体名 <span class="txtRed c-block">＊</span></th>
              <td>
                {{ Form::text('company', $request->company, ['class' => 'form-control text3', 'id'=>'company', 'placeholder'=>"入力してください"]) }}
                <br class="spOnlyunder">
                <p><span>法人・団体ではない方は、お名前をご記入ください。</span></p>
                <a name="a-company02" class="error-r"></a>
              </td>
            </tr>
            <tr>
              <th>担当者氏名
                <span class="txtRed c-block">＊</span></th>
              <td>
                <ul class="form-cell">
                  <li>
                    <p>姓</p>
                    {{ Form::text('first_name', old('first_name'), ['class' => 'form-control text1', 'id'=>'nam', 'placeholder'=>"入力してください"]) }}
                    <br class="spOnlyunder">
                    <a name="a-nam" class="error-r"></a>
                  </li>
                  <li>
                    <p>名</p>
                    {{ Form::text('last_name', old('last_name'), ['class' => 'form-control text1', 'id'=>'nam', 'placeholder'=>"入力してください"]) }}
                    <br class="spOnlyunder">
                    <a name="a-nam" class="error-r"></a>
                  </li>
                </ul>
              </td>
            </tr>
            <tr>
              <th>担当者氏名(フリガナ) <span class="txtRed c-block">＊</span></th>
              <td>
                <ul class="form-cell">
                  <li>
                    <p>セイ</p>
                    {{ Form::text('first_name_kana', old('first_name_kana'), ['class' => 'form-control text1', 'id'=>'nam', 'placeholder'=>"入力してください"]) }}
                    <br class="spOnlyunder">
                    <a name="a-nam" class="error-r"></a>
                  </li>
                  <li>
                    <p>メイ</p>
                    {{ Form::text('last_name_kana', old('last_name_kana'), ['class' => 'form-control text1', 'id'=>'nam', 'placeholder'=>"入力してください"]) }}
                    <br class="spOnlyunder">
                    <a name="a-nam" class="error-r"></a>
                  </li>
                </ul>
              </td>
            </tr>
            <tr>
              <th><label for="post_code">郵便番号</label></th>
              <td>
                <p class="postal-p">〒</p>
                <input onKeyUp="AjaxZip3.zip2addr(this,&#039;&#039;,&#039;address1&#039;,&#039;address2&#039;);"
                  autocomplete="off" name="post_code" type="text" value="" id="post_code">
              </td>
            </tr>
            <tr>
              <th>
                <label for="address1">住所1（都道府県）</label>
              </th>
              <td>
                {{-- <input class="text3" name="address1" type="text" value="" id="address1"> --}}
                {{ Form::text('address1', old('address1'), ['class' => 'form-control ', 'id'=>'address1', 'placeholder'=>"入力してください"]) }}
              </td>
            </tr>
            <tr>
              <th><label for="address2">住所2（市町村番地）</label></th>
              <td>
                {{-- <input class="text3" name="address2" type="text" value="" id="address2"> --}}
                {{ Form::text('address2', old('address2'), ['class' => 'form-control ', 'id'=>'address2', 'placeholder'=>"入力してください"]) }}

              </td>
            </tr>
            <tr>
              <th><label for="address3">住所3（建物名）</label></th>
              <td>
                {{-- <input class="text3" name="address3" type="text" value="" id="address3"> --}}
                {{ Form::text('address3', old('address3'), ['class' => 'form-control ', 'id'=>'address3', 'placeholder'=>"入力してください"]) }}
              </td>
            </tr>
            <tr class="tr-tel-0">
              <th>連絡先 <span class="txtRed">＊</span></th>
              <td>
                <span class="txtRed">携帯電話、固定電話のどちらか一方は必須入力です</span>
                <a name="a-tel" class="error-r"></a>
              </td>
            </tr>
            <tr class="tr-tel-1">
              <th>
                <!--<span class="txtRed c-block">＊</span>-->
              </th>
              <td>
                <p class="checkbox-txt">携帯電話</p>
                {{-- <input name="tel01_1" id="tel01_1" class="text2" type="tel"> --}}
                {{ Form::text('tel', old('tel'), ['class' => 'form-control text2', 'id'=>'tel', 'placeholder'=>"入力してください"]) }}
                <p style="display:inline-block">11文字</p>
                <a name="a-tel01" class="error-r"></a>
                <p>※半角数字、ハイフンなしで入力してください。</p>
              </td>
            </tr>
            <tr class="tr-tel-2">
              <th>
                <!--<span class="txtRed c-block">＊</span>-->
              </th>
              <td>
                <p class="checkbox-txt">固定電話</p>
                {{-- <input name="tel02_1" id="tel1" class="text2" type="tel"> --}}
                {{ Form::text('mobile', old('mobile'), ['class' => 'form-control text2', 'id'=>'mobile', 'placeholder'=>"入力してください"]) }}
                <p style="display:inline-block">10文字</p>
                <a name="a-tel02" class="error-r"></a>
                <p>※半角数字、ハイフンなしで入力してください。</p>
              </td>
            </tr>
            <tr>
              <th>FAX</th>
              <td>
                {{-- <input name="fax1" id="fax1" class="text2" type="tel"> --}}
                {{ Form::text('fax', old('fax'), ['class' => 'form-control text2', 'id'=>'fax', 'placeholder'=>"入力してください"]) }}

                <p>※半角数字、ハイフンなしで入力してください。</p>
              </td>
            </tr>
            <tr>
              <th>メールアドレス</th>
              <td>
                {{$request->email}}
                {{ Form::hidden('email', $request->email, ['id'=>'email']) }}
              </td>
            </tr>
            <tr>
              <th>パスワード<span class="txtRed">＊</span></th>
              <td>
                {{-- <input name="password" id="password" class="text2" type="password"> --}}
                {{Form::password('password', ['class' => 'text2'])}}
                <a name="a-mail01" class="error-r"></a>
                <p>※半角英数字6文字以上20文字以内にてご記入お願い致します。</p>
              </td>
            </tr>
            <tr>
              <th>パスワード確認<span class="txtRed">＊</span></th>
              <td>
                {{-- <input name="password" id="password" class="text2" type="password"> --}}
                {{Form::password('password_chk', ['class' => 'text2'])}}
                <a name="a-mail01" class="error-r"></a>
                <p>※確認のため、もう一度パスワードを入力してください。</p>
              </td>
            </tr>
            <tr>
              <th>SMGを何で知りましたか</th>
              <td>
                <ul class="radio-box">
                  <li>PC検索：
                    <div>
                      <input name="research" id="google" class="" type="radio" value="1">
                      <label for="google">Google</label>
                      <input name="research" id="yahoo" class="" type="radio" value="2">
                      <label for="yahoo">Yahoo</label>
                      <input name="research" id="others" class="" type="radio" value="3">
                      <label for="others">その他</label>
                    </div>
                  </li>
                  <li>
                    <input name="research" id="phoneSearch" class="" type="radio" value="1"><label
                      for="phoneSearch">スマホ検索</label>
                  </li>
                  <li>
                    <label style="width: 90px;" for="intro">
                      <input type="radio" name="research" id="intro" value="2">ご紹介</label>
                    <input name="intro" type="text" class="" id="intro" placeholder="入力してください"></li>
                  <li>
                    <input name="research" id="mail" class="" type="radio" value="3">
                    <label for="mail">メルマガ</label>
                  </li>
                  <li><input name="research" id="flyer" class="" type="radio" value="4">
                    <label for="flyer">看板・チラシ</label>
                  </li>
                  <li><label style="width: 90px;">
                      <input type="radio" name="research" id="other" value="5">その他
                    </label>
                    <label for="other"></label>
                    <input name="othertext" type="text" class="" id="" placeholder="入力してください">
                    　</li>
                </ul>
              </td>
            </tr>
          </table>
        </div>
        <dl class="attention-txt">
          <dt>【個人情報の利用目的】</dt>
          <dd>当フォームにご入力いただく内容は、弊社が責任を持って保管し、その他の目的に使用いたしません。また、許可なく第三者に提供することはございません。個人情報の取り扱いに関しては、<a
              href="https://osaka-conference.com/privacypolicy/">プライバシーポリシー</a>をご確認下さい。</dd>
        </dl>

        <dl class="attention-txt">
          <dt>【利用規約】</dt>
          <dd>当フォームにご入力いただく内容は、弊社が責任を持って保管し、その他の目的に使用いたしません。また、許可なく第三者に提供することはございません。個人情報の取り扱いに関しては、<a
              href="https://osaka-conference.com/privacypolicy/">プライバシーポリシー</a>をご確認下さい。</dd>
        </dl>

        <div class="page-text">
          <p class="checkbox-txt "><span class="txtRed">＊</span><input type="checkbox" name="q1" value="">
            本内容で会員登録をすることに同意する</p>
          <p>※WEB予約には会員登録が必須となります。</p>
        </div>

        <div class="btn-wrapper2">
          <p>
            <button type="submit" id="" name="action" block="false">確認して進む</button>
            {{-- {{ Form::submit('確認して進む', ['class' => 'btn btn-primary mb-5 mt-5']) }} --}}
          </p>
        </div>
        {{ Form::hidden('id', $request->id) }}
        {{ Form::hidden('token', $request->token) }}
        {{ Form::hidden('status', $request->status) }}
        {{ Form::close() }}

  </div>



  </section>



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
  <!-- 住所検索 -->
  <script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>

  <!-- ここからfooter.html -->
  <div class="banner">
    <ul class="contents pc">
      <li><a href="https://osaka-conference.com/characteristic/free-equipment/"><img
            src="https://osaka-conference.com/img/banner_freegoods02.jpg" alt="無料備品が多数！"></a></li>
      <li><a href="https://osaka-conference.com/characteristic/night-use/"><img
            src="https://osaka-conference.com/img/banner_night02.jpg" alt="夜間激安"></a></li>
      <li><a href="https://osaka-conference.com/characteristic/regular-use/"><img
            src="https://osaka-conference.com/img/banner_regular02.jpg" alt="定期利用のお客様へ"></a></li>
      <li><a href="https://osaka-conference.com/characteristic/high-grade/"><img
            src="https://osaka-conference.com/img/banner_highgre02.jpg" alt="音響ハイグレード"></a></li>
      <li><a href="https://osaka-conference.com/characteristic/access/"><img
            src="https://osaka-conference.com/img/banner_access.jpg" alt="駅チカ！アクセス抜群"></a></li>
      <li><a href="https://osaka-conference.com/catering/"><img
            src="https://osaka-conference.com/img/banner_catering02.jpg" alt="ケータリングサービスお弁当の手配"></a></li>
    </ul>
    <ul class="contents sp">
      <li><a href="https://osaka-conference.com/characteristic/free-equipment/"><img
            src="https://osaka-conference.com/img/banner_freegoods02@2x.jpg" alt="無料備品が多数！"></a></li>
      <li><a href="https://osaka-conference.com/characteristic/night-use/"><img
            src="https://osaka-conference.com/img/banner_night02@2x.jpg" alt="夜間激安"></a></li>
      <li><a href="https://osaka-conference.com/characteristic/regular-use/"><img
            src="https://osaka-conference.com/img/banner_regular02@2x.jpg" alt="定期利用のお客様へ"></a></li>
      <li><a href="https://osaka-conference.com/characteristic/high-grade/"><img
            src="https://osaka-conference.com/img/banner_highgre02@2x.jpg" alt="音響ハイグレード"></a></li>
      <li><a href="https://osaka-conference.com/characteristic/access/"><img
            src="https://osaka-conference.com/img/banner_access02.jpg" alt="駅チカ！アクセス抜群"></a></li>
      <li><a href="https://osaka-conference.com/catering/"><img
            src="https://osaka-conference.com/img/banner_catering02@2x.jpg" alt="ケータリングサービスお弁当の手配"></a></li>
    </ul>
  </div>
  <footer class="new">
    <nav class="contents">
      <div class="footerInfo">
        <ul class="pc">

          <li class="download">
            <p>本申込み(フォーム・直接メールに添付・FAX)</p>
            　　<p class="download_btn3 btnOrange"><a href="https://osaka-conference.com/reservation/"
                target="_blank"><img src="https://osaka-conference.com/img/ico_form.png" alt="本申込み">フォーム</a></p>
            <p class="download_btn3 btnOrange"><a href="https://osaka-conference.com/downlord/form.pdf"
                target="_blank"><img src="https://osaka-conference.com/img/ico_pdf.png" alt="PDF">PDF</a></p>
            <p class="download_btn3 btnOrange"><a href="https://osaka-conference.com/downlord/form.xlsx"
                target="_blank"><img src="https://osaka-conference.com/img/ico_excel.png" alt="EXCEL">EXCEL</a></p>
          </li>
        </ul>
        <ul class="sp">

          <li>本申込みフォームあるいは本申込み書をダウンロード！</li>
          <li class="foot-btnM"><a href="https://osaka-conference.com/reservation/"><img
                src="https://osaka-conference.com/img/ico_form02@2x.png" alt="本申込みフォーム">本申込み</a></li>
          <li class="foot-btnS"><a href="https://osaka-conference.com/downlord/form.pdf" target="_blank"><img
                src="https://osaka-conference.com/img/ico_pdf01@2x.png" alt="PDF">PDF</a></li>
          <li class="foot-btnS"><a href="https://osaka-conference.com/downlord/form.xlsx" target="_blank"><img
                src="https://osaka-conference.com/img/ico_excel01@2x.png" alt="EXCEL">EXCEL</a></li>
        </ul>

        <div class="pc">
          <div class="tel pc">
            <p><em>06-6556-6462</em>予約専用：10時～18時</p>
          </div>
          <p class="txt">ご予約、お問合せ専用番号となります。<br>会場アクセスやイベント内容についてのお問い合わせはお控え下さい。</p>
        </div>
        <div class="mt20 pc">
          <div class="fax pc">
            <p><em>06-6538-4315</em>24時間受付</p>
          </div>
        </div>

        <div class="pc contactBtn_area">
          <div class="btn"><a href="https://osaka-conference.com/contact/">問い合わせ</a></div>

        </div>
        <div class="foot-tel-wrap sp">
          <div class="tel">
            <div class="sp"><span>お電話でのお問い合わせ(10時～18時)</span></div>
            <p class="telNo"><em><a href="tel:0665566462"
                  onclick="gtag('event','tel-tap',{'event_category':'click'});">06-6556-6462</a></em></p>
            <p class="note">ご予約、お問合せ専用番号となります。<br>会場アクセスやイベント内容についてのお問い合わせはお控え下さい。</p>
          </div>
          <div class="allbtn green"><a href="https://osaka-conference.com/contact/"><img
                src="https://osaka-conference.com/img/icon_mail.png" alt="問い合わせ"><span>問い合わせ</span></a></div>
        </div>
      </div>

      <ul class="footerpagelist pc">
        <li><a href="https://osaka-conference.com/">TOP</a></li>
        <li><a href="https://osaka-conference.com/rental/">会場一覧</a></li>
        <li><a href="https://osaka-conference.com/rental/yotsubashi/">四ツ橋エリア</a></li>
        <li><a href="https://osaka-conference.com/rental/shinsaibashi/">心斎橋エリア</a></li>
        <li><a href="https://osaka-conference.com/rental/honmachi/">本町エリア</a></li>
        <li><a href="https://osaka-conference.com/rental/namba/">なんばエリア</a></li>
        <li><a href="https://osaka-conference.com/rental/shinosaka/">新大阪(江坂)エリア</a></li>
        <!--<li><a href="https://osaka-conference.com/rental/nagahoribashi/">長堀橋エリア</a></li>-->
      </ul>
      <ul class="footerpagelist pc">
        <li><a href="https://osaka-conference.com/price/">料金表</a></li>
        <li><a href="https://osaka-conference.com/characteristic/">特徴</a></li>
        <li><a href="https://osaka-conference.com/flow/">利用の流れ</a></li>
        <li><a href="https://osaka-conference.com/rental/about/TermsOfService.pdf" target="_blank">利用規約</a></li>
        <li><a href="https://osaka-conference.com/cancelpolicy/">キャンセルポリシー</a></li>
        <li><a href="https://osaka-conference.com/faq/">よくある質問</a></li>
        <li><a href="https://osaka-conference.com/voice/">お客様の声</a></li>
        <li><a href="https://osaka-conference.com/clients/">取引実績</a></li>
        <li><a href="https://osaka-conference.com/calendar/">カレンダー</a></li>
        <li><a href="https://osaka-conference.com/news/">新着ニュース</a></li>
        <li><a href="https://osaka-conference.com/contact/">問い合わせ</a></li>
      </ul>
      <ul class="footerpagelist pc">
        <li><a href="https://osaka-conference.com/characteristic/free-equipment/">無料備品が多数</a></li>
        <li><a href="https://osaka-conference.com/characteristic/access/">駅チカ！アクセス抜群！</a></li>
        <li><a href="https://osaka-conference.com/characteristic/night-use/">夜間激安</a></li>
        <li><a href="https://osaka-conference.com/characteristic/regular-use/">定期利用のお客様へ</a></li>
        <li><a href="https://osaka-conference.com/characteristic/high-grade/">音響ハイグレード</a></li>
        <li><a href="https://osaka-conference.com/characteristic/training/">説明会・面接・研修に最適</a></li>
        <li><a href="https://osaka-conference.com/catering/">ケータリング</a></li>
        <li><a href="https://osaka-conference.com/column/">コラム</a></li>
        <li><a href="https://osaka-conference.com/seminar-manual/">セミナー主催者マニュアル</a></li>
        <li><a href="https://osaka-conference.com/company/">会社概要</a></li>
        <li><em class="footerLink"><a href="https://osaka-conference.com/privacypolicy/">プライバシーポリシー</a></em></li>
      </ul>

      <div class="sp">
        <ul class="footerpagelist FmenuT">
          <li><a href="javascript:void(0)" onclick="return false;">MENU</a><img
              src="https://osaka-conference.com/img/icon_plus.png" alt="MENU" class="cImg fR"></li>
        </ul>
        <ul class="footerpagelist">
          <li><a href="https://osaka-conference.com/">TOP</a></li>
          <li><a href="https://osaka-conference.com/price/">料金表</a></li>
          <li><a href="https://osaka-conference.com/characteristic/">特徴</a></li>
          <li><a href="https://osaka-conference.com/flow/">利用の流れ</a></li>
          <li><a href="https://osaka-conference.com/rental/about/TermsOfService.pdf" target="_blank">利用規約</a></li>
          <li><a href="https://osaka-conference.com/cancelpolicy/">キャンセルポリシー</a></li>
          <li><a href="https://osaka-conference.com/faq/">よくある質問</a></li>
          <li><a href="https://osaka-conference.com/voice/">お客様の声</a></li>
          <li><a href="https://osaka-conference.com/clients/">取引実績</a></li>
          <li><a href="https://osaka-conference.com/calendar/">カレンダー</a></li>
          <li><a href="https://osaka-conference.com/news/">新着ニュース</a></li>
          <li><a href="https://osaka-conference.com/contact/">問い合わせ</a></li>
          <li><a href="https://osaka-conference.com/characteristic/free-equipment/">無料備品が多数</a></li>
          <li><a href="https://osaka-conference.com/characteristic/access/">駅チカ！アクセス抜群！</a></li>
          <li><a href="https://osaka-conference.com/characteristic/night-use/">夜間激安</a></li>
          <li><a href="https://osaka-conference.com/characteristic/regular-use/">定期利用のお客様へ</a></li>
          <li><a href="https://osaka-conference.com/characteristic/high-grade/">音響ハイグレード</a></li>
          <li><a href="https://osaka-conference.com/characteristic/training/">説明会・面接・研修に最適</a></li>
          <li><a href="https://osaka-conference.com/catering/">ケータリング</a></li>
          <li><a href="https://osaka-conference.com/column/">コラム</a></li>
          <li><a href="https://osaka-conference.com/seminar-manual/">セミナー主催者マニュアル</a></li>
          <li><a href="https://osaka-conference.com/company/">会社概要</a></li>
          <li><em class="footerLink"><a href="https://osaka-conference.com/privacypolicy/">プライバシーポリシー</a></em></li>
        </ul>

        <ul class="footerpagelist FmenuT">
          <li><a href="javascript:void(0)" onclick="return false;">会場一覧</a><img
              src="https://osaka-conference.com/img/icon_plus.png" alt="MENU" class="cImg fR"></li>
        </ul>
        <ul class="footerpagelist">
          <li><a href="https://osaka-conference.com/rental/">すべての会場</a></li>
          <li><a href="https://osaka-conference.com/rental/yotsubashi/">四ツ橋エリア</a></li>
          <li><a href="https://osaka-conference.com/rental/shinsaibashi/">心斎橋エリア</a></li>
          <li><a href="https://osaka-conference.com/rental/honmachi/">本町エリア</a></li>
          <li><a href="https://osaka-conference.com/rental/namba/">なんばエリア</a></li>
          <li><a href="https://osaka-conference.com/rental/shinosaka/">新大阪(江坂)エリア</a></li>
          <li><a href="https://osaka-conference.com/rental/nagahoribashi/">長堀橋エリア</a></li>
        </ul>

      </div>
    </nav>
  </footer>
  <div class="copyright contents">
    <address><img src="https://osaka-conference.com/img/footer_logo.png" alt="株式会社SMG" />SMGアクセア貸し会議室　<br
        class="sp">〒550-0014　大阪市西区北堀江1丁目6番2号 サンワールドビル11階</address>
    <p>COPY RIGHT © SMGアクセア貸し会議室 ALL RIGHTS RESERVED.</p>
  </div>

  <div class="pc banner sticky">
    <div class="block contents">
      <ul>
        <li><a href="https://osaka-conference.com/rental/"><img
              src="https://osaka-conference.com/img/banner_roomlist.jpg" alt="大阪市内主要エリア"></a></li>
        <li><a href="https://osaka-conference.com/characteristic/"><img
              src="https://osaka-conference.com/img/banner_kakuyasu.jpg" alt="格安貸し会議室"></a></li>
        <li><a href="https://osaka-conference.com/characteristic/free-equipment/"><img
              src="https://osaka-conference.com/img/banner_freegoods_mini.png" alt="無料備品が多数！"></a></li>
        <li><a href="https://osaka-conference.com/characteristic/night-use/"><img
              src="https://osaka-conference.com/img/banner_night_mini.png" alt="夜間激安"></a></li>
        <div class="tel">
          <dl>
            <dt><span>予約専用</span>10時～18時</dt>
            <dd>
              <div class="telNo">06-6556-6462</div>
            </dd>
          </dl>
        </div>
    </div>
  </div>
  </div>

  <script type="text/javascript" src="//www.googleadservices.com/pagead/conversion_async.js"></script>
</body>

</html>








{{-- <!doctype html>
<html lang="ja">

<head>
  <title>Starter Template for Bootstrap · Bootstrap</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <link href="starter-template.css" rel="stylesheet">
</head>

<body>
  <style>
  </style>
  <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
    <a class="navbar-brand" href="#">SMG貸し会議室</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
  </nav>

  <main role="main" class="container">
    <div class="starter-template">

      <div class="container">
        <div class="py-5 text-center" style="margin-top: 100px;">
          <h2>会員登録</h2>
          <p class="lead">以下のフォームに沿って情報を入力してください。
          </p>
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
<div class="row">
  <div class="col-md-12 order-md-1">
    <h4 class="mb-3">会員情報登録</h4>
    <form method="POST" action="{{ route('user.register') }}">
      @csrf

      <div class="mb-3">
        <label for="company">会社・団体名</label>
        <div class="input-group">
          <input type="text" class="form-control" id="company" name="company" placeholder="会社名">
        </div>
        <div><input type="checkbox">所属する会社・団体はないので個人で登録します</div>

      </div>

      <div>担当者氏名</div>
      <div class="row">
        <div class="col-md-6 mb-3">
          <label for="firstName">姓</label>
          <input type="text" class="form-control" id="first_name" name="first_name" placeholder="浦島" value="">
        </div>
        <div class="col-md-6 mb-3">
          <label for="lastName">名</label>
          <input type="text" class="form-control" id="last_name" name="last_name" placeholder="太郎" value="">
        </div>
      </div>

      <div class="row">
        <div class="col-md-6 mb-3">
          <label for="first_name_kana">セイ</label>
          <input type="text" class="form-control" id="first_name_kana" name="first_name_kana" placeholder="ウラシマ"
            value="">
        </div>
        <div class="col-md-6 mb-3">
          <label for="last_name_kana">カナ</label>
          <input type="text" class="form-control" id="last_name_kana" name="last_name_kana" placeholder="タロウ" value="">
        </div>
      </div>

      <div class="mb-3">
        <label for="post_code">郵便番号</label>
        <input type="text" class="form-control" id="post_code" name="post_code" placeholder="1234567">
        <small class="text-muted">※「ー」(ハイフン)は省略、半角数字のみで入力してください</small>
      </div>

      <div class="mb-3">
        <label for="address1">都道府県</label>
        <input type="text" class="form-control" id="address1" name="address1" placeholder="">
      </div>

      <div class="mb-3">
        <label for="address2">市町村番地</label>
        <input type="text" class="form-control" id="address2" name="address2" placeholder="">
      </div>

      <div class="mb-3">
        <label for="address3">建物名</label>
        <input type="text" class="form-control" id="address3" name="address3" placeholder="">
      </div>

      <div>電話番号<br>（携帯電話・固定電話のどちらか一方は必須入力です）</div>
      <div class="row">
        <div class="col-md-6 mb-3">
          <label for="mobile">携帯電話</label>
          <input type="text" class="form-control" id="mobile" name="mobile" placeholder="00011112222" value="">
          <small class="text-muted">※「ー」(ハイフン)は省略、半角数字のみで入力</small>
        </div>
        <div class="col-md-6 mb-3">
          <label for="tel">固定電話</label>
          <input type="text" class="form-control" id="tel" name="tel" placeholder="00011112222" value="">
          <small class="text-muted">※「ー」(ハイフン)は省略、半角数字のみで入力してください</small>
        </div>
      </div>

      <div class="mb-3">
        <label for="fax">FAX</label>
        <input type="text" class="form-control" id="fax" name="fax" placeholder="">
        <small class="text-muted">※「ー」(ハイフン)は省略、半角数字のみで入力してください</small>
      </div>

      <div class="mb-3">
        <label for="email">メールアドレス</label>
        <input type="email" class="form-control" id="email" name="email" placeholder="sample@sample.com">
      </div>

      <div class="mb-3">
        <label for="password">パスワード</label>
        <input type="password" class="form-control" id="password" name="password" placeholder="">
      </div>

      <div class="mb-3">
        <label for="password-confirm">パスワード確認</label>
        <input id="password-confirm" type="password" class="form-control" name="password_confirmation"
          autocomplete="new-password">
      </div>

      <div>SMGを何で知りましたか</div>
      <div class="mb-3">
        <label for="password">PC検索</label>
        <div class="d-block my-3">
          <div class="custom-control custom-radio">
            <input id="google" name="quest_pc" type="radio" class="custom-control-input" checked>
            <label class="custom-control-label" for="credit">Google</label>
          </div>
          <div class="custom-control custom-radio">
            <input id="yahoo" name="quest_pc" type="radio" class="custom-control-input">
            <label class="custom-control-label" for="debit">Yahoo</label>
          </div>
          <div class="custom-control custom-radio">
            <input id="pc_other" name="quest_pc" type="radio" class="custom-control-input">
            <label class="custom-control-label" for="paypal">その他</label>
          </div>
        </div>

        <div class="mb-3">
          <label for="password">PC以外</label>
          <div class="d-block my-3">
            <div class="custom-control custom-radio">
              <input id="search_phone" name="quest_others" type="radio" class="custom-control-input" checked>
              <label class="custom-control-label" for="search_phone">スマホ検索</label>
            </div>
            <div class="custom-control custom-radio">
              <input id="introduce" name="quest_others" type="radio" class="custom-control-input">
              <label class="custom-control-label" for="introduce">ご紹介</label>
            </div>
            <div class="custom-control custom-radio">
              <input id="mail_magazine" name="quest_others" type="radio" class="custom-control-input">
              <label class="custom-control-label" for="mail_magazine">メルマガ</label>
            </div>
            <div class="custom-control custom-radio">
              <input id="signboard" name="quest_others" type="radio" class="custom-control-input">
              <label class="custom-control-label" for="signboard">看板・チラシ</label>
            </div>
            <div class="custom-control custom-radio">
              <input id="others_others" name="quest_others" type="radio" class="custom-control-input">
              <label class="custom-control-label" for="others_others">その他</label>
            </div>
          </div>
        </div>

        <hr class="mb-4">
        <button class="btn btn-primary btn-lg btn-block" type="submit">Continue to checkout</button>
    </form>
  </div>
</div>

</div>


</div>

</main><!-- /.container -->

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
  integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
</script>
<script>
  window.jQuery || document.write('<script src="/docs/4.3/assets/js/vendor/jquery-slim.min.js"><\/script>')
</script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
<script src="/docs/4.3/assets/js/vendor/anchor.min.js"></script>
<script src="/docs/4.3/assets/js/vendor/clipboard.min.js"></script>
<script src="/docs/4.3/assets/js/vendor/bs-custom-file-input.min.js"></script>
<script src="/docs/4.3/assets/js/src/application.js"></script>
<script src="/docs/4.3/assets/js/src/search.js"></script>
<script src="/docs/4.3/assets/js/src/ie-emulation-modes-warning.js"></script>
</body>

</html> --}}