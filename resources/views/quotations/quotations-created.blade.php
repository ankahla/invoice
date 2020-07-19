<div class="table-responsive">
	<table class="table table-striped solsoTable">
		<thead>
			<tr>
				<th>{{ trans('invoice.crt') }}.</th>
				<th class="col-md-1">{{ trans('invoice.number') }}</th>
				<th>{{ trans('invoice.client') }}</th>
				<th class="col-md-1">{{ trans('invoice.amount') }}</th>
				<th class="small">{{ trans('invoice.export_pdf') }}</th>
				<th class="small">{{ trans('invoice.email_to_client') }}</th>
				<th class="small"></th>
				<th class="small"></th>
				<th class="small"></th>
				<th class="small"></th>
			</tr>
		</thead>
		
		<tbody>
		
		@foreach ($quotations as $crt => $v)
		
			<tr>
				<td>
					{{ $crt+1 }}
				</td>

				<td>
					{{ isset($invoiceSettings->code) ? $invoiceSettings->code : '' }} {{ $v->number }}
				</td>
				
				<td>
					{{ $v->client }}
				</td>						
				
				<td>
					{{ $v->position == 1 ? $v->currency : '' }} {{ $v->amount }} {{ $v->position == 2 ? $v->currency : '' }} 
				</td>					
				
				
			<td>		
					<a class="btn btn-default" href="{{ URL::to('quotationpdf/' . $v->id.'/theme_01') }}" 
					title="{{ trans('invoice.export_pdf') }}">
						<i class="fa fa-file-pdf-o"></i>
					</a>
				</td>
				
				<td>		
					<button class="btn btn-default solsoConfirm" data-toggle="modal" data-target="#solsoSendEmail" data-url="{{ URL::to('quotationemail/' . $v->id.'/theme_01') }}" 
					title="{{ trans('invoice.email_to_client') }}">
						<i class="fa fa-envelope"></i>
					</button>		
				</td>						

				<td>
                <form method="POST" action ="{{ URL::to('quotation/' . $v->id.'/validate') }}">
					@csrf
					<button type="submit" class="btn btn-success">
						<i class="fa fa-check"></i> {{ trans('invoice.create_invoice') }}
					</button>
                </form>
				</td>
                
				<td>		
					<a class="btn btn-info" href="{{ URL::to('quotation/' . $v->id) }}">
						<i class="fa fa-eye"></i> {{ trans('invoice.show') }}
					</a>
				</td>						

				<td>							
					<a class="btn btn-primary" href="{{ URL::to('quotation/' . $v->id . '/edit') }}">
						<i class="fa fa-edit"></i> {{ trans('invoice.edit') }}
					</a>
				</td>						

				<td>							
					<button class="btn btn-danger solsoConfirm" data-toggle="modal" data-target="#solsoDeleteModal" data-url="{{ URL::to('quotation/' . $v->id) }}">
						<i class="fa fa-trash"></i> {{ trans('invoice.delete') }}
					</button>		
				</td>
			</tr>
			
		@endforeach
		
		</tbody>
	</table>	
</div>