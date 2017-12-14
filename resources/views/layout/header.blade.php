@if(Auth::check())

<div class="navbar navbar-inverse set-radius-zero">
  <div class="container">
    <div class="col-md-6 no-padding-left">
      <div class="navbar-header" style="margin-top: 10px;">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="logo-class" href="/dashboard">
          <img src="{{ asset('images/netflix-logo-small.png') }}" alt="">
        </a>

      </div><!-- end navbar-header -->
    </div><!-- end col-md-6 -->

    @if(Auth::user()->role == 0 || Auth::user()->role == 1)
    <div class="navbar-collapse collapse no-padding-right">
      <ul id="menu-top" class="nav navbar-nav navbar-right">
        <li><a class="#" href="/videos"><i class="fa fa-video-camera"></i> Videos</a></li>
        <li><a class="#" href="/schedules"><i class="fa fa-calendar"></i> Schedules</a></li>
        <li><a class="#" href="/stores"><i class="fa fa-home"></i> Stores</a></li>

        @if(Auth::user()->role == 0)
        <li><a class="#" href="/settings"><i class="fa fa-cogs"></i> Settings</a></li>
        <li><a class="#" href="/faq"><i class="fa fa-question-circle"></i> Faq</a></li>
        @endif
      </ul>
    </div><!-- end navbar-collapse -->
    @endif

    @if(Auth::user()->role == 2)
    <div class="navbar-collapse collapse no-padding-right">
      <ul id="menu-top" class="nav navbar-nav navbar-right">
        <li><a class="#" href="/videos"><i class="fa fa-video-camera"></i> Videos</a></li>
        <li><a class="#" href="/client/schedules"><i class="fa fa-calendar"></i> Schedules</a></li>
        <li><a class="#" href="/stores"><i class="fa fa-home"></i> Stores</a></li>
        <li><a class="#" href="/client/setting"><i class="fa fa-cogs"></i> Settings</a></li>
        <li><a class="#" href="/faq"><i class="fa fa-question-circle"></i> Faq</a></li>
      </ul>
    </div><!-- end navbar-collapse -->
    @endif

  </div><!-- end container -->
</div><!-- end navbar -->

@php

  $country_name = Session::get('country_name');
  $store_name = Session::get('store_name');

@endphp

<header class="color-bar">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        @if(Auth::user()->role != 2)
        <strong>Welcome, </strong>
        <span style="color: #f4f4f4; font-weight: bold;" class="user-name">{{ Auth::user()->full_name }}</span>
        @else
        <strong class="user-name">{{ $country_name }} : {{ $store_name }}</strong>
        @endif
        <div class="user-top-right btn-group">
          <a type="button" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="caret"></span>
          </a>
          <ul class="dropdown-menu dropdown-menu-right">
            <li class="last hover-link"><a href="/usermanual">User Manual</a></li>
            @if(Auth::user()->role != 2)
            <li class="last hover-link"><a href="/auth/logout">Logout</a></li>
            @else
            <li class="last hover-link"><a href="/client/logout">Logout</a></li>
            @endif
          </ul>
        </div>
      </div><!-- end col-md-12 -->

    </div><!-- end row -->
  </div><!-- end container -->
</header><!-- end header -->

<div class="page-top-shadow">

</div>

@endif
