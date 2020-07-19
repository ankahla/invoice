<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="dompdf.view" content="XYZ,0,0,1" />
	
	<link href='http://fonts.googleapis.com/css?family=Dosis' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" type="text/css" href="{{ url('public/css/invoice.css') }}">
</head>
<body>
	<div id="invoice">
		<table>
			<tr>
				<td class="col-md-8">
					@if (isset($logo->name))
						<img src="{{ URL::to('public/upload/' . $logo->name ) }}">
					@endif
				</td>
				<td class="col-md-4">
					<span class="h1">{{ trans('invoice.quotation') }}</span>
					
					<table class="border">
						<tr>
							<th class="col-md-6">{{ trans('invoice.quotation') }} N°</th>
							<th class="col-md-6">{{ trans('invoice.date') }}</th>
						</tr>

						<tr>						
							<td class="text-center">{{ isset($invoiceSettings->code) ? $invoiceSettings->code : '' }} {{ $item->number }}</td>
							<td class="text-center">{{ $item->start_date }}</td>
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
					<p class="text-left background-th"><span class="h2">{{ trans('invoice.bill_to') }} </span>   <span class="h4">{{ $item->client }}</span></p>
					<p class="details">{{ $item->address }}, {{ $item->zip}}</p>
					<p class="details">{{ $item->contact }}</p>
					<p class="details">{{ $item->phone }}</p>
					<p class="details">{{ $item->bank }}</p>
					<p class="details">{{ $item->bank_account }}</p>
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
			
			@foreach ($products as $crt => $v)

				<tr>
					<td>
						<!--{{ $crt + 1 }}-->
                        @if ($v->product_image)
                        <img src="{{ URL::to('public/upload/products/' . $v->product_image ) }}" style="max-height:50px; max-width:50px" class="img-responsive thumbnail">
                        @endif
					</td>
					
					<td>
						{{ $v->name }}
					</td>
					
					<td class="text-center">
						{{ $v->quantity }}
					</td>
					
					<td class="text-right">
						{{ $item->position == 1 ? $item->currency : '' }} {{ number_format($v->price, 3, '.', '') }} {{ $item->position == 2 ? $item->currency : '' }}
					</td>
					
					<td class="text-center">
						{{ $v->tax|round(0) }} %
					</td>
					
					<td class="text-right">
						- {{ $item->position == 1 ? $item->currency : '' }} {{ number_format($v->discount_value, 3, '.', '') }} {{ $item->position == 2 ? $item->currency : '' }} 
					</td>
					
					<td class="text-right">
						{{ $item->position == 1 ? $item->currency : '' }} {{ number_format($v->amount, 3, '.', '') }} {{ $item->position == 2 ? $item->currency : '' }}
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
			
				<?php if ($item->type == 2) { ?>
					<?php $invoiceDiscount		= $item->discount;?>
				<?php } ?>
				
				<?php if ($item->type == 2) { ?>
					<?php $invoiceDiscount		= ($subTotalItems + $taxItems - $discountItems) * ($item->discount / 100); ?>
				<?php } ?>	
			
			<tr class="bg-white">
				<td colspan="4" class="text-center" style="border-left:none; border-bottom:none">
					<!--<div class="top20">{{ trans('invoice.invoice_text_01') }}</div>-->
				</td>
				
				<td colspan="3" class="total">
					<div class="top10">{{ trans('invoice.subtotal') }}:   
						{{ $item->position == 1 ? $item->currency : '' }} {{ number_format($subTotalItems, 3, '.', '') }} {{ $item->position == 2 ? $item->currency : '' }} 
					</div>
					
					<div>{{ trans('invoice.tax') }}:   
						{{ $item->position == 1 ? $item->currency : '' }} {{ number_format($taxItems, 3, '.', '') }} {{ $item->position == 2 ? $item->currency : '' }}
					</div>

					@if ( $discountItems != 0 )
						<div>{{ trans('invoice.discount') }}:   
							- {{ $item->position == 1 ? $item->currency : '' }} {{ number_format($discountItems, 3, '.', '') }} {{ $item->position == 2 ? $item->currency : '' }}
						</div>
					@endif
					@if ( $item->revenue_stamp != 0 )
                                <div class="form-group">{{ trans('invoice.revenue_stamp') }}:   
									{{ $item->position == 1 ? $item->currency : '' }} {{ number_format($item->revenue_stamp, 3, '.', '') }} {{ $item->position == 2 ? $item->currency : '' }}
								</div>
                    @endif
					@if ( $invoiceDiscount != 0 )
						<div>{{ trans('invoice.invoice_discount') }}:   
							- {{ $item->position == 1 ? $item->currency : '' }} {{ number_format($invoiceDiscount, 3, '.', '') }} {{ $item->position == 2 ? $item->currency : '' }}
						</div>
					@endif
					
					<div class="h4 top10">
						{{ trans('invoice.total') }}:   
                        <br><center><strong>
							{{ $item->position == 1 ? $item->currency : '' }} {{ number_format($item->amount, 3, '.', '') }} {{ $item->position == 2 ? $item->currency : '' }}
						</strong></center>
					</div>
				</td>
			</tr>			
		</table>
	</div>
	
		<div class="footer">	
	@if (isset($invoiceSettings->text))
    <img src="{{ URL::to($invoiceSettings->text) }}">
	@endif

		</div>
	
</body>
</html>