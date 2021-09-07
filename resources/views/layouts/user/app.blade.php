{{-- <!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>SMG貸し会議室</title>

  <!-- Scripts -->
  <script src="{{ asset('js/app.js') }}" defer></script>

  <!-- Fonts -->
  <link rel="dns-prefetch" href="//fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

  <!-- Styles -->
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body>
  <div id="app">
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
      <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
          {{ config('app.name', 'Laravel') }}
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
          aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <!-- Left Side Of Navbar -->
          <ul class="navbar-nav mr-auto">

          </ul>

          <!-- Right Side Of Navbar -->
          <ul class="navbar-nav ml-auto">
            <!-- Authentication Links -->
            @guest('user')
            <li class="nav-item">
              <a class="nav-link" href="{{ route('user.login') }}">{{ __('Login') }}</a>
            </li>
            @if (Route::has('user.register'))
            <li class="nav-item">
              <a class="nav-link" href="{{ route('user.preusers') }}">{{ __('Register') }}</a>
            </li>
            @endif
            @else
            <li class="nav-item dropdown">
              <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false" v-pre>
                {{ Auth::user()->name }} <span class="caret"></span>
              </a>

              <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="{{ route('user.logout') }}"
                  onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                  {{ __('Logout') }}
                </a>

                <form id="logout-form" action="{{ route('user.logout') }}" method="POST" style="display: none;">
                  @csrf
                </form>
              </div>
            </li>
            @endguest
          </ul>
        </div>
      </div>
    </nav>

    <main class="py-4">
      @yield('content')
    </main>
  </div>
</body>

</html> --}}

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

</head>

<body class="hold-transition sidebar-mini">
  <div class="wrapper user_wrapper">
    <nav class="main-header navbar navbar-expand navbar-white navbar-light d-flex justify-content-between">
      <ul class="navbar-nav d-block">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
      </ul>
      <div class="user_info">会員ID：{{Auth::id()}}</div>
      <div class="user_info">メール：{{(Auth::user()->email)}}</div>
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

    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <a href="/user/home" class="brand-link">
        <span class="brand-text font-weight-light">SMGアクセア貸し会議室</span>
      </a>

      @include('layouts.user.side')

      <div class="company-info">
        <p>SMGアクセア貸し会議室</p>
        <p>06-6556-6462</p>
        <p>平日10時～18時</p>
        <p>kaigi@s-mg.co.jp</p>
          <a href="{{url('https://osaka-conference.com/')}}" target="_blank"  rel="noopener noreferrer" class="nav-link">
            WEBサイトを見る<span><i class="fas fa-chevron-right"></i></span></a>
      </div>


    </aside>
    <div class="content-wrapper">
      <div class="content">
        <div class="container-fluid">

          @yield('content')
        </div>
      </div>
    </div>

    <script src="{{ asset('js/adminlte.min.js') }}"></script>

  </div>

</body>

</html>