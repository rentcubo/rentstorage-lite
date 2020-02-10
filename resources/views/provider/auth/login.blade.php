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
              <h4>{{tr('login_message')}}</h4>
              <h6 class="font-weight-light">{{tr('login_continue')}}</h6>
              @include('notifications.notification')
              <br>

              <form class="forms-sample" method="post" action="{{ route('provider.login') }}">
                @csrf
                <div class="form-group row">
                  <label for="email" class="col-sm-3 col-form-label">{{tr('email')}} *</label>
                  <div class="col-sm-9">
                    <input type="email" class="form-control" id="email" name="email" placeholder="{{tr('email')}}" value= "{{ old('email') }}" required>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="password" class="col-sm-3 col-form-label">{{tr('password')}} *</label>
                  <div class="col-sm-9">
                    <input type="password" class="form-control" id="password" name="password" placeholder="{{tr('password')}}" value= "{{ old('password') }}" required>
                  </div>
                </div>
               
                <button type="submit" class="btn btn-primary mr-2">{{tr('login')}}</button>
                <button type="reset" class="btn btn-light">{{tr('cancel')}}</button>
              </form>
              <hr>

              <div class="text-center mt-4 font-weight-light">
                  <a href="{{ route('provider.password.request') }}" class="text-primary">{{ tr('forgot_password') }} ?</a>
              </div>
              <div class="text-center mt-4 font-weight-light">
                  {{ tr('new_account') }} 
                  <a href="{{ route('provider.register') }}" class="text-primary">{{ tr('register') }}</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
 



@endsection