@extends('layout.master')
@section('title', 'New Video')
@section('content')

<div class="content-wrapper">
  <div class="container">
    <div class="row">
      <div class="col-md-12"><h4 class="page-head-line">New Video</h4></div><!-- end col-md-12 -->
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
            <div class="panel-heading"><h4>Video Upload</h4></div><!-- end panel-heading -->

            <div class="panel-body">

              <div class="row form-area-with-inputs">
                <div class="col-md-12">
                  {!!Form::open(['enctype'=>'multipart/form-data'])!!}

                  <div class="form-group">
                    <label class="col-md-2">Code <span class="text-danger">*</span></label>
                    <div class="col-md-6">
                      {!! Form::text('code', NULL, ['class'=>'form-control code', 'id'=>'code']) !!}
                    </div>
                  </div><!-- end form-group -->

                  <div class="form-group">
                    <label class="col-md-2">Title <span class="text-danger">*</span></label>
                    <div class="col-md-6">
                      {!! Form::text('title', NULL, ['class'=>'form-control title', 'id'=>'title']) !!}
                    </div>
                  </div><!-- end form-group -->

                  <div class="form-group">
                    <label class="col-md-2">Description</label>
                    <div class="col-md-6">
                      {{ Form::textarea('description', NULL, ['class'=>'form-control description', 'id'=>'description', 'size' => '30x5']) }}
                    </div>
                  </div><!-- end form-group -->

                  <div class="form-group">
                    <label class="col-md-2">Duration</label>
                    <div class="col-md-6">
                      {!! Form::text('duration', NULL, ['class'=>'form-control duration', 'id'=>'duration']) !!}
                    </div>
                  </div><!-- end form-group -->

                  <div class="form-group">
                    <label class="col-md-2">Category <span class="text-danger">*</span></label>
                    <div class="col-md-6">
                      <select class="form-control" name="category_id" id="category-id">
                        <option value="0">Select a Category</option>

                        @foreach($categories as $data)
                        <option value="{{ $data->id }}">{{ $data->category_name }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div><!-- end form-group -->

                  <div class="form-group">
                    <label class="col-md-2">Upload <span class="text-danger">*</span></label>
                    <div class="col-md-6">
                      {!! Form::file('file', ['class'=>'video', 'id'=>'file']) !!}
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

  <script type="text/javascript">

    $(function() {

      $("#submit").click(function() {

        var count = 0;
        var errors = new Array();
        var validationFailed = false;

        var code = $("#code").val();
        var title = $("#title").val();
        var category_id = $("#category-id").val();
        var file = $('#file').val();

        if($.trim(code).length <= 0)
        {
          validationFailed = true;
          errors[count++] = "Code field is empty.";
        }

        if($.trim(title).length <= 0)
        {
          validationFailed = true;
          errors[count++] = "Title field is empty.";
        }

        if(category_id == 0)
        {
          validationFailed = true;
          errors[count++] = "Category field is empty.";
        }

        if(file == '')
        {
          validationFailed = true;
          errors[count++] = "Upload field is empty.";
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
