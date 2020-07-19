@extends('layouts.app')

@section('content')
	<div class="col-md-12 col-lg-12">
		<h1><i class="fa fa-users"></i> {{ trans('invoice.users') }}</h1>
        <a href="user/create" class="btn btn-primary"><i class="fa fa-plus"></i> {{ trans('invoice.create_new_account') }}</a
	></div>

	<div class="col-md-12 col-lg-12 top40">
		<h3>{{ trans('invoice.users') }}</h3>

		<div class="table-responsive">
			<table class="table solsoTable">
				<thead>
					<tr>
						<th>{{ trans('invoice.crt') }}</th>
						<th>{{ trans('invoice.email') }}</th>
						<th class="col-md-2">{{ trans('invoice.created_at') }}</th>
						<th class="small">{{ trans('invoice.action') }}</th>
					</tr>
				</thead>

				<tbody>

				@foreach ($users as $crt => $v)

					<tr>
						<td>
							{{ $crt+1 }}
						</td>

						<td>
							{{ $v->email }}
						</td>

						<td>
							{{ $v->created_at }}
						</td>

						<td>
							@if ($v->status == 0)
								<form action="{{ 'admin/' . $v->id }}" role="form" class="solsoForm" method="post">
									@method('PUT')
									@csrf
									<button type="submit" class="btn solso-pdf"><i class="fa fa-check"></i> {{ trans('invoice.approve') }}</button>
								</form>
							@elseif ($v->status == 1 && $v->role_id != 1)
								<a  class="btn btn-warning solsoConfirm" data-toggle="modal" data-target="#solsoBanAccount" data-url="{{ URL::to('admin/' . $v->id) }}"><i class="fa fa-ban"></i> {{ trans('invoice.ban') }}</a>
							@elseif ($v->role_id != 1)
								<form action="{{ 'admin/' . $v->id }}" role="form" class="solsoForm" method="post">
									@method('PUT')
									@csrf
									<button type="submit" class="btn btn-success"><i class="fa fa-check"></i> {{ trans('invoice.remove_ban') }}</button>
								</form>
							@endif
						</td>
					</tr>

				@endforeach

				</tbody>
			</table>
		</div>
	</div>

	@include('_modals/ban')

@stop