@extends('layouts.app')

@section('content')
	
	<div class="col-md-12 col-lg-12">
		<h1><i class="fa fa-plus"></i> {{ trans('invoice.translate_language') }}</h1>
	</div>		

	<form method="post" action="{{ route('translate') }}" role="form" class="solsoForm">
		@csrf
	<div class="col-md-12 col-lg-12">
	<div class="table-responsive">
		<table class="table table-striped">
			<thead>
				<tr>
					<th class="col-md-6">{{ trans('invoice.original_language') }}</th>
					<th class="col-md-6">{{ trans('invoice.translate_language') }}</th>
				</tr>
			</thead>

			<tbody>
				@foreach ($original as $k => $v)
				
				<tr>
					<td>
						{{ $v['original'] }}
					</th>
					
					<td>
						<input type="text" name="words[{{ $k }}]" class="form-control required" value="{{ isset($translated[$k]) ? $translated[$k] : $v['translated'] }}">
					</th>
				</tr>
				
				@endforeach
			</tbody>	
			
			<tfoot>
				<tr>
					<td colspan="2">
						<input type="hidden" name="languageID" value="{{ Request::segment(2) }}">
						<button type="submit" class="btn btn-success btn-lg"><i class="fa fa-save"></i> {{ trans('invoice.save') }}</button>
					</td>
				</tr>
			</tfoot>
		</table>		
	</div>	
	</div>	

	</form>
	
@stop
