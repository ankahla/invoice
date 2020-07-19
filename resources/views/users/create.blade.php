@extends('layouts.app')

@section('content')

	<div class="col-md-12 col-lg-12">
		<h1><i class="fa fa-plus"></i> {{ trans('invoice.create_new_account') }} </h1>
	</div>	

		<form action="{{URL::to('user')}}" class="solsoForm" role="form" method="post">
			@csrf
		<div class="col-md-6 col-lg-3">
			<div class="form-group">
				<label for="name"> {{ trans('invoice.email') }} </label>
				<input type="email" name="email" class="form-control required" autocomplete="off" value="{{ old('email') }}">

				<?php echo $errors->first('name', '<p class="error">:messages</p>');?>
			</div>		

			<div class="form-group">
				<label for="password"> {{ trans('invoice.password') }} </label>
				<input type="password" name="password" class="form-control required" autocomplete="off" value="">

				<?php echo $errors->first('password', '<p class="error">:messages</p>');?>
			</div>
            
            <div class="form-group">
				<label for="password_repeat"> {{ trans('invoice.repeat_password') }} </label>
				<input type="password" name="password_repeat" class="form-control required" autocomplete="off" value="">

				<?php echo $errors->first('password', '<p class="error">:messages</p>');?>
			</div>

			<div class="form-group">
				<label for="state"> {{ trans('invoice.role') }} </label>
                <select name="role_id" class="form-control required">
                <option value="1">Administrateur</option>
                <option value="2">Utilisteur</option>
                </select>
				
				<?php echo $errors->first('role_id', '<p class="error">:messages</p>');?>
			</div>			
		
		<div class="form-group col-md-12">
			<button type="submit" class="btn btn-success btn-lg"><i class="fa fa-save"></i> {{ trans('invoice.save') }} </button>	
		</div>

		</form>
	
@stop