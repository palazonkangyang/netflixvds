@extends('layout.master')
@section('title', 'Schedules')
@section('content')

<div class="content-wrapper">
  <div class="container">

    <div class="row">

      <div class="col-md-12">
        <h4 class="page-head-line">Schedules</h4>
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

        {!! Form::open(array("url"=>"/schedules/search-schedules")) !!}

        <div class="col-md-12 form-size no-padding-left no-padding-right" style="margin-bottom:20px;">

          <div class="col-md-2 no-padding-left">
            <input type="text" name="from_date" placeholder="From Date" class="form-control" id="from-date">
          </div><!-- end col-md-2 -->

          <div class="col-md-1 no-padding-left no-padding-right" style="width:30px; vertical-align: middle;">
            <label style="height: 35px; line-height: 35px;">to</label>
          </div><!-- end col-md-1 -->

          <div class="col-md-2 no-padding-left">
            <input type="text" name="to_date" placeholder="To Date" class="form-control" id="to-date">
          </div><!-- end col-md-2 -->

          <div class="col-md-2 no-padding-left">
            <select class="form-control" name="partner_id" id="partner-id">
              <option value="0">Partner</option>

              @foreach($partners as $data)
              <option value="{{ $data->id }}">{{ $data->partner_name }}</option>
              @endforeach
            </select>
          </div><!-- end col-md-2 -->

          <div class="col-md-2 no-padding-left">
            <select class="form-control" name="country_id" id="country-id">
              <option value="0">Country</option>
            </select>
          </div><!-- end col-md-2 -->

          <div class="col-md-2 no-padding-left">
            <select class="form-control" name="store_id" id="store-id">
              <option value="0">Stores</option>
            </select>
          </div><!-- end col-md-2 -->

          <div class="col-md-1">
            <button type="submit" class="btn btn-default" id="search">Search</button>
          </div><!-- end col-md-1 -->

          <div class="col-md-1 no-padding-left no-padding-right pull-right" style="width: 5%;">
            <a href="/schedules/new-schedule" class="btn btn-default pull-right">New</a>
          </div><!-- end col-md-1 -->

        </div><!-- end col-md-12 -->

        <div class="col-md-12 form-size no-padding-left no-padding-right" style="margin-bottom:20px;">

          <div class="col-md-2 no-padding-left">
            <select class="form-control" name="category_id" id="category-id">
              <option value="0">Category</option>

              @foreach($categories as $data)
              <option value="{{ $data->id }}">{{ $data->category_name }}</option>
              @endforeach
            </select>
          </div><!-- end col-md-2 -->

          <div class="col-md-3">
            <input type="text" name="search_title" placeholder="Keyword" class="form-control">
          </div><!-- end col-md-2 -->

        </div><!-- end col-md-12 -->

      </div><!-- end row -->

      {!! Form::open(array("url"=>"/videos/delete/videos")) !!}

      <div class="row">

        <table class="col-md-12 table-bordered table-striped table-condensed" id="video-lists">
          <thead>
            <th width="3%" class="text-center"><input type="checkbox" id="checkAll"></th>
            <th>Partner</th>
            <th>Country</th>
            <th>Store</th>
            <th>Date</th>
            <th>Seq</th>
            <th>Video</th>
            <th>Duration</th>
            <th>Category</th>
            <th>Action</th>
          </thead>

          <tbody>
            <tr>
              <td colspan="10">No Data</td>
            </tr>
          </tbody>

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

          </div>
        </div><!-- end col-md-4 -->
      </div><!-- end row -->

      {!! Form::close() !!}

    </div><!-- end wrap-content -->

  </div><!-- end container -->
</div><!-- end content-wrapper -->

@stop

@section('custom-js')

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript">

  $(function() {

    $("#from-date").datepicker({ dateFormat: 'dd/mm/yy' });
    $("#to-date").datepicker({ dateFormat: 'dd/mm/yy' });

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

    $("#search").click(function() {

      $(".alert-success").remove();

      var count = 0;
			var errors = new Array();
			var validationFailed = false;

      var from_date = $("#from-date").val();
      var to_date = $("#to-date").val();

      if($.trim(from_date).length <= 0)
			{
				validationFailed = true;
				errors[count++] = "From Date is empty.";
			}

      if($.trim(to_date).length <= 0)
			{
				validationFailed = true;
				errors[count++] = "To Date is empty.";
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
