<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="description" content="Neflix Video Distribution System">
  <meta name="keywords" content="">
  <meta name="author" content="">
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Netflix Video Distribution System - @yield('title')</title>

  @include('layout.assets.css')
  @include('layout.assets.js')

  @yield('custom-css')

</head>

<body>

  @include('layout.header')

  <div class="main-content">
    @yield('content')
  </div><!-- end main-content -->

  @include('layout.footer')

  @yield('custom-js')

</body>
</html>
