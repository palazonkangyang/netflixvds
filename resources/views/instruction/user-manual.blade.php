@extends('layout.master')
@section('title', 'User Manual')
@section('content')

<div class="content-wrapper">
  <div class="container">

    <div class="row">

      <div class="col-md-12">
        <h4 class="page-head-line">User Manual</h4>
      </div><!-- end col-md-12 -->

    </div><!-- end row -->

    <div class="wrap-content">

      <div class="row">

        <div class="col-md-12">
          <h5>Video Module</h5>

          <ul>
            <li>Able to manage the videos</li>
            <li>Able to edit and remove the selected video information</li>
            <li>Able to filter/search the videos by date range, category and keywords, keyword will search code, title and description.</li>
            <li>Able to quick access to upload new video by clicking on “Upload New” button.</li>
          </ul>

          <h5>Schedule Module</h5>

          <ul>
            <li>Able to manage the schedules</li>
            <li>Able to add new schedule by clicking on “New” button</li>
            <li>Able to edit and remove the selected schedule information</li>
            <li>Able to search/filter and records by date range, partner, country, store, category and keyword, keyword is to search the video title</li>
          </ul>
        </div><!-- end col-md-12 -->

      </div><!-- end row -->

    </div><!-- end wrap-content -->

  </div><!-- end container -->

</div><!-- end content-wrapper -->


@stop
