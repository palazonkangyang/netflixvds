@extends('layout.master')
@section('title', 'User Manual')
@section('content')

<div class="content-wrapper">
  <div class="container">

    <div class="row">

      @if(Auth::user()->role == 0 || Auth::user()->role == 1)
      <div class="col-md-12">
        <h4 class="page-head-line">User Manual (Admin)</h4>
      </div><!-- end col-md-12 -->

      @else

      <div class="col-md-12">
        <h4 class="page-head-line">User Manual (Client)</h4>
      </div><!-- end col-md-12 -->

      @endif

    </div><!-- end row -->

    <div class="wrap-content">

      <div class="row">

        @if(Auth::user()->role == 0 || Auth::user()->role == 1)
        <div class="col-md-12">
          <h5 class="sub-head-line">Video Module</h5>

          <ul class="instruction-listing">
            <li>Shows all video listings.</li>
            <li>Admin can upload a new video by clicking on "Upload New" button.</li>
            <li>When uploading a new video. All the fields are mandatory except description and duration fields.
            </li>
            <li>Admin can edit and remove the selected video information.</li>
            <li>Admin can remove multiple videos by clicking on the checkbox field.</li>
            <li>Admin can search/- filter the videos by date range, category and keywords - keywords entered will be searched in code, title and description fields.</li>
          </ul>

          <h5 class="sub-head-line">Schedule Module</h5>

          <ul class="instruction-listing">
            <li>Shows all schedule listings.</li>
            <li>Admin can create a new schedule by clicking on "New" button.</li>
            <li>When uploading a new schedule, All the fields are mandatory.</li>
            <li>Admin can edit and remove the selected schedule information.</li>
            <li>Admin can remove multiple schedules by clicking on the checkbox field.</li>
            <li>Admin can search/- filter records by date range, partner, country, store, category and keywords - keywords entered searches for video title.</li>
          </ul>

          <h5 class="sub-head-line">Store Module</h5>

          <ul class="instruction-listing">
            <li>Shows all store listings.</li>
            <li>Admin can create a new store profile by clicking on "New" button.</li>
            <li>When creating a new store profile, all the fields are mandatory except the description, contact name and contact no fields.
            </li>
            <li>Admin can edit and remove the selected store information.</li>
            <li>Admin can remove multiple stores by clicking on the checkbox field.</li>
            <li>Admin can search/- filter stores by partner, country and keyword - keyword entered searches for store name.</li>
            <li>Admin can import a list of new stores by clicking on "Import" button.</li>
            <li>Download .csv file template, enter information accordingly then upload file.</li>
          </ul>

          <h5 class="sub-head-line">Settings Module</h5>

          <ul class="instruction-listing">
            <li>Admin profiles have access to Global, Countries, Users and Partners module.</li>
          </ul>

          <h5 class="sub-head-line">Global Module</h5>

          <ul class="instruction-listing">
            <li>Admin can update SMTP setting to send emails.</li>
            <li>When updating on SMTP Settings, all the fields are mandatory except require SSL field.
            </li>
          </ul>

          <h5 class="sub-head-line">Country Module</h5>

          <ul class="instruction-listing">
            <li>Shows all country listings.</li>
            <li>Admin can create new country by clicking on "New" button.</li>
            <li>Admin can edit and remove countries from the list.</li>
            <li>When stores are created under the country that cannot be removed it. Unless stores have been deleted.
              When there are existing stores listed under a country, that country cannot be removed until the corresponding stores have been deleted.
            </li>
            <li>Admin can search/- filter by country name.</li>
          </ul>

          <h5 class="sub-head-line">User Module</h5>

          <ul class="instruction-listing">
            <li>Shows all user listings.</li>
            <li>Admin can create a new user by clicking on "New" Button.</li>
            <li>When creating a new user, all the fields are mandatory.</li>
            <li>Admin can add new user as Administrator, Operator or Client under the role field.</li>
            <li>Admin can edit and remove the selected user information.</li>
            <li>Admin can remove multiple users by checking on the checkbox field.</li>
            <li>Admin can search/- filter by partner, country, store and username - keyword searches the username field.</li>
          </ul>

          <h5 class="sub-head-line">Role Module</h5>

          <ul class="instruction-listing">
            <li>The list of roles and permissions are shown here.</li>
          </ul>

          <h5 class="sub-head-line">Partner Module</h5>

          <ul class="instruction-listing">
            <li>Shows all partner listings.</li>
            <li>Admin can create a new partner by clicking on "New" button.</li>
            <li>When adding or editing partners, all fields are mandatory.</li>
            <li>Admin can edit and remove the selected partner information.</li>
            <li>Admin can remove multiple partners by checking on the checkbox field.</li>
            <li>When there are existing stores listed under a partner, that partner cannot be removed until the corresponding stores have been deleted.</li>
          </ul>
        </div><!-- end col-md-12 -->
        @endif


        @if(Auth::user()->role == 2)
        <div class="col-md-12">

          <h5 class="sub-head-line">Video Module</h5>

          <ul class="instruction-listing">
            <li>Show all video listings.</li>
            <li>The client can search/ filter the videos by date range, category and keywords, keyword will search code, title and description.</li>
          </ul>

          <h5 class="sub-head-line">Schedule Module</h5>

          <ul class="instruction-listing">
            <li>Show all schedule listings.</li>
            <li>The client can search/ filter and records by date range, partner, country, store, category and keyword, keyword is to search the video title.</li>
          </ul>

          <h5 class="sub-head-line">Store Module</h5>

          <ul class="instruction-listing">
            <li>Show all store listings</li>
            <li>The client can search/ filter partner, country and keyword, keyword is to search the store name.</li>
          </ul>

          <h5 class="sub-head-line">Settings Module</h5>

          <ul class="instruction-listing">
            <li>The client can update the client key, time zone and auto update fields.</li>
            <li>Client Key, Time Zone and Auto Update fields are mandatory.</li>
          </ul>

        </div><!-- end col-md-12 -->
        @endif

      </div><!-- end row -->

    </div><!-- end wrap-content -->

  </div><!-- end container -->

</div><!-- end content-wrapper -->


@stop
