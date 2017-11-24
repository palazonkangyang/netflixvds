@extends('layout.master')
@section('title','Login')
@section('content')

<link rel="stylesheet" href="{{ asset('/css/login.css') }}" />

<div class="container">
  <div class="row login_box">

    <div class="col-md-12 col-xs-12" align="center">
      <div class="outter">
        <img src="{{ asset('images/netflix-logo-small.png') }}" class="image-circle" />
      </div><!-- end outter -->

    </div><!-- end col-md-12 -->

    <div class="col-md-12 col-xs-12 login_control">
      {!! Form::open(['url'=>'/client/login']) !!}

      @if(Session::has('error'))
      <div class="alert alert-danger alert-dismissable">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <em> {{ Session::get('error') }}</em>
      </div><!-- end alert-danger -->
      @endif

      <div class="ins_sub control" style="text-align: center">Video Distribution System <br /> (Client)</div><!-- end ins_sub control -->

      <div class="control">
        {!! Form::text('username', Input::old('username'), ['class'=>'form-control','placeholder'=>'Username', 'autofocus'=>'']) !!}
      </div><!-- end control -->

      <div class="control">
        {!! Form::password('password', ['class'=>'form-control','placeholder'=>'Password']) !!}
      </div><!-- end control -->

      <div align="center">
        {!! Form::submit('Log in', ['class'=>'btn btn-default login-btn']) !!}
      </div><!-- end center -->

      {!! Form::close() !!}
    </div><!-- end col-md-12 -->

    <!-- <p class="reset-password"><a href="/account/resetpassword">Forgot Password? Click here</a></p> -->
  </div><!-- end row -->

</div><!-- end container -->

@stop
