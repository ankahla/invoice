@extends('layouts.app')

@section('content')

	<div class="col-md-12 col-lg-12">
		<h1><i class="fa fa-book"></i> {{ trans('invoice.languages') }}</h1>
		
		<a href="language/create" class="btn btn-primary"><i class="fa fa-plus"></i> {{ trans('invoice.create_new_language') }}</a>
	</div>	

	
	<div class="col-md-12 col-lg-12 top40">
		<h3>{{ trans('invoice.languages') }}</h3>
		
		<div class="table-responsive">
			<table class="table solsoTable">
				<thead>
					<tr>
						<th>{{ trans('invoice.crt') }}.</th>
						<th>{{ trans('invoice.language') }}</th>
						<th>{{ trans('invoice.short_name') }}</th>
						<th class="small">{{ trans('invoice.action') }}</th>
						<th class="small">{{ trans('invoice.action') }}</th>
						<th class="small">{{ trans('invoice.action') }}</th>
					</tr>
				</thead>
				
				<tbody>
				
				@foreach ($languages as $crt => $v)
					
					<tr>
						<td>
							{{ $crt+1 }}
						</td>

						<td>
							{{ $v->name }}
						</td>

						<td>
							{{ $v->short }}
						</td>

						<td>		
							<a class="btn solso-email" href="{{ URL::to('language/' . $v->id) }}">
								<i class="fa fa-book"></i> {{ trans('invoice.translate') }}
							</a>
						</td>							
						
						<td>							
							<a class="btn btn-primary" href="{{ URL::to('language/' . $v->id . '/edit') }}">
								<i class="fa fa-edit"></i> {{ trans('invoice.edit') }}
							</a>
						</td>						

						<td>							
							<button class="btn btn-danger solsoConfirm" data-toggle="modal" data-target="#solsoDeleteModal" data-url="{{ URL::to('language/' . $v->id) }}">
								<i class="fa fa-trash"></i> {{ trans('invoice.delete') }}
							</button>		
						</td>
					</tr>					

				@endforeach
				
				</tbody>
			</table>	
		</div>	
	</div>
	
	@include('_modals/delete')
	
@stop