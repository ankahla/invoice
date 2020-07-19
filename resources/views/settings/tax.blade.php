<div class="col-md-12 col-lg-8">
	<h3>{{ trans('invoice.tax_rate') }}</h3>

	<div class="row">
	<div class="col-md-6">		

		<form action="tax" role="form" class="solsoForm" method="post">
			@csrf
		<label for="value">{{ trans('invoice.new_value') }}</label>
		<div class="input-group">
			<input type="text" name="value" class="form-control required" autocomplete="off" value="{{ old('value') }}" data-parsley-errors-container=".createTax">

			<span class="input-group-btn">
				<button type="submit" class="btn btn-success"><i class="fa fa-save"></i> {{ trans('invoice.save') }}</button>	
			</span>	
		</div>
		
		<div class="createTax"></div>
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
					<th class="col-md-4 col-4">{{ trans('invoice.action') }}</th>
					<th class="small">{{ trans('invoice.action') }}</th>
				</tr>
			</thead>
			
			<tbody>
			
				@foreach ($taxes as $crt => $v)
			
				<tr>
					<td> 
						{{ $crt + 1 }} 
					</td>
					
					<td> 
						{{ $v->value }} %
					</td>
					
					<td>
						<form action="{{ 'tax/' . $v->id }}" role="form" class="solsoForm" method="post">
							@method('PUT')
							@csrf
						<div class="input-group">
							<input type="text" name="value" class="form-control required" autocomplete="off" value="{{ $v->value }}">
							
							<span class="input-group-btn">
								<button type="submit" class="btn btn-success"><i class="fa fa-save"></i> {{ trans('invoice.update') }}</button>	
							</span>	
						</div>		
						
						</form>
					</td>
					
					<td>
						<a  class="btn btn-danger solsoConfirm" data-toggle="modal" data-target="#solsoDeleteModal" data-url="{{ URL::to('tax/' . $v->id) }}"><i class="fa fa-trash"></i> {{ trans('invoice.delete') }}</a>
					</td>
				</tr>
				
				@endforeach
				
			</tbody>
			
			@if ( sizeof($taxes) == 0 )
			
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