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

        {!! Form::open(array("url"=>"/client/schedules/search-schedules")) !!}

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
            <select class="form-control" name="category_id" id="category-id">
              <option value="0">Category</option>

              @foreach($categories as $data)
              <option value="{{ $data->id }}">{{ $data->category_name }}</option>
              @endforeach
            </select>
          </div><!-- end col-md-2 -->

          <div class="col-md-2">
            <input type="text" name="search_title" placeholder="Keyword" class="form-control">
          </div><!-- end col-md-2 -->

          <div class="col-md-1">
            <button type="submit" class="btn btn-default">Search</button>
          </div><!-- end col-md-1 -->

        </div><!-- end col-md-12 -->

      </div><!-- end row -->

      <div class="row">

        <table class="col-md-12 table-bordered table-striped table-condensed" id="video-lists">
          <thead>
            <th>Date</th>
            <th>Video</th>
            <th>Thumb</th>
            <th>Duration</th>
            <th>Category</th>
          </thead>

          <tbody>
            <tr>
              <td colspan="5">No Data</td>
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

  });

</script>

@stop
