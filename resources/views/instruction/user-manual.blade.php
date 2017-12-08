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
            <li>Show all video listings.</li>
            <li>Upload new video by clicking on "Upload New" button.</li>
            <li>When clicking on video page, there have Code, Title, Description, Duration, Category and Upload fields.
              All the fields are mandatory except description and duration fields.
            </li>
            <li>Admin can edit and remove the selected video information.</li>
            <li>Admin can remove multiple videos by clicking on the checkbox field.</li>
            <li>Admin can search/ filter the videos by date range, category and keywords, keyword will search code, title and description.</li>
          </ul>

          <h5 class="sub-head-line">Schedule Module</h5>

          <ul class="instruction-listing">
            <li>Show all schedule listings.</li>
            <li>Admin can create new schedule by clicking on "New" button.</li>
            <li>When clicking on schedule page, there have Partner, Store, Date and Video fields. All the fields are mandatory.</li>
            <li>Admin can edit and remove the selected schedule information.</li>
            <li>Admin can remove multiple schedules by clicking on the checkbox field.</li>
            <li>Admin can search/ filter and records by date range, partner, country, store, category and keyword, keyword is to search the video title.</li>
          </ul>

          <h5 class="sub-head-line">Store Module</h5>

          <ul class="instruction-listing">
            <li>Show all store listings.</li>
            <li>Admin can create new store by clicking on "New" button.</li>
            <li>When clicking on store page, there have Partner, Country, Store Name, Description, Contact Name and Contact No fields.
              All the fields are mandatory except Description, Contact Name and Contact No fields.
            </li>
            <li>Admin can edit and remove the selected store information.</li>
            <li>Admin can remove multiple stores by clicking on the checkbox field.</li>
            <li>Admin can search/ filter the stores by partner, country and keyword, keyword is to search store name.</li>
            <li>Admin can import new stores using csv file by clicking on "Import" button.</li>
          </ul>

          <h5 class="sub-head-line">Settings Module</h5>

          <ul class="instruction-listing">
            <li>Admin can manage Global, Countries, Users and Partners module.</li>
          </ul>

          <h5 class="sub-head-line">Global Module</h5>

          <ul class="instruction-listing">
            <li>Admin can update SMTP setting to send the email.</li>
            <li>When clicking on Global Page, there have SMTP Host, SMTP Username, SMTP Password, SMTP Port and Require SSL.
              All the fields are mandatory except Require SSL fields.
            </li>
          </ul>

          <h5 class="sub-head-line">Country Module</h5>

          <ul class="instruction-listing">
            <li>Show all country listings.</li>
            <li>Admin can create new country by clicking on "New" button.</li>
            <li>When clicking on New Country and Edit Country Page. There has Country Name field. The field is mandatory.</li>
            <li>Admin can edit and remove the country.</li>
            <li>When stores are created under the country that cannot be removed it. Unless stores have been deleted.</li>
            <li>Admin can search/ filter by country name, keyword is to search the country name.</li>
          </ul>

          <h5 class="sub-head-line">Users Module</h5>

          <ul class="instruction-listing">
            <li>Show all user listings.</li>
            <li>Admin can create new user by clicking on "New" Button.</li>
            <li>When clicking on New Partner and Edit Partner Page, there have Username, Password,
              Confirm Password, Full Name, Email Address, Role, Partner, Country, Store fields.
              All the fields are mandatory.</li>
            <li>Partner, Country and Store are shown by choosing on Role field.</li>
            <li>Choose Partner field first, country listings will be shown and then choose Country field,
              Store listings will be shown in the dropdown list.
            </li>
            <li>Admin can edit and remove the selected user information.</li>
            <li>Admin can remove multiple users by checking on the checkbox field.</li>
            <li>Admin can search/ filter by partner, country, store and username, keyword is to search the username.</li>
          </ul>

          <h5 class="sub-head-line">Role Module</h5>

          <ul class="instruction-listing">
            <li>The list of roles and permissions are shown in role page.</li>
          </ul>

          <h5 class="sub-head-line">Partner Module</h5>

          <ul class="instruction-listing">
            <li>Show all partner listings.</li>
            <li>Admin can create new partner by clicking on "New" button.</li>
            <li>When clicking on New Partner and Edit Partner Page, there have partner name, country name fields. These two fields are mandatory.</li>
            <li>Admin can edit and remove the selected partner information.</li>
            <li>Admin can remove multiple partners by checking on the checkbox field.</li>
            <li>When stores are created under the partner that cannot be removed it. Unless stores have been deleted.</li>
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
