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
                <h4>{{tr('register')}}</h4>
                <br>
                @include('notifications.notification')

                <form class="forms-sample" method="post" action="{{ route('provider.register') }}">
                  @csrf
                  <input type="hidden" name="timezone" class="form-control " id="timezone"  value="" />
                  <div class="form-group row">
                    <label for="name" class="col-sm-3 col-form-label">{{tr('name')}} *</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="name" name="name" minlength="3" placeholder="{{tr('name')}}" value= "{{ old('name') }}" required>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="email" class="col-sm-3 col-form-label">{{tr('email')}} *</label>
                    <div class="col-sm-9">
                      <input type="email" class="form-control" id="email" name="email" placeholder="{{tr('email')}}" value= "{{ old('email') }}" required>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="mobile" class="col-sm-3 col-form-label">{{tr('mobile')}} *</label>
                    <div class="col-sm-9">
                      <input type="number" class="form-control" id="mobile" name="mobile" placeholder="{{tr('mobile')}}" value= "{{ old('mobile') }}" required>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="password" class="col-sm-3 col-form-label">{{tr('password')}} *</label>
                    <div class="col-sm-9">
                      <input type="password" class="form-control" id="password" minlength="6" name="password" placeholder="{{tr('password')}}" value= "{{ old('password') }}" required>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="confirm_password" class="col-sm-3 col-form-label">{{tr('confirm_password')}} *</label>
                    <div class="col-sm-9">
                      <input type="password" class="form-control" id="confirm_password" minlength="6" name="password_confirmation" placeholder="{{tr('confirm_password')}}" required>
                    </div>
                  </div>
                  <button type="submit" class="btn btn-primary">{{tr('register')}}</button>
                </form>
                <br>
                <hr>
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

 <script type="text/javascript">

    timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;

    document.getElementById('timezone').value = timezone;

</script>
@endsection