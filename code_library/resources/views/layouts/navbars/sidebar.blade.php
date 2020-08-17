@push('js')
<!-- <script>
$(document).ready(function() {
  $('.closnv').on('click',function () {
     $('.closenv').width(0);
  })
});
</script> -->
@endpush
<nav class="closenv navbar navbar-vertical fixed-left navbar-expand-md navbar-light bg-white" id="sidenav-main">
  <div class="container-fluid">
      <a class="navbar-brand pt-0 closnv">
          <img src="{{ asset('argon') }}/img/brand/blue.png" class="navbar-brand-img" alt="...">
      </a>
      <div class="collapse navbar-collapse" id="sidenav-collapse-main">

        <!-- Navigation -->
        <ul class="navbar-nav mt-5">
          <li class="nav-item">
              <a class="nav-link" href="">
                  <!-- <i class="ni ni-tv-2 text-primary"></i> {{ __('Dashboard') }} -->
              </a>
          </li>

          <li class="nav-item">
              <a class="nav-link" href="/addcode/create">
                  <i class="fa fa-book text-blue"></i> {{ __('Add Code') }}
              </a>
          </li>
          <li class="nav-item">
              <a class="nav-link" href="/tags">
                  <i class="fa fa-tags text-blue"></i> {{ __('Tags') }}
              </a>
          </li>
          <li class="nav-item">
              <a class="nav-link" href="/search">
              <i class="fa fa-code text-blue" aria-hidden="true"></i> {{ __('Codes') }}
              </a>
          </li>
        </ul>

      </div>
  </div>
</nav>
