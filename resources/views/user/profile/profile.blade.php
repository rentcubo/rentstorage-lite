@extends('layouts.user')

@section('title', tr('profile'))

@section('content-header', tr('profile'))


@section('content')

<div class="row">
  {{-- <div class="col-md-12 grid-margin grid-margin stretch-card "> --}}
  <div class="col-md-5 grid-margin grid-margin-md-1 stretch-card">

    <div class="card">
      <div class="card-body">
        <div class="col-md-5">
          <img src="{{ Auth::guard('web')->user()->picture ?: asset('default-profile.jpg')}}" style="width: 380px; height: 260px; margin-bottom: 15px; border-radius:2em;" alt="profile image">
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-7 grid-margin grid-margin-md-1 stretch-card">

    <div class="card">
      <div class="card-body">
        <div class="col-md-12">
          <div class="text-center">
              <div class="mb-4">
                  <h3 class="profile-username text-center">{{Auth::guard('web')->user()->name}}</h3>
                  <p class="text-muted text-center">{{tr('user')}}</p>
              </div>
          </div>
          <hr><br>

          <div class="py-6">
              <p class="clearfix">
                <span class="float-left">
                  {{tr('first_name')}}
                </span>
                <span class="float-right text-muted">
                  {{Auth::guard('web')->user()->first_name}}
                </span>
              </p>
              <p class="clearfix">
                <span class="float-left">
                  {{tr('last_name')}}
                </span>
                <span class="float-right text-muted">
                  {{Auth::guard('web')->user()->last_name}}
                </span>
              </p>

              <p class="clearfix">
                <span class="float-left">
                  {{tr('email')}}
                </span>
                <span class="float-right text-muted">
                  {{Auth::guard('web')->user()->email}}
                </span>
              </p>
              <p class="clearfix">
                <span class="float-left">
                  {{tr('mobile')}}
                </span>
                <span class="float-right text-muted">
                  {{Auth::guard('web')->user()->mobile}}
                </span>
              </p>
              <p class="clearfix">
                <span class="float-left">
                  {{tr('description')}}
                </span>
                <span class="float-right text-muted">
                  {{Auth::guard('web')->user()->description}}
                </span>
              </p>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>


    <div class="row">

        <div class="col-md-12 stretch-card ">

          <div class="card">

            <div class="card-body">
              <h4 class="card-title">{{tr('account_details')}}</h4>

              <ul class="nav nav-pills nav-pills-custom" id="pills-tab-custom" role="tablist">
                <li class="nav-item">
                  <a class="nav-link active" id="pills-home-tab-custom" data-toggle="pill" href="#pills-health" role="tab" aria-controls="pills-home" aria-selected="true">
                    {{ tr('update_profile') }}
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="pills-profile-tab-custom" data-toggle="pill" href="#pills-career" role="tab" aria-controls="pills-profile" aria-selected="false">
                    {{ tr('upload_image') }}
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="pills-contact-tab-custom" data-toggle="pill" href="#pills-music" role="tab" aria-controls="pills-contact" aria-selected="false">
                    {{ tr('change_password') }}
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="pills-vibes-tab-custom" data-toggle="pill" href="#pills-vibes" role="tab" aria-controls="pills-contact" aria-selected="false">
                    {{ tr('delete_account') }}
                  </a>
                </li>
              </li>
            </ul>
            <div class="tab-content tab-content-custom-pill" id="pills-tabContent-custom">
              <div class="tab-pane fade active show" id="pills-health" role="tabpanel" aria-labelledby="pills-home-tab-custom">

                <div class="media">

                  <div class="media-body">
                    <form class="form-horizontal" action="{{route('profile.save')}}" method="POST" enctype="multipart/form-data" role="form">

                      @csrf

                      <input type="hidden" name="user_id" value="{{Auth::guard('web')->user()->id}}">

                      <div class="form-group">
                        <label for="first_name">{{tr('first_name')}} *</label>

                        <input type="text" class="form-control" id="first_name"  name="first_name" value="{{Auth::guard('web')->user()->first_name}}" placeholder="{{tr('first_name')}}" required>
                      </div>
                      <div class="form-group">
                        <label for="last_name">{{tr('last_name')}} *</label>

                        <input type="text" class="form-control" id="last_name"  name="last_name" value="{{Auth::guard('web')->user()->last_name}}" placeholder="{{tr('last_name')}}" required>
                      </div>

                      <div class="form-group">
                        <label for="email" >{{tr('email')}} *</label>

                        <input type="email" required value="{{Auth::guard('web')->user()->email}}" name="email" class="form-control" id="email" placeholder="{{tr('email')}}">
                      </div>


                      <div class="form-group">
                        <label for="mobile" >{{tr('mobile')}} *</label>

                        <input type="number" required value="{{Auth::guard('web')->user()->mobile}}" name="mobile" class="form-control" id="mobile" placeholder="{{tr('mobile')}}" minlength="6" >
                      </div>

                      <div class="form-group">
                        <label for="description">{{tr('description')}} *</label>

                        <input type="text" required value="{{Auth::guard('web')->user()->description}}" name="description" class="form-control" id="description" placeholder="{{tr('description')}}" minlength="5">
                      </div>

                      <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                          <button type="submit" class="btn btn-danger">{{tr('submit')}}</button>
                        </div>
                      </div>

                    </form>
                  </div>
                </div>


              </div>
              <div class="tab-pane fade" id="pills-career" role="tabpanel" aria-labelledby="pills-profile-tab-custom">

                <div class="media">
                  <div class="media-body">
                    <form class="form-horizontal" action="{{route('profile.save')}}" method="POST" enctype="multipart/form-data" role="form">

                      @csrf

                      <input type="hidden" name="user_id" value="{{Auth::guard('web')->user()->id}}">

                      <div class="row">

                          <div class="col-md-6">
                              <div class="form-group row">

                                  <div class="col-sm-9">
                                      
                                      <img src="{{ Auth::guard('web')->user()->picture ?? asset('placeholder.jpg') }}" style="height: 90px; margin-bottom: 15px; border-radius:2em;" id="preview" class="preview">
                                  </div>
                              </div>
                          </div>

                      </div>

                      <div class="form-group">

                          <label for="picture" >{{ tr('picture') }} *</label>

                          <div>

                              <input type="file" name="picture"  onchange="readURL(this);" class="form-control" value="" accept="image/*">
                          </div>
                      </div>

                      <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                          <button type="submit" class="btn btn-danger">{{tr('submit')}}</button>
                        </div>
                      </div>

                    </form>
                  </div>
                </div>

              </div>
              <div class="tab-pane fade" id="pills-music" role="tabpanel" aria-labelledby="pills-contact-tab-custom">
                <div class="media">
                  <div class="media-body">
                    <form class="form-horizontal" action="{{route('profile.change_password')}}" method="POST" enctype="multipart/form-data" role="form">

                      @csrf

                      <input type="hidden" name="user_id" value="{{Auth::guard('web')->user()->id}}">

                      <div class="form-group">
                        <label for="old_password">{{tr('old_password')}} *</label>
                        <input required type="password" class="form-control" name="old_password" id="old_password" placeholder="{{tr('old_password')}}" minlength="6">
                      </div>

                      <div class="form-group">
                        <label for="password">{{tr('new_password')}} *</label>
                        <input required type="password" class="form-control" name="password" id="password" placeholder="{{tr('new_password')}}" minlength="6">
                      </div>

                      <div class="form-group">
                        <label for="password_confirmation" control-label">{{tr('confirm_password')}} *</label>
                        <input required type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="{{tr('confirm_password')}}" minlength="6">
                      </div>

                      <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                          <button type="submit" class="btn btn-danger">{{tr('submit')}}</button>
                        </div>
                      </div>

                    </form>
                  </div>
                </div>
              </div>
              <div class="tab-pane fade" id="pills-vibes" role="tabpanel" aria-labelledby="pills-vibes-tab-custom">

                <div class="media">
                  <div class="media-body">
                    <form class="form-horizontal" action="{{route('profile.delete')}}" method="POST" enctype="multipart/form-data" role="form">

                      @csrf

                      <input type="hidden" name="user_id" value="{{Auth::guard('web')->user()->id}}">

                      <div class="form-group">
                        <label for="password">{{tr('enter_password')}} *</label>
                        <input required type="password" class="form-control" name="password" id="password" placeholder="{{tr('password')}}">
                      </div>

                      <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                          <button type="submit" class="btn btn-danger" onclick="return confirm(&quot;{{ tr('delete_account_confirmation')}}&quot;)">{{tr('submit')}}</button>
                        </div>
                      </div>

                    </form>
                  </div>
                </div>

              </div>

            </div>

          </div>
        </div>
      </div>

    </div>


@endsection
