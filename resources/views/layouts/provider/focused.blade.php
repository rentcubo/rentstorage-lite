<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ Setting::get('site_name')}}</title>
    <!-- plugins:css -->
    @include('layouts.provider.styles')
</head>

<body>
    <div class="horizontal-menu">
        <nav class="navbar top-navbar col-lg-12 col-12 p-0">
          <div class="container">
                <div class="navbar-menu-wrapper d-flex align-items-stretch justify-content-between">
                  <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
            
                    <a class="navbar-brand brand-logo" href="{{ route('provider.login') }}"
                    ><img src="{{ Setting::get('site_logo') }}" alt="logo" /></a>

                    <h3><strong>{{Setting::get('site_name')}}</strong></h3>

                  </div>
                </div>
            </div>
        </nav>
        <nav class="bottom-navbar">
            <div class="container">
                <div class="pull-right">
                    
                    <ul class="nav page-navigation">
                        <li class="nav-item">
                            <a href="{{ route('register') }}" class="nav-link">
                                <i class="fa fa-user menu-icon"></i>
                                <span class="menu-title">{{ tr('become_user') }}</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

    </div>
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper">
            <div class="main-panel">
                <div class="content-wrapper">

                    @yield('content')

                </div>
                <footer class="footer">
                    <div class="w-100 clearfix">

                        <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">{{ tr('copyright') }} © {{ date("Y") }}  <a href="#" target="_blank">{{ setting()->get('site_name') }}, </a>{{ tr('all_rights_reserved') }}.</span>&emsp;
                    </div>
                </footer>
            </div>
        </div>
    </div>
    
    @include('layouts.provider.scripts')
</body>

</html>

</html>