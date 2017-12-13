@extends('layout.master')
@section('title', 'FAQ')
@section('content')

<div class="content-wrapper">
  <div class="container">

    <div class="row">

      @if(Auth::user()->role == 0 || Auth::user()->role == 1)
      <div class="col-md-12">
        <h4 class="page-head-line">FAQ (Admin)</h4>
      </div><!-- end col-md-12 -->

      @else

      <div class="col-md-12">
        <h4 class="page-head-line">FAQ (Client)</h4>
      </div><!-- end col-md-12 -->

      @endif

    </div><!-- end row -->

    <div class="wrap-content">

      <div class="row">

        @if(Auth::user()->role == 0 || Auth::user()->role == 1)
        <div class="col-md-12">
          <h5 class="sub-head-line">Video Module</h5>

          <h6 class="heading6">Q: Why video upload will be fail?</h6>
          <p>
            A: There is two possibility, one is you close the browser before the uploading is fully loaded. Another is you
            try to upload the file which is bigger than 512MB. Please inform admin or Palazon
            <a href="mailto:support@palazon.com" target="_top">(support@palazon.com)</a> to adjust accordingly.
          </p>

          <h6 class="heading6">Q: Are all the fields in the forms needed to be entered?</h6>
          <p class="paragraph">
            A: Only the fields with the red asterisks symbol are compulsory to be entered.
          </p>

          <h5 class="sub-head-line">Store Module</h5>

          <h6 class="heading6">Q: How to upload stores in CSV format?</h6>
          <p>
            A: You need to get the template from <a href="{{ URL::to('download/store_template.xlsx') }}">here</a>, remain the headers, and insert the stores
              details' fields. store_name, partner_name and country_name need to be same in the system.
          </p>

          <h6 class="heading6">Q: Why Country’s dropdown list is empty?</h6>
          <p>
            A: You need to select Partner first, then respective country for that partner will be shown in dropdown list.
          </p>

          <h6 class="heading6">Q: Are all the fields in the forms needed to be entered?</h6>
          <p class="paragraph">
            A: Only the fields with the red asterisks symbol are compulsory to be entered.
          </p>

          <h5 class="sub-head-line">Country Module</h5>

          <h6 class="heading6">Q: Why some countries cannot be removed?</h6>
          <p>
            A: If there are stores under the country, you cannot remove that particular country unless stores
            under that particular country have been deleted.
          </p>

          <h6 class="heading6">Q: Are all the fields in the forms needed to be entered?</h6>
          <p class="paragraph">
            A: Only the fields with the red asterisks symbol are compulsory to be entered.
          </p>

          <h5 class="sub-head-line">User Module</h5>

          <h6 class="heading6">Q: Why there are no partner, country, and store fields in user module?</h6>
          <p>
            A: You need to select on Role field, then respective partner, country, and store fields will be appeared according to the role.
          </p>

          <h6 class="heading6">Q: Are all the fields in the forms needed to be entered?</h6>
          <p class="paragraph">
            A: Only the fields with the red asterisks symbol are compulsory to be entered.
          </p>

          <h5 class="sub-head-line">Partner Module</h5>

          <h6 class="heading6">Q: Why some partners cannot be removed?</h6>
          <p>
            A: If there are countries under the partner, you cannot remove that particular partner unless countries
            under that particular partner have been deleted.
          </p>

          <h6 class="heading6">Q: Are all the fields in the forms needed to be entered?</h6>
          <p>
            A: Only the fields with the red asterisks symbol are compulsory to be entered.
          </p>
        </div><!-- end col-md-12 -->
        @endif


        @if(Auth::user()->role == 2)
        <div class="col-md-12">

          <h5 class="sub-head-line">Store Module</h5>

          <h6 class="heading6">Q: Why Country’s dropdown list is empty?</h6>
          <p class="paragraph">
            A: You need to select Partner first, then respective country for that partner will be shown in dropdown list.
          </p>

          <h5 class="sub-head-line">Settings Module</h5>

          <h6 class="heading6">Q: Are all the fields in the forms needed to be entered?</h6>
          <p class="paragraph">
            A: Yes, all the fields with the red asterisks symbol are compulsory to be entered.
          </p>

        </div><!-- end col-md-12 -->
        @endif

      </div><!-- end row -->

    </div><!-- end wrap-content -->

  </div><!-- end container -->
</div><!-- end content-wrapper -->


@stop
