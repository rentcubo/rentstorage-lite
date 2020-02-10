<!-- header -->
<nav class="navbar top-navbar col-lg-12 col-12 p-0">
  <div class="container">
    <div class="navbar-menu-wrapper d-flex align-items-stretch justify-content-between">
      <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">

        <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
            
            <a class="navbar-brand brand-logo" href="{{ route('spaces.index') }}"><img src="{{ setting::get('site_logo') }}" alt="logo" /></a>

        </div>
      
        <h3><strong>{{Setting::get('site_name')}}</strong></h3>
      </div>
      <ul class="navbar-nav navbar-nav-right">
        <li class="nav-item nav-profile dropdown">
          <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
            @if(Auth::guard('web')->user()->picture)
            <img src="{{Auth::guard('web')->user()->picture}}"/>
            @else 
            <img src="{{asset('placeholder.jpg')}}"/>
            @endif
            <span class="nav-profile-name">{{Auth::guard('web')->user()->name}}</span>
          </a>
          <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
            <a class="dropdown-item" href="{{ route('user.profile') }}">
              <i class="mdi mdi-account text-primary"></i>
              {{tr('profile')}}
            </a>
           
            <div class="dropdown-divider"></div>
            <div class="dropdown-item">
                <i class="mdi mdi-logout text-primary"></i>
                <a href="{{route('logout')}}" class="dropdown-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{ tr('logout') }}</a>
               <form id="logout-form" action="{{ route('logout') }}" method="POST">
                    @csrf
                </form>
            </div>
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