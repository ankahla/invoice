@extends('layouts.app')

@section('content')

	<div class="col-md-12 col-lg-12 bottom40">
		<h1><i class="fa fa-line-chart"></i> {{ trans('invoice.reports') }}</h1>
	</div>	

	<div class="col-sm-6 col-lg-6">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h2 class="panel-title">{{ trans('invoice.report_01') }}</h2>
			</div>
			
			<div class="panel-body">
				<div id="chartInvoicesLastMonth"></div>
				<input type="hidden" class="chartInvoicesLastMonth" value="<?php echo $invoices['month'];?>">
			</div>
		</div>				
	</div>

	<div class="col-sm-6 col-lg-6">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h2 class="panel-title">{{ trans('invoice.report_02') }}</h2>
			</div>
			
			<div class="panel-body">
				<div id="chartInvoicesLastYear"></div>
				<input type="hidden" class="chartInvoicesLastYear" value="<?php echo $invoices['year'];?>">
			</div>
		</div>				
	</div>
	
	
	<div class="col-sm-6 col-lg-6">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h2 class="panel-title">{{ trans('invoice.report_03') }}</h2>
			</div>
			
			<div class="panel-body">
				<div id="chartAmountLastMonth"></div>
				<input type="hidden" class="chartAmountLastMonth" value="<?php echo $amounts['month'];?>">
			</div>
		</div>				
	</div>

	<div class="col-sm-6 col-lg-6">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h2 class="panel-title">{{ trans('invoice.report_04') }}</h2>
			</div>
			
			<div class="panel-body">
				<div id="chartAmountLastYear"></div>
				<input type="hidden" class="chartAmountLastYear" value="<?php echo $amounts['year'];?>">
			</div>
		</div>				
	</div>
	
	
	<div class="col-sm-6 col-lg-6">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h2 class="panel-title">{{ trans('invoice.report_05') }}</h2>
			</div>
			
			<div class="panel-body">
				<div id="chartClientsLastMonth"></div>
				<input type="hidden" class="chartClientsLastMonth" value="<?php echo $clients['month'];?>">
			</div>
		</div>				
	</div>

	<div class="col-sm-6 col-lg-6">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h2 class="panel-title">{{ trans('invoice.report_06') }}</h2>
			</div>
			
			<div class="panel-body">
				<div id="chartClientsLastYear"></div>
				<input type="hidden" class="chartClientsLastYear" value="<?php echo $clients['year'];?>">
			</div>
		</div>				
	</div>	
	
@stop