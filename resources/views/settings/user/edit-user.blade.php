@extends('layout.master')
@section('title', 'Edit User')
@section('content')

<div class="content-wrapper">
  <div class="container">
    <div class="row">
      <div class="col-md-12"><h4 class="page-head-line">Edit User</h4></div><!-- end col-md-12 -->
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
            <div class="panel-heading"><h4>Edit User</h4></div><!-- end panel-heading -->

            <div class="panel-body">

              <div class="row form-area-with-inputs">
  	            <div class="col-md-12">
                  {!!Form::open(['class'=>'submit_now'])!!}

                  <div class="form-group">
                    {!! Form::hidden('id', $user->id, ['class'=>'form-control', 'id'=>'id']) !!}
                  </div><!-- end form-group -->

                  <div class="form-group">
          		   		<label for="country" class="col-md-2">Username <span class="text-danger">*</span></label>
          		    	<div class="col-md-6">
          		    	  {!! Form::text('username', $user->username, ['class'=>'form-control username', 'id'=>'username']) !!}
          		    	</div>
          		  	</div><!-- end form-group -->

                  <div class="form-group">
          		   		<label for="country" class="col-md-2">Password</label>
          		    	<div class="col-md-6">
          		    	  {!! Form::password('password', ['class'=>'form-control password', 'id'=>'password']) !!}
          		    	</div>
          		  	</div><!-- end form-group -->

                  <div class="form-group">
          		   		<label for="country" class="col-md-2">Confirm Password</label>
          		    	<div class="col-md-6">
          		    	  {!! Form::password('confirm_password', ['class'=>'form-control confirm-password', 'id'=>'confirm-password']) !!}
          		    	</div>
          		  	</div><!-- end form-group -->

                  <div class="form-group">
          		   		<label for="country" class="col-md-2">Full Name <span class="text-danger">*</span></label>
          		    	<div class="col-md-6">
          		    	  {!! Form::text('full_name', $user->full_name, ['class'=>'form-control full-name', 'id'=>'full-name']) !!}
          		    	</div>
          		  	</div><!-- end form-group -->

                  <div class="form-group">
          		   		<label for="country" class="col-md-2">Email Address <span class="text-danger">*</span></label>
          		    	<div class="col-md-6">
          		    	  {!! Form::text('email', $user->email, ['class'=>'form-control email', 'id'=>'email']) !!}
          		    	</div>
          		  	</div><!-- end form-group -->

                  <div class="form-group">
          		   		<label for="country" class="col-md-2">Role <span class="text-danger">*</span></label>
          		    	<div class="col-md-6">
                      {{ Form::select('role', ['' => 'Select Role', '0' => 'Administrator', '1'=> 'Operator', '2'=> 'Client'], $user->role, ['class'=>'form-control role', 'id'=>'role']) }}
          		    	</div>
          		  	</div><!-- end form-group -->

                  <div id="select-operator">
                    <div class="form-group">
            		   		<label for="country" class="col-md-2">Partner <span class="text-danger">*</span></label>
            		    	<div class="col-md-6">
                        <select class="form-control operator-partner-id" name="operator_partner_id" id="operator-partner-id">
                          <option value="0">Select Partner</option>
                          @foreach($partners as $data)
                          <option value="{{ $data->id }}" <?php if ($user->partner_id == $data->id) echo "selected"; ?>>{{ $data->partner_name }}</option>
                          @endforeach
                        </select>
            		    	</div>
            		  	</div><!-- end form-group -->
                  </div><!-- end select-operator -->

                  <div id="select-client">
                    <div class="form-group">
            		   		<label for="country" class="col-md-2">Partner <span class="text-danger">*</span></label>
            		    	<div class="col-md-6">
                        <select class="form-control client-partner-id" name="partner_id" id="client-partner-id">
                          <option value="0">Select Partner</option>
                          @foreach($partners as $data)
                          <option value="{{ $data->id }}" <?php if ($user->partner_id == $data->id) echo "selected"; ?>>{{ $data->partner_name }}</option>
                          @endforeach
                        </select>
            		    	</div>
            		  	</div><!-- end form-group -->

                    <div class="form-group">
            		   		<label for="country" class="col-md-2">Country <span class="text-danger">*</span></label>
            		    	<div class="col-md-6">
                        <select class="form-control country-id" name="country_id" id="country-id">
                          <option value="0">Select Country</option>
                          @foreach($countries as $data)
                          <option value="{{ $data->id }}" <?php if ($user->country_id == $data->id) echo "selected"; ?>>{{ $data->country_name }}</option>
                          @endforeach
                        </select>
            		    	</div>
            		  	</div><!-- end form-group -->

                    <div class="form-group">
            		   		<label for="country" class="col-md-2">Store <span class="text-danger">*</span></label>
            		    	<div class="col-md-6">
                        <select class="form-control store-id" name="store_id" id="store-id">
                          <option value="0">Select Store</option>
                          @foreach($stores as $data)
                          <option value="{{ $data->id }}" <?php if ($user->store_id == $data->id) echo "selected"; ?>>{{ $data->store_name }}</option>
                          @endforeach
                        </select>
            		    	</div>
            		  	</div><!-- end form-group -->
                  </div><!-- end select-client -->

                  <div class="clearfix"></div><!-- end clearfix -->

                  <hr />
                  <button type="submit" class="btn btn-default margin-right" id="submit">Submit</button>
                  <button type="reset" class="btn btn-default" id="cancel">Cancel</button>

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

    rolefunction();

    $("#role").change(function() {

      $("#operator-partner-id").val(0);
      $("#client-partner-id").val(0);
      $("#country-id").val(0);
      $("#store-id").val(0);

      $("#country-id").find('option').not(':first').remove();
      $("#store-id").find('option').not(':first').remove();

      rolefunction();

    });

    function rolefunction()
    {
      $role = $("#role").val();

      if($role == 1)
      {
        $("#select-operator").show();
        $("#select-client").hide();
      }

      else if($role == 2)
      {
        $("#select-operator").hide();
        $("#select-client").show();
      }

      else
      {
        $("#select-operator").hide();
        $("#select-client").hide();
      }
    }

    $('#client-partner-id').change(function() {

      $("#country-id").find('option').not(':first').remove();
      $("#store-id").find('option').not(':first').remove();

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

    $("#country-id").change(function() {

      $("#store-id").find('option').not(':first').remove();

      var partner_id = $("#client-partner-id").val();
      var country_id = $(this).val();

      var formData = {
				_token: $('meta[name="csrf-token"]').attr('content'),
				partner_id: partner_id,
        country_id: country_id
			};

      $.ajax({
				type: 'GET',
				url: "/get-store",
				data: formData,
				dataType: 'json',
				success: function(response)
				{
          $.each(response.stores, function(index, data) {
            $("#store-id").append("<option value=" + data.id + ">" + data.store_name + "</option>");
          });
				},

				error: function (response) {
					console.log(response);
				}
			});
    });

    $("#cancel").click(function() {
      $("#select-operator").hide();
      $("#select-client").hide();
    });

    $("#username").focusout(function() {

      var username = $(this).val();

      var formData = {
				_token: $('meta[name="csrf-token"]').attr('content'),
        username: username
			};

      $.ajax({
				type: 'GET',
				url: "/check-username",
				data: formData,
        context: this,
				dataType: 'json',
				success: function(response)
				{
          if(response.user.length > 0)
          {
            $(this).parent().addClass('duplicate-user');
          }

          else
          {
            $(this).parent().removeClass('duplicate-user');
          }
				},

				error: function (response) {
					console.log(response);
				}
			});
    });

    $("#submit").click(function(e) {

      $(".alert-danger").empty();

      var count = 0;
      var errors = new Array();
      var validationFailed = false;

      var username = $("#username").val();
      var password = $("#password").val();
      var confirm_password = $("#confirm-password").val();
      var full_name = $("#full-name").val();
      var email = $("#email").val();
      var role = $("#role").val();
      var operator_partner_id = $("#operator-partner-id").val();
      var client_partner_id = $("#client-partner-id").val();
      var country = $("#country-id").val();
      var store = $("#store-id").val();

      if($.trim(username).length <= 0)
      {
        validationFailed = true;
        errors[count++] = "Username field is empty.";
      }

      if($("#username").parent().hasClass("duplicate-user"))
      {
        validationFailed = true;
        errors[count++] = "Username is already exit.";
      }

      // if(password != confirm_password)
      // {
      //   validationFailed = true;
      //   errors[count++] = "The password must be match.";
      // }

      if($.trim(full_name).length <= 0)
      {
        validationFailed = true;
        errors[count++] = "Full Name field is empty.";
      }

      if($.trim(email).length <= 0)
      {
        validationFailed = true;
        errors[count++] = "Email field is empty.";
      }

      if(role == '')
      {
        validationFailed = true;
        errors[count++] = "Role field is empty.";
      }

      if(role == 1)
      {
        if(operator_partner_id == 0)
        {
          validationFailed = true;
          errors[count++] = "Partner field is empty.";
        }
      }

      if(role == 2)
      {
        if(client_partner_id == 0)
        {
          validationFailed = true;
          errors[count++] = "Partner field is empty.";
        }

        if(country == 0)
        {
          validationFailed = true;
          errors[count++] = "Country field is empty.";
        }

        if(store == 0)
        {
          validationFailed = true;
          errors[count++] = "Store field is empty.";
        }
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
