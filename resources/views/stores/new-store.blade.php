@extends('layout.master')
@section('title', 'New Store')
@section('content')

<div class="content-wrapper">
  <div class="container">
    <div class="row">
      <div class="col-md-12"><h4 class="page-head-line">New Store</h4></div><!-- end col-md-12 -->
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

        <div class="col-md-12">

          <div class="panel panel-default">
            <div class="panel-heading"><h4>New Store</h4></div><!-- end panel-heading -->

            <div class="panel-body">

              <div class="row form-area-with-inputs">
  	            <div class="col-md-12">
                  {!!Form::open(['class'=>'submit_now'])!!}

                  <div class="form-group">
          		   		<label class="col-md-2">Partner <span class="text-danger">*</span></label>
          		    	<div class="col-md-6">
          		    	  <select class="form-control" name="partner_id" id="partner-id">
                        <option value="0">Select Partner</option>
                        @foreach($partners as $data)
                        <option value="{{ $data->id }}">{{ $data->partner_name }}</option>
                        @endforeach
                      </select>
          		    	</div>
          		  	</div><!-- end form-group -->

                  <div class="form-group">
          		   		<label class="col-md-2">Country <span class="text-danger">*</span></label>
          		    	<div class="col-md-6">
          		    	  <select class="form-control" name="country_id" id="country-id">
                        <option value="0">Select Country</option>
          		    	  </select>
          		    	</div>
          		  	</div><!-- end form-group -->

                  <div class="form-group">
          		   		<label class="col-md-2">Store Name <span class="text-danger">*</span></label>
          		    	<div class="col-md-6">
          		    	  {!! Form::text('store_name', NULL, ['class'=>'form-control store-name', 'id'=>'store-name']) !!}
          		    	</div>
          		  	</div><!-- end form-group -->

                  <div class="form-group">
          		   		<label class="col-md-2">Description</label>
          		    	<div class="col-md-6">
                      {{ Form::textarea('description', NULL, ['class'=>'form-control description', 'id'=>'description', 'size' => '30x5']) }}
          		    	</div>
          		  	</div><!-- end form-group -->

                  <div class="form-group">
          		   		<label class="col-md-2">Contact Name</label>
          		    	<div class="col-md-6">
                      {!! Form::text('contact_name', NULL, ['class'=>'form-control contact-name', 'id'=>'contact-name']) !!}
          		    	</div>
          		  	</div><!-- end form-group -->

                  <div class="form-group">
          		   		<label class="col-md-2">Contact No</label>
          		    	<div class="col-md-6">
                      {!! Form::text('contact_no',NULL,['class'=>'form-control contact-no', 'id'=>'contact-no']) !!}
          		    	</div>
          		  	</div><!-- end form-group -->

                  <div class="clearfix"></div><!-- end clearfix -->

                  <hr />
                  <button type="submit" class="btn btn-default margin-right" id="submit">Submit</button>
                  <button type="reset" class="btn btn-default margin-right" id="cancel">Cancel</button>
                  <a class="btn btn-default" href="{{ URL::previous() }}">back</a>

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

    $('#partner-id').change(function() {

      $("#country-id").find('option').not(':first').remove();

      var partner_id = $(this).val();

      var formData = {
				_token: $('meta[name="csrf-token"]').attr('content'),
				partner_id: partner_id,
			};

      $.ajax({
				type: 'GET',
				url: "/get-country-by-partner-id",
				data: formData,
				dataType: 'json',
				success: function(response)
				{
          $.each(response.countries, function(index, data) {
            $("#country-id").append("<option value=" + data.id + ">" + data.country_name + "</option>");
          });
				},

				error: function (response) {
					console.log(response);
				}
			});

    });

    $("#cancel").click(function() {

      $(".alert-success").remove();
      $(".alert-danger").remove();

      $("#country-id").find('option').not(':first').remove();
    });

    $("#submit").click(function() {

      $(".alert-success").remove();

      var count = 0;
      var errors = new Array();
      var validationFailed = false;

      var partner_id = $("#partner-id").val();
      var country_id = $("#country-id").val();
      var store_name = $('#store-name').val();

      if(partner_id <= 0)
      {
        validationFailed = true;
        errors[count++] = "Partner Name field is empty.";
      }

      if(country_id <= 0)
      {
        validationFailed = true;
        errors[count++] = "Country Name field is empty.";
      }

      if($.trim(store_name).length <= 0)
      {
        validationFailed = true;
        errors[count++] = "Store Name field is empty.";
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
