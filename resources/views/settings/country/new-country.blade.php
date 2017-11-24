@extends('layout.master')
@section('title', 'New Country')
@section('content')

<div class="content-wrapper">
  <div class="container">
    <div class="row">
      <div class="col-md-12"><h4 class="page-head-line">New Country</h4></div><!-- end col-md-12 -->
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
        <em>{{ Session::get('success') }}</em>
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
            <div class="panel-heading"><h4>NEW Country</h4></div><!-- end panel-heading -->

            <div class="panel-body">

              <div class="row form-area-with-inputs">
  	            <div class="col-md-12">
                  {!!Form::open(['class'=>'submit_now'])!!}

                  <div class="form-group">
          		   		<label class="col-md-2">Country Name <span class="text-danger">*</span></label>
          		    	<div class="col-md-6">
          		    	  {!! Form::text('country_name',NULL,['class'=>'form-control country-name', 'id'=>'country']) !!}
          		    	</div>
          		  	</div><!-- end form-group -->

                  <div class="clearfix"></div><!-- end clearfix -->

                  <hr />
                  <button type="submit" class="btn btn-default margin-right" id="submit">Submit</button>
                  <button type="reset" class="btn btn-default margin-right" id="cancel">Cancel</button>
                  <a class="btn btn-default" href="{{ URL::previous() }}">Back</a>

                  {!!Form::close()!!}
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

      var country = $("#country").val();

      if($.trim(country).length <= 0)
			{
				validationFailed = true;
				errors[count++] = "Country Name field is empty.";
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
