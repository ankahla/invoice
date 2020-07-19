@extends('layouts.app')

@section('content')

	<div class="col-md-12 col-lg-12">
		<h1><i class="fa fa-users"></i> {{ trans('invoice.dashboard') }}</h1>
	</div>		
	
	<div class="col-sm-6 col-md-6">
		<div class="widget widget-stats bg-green">
			<div class="stats-icon stats-icon-lg"><i class="fa fa-users fa-fw"></i></div>
			<div class="stats-title">{{ trans('invoice.users') }}</div>
			<div class="stats-number">{{ $users }}</div>
			<hr>
			<div class="stats-desc">{{ trans('invoice.number_of_clients') }}</div>
		</div> 	
	</div> 
	
	<div class="col-sm-6 col-md-6">
		<div class="widget widget-stats bg-purple">
			<div class="stats-icon stats-icon-lg"><i class="fa fa-file-pdf-o fa-fw"></i></div>
			<div class="stats-title">{{ trans('invoice.invoices') }}</div>
			<div class="stats-number">{{ $invoices }}</div>
			<hr>
			<div class="stats-desc">{{ trans('invoice.number_of_invoices') }}</div>
		</div> 
	</div> 	
	
	
	<div class="col-sm-6 col-lg-6">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h2 class="panel-title">{{ trans('invoice.users_report_01') }}</h2>
			</div>
			
			<div class="panel-body">
				<div id="chartUsersLastMonth"></div>
				<input type="hidden" class="chartUsersLastMonth" value="<?php echo $usersReport['month'];?>">
			</div>
		</div>				
	</div>

	<div class="col-sm-6 col-lg-6">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h2 class="panel-title">{{ trans('invoice.users_report_02') }}</h2>
			</div>
			
			<div class="panel-body">
				<div id="chartUsersLastYear"></div>
				<input type="hidden" class="chartUsersLastYear" value="<?php echo $usersReport['year'];?>">
			</div>
		</div>				
	</div>	
	
	
	<div class="col-sm-6 col-lg-6">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h2 class="panel-title">{{ trans('invoice.report_01') }}</h2>
			</div>
			
			<div class="panel-body">
				<div id="chartInvoicesLastMonth"></div>
				<input type="hidden" class="chartInvoicesLastMonth" value="<?php echo $invoicesReport['month'];?>">
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
				<input type="hidden" class="chartInvoicesLastYear" value="<?php echo $invoicesReport['year'];?>">
			</div>
		</div>				
	</div>	
	
@stop