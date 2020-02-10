<!-- scripts -->
<script src="{{ asset('provider-assets/vendors/js/vendor.bundle.base.js') }}"></script>
<!-- endinject -->

<!-- Plugin js for this page -->
 <script src="{{ asset('provider-assets/vendors/jquery-bar-rating/jquery.barrating.min.js') }}"></script>

<script src="{{ asset('provider-assets/vendors/moment/moment.min.js') }}"></script>

<script src="{{ asset('provider-assets/vendors/chart.js/Chart.min.js') }}"></script>

<script src="{{ asset('provider-assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>

<script src="{{ asset('provider-assets/vendors/jquery-tags-input/jquery.tagsinput.min.js') }}"></script>

<!-- End plugin js for this page -->

<!-- inject:js -->
<script src="{{ asset('provider-assets/js/off-canvas.js') }}"></script>

<script src="{{ asset('provider-assets/js/hoverable-collapse.js') }}"></script>

<script src="{{ asset('provider-assets/js/template.js') }}"></script>

<script src="{{ asset('provider-assets/js/settings.js') }}"></script>

<script src="{{ asset('provider-assets/js/todolist.js') }}"></script>
<!-- endinject -->

<!-- Custom js for this page-->
<script src="{{ asset('provider-assets/js/dashboard.js') }}"></script>

<script src="{{ asset('provider-assets/js/chart.js') }}"></script>

<script src="{{ asset('provider-assets/vendors/tempusdominus-bootstrap-4/tempusdominus-bootstrap-4.js') }}"></script>

<script src="{{ asset('provider-assets/js/formpickers.js') }}"></script>

<script src="{{ asset('provider-assets/js/form-addons.js') }}"></script>

<script type="text/javascript" src="{{asset('provider-assets/js/jquery.star-rating-svg.min.js')}}"> </script>

<!-- endinject -->
<!-- Plugin js for this page -->
<script src="{{asset('provider-assets/vendors/select2/select2.min.js')}}"></script>
<!-- End plugin js for this page -->
<!-- inject:js -->
<script src="{{asset('provider-assets/js/off-canvas.js')}}"></script>
<script src="{{asset('provider-assets/js/select2.js')}}"></script>
<script src="{{asset('provider-assets/js/file-upload.js')}}"></script>
<script src="{{ asset('provider-assets/vendors/raphael/raphael.min.js')}}"></script>
<script src="{{ asset('provider-assets/vendors/morris.js/morris.min.js')}}"></script>

<!-- endinject -->
<!-- Custom js for dashboard page-->
<script src="{{asset('provider-assets/js/morris.js')}}"></script>

<!-- for table -->
<script src="{{asset('provider-assets/js/data-table.js')}}"></script>
<script src="{{asset('provider-assets/vendors/datatables.net/jquery.dataTables.js')}}"></script>
<script src="{{asset('provider-assets/vendors/datatables.net-bs4/dataTables.bootstrap4.js')}}"></script>

{{-- active class --}}


<script type="text/javascript">
	@if(isset($page))
	$("#{{$page}}").addClass("active");
	@if(isset($sub_page)) $("#{{$sub_page}}").addClass("active"); @endif
	@endif
</script>

{{-- image preview --}}

<script type="text/javascript">
		
  function readURL(input) {
	    if (input.files && input.files[0]) {
	        var reader = new FileReader();

	        reader.onload = function (e) {
	            $('#preview')
	                .attr('src', e.target.result);
	        };

	        reader.readAsDataURL(input.files[0]);
	    }
	}
</script>