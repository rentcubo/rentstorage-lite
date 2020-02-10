@extends('layouts.user.focused') 

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


                    <form class="forms-sample" action="{{ route('register') }}" method="POST">
                        @csrf
                         <input type="hidden" name="timezone" class="form-control " id="timezone"  value="" />
                        <div class="form-group row">
                            <label for="first_name" class="col-sm-3 col-form-label">{{tr('first_name')}} *</label>
                            <div class="col-sm-9">
                                <input type="text" name="first_name" class="form-control" placeholder="{{ tr('first_name') }}" value="{{ old('first_name') }}" pattern="[a-zA-Z]{3,}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="last_name" class="col-sm-3 col-form-label">{{tr('last_name')}} *</label>
                            <div class="col-sm-9">
                                <input type="text" name="last_name" class="form-control" placeholder="{{ tr('last_name') }}" value="{{ old('last_name') }}" pattern="[a-zA-Z]{1,}" required>

                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="email" class="col-sm-3 col-form-label">{{tr('email')}} *</label>
                            <div class="col-sm-9">
                                <input type="email" name="email" class="form-control" placeholder="{{ tr('email') }}" value="{{ old('email') }}" required>

                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="password" class="col-sm-3 col-form-label">{{tr('password')}} *</label>
                            <div class="col-sm-9">
                                <input type="password" name="password" class="form-control" id="password" minlength="6" placeholder="{{ tr('password') }}" required>

                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="confirm_password" class="col-sm-3 col-form-label">{{tr('confirm_password')}} *</label>
                            <div class="col-sm-9">
                                <input type="password" name="password_confirmation" class="form-control" id="confirm_password" placeholder="{{ tr('confirm_password') }}" minlength="6" required>

                            </div>
                        </div>

                        <input type="submit" value="{{ tr('register') }}" class="btn btn-primary">

                    </form>
                    <hr>
                    <div class="text-center mt-4 font-weight-light">
                        {{ tr('already_account') }} 
                        <a href="{{ route('login') }}" class="text-primary">{{ tr('login') }}</a>
                    </div>
                    <br>

                </div>
            </div>

            
        </div>
    </div>
</div>
    <!-- content-wrapper ends -->

     <script type="text/javascript">

        timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;

        document.getElementById('timezone').value = timezone;

    </script>
@endsection
