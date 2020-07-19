@extends('layouts.app')

@section('content')

	<div class="col-md-12 col-lg-12">
		<h1><i class="fa fa-plus"></i> {{ trans('invoice.new_language') }}</h1>
	</div>	
	
	{{ Form::open(array('url' => 'language', 'role' => 'form', 'class' => 'solsoForm')) }}
		
		<div class="col-md-6 col-lg-3">
			<div class="form-group">
				<label for="name">{{ trans('invoice.name') }}</label>
				<input type="text" name="name" class="form-control required" autocomplete="off" value="{{ old('name') }}">

				<?php echo $errors->first('name', '<p class="error">:messages</p>');?>
			</div>		
		</div>
		<div class="clearfix"></div>
		
		<div class="col-md-6 col-lg-3">
			<div class="form-group">
				<label for="short_name">{{ trans('invoice.short_name') }}</label>
				<input type="text" name="short_name" class="form-control required" autocomplete="off" value="{{ old('short_name') }}">

				<?php echo $errors->first('short_name', '<p class="error">:messages</p>');?>
				
				@if (Session::has('validationMessage'))
				
					<p class="error">
						{{ Session::get('validationMessage') }}
					</p>		
					{{ Session::forget('validationMessage') }}
					
				@endif				
			</div>		
		</div>
		<div class="clearfix"></div>
		
		<div class="form-group col-md-12">
			<button type="submit" class="btn btn-success btn-lg"><i class="fa fa-save"></i> {{ trans('invoice.save') }}</button>	
		</div>
		
	{{ Form::close() }}
	
@stop