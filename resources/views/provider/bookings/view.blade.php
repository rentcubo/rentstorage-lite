@extends('layouts.provider') 

@section('content')

    <div class="content-wrapper">
        
        <div class="row">
            <div class="col-md-5 grid-margin grid-margin-md-0 stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex flex-row flex-wrap">
                            <img src="{{$booking_details->users->picture}}" class="img-lg rounded" alt="profile image">
                            <div class="ml-3">
                                <h6>{{tr('user')}}</h6>
                                <a href="#" class="text-muted">{{$booking_details->users->name}}</a>
                            </div>
                        </div>
                        <br>
                        <hr>
                        <div class="d-flex flex-row flex-wrap">
                            <img src="{{$booking_details->spaces->picture}}" class="img-lg rounded" alt="profile image">
                            <div class="ml-3">
                                <h6>{{tr('space')}}</h6>
                                <a href="{{route('provider.spaces.view',['space_id'=>$booking_details->space_id])}}" class="text-muted">{{$booking_details->spaces->name}}</a>
                                <p class="text-muted"> {{tr('address')}} : {{$booking_details->spaces->full_address}}</p>
                            </div>
                        </div>
                        <br>
                        <hr>
                        <div class="d-flex flex-row flex-wrap">
                            <img src="{{$booking_details->spaces->providers->picture}}" class="img-lg rounded" alt="profile image">
                            <div class="ml-3">
                                <h6>{{tr('provider')}}</h6>
                                <a href="{{route('provider.profile',['provider_id'=>$booking_details->provider_id])}}" class="text-muted">{{$booking_details->spaces->providers->name}}</a>
                            </div>
                        </div>
                    </div>
                    @if($booking_details->status == COMPLETED)
                      @if(!$booking_details->bookingProviderReviews)
                      <br>
                        <div class="card-body">
                        <h6 class="card-title"><b>{{ tr('review_here') }}</b></h6>
                          <form action="{{ route('provider.bookings.review', ['booking_id'=>$booking_details->id]) }}" method="post">       
                            @csrf

                            <input type="hidden" name="booking_id" class="form-control" value="{{ $booking_details->id }}" >

                            <div class="form-group">
                              <label>{{ tr('rating') }} *</label>
                              <select id="example-fontawesome" name="ratings" autocomplete="off">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                              </select>


                              <div class="form-group">
                                <br>
                                <label>{{ tr('review') }} *</label>
                                <input type="text" name="review" class="form-control "  placeholder="{{ tr('review') }}" required="">

                              </div>

                            </div>

                            <input type="submit" name="submit" class="btn btn-success" value="{{ tr('submit') }}">


                          </form>
                        </div>
                      
                      @else
                      <div class="card">
                        <div class="card-body">
                            <h6 class="card-title"><b>{{ tr('review_thanks') }}</b></h6>
                          <p class="clearfix">
                              <span class="float-left">
                                  {{ tr('review') }}
                              </span>
                              <span class="float-right text-muted">
                                  @if($booking_details->bookingProviderReviews)
                                      {{ $booking_details->bookingProviderReviews->review}}
                                  @endif
                              </span>
                          </p>
                          <br>
                           <p class="clearfix">
                              <span class="float-left">
                                  {{ tr('rating') }}
                              </span>

                              <span class="float-right">
                               <label>
                                 @for ($i = 1; $i <=$booking_details->bookingProviderReviews->ratings ; $i++)

                                     <i class="fa fa-star text-primary" ></i>
                                 @endfor
                                 
                               </label>
                              </span>
                          </p>
                        </div>
                      </div>
                      @endif
                    @endif
                </div>
            </div>
            <div class="col-md-7 grid-margin grid-margin-md-0 stretch-card">
                <div class="card">
                    <div class="card-body">
                        
                        <h4 class="card-title"><strong><i class="mdi mdi-book-outline"></i>&nbsp;{{tr('booking_details') }}</strong></h4>
                        <div class="table-responsive">
                            <table class="table">
                          
                              <tbody>
                                <tr>
                                  <td class="py-1 pl-0">
                                    <div class="d-flex align-items-center">
                                      <div class="ml-3">
                                        {{ tr('status') }}
                                    </div>
                                  </td>
                                  <td>
                                    @if($booking_details->status == CANCELLED)
                                    <span class="badge badge-danger">{{tr('cancelled')}}</span>
                                    @elseif($booking_details->status == COMPLETED)
                                    <span class="badge badge-success">{{tr('completed')}}</span>
                                    @elseif($booking_details->status == BOOKING_INITIATE)
                                    <span class="badge badge-primary">{{tr('initiated')}}</span>
                                    @elseif($booking_details->status == BOOKING_CREATED)
                                    <span class="badge badge-secondary">{{tr('created')}}</span>
                                    @endif
                                  </td>
                                </tr>
                                <tr>
                                  <td class="py-1 pl-0">
                                    <div class="d-flex align-items-center">
                                      <div class="ml-3">
                                        {{ tr('checkin') }}
                                    </div>
                                  </td>
                                  <td>
                                    {{ common_date($booking_details->checkin) ?: tr('not_available') }}
                                  </td>
                                </tr>
                                <tr>
                                  <td class="py-1 pl-0">
                                    <div class="d-flex align-items-center">
                                      <div class="ml-3">
                                        {{ tr('checkout') }}
                                    </div>
                                  </td>
                                  <td>
                                    {{ common_date($booking_details->checkout) ?: tr('not_available') }}
                                  </td>
                                </tr>
                                <tr>
                                  <td class="py-1 pl-0">
                                    <div class="d-flex align-items-center">
                                      <div class="ml-3">
                                        {{ tr('total_time') }}
                                    </div>
                                  </td>
                                  <td>
                                    {{ time_show($booking_details->total_time) ?: tr('not_available')}}
                                  </td>
                                </tr>
                                <tr>
                                  <td class="py-1 pl-0">
                                    <div class="d-flex align-items-center">
                                      <div class="ml-3">
                                        {{ tr('pay_per_hour') }}
                                    </div>
                                  </td>
                                  <td>
                                    {{ formatted_amount($booking_details->per_hour) }}
                                  </td>
                                </tr>
                                <tr>
                                  <td class="py-1 pl-0">
                                    <div class="d-flex align-items-center">
                                      <div class="ml-3">
                                        {{ tr('total') }}
                                    </div>
                                  </td>
                                  <td>
                                    {{ formatted_amount($booking_details->total) }}
                                  </td>
                                </tr>
                                <tr>
                                  <td class="py-1 pl-0">
                                    <div class="d-flex align-items-center">
                                      <div class="ml-3">
                                        {{ tr('payment_mode') }}
                                    </div>
                                  </td>
                                  <td>
                                    {{ $booking_details->payment_mode ?: tr('not_available')}}
                                  </td>
                                </tr>
                                <tr>
                                  <td class="py-1 pl-0">
                                    <div class="d-flex align-items-center">
                                      <div class="ml-3">
                                        {{ tr('description') }}
                                    </div>
                                  </td>
                                  <td>
                                    {{ $booking_details->description }}
                                  </td>
                                </tr>
                                <tr>
                                  <td class="py-1 pl-0">
                                    <div class="d-flex align-items-center">
                                      <div class="ml-3">
                                        {{ tr('created_at') }}
                                    </div>
                                  </td>
                                  <td>
                                    {{ common_date($booking_details->created_at) ?: tr('not_available') }}
                                  </td>
                                </tr>
                                <tr>
                                  <td class="py-1 pl-0">
                                    <div class="d-flex align-items-center">
                                      <div class="ml-3">
                                        {{ tr('updated_at') }}
                                    </div>
                                  </td>
                                  <td>
                                    {{ common_date($booking_details->updated_at) ?: tr('not_available') }}
                                  </td>
                                </tr> 
                              </tbody>
                            </table>
                            <br>
                             <div class="d-flex justify-content-between">
                            

                                @if($booking_details->status == BOOKING_INITIATE)
                            
                                    <a href="{{ route('provider.bookings.status', ['booking_id' => $booking_details->id]) }}" onclick="return confirm(&quot;{{ tr('booking_cancel_confirmation')}}&quot;)" title="{{tr('booking_cancel')}}" class="btn btn-danger">{{ tr('cancel') }}</a>

                                @endif
                            </div>

                          </div>
                    </div>
                </div>
            </div>
        </div>
        <br>
        @if($booking_payment_details)
        <div class="row">
          <div class="col-md-12 grid-margin grid-margin-md-0 stretch-card">
            <div class="card">
              <div class="card-body">
                <div class="card-title">

                <h5><strong><i class="mdi mdi-credit-card"></i>&nbsp;{{tr('payment_details') }}</strong>
              </h5>
                  <br>
                  <p class="float-right">{{tr('payment_mode')}} : 
                    @if($booking_payment_details->payment_mode == COD)

                    <span class="badge badge-primary">{{tr('cod')}}</span>
                    @else
                    <span class="badge badge-secondary">{{tr('card')}}</span>
                    @endif
                  </p> 
                  <p>{{tr('status')}} : 
                    @if($booking_payment_details->status== PAID)
                       <span class="badge badge-success">{{tr('paid')}}</span>
                    @else
                      <span class="badge badge-danger">{{tr('pending')}}</span>
                    @endif
                </p>

                <p>{{tr('paid_date')}} : {{common_date($booking_payment_details->paid_date) ?: tr('not_available') }}</p>

                </div>
                <br>
               
                <div class="row">
                    <div class="col-md-3 grid-margin stretch-card">
                      <div class="d-flex flex-row flex-wrap ">
                          <div class="ml-3">
                              <h6>{{tr('total_amount')}}</h6>
                              <a href="#" class="text-muted">{{formatted_amount($booking_payment_details->total)}}</a>
                          </div>
                      </div>
                      
                    </div>

                    <div class="col-md-3 grid-margin stretch-card">
                      
                      <div class="d-flex flex-row flex-wrap">
                          <div class="ml-3">
                              <h6>{{tr('paid_amount')}}</h6>
                              <a href="#" class="text-muted">{{formatted_amount($booking_payment_details->paid_amount)}}</a>
                          </div>
                      </div>
                      
                    </div>

                    <div class="col-md-3 grid-margin stretch-card">
                      <div class="d-flex flex-row flex-wrap">
                          <div class="ml-3">
                              <h6>{{tr('admin_amount')}}</h6>
                              <a href="#" class="text-muted">{{formatted_amount($booking_payment_details->admin_amount)}}</a>
                          </div>
                      </div>
                    </div>
                     <div class="col-md-3 grid-margin stretch-card">
                      <div class="d-flex flex-row flex-wrap">
                          <div class="ml-3">
                              <h6>{{tr('provider_amount')}}</h6>
                              <a href="#" class="text-muted">{{formatted_amount($booking_payment_details->provider_amount)}}</a>
                          </div>
                      </div>
                    </div>

                  </div>
                  
              </div>
            </div>            
          </div>
        </div>
        @endif
    </div>
    
@endsection