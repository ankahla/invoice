@extends('layouts.app')

@section('content')

	<div class="col-md-12 col-lg-12">
		<h1><i class="fa fa-list"></i> {{ trans('invoice.products') }}</h1>
		
		<a href="product/create" class="btn btn-primary"><i class="fa fa-plus"></i> {{ trans('invoice.create_new_product') }}</a>
	</div>	

	<div class="col-md-12 col-lg-12 top40">
		<h3>{{ trans('invoice.products') }}</h3>
		
		<div class="table-responsive">
			<table class="table solsoTable">
				<thead>
					<tr>
						<th>{{ trans('invoice.crt') }}.</th>
						<th>{{ trans('invoice.product') }}</th>
						<th>{{ trans('invoice.code') }}</th>
						<th class="small text-right">{{ trans('invoice.price') }}</th>
						<th class="small">{{ trans('invoice.action') }}</th>
						<th class="small">{{ trans('invoice.action') }}</th>
						<th class="small">{{ trans('invoice.action') }}</th>
					</tr>
				</thead>
				
				<tbody>
				
				@foreach ($products as $crt => $v)
                	<?php $imgUrl = $v->getImage() ?>
					<tr>
						<td>
							<!--{{ $crt+1 }}-->
                            @if ($imgUrl)
                        <img src="{{ asset('upload/products/' . $imgUrl ) }}" style="max-height:75px; max-width:75px" class="img-responsive thumbnail">
                        @endif
						</td>
						
						<td>
							{{ $v->name }}
						</td>						
						
						<td>
							{{ $v->code }}
						</td>
						
						<td class="text-right">
							{{ $currency->position == 1 ? $currency->name : '' }} {{ $v->price }} {{ $currency->position == 2 ? $currency->name : '' }} 
						</td>						
						
						<td>		
							<a  class="btn btn-info solsoShowDetails" data-toggle="modal" data-target="#solsoInfoProduct" data-value="{{ $v->id }}"><i class="fa fa-eye"></i> {{ trans('invoice.show') }}</a>	
						</td>
						
						<td>		
							<a class="btn btn-primary" href="{{ URL::to('product/' . $v->id . '/edit') }}"><i class="fa fa-edit"></i> {{ trans('invoice.edit') }}</a>
						</td>
						
						<td>		
							<a  class="btn btn-danger solsoConfirm" data-toggle="modal" data-target="#solsoDeleteModal" data-url="{{ URL::to('product/' . $v->id) }}"><i class="fa fa-trash"></i> {{ trans('invoice.delete') }}</a>		
						</td>
					</tr>
					
				@endforeach
				
				</tbody>
			</table>
		</div>	
	</div>
	
	@include('_modals/delete')
	@include('_modals/product')
	
@stop