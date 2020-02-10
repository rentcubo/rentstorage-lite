@extends('layouts.provider')

@section('title', tr('profile'))

@section('content-header', tr('profile'))


@section('content')


    <div class="row">

        <div class="col-md-5 grid-margin grid-margin stretch-card ">

            <div class="card col-md-4">

                <div class="card-body">
                    <div class="text-center">
                        <div class="mb-4">
                            <img src="{{ Auth::guard('provider')->user()->picture ?: asset('default-profile.jpg')}}" class="img-lg rounded-circle mb-2" alt="profile image">
                            <h3 class="profile-username text-center">{{Auth::guard('provider')->user()->name}}</h3>
                            <p class="text-muted text-center">{{tr('provider')}}</p>
                        </div>
                    </div>
                    <div class="py-6">
                        <p class="clearfix">
                          <span class="float-left">
                            {{tr('name')}}
                          </span>
                          <span class="float-right text-muted">
                            {{Auth::guard('provider')->user()->name}}
                          </span>
                        </p>
                        <p class="clearfix">
                          <span class="float-left">
                            {{tr('email')}}
                          </span>
                          <span class="float-right text-muted">
                            {{Auth::guard('provider')->user()->email}}
                          </span>
                        </p>
                        <p class="clearfix">
                          <span class="float-left">
                            {{tr('mobile')}}
                          </span>
                          <span class="float-right text-muted">
                            {{Auth::guard('provider')->user()->mobile}}
                          </span>
                        </p>
                        <p class="clearfix">
                          <span class="float-left">
                            {{tr('full_address')}}
                          </span>
                          <span class="float-right text-muted">
                            {{Auth::guard('provider')->user()->full_address}}
                          </span>
                        </p>
                        <p class="clearfix">
                          <span class="float-left">
                            {{tr('description')}}
                          </span>
                          <span class="float-right text-muted">
                            {{Auth::guard('provider')->user()->description}}
                          </span>
                        </p>
                      </div>
                   
                    </div>
                 <br><hr>
                <div class="card-body">
                  <h4 class="card-title"><b>{{ tr('delete_account') }}</b></h4>
                  <form class="form-horizontal" action="{{route('provider.profile.delete')}}" method="POST" enctype="multipart/form-data" role="form">

                    @csrf

                    <input type="hidden" name="provider_id" value="{{Auth::guard('provider')->user()->id}}">

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

        <div class="col-md-7 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <h4 class="card-title">{{tr('account_details')}}</h4>
              <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                  <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home-1" role="tab" aria-controls="home-1" aria-selected="true">{{tr('update_profile')}}</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile-1" role="tab" aria-controls="profile-1" aria-selected="false">{{tr('upload_image')}}</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact-1" role="tab" aria-controls="contact-1" aria-selected="false">{{tr('change_password')}}</a>
                </li>
              </ul>
              <div class="tab-content">
                <div class="tab-pane fade active show" id="home-1" role="tabpanel" aria-labelledby="home-tab">
                  <div class="media">
                    <div class="media-body">

                            <form class="form-horizontal" action="{{route('provider.profile.save')}}" method="POST" enctype="multipart/form-data" role="form">

                            @csrf

                            <input type="hidden" name="provider_id" value="{{Auth::guard('provider')->user()->id}}">

                            <div class="form-group">
                                <label for="name">{{tr('name')}} *</label>

                                  <input type="text" class="form-control" id="name"  name="name" value="{{Auth::guard('provider')->user()->name}}" placeholder="{{tr('name')}}" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="email" >{{tr('email')}} *</label>

                                  <input type="email" required value="{{Auth::guard('provider')->user()->email}}" name="email" class="form-control" id="email" placeholder="{{tr('email')}}">
                            </div>


                            <div class="form-group">
                                <label for="mobile" >{{tr('mobile')}} *</label>

                                  <input type="number" required value="{{Auth::guard('provider')->user()->mobile}}" minlength="4" maxlength="16" name="mobile" class="form-control" id="mobile" placeholder="{{tr('mobile')}}">
                            </div>

                            <div class="form-group">
                                <label for="full_address">{{tr('full_address')}} *</label>

                                  <input type="text" required value="{{Auth::guard('provider')->user()->full_address}}" minlength="10" name="full_address" class="form-control" id="full_address" placeholder="{{tr('full_address')}}">
                            </div>
                            <div class="form-group">
                                <label for="description">{{tr('description')}} *</label>

                                  <input type="text" required value="{{Auth::guard('provider')->user()->description}}" minlength="5" name="description" class="form-control" id="description" placeholder="{{tr('description')}}">
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
                <div class="tab-pane fade" id="profile-1" role="tabpanel" aria-labelledby="profile-tab">
                  <div class="media">
                    <div class="media-body">
                          <form class="form-horizontal" action="{{route('provider.profile.save')}}" method="POST" enctype="multipart/form-data" role="form">

                          @csrf

                          <input type="hidden" name="provider_id" value="{{Auth::guard('provider')->user()->id}}">

                          <div class="row">

                              <div class="col-md-6">
                                  <div class="form-group row">

                                      <div class="col-sm-9">
                                          
                                          <img src="{{ Auth::guard('provider')->user()->picture ?? asset('placeholder.jpg') }}" style="height: 90px; margin-bottom: 15px; border-radius:2em;" id="preview" class="preview">
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
                <div class="tab-pane fade" id="contact-1" role="tabpanel" aria-labelledby="contact-tab">
                    <div class="media">
                        <div class="media-body">

                            <form class="form-horizontal" action="{{route('provider.change_password')}}" method="POST" enctype="multipart/form-data" role="form">

                            @csrf

                              <input type="hidden" name="provider_id" value="{{Auth::guard('provider')->user()->id}}">

                              <div class="form-group">
                                  <label for="old_password">{{tr('old_password')}} *</label>
                                    <input required type="password" class="form-control" name="old_password" minlength="6" id="old_password" placeholder="{{tr('old_password')}}">
                              </div>

                              <div class="form-group">
                                  <label for="password">{{tr('new_password')}} *</label>
                                    <input required type="password" class="form-control" name="password" minlength="6" id="password" placeholder="{{tr('new_password')}}">
                              </div>

                              <div class="form-group">
                                  <label for="password_confirmation" control-label">{{tr('confirm_password')}} *</label>
                                    <input required type="password" minlength="6" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="{{tr('confirm_password')}}">
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
              </div>
            </div>
          </div>
        </div>

    </div>

@endsection
