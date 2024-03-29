<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'Laravel') }}</title>

  <script src="{{ asset('js/app.js') }}"></script>

  <link rel="dns-prefetch" href="//fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

  <link href="{{ asset('css/adminlte.min.css')}}" rel="stylesheet">

  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>

  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

  <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/multi-select/0.9.12/js/jquery.multi-select.min.js"></script>

  <script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>

  <script src="https://kit.fontawesome.com/a98e58f6de.js" crossorigin="anonymous"></script>

  <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.2/dist/jquery.validate.min.js"></script>

  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1/i18n/jquery.ui.datepicker-ja.min.js"></script>

  <link href="https://cdn.jsdelivr.net/npm/wickedpicker@0.4.3/dist/wickedpicker.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/wickedpicker@0.4.3/dist/wickedpicker.min.js"></script>

  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>


  <script src="{{ asset('/js/numeric.js') }}"></script>

  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css" />
  <script type="text/javascript" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>

</head>

<body class="hold-transition sidebar-mini">
  <div class="wrapper user_wrapper">
    <nav class="main-header navbar navbar-expand navbar-white navbar-light d-flex justify-content-between">
      <div class="d-flex align-items-center">
        <ul class="navbar-nav d-block">
          <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
          </li>
        </ul>
        <div class="d-flex ml-3">
          <div class="mr-3">会員ID：{{ReservationHelper::fixId(Auth::id())}}</div>
          <div class="user_info mr-3">会社・団体名：{{ReservationHelper::getCompany(Auth::id())}}</div>
          <div class="user_info">メール：{{(Auth::user()->email)}}</div>
        </div>
      </div>
      <div>
        <a class="dropdown-item" href="{{ route('user.logout') }}"
          onclick="event.preventDefault();document.getElementById('logout-form').submit();">
          {{ __('ログアウト') }}
        </a>
        <form id="logout-form" action="{{ route('user.logout') }}" method="POST" style="">
          @csrf
        </form>
      </div>
    </nav>

    <aside class="main-sidebar elevation-4">
      <a href="/user/home" class="brand-link">
        <span class="brand-text font-weight-light">SMGアクセア貸し会議室<br>マイページ</span>
      </a>

      @include('layouts.user.side')

      <div class="company-info">
        <p>SMGアクセア貸し会議室</p>
        <p class="company-tell">06-6556-6462</p>
        <p>平日10時～18時</p>
        <p>kaigi@s-mg.co.jp</p>
        <a href="{{url('https://system.osaka-conference.com/')}}" target="_blank" rel="noopener noreferrer"
          class="company-info-sitelink nav-link">
          WEBサイトを見る<span><i class="fas fa-chevron-right"></i></span></a>
      </div>
    </aside>
    <style>
      .main-sidebar {
        background-color: #ffff99;
      }

      .main-sidebar a {
        color: #6c757d;
      }

      .nav-pills .nav-link.active {
        background-color: #9d9d9d;
      }

      .nav-pills .nav-link:not(.active):hover {
        color: #ababab;
      }
    </style>

    <div class="content-wrapper">
      <div class="content">
        <div class="container-fluid">

          @yield('content')
        </div>
      </div>
    </div>

    <script src="{{ asset('js/adminlte.min.js') }}"></script>
    <script>
      var rootPath="{{url('/')}}";
      // マイナスを赤字に
          $('HTML').on('DOMSubtreeModified propertychange', function() {
          // DOMが変更された時に動く処理
          $('input').each(function(index, element){
          var this_val=$('input').eq(index);
          if (Number(this_val.val())<0) { this_val.css('color','red'); }else if(Number(this_val.val())>0){
            // this_val.css('color','black');
            }
            })
            });
          
            $(function(){
            $('input').each(function(index, element){
            var this_val=Number($('input').eq(index).val().replace(/,/g, '').replace(/合計：/g, '').replace(/円/g, '').replace(/小計：/g,
            '').replace(/消費税：/g, '').replace(/合計金額：/g, ''));
            
            if (this_val<0) { 
              $('input').eq(index).css('color','red'); 
            } 
          }) 
          
          $('td').each(function(index, element){ 
            var target=Number($('td').eq(index).text().replace(/,/g, '' ).replace(/合計：/g, '' ).replace(/円/g, '' ).replace(/小計：/g, ''
              ).replace(/消費税：/g, '' ).replace(/合計金額：/g, '' )); 
              
              if (target<0) {
                 $('td').eq(index).css('color','red'); 
                } })

              $('dd').each(function(index, element){ 
                var target=Number($('dd').eq(index).text().replace(/,/g, '').replace(/合計：/g, '' ).replace(/円/g, '' ).replace(/小計：/g, '' ).replace(/消費税：/g, '' ).replace(/合計金額：/g, '' )
                ); 
                if(target<0) { 
                  $('dd').eq(index).css('color','red'); } }) 
                }
                )
     
    </script>

  </div>

</body>

</html>