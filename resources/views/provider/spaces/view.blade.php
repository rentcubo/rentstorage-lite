@extends('layouts.provider')

@section('content')


	<div class="row">
			
			<div class="col-md-5 stretch-card">

				<div class="card">
					
					<div class="card-body">
						<img src="@if($space_details->picture){{ $space_details->picture }} @else {{ asset('placeholder.jpg') }} @endif" class="card-img-top" alt="image">
					</div>
				</div>
				
			</div>
			
			<div class="col-md-7 stretch-card">
			    <div class="card">
			        <div class="card-body">

			        	<a href="{{route('provider.spaces.index')}}" class="btn btn-primary float-right"><b>{{tr('view_spaces')}}</b></a><br>
			            
			            <h4 class="card-title"><strong><i class="mdi mdi-map-outline"></i>&nbsp;{{tr('space_details') }}</strong>
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
			                        @if($space_details->status == PUBLISHED)
			                        <span class="badge badge-success">{{tr('published')}}</span>
			                        @else
			                        <span class="badge badge-danger">{{tr('un-published')}}</span>
			                        @endif
			                      </td>
			                    </tr>
			                    <tr>
			                      <td class="py-1 pl-0">
			                        <div class="d-flex align-items-center">
			                          <div class="ml-3">
			                            {{ tr('admin_status') }}
			                        </div>
			                      </td>
			                      <td>
			                        @if($space_details->admin_status == APPROVED)
			                        <span class="badge badge-success">{{tr('approved')}}</span>
			                        @else
			                        <span class="badge badge-danger">{{tr('declined')}}</span>
			                        @endif
			                      </td>
			                    </tr>
			                    <tr>
			                      <td class="py-1 pl-0">
			                        <div class="d-flex align-items-center">
			                          <div class="ml-3">
			                            {{ tr('name') }}
			                        </div>
			                      </td>
			                      <td>
			                        {{ $space_details->name }}
			                      </td>
			                    </tr>
			                    <tr>
			                      <td class="py-1 pl-0">
			                        <div class="d-flex align-items-center">
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
			                        <div class="d-flex align-items-center">
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
			                        <div class="d-flex align-items-center">
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
			                        <div class="d-flex align-items-center">
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
			                        <div class="d-flex align-items-center">
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
			                        <div class="d-flex align-items-center">
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
			                        <div class="d-flex align-items-center">
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
			                        <div class="d-flex align-items-center">
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
			                

			                    @if($space_details->status == PUBLISHED)
			                
			                        <a href="{{ route('provider.spaces.status', ['space_id' => $space_details->id]) }}" onclick="return confirm(&quot;{{ tr('space_unpublish_confirmation')}}&quot;)" class="btn btn-danger">{{ tr('un-publish') }}</a>
			                    @else

			                    <a href="{{ route('provider.spaces.status', ['space_id' => $space_details->id]) }}" class="btn btn-success">{{ tr('publish') }}</a>
			                    @endif

                        		<a href="{{route('provider.spaces.edit',['space_id'=>$space_details->id])}}" class="btn btn-secondary">{{tr('edit')}}</a>


			                    <a class="btn btn-danger" href="{{route('provider.spaces.delete',['space_id'=>$space_details->id])}}" onclick="return confirm(&quot;{{ tr('space_delete_confirmation')}}&quot;)">{{tr('delete')}}</a>

			                
			                </div>
			              </div>
			        </div>
			    </div>
			</div>
	</div>

@endsection