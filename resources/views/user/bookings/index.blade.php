@extends('layouts.user')

@section('content')

<div class="card">
  <div class="card-body">
    <a href="{{route('spaces.index')}}" class="btn btn-primary float-right"><b>{{tr('book_space')}}</b></a><br>
    <h4 class="card-title"><b>{{tr('bookings')}}</b></h4>
    <div class="row">
      <div class="col-12">
        <div class="table-responsive">
          <table id="order-listing" class="table">
            <thead>
              <tr>
                <th>{{tr('sno')}}</th>
                <th>{{tr('space_name')}}</th>
                <th>{{tr('checkin')}}</th>
                <th>{{tr('checkout')}}</th>
                <th>{{tr('payment')}}</th>
                <th>{{tr('status')}}</th>
                <th>{{tr('action')}}</th>
              </tr>
            </thead>
              <tbody>
                @foreach($bookings as $i=>$booking_details)
                <tr>
                  <td>{{$i+1}}</td>

                  <td>
                    
                    <a href="{{ route('spaces.view', ['space_id' => $booking_details->space_id]) }}">{{ $booking_details->spaces->name }}</a>
                   
                  </td>
                 
                  <td>
                
                    {{common_date($booking_details->checkin,'','d M y')}}
                    
                  </td>
                  <td>
                
                    {{common_date($booking_details->checkout,'','d M y')}}
                    
                  </td>
                  <td>
                
                    @if($booking_details->booking_payments)

                    <span class="badge badge-success" title="{{tr('payment_paid')}}">{{tr('paid')}}</span>

                    @else
                    <span class="badge badge-danger" title="{{tr('payment_pending')}}">{{tr('pending')}}</span>
                    
                    @endif
                    
                  </td>

                  <td>
                    @if($booking_details->status == CANCELLED)
                    <span class="badge badge-danger" title="{{tr('booking_cancelled')}}">{{tr('cancelled')}}</span>
                    @elseif($booking_details->status == COMPLETED)
                    <span class="badge badge-success" title="{{tr('booking_completed')}}">{{tr('completed')}}</span>
                    @elseif($booking_details->status == BOOKING_INITIATE)
                    <span class="badge badge-primary" title="{{tr('booking_initiated')}}">{{tr('initiated')}}</span>
                    @elseif($booking_details->status == BOOKING_CREATED)
                    <span class="badge badge-secondary" title="{{tr('booking_created')}}">{{tr('created')}}</span>
                    @endif
                  </td>
                  <td>

                    <div class="dropdown">
                      <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuSizeButton3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{ tr('action') }}
                      </button>
                      <div class="dropdown-menu" aria-labelledby="dropdownMenuSizeButton3" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 32px, 0px);">

                        
                        <li> <a href="{{ route('bookings.view', ['booking_id' => $booking_details->id]) }}" class="dropdown-item"><b><i class="fa fa-eye"></i>&emsp;{{ tr('view') }}</b></a></li>
                        <li>
                            @if($booking_details->status == BOOKING_INITIATE)
                                <div class="dropdown-divider"></div>
                                  <a href="{{ route('bookings.status',['booking_id'=>$booking_details->id]) }}" onclick="return confirm(&quot;{{ tr('booking_cancel_confirmation')}}&quot;)" class="dropdown-item"><b><i class="fa fa-close"></i>&emsp;{{ tr('cancel') }}</b></a>
                            @endif
                        </li>
                        
                    </div>
                  </td>
                </tr>
                @endforeach
              </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection
