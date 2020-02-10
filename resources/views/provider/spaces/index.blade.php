@extends('layouts.provider')


@section('content')

<div class="card">
  <div class="card-body">
    <a href="{{route('provider.spaces.create')}}" class="btn btn-primary float-right"><b>{{tr('add_space')}}</b></a><br>
    <h4 class="card-title"><b>{{tr('spaces')}}</b></h4>
    <div class="row">
      <div class="col-12">
        <div class="table-responsive">
          <table id="order-listing" class="table">
            <thead>
              <tr>
                  <th>{{tr('sno')}}</th>
                <th>{{tr('name')}}</th>
                <th>{{tr('tagline')}}</th>
                <th>{{tr('space_type')}}</th>
                <th>{{tr('pay_per_hour')}}</th>
                <th>{{tr('updated_at')}}</th>
                <th>{{tr('admin_status')}}</th>
                <th>{{tr('status')}}</th>
                <th>{{tr('action')}}</th>
              </tr>
            </thead>
              <tbody>
                @foreach($spaces as $i=>$space_details)
                <tr>

                  
                  <td>{{$i+1}}</td>

                  <td><a href="{{route('provider.spaces.view',['space_id'=> $space_details->id])}}">{{$space_details->name}}</a></td>
                  <td>{{$space_details->tagline}}</td>
                  <td>
                    {{$space_details->space_type}}
                  </td>
                  <td>
                    {{formatted_amount($space_details->per_hour)}}
                  </td>
                  <td>
                
                    {{common_date($space_details->updated_at,'','d M y')}}
                    
                  </td>
                  <td>
                    @if($space_details->admin_status ==DECLINED)
                    <span class="badge badge-danger">{{tr('declined')}}</span>
                    @else
                    <span class="badge badge-success">{{tr('approved')}}</span>
                    @endif
                  </td>
                  <td>
                    @if($space_details->status ==UNPUBLISH)
                    <span class="badge badge-danger">{{tr('un-published')}}</span>
                    @else
                    <span class="badge badge-success">{{tr('published')}}</span>
                    @endif
                  </td>
                  <td>

                    <div class="dropdown">
                      <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuSizeButton3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{ tr('action') }}
                      </button>
                      <div class="dropdown-menu" aria-labelledby="dropdownMenuSizeButton3" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 32px, 0px);">
                        <a href="{{route('provider.spaces.edit',['space_id'=>$space_details->id])}}" class="dropdown-item"><b><i class="fa fa-edit"></i>&emsp;{{tr('edit')}}</b></a>
                        <div class="dropdown-divider"></div>
                        <a href="{{route('provider.spaces.view',['space_id'=>$space_details->id])}}" class="dropdown-item"><b><i class="fa fa-eye"></i>&emsp;{{tr('view')}}</b></a>
                        <div class="dropdown-divider"></div>

                        @if($space_details->status == PUBLISHED)

                        <a href="{{route('provider.spaces.status',['space_id'=>$space_details->id])}}" class="dropdown-item" onclick="return confirm(&quot;{{ tr('space_unpublish_confirmation')}}&quot;)"><b><i class="fa fa-close"></i>&nbsp;{{tr('un-publish')}}</b></a>
                        @else

                        <a href="{{route('provider.spaces.status',['space_id'=>$space_details->id])}}" class="dropdown-item"><b><i class="fa fa-check"></i>&emsp;{{tr('publish')}}</b></a>
                        @endif

                        <div class="dropdown-divider"></div>

                          <a class="dropdown-item" href="{{route('provider.spaces.delete',['space_id'=>$space_details->id])}}" onclick="return confirm(&quot;{{ tr('space_delete_confirmation')}}&quot;)"><b><i class="fa fa-trash"></i>&emsp;{{tr('delete')}}</b></a>
                      </div>
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