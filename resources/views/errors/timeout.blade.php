@extends('layouts.reservation.app')
@section('content')

<main>
  <div class="contents">
    <div class="pagetop-text">
      <h1 class="page-title oddcolor"><span>会員登録URLの有効期限が切れました。</span></h1>
    </div>
  </div>

  <section class="contents block" id="cartNone">
    <div class="block">
      <p class="page-text">再度、会員登録画面にてメールアドレスを入力してください。
      </p>
      <p class="page-text"><a href="{{url('/user/preusers')}}">会員登録画面へ＞＞</a>
      </p>
    </div>
    <div class="sitemaplist">
      <ul>
        <li><a href="https://system.osaka-conference.com/">TOP</a></li>
        <li><a href="https://system.osaka-conference.com/rental/">会場一覧</a></li>
        <li><a href="https://system.osaka-conference.com/price/">料金表</a></li>
        <li><a href="https://system.osaka-conference.com/characteristic/">特徴</a></li>
        <li><a href="https://system.osaka-conference.com/flow/">利用の流れ</a></li>
        <li><a href="https://system.osaka-conference.com/rental/about/TermsOfService.pdf" target="_blank">利用規約</a></li>
        <li><a href="https://system.osaka-conference.com/cancelpolicy/">キャンセルポリシー</a></li>
        <li><a href="https://system.osaka-conference.com/faq/">よくある質問</a></li>
        <li><a href="https://system.osaka-conference.com/calendar/">カレンダー</a></li>
        <li><a href="https://system.osaka-conference.com/news/">新着ニュース</a></li>
        <li><a href="https://system.osaka-conference.com/contact/">問い合わせ</a></li>
      </ul>
      <ul>
        <li><a href="https://system.osaka-conference.com/characteristic/free-equipment/">無料備品が多数</a></li>
        <li><a href="https://system.osaka-conference.com/characteristic/night-use/">夜間激安</a></li>
        <li><a href="https://system.osaka-conference.com/characteristic/regular-use/">定期利用のお客様へ</a></li>
        <li><a href="https://system.osaka-conference.com/characteristic/high-grade/">音響ハイグレード</a></li>
        <li><a href="">説明会・面接・研修に最適</a></li>
        <li><a href="https://system.osaka-conference.com/catering/">ケータリング</a></li>
        <li><a href="https://system.osaka-conference.com/column/">コラム</a></li>
        <li><a href="https://system.osaka-conference.com/seminar-manual/">セミナー主催者マニュアル</a></li>
      </ul>
      <ul>
        <li><a href="https://system.osaka-conference.com/company/">会社概要</a></li>
        <li><a href="https://system.osaka-conference.com/privacypolicy/">プライバシーポリシー</a></li>
      </ul>
    </div>
  </section>


  <div class="top contents"><a href="#top"><img src="https://system.osaka-conference.com/img/pagetop.png" alt="上に戻る"></a>
  </div>
</main>

@endsection