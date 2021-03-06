@extends('layout.master')
@section('title', 'New Partner')
@section('content')

<div class="content-wrapper">
  <div class="container">
    <div class="row">
      <div class="col-md-12"><h4 class="page-head-line">New Partner</h4></div><!-- end col-md-12 -->
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
            <div class="panel-heading"><h4>New Partner</h4></div><!-- end panel-heading -->

            <div class="panel-body">

              <div class="row form-area-with-inputs">
                <div class="col-md-12">
                  {!!Form::open(['id'=>'new-partner-form'])!!}

                  <div class="form-group">
                    <label class="col-md-2">Partner Name</label>
                    <div class="col-md-6">
                      {!! Form::text('partner_name',NULL,['class'=>'form-control partner-name', 'id'=>'partner-name']) !!}
                    </div>
                  </div><!-- end form-group -->

                  <div class="form-group">
                    <label class="col-md-2">Country Name</label>
                    <div class="col-md-6">
                      {!! Form::text('country_name[]',NULL,['class'=>'form-control country-name', 'id'=>'country-name']) !!}
                      {!! Form::hidden('country_id[]',NULL,['class'=>'form-control country-id', 'id'=>'country-id']) !!}
                    </div>
                    <div class="col-md-1"></div>
                  </div><!-- end form-group -->

                  <div id="add-row">
                  </div><!-- end add-row -->

                  <div class="form-group">
                    <label class="col-md-2"></label>
                    <div class="col-md-10">
                      <button type="button" name="button" class="btn btn-default" id="add-btn"><i class="fa fa-plus-circle fa-lg"></i> Add Country</button>
                    </div>
                  </div><!-- end form-group -->

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

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript">

$(function() {

  $("#add-btn").click(function() {
    $("#add-row").append("<div class='form-group'><label class='col-md-2'>Country Name</label>" +
    "<div class='col-md-6'><input type='text' name='country_name[]' class='form-control country-name' id='country-name'>" +
    "<input type='hidden' name='country_id[]' class='form-control country-id' id='country-id'></div>" +
    "<div class='col-md-1'><i class='fa fa-minus-circle fa-lg remove-btn' aria-hidden='true'></i>" +
    "</div></div>");
  });

  $("#add-row").on('click', '.remove-btn', function() {
    $(this).parent().parent().remove();
  });

  $("body").delegate('#country-name', 'focus', function() {

    $(this).autocomplete({
      source: "/search/country-name",
      minLength: 1,
      select: function(event, ui) {
        $(this).val(ui.item.value);
        $(this).closest('div').find('.country-id').val(ui.item.id);
      }
    });
  });

  $("#submit").click(function() {

    var count = 0;
    var errors = new Array();
    var validationFailed = false;

    var partner_name = $("#partner-name").val();

    if($.trim(partner_name).length <= 0)
    {
      validationFailed = true;
      errors[count++] = "Partner Name field is empty.";
    }

    $("#new-partner-form input:text[name^='country_name']").each(function() {

      if (!$.trim($(this).val()).length) {
        validationFailed = true;
        errors[count++] = "Country Name fields are empty.";
        return false;
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
