@extends('layouts.app')

@section('content')

	<div class="col-md-12">
		@if ($clients == 0)
		<div role="alert" class="alert alert-warning top20">
			<strong>{{ trans('invoice.message') }}: </strong> {{ trans('invoice.create_at_least_one_client') }}
			<a href="{{ URL::to('client') }}" >{{ trans('invoice.clients') }}</a>
		</div>	
		@endif
	
		@if ($products == 0)
		<div role="alert" class="alert alert-warning top20">
			<strong>{{ trans('invoice.message') }}: </strong> {{ trans('invoice.create_at_least_one_product') }}
			<a href="{{ URL::to('product') }}" >{{ trans('invoice.products') }}</a>
		</div>	
		@endif	
		
		@if ($check['email'] == 0)
			<div role="alert" class="alert alert-warning top20">
				<strong> {{ trans('invoice.message') }}: </strong> {{ trans('invoice.message_01') }} 
				<a href="{{ URL::to('setting') }}" >{{ trans('invoice.settings') }} -> {{ trans('invoice.company') }}</a>
			</div>	
		@endif
		
		@if ($check['tax'] == 0)
			<div role="alert" class="alert alert-warning top20">
				<strong>{{ trans('invoice.message') }}: </strong> {{ trans('invoice.message_03') }} 
				<a href="{{ URL::to('setting') }}" >{{ trans('invoice.settings') }} -> {{ trans('invoice.tax') }}</a>
			</div>	
		@endif

		@if ($check['currency'] == 0)
			<div role="alert" class="alert alert-warning top20">
				<strong>{{ trans('invoice.message') }}: </strong> {{ trans('invoice.message_04') }} 
				<a href="{{ URL::to('setting') }}" >{{ trans('invoice.settings') }} -> {{ trans('invoice.currency') }}</a>
			</div>	
		@endif

		@if ($check['payment'] == 0)
			<div role="alert" class="alert alert-warning top20">
				<strong>{{ trans('invoice.message') }}: </strong> {{ trans('invoice.message_05') }} 
				<a href="{{ URL::to('setting') }}" >{{ trans('invoice.settings') }} -> {{ trans('invoice.payment') }}</a>
			</div>	
		@endif
	</div>
	
	<div class="col-md-12 col-lg-12">	
		<h1><i class="fa fa-list"></i> {{ trans('invoice.quotations') }}</h1>
		
		<a href="quotation/create" class="btn btn-primary {{ $clients == 0 || $products == 0 || $check['email'] == 0 || $check['tax'] == 0 || $check['currency'] == 0 || $check['payment'] == 0 ? 'disabled' : ''}}">
			<i class="fa fa-plus"></i> {{ trans('invoice.create_new_quotation') }}
		</a>
	</div>	
	
	<div class="col-md-12 top40">
		<ul id="solsoTabs" class="nav nav-tabs" role="tablist" id="myTab">
			<li class="active"><a href="#tab1" role="tab" data-toggle="tab">{{ trans('invoice.quotations_created') }}</a></li>
		</ul>	
	
		<div class="tab-content top20">
			<div class="tab-pane active" id="tab1">
				@include('quotations.quotations-created')
			</div>
			
		</div>	
	</div>
	
	@include('_modals/add-payment')
	@include('_modals/edit-status')
	@include('_modals/edit-due-date')
	@include('_modals/email')
	@include('_modals/delete')
	
@stop