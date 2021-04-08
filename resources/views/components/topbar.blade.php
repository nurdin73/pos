<button class="c-header-toggler c-class-toggler d-lg-none mfe-auto" type="button" data-target="#sidebar" data-class="c-sidebar-show">
  <svg class="c-icon c-icon-lg">
    <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-menu') }}"></use>
  </svg>
  <span class="sr-only">Sidebar</span>
</button>
<a class="c-header-brand d-lg-none" href="{{ route('dashboardAdmin') }}">
  POS
</a>
<button class="c-header-toggler c-class-toggler mfs-3 d-md-down-none" type="button" data-target="#sidebar" data-class="c-sidebar-lg-show" responsive="true">
  <svg class="c-icon c-icon-lg">
    <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-menu') }}"></use>
  </svg>
  <span class="sr-only">Sidebar</span>
</button>
<ul class="c-header-nav ml-auto mr-4">
  {{-- <li class="c-header-nav-item d-md-down-none mx-2">
    <a class="c-header-nav-link changeTheme" href="#"> --}}
      {{-- <svg class="c-icon">
        <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-sun') }}"></use>
      </svg> --}}
    {{-- </a>
  </li> --}}
  <li class="c-header-nav-item d-md-down-none mx-2">
    <a class="c-header-nav-link" href="#">
      <svg class="c-icon">
        <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-bell') }}"></use>
      </svg>
    </a>
  </li>
  <li class="c-header-nav-item dropdown"><a class="c-header-nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
      <div class="c-avatar"><img class="c-avatar-img" src="{{ asset('assets/img/avatars/avatar-1.png') }}" width="50" height="50" alt="user@email.com"></div>
    </a>
    <div class="dropdown-menu dropdown-menu-right pt-0">
      <div class="dropdown-header bg-light py-2">
        <strong>Settings</strong>
      </div>
      <a class="dropdown-item" href="{{ route('settingProfile') }}">
        <svg class="c-icon mr-2">
          <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-user') }}"></use>
        </svg> Profile
      </a>
      <div class="dropdown-divider"></div>
      <a class="dropdown-item" href="#">
        <svg class="c-icon mr-2">
          <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-lock-locked') }}"></use>
        </svg> Lock Account
      </a>
      <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        <svg class="c-icon mr-2">
          <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-account-logout') }}"></use>
        </svg> Logout
      </a>
      <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
        @csrf
      </form>
    </div>
  </li>
</ul>