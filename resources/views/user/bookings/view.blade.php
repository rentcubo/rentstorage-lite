@extends('layouts.user') 

@section('content')

    <div class="content-wrapper">
        <div class="row">
                
                <div class="col-md-5 stretch-card">

                    <div class="card">
                        
                        <div class="card-body">
                            <h4 class="card-title"><strong>{{ $booking_details->spaces->name }}</strong></h4>
                            <img src="@if($booking_details->spaces){{ $booking_details->spaces->picture }} @else {{ asset('placeholder.jpg') }} @endif" class="card-img-top" alt="image">
                            <br><hr>
                            @if($booking_details->status != CANCELLED)

                              @if($booking_details->status == BOOKING_INITIATE)
                              
                                  <a href="{{ route('bookings.checkin', ['booking_id' => $booking_details->id]) }}" onclick="return confirm(&quot;{{ tr('booking_checkin_confirmation')}}&quot;)" class="btn btn-primary">{{ tr('checkin') }}</a>

                              @elseif($booking_details->status == BOOKING_CREATED)

                              <a href="{{ route('bookings.checkout', ['booking_id' => $booking_details->id]) }}" onclick="return confirm(&quot;{{ tr('booking_checkout_confirmation')}}&quot;)" class="btn btn-primary">{{ tr('checkout') }}</a>

                              @endif

                              @if(!$booking_payment_details)

                                      <a href="{{ route('bookings.payment', ['booking_id' => $booking_details->id]) }}" onclick="return confirm(&quot;{{ tr('booking_payment_confirmation')}}&quot;)" class="btn btn-success float-right">{{ tr('pay') }}</a>
                              @else

                                  <br><hr>

                                  <label class="badge badge-success float-right">{{ tr('paid') }}</label>
                                  <h4 class="card-title"><strong>{{ tr('payment_details') }}</strong></h4>
                                  <div class="table-responsive">
                                  <table class="table">
                                    <tbody>
                                      <tr>
                                        <td class="py-1 pl-0">
                                          <div class="d-flex align-items-center">
                                            <div class="ml-3">
                                              {{ tr('total_time') }}
                                          </div>
                                        </td>
                                        <td>
                                          {{ time_show($booking_payment_details->total_time) ?: tr('not_available')}}
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
                                          {{ formatted_amount($booking_payment_details->per_hour) }}
                                        </td>
                                      </tr>
                                      <tr>
                                        <td class="py-1 pl-0">
                                          <div class="d-flex align-items-center">
                                            <div class="ml-3">
                                              {{ tr('sub_total') }}
                                          </div>
                                        </td>
                                        <td>
                                          {{ formatted_amount($booking_payment_details->sub_total) }}
                                        </td>
                                      </tr>
                                      <tr>
                                        <td class="py-1 pl-0">
                                          <div class="d-flex align-items-center">
                                            <div class="ml-3">
                                              {{ tr('tax_price') }}
                                          </div>
                                        </td>
                                        <td>
                                          {{ formatted_amount($booking_payment_details->tax_price) }}
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
                                          {{ formatted_amount($booking_payment_details->total) }}
                                        </td>
                                      </tr>
                                      <tr>
                                        <td class="py-1 pl-0">
                                          <div class="d-flex align-items-center">
                                            <div class="ml-3">
                                              {{ tr('paid_amount') }}
                                          </div>
                                        </td>
                                        <td>
                                          {{ formatted_amount($booking_payment_details->paid_amount) }}
                                        </td>
                                      </tr>
                                       <tr>
                                        <td class="py-1 pl-0">
                                          <div class="d-flex align-items-center">
                                            <div class="ml-3">
                                              {{ tr('paid_date') }}
                                          </div>
                                        </td>
                                        <td>
                                          {{ common_date($booking_payment_details->paid_date) }}
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
                                          {{ $booking_payment_details->payment_mode ?: tr('not_available')}}
                                        </td>
                                      </tr>
                                  </tbody>
                              </table>
                          </div>


                              @endif

                        @endif
                            
                        </div>
                    </div>
                    
                </div>
                
                <div class="col-md-7 stretch-card">
                    <div class="card">
                        <div class="card-body">

                            <a href="{{route('bookings.index')}}" class="btn btn-primary float-right"><b>{{tr('view_bookings')}}</b></a><br>
                            
                            <h4 class="card-title"><strong><i class="mdi mdi-map-outline"></i>&nbsp;{{tr('booking_details') }}</strong>
                            </h4>
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
                                
                                        <a href="{{ route('bookings.status', ['booking_id' => $booking_details->id]) }}" onclick="return confirm(&quot;{{ tr('booking_cancel_confirmation')}}&quot;)" title="{{tr('booking_cancel')}}" class="btn btn-danger">{{ tr('cancel') }}</a>

                                    @endif
                                
                                </div>

                                @if($booking_details->status == COMPLETED)
                                  @if(!$booking_details->bookingUserReviews)
                                  <hr>
                                    <h6 class="card-title"><b>{{ tr('review_here') }}</b></h6>
                                  <div class="card-body">
                                    <form action="{{ route('bookings.review', ['booking_id'=>$booking_details->id]) }}" method="post">       
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
                                              @if($booking_details->bookingUserReviews)
                                                  {{ $booking_details->bookingUserReviews->review}}
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
                                              @for ($i = 1; $i <=$booking_details->bookingUserReviews->ratings ; $i++)

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
                    </div>
                </div>
        </div>
    </div>
    <!-- content-wrapper ends -->
@endsection