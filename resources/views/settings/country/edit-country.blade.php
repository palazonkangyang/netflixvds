@extends('layout.master')
@section('title', 'Edit Country')
@section('content')

<div class="content-wrapper">
  <div class="container">
    <div class="row">
      <div class="col-md-12"><h4 class="page-head-line">Edit Country</h4></div><!-- end col-md-12 -->
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
            <div class="panel-heading"><h4>Edit Country</h4></div><!-- end panel-heading -->

            <div class="panel-body">

              <div class="row form-area-with-inputs">
  	            <div class="col-md-12">
                  {!! Form::open(array("url"=>"/settings/edit/country/". $country->id)) !!}

                  <div class="form-group">
                    {!! Form::hidden('id', $country->id, ['class'=>'form-control', 'id'=>'id']) !!}
                  </div>

                  <div class="form-group">
          		   		<label class="col-md-2">Country Name</label>
          		    	<div class="col-md-6">
          		    	  {!! Form::text('country_name', $country->country_name, ['class'=>'form-control country-name', 'id'=>'country-name']) !!}
          		    	</div>
          		  	</div><!-- end form-group -->

                  <hr />
                  <button type="submit" class="btn btn-default margin-right" id="update">Update</button>
                  <button type="reset" class="btn btn-default margin-right" id="cancel">Cancel</button>
                  <a class="btn btn-default" href="{{ URL::previous() }}">back</a>

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
