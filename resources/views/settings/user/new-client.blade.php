@extends('layout.master')
@section('title', 'New Client')
@section('content')

<div class="content-wrapper">
  <div class="container">

    <div class="row">

      <div class="col-md-12">
        <h4 class="page-head-line">New Client</h4>
      </div><!-- end col-md-12 -->

    </div><!-- end row -->

    <div class="wrap-content">

      <div class="row">
        <p>
          New client account has been successfully created.<br /><br />
          Partner: {{ $user->partner_name }}<br /><br />
          Country: {{ $user->country_name }}<br /><br />
          Store: {{ $user->store_name }}<br /><br />
          Client Key: {{ $user->client_key }}
        </p>

      </div><!-- end row -->

      <div class="row" style="margin-top: 30px;">
        <div class="col-md-4 no-padding-left">
          <a href="#" class="btn btn-default btn-right">Email to Client</a>
          <a href="/settings/users" class="btn btn-default">Back</a>
        </div><!-- end col-md-4 -->

        <div class="col-md-4">
        </div><!-- end col-md-4 -->

        <div class="col-md-4">
        </div><!-- end col-md-4 -->
      </div><!-- end row -->

    </div><!-- end wrap-content -->

  </div><!-- end container -->
</div><!-- end content-wrapper -->

@stop
