@include('_begin')

<div class="solso-sidebar">

	@if ( Auth::user()->role_id == 1 ) 
		@include('admin.sidebar')
	@else	
		@include('sidebar')
	@endif		
	
</div>

<div class="container-fluid">
<div class="row">
	<div class="col-md-12 col-lg-12">

		@include('_messages.index')
		
	</div>	
	
	@yield('content')
</div>
</div>

@include('_end')