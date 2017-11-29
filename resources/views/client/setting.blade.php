@extends('layout.master')
@section('title', 'Client Setting')
@section('content')

<div class="content-wrapper">
  <div class="container">
    <div class="row">
      <div class="col-md-12"><h4 class="page-head-line">Settings</h4></div><!-- end col-md-12 -->
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
            <div class="panel-heading"><h4>Settings</h4></div><!-- end panel-heading -->

            <div class="panel-body">

              <div class="row form-area-with-inputs">

                <div class="col-md-12">

                  {!! Form::open() !!}

                  <div class="form-group">
                    {!! Form::hidden('id', $user->id, ['class'=>'form-control', 'id'=>'id']) !!}
                    {!! Form::hidden('user_id', $user->id, ['class'=>'form-control user-id', 'id'=>'user-id']) !!}
                  </div><!-- end form-group -->

                  <div class="form-group">
                    <label class="col-md-2">Client Key <span class="text-danger">*</span></label>
          		    	<div class="col-md-6">
          		    	  {!! Form::text('client_key', $user->client_key, ['class'=>'form-control client-key', 'id'=>'client-key']) !!}
          		    	</div>
          		  	</div><!-- end form-group -->

                  <div class="form-group">
                    <label class="col-md-2">Time Zone <span class="text-danger">*</span></label>
          		    	<div class="col-md-6">
                      <select class="form-control" name="time_zone" id="time-zone">
                        <option value="0">Select Time Zone</option>
                        @foreach($time_zone as $data)

                          @if(isset($client_setting->time_zone))
                          <option value="{{ $data->id }}" <?php if ($data->id == $client_setting->time_zone) echo "selected"; ?>>{{ $data->name }}</option>
                          @else
                          <option value="{{ $data->id }}">{{ $data->name }}</option>
                          @endif

                        @endforeach
          		    	  </select>
          		    	</div>
          		  	</div><!-- end form-group -->

                  <div class="form-group">
                    <label class="col-md-2">Auto Update <span class="text-danger">*</span></label>
          		    	<div class="col-md-6">
                      {!! Form::text('auto_update', NULL, ['class'=>'form-control auto-update', 'id'=>'auto-update']) !!}
          		    	</div>
          		  	</div><!-- end form-group -->

                  <hr />
                  <button type="submit" class="btn btn-default margin-right" id="submit">Update</button>
                  <button type="reset" class="btn btn-default margin-right" id="cancel">Cancel</button>

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

<link rel="stylesheet" href="{{ asset('/css/wickedpicker.min.css') }}" />

@stop

@section('custom-js')

<script type="text/javascript" src="{{ asset('/js/wickedpicker.min.js') }}"></script>

<script type="text/javascript">

  $(function() {

    var auto_update = "<?= isset($client_setting->auto_update) ? $client_setting->auto_update : '00 : 00'  ?>";

    var options = {
      now: auto_update, //hh:mm 24 hour format only, defaults to current time
      twentyFour: true,  //Display 24 hour format, defaults to false
    };

    $('.auto-update').wickedpicker(options);

  });

</script>

@stop
