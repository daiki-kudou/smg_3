<!doctype html>
<html lang="ja">

<head>
    <title>Starter Template for Bootstrap · Bootstrap</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link href="starter-template.css" rel="stylesheet">
</head>

<body>
    <style>
        body {
            padding-top: 5rem;
        }

        .starter-template {
            padding: 3rem 1.5rem;
            text-align: center;
        }
    </style>
    <a id="skippy" class="sr-only sr-only-focusable" href="#content">
        <div class="container">
            <span class="skiplink-text">Skip to main content</span>
        </div>
    </a>

    <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
        <a class="navbar-brand" href="#">SMG貸し会議室</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    </nav>
    <main role="main" class="container">
        <div class="starter-template">
            <h1>会員登録フォーム送信</h1>
            <div style="margin-top: 50px;width: 900px;" class="form-group mx-auto">
                <p>{{$email}}　へ会員登録フォームメールを送付しました。<br>
                    １時間以内に受信されていない場合はメールアドレスのお間違えの可能性がございますので、ご理解ください。<br><br><br>

                    会員登録メールに会員登録のためのURLが記載されております。<br>
                    こちらのURLの有効期限は１時間となりますので、ご注意お願い致します。<br><br><br>

                    ※弊社からの自動返信がお客様のメール利用環境により迷惑フォルダに受信される場合がございます。<br>
                    お手数ですが迷惑フォルダにもご確認いただけましたら幸いです。その場合は<br>
                    【&#064;s-mg.co.jo】を受信設定していただきますようお願いします。<br>
                </p>
            </div>
        </div>
    </main><!-- /.container -->
</body>

</html>