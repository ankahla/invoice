@if(Session::has('message'))

	<div role="alert" class="alert alert-warning top20 solsoHideAlert">
		<button data-dismiss="alert" class="close" type="button"><span aria-hidden="true"><i class="fa fa-close"></i></span><span class="sr-only">{{ trans('invoice.close') }}</span></button>
		<strong>{{ trans('invoice.message') }}: </strong> {{ Session::get('message') }}
	</div>		
	
	{{ Session::forget('message') }}
	
@endif	
