@extends('layout.master')
@section('title', 'Users')
@section('content')

<div class="content-wrapper">
  <div class="container">

    <div class="row">

      <div class="col-md-12">
        <h4 class="page-head-line">Users</h4>
      </div><!-- end col-md-12 -->

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

        <div class="col-md-12 form-size no-padding-left no-padding-right" style="margin-bottom:20px;">

          {!! Form::open(array("url"=>"/settings/search/users")) !!}

          <div class="col-md-2 no-padding-left">
            <select class="form-control" name="partner_id" id="partner-id">
              <option value="0">Partner</option>
              @foreach($partners as $data)
              <option value="{{ $data->id }}" <?php if ($data->id == $partner_id) echo "selected"; ?>>{{ $data->partner_name }}</option>
              @endforeach
            </select>
          </div><!-- end col-md-2 -->

          <div class="col-md-2">
            <select class="form-control" name="country_id" id="country-id">
              <option value="0">Country</option>

              @if(count($countries) > 0)
                @foreach($countries as $data)
                <option value="{{ $data->id }}" <?php if ($data->id == $country_id) echo "selected"; ?>>{{ $data->country_name }}</option>
                @endforeach
              @endif
            </select>
          </div><!-- end col-md-2 -->

          <div class="col-md-3">
            <select class="form-control" name="store_id" id="store-id">
              <option value="0">Store</option>

              @if(count($stores) > 0)
                @foreach($stores as $data)
                <option value="{{ $data->id }}" <?php if ($data->id == $store_id) echo "selected"; ?>>{{ $data->store_name }}</option>
                @endforeach
              @endif
            </select>
          </div><!-- end col-md-3 -->

          <div class="col-md-3">
            <input type="text" name="username" placeholder="Keyword" class="form-control" value="{{ $keyword }}">
          </div><!-- end col-md-3 -->

          <div class="col-md-1">
            <button type="submit" class="btn btn-default">Search</button>
          </div><!-- end col-md-1 -->

          {!! Form::close() !!}

          <div class="col-md-1 no-padding-right">
            <a href="/settings/new-user" class="btn btn-default pull-right">New</a>
          </div><!-- end col-md-1 -->

        </div><!-- end col-md-12 -->

      </div><!-- end row -->

      {!! Form::open(array("url"=>"/settings/delete/users")) !!}

      <div class="row">

        <table class="col-md-12 table-bordered table-striped table-condensed" id="user-lists">
          <thead>
            <th width="3%" class="text-center"><input type="checkbox" id="checkAll"></th>
            <th>Username</th>
            <th>Full Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Partner</th>
            <th>Country</th>
            <th>Store</th>
            <th>Client Key</th>
            <th>Action</th>
          </thead>

          @if(count($users) > 0)

          <tbody>
            @foreach($users as $data)
            <tr>
              <td class="text-center">
                @if($data->login_user =="false")
                <input type="checkbox" name="id[]" value="{{ $data->id }}">
                @else
                <input type="checkbox" name="id[]" disabled>
                @endif
              </td>
              <td>{{ $data->username }}</td>
              <td>{{ $data->full_name }}</td>
              <td>{{ $data->email }}</td>
              <td>{{ $data->role_name }}</td>
              <td>{{ $data->partner_name }}</td>
              <td>{{ $data->country_name }}</td>
              <td>{{ $data->store_name }}</td>
              <td>{{ $data->client_key }}</td>
              <td>
                <a href="/settings/edit/user/{{$data->id}}" class="action">Edit</a>
                @if($data->login_user =="false")
                | <a href="/settings/delete/user/{{$data->id}}" class="action remove-item">Remove</a>
                @else
                | <span href="#" class="disabled-link" title="You cannot delete the login user.">Remove</span>
                @endif
              </td>
            </tr>
            @endforeach
          </tbody>

          @else

          <tbody>
            <tr>
              <td colspan="10">No Data</td>
            </tr>
          </tbody>

          @endif


        </table>

      </div><!-- end row -->

      <div class="row">
        <div class="col-md-4 no-padding-left" style="margin: 20px 0;">
          <div class="col-md-7 no-padding-left">
            <select class="form-control" name="" id="">
              <option value="0">Remove Selected</option>
            </select>
          </div><!-- end col-md-10 -->

          <button type="submit" class="btn btn-default" id="apply-btn">Apply</button>
        </div><!-- end col-md-4 -->

        <div class="col-md-4">

        </div><!-- end col-md-4 -->

        <div class="col-md-4 no-padding-right">
          <div class="pull-right">
            {!! $users->render() !!}
          </div>
        </div><!-- end col-md-4 -->
      </div><!-- end row -->

      {!! Form::close() !!}

    </div><!-- end wrap-content -->

  </div><!-- end container -->
</div><!-- end content-wrapper -->

@stop

@section('custom-js')

<script type="text/javascript">

  $(function() {

    $("#checkAll").click(function () {
			$('#user-lists input:checkbox').not(":disabled").not(this).prop('checked', this.checked);
		});

    $('#partner-id').change(function() {

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

      var partner_id = $("#partner-id").val();
      var country_id = $(this).val();

      var formData = {
				_token: $('meta[name="csrf-token"]').attr('content'),
				partner_id: partner_id,
        country_id: country_id
			};

      $.ajax({
				type: 'GET',
				url: "/get-store-by-country-id",
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

    $("#apply-btn").click(function() {

      $(".alert-success").remove();

      var count = 0;
			var errors = new Array();
			var validationFailed = false;

      var count_checked = $("[name='id[]']:checked").length;

      if(count_checked == 0)
			{
				validationFailed = true;
				errors[count++] = "Please choose at least one checkbox.";
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

    $("#user-lists").on('click', '.remove-item', function() {
      if (!confirm("Screenplay administrator says: You cannot undo this action, are you sure you want to continue?")){
        return false;
      }
    });

  });

</script>

@stop
