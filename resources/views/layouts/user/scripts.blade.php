<!-- scripts -->
<!-- plugins:js -->
<script src="{{ asset('user-assets/vendors/js/vendor.bundle.base.js') }}"></script>
<!-- endinject -->

<!-- Plugin js for this page -->
 <script src="{{ asset('user-assets/vendors/jquery-bar-rating/jquery.barrating.min.js') }}"></script>

<script src="{{ asset('user-assets/vendors/moment/moment.min.js') }}"></script>

<script src="{{ asset('user-assets/vendors/chart.js/Chart.min.js') }}"></script>

<script src="{{ asset('user-assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>

<script src="{{ asset('user-assets/vendors/jquery-tags-input/jquery.tagsinput.min.js') }}"></script>

<!-- End plugin js for this page -->

<!-- inject:js -->
<script src="{{ asset('user-assets/js/off-canvas.js') }}"></script>

<script src="{{ asset('user-assets/js/hoverable-collapse.js') }}"></script>

<script src="{{ asset('user-assets/js/template.js') }}"></script>

<script src="{{ asset('user-assets/js/settings.js') }}"></script>

<script src="{{ asset('user-assets/js/todolist.js') }}"></script>
<!-- endinject -->

<!-- Custom js for this page-->
<!-- Custom js for dashboard page-->
<script src="{{ asset('user-assets/js/dashboard.js') }}"></script>

<script src="{{ asset('user-assets/js/chart.js') }}"></script>

<script src="{{ asset('user-assets/vendors/tempusdominus-bootstrap-4/tempusdominus-bootstrap-4.js') }}"></script>

<script src="{{ asset('user-assets/js/formpickers.js') }}"></script>

<script src="{{ asset('user-assets/js/form-addons.js') }}"></script>

<script type="text/javascript" src="{{asset('user-assets/js/jquery.star-rating-svg.min.js')}}"> </script>

<!-- for table -->
<script src="{{asset('user-assets/js/data-table.js')}}"></script>
<script src="{{asset('user-assets/vendors/datatables.net/jquery.dataTables.js')}}"></script>
<script src="{{asset('user-assets/vendors/datatables.net-bs4/dataTables.bootstrap4.js')}}"></script>




{{-- active class --}}


<script type="text/javascript">
	@if(isset($page))
	$("#{{$page}}").addClass("active");
	@endif
	@if(isset($sub_page)) $("#{{$sub_page}}").addClass("active"); @endif
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