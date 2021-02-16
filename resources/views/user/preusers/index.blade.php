<!doctype html>
<html lang="ja">

<head>
    <title>Starter Template for Bootstrap · Bootstrap</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link href="starter-template.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>

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

        .hide {
            display: none;
        }
    </style>
    <script>
        $(function() {
            $('.btn').on('click', function() {
                $(this).addClass('hide')
                $('#spinner').removeClass('hide');
            })
        })
    </script>

    <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
        <a class="navbar-brand" href="#">SMG貸し会議室</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    </nav>

    <main role="main" class="container">
        <div class="starter-template">
            <h1>会員登録</h1>
            <p class="lead">メールアドレスを入力してください。会員登録のフォームのご案内をします。</p>
            <div style="margin-top: 50px;width: 500px;" class="form-group mx-auto">
                <form action="/user/preusers/create" method="POST">
                    {{ csrf_field() }}
                    <label for="email">メールアドレス</label>
                    <input type="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="sample@sample.com" name="email">
                    <button type="submit" class="btn btn-primary">送信する</button>
                    {{-- スピナー --}}
                    <button class="btn btn-primary hide" type="button" disabled id="spinner">
                        <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                        送信しています...
                    </button>
                </form>
            </div>
        </div>
    </main><!-- /.container -->
</body>

</html>