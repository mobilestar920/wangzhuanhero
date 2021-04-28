<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'Laravel') }}</title>

  <!-- Scripts -->
  <script src="{{ asset('js/app.js') }}" defer></script>

  <!-- Fonts -->
  <link rel="dns-prefetch" href="//fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

  <!-- Styles -->
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  <link href="{{ asset('css/jquery.dataTables.min.css') }}"  rel="stylesheet">

  <script src="{{ asset('js/jquery/jquery.min.js') }}"></script>
  <script src="{{ asset('js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('js/jquery/jquery.dataTables.min.js') }}"></script>

  
  @yield('head')

</head>

<body class="c-app">
  <div class="c-sidebar c-sidebar-dark c-sidebar-fixed c-sidebar-lg-show" id="sidebar">
    @include('dashboard.nav-builder')
  </div>

  <div class="c-wrapper">
    @include('dashboard.header')

    <div class="c-body">

      <main class="c-main">

        @yield('content')

      </main>

      @include('dashboard.footer')
    </div>
  </div>


  <!-- CoreUI and necessary plugins-->
  <script src="{{ asset('js/coreui.bundle.min.js') }}"></script>
  <script src="{{ asset('js/coreui-utils.js') }}"></script>

  @yield('javascript')

</body>

</html>