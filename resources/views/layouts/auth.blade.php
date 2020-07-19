@include('_begin')

<div class="col-md-12 col-lg-12">
	@if(Session::has('message'))
		<div role="alert" class="alert alert-warning fade in top20 solsoHideAlert">
			<button data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span><span class="sr-only">{{ trans('invoice.close') }}</span></button>
			<strong>{{ trans('invoice.message') }}: </strong> {{ Session::get('message') }} !
		</div>		
	@endif	
	
	@if(Session::has('error'))
		<div role="alert" class="alert alert-danger fade in top20 solsoHideAlert">
			<button data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span><span class="sr-only">{{ trans('invoice.close') }}</span></button>
			<strong>{{ trans('invoice.message') }}: </strong> {{ Session::get('error') }} !
		</div>		
	@endif		
</div>	
		
<div id="website">
	<div class="jumbotron">
		<div class="container">
		<div class="row">
			<div class="col-md-3 text-center">
				<img src="{{ asset('upload/default-logo.jpg') }}" class="top10 img img-responsive">
				
			</div>
			
			<div class="col-md-6">
				@yield('content')
			</div>
		</div>
		</div>
	</div>

	<div class="container">
	<div class="row">
		<h4 class="text-center"> {{ trans('invoice.power_by') }}</h4>
	</div>
	</div>
		
</div>

<script type="text/javascript" src="{{ asset('js/jquery.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/bootstrap.min.js') }}"></script>

<!-- PARSLEY VALIDATION -->
<script type="text/javascript" src="{{ asset('vendor/parsley/parsley.js') }}"></script>
<script>	
	$(".solsoForm").parsley({
		successClass: "has-success",
		errorClass: "has-error",
		classHandler: function (el) {
			return el.$element.closest(".form-group, td");
		}, 
		errorsContainer: function (el) {
			return el.$element.closest(".form-group, td");
		}
	});
	
	/* === CLOSE ALERTS === */
	function solsoAlerts()
	{
		window.setTimeout(function() {
			$(".solsoHideAlert").fadeTo(500, 0).slideUp(500, function(){
				$(this).remove(); 
			});
		}, 5000);		
	}
	
	solsoAlerts();
	/* === END CLOSE ALERTS === */	
</script>	
<!-- END PARSLEY VALIDATION -->
	
</body>
</html>