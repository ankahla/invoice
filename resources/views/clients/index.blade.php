@extends('layouts.app')

@section('content')

	<div class="col-md-12 col-lg-12">
		<h1><i class="fa fa-list"></i> {{ trans('invoice.clients') }}</h1>
		
		<a href="client/create" class="btn btn-primary"><i class="fa fa-plus"></i> {{ trans('invoice.create_new_client') }}</a>
	</div>	

	<div class="col-md-12 col-lg-12 top40">
		<h3>{{ trans('invoice.clients') }}</h3>
		
		<div class="table-responsive">
			<table class="table solsoTable">
				<thead>
					<tr>
						<th>{{ trans('invoice.crt') }}.</th>
						<th>{{ trans('invoice.client') }}</th>
						<th>{{ trans('invoice.address') }}</th>
						<th>{{ trans('invoice.contact') }}</th>
						<th>{{ trans('invoice.phone') }}</th>
						<th>{{ trans('invoice.email') }}</th>
						@if ($app->type == 2)
						<th class="small">{{ trans('invoice.action') }}</th>
						@endif
						<th class="small">{{ trans('invoice.action') }}</th>
						<th class="small">{{ trans('invoice.action') }}</th>
						<th class="small">{{ trans('invoice.action') }}</th>
					</tr>
				</thead>
				
				<tbody>
				
				@foreach ($clients as $crt => $v)
				
					<tr>
						<td>
							{{ $crt+1 }}
						</td>

						<td>
							{{ $v->name }}
						</td>
						
						<td>
							{{ $v->address }}
						</td>					
						
						<td>
							{{ $v->contact }}
						</td>						
						
						<td>
							{{ $v->phone }}
						</td>					
						
						<td>
							{{ $v->email }}
						</td>						
						
						@if ($app->type == 2)
							
							<td>		
								@if ($v->status != 1)
								
									<a class="btn solso-pdf" href="{{ URL::to('newsletter/' . $v->id) }}"><i class="fa fa-share"></i> {{ trans('invoice.send_invitation') }}</a>	
									
								@else
									{{ trans('invoice.invitation_was_sent') }}
								@endif
							</td>
						
						@endif		
						
						<td>		
							<a class="btn btn-info" href="{{ URL::to('client/' . $v->id) }}"><i class="fa fa-eye"></i> {{ trans('invoice.show') }}</a>
						</td>

						<td>		
							<a class="btn btn-primary" href="{{ URL::to('client/' . $v->id . '/edit') }}"><i class="fa fa-edit"></i> {{ trans('invoice.edit') }}</a>
						</td>
						
						<td>		
							<a class="btn btn-danger solsoConfirm" data-toggle="modal" data-target="#solsoDeleteModal" data-url="{{ URL::to('client/' . $v->id) }}"><i class="fa fa-trash"></i> {{ trans('invoice.delete') }}</a>		
						</td>
					</tr>
					
				@endforeach
				
				</tbody>
			</table>	
		</div>	
	</div>
	
	@include('_modals/delete')
	
@stop