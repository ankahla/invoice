<div class="col-md-12 col-lg-8">	
	<h3>{{ trans('invoice.currencies') }}</h3>
		
	@if (Session::has('ajaxMessage'))

		<div role="alert" class="alert alert-warning top20 solsoHideAlert">
			<button data-dismiss="alert" class="close" type="button"><span aria-hidden="true"><i class="fa fa-close"></i></span><span class="sr-only">Close</span></button>
			<strong>{{ trans('invoice.message') }}: </strong> {{ Session::get('ajaxMessage') }}
		</div>		
		
		{{ Session::forget('ajaxMessage') }}
		
	@endif	
	
	<div class="row">
	<div class="col-md-6">		
		<form action="currency" role="form" class="solsoForm" method="POST">
			@csrf
		<label for="value"> {{ trans('invoice.new_value') }}</label>
		<div class="input-group">
			<input type="text" name="value" class="form-control required" autocomplete="off" value="{{ old('value') }}" data-parsley-errors-container=".createCurency">

			<span class="input-group-btn">
				<button type="submit" class="btn btn-success"><i class="fa fa-save"></i> {{ trans('invoice.save') }}</button>	
			</span>	
		</div>
		
		<div class="createCurency"></div>
		<?php echo $errors->first('value', '<p class="error">:messages</p>');?>
		
		</form>
	</div>
	</div>
	<div class="clearfix"></div>		
	
	<div class="table-responsive">
		<table class="table top20">
			<thead>
				<tr>
					<th>{{ trans('invoice.crt') }}.</th>
					<th>{{ trans('invoice.values') }}</th>
					<th>{{ trans('invoice.position_price') }}</th>
					<th>{{ trans('invoice.default_currency') }}</th>
					<th class="col-md-4 col-4">{{ trans('invoice.action') }}</th>
					<th class="small">{{ trans('invoice.action') }}</th>
				</tr>
			</thead>
			
			<tbody>
			
				@foreach ($currencies as $crt => $v)
			
				<tr>
					<td> 
						{{ $crt + 1 }} 
					</td>
					
					<td> 
						{{ $v->name }}
					</td>
					
					<td>
						<div class="btn-group" data-toggle="buttons">
							<label class="btn btn-default {{ $v->position == 1 ? 'active' : '' }} solsoCurrencySettings" data-id="{{ $v->id }}">
								<input type="radio" name="position" autocomplete="off" value="1" {{ $v->position == 1 ? "checked='checked'" : '' }}> <span class="capitalize">{{ trans('invoice.left') }}</span>
							</label>
							
							<label class="btn btn-default {{ $v->position == 2 ? 'active' : '' }} solsoCurrencySettings" data-id="{{ $v->id }}">
								<input type="radio" name="position" autocomplete="off" value="2" {{ $v->position == 2 ? "checked='checked'" : '' }}> <span class="capitalize">{{ trans('invoice.right') }}</span>
							</label>
						</div>	
					</td>
					
					<td>
						<div class="btn-group" data-toggle="buttons">
							<label class="btn btn-default {{ $company->currency_id == $v->id  ? 'active' : '' }} solsoCurrencySettings" data-id="{{ $v->id }}">
								<input type="radio" name="default" autocomplete="off" value="1" {{ $company->currency_id == $v->id ? "checked='checked'" : '' }}> <span class="capitalize">{{ trans('invoice.yes') }}</span>
							</label>
							
							<label class="btn btn-default {{ $company->currency_id != $v->id ? 'active' : '' }} solsoCurrencySettings" data-id="{{ $v->id }}">
								<input type="radio" name="default" autocomplete="off" value="2" {{ $company->currency_id != $v->id ? "checked='checked'" : '' }}> <span class="capitalize">{{ trans('invoice.no') }}</span>
							</label>
						</div>	
					</td>					
					
					<td>
						<form action="{{ 'currency/' . $v->id }}" role="form" class="solsoForm" method="POST">
							@method('PUT')
							@csrf
						
						<div class="input-group">
							<input type="text" name="value" class="form-control required" autocomplete="off" value="{{ $v->name }}">
							
							<span class="input-group-btn">
								<button type="submit" class="btn btn-success"><i class="fa fa-save"></i> {{ trans('invoice.update') }}</button>	
							</span>	
						</div>		
						
						</form>
					</td>
					
					<td>
						<a  class="btn btn-danger solsoConfirm" data-toggle="modal" data-target="#solsoDeleteModal" data-url="{{ URL::to('currency/' . $v->id) }}"><i class="fa fa-trash"></i> {{ trans('invoice.delete') }}</a>
					</td>
				</tr>
				
				@endforeach
				
			</tbody>
			
			@if (sizeof($currencies) == 0)
			
			<tfoot>
				<tr>
					<td colspan="4">
						{{ trans('invoice.no_data') }}
					</td>
				</tr>
			</tfoot>

			@endif	
		</table>
	</div>
</div>