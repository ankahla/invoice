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
    <a class="btn btn-primary" href="{{ URL::to('invoice/' . $invoice->invoiceID . '/edit') }}">
						<i class="fa fa-edit"></i> {{ trans('invoice.edit') }}
	</a>        
    			@if (Request::segment(3))
			
				<a class="btn  solso-pdf" href="{{ URL::to('pdf/received/' . $invoice->invoiceID) }}"><i class="fa fa-file-pdf-o"></i> {{ trans('invoice.export_pdf') }}</a>
				
			@else
			
				<a class="btn  solso-pdf" href="{{ URL::to('pdf/' . $invoice->invoiceID) }}"><i class="fa fa-file-pdf-o"></i> {{ trans('invoice.export_pdf') }}</a>
				<button class="btn solso-email solsoConfirm" data-toggle="modal" data-target="#solsoSendEmail" data-url="{{ URL::to('email/' . $invoice->invoiceID) }}">
					<i class="fa fa-envelope"></i> {{ trans('invoice.email_to_client') }}
				</button>					
				<a class="btn  btn-info" href="{{ URL::to('client/' . $invoice->clientID) }}"><i class="fa fa-user"></i> {{ trans('invoice.client') }}</a>		
			
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
			
			<div class="col-md-2">
				<span class="label label-{{ str_replace(' ', '-', $invoice->status) }} ">{{ trans('invoice.'.str_replace(' ', '_',$invoice->status)) }}</span>
			</div>
			
			<div class="col-md-4">
				<h1 class="uppercase">
					{{ trans('invoice.invoice') }}
				</h1>
				
				<table class="table">
					<tr>
						<th class="col-md-6 text-center">{{ trans('invoice.invoice') }} #</th>
						<th class="col-md-6 text-center">{{ trans('invoice.date') }}</th>
					</tr>

					<tr>						
						<td class="text-center">{{ isset($invoiceSettings->code) ? $invoiceSettings->code : '' }} {{ $invoice->number }}</td>
						<td class="text-center">{{ $invoice->start_date }}</td>
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
				<h2>{{ trans('invoice.bill_to') }} <span class="h4">{{ $invoice->client }}</span></h2>
				<p class="details">{{ $invoice->address }} {{ $invoice->zip}}</p>
				<p class="details">{{ $invoice->contact }}</p>
				<p class="details">{{ $invoice->phone }}</p>
				<p class="details">{{ $invoice->bank }}</p>
				<p class="details">{{ $invoice->bank_account }}</p>				
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
						<?php $invoiceDiscount	= $invoice->discount;?>
						
						@foreach ($invoiceProducts as $crt => $v)
						
							<tr>
								<td align="center">
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
									{{ $invoice->position == 1 ? $invoice->currency : '' }} {{ $v->price }} {{ $invoice->position == 2 ? $invoice->currency : '' }}
								</td>
								
								<td class="small">
									{{ $v->tax }} %
								</td>
								
								<td class="small">
									- {{ $invoice->position == 1 ? $invoice->currency : '' }} {{ number_format($v->discount_value, 3, '.', '') }} {{ $invoice->position == 2 ? $invoice->currency : '' }} 
								</td>
								
								<td class="small">
									{{ $invoice->position == 1 ? $invoice->currency : '' }} {{ number_format($v->amount, 3, '.', '') }} {{ $invoice->position == 2 ? $invoice->currency : '' }}
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
						
						<?php if ($invoice->type == 2) { ?>
							<?php $invoiceDiscount		= ($subTotalItems + $taxItems - $discountItems) * ($invoice->discount / 100); ?>
						<?php } ?>	
					</tbody>	
					
					<tfoot>
						<tr class="bg-white">
							<td colspan="4" class="vcenter text-center">
								<!--{{ trans('invoice.invoice_text_01') }}-->
							</td>
							
							<td colspan="3" class="total">
								<div class="form-group top10">{{ trans('invoice.subtotal') }}: 
									{{ $invoice->position == 1 ? $invoice->currency : '' }} {{ number_format($subTotalItems, 3, '.', '') }} {{ $invoice->position == 2 ? $invoice->currency : '' }} 
								</div>
								
								<div class="form-group">{{ trans('invoice.tax') }}: 
									{{ $invoice->position == 1 ? $invoice->currency : '' }} {{ number_format($taxItems, 3, '.', '') }} {{ $invoice->position == 2 ? $invoice->currency : '' }}
								</div>

								@if ( $discountItems != 0 )
									<div class="form-group">{{ trans('invoice.discount') }}: 
										- {{ $invoice->position == 1 ? $invoice->currency : '' }} {{ number_format($discountItems, 3, '.', '') }} {{ $invoice->position == 2 ? $invoice->currency : '' }}
									</div>
								@endif
								@if ( $invoice->revenue_stamp != 0 )
                                <div class="form-group">{{ trans('invoice.revenue_stamp') }}: 
									{{ $invoice->position == 1 ? $invoice->currency : '' }} {{ number_format($invoice->revenue_stamp, 3, '.', '') }} {{ $invoice->position == 2 ? $invoice->currency : '' }}
								</div>
                                @endif
								@if ( $invoiceDiscount != 0 )
									<div class="form-group">{{ trans('invoice.invoice_discount') }}: 
										- {{ $invoice->position == 1 ? $invoice->currency : '' }} {{ number_format($invoiceDiscount, 3, '.', '') }} {{ $invoice->position == 2 ? $invoice->currency : '' }}
									</div>
								@endif								
								
								<h4 class="form-group">{{ trans('invoice.total') }}: 
									{{ $invoice->position == 1 ? $invoice->currency : '' }} {{ number_format($invoice->amount, 3, '.', '') }} {{ $invoice->position == 2 ? $invoice->currency : '' }}
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
				<p class="text-center top10"> {{ $invoice->invoiceDescription }}</p>
			</div>

			@if (isset($invoiceSettings->text))

				@if (isset($invoiceSettings->text))
					<div class="col-md-12 footer">
					<!--<img style="max-width:100%" src="{{ URL::to($invoiceSettings->text) }}">-->
						{!! $invoiceSettings->text !!}
					</div>
				@endif
			@endif
		@endif

		<div class="col-md-12">
			<h3>{{ trans('invoice.list_of_payments') }}</h3>

			<div class="table-responsive">
				<table class="table table-striped">
					<thead>
					<tr>
						<th>{{ trans('invoice.crt') }}.</th>
						<th class="col-md-4">{{ trans('invoice.amount_paid') }}</th>
						<th class="col-md-4">{{ trans('invoice.date') }}</th>
						<th class="col-md-4">{{ trans('invoice.payment_method') }}</th>
					</tr>
					</thead>

					<tbody>

					@if ($invoicePayments)
						@foreach($invoicePayments as $crt => $p)

							<tr>
								<td>
									{{ $crt + 1 }}
								</td>

								<td>
									{{ $p->payment_amount }} {{ $invoice->currency }}
								</td>

								<td>
									{{ $p->payment_date }}
								</td>

								<td>
									{{ $p->name }}
								</td>
							</tr>

						@endforeach
					@else

						<tr>
							<td colspan="4">
								{{ trans('invoice.no_data') }}
							</td>
						</tr>

					@endif

					</tbody>
				</table>
			</div>
		</div>

		</div>
	</div>
	
	<div class="container">
	<div class="row">
		<div class="col-md-12">
	
			@if (Request::segment(3))
			
				<a class="btn  solso-pdf" href="{{ URL::to('pdf/received/' . $invoice->invoiceID) }}"><i class="fa fa-file-pdf-o"></i> {{ trans('invoice.export_pdf') }}</a>
				
			@else
			
				<a class="btn  solso-pdf" href="{{ URL::to('pdf/' . $invoice->invoiceID) }}"><i class="fa fa-file-pdf-o"></i> {{ trans('invoice.export_pdf') }}</a>
				<button class="btn solso-email solsoConfirm" data-toggle="modal" data-target="#solsoSendEmail" data-url="{{ URL::to('email/' . $invoice->invoiceID) }}">
					<i class="fa fa-envelope"></i> {{ trans('invoice.email_to_client') }}
				</button>					
				<a class="btn  btn-info" href="{{ URL::to('client/' . $invoice->clientID) }}"><i class="fa fa-user"></i> {{ trans('invoice.client') }}</a>		
			
			@endif
			
		</div>
	</div>	
	</div>

	@include('_modals/email')
	
@stop