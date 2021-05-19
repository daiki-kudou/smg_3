@extends('layouts.user.auth')

@section('content')


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
    jQuery(document).ready(function($) {
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
    $(window).load(function() {
      $(".box0>li").heightLine();
      //$(".box01>li").heightLine();
          if(window.matchMedia('(min-width: 751px)').matches) {
              $(".room-data").heightLine();
              $(".conference-roominner>.conference-roomdata").heightLine();
              $(".top-characteristic-index .contents .featurelist .three dl>dt").heightLine();
          }
  });
  $(function() {
      if(window.matchMedia('(min-width: 751px)').matches) {
          setTimeout (function() {
              $('#tablist .r-tabs-tab a.r-tabs-anchor').on('click', function() {
                  $('.other-servicelist>.item-block').heightLine();
              });
          }, 10);
      }
  });
  </script>
  <script>
    if($().Stickyfill){　$('.sticky').Stickyfill(); }
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
  <script src="https://osaka-conference.com/js/jquery.validationEngine-ja.js"></script>
  <script src="https://osaka-conference.com/js/jquery.validationEngine.js"></script>
  <script src="https://osaka-conference.com/js/form.js"></script>
  <script type="text/javascript">
    $(function(){
       var today = new Date();
       var dd = today.getDate();
  　$("#datepicker").datepicker({
       showOn: "both",
       buttonImage: "https://osaka-conference.com/img/icon_calender.png",
       buttonImageOnly: true,
       minDate: "+3",
       maxDate: "+3M -" + dd,
       beforeShow: function(input, inst) { // カレンダーを必ず下側へ表示させるための表示位置計算function
                  var top  = $(this).offset().top + $(this).outerHeight();
                  var left = $(this).offset().left;
                  setTimeout(function() {
                          inst.dpDiv.css({
                                  'top' : top,
                                  'left': left
                          });
                  }, 10) // 10msec
          }       
   });
  $("ul.tabBtn li").mouseover(function(){
                  if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
                      $(this).click();
                  }
              });
  $(".hasDatepicker, .ui-datepicker, .ui-datepicker-trigger").click(function(event) {
      event.stopPropagation();
  });
  $(".contents").bind("click touchstart, touchmove", function(event) {
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

      <!-- パンくずなど -->
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
      @if (session('flash_message'))
      <div class="contents">
        <div class="pagetop-text">
          <h1 class="page-title oddcolor"><span>会員登録完了</span></h1>
        </div>
        <div class="text-box">
          <p class="text-center">会員登録が完了しました。<br>下記より、ログインしてください。</p>
        </div>
      </div>
      @else
      <div class="contents">
        <div class="pagetop-text">
          <h1 class="page-title oddcolor"><span>ログイン/会員登録</span></h1>
        </div>
      </div>
      @endif


      <section class="contents">
        <form method="POST" action="{{ route('user.login') }}">
          @csrf

          <div class="form-group row">
            <label for="email" class="col-md-4 col-form-label text-md-right">メールアドレス</label>

            <div class="col-md-6">
              <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                value="{{ old('email') }}" required autocomplete="email" autofocus>

              @error('email')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
              @enderror
            </div>
          </div>

          <div class="form-group row">
            <label for="password" class="col-md-4 col-form-label text-md-right">パスワード</label>

            <div class="col-md-6">
              <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                name="password" required autocomplete="current-password">

              @error('password')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
              @enderror
            </div>
          </div>

          <div class="form-group row">
            <div class="col-md-6 offset-md-4">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" name="remember" id="remember"
                  {{ old('remember') ? 'checked' : '' }}>

                <label class="form-check-label" for="remember">
                  ログイン状態を保持する
                </label>
                <p><a href="{{url('user/password/reset')}}" target="_blank">パスワードをお忘れの方はこちら</a></p>
              </div>
            </div>
          </div>

          <div class="btn-wrapper2">
            <button type="submit" class="btn">
              ログイン
            </button>
          </div>
        </form>

        <div class="borderBox page-text">
          <p>WEBからの予約をご希望の場合は、会員登録が必要になります。<br>
            お手数ですが、会員登録のお手続きをよろしくお願い致します。</p>

          <div class="btn-wrapper2">
            <a href="{{url('user/preusers')}}">
              <p class="link-btn">
                会員登録をする
              </p>
            </a>
          </div>
        </div>

      </section>



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

  <!-- Global site tag (gtag.js) - Google Analytics -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-57423515-1"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
function gtag(){dataLayer.push(arguments);}
gtag('js', new Date());


gtag('config', 'UA-57423515-1');
  </script>


  <script type="text/javascript" src="//www.googleadservices.com/pagead/conversion_async.js"></script>
</body>

</html>





{{-- 以下デフォルトテンプレ --}}

{{-- <div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">{{ __('Login') }}</div>

<div class="card-body">
  <form method="POST" action="{{ route('user.login') }}">
    @csrf

    <div class="form-group row">
      <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

      <div class="col-md-6">
        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email"
          value="{{ old('email') }}" required autocomplete="email" autofocus>

        @error('email')
        <span class="invalid-feedback" role="alert">
          <strong>{{ $message }}</strong>
        </span>
        @enderror
      </div>
    </div>

    <div class="form-group row">
      <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

      <div class="col-md-6">
        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
          name="password" required autocomplete="current-password">

        @error('password')
        <span class="invalid-feedback" role="alert">
          <strong>{{ $message }}</strong>
        </span>
        @enderror
      </div>
    </div>

    <div class="form-group row">
      <div class="col-md-6 offset-md-4">
        <div class="form-check">
          <input class="form-check-input" type="checkbox" name="remember" id="remember"
            {{ old('remember') ? 'checked' : '' }}>

          <label class="form-check-label" for="remember">
            {{ __('Remember Me') }}
          </label>
        </div>
      </div>
    </div>

    <div class="form-group row mb-0">
      <div class="col-md-8 offset-md-4">
        <button type="submit" class="btn btn-primary">
          {{ __('Login') }}
        </button>
      </div>
    </div>
  </form>
</div>
</div>
</div>
</div>
</div> --}}
@endsection