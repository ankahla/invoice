@section('content')

	<div class="col-md-12 col-lg-12">
		<h1><i class="fa fa-home"></i> {{ trans('invoice.dashboard') }}</h1>
	</div>

	<div class="col-md-12">
		<div role="alert" class="alert alert-warning top20">
			<strong> {{ trans('invoice.message') }}: </strong> {{ trans('invoice.message_07') }} 
			<a href="{{ URL::to('setting') }}" >{{ trans('invoice.settings') }} -> {{ trans('invoice.application') }}</a>
			{{ trans('invoice.message_08') }}
		</div>	
	</div> 
	
	<div class="col-sm-6 col-md-6">
		<div class="widget widget-stats bg-purple">
			<div class="stats-icon stats-icon-lg"><i class="fa fa-file-pdf-o fa-fw"></i></div>
			<div class="stats-title">{{ trans('invoice.invoices_received') }}</div>
			<div class="stats-number">{{ $invoices ? sizeof($invoices) : 0 }}</div>
			<hr>
			<div class="stats-desc">{{ trans('invoice.number_of_invoices') }}</div>
		</div> 
	</div> 	
	
	<div class="col-sm-6 col-md-6">
		<div class="widget widget-stats bg-grey">
			<div class="stats-icon stats-icon-lg"><i class="fa fa-money fa-fw"></i></div>
			<div class="stats-title">{{ trans('invoice.amount') }}</div>
			<div class="stats-number">{{ $totalAmount }}</div>
			<hr>
			<div class="stats-desc">{{ trans('invoice.value_of_amounts') }}</div>
		</div> 
	</div> 
	
	<div class="col-md-12">	
		<h1><i class="fa fa-list"></i> {{ trans('invoice.invoices') }}</h1>
	</div>		
	
	<div class="col-md-12">
		<h3>{{ trans('invoice.invoices_received') }}</h3>
		
		@include('invoices.invoices-received')
	</div>
	
@stop