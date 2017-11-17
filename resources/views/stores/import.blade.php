@extends('layout.master')
@section('title', 'New Store - Import')
@section('content')

<div class="content-wrapper">
  <div class="container">
    <div class="row">
      <div class="col-md-12"><h4 class="page-head-line">New Store - Import</h4></div><!-- end col-md-12 -->
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
            <div class="panel-heading"><h4>New Store - Import</h4></div><!-- end panel-heading -->

            <div class="panel-body">

              <div class="row form-area-with-inputs">
  	            <div class="col-md-12">
                  {!!Form::open(['class'=>'submit_now'])!!}

                  <div class="form-group">
          		    	<div class="col-md-5 no-padding-left">
          		    	  {!! Form::text('import',NULL,['class'=>'form-control partner-name', 'id'=>'partner']) !!}
          		    	</div>

                    <div class="col-md-1">
                      <a href="#" class="btn btn-default">Browse</a>
                    </div><!-- end col-md-1 -->

                    <div class="col-md-1">
                      <button type="button" class="btn btn-default">Import</button>
                    </div><!-- end col-md-1 -->
          		  	</div><!-- end form-group -->

                  {!! Form::close() !!}

                </div><!-- end col-md-12 -->

                <div class="col-md-12">
                  <p>
                    Tip: Please browse and select a CSV file to import stores. Get the template <a href="#">here</a>.
                  </p>
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
