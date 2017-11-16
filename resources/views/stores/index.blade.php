@extends('layout.master')
@section('title', 'Stores')
@section('content')

<div class="content-wrapper">
  <div class="container">

    <div class="row">

      <div class="col-md-12">
        <h4 class="page-head-line">Stores</h4>
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

          {!! Form::open(array("url"=>"/stores/search")) !!}

          <div class="col-md-2 no-padding-left">
            <select class="form-control" name="partner_id" id="partner-id">
              <option value="0">Partner</option>
              @foreach($partners as $data)
              <option value="{{ $data->id }}">{{ $data->partner_name }}</option>
              @endforeach
            </select>
          </div><!-- end col-md-2 -->

          <div class="col-md-3">
            <select class="form-control" name="country_id" id="country-id">
              <option value="0">Country</option>
            </select>
          </div><!-- end col-md-2 -->

          <div class="col-md-3">
            <input type="text" name="store_name" placeholder="Keyword" class="form-control">
          </div><!-- end col-md-3 -->

          <div class="col-md-2">
            <button type="submit" name="button" class="btn btn-default">Search</button>
          </div><!-- end col-md-2 -->

          {!! Form::close() !!}

          <div class="col-md-1">
            <a href="/stores/import" class="btn btn-default pull-right">Import</a>
          </div><!-- end col-md-2 -->

          <div class="col-md-1 no-padding-right">
            <a href="/stores/new-store" class="btn btn-default pull-right">New</a>
          </div><!-- end col-md-1 -->

        </div><!-- end col-md-12 -->

      </div><!-- end row -->

      {!! Form::open(array("url"=>"/stores/delete/stores")) !!}

      <div class="row">

        <table class="col-md-12 table-bordered table-striped table-condensed" id="store-lists">
          <thead>
            <th width="3%" class="text-center"><input type="checkbox" id="checkAll"></th>
            <th>Partner</th>
            <th>Country</th>
            <th>Store</th>
            <th>Contact Name</th>
            <th>Contact No</th>
            <th>Action</th>
          </thead>

          @if(count($stores) > 0)

          <tbody>
            @foreach($stores as $data)
            <tr>
              <td class="text-center"><input type="checkbox" name="id[]" value="{{ $data->id }}"></td>
              <td>{{ $data->partner_name }}</td>
              <td>{{ $data->country_name }}</td>
              <td>{{ $data->store_name }}</td>
              <td>{{ $data->contact_name }}</td>
              <td>{{ isset($data->contact_no) ? '+ ' . $data->contact_no : $data->contact_no }}</td>
              <td>
                <a href="/stores/edit/{{ $data->id }}" class="action">Edit</a> |
                <a href="/stores/delete/{{ $data->id }}" class="action">Remove</a>
              </td>
            </tr>
            @endforeach
          </tbody>

          @else

          <tbody>
            <tr>
              <td colspan="7">No Data</td>
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

        <div class="col-md-4"></div><!-- end col-md-4 -->

        <div class="col-md-4 no-padding-right">
          <div class="pull-right">
            {!! $stores->render() !!}
          </div>
        </div><!-- end col-md-4 -->
      </div><!-- end row -->

    </div><!-- end wrap-content -->

    {!! Form::close() !!}

  </div><!-- end container -->
</div><!-- end content-wrapper -->

@stop

@section('custom-js')

<script type="text/javascript">

  $(function() {

    $("#checkAll").click(function () {
			$('#store-lists input:checkbox').not(this).prop('checked', this.checked);
		});

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

    $("#apply-btn").click(function() {

      $(".alert-success").remove();

      var count = 0;
			var errors = new Array();
			var validationFailed = false;

      var count_checked = $("[name='id[]']:checked").length; // count the checked rows

      if(count_checked == 0)
			{
				validationFailed = true;
				errors[count++] = "Please choose at least one checkbox."
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
