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
                  {!!Form::open(['class'=>'dropzone', 'id'=>'myAwesomeDropzone', 'enctype'=>'multipart/form-data'])!!}

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
                    <div class="col-md-6 wrap-zone" style="padding: 0;">
                      <div class="col-md-12 dropzone dz-clickable" id="fileUpload">
                        <div class="dz-message" data-dz-message>
                          <span>Click to Select Video File <br/>or Drag & Drop a File Here</span>
                        </div>
                      </div>
                    </div>
                    <div class="clear-left">
                      <div class="file-list"></div>
                    </div>
                  </div><!-- end form-group -->

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

@section('custom-css')
  <link rel="stylesheet" href="{{ asset('/packages/dropzone/dist/min/basic.min.css') }}"/>
@stop

@section('custom-js')

  <script type="text/javascript" src="{{ asset('/packages/dropzone/dist/dropzone.js') }}"></script>

  <script type="text/javascript">

    var baseUrl = "{{ url('/') }}";
    var token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    var AppFile = new Dropzone("div#fileUpload", {
      url: baseUrl + "/file/uploadFiles",
      params: {
        _token: token
      }
    });

    Dropzone.options.myAwesomeDropzone = {
      maxFiles: 1,
      paramName: "file", // The name that will be used to transfer the file
      maxFilesize: 2048, // MB
      init: function() {
        this.on("maxfilesexceeded", function(file){
          this.removeAllFiles();
          this.addFile(file);
        });
      }
    };

    Dropzone.autoDiscover = false;

    Dropzone.options.AppFile = {
      paramName: "file", // The name that will be used to transfer the file
      addRemoveLinks: true,
    };

    AppFile.on("error", function (file, done) {
      console.log(file);
    });

    AppFile.on("addedfile", function (file, done) {
      var removeButton = Dropzone.createElement('<div class="remove-x"><button>Remove</button></div>');
      var _this = this;
      var name = file.name;

      if (this.files.length) {
        var _i, _len;
        for (_i = 0, _len = this.files.length; _i < _len - 1; _i++) // -1 to exclude current file
        {
          if (this.files[_i].name === file.name && this.files[_i].size === file.size && this.files[_i].lastModifiedDate.toString() === file.lastModifiedDate.toString()) {
            this.removeFile(file);
          }
        }
      }

      removeButton.addEventListener("click", function (e) {
        e.preventDefault();
        e.stopPropagation();
        _this.removeFile(file);

        filrem = $('.file-list input[data-file-name="' + name + '"]').val();
        filinput = $('.file-list input[data-file-name="' + name + '"]').parent().remove();

        $.ajax({
          type: 'GET',
          url: '/file/removeFiles/' + filrem,
          dataType: 'html',
          success: function (data) {
            console.log(data);
          },
        });

      });

      file.previewElement.appendChild(removeButton);
    });

    AppFile.on("success", function (file, responseText) {
      var _ref;

      if (responseText.errors) {
        var errormsg = responseText.errors.file;

        this.removeFile(this.files);
        $('.err-file > span').remove();
        $('.err-file').append('<span class="alert alert-danger">' + errormsg + '<span>');
        setTimeout(function () {
          $('.err-file > span').remove();
        }, 6000);

        return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;
      }

      if (responseText.status) {
        $('.file-list').append('<div class="filesperline"><input data-file-name="' + responseText.file_name + '" type="hidden" name="fileurl[]" value="' + responseText.file_url + '" /> <input data-file-name="' + responseText.file_name + '" type="hidden" name="filename[]" value="' + responseText.file_name + '" /> <input data-file-name="' + responseText.file_name + '" type="hidden" name="mimetype[]" value="' + responseText.mimetype + '" /></div>');
      }
      else {

        this.removeFile(this.files);
        $('.err-file > span').remove();
        $('.err-file').append('<span class="alert alert-danger">Error. Size is too big to upload! Limit size: 3MB<span>');
        setTimeout(function () {
          $('.err-file > span').remove();
        }, 6000);
        return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;
      }
    });

    $(function() {

      $("#submit").click(function() {

        var count = 0;
        var errors = new Array();
        var validationFailed = false;

        var code = $("#code").val();
        var title = $("#title").val();
        var category_id = $("#category-id").val();

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
