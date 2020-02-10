<!DOCTYPE html>
<html>
<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="{{ Setting::get('site_icon') }}" />
	<title>{{Setting::get('site_name')}}</title>
	@include('layouts.provider.styles')
</head>
<body class="hold-transition skin-blue sidebar-mini">
	<div class="container-scroller">
		<div class="horizontal-menu">
			@include('layouts.provider.header')

			@include('layouts.provider.navbar')
		</div>
		<div class="container-fluid page-body-wrapper">
		   	<div class="main-panel">
		   		<div class="content-wrapper">

		   			@include('notifications.notification')

		   			@yield('content')

		   		</div>
		   		@include('layouts.provider.footer')
		   	</div>
		</div>
	</div>
	@include('layouts.provider.scripts')
</body>
</html>
