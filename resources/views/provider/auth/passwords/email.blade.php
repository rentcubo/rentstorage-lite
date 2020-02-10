@extends('layouts.provider.focused')

@section('content')

<div class="main-panel">
    <div class="content-wrapper d-flex align-items-center auth">
        <div class="row w-100">
            <div class="col-lg-5 mx-auto">
                <div class="auth-form-light text-left p-5">
                    <div class="brand-logo">
                      <h4><b>{{Setting::get('site_name')}}</b></h4>
                    </div>
                    @include('notifications.notification')

                    <h4 class="font-weight-light">{{tr('forgot_password')}}</h4>
                    <br>

                    <h6 class="text-muted">{{tr('registered_email')}}</h6>

                    <form class="pt-3" action="{{ route('provider.password.email') }}" method="post">
                        @csrf


                        <div class="form-group row">
                            <label for="email" class="col-sm-3 col-form-label">{{tr('email')}} *</label>
                            <div class="col-sm-9">
                                <input type="email" class="form-control" id="email" name="email" placeholder="{{tr('email')}}" value= "{{ old('email') }}" required>
                            </div>
                        </div>
                                
                        <div class="my-3">
                            <input type="submit" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn" value=" {{ tr('reset_link') }}">
                        </div>

                        
                    </form>

                    <hr>
                    <div class="text-center mt-4 font-weight-light">
                        {{ tr('new_account') }} 
                        <a href="{{ route('provider.register') }}" class="text-primary">{{ tr('register') }}</a>
                    </div>

                    <div class="text-center mt-4 font-weight-light">
                        {{ tr('already_account') }} 
                        <a href="{{ route('provider.login') }}" class="text-primary">{{ tr('login') }}</a>
                    </div>
                    <br>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
