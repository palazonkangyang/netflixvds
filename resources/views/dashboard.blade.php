@extends('layout.master')
@section('title','Dashboard')
@section('content')

<div class="content-wrapper">
  <div class="container">
    <div class="row">
      <div class="col-md-12"><h4 class="page-head-line">Dashboard</h4></div>
    </div><!-- end row -->

    <div class="row">

      <div class="col-md-3 col-sm-3 col-xs-6">
        <a href="#" class="magic-link">
          <div class="dashboard-div-wrapper bk-clr-one">
            <i class="fa fa-video-camera dashboard-div-icon"></i>
            <div class="progress progress-striped active">
              <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
            </div>
            <h5 style="font-weight: bold">Videos (0)</h5>
          </div><!-- end dashboard-div-wrapper -->
        </a>
      </div><!-- end col-md-3 -->

      <div class="col-md-3 col-sm-3 col-xs-6">
        <a href="#" class="magic-link">
          <div class="dashboard-div-wrapper bk-clr-two">
            <i class="fa fa-calendar dashboard-div-icon"></i>
            <div class="progress progress-striped active">
              <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
              </div>
            </div>
            <h5 style="font-weight: bold">Schedules (0)</h5>
          </div><!-- end dashboard-div-wrapper -->
        </a>
      </div><!-- end col-md-3 -->

      <div class="col-md-3 col-sm-3 col-xs-6">
        <a href="/stores" class="magic-link">
          <div class="dashboard-div-wrapper bk-clr-three">
            <i class="fa fa-users dashboard-div-icon" ></i>
            <div class="progress progress-striped active">
              <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
              </div>
            </div>
            <h5 style="font-weight: bold">Stores ({{ $no_of_stores }})</h5>
          </div><!-- end dashboard-div-wrapper -->
        </a>
      </div><!-- end col-md-3 -->

      <div class="col-md-3 col-sm-3 col-xs-6">
        <a href="/settings/partners" class="magic-link">
          <div class="dashboard-div-wrapper bk-clr-four">
            <i class="fa fa-handshake-o dashboard-div-icon"></i>
            <div class="progress progress-striped active">
              <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
              </div>
            </div>
            <h5 style="font-weight: bold">Partners ({{ $no_of_partners }})</h5>
          </div><!-- end dashboard-div-wrapper -->
        </a>
      </div><!-- end col-md-3 -->

    </div><!-- end row -->

  </div><!-- end container -->

</div><!-- end content-wrapper -->

@stop
