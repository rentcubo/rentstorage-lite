@extends('layouts.admin') 

@section('title', tr('view_providers')) 


@section('breadcrumb')

<li class="breadcrumb-item"><i class="fa fa-dashboard"></i><a href="{{ route('admin.dashboard') }}">&nbsp{{tr('home')}}</a></li>

<li class="breadcrumb-item"><i class="fa fa-users"></i><a href="{{route('admin.providers_index')}}">&nbsp{{tr('providers')}}</a>
</li>
<li class="breadcrumb-item active" aria-current="page">
    <i class="fa fa-user"></i>
    <span>&nbsp{{tr('view_providers')}}</span>
</li>

@endsection 

@section('content')

<section class="content">

    @include('notifications.notification')

    <div class="row">
        
        <div class="col-lg-12 grid-margin stretch-card">
        
            <div class="box box-primary">

                <div class="box-header bg-card-header">
                    <h4>{{tr('provider_details')}}</h4>
                </div>

                <div class="box-body">

                    <div class="row">

                        <div class="col-md-6">

                            <!-- Card group -->
                            <div class="card-group">

                                <!-- Card -->
                                <div class="card mb-4">

                                    <!-- Card image -->
                                    <div class="view overlay">

                                        <img class="image" src="{{$provider_details->picture ?: asset('placeholder.jpg')}}">
                                        <a href="#!">
                                            <div class="mask rgba-white-slight"></div>
                                        </a>
                                    </div>

                                    <div class="card-body">

                                        <hr>

                                        <div class="row">
                                            @if($provider_details->description)
                                            <h5 class="col-md-12">{{tr('description')}}</h5>

                                            <p class="col-md-12 text-muted">{{$provider_details->description}}</p>
                                            @endif
                                        </div>

                                    </div>

                                </div>
                                <!-- Card -->

                                <!-- Card -->

                                <!-- Card -->

                                <!-- Card -->

                            </div>
                            <!-- Card group -->

                        </div>
                        <div class="col-md-6">
                            <!-- Card -->
                            <div class="card mb-8">

                                <!-- Card content -->
                                <div class="card-body">

                                    <div class="template-demo">

                                        <table class="table mb-0">

                                            <thead>

                                            </thead>

                                            <tbody>

                                                <tr>
                                                    <td class="pl-0"><b>{{ tr('name') }}</b></td>
                                                    <td class="pr-0 text-right">
                                                        <div>{{$provider_details->name}}</div>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td class="pl-0"><b>{{ tr('email') }}</b></td>
                                                    <td class="pr-0 text-right">
                                                        <div>{{$provider_details->email}}</div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="pl-0"><b>{{ tr('mobile') }} </b></td>
                                                    <td class="pr-0 text-right">
                                                        <div>{{ $provider_details->mobile }}</div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="pl-0"><b>{{ tr('login_by') }}</b></td>
                                                    <td class="pr-0 text-right">
                                                        <div>{{ $provider_details->login_by }}</div>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td class="pl-0"><b>{{ tr('register_type') }} </b></td>
                                                    <td class="pr-0 text-right">
                                                        <div>{{ $provider_details->register_type }}</div>
                                                    </td>
                                                </tr>

                                                <tr>

                                                    <td class="pl-0"> <b>{{ tr('status') }}</b></td>

                                                    <td class="pr-0 text-right">

                                                        @if($provider_details->status == PROVIDER_PENDING)

                                                        <span class="card-text btn-sm btn-danger text-uppercase">{{tr('pending')}}</span> @elseif($provider_details->status == PROVIDER_APPROVED)

                                                        <span class="card-text btn-sm btn-success text-uppercase">{{tr('approved')}}</span> @else

                                                        <span class="card-text btn-sm btn-danger text-uppercase">{{tr('declined')}}</span> @endif

                                                    </td>

                                                </tr>
                                                <tr>
                                                    <td class="pl-0"> <b>{{ tr('created_at') }}</b></td>
                                                    <td class="pr-0 text-right">
                                                        <div>{{ common_date($provider_details->created_at) }}</div>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td class="pl-0"> <b>{{ tr('updated_at') }}</b></td>
                                                    <td class="pr-0 text-right">
                                                        <div>{{ common_date($provider_details->updated_at) }}</div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <a class="btn btn-primary" href="{{ route('admin.providers_edit', ['provider_id' => $provider_details->id])}}">{{tr('edit')}}</a>

                                                        <a class="btn btn-danger" href="{{route('admin.providers_delete', ['provider_id' => $provider_details->id])}}" onclick="return confirm(&quot;{{tr('provider_delete_confirmation' , $provider_details->name)}}&quot;);">{{tr('delete')}}</a> 
                                                        @if($provider_details->status == PROVIDER_APPROVED)

                                                            <a class="btn btn-danger" href="{{ route('admin.providers_status', ['provider_id' => $provider_details->id]) }}" onclick="return confirm(&quot;{{$provider_details->first_name}} - {{tr('provider_decline_confirmation')}}&quot;);">
                                                                {{ tr('decline') }} 
                                                            </a> 
                                                        @else

                                                            <a class="btn btn-success" href="{{ route('admin.providers_status', ['provider_id' => $provider_details->id]) }}">
                                                                {{ tr('approve') }} 
                                                            </a> 
                                                        @endif
                                                    </td>
                                                </tr>

                                            </tbody>

                                        </table>

                                    </div>
                                    <!-- </div> -->

                                </div>
                                <!-- Card content -->

                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>
    </div>
</section>
@endsection