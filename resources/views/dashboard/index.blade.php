@extends('layouts.app')

@section('content')

	<div class="col-md-12">
		<h1><i class="fa fa-home"></i> {{ trans('invoice.dashboard') }}</h1>
	</div>
	
	<div class="col-md-12">
    @if ( Auth::user()->role_id == 1 ) 
		<div role="alert" class="alert alert-warning">
			<strong> {{ trans('invoice.message') }}: </strong> {{ trans('invoice.message_09') }} 
			<a href="{{ URL::to('setting') }}" >{{ trans('invoice.settings') }} -> {{ trans('invoice.application') }}</a>
			{{ trans('invoice.message_10') }}
		</div>	
	@endif
		@if ($check['email'] == 0)
			<div role="alert" class="alert alert-warning top20">
				<strong> {{ trans('invoice.message') }}: </strong> {{ trans('invoice.message_01') }} 
				<a href="{{ URL::to('setting') }}" >{{ trans('invoice.settings') }} -> {{ trans('invoice.company') }}</a>
			</div>	
		@endif

		@if ($check['logo'] == 0)
			<div role="alert" class="alert alert-warning top20">
				<strong>{{ trans('invoice.message') }}: </strong> {{ trans('invoice.message_02') }} 
				<a href="{{ URL::to('setting') }}" >{{ trans('invoice.settings') }} -> {{ trans('invoice.logo') }}</a>
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
	
	<div class="col-sm-6 col-md-3">
		<div class="widget widget-stats bg-green">
			<div class="stats-icon stats-icon-lg"><i class="fa fa-users fa-fw"></i></div>
			<div class="stats-title">{{ trans('invoice.clients') }}</div>
			<div class="stats-number">{{ $clients }}</div>
			<hr>
			<div class="stats-desc">{{ trans('invoice.number_of_clients') }}</div>
		</div> 	
	</div> 	

	<div class="col-sm-6 col-md-3">
		<div class="widget widget-stats bg-blue">
			<div class="stats-icon stats-icon-lg"><i class="fa fa-puzzle-piece fa-fw"></i></div>
			<div class="stats-title">{{ trans('invoice.products') }}</div>
			<div class="stats-number">{{ $products }}</div>
			<hr>
			<div class="stats-desc">{{ trans('invoice.number_of_products') }}</div>
		</div> 	
	</div>  

	<div class="col-sm-6 col-md-3">
		<div class="widget widget-stats bg-purple">
			<div class="stats-icon stats-icon-lg"><i class="fa fa-file-pdf-o fa-fw"></i></div>
			<div class="stats-title">{{ trans('invoice.invoices') }}</div>
			<div class="stats-number">{{ $invoices }}</div>
			<hr>
			<div class="stats-desc">{{ trans('invoice.number_of_invoices') }}</div>
		</div> 
	</div> 		
	
	<div class="col-sm-6 col-md-3">
		<div class="widget widget-stats bg-grey">
			<div class="stats-icon stats-icon-lg"><i class="fa fa-money fa-fw"></i></div>
			<div class="stats-title">{{ trans('invoice.amount') }}</div>
			<div class="stats-number">{{ $totalAmount }}</div>
			<hr>
			<div class="stats-desc">{{ trans('invoice.value_of_amounts') }}</div>
		</div> 
	</div> 		

	
	<div class="col-sm-6 col-md-2">
		<div class="solso-pie-chart thumbnail chart-invoice-pending">
			<p>{{ trans('invoice.paid') }}: {{ $invoiceChart['paid']['count'] }}</p>
			<p>{{ trans('invoice.unpaid') }}: {{ $invoiceChart['unpaid']['count'] }}</p>
			<p>{{ trans('invoice.partial_paid') }}: {{ $invoiceChart['partiallypaid']['count'] }}</p>
			<p>{{ trans('invoice.overdue') }}: {{ $invoiceChart['overdue']['count'] }}</p>
			<p>{{ trans('invoice.canceled') }}: {{ $invoiceChart['cancelled']['count'] }}</p>
		</div> 
	</div>		

	<div class="col-sm-6 col-md-2">
		<div class="solso-pie-chart thumbnail chart-invoice-paid">
			<div class="chart" data-percent="{{ $invoiceChart['paid']['percent']}}">
				<span class="percent"></span>
			</div>	
			
			<h4>{{ trans('invoice.paid') }}</h4>
		</div>
	</div> 	

	<div class="col-sm-6 col-md-2">
		<div class="solso-pie-chart thumbnail chart-invoice-unpaid">
			<div class="chart" data-percent="{{ $invoiceChart['unpaid']['percent'] }}">
				<span class="percent"></span>
			</div>	
			
			<h4>{{ trans('invoice.unpaid') }}</h4>
		</div>
	</div>  

	<div class="col-sm-6 col-md-2">
		<div class="solso-pie-chart thumbnail chart-invoice-partial-paid">
			<div class="chart" data-percent="{{ $invoiceChart['partiallypaid']['percent'] }}">
				<span class="percent"></span>
			</div>	
			
			<h4>{{ trans('invoice.partial_paid') }}</h4>
		</div>
	</div> 		

	<div class="col-sm-6 col-md-2">
		<div class="solso-pie-chart thumbnail chart-invoice-overdue">
			<div class="chart" data-percent="{{ $invoiceChart['overdue']['percent'] }}">
				<span class="percent"></span>
			</div>	
			
			<h4>{{ trans('invoice.overdue') }}</h4>
		</div>
	</div> 

	<div class="col-sm-6 col-md-2">
		<div class="solso-pie-chart thumbnail chart-invoice-canceled">
			<div class="chart" data-percent="{{ $invoiceChart['cancelled']['percent']}}">
				<span class="percent"></span>
			</div>	
			
			<h4>{{ trans('invoice.canceled') }}</h4>
		</div>
	</div>	
	
			
	<div class="col-sm-6 col-lg-6">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h2 class="panel-title">{{ trans('invoice.report_01') }}

				<a href="<?php echo URL::to('report');?>" class="pull-right"><i class="fa fa-line-chart"></i>{{ trans('invoice.reports') }}</a></h2>
			</div>
			
			<div class="panel-body">
				<div id="chartInvoicesLastMonth"></div>
				<input type="hidden" class="chartInvoicesLastMonth" value="<?php echo $reports['month'];?>">
			</div>
		</div>				
	</div>

	<div class="col-sm-6 col-lg-6">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h2 class="panel-title">{{ trans('invoice.report_02') }}

				<a href="<?php echo URL::to('report');?>" class="pull-right"><i class="fa fa-line-chart"></i> {{ trans('invoice.reports') }}</a></h2>
			</div>
			
			<div class="panel-body">
				<div id="chartInvoicesLastYear"></div>
				<input type="hidden" class="chartInvoicesLastYear" value="<?php echo $reports['year'];?>">
			</div>
		</div>				
	</div>

	<div class="col-sm-6 col-lg-6">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h2 class="panel-title">{{ trans('invoice.invoices_to_be_paid') }}

				<a href="<?php echo URL::to('invoice');?>" class="pull-right"><i class="fa fa-file-pdf-o"></i> {{ trans('invoice.invoices') }}</a></h2>
			</div>
			
			<div class="panel-body">
				<div class="table-responsive">
				<table class="table table-striped solsoTable">
					<thead>
						<tr>
							<th>{{ trans('invoice.crt') }}.</th>
							<th class="small">{{ trans('invoice.number') }}</th>
							<th>{{ trans('invoice.client') }}</th>
							<th class="small">{{ trans('invoice.due_date') }}</th>
							<th class="small">{{ trans('invoice.status') }}</th>
							<th class="small">{{ trans('invoice.action') }}</th>
						</tr>
					</thead>				
					
					<tbody>
						@foreach($lastInvoices as $crt => $v)
						<tr>
							<td>
								{{ $crt + 1 }}
							</td>
							
							<td>
								{{ $v->number }}
							</td>

							<td>
								{{ $v->client }}
							</td>													
							
							<td>
								{{ $v->due_date }}
							</td>
							
							<td>
								<span class="label label-{{ str_replace(' ', '-', $v->status) }} ">{{ $v->status }}</label>
							</td>
							
							<td>
								<a class="btn btn-info" href="{{ URL::to('invoice/' . $v->id) }}"><i class="fa fa-eye"></i> {{ trans('invoice.show') }}</a>
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>		
				</div>
			</div>
		</div>				
	</div>

	<div class="col-sm-6 col-lg-6">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h2 class="panel-title">{{ trans('invoice.overdue_invoices') }}

				<a href="<?php echo URL::to('invoice');?>" class="pull-right"><i class="fa fa-file-pdf-o"></i> {{ trans('invoice.invoices') }}</a></h2>
			</div>
			
			<div class="panel-body">
				<div class="table-responsive">
				<table class="table table-striped solsoTable">
					<thead>
						<tr>
							<th>{{ trans('invoice.crt') }}.</th>
							<th class="small">{{ trans('invoice.number') }}</th>
							<th>{{ trans('invoice.client') }}</th>
							<th class="small">{{ trans('invoice.due_date') }}</th>
							<th class="small">{{ trans('invoice.status') }}</th>
							<th class="small">{{ trans('invoice.action') }}</th>
						</tr>
					</thead>				
					
					<tbody>
						@foreach($overdueInvoices as $crt => $v)
						<tr>
							<td>
								{{ $crt + 1 }}
							</td>
							
							<td>
								{{ $v->number }}
							</td>

							<td>
								{{ $v->client }}
							</td>													
							
							<td>
								{{ $v->due_date }}
							</td>
							
							<td>
								<span class="label label-overdue">{{ trans('invoice.overdue') }}</label>
							</td>
							
							<td>
								<a class="btn btn-info" href="{{ URL::to('invoice/' . $v->id) }}"><i class="fa fa-eye"></i> {{ trans('invoice.show') }}</a>
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>		
				</div>
			</div>
		</div>				
	</div>

@stop