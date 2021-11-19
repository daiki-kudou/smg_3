<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=1200, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ config('app.name', 'Laravel') }}</title>
  <script src="{{ asset('js/app.js') }}"></script>
  <link rel="dns-prefetch" href="//fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
  <link href="{{ asset('css/reset.css')}}" rel="stylesheet">
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
  <script src="{{ asset('/js/jquery.validate.min.js') }}"></script>
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1/i18n/jquery.ui.datepicker-ja.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/wickedpicker@0.4.3/dist/wickedpicker.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/wickedpicker@0.4.3/dist/wickedpicker.min.js"></script>
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <script src="{{ asset('/js/numeric.js') }}"></script>
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css" />
  <script type="text/javascript" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
  <script src="{{ asset('/js/admin/side_menu.js') }}"></script>
</head>

<body class="hold-transition sidebar-mini">
  <div class="wrapper pc_wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light d-flex justify-content-between">
      <!-- Left navbar links -->
      <ul class="navbar-nav d-block">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
      </ul>
      <div class="dropdown">
        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown"
          aria-haspopup="true" aria-expanded="false">
          ログイン中：{{Auth::user()->name}}
        </button>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
          <div>
            {{-- ログアウト用 --}}
            <a class="dropdown-item" href="{{ route('admin.logout') }}"
              onclick="event.preventDefault();document.getElementById('logout-form').submit();">
              {{ __('Logout') }}
            </a>
            <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="">
              @csrf
            </form>
            {{-- ログアウト用 --}}
          </div>
        </div>
      </div>
    </nav>

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4" style="{{Auth::user()->id===8?'background: teal':""}}">
      <!-- Brand Logo -->
      <a href="/admin/home" class="brand-link">
        <span class="brand-text font-weight-light">SMGアクセア貸し会議室<br>管理者画面</span>
      </a>
      @include('layouts.admin.side')
      <!-- Sidebar -->
    </aside>
    <!-- /.navbar -->
    <div class="content-wrapper">
      <div class="content">
        <div class="container-fluid">
          @yield('content')
        </div>
      </div>
    </div>
  </div>
  <script src="{{ asset('js/adminlte.min.js') }}"></script>
  <script src="{{ asset('js/confirm.js') }}"></script>
  <script>
    $(function(){
      $('input').each(function(index, element){
        var this_val=Number($('input').eq(index).val().replace(/,/g, '').replace(/合計：/g, '').replace(/円/g, '').replace(/小計：/g, '').replace(/消費税：/g, '').replace(/合計金額：/g, ''));
        if (this_val<0) {
          $('input').eq(index).css('color','red');
        }
      })
      $('td').each(function(index, element){
        var target =Number($('td').eq(index).text().replace(/,/g, '').replace(/合計：/g, '').replace(/円/g, '').replace(/小計：/g, '').replace(/消費税：/g, '').replace(/合計金額：/g, ''));
        if (target<0) {
          $('td').eq(index).css('color','red');
        } 
      })
      $('dd').each(function(index, element){
        var target =Number($('dd').eq(index).text().replace(/,/g, '').replace(/合計：/g, '').replace(/円/g, '').replace(/小計：/g, '').replace(/消費税：/g, '').replace(/合計金額：/g, ''));
        if (target<0) {
          $('dd').eq(index).css('color','red');
        } 
      })
    })

    // // 自動補完無効
    $(function(){
      $('input[=type"text"]').each(function(index, element){
        var this_val=$('input[=type"text"]').eq(index);
        this_val.on("mousedown", function(){
        setTimeout(function(){
        this_val.focus();
        }, 1);
        return false;
        });
        })
    })

    // // enterキー無効
    $(function(){
        $("input").on("keydown", function(e) {
            if ((e.which && e.which === 13) || (e.keyCode && e.keyCode === 13)) {
                return false;
            } else {
                return true;
            }
        });
    });

    var rootPath="{{url('/')}}";
    var currentRouteName="{{Route::currentRouteName()}}";
  </script>
</body>

</html>