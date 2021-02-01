<!doctype html>
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
                  <input type="text" class="form-control" id="first_name_kana" name="first_name_kana" placeholder="ウラシマ" value="">
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
                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" autocomplete="new-password">
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

  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
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

</html>