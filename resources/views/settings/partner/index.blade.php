@extends('layout.master')
@section('title', 'Partners')
@section('content')

<div class="content-wrapper">
  <div class="container">

    <div class="row">

      <div class="col-md-12">
        <h4 class="page-head-line">Partners</h4>
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

          {!! Form::open(array("url"=>"/settings/search/partners")) !!}

          <div class="col-md-3 no-padding-left">
            {!! Form::text('partner_name', NULL, ['class'=>'form-control search-partner', 'placeholder'=>'Keyword', 'id'=>'search-partner']) !!}
          </div><!-- end col-md-2 -->

          <div class="col-md-2">
            <button type="submit" class="btn btn-default">Search</button>
          </div><!-- end col-md-2 -->

          {!! Form::close() !!}

          <div class="col-md-5">
          </div><!-- end col-md-5 -->

          <div class="col-md-2 no-padding-right">
            <a href="/settings/new-partner" class="btn btn-default pull-right">New</a>
          </div><!-- end col-md-2 -->

        </div><!-- end col-md-12 -->

      </div><!-- end row -->

      {!! Form::open(array("url"=>"/settings/delete/partners")) !!}

      <div class="row">

        <table class="col-md-12 table-bordered table-striped table-condensed" id="partner-lists">
          <thead>
            <th width="3%" class="text-center"><input type="checkbox" id="checkAll"></th>
            <th width="55%">Partner Name</th>
            <th width="20%">Action</th>
          </thead>

          @if(count($partners) > 0)

          <tbody>
            @foreach($partners as $data)
            <tr>
              <td class="text-center">
                @if($data->editable == "")
                <input type="checkbox" name="id[]" value="{{ $data->id }}">
                @else
                <input type="checkbox" name="id[]" disabled>
                @endif
              </td>
              <td>{{ $data->partner_name }}</td>
              <td>
                <a href="/settings/edit/partner/{{$data->id}}" class="action">Edit</a>
                @if($data->editable == "")
                | <a href="/settings/delete/partner/{{$data->id}}" class="action">Remove</a>
                @else
                | <span href="#" class="disabled-link" title="Stores are created under this partner. You cannot remove it. Unless Stores have been deleted.">Remove</span>
                @endif
              </td>
            </tr>
            @endforeach
          </tbody>

          @else

          <tbody>
            <tr>
              <td colspan="3">No Data</td>
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
            {!! $partners->render() !!}
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
			$('#partner-lists input:checkbox').not(":disabled").not(this).prop('checked', this.checked);
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
