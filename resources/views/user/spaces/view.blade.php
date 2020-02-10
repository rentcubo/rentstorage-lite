@extends('layouts.user') 

@section('content')

<div class="content-wrapper">

    <div class="row">

        <div class="col-md-5 stretch-card">

            <div class="card">

                <div class="card-body">
                    <h4 class="card-title"><strong>{{ $space_details->name }}</strong></h4>
                    <img src="@if($space_details->picture){{ $space_details->picture }} @else {{ asset('placeholder.jpg') }} @endif" class="card-img-top" alt="image">
                </div>
            </div>

        </div>

        <div class="col-md-7 stretch-card">
            <div class="card">
                <div class="card-body">

                    <a href="{{route('spaces.index')}}" class="btn btn-primary float-right"><b>{{tr('view_spaces')}}</b></a><br>

                    <h4 class="card-title"><strong><i class="mdi mdi-map-outline"></i>&nbsp;{{tr('space_details') }}</strong>
                    </h4>
                    <div class="table-responsive">
                        <table class="table">

                            <tbody>

                                <tr>
                                    <td class="py-1 pl-0">
                                        <div class="ml-3">
                                            {{ tr('space_type') }}
                                        </div>
                                    </td>
                                    <td>
                                        {{ $space_details->space_type}}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="py-1 pl-0">
                                        <div class="ml-3">
                                            {{ tr('tagline') }}
                                        </div>
                                    </td>
                                    <td>
                                        {{ $space_details->tagline }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="py-1 pl-0">
                                        <div class="ml-3">
                                            {{ tr('pay_per_hour') }}
                                        </div>
                                    </td>
                                    <td>
                                        {{ formatted_amount($space_details->per_hour) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="py-1 pl-0">
                                        <div class="ml-3">
                                            {{ tr('address') }}
                                        </div>
                                    </td>
                                    <td>
                                        {{ $space_details->full_address }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="py-1 pl-0">
                                        <div class="ml-3">
                                            {{ tr('instructions') }}
                                        </div>
                                    </td>
                                    <td>
                                        {{ $space_details->instructions }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="py-1 pl-0">
                                        <div class="ml-3">
                                            {{ tr('description') }}
                                        </div>
                                    </td>
                                    <td>
                                        {{ $space_details->description }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="py-1 pl-0">
                                        <div class="ml-3">
                                            {{ tr('created_at') }}
                                        </div>
                                    </td>
                                    <td>
                                        {{ common_date($space_details->created_at) ?: tr('not_available') }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="py-1 pl-0">
                                        <div class="ml-3">
                                            {{ tr('updated_at') }}
                                        </div>
                                    </td>
                                    <td>
                                        {{ common_date($space_details->updated_at) ?: tr('not_available') }}
                                    </td>
                                </tr> 
                            </tbody>
                        </table>
                        <br>
                        <div class="d-flex justify-content-between">

                            <a href="#"  data-toggle="modal" data-target="#bookingModal">
                                <button class="btn btn-success">{{ tr('book_now') }}</button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- content-wrapper ends -->

<!-- Booking Modal-->
<div class="modal fade" id="bookingModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ tr('book_space') }}</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <div class="modal-body">
                <form class="form-sample" action="{{ route('bookings.save') }}" method="post" enctype="multipart/form-data">
                    @csrf


                    <input type="hidden" name="space_id" class="form-control " id="space_id"  value="{{$space_details->id}}" />

                    <input type="hidden" name="timezone" class="form-control " id="timezone"  value="" />

                    <div class="col-md-12">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">{{ tr('checkin') }} *</label>
                            <div class="col-sm-9">

                                <div class="input-group date" id="checkin" data-target-input="nearest">
                                    <div class="input-group" data-target="#checkin" data-toggle="datetimepicker">
                                        <input type="datetime" name="checkin" class="form-control datetimepicker-input" data-target="#checkin" autocomplete="off" required />
                                        <div class="input-group-addon input-group-append">
                                            <i class="mdi mdi-clock input-group-text"></i>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">{{ tr('checkout') }} *</label>
                            <div class="col-sm-9">

                                <div class="input-group date" id="checkout" data-target-input="nearest">
                                    <div class="input-group" data-target="#checkout" data-toggle="datetimepicker">
                                        <input type="datetime" name="checkout" class="form-control datetimepicker-input" data-target="#checkout" autocomplete="off" required />
                                        <div class="input-group-addon input-group-append">
                                            <i class="mdi mdi-clock input-group-text"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">{{ tr('description') }} *</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="description" placeholder="{{ tr('description') }}" value="{{ old('description') }}" required />
                            </div>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-secondary" type="reset" data-dismiss="modal">{{ tr('cancel') }}</button>

                            <button class="btn btn-primary float-right" type="submit"> {{ tr('book_now') }}</button>
                        </div>

                    </div>

                </form>
            </div>

        </div>

    </div>

</div>
<script type="text/javascript">

    timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;

    document.getElementById('timezone').value = timezone;

</script>

@endsection

