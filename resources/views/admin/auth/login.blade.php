@extends('layouts.admin.focused')

@section('content')


	<div class="login">

	    <h1>{{tr('admin_login')}}</h1>

	    <form method="POST" action="{{ route('admin.login') }}">
	        @csrf
	        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ Setting::get('demo_admin_email') }}" required autocomplete="email" autofocus placeholder="">

	        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" value="{{ old('email') ?: Setting::get('demo_admin_password') }}" name="password" required autocomplete="current-password">

	        <button type="submit" class="btn btn-primary btn-block btn-large">{{tr('login')}}</button>
	        
	    </form>

	</div>

@endsection
