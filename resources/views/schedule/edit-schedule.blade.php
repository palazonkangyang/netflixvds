@extends('layout.master')
@section('title', 'Edit Schedule')
@section('content')

<div class="content-wrapper">
  <div class="container">
    <div class="row">
      <div class="col-md-12"><h4 class="page-head-line">Edit Schedule</h4></div><!-- end col-md-12 -->
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
            <div class="panel-heading"><h4>Edit Schedule</h4></div><!-- end panel-heading -->

            <div class="panel-body">

              <div class="row form-area-with-inputs">
  	            <div class="col-md-12">
                  {!! Form::open(['class'=>'submit_now']) !!}

                  <div class="form-group">
          		   		<label class="col-md-2">Partner <span class="text-danger">*</span></label>
          		    	<div class="col-md-6">
          		    	  <select class="form-control" name="partner_id" id="partner-id" disabled>
                        <option value="0">Select Partner</option>
                        @foreach($partners as $data)
                        <option value="{{ $data->id }}" <?php if ($data->id == $partner_id) echo "selected"; ?>>{{ $data->partner_name }}</option>
                        @endforeach
                      </select>
          		    	</div>
          		  	</div><!-- end form-group -->

                  <div class="form-group">
          		   		<label class="col-md-2">Store <span class="text-danger">*</span></label>
          		    	<div class="col-md-5">
                      {!! Form::text('store_name', NULL, ['class'=>'form-control store-name', 'id'=>'store-name']) !!}
                      {!! Form::hidden('country_id', NULL, ['class'=>'form-control country-id', 'id'=>'country-id']) !!}
                      {!! Form::hidden('country_name', NULL, ['class'=>'form-control country-name', 'id'=>'country-name']) !!}
                      {!! Form::hidden('store_id', NULL, ['class'=>'form-control store-id', 'id'=>'store-id']) !!}
          		    	</div>
                    <div class="col-md-1">
                      <a href="#" class="btn btn-default" id="add-store-btn">Add</a>
                    </div>
          		  	</div><!-- end form-group -->

                  <div class="form-group">
                    <label class="col-md-2"></label>
                    <div class="col-md-6">

                      <table class="col-md-12 table-bordered table-striped table-condensed" id="store-lists">
                        <thead>
                          <th class="col-md-5">Country</th>
                          <th class="col-md-6">Store</th>
                          <th class="col-md-1">Action</th>
                        </thead>

                        @foreach($schedule_store as $data)

                        <tbody>
                          <tr>
                            <td><input type='hidden' value='{{ $data->country_id }}' name='country_id[]'>{{ $data->country_name }}</td>
                            <td><input type='hidden' value='{{ $data->store_id }}' name='store_id[]'>{{ $data->store_name }}</td>
                            <td><a href='#' class='remove'>Remove</a></td>
                          </tr>
                        </tbody>

                        @endforeach
                      </table>

                    </div><!-- end col-md-6 -->
                  </div><!-- end form-group -->

                  <div class="form-group">
          		   		<label class="col-md-2">Date <span class="text-danger">*</span></label>
                    <div class="col-md-2">
                      {!! Form::text('from_date', NULL, ['class'=>'form-control from-date', 'id'=>'from-date', 'placeholder'=>'From Date']) !!}
                    </div>
                    <div class="col-md-2">
                      {!! Form::text('to_date', NULL, ['class'=>'form-control to-date', 'id'=>'to-date', 'placeholder'=>'To Date']) !!}
                    </div>

                    <div class="col-md-3">
                      <select class="form-control" name="timezone_id" id="timezone-id">
                        <option value="0">Select Timezone</option>
                        @foreach($time_zone as $data)
                        <option value="{{ $data->id }}">{{ $data->name }}</option>
                        @endforeach
                      </select>
                    </div>

                    <div class="col-md-1">
                      <a href="#" class="btn btn-default" id="add-date-btn">Add</a>
                    </div>
          		  	</div><!-- end form-group -->

                  <div class="form-group">
                    <label class="col-md-2"></label>
                    <div class="col-md-6">

                      <table class="col-md-12 table-bordered table-striped table-condensed" id="date-lists">
                        <thead>
                          <th class="col-md-4">Date</th>
                          <th class="col-md-6">Time Zone</th>
                          <th class="col-md-1">Action</th>
                        </thead>

                        <tbody>
                          @foreach($schedule_date as $data)
                          <tr>
                            <td>{{ $data->date }}</td>
                            <td>{{ $data->name }}</td>
                            <td><a href='#' class='remove'>Remove</a></td>
                          </tr>
                          @endforeach
                        </tbody>

                      </table>

                    </div><!-- end col-md-6 -->
                  </div><!-- end form-group -->

                  <div class="form-group"></div><!-- end form-group -->

                  <div class="form-group">
          		   		<label class="col-md-2">Video <span class="text-danger">*</span></label>
                    <div class="col-md-5">
                      {!! Form::text('video_name', NULL, ['class'=>'form-control video-name', 'id'=>'video-name']) !!}
                      {!! Form::hidden('video', NULL, ['class'=>'form-control video-id', 'id'=>'video-id']) !!}
                    </div>
                    <div class="col-md-1">
                      <a href="#" class="btn btn-default" id="add-video-btn">Add</a>
                    </div>
          		  	</div><!-- end form-group -->

                  <div class="form-group">
                    <label class="col-md-2"></label>
                    <div class="col-md-6">

                      <table class="col-md-12 table-bordered table-striped table-condensed" id="video-lists">
                        <thead>
                          <tr>
                            <th class="col-md-11">Video</th>
                            <th class="col-md-1">Action</th>
                          </tr>
                        </thead>

                        <tbody>
                          @foreach($schedule_video as $data)
                          <tr>
                            <td><input type='hidden' value='{{ $data->video_id }}' name='video_id[]'>{{ $data->title }}</td>
                            <td><a href='#' class='remove'>Remove</a></td>
                          </tr>
                          @endforeach
                        </tbody>

                      </table>

                    </div><!-- end col-md-6 -->
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

@section('custom-css')
  <!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.css" rel="stylesheet"> -->
@stop

@section('custom-js')

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script type="text/javascript">

  $(function() {

    $("#from-date").datepicker({ dateFormat: 'dd/mm/yy' });
    $("#to-date").datepicker({ dateFormat: 'dd/mm/yy' });

    $('#video-lists tbody').sortable();

    $("#store-name").focus(function() {

      $(this).autocomplete({
        source: function(request, response) {
          $.ajax({
            url: "/search/store-name",
            dataType: "json",
            content: this,
            data: {
              term: request.term,
              partner_id: $("#partner-id").val()
            },
            success: function(data) {
              response(data);
            }
          });
        },
        select: function(event, ui) {
          $(".country-id").val(ui.item.country_id);
          $(".country-name").val(ui.item.country_name);
          $(".store-id").val(ui.item.store_id);
        }
      });

    });

    $("#video-name").focus(function() {

      $(this).autocomplete({
        source: "/search/video-name",
        minLength: 1,
        select: function(event, ui) {
          $(this).val(ui.item.value);
          $(".video-id").val(ui.item.id);
        }
      });

    });

    $("#add-store-btn").click(function(e){

      e.preventDefault();

      var count = 0;
      var errors = new Array();
      var validationFailed = false;

      var country_name = $("#country-name").val();
      var country_id = $('#country-id').val();
      var store_name = $("#store-name").val();
      var store_id = $("#store-id").val();
      var partner_id = $("#partner-id").val();

      if(partner_id == 0)
      {
        validationFailed = true;
        errors[count++] = "Please choose partner field.";
      }

      if(store_name == '')
      {
        validationFailed = true;
        errors[count++] = "Store field is empty.";
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
        $('#store-lists td').each(function() {

          if($(this).attr('id') == 'no-data')
          {
            $(this).parent().remove();
          }
        });

        $("#store-lists tbody").append("<tr><td><input type='hidden' value='" + country_id + "' name='country_id[]'>" + country_name + "</td>" +
        "<td><input type='hidden' value='" + store_id + "' name='store_id[]'>" + store_name + "</td>" +
        "<td><a href='#' class='remove'>Remove</a></td></tr>");

        $(".alert-danger").removeClass("bg-danger alert alert-error");
        $(".alert-danger").empty();
      }

    });

    $("#add-date-btn").click(function(e) {

      e.preventDefault();

      var from_date = $("#from-date").val();
      var to_date = $("#to-date").val();
      var date = from_date + ' - ' + to_date;
      var timezone = $("#timezone-id").find("option:selected").text();
      var timezone_id = $("#timezone-id").val();

      if(from_date == "" || timezone_id == 0)
      {
        return false;
      }

      else if(from_date != "" && to_date != "" && timezone_id != 0)
      {
        $('#date-lists td').each(function() {

          if($(this).attr('id') == 'no-data')
          {
            $(this).parent().remove();
          }
        });

        $("#date-lists tbody").append("<tr><td><input type='hidden' value='" + date + "' name='date[]'>" + date + "</td>" +
        "<td><input type='hidden' value='" + timezone_id + "' name='timezone_id[]'>" + timezone + "</td>" +
        "<td><a href='#' class='remove'>Remove</a></td></tr>");
      }

      else
      {
        $('#date-lists td').each(function() {

          if($(this).attr('id') == 'no-data')
          {
            $(this).parent().remove();
          }
        });

        $("#date-lists tbody").append("<tr><td><input type='hidden' value='" + from_date + "' name='date[]'>" + from_date + "</td>" +
        "<td><input type='hidden' value='" + timezone_id + "' name='timezone_id[]'>" + timezone + "</td>" +
        "<td><a href='#' class='remove'>Remove</a></td></tr>");
      }

    });

    $("#add-video-btn").click(function(e) {

      e.preventDefault();

      var video_id = $("#video-id").val();
      var video_name = $("#video-name").val();

      if(video_name == '')
      {
        return false;
      }

      $('#video-lists td').each(function() {

        if($(this).attr('id') == 'no-data')
        {
          $(this).parent().remove();
        }
      });

      if(video_id)
      {
        $("#video-lists tbody").append("<tr title='Drag for Sequence'><td><input type='hidden' value='" + video_id + "' name='video_id[]'>" + video_name + "</td>" +
        "<td><a href='#' class='remove'>Remove</a></td></tr>");
      }

    });

    // Remove Row from Video Lists
    $("#store-lists").on('click', '.remove', function(e) {
      e.preventDefault();

      $(this).parent().parent().remove();

      if($('#store-lists > tbody > tr').length == 0)
      {
        $("#store-lists tbody").append("<tr><td colspan='3' id='no-data'>No Data</td></tr>");
      }
    });

    // Remove Row from Video Lists
    $("#date-lists").on('click', '.remove', function(e) {
      e.preventDefault();

      $(this).parent().parent().remove();

      if($('#date-lists > tbody > tr').length == 0)
      {
        $("#date-lists tbody").append("<tr><td colspan='3' id='no-data'>No Data</td></tr>");
      }
    });

    // Remove Row from Video Lists
    $("#video-lists").on('click', '.remove', function(e) {
      e.preventDefault();

      $(this).parent().parent().remove();

      if($('#video-lists > tbody > tr').length == 0)
      {
        $("#video-lists tbody").append("<tr><td colspan='2' id='no-data'>No Data</td></tr>");
      }
    });

    $("#submit").click(function() {

      $(".alert-success").remove();

      var count = 0;
      var errors = new Array();
      var validationFailed = false;

      var storeRow = $('#store-lists > tbody > tr').length;
      var dateRow = $('#date-lists > tbody > tr').length;
      var videoRow = $('#video-lists > tbody > tr').length;

      $('#store-lists td').each(function() {

        if($(this).attr('id') == 'no-data')
        {
          validationFailed = true;
          errors[count++] = "Stores are empty.";
        }
      });

      $('#date-lists td').each(function() {

        if($(this).attr('id') == 'no-data')
        {
          validationFailed = true;
          errors[count++] = "Dates are empty.";
        }
      });

      if(storeRow != dateRow)
      {
        validationFailed = true;
        errors[count++] = "Store and Dates are not the match.";
      }

      $('#video-lists td').each(function() {

        if($(this).attr('id') == 'no-data')
        {
          validationFailed = true;
          errors[count++] = "Videos are empty.";
        }
      });

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
