@extends('layouts.provider')


@section('content')

<div class="card">
  <div class="card-body">
    <h4 class="card-title"><b>{{tr('bookings')}}</b></h4>
    <div class="row">
      <div class="col-12">
        <div class="table-responsive">
          <table id="order-listing" class="table">
            <thead>
              <tr>
                  <th>{{tr('sno')}}</th>
                <th>{{tr('user')}}</th>
                <th>{{tr('space_name')}}</th>
                <th>{{tr('checkin')}}</th>
                <th>{{tr('checkout')}}</th>
                <th>{{tr('status')}}</th>
                <th>{{tr('action')}}</th>
              </tr>
            </thead>
              <tbody>
                @foreach($bookings as $i=>$booking_details)
                <tr>
                  <td>{{$i+1}}</td>

                  <td>
                  	@if($booking_details->users)

                  	<a href="#">{{$booking_details->users->name}}</a>
                  	@else
                  		-
                  	@endif
                  </td>

                  <td>
                  	@if($booking_details->spaces)

                  	<a href="{{route('provider.spaces.view',['space_id'=> $booking_details->space_id])}}">{{$booking_details->spaces->name}}</a>

                  	@else
                  		{{ tr('space_removed') }}
                  	@endif
                  </td>
                 
                  <td>
                
                    {{common_date($booking_details->checkin,'', 'd M y')}}
                    
                  </td>
                  <td>
                
                    {{common_date($booking_details->checkout,'','d M y')}}
                    
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

                      
                        <a href="{{route('provider.bookings.view',['booking_id'=>$booking_details->id])}}" class="dropdown-item"><b><i class="fa fa-eye"></i>&emsp;{{tr('view')}}</b></a>

                        @if($booking_details->status == BOOKING_INITIATE)
                            <div class="dropdown-divider"></div>
                              <a href="{{ route('provider.bookings.status',['booking_id'=>$booking_details->id]) }}" onclick="return confirm(&quot;{{ tr('booking_cancel_confirmation')}}&quot;)" class="dropdown-item"><b><i class="fa fa-close"></i>&emsp;{{ tr('cancel') }}</b></a>
                        @endif
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