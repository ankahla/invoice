<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="dompdf.view" content="XYZ,0,0,1" />
	
	<link href='http://fonts.googleapis.com/css?family=Dosis' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" type="text/css" href="{{ asset('css/invoice.css') }}">
</head>
<body>
	<div id="invoice">
		<table>
			<tr>
				<td class="col-md-8">
					@if (isset($logo->name))
						<img src="{{ asset('upload/' . $logo->name ) }}" class="logo">
					@endif
				</td>
				<td class="col-md-4">
					<span class="h1">{{ trans('invoice.invoice') }}</span>
					
					<table class="border">
						<tr>
							<th class="col-md-6">{{ trans('invoice.invoice') }} N°</th>
							<th class="col-md-6">{{ trans('invoice.date') }}</th>
						</tr>

						<tr>						
							<td class="text-center">{{ isset($invoiceSettings->code) ? $invoiceSettings->code : '' }} {{ $invoice->number }}</td>
							<td class="text-center">{{ $invoice->start_date }}</td>
						</tr>
					</table>					
				</td>
			</tr>
		</table>
		
		<table>
			<tr>
				<td class="col-md-6">
					<p class="text-left"><span class="h2">{{ $owner->name }}</span></p>
					<p class="details">{{ $owner->address }}, {{ $owner->zip}}</p>
					<p class="details">{{ $owner->contact }}</p>
					<p class="details">{{ $owner->phone }}</p>
					<p class="details">{{ $owner->bank }}</p>
					<p class="details">{{ $owner->bank_account }}</p>
				</td>

				<td class="col-md-6">			
					<p class="text-left background-th"><span class="h2">{{ trans('invoice.bill_to') }} </span>   <span class="h4">{{ $invoice->client }}</span></p>
					<p class="details">{{ $invoice->address }}, {{ $invoice->zip}}</p>
					<p class="details">{{ $invoice->contact }}</p>
					<p class="details">{{ $invoice->phone }}</p>
					<p class="details">{{ $invoice->bank }}</p>
					<p class="details">{{ $invoice->bank_account }}</p>
				</td>
			</tr>
		</table>

		<table class="border table-striped top20">
			<tr>
				<th class="">{{ trans('invoice.crt') }}</th>
				<th class="product">{{ trans('invoice.item') }}</th>
				<th class="qty">{{ trans('invoice.qty') }}</th>
				<th class="small">{{ trans('invoice.unit_price') }}</th>
				<th class="qty">{{ trans('invoice.tax_rate') }}</th>
				<th class="qty">{{ trans('invoice.discount') }}</th>
				<th class="small">{{ trans('invoice.amount') }}</th>
			</tr>

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
					
					<td class="text-center">
						{{ $v->quantity }}
					</td>
					
					<td class="text-right">
						{{ $invoice->position == 1 ? $invoice->currency : '' }} {{ number_format($v->price, 3, '.', '') }} {{ $invoice->position == 2 ? $invoice->currency : '' }}
					</td>
					
					<td class="text-center">
						{{ $v->tax|round(0) }} %
					</td>
					
					<td class="text-right">
						- {{ $invoice->position == 1 ? $invoice->currency : '' }} {{ number_format($v->discount_value, 3, '.', '') }} {{ $invoice->position == 2 ? $invoice->currency : '' }} 
					</td>
					
					<td class="text-right">
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
					<?php $invoiceDiscount		= $invoice->discount;?>
				<?php } ?>
				
				<?php if ($invoice->type == 2) { ?>
					<?php $invoiceDiscount		= ($subTotalItems + $taxItems - $discountItems) * ($invoice->discount / 100); ?>
				<?php } ?>	
			
			<tr class="bg-white">
				<td colspan="4" class="text-center" style="border-left:none; border-bottom:none">
					<!--<div class="top20">{{ trans('invoice.invoice_text_01') }}</div>-->
				</td>
				
				<td colspan="3" class="total">
					<div class="top10">{{ trans('invoice.subtotal') }}: 
						{{ $invoice->position == 1 ? $invoice->currency : '' }} {{ number_format($subTotalItems, 3, '.', '') }} {{ $invoice->position == 2 ? $invoice->currency : '' }} 
					</div>
					
					<div>{{ trans('invoice.tax') }}:   
						{{ $invoice->position == 1 ? $invoice->currency : '' }} {{ number_format($taxItems, 3, '.', '') }} {{ $invoice->position == 2 ? $invoice->currency : '' }}
					</div>

					@if ( $discountItems != 0 )
						<div>{{ trans('invoice.discount') }}:  
							- {{ $invoice->position == 1 ? $invoice->currency : '' }} {{ number_format($discountItems, 3, '.', '') }} {{ $invoice->position == 2 ? $invoice->currency : '' }}
						</div>
					@endif
					@if ( $invoice->revenue_stamp != 0 )
                                <div class="form-group">{{ trans('invoice.revenue_stamp') }}:   
									{{ $invoice->position == 1 ? $invoice->currency : '' }} {{ number_format($invoice->revenue_stamp, 3, '.', '') }} {{ $invoice->position == 2 ? $invoice->currency : '' }}
								</div>
                                @endif
					@if ( $invoiceDiscount != 0 )
						<div>{{ trans('invoice.invoice_discount') }}:   
							- {{ $invoice->position == 1 ? $invoice->currency : '' }} {{ number_format($invoiceDiscount, 3, '.', '') }} {{ $invoice->position == 2 ? $invoice->currency : '' }}
						</div>
					@endif
					
					<div class="h4 top10">
						{{ trans('invoice.total') }}: 
                        <br><center><strong>
							{{ $invoice->position == 1 ? $invoice->currency : '' }} {{ number_format($invoice->amount, 3, '.', '') }} {{ $invoice->position == 2 ? $invoice->currency : '' }}
						</strong></center>
					</div>
				</td>
			</tr>
		</table>
	</div>
    <div class="summary">
        {{ trans('invoice.invoice_extra_information') }} {{ $invoice->invoiceDescription }}
    </div>
		<div class="footer">	
	@if (isset($invoiceSettings->text))
    {!! $invoiceSettings->text !!}
	@endif
		</div>		
</body>
</html>