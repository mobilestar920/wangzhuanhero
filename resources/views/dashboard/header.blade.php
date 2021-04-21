<header class="c-header c-header-light c-header-fixed c-header-with-subheader">
  <button class="c-header-toggler c-class-toggler d-lg-none mr-auto" type="button" data-target="#sidebar" data-class="c-sidebar-show">
    <span class="c-header-toggler-icon"></span>
  </button>
  <a class="c-header-brand d-sm-none" href="#">
    <img class="c-header-brand" src="{{ url('/assets/brand/coreui-base.svg') }}" width="97" height="46" alt="CoreUI Logo">
  </a>
  <button class="c-header-toggler c-class-toggler ml-3 d-md-down-none" type="button" data-target="#sidebar" data-class="c-sidebar-lg-show" responsive="true">
    <span class="c-header-toggler-icon"></span>
  </button>
  <ul class="c-header-nav ml-auto mr-4">
    <li class="c-header-nav-item dropdown">
      <a class="c-header-nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
        {{ Auth::user()->username }}
      </a>
    </li>
  </ul>
</header>