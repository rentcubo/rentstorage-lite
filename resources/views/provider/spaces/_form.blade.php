@extends('layouts.provider')


@section('content')

<div class="card">
    <div class="card-body">
        <a href="{{route('provider.spaces.index')}}" class="btn btn-primary float-right"><b>{{tr('view_spaces')}}</b></a><br>

        <h3 class="card-title"><b>
            @if($space_details->id) 
                {{ tr('edit_space') }} 
            @else
                {{ tr('add_space') }}
            @endif
        </b></h3>
        <form class="form-horizontal" action="{{route('provider.spaces.save')}}" method="POST" enctype="multipart/form-data" role="form">

            @csrf

            <div class="form-group">    
                <input type="hidden" name="space_id" class="form-control" @if($space_details->id) value="{{ $space_details->id }}" @endif >
            </div>

            <fieldset>
                <div class="form-group">
                    <label for="name">{{tr('name')}} *</label>
                    <input id="name" class="form-control" name="name" type="text" required="" @if($space_details) value="{{ old('name') ?? $space_details->name  }}" @else value="{{ old('name') }}" @endif placeholder="{{tr('name')}}">
                </div>
                <div class="form-group">
                    <label for="tagline">{{tr('tagline')}} *</label>
                    <input id="tagline" class="form-control" name="tagline" type="text" minlength="5" required="" @if($space_details) value="{{ old('tagline') ?? $space_details->tagline  }}" @else value="{{ old('tagline') }}" @endif placeholder="{{tr('tagline')}}">
                </div>
                <div class="form-group">
                  <label>{{tr('space_type')}} *</label>
                  <select class="js-example-basic-single w-100"  name="space_type" id="space_type" required >
                    <option value="@if($space_details) {{$space_details->space_type}} @else '' @endif "> 
                        @if($space_details) {{ $space_details->space_type }} @else {{ tr('space_type')}} @endif
                    </option>
                    <option value="{{ tr('private_space') }}">{{ tr('private_space') }}</option>
                    <option value="{{ tr('shared_space') }}">{{ tr('shared_space') }}</option>
                  </select>
                </div>
                <div class="form-group">
                    <label for="per_hour">{{tr('pay_per_hour')}} *</label>
                    <input type="number" id="per_hour" name="per_hour" step="any" class="form-control" step="any" min="1" placeholder="{{tr('pay_per_hour')}}" @if($space_details) value="{{ old('per_hour') ?? $space_details->per_hour  }}" @else value="{{ old('per_hour') }}" @endif required="">
                </div>
                <div class="form-group">
                    <label for="description">{{tr('description')}} *</label>
                    <input id="description" class="form-control" name="description" type="text" minlength="5" @if($space_details) value="{{ old('description') ?? $space_details->description  }}" @else value="{{ old('description') }}" @endif placeholder="{{tr('description')}}" required="">
                </div>
                <div class="form-group">
                    <label for="full_address">{{tr('full_address')}} *</label>
                    <input id="full_address" class="form-control" name="full_address" type="text" minlength="10" @if($space_details) value="{{ old('full_address') ?? $space_details->full_address  }}" @else value="{{ old('full_address') }}" @endif placeholder="{{tr('full_address')}}" required="">
                </div>
                <div class="form-group">
                    <label for="instructions">{{tr('instructions')}} *</label>
                    <input id="instructions" class="form-control" name="instructions" type="text" minlength="10" @if($space_details) value="{{ old('instructions') ?? $space_details->instructions  }}" @else value="{{ old('instructions') }}" @endif placeholder="{{tr('instructions')}}" required="">
                </div>
                <div class="form-group">

                    <label for="picture" >{{ tr('picture') }}</label>

                    <div>

                        <input type="file" name="picture"  onchange="readURL(this);" class="form-control" value="" accept="image/*">
                    </div>
                </div>
                <div class="row">

                    <div class="col-md-6">
                        <div class="form-group row">

                            <div class="col-sm-9">
                                
                                <img src="{{ $space_details->picture ?? asset('space-placeholder.jpg') }}" width="50%" id="preview" class="preview">
                            </div>
                        </div>
                    </div>

                </div>
                
                <input class="btn btn-primary float-right" type="submit" value="{{tr('submit')}}">
                <input class="btn btn-danger" type="reset" value="{{tr('cancel')}}">
            </fieldset>
        </form>
    </div>
</div>
@endsection
