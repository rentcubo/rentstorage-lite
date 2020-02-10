@extends('layouts.provider.focused')

@section('content')

<div class="main-panel">
    <div class="content-wrapper d-flex align-items-center auth">
        <div class="row w-100">
            <div class="col-lg-6 mx-auto">
                <div class="auth-form-light text-left p-5">
                    
                    <div class="brand-logo">
                      <h4><b>{{Setting::get('site_name')}}</b></h4>
                    </div>

                    @include('notifications.notification')

                    <h4>{{ tr('reset_password') }}</h4>

                    <h6 class="font-weight-light">{{ tr('reset_to_continue') }}</h6>

                    <form class="pt-3" action="{{ route('provider.password.request') }}" method="post">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">
                        <input type="hidden" name="email" value="{{ $email }}">

                        
                        <div class="form-group row">
                          <label for="password" class="col-sm-3 col-form-label">{{tr('password')}} *</label>
                          <div class="col-sm-9">
                            <input type="password" name="password" class="form-control" id="exampleInputPassword" placeholder="{{ tr('password') }}" required>
                        
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="confirm_password" class="col-sm-3 col-form-label">{{tr('confirm_password')}} *</label>
                          <div class="col-sm-9">
                            <input type="password" name="password_confirmation" class="form-control" id="exampleInputPassword" placeholder="{{ tr('confirm_password') }}" required>
                        
                          </div>
                        </div>

                        <div class="my-3">
                            <input type="submit" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn" value=" {{ tr('reset_password') }}">
                        </div>

                        <div class="text-center mt-4 font-weight-light">
                            {{ tr('new_account') }} 
                            <a href="{{ route('provider.register') }}" class="text-primary">{{ tr('register') }}</a>
                        </div>

                        <div class="text-center mt-4 font-weight-light">
                            {{ tr('already_account') }} 
                            <a href="{{ route('provider.login') }}" class="text-primary">{{ tr('login') }}</a>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>