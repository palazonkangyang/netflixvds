<script type="text/javascript" src="{{ asset('/js/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/js/bootstrap.min.js') }}"></script>

<script type="text/javascript">

  $(function() {

    var path = window.location.pathname;

    var string = path.split('/');

    $('.navbar-nav li a').each(function() {
	    if ($(this).attr('href') == "/" + string[1]) {

				$(this).parent().addClass('active');
	    }
   });

  });

</script>
