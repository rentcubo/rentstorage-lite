@extends('layouts.provider')

@section('content')

        <div class="content-wrapper">
          <div class="row">
            <div class="col-lg-8 grid-margin d-flex flex-column">
              <div class="row">
                <div class="col-md-4 grid-margin stretch-card">
                  <div class="card">
                    <div class="card-body text-center">
                      <div class="text-primary mb-4">
                        <a class="text-primary" href="{{route('provider.spaces.index')}}">
                        <i class="mdi mdi-map-marker mdi-36px"></i>
                        <p class="font-weight-medium mt-2">{{tr('total_spaces')}}</p>
                        </a>
                      </div>
                      <h1 class="font-weight-light">{{$data['total_spaces'] }}</h1>
                      
                    </div>
                  </div>
                </div>
                <div class="col-md-4 grid-margin stretch-card">
                  <div class="card">
                    <div class="card-body text-center">
                      <div class="text-danger mb-4">
                        <a href="{{route('provider.bookings.index')}}">
                        <i class="mdi mdi-bookmark mdi-36px"></i>
                        <p class="font-weight-medium mt-2">{{tr('total_bookings')}}</p>
                        </a>
                      </div>
                      <h1 class="font-weight-light">{{$data['total_bookings']}}</h1>
                    </div>
                  </div>
                </div>
                <div class="col-md-4 grid-margin stretch-card">
                  <div class="card">
                    <div class="card-body text-center">
                      <div class="text-info mb-4">
                        <i class="mdi mdi-credit-card mdi-36px"></i>
                        <p class="font-weight-medium mt-2">{{tr('total_payments')}}</p>
                      </div>
                      <h1 class="font-weight-light">{{formatted_amount($booking_payments->sum('total'))}}</h1>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row flex-grow-1">
                <div class="col-lg-6 grid-margin grid-margin-lg-0 stretch-card">
                  <div class="card">
                    <div class="card-body">
                      <h4 class="card-title">{{tr('space_statistics')}}</h4>
                      <div id="space-chart"></div>
                    </div>
                  </div>
                </div>
                <div class="col-lg-6 grid-margin grid-margin-lg-0 stretch-card">
                  <div class="card">
                    <div class="card-body">
                      <h4 class="card-title">{{tr('booking_statistics')}}</h4>
                      <div id="booking-chart"></div>
                    </div>
                  </div>
                </div>
               
              </div>
            </div>
            <div class="col-lg-4 grid-margin stretch-card">
              <div class="card d-flex flex-column justify-content-between">
                <div class="card-body">
                  <div class="d-flex justify-content-between align-items-start">
                    <h4 class="text-primary"><strong>{{tr('revenue')}}</strong></h4>
                  <i class="mdi mdi-cash mdi-36px"></i>
                  </div>
                  <h4 class="font-weight-light">{{tr('total_revenue')}}</h4>
                  <h1 class="font-weight-normal mb-0">{{formatted_amount($booking_payments->sum('paid_amount'))}}</h1>
                  <div class="d-md-flex justify-content-start mt-5">
                    <div class="mb-3 mb-lg-0">
                      <h4 class="font-w3eight-light text-primary">{{formatted_amount($booking_payments->sum('total'))}}</h4>
                      <p class="text-primary mb-0">{{tr('total_amount')}}</p>
                    </div>
                  </div>
                  <div class="d-md-flex justify-content-start mt-5">
                    <div class="mb-3 mb-lg-0">
                      <h4 class="font-weight-light text-danger">{{formatted_amount($booking_payments->sum('admin_amount'))}}</h4>
                      <p class="text-danger mb-0">{{tr('admin_amount')}}</p>
                    </div>
                  </div>
                  <div class="d-md-flex justify-content-start mt-5">
                    <div class="mb-3 mb-lg-0">
                      <h4 class="font-weight-light text-info">{{formatted_amount($booking_payments->sum('provider_amount'))}}</h4>
                      <p class="text-info mb-0">{{tr('provider_amount')}}</p>
                    </div>
                  </div>
                </div>
                <div class="card-body px-0 pb-0 d-flex flex-column justify-content-between">
                  <canvas id="statistics-chart" class="mt-auto"></canvas>
                </div>
              </div>
            </div>
          </div>
        </div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="{{ asset('provider-assets/vendors/raphael/raphael.min.js')}}"></script>
<script src="{{ asset('provider-assets/vendors/morris.js/morris.min.js')}}"></script>

        <script>
  
          Morris.Donut({
            element: 'space-chart',
            colors: ['#76C1FA', '#F36368', '#63CF72', '#FABA66'],
            data: [{
                label: "{{ tr('total_spaces') }}",
                value: {{ $data['total_spaces'] }}
              },
              {
                label: "{{ tr('declined_spaces') }}",
                value: {{ $data['declined_spaces'] }}
              },
              {
                label: "{{ tr('approved_spaces') }}",
                value: {{ $data['approved_spaces'] }}
              }
            ]
          });

          Morris.Donut({
            element: 'booking-chart',
            colors: ['#76C1FA', '#F36368', '#63CF72', '#FABA66'],
            data: [{
                label: "{{ tr('total_bookings') }}",
                value: {{ $data['total_bookings'] }}
              },
              {
                label: "{{ tr('cancelled_bookings') }}",
                value: {{ $data['cancelled_bookings'] }}
              },
              {
                label: "{{ tr('completed_bookings') }}",
                value: {{ $data['completed_bookings'] }}
              }
            ]
          });

      </script>
      <style>
        #morris-donut{

          min-height: 100px;
      }
      </style>

@endsection