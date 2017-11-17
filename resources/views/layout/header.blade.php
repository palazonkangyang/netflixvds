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

    <div class="navbar-collapse collapse no-padding-right">
      <ul id="menu-top" class="nav navbar-nav navbar-right">
        <li><a class="#" href="#"><i class="fa fa-video-camera"></i> Videos</a></li>
        <li><a class="#" href="#"><i class="fa fa-calendar"></i> Schedules</a></li>
        <li><a class="#" href="/stores"><i class="fa fa-home"></i> Stores</a></li>

        @if(Auth::user()->role == 0)
        <li><a class="#" href="/settings"><i class="fa fa-cogs"></i> Settings</a></li>
        @endif
      </ul>
    </div><!-- end navbar-collapse -->

  </div><!-- end container -->
</div><!-- end navbar -->

<header>
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <strong>Welcome, </strong>
        <span style="color: #f4f4f4; font-weight: bold;">{{ Auth::user()->username }}</span>
        <div class="user-top-right btn-group">
          <a type="button" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="caret"></span>
          </a>
          <ul class="dropdown-menu dropdown-menu-right">
            <li class="last"><a href="/auth/logout">Logout</a></li>
          </ul>
        </div>
      </div><!-- end col-md-12 -->

    </div><!-- end row -->
  </div><!-- end container -->
</header><!-- end header -->

@endif
