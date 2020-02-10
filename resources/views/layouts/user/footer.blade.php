<!-- footer -->
<footer class="footer">
  <div class="w-100 clearfix">
    <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">{{ tr('copyright') }} © {{ date("Y") }}  <a href="#" target="_blank">{{ setting()->get('site_name') }}, </a>{{ tr('all_rights_reserved') }}.</span>&emsp;

     	<a class="text-muted" href="{{ route('static-pages',['page_type' =>'about']) }}">{{ tr('about') }}</a>&emsp;

     	<a class="text-muted" href="{{ route('static-pages',['page_type' =>'privacy']) }}">{{ tr('privacy') }}</a>&emsp;

    	<a class="text-muted" href="{{ route('static-pages', ['page_type' =>'cancellation']) }}">{{ tr('cancellation_policy') }}</a>&emsp;

    	<a class="text-muted" href="{{ route('static-pages', ['page_type' =>'terms']) }}">{{ tr('terms') }}</a>&emsp;
    
  </div>
</footer>