@extends('layout.master')
@section('title', 'Global')
@section('content')

<div class="content-wrapper">
  <div class="container">
    <div class="row">
      <div class="col-md-12"><h4 class="page-head-line">Global</h4></div><!-- end col-md-12 -->
    </div><!-- end row -->

    <div class="wrap-content">

      <div class="alert-danger">
        @foreach($errors->all() as $error)
          <div class="error-list">{!! $error !!}</div><!-- end error-list -->
        @endforeach
      </div><!-- end alert-danger -->

      @if(Session::has('success'))
      <div class="alert alert-success alert-dismissable">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <em> {{ Session::get('success') }}</em>
      </div><!-- end alert-success -->
      @endif

      @if(Session::has('error'))
      <div class="alert alert-danger alert-dismissable">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <em> {{ Session::get('error') }}</em>
      </div><!-- end alert-danger -->
      @endif

      <div class="row">

        <div class="col-md-12 no-padding-left no-padding-right">

          <div class="panel panel-default">
            <div class="panel-heading"><h4>SMTP Settings</h4></div><!-- end panel-heading -->

            <div class="panel-body">

              <div class="row form-area-with-inputs">
  	            <div class="col-md-12">
                  {!! Form::open(array("url"=>"/settings/update-global")) !!}

                  <div class="form-group">
                    {!! Form::hidden('id', $settings->id, ['class'=>'form-control', 'id'=>'id']) !!}
                  </div><!-- end form-group -->

                  <div class="form-group">
          		   		<label class="col-md-2">SMTP Host <span class="text-danger">*</span></label>
          		    	<div class="col-md-6">
          		    	  {!! Form::text('host', $settings->host, ['class'=>'form-control smtp-host', 'id'=>'smtp-host']) !!}
          		    	</div>
          		  	</div><!-- end form-group -->

                  <div class="form-group">
          		   		<label class="col-md-2">SMTP Username <span class="text-danger">*</span></label>
          		    	<div class="col-md-6">
          		    	  {!! Form::text('username', $settings->username, ['class'=>'form-control smtp-username', 'id'=>'smtp-username']) !!}
          		    	</div>
          		  	</div><!-- end form-group -->

                  <div class="form-group">
          		   		<label class="col-md-2">SMTP Password <span class="text-danger">*</span></label>
          		    	<div class="col-md-6">
          		    	  {!! Form::text('password', $settings->password, ['class'=>'form-control smtp-password', 'id'=>'smtp-password']) !!}
          		    	</div>
          		  	</div><!-- end form-group -->

                  <div class="form-group">
          		   		<label class="col-md-2">SMTP Port <span class="text-danger">*</span></label>
          		    	<div class="col-md-6">
          		    	  {!! Form::text('port', $settings->port, ['class'=>'form-control smtp-port', 'id'=>'smtp-port']) !!}
          		    	</div>
          		  	</div><!-- end form-group -->

                  <div class="form-group">
          		   		<label class="col-md-2">Require SSL</label>
          		    	<div class="col-md-6" style="margin-top: 10px;">
                      {!! Form::checkbox('require_ssl', 1, $settings->require_ssl, ['class'=>'require-ssl', 'id'=>'require-ssl']) !!}
          		    	</div>
          		  	</div><!-- end form-group -->

                  <div class="clearfix"></div><!-- end clearfix -->

                  <hr />
                  <button type="submit" class="btn btn-default margin-right" id="submit">Submit</button>
                  <button type="reset" class="btn btn-default" id="cancel">Cancel</button>

                  {!! Form::close() !!}
                </div><!-- end col-md-12 -->

              </div><!-- end row -->

            </div><!-- end panel-body -->

          </div><!-- end panel panel-default -->

        </div><!-- end col-md-12 -->

      </div><!-- end row -->

    </div><!-- end wrap-content -->

  </div><!-- end container -->
</div><!-- end content-wrapper -->

@stop

@section('custom-js')

<script type="text/javascript">

  $(function() {

    $("#submit").click(function() {

      var count = 0;
      var errors = new Array();
      var validationFailed = false;

      var smtp_host = $("#smtp-host").val();
      var smtp_username = $("#smtp-username").val();
      var smtp_password = $("#smtp-password").val();
      var smtp_port = $("#smtp-port").val();

      if($.trim(smtp_host).length <= 0)
      {
        validationFailed = true;
        errors[count++] = "SMTP Host field is empty.";
      }

      if($.trim(smtp_username).length <= 0)
      {
        validationFailed = true;
        errors[count++] = "SMTP Username field is empty.";
      }

      if($.trim(smtp_password).length <= 0)
      {
        validationFailed = true;
        errors[count++] = "SMTP Password field is empty.";
      }

      if($.trim(smtp_port).length <= 0)
      {
        validationFailed = true;
        errors[count++] = "SMTP Port field is empty.";
      }

      if (validationFailed)
      {
        var errorMsgs = '';

        for(var i = 0; i < count; i++)
        {
          errorMsgs = errorMsgs + errors[i] + "<br/>";
        }

        $('html,body').animate({ scrollTop: 0 }, 'slow');

        $(".alert-danger").addClass("bg-danger alert alert-error");
        $(".alert-danger").html(errorMsgs);

        return false;
      }

      else
      {
        $(".alert-danger").removeClass("bg-danger alert alert-error");
        $(".alert-danger").empty();
      }

    });

  });

</script>

@stop
