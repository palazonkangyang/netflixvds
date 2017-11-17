@if(Auth::check())

  <footer>
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          Copyright &copy; <?= date('Y') ?>. All Right Reserved.
        </div>
      </div>
    </div>
  </footer>

@endif
