@extends('layout.master')
@section('title', 'Roles')
@section('content')

<div class="content-wrapper">
  <div class="container">

    <div class="row">

      <div class="col-md-12">
        <h4 class="page-head-line">Roles</h4>
      </div><!-- end col-md-12 -->

    </div><!-- end row -->

    <div class="wrap-content">

      <div class="row">

        <table class="col-md-12 table-bordered table-striped table-condensed">
          <thead>
            <th>S/N</th>
            <th>Role</th>
            <th>Permission</th>
          </thead>

          <tbody>
            <tr>
              <td>1</td>
              <td>Administrator</td>
              <td>Manage Videos, Schedules, Stores, Settings</td>
            </tr>
            <tr>
              <td>2</td>
              <td>Operator</td>
              <td>Manage Videos, Schedules, Stores</td>
            </tr>
            <tr>
              <td>3</td>
              <td>Client</td>
              <td>Video Download, Retrieve Schedule</td>
            </tr>
          </tbody>
        </table>

      </div><!-- end row -->

    </div><!-- end wrap-content -->

  </div><!-- end container -->
</div><!-- end content-wrapper -->

@stop
