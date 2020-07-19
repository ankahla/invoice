@extends('layouts.app')

@section('stylesheets')
	@parent
	<style>
		.footer img {
			max-width: 100%;
		}
	</style>
@stop

@section('content')
	<div class="container top20">
	<div class="row">
		<div class="col-md-12">
			<a class="btn btn-primary" href="{{ URL::to('quotation/' . $quotation->invoiceID . '/edit') }}">
						<i class="fa fa-edit"></i> {{ trans('invoice.edit') }}
            </a>
            @if (Request::segment(3))
			
				<a class="btn  solso-pdf" href="{{ URL::to('quotationpdf/' . $quotation->invoiceID.'/theme_01') }}"><i class="fa fa-file-pdf-o"></i> {{ trans('invoice.export_pdf') }}</a>
				
			@else
			
				<a class="btn  solso-pdf" href="{{ URL::to('quotationpdf/' . $quotation->invoiceID.'/theme_01') }}"><i class="fa fa-file-pdf-o"></i> {{ trans('invoice.export_pdf') }}</a>
				<button class="btn solso-email solsoConfirm" data-toggle="modal" data-target="#solsoSendEmail" data-url="{{ URL::to('quotationemail/' . $quotation->invoiceID.'/theme_01') }}">
					<i class="fa fa-envelope"></i> {{ trans('invoice.email_to_client') }}
				</button>					
				<a class="btn  btn-info" href="{{ URL::to('client/' . $quotation->clientID) }}"><i class="fa fa-user"></i> {{ trans('invoice.client') }}</a>		
			
			@endif
			
		</div>
	</div>	
	</div>
    <div class="container top20">
	<div class="row thumbnail">
		<div id="invoice">
			<div class="col-md-6">
				@if (isset($logo->name))
					<img src="{{ asset('upload/' . $logo->name ) }}" class="img-responsive thumbnail col-md-3">
				@endif
			</div>
			
			<div class="col-md-4">
				<h1 class="uppercase">
					{{ trans('invoice.quotation') }}
				</h1>
				
				<table class="table">
					<tr>
						<th class="col-md-6 text-center">{{ trans('invoice.quotation') }} #</th>
						<th class="col-md-6 text-center">{{ trans('invoice.date') }}</th>
					</tr>

					<tr>						
						<td class="text-center">{{ isset($invoiceSettings->code) ? $invoiceSettings->code : '' }} {{ $quotation->number }}</td>
						<td class="text-center">{{ $quotation->start_date }}</td>
					</tr>
				</table>				
			</div>

			<div class="col-md-6 top20">	
				<h2>{{ $owner->name }}</h2>
				<p class="details">{{ $owner->address }} {{ $owner->zip}}</p>
				<p class="details">{{ $owner->contact }}</p>
				<p class="details">{{ $owner->phone }}</p>
				<p class="details">{{ $owner->bank }}</p>
				<p class="details">{{ $owner->bank_account }}</p>
			</div>
			
			<div class="col-md-6 top20">
				<h2>{{ trans('invoice.bill_to') }} <span class="h4">{{ $quotation->client }}</span></h2>
				<p class="details">{{ $quotation->address }} {{ $quotation->zip}}</p>
				<p class="details">{{ $quotation->contact }}</p>
				<p class="details">{{ $quotation->phone }}</p>
				<p class="details">{{ $quotation->bank }}</p>
				<p class="details">{{ $quotation->bank_account }}</p>				
			</div>
			
			<div class="col-md-12 top20">
			
				@if ($invoiceProducts)
			
					<div class="table-responsive">
					<table class="table table-striped">
					<thead>
						<tr>
							<th><!--{{ trans('invoice.crt') }}.--></th>
							<th>{{ trans('invoice.item') }}</th>
							<th class="small">{{ trans('invoice.qty') }}</th>
							<th class="small">{{ trans('invoice.unit_price') }}</th>
							<th class="small">{{ trans('invoice.tax_rate') }}</th>
							<th class="small">{{ trans('invoice.discount') }}</th>
							<th class="small">{{ trans('invoice.amount') }}</th>
						</tr>
					</thead>
					
					<tbody>
						<?php $subTotalItems 	= 0;?>
						<?php $taxItems 		= 0;?>
						<?php $discountItems	= 0;?>
						<?php $invoiceDiscount	= 0;?>
						
						@foreach ($invoiceProducts as $crt => $v)
						
							<tr>
								<td>
									<!--{{ $crt + 1 }}-->
                                    @if ($v->product_image)
                                    <img src="{{ asset('upload/products/' . $v->product_image ) }}" style="max-height:50px; max-width:50px" class="img-responsive thumbnail">
                                    @endif
								</td>
								
								<td>
									{{ $v->name }}
								</td>
								
								<td class="small">
									{{ $v->quantity }}
								</td>
								
								<td class="small">
									{{ $quotation->position == 1 ? $quotation->currency : '' }} {{ $v->price }} {{ $quotation->position == 2 ? $quotation->currency : '' }}
								</td>
								
								<td class="small">
									{{ $v->tax }} %
								</td>
								
								<td class="small">
									- {{ $quotation->position == 1 ? $quotation->currency : '' }} {{ number_format($v->discount_value, 3, '.', '') }} {{ $quotation->position == 2 ? $quotation->currency : '' }} 
								</td>
								
								<td class="small">
									{{ $quotation->position == 1 ? $quotation->currency : '' }} {{ number_format($v->amount, 3, '.', '') }} {{ $quotation->position == 2 ? $quotation->currency : '' }}
								</td>							
							</tr>
							
							@if ($v->description)
							<tr>
								<td colspan="7">
									{{ $v->description }}
								</td>
							</tr>
							@endif
							
							<?php $subTotalItems 	+= $v->quantity * $v->price;?>
							<?php $taxItems 		+= ($v->quantity * $v->price) * ($v->tax / 100);?>							
							<?php $discountItems 	+= $v->discount_value;?>		
							
						@endforeach
						
						<?php if ($quotation->type == 1) { ?>
							<?php $invoiceDiscount		= $quotation->discount;?>
						<?php } ?>
						
						<?php if ($quotation->type == 2) { ?>
							<?php $invoiceDiscount		= ($subTotalItems + $taxItems - $discountItems) * ($quotation->discount / 100); ?>
						<?php } ?>	
					</tbody>	
					
					<tfoot>
						<tr class="bg-white">
							<td colspan="4" class="vcenter text-center">
								<!--{{ trans('invoice.invoice_text_01') }}-->
							</td>
							
							<td colspan="3" class="total">
								<div class="form-group top10">{{ trans('invoice.subtotal') }}: 
									{{ $quotation->position == 1 ? $quotation->currency : '' }} {{ number_format($subTotalItems, 3, '.', '') }} {{ $quotation->position == 2 ? $quotation->currency : '' }} 
								</div>
								
								<div class="form-group">{{ trans('invoice.tax') }}: 
									{{ $quotation->position == 1 ? $quotation->currency : '' }} {{ number_format($taxItems, 3, '.', '') }} {{ $quotation->position == 2 ? $quotation->currency : '' }}
								</div>

								@if ( $discountItems != 0 )
									<div class="form-group">{{ trans('invoice.discount') }}: 
										- {{ $quotation->position == 1 ? $quotation->currency : '' }} {{ number_format($discountItems, 3, '.', '') }} {{ $quotation->position == 2 ? $quotation->currency : '' }}
									</div>
								@endif
                                @if ( $quotation->revenue_stamp != 0 )
                                <div class="form-group">{{ trans('invoice.revenue_stamp') }}: 
									{{ $quotation->position == 1 ? $quotation->currency : '' }} {{ number_format($quotation->revenue_stamp, 3, '.', '') }} {{ $quotation->position == 2 ? $quotation->currency : '' }}
								</div>
                                @endif
								@if ( $invoiceDiscount != 0 )
									<div class="form-group">{{ trans('invoice.invoice_discount') }}: 
										- {{ $quotation->position == 1 ? $quotation->currency : '' }} {{ number_format($invoiceDiscount, 3, '.', '') }} {{ $quotation->position == 2 ? $quotation->currency : '' }}
									</div>
								@endif								
								
								<h4 class="form-group">{{ trans('invoice.total') }}: 
									{{ $quotation->position == 1 ? $quotation->currency : '' }} {{ number_format($quotation->amount, 3, '.', '') }} {{ $quotation->position == 2 ? $quotation->currency : '' }}
								</h4>
							</td>
						</tr>	
					</tfoot>	
					</table>
					</div>
					
				@else
				
					<div role="alert" class="alert alert-danger top20">
						<strong>{{ trans('invoice.message') }}: </strong> {{ trans('invoice.message_06') }}
					</div>	
					
				@endif				
				
			</div>
		</div>
		
	
		@if (!Request::segment(3))
		
			<div class="col-md-12">
				<!--<h3>{{ trans('invoice.invoice_extra_information') }}</h3>-->
				<!--<p class="text-center top10">{{ trans('invoice.invoice_extra_information') }} {{ $quotation->invoiceDescription }}</p>-->
			</div>		
		
			@if (isset($invoiceSettings->text))
			
				<div class="col-md-12 footer">
					<!--<h4>{{ trans('invoice.invoice_personal_description') }}</h4>-->
                    @if (isset($invoiceSettings->text))
							{!!  $invoiceSettings->text !!}
					@endif
				</div>
				
			@endif
		@endif
		
	</div>
	</div>
	
	<div class="container">
	<div class="row">
		<div class="col-md-12">
	
			@if (Request::segment(3))
			
				<a class="btn  solso-pdf" href="{{ URL::to('quotationpdf/' . $quotation->invoiceID.'/theme_01') }}"><i class="fa fa-file-pdf-o"></i> {{ trans('invoice.export_pdf') }}</a>
				
			@else
			
				<a class="btn  solso-pdf" href="{{ URL::to('quotationpdf/' . $quotation->invoiceID.'/theme_01') }}"><i class="fa fa-file-pdf-o"></i> {{ trans('invoice.export_pdf') }}</a>
				<button class="btn solso-email solsoConfirm" data-toggle="modal" data-target="#solsoSendEmail" data-url="{{ URL::to('quotationemail/' . $quotation->id.'/theme_01') }}">
					<i class="fa fa-envelope"></i> {{ trans('invoice.email_to_client') }}
				</button>					
				<a class="btn  btn-info" href="{{ URL::to('client/' . $quotation->clientID) }}"><i class="fa fa-user"></i> {{ trans('invoice.client') }}</a>		
			
			@endif
			
		</div>
	</div>	
	</div>

	@include('_modals/email')
	
@stop