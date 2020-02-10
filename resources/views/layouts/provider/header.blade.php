<!-- header -->
<nav class="navbar top-navbar col-lg-12 col-12 p-0">
  <div class="container">
    <div class="navbar-menu-wrapper d-flex align-items-stretch justify-content-between">
      <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
        <a class="navbar-brand brand-logo" href="{{ route('provider.index') }}"
        ><img src="{{ Setting::get('site_logo') }}" alt="logo" /></a>
        <h3><strong>{{Setting::get('site_name')}}</strong></h3>
      </div>
      <ul class="navbar-nav navbar-nav-right">
        <li class="nav-item nav-profile dropdown">
          <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
            @if(Auth::guard('provider')->user()->picture)
            <img src="{{Auth::guard('provider')->user()->picture}}"/>
            @else 
            <img src="{{asset('placeholder.jpg')}}"/>
            @endif
            <span class="nav-profile-name">{{Auth::guard('provider')->user()->name}}</span>
          </a>
          <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
            <a class="dropdown-item" href="{{route('provider.profile')}}">
              <i class="mdi mdi-account text-primary"></i>
              {{tr('profile')}}
            </a>
           
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="{{route('provider.logout')}}" >
              <i class="mdi mdi-logout text-primary"></i>
              {{tr('logout')}}
            </a>
          </div>
        </li>
        <li class="nav-item nav-toggler-item-right d-lg-none">
          <button class="navbar-toggler align-self-center" type="button" data-toggle="horizontal-menu-toggle">
            <span class="mdi mdi-menu"></span>
          </button>
        </li>
      </ul>
    </div>
  </div>
</nav>