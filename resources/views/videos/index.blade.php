@extends('layout.master')
@section('title', 'Videos')
@section('content')

<div class="content-wrapper">
  <div class="container">

    <div class="row">

      <div class="col-md-12">
        <h4 class="page-head-line">Videos</h4>
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

          {!! Form::open(array("url"=>"/videos/search-videos")) !!}

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

          <div class="col-md-3">
            <input type="text" name="search_title" placeholder="Keyword" class="form-control">
          </div><!-- end col-md-3 -->

          <div class="col-md-1">
            <button type="submit" name="button" class="btn btn-default">Search</button>
          </div><!-- end col-md-2 -->

          {!! Form::close() !!}

          <div class="col-md-1 no-padding-right">
            <a href="/videos/new-video" class="btn btn-default pull-right">Upload New</a>
          </div><!-- end col-md-1 -->

        </div><!-- end col-md-12 -->

      </div><!-- end row -->

      {!! Form::open(array("url"=>"/videos/delete/videos")) !!}

      <div class="row">

        <table class="col-md-12 table-bordered table-striped table-condensed" id="video-lists">
          <thead>
            <th width="3%" class="text-center"><input type="checkbox" id="checkAll"></th>
            <th>Date</th>
            <th>Code</th>
            <th>Title</th>
            <th>Thumb</th>
            <th>Description</th>
            <th>Duration</th>
            <th>Category</th>
            <th>Action</th>
          </thead>

          @if(count($videos) > 0)

          <tbody>
            @foreach($videos as $data)
            <tr>
              <td class="text-center"><input type="checkbox" name="id[]" value="{{ $data->id }}"></td>
              <td>{{ $data->date }}</td>
              <td>{{ $data->code }}</td>
              <td>{{ $data->title }}</td>
              <td class="text-center"><img width="50px" src="{{ URL::asset('uploads/thumb_images/'. $data->thumbnail_name) }}" /></td>
              <td>{{ $data->description }}</td>
              <td>{{ $data->duration }}</td>
              <td>{{ $data->category_name }}</td>
              <td>
                <a href="/videos/edit/{{ $data->id }}" class="action">Edit</a> |
                <a href="/videos/delete/{{ $data->id }}" class="action remove-item">Remove</a>
              </td>
            </tr>
            @endforeach
          </tbody>

          @else

          <tbody>
            <tr>
              <td colspan="9">No Data</td>
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

          </div>
        </div><!-- end col-md-4 -->
      </div><!-- end row -->

      {!! Form::close() !!}

    </div><!-- end wrap-content -->

  </div><!-- end container -->
</div><!-- end content-wrapper -->

@stop

@section('custom-css')
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
@stop

@section('custom-js')

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript">

  $(function() {

    $("#from-date").datepicker({ dateFormat: 'dd/mm/yy' });
    $("#to-date").datepicker({ dateFormat: 'dd/mm/yy' });

    $("#checkAll").click(function () {
			$('#video-lists input:checkbox').not(this).prop('checked', this.checked);
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

    $("#video-lists").on('click', '.remove-item', function() {
      if (!confirm("Are you sure?")){
        return false;
      }
    });

  });

</script>

@stop
