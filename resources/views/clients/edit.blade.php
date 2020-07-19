@extends('layouts.app')

@section('content')
			
	<div class="col-md-12 col-lg-12">
		<h1><i class="fa fa-edit"></i> {{ trans('invoice.edit') }}</h1>
	</div>		

		<form action="{{ URL::to('client/' . Request::segment(2)) }}" role="form" method="post" class="solsoForm">
			@method('PUT')
			@csrf


		<div class="col-md-6 col-lg-3">
			<div class="form-group">
				<label for="name">{{ trans('invoice.name') }}</label>
				<input type="text" name="name" class="form-control required" autocomplete="off" value="{{ old('name') ? old('name') : $client->name }}">
				
				<?php echo $errors->first('name', '<p class="error">:messages</p>');?>
			</div>		

			<div class="form-group">
				<label for="country">{{ trans('invoice.country') }}</label>
				<input type="text" name="country" class="form-control required" autocomplete="off" value="{{ old('country') ? old('country') : $client->country }}">
				
				<?php echo $errors->first('country', '<p class="error">:messages</p>');?>
			</div>		

			<div class="form-group">
				<label for="state">{{ trans('invoice.province_state') }}</label>
				<input type="text" name="state" class="form-control" autocomplete="off" value="{{ old('state') ? old('state') : $client->state }}">
				
				<?php echo $errors->first('state', '<p class="error">:messages</p>');?>
			</div>			
			
			<div class="form-group">
				<label for="city">{{ trans('invoice.city') }}</label>
				<input type="text" name="city" class="form-control required" autocomplete="off" value="{{ old('city') ? old('city') : $client->city }}">
				
				<?php echo $errors->first('city', '<p class="error">:messages</p>');?>
			</div>

			<div class="form-group">
				<label for="zip">{{ trans('invoice.zip_code') }}</label>
				<input type="text" name="zip" class="form-control required" autocomplete="off" value="{{ old('zip') ? old('zip') : $client->zip }}">
				
				<?php echo $errors->first('zip', '<p class="error">:messages</p>');?>
			</div>

			<div class="form-group">
				<label for="address">{{ trans('invoice.address') }}</label>
				<input type="text" name="address" class="form-control required" autocomplete="off" value="{{ old('address') ? old('address') : $client->address }}">
				
				<?php echo $errors->first('address', '<p class="error">:messages</p>');?>
			</div>				
		</div>
		
		<div class="col-md-6 col-lg-3">		
			<div class="form-group">
				<label for="contact">{{ trans('invoice.contact') }}</label>
				<input type="text" name="contact" class="form-control required" autocomplete="off" value="{{ old('contact') ? old('contact') : $client->contact }}">
				
				<?php echo $errors->first('contact', '<p class="error">:messages</p>');?>
			</div>				
			
			<div class="form-group">
				<label for="phone">{{ trans('invoice.phone') }}</label>
				<input type="text" name="phone" class="form-control required" autocomplete="off" value="{{ old('phone') ? old('phone') : $client->phone }}">
				
				<?php echo $errors->first('phone', '<p class="error">:messages</p>');?>
			</div>	

			<div class="form-group">
				<label for="email">{{ trans('invoice.email') }} => <span class="lowercase">{{ trans('invoice.receive_emails_from_your_company') }}</span></label>
				<input type="email" name="email" class="form-control required" autocomplete="off" 
				title="Infomation" data-popover="popover" data-placement="top" data-content="{{ trans('invoice.receive_emails_from_your_company') }}"
				value="{{ old('email') ? old('email') : $client->email }}">
				
				<?php echo $errors->first('email', '<p class="error">:messages</p>');?>
			</div>		

			<div class="form-group">
				<label for="website">{{ trans('invoice.website') }}</label>
				<input type="url" name="website" class="form-control" autocomplete="off" value="{{ old('website') ? old('website') : $client->website }}">
				
				<?php echo $errors->first('website', '<p class="error">:messages</p>');?>
			</div>	

			<div class="form-group">
				<label for="bank"> {{ trans('invoice.bank') }} </label>
				<input type="text" name="bank" class="form-control" autocomplete="off" value="{{ old('bank') ? old('bank') : $client->bank }}">
			</div>	

			<div class="form-group">
				<label for="bank_account"> {{ trans('invoice.bank_account') }} </label>
				<input type="text" name="bank_account" class="form-control" autocomplete="off" value="{{ old('bank_account', $client->bank_account) }}">
			</div>			
		</div>
		<div class="clearfix"></div>
		
		<div class="col-md-12 col-lg-6">
			<div class="form-group">
				<label for="description">{{ trans('invoice.description') }}</label>
				<textarea name="description" class="form-control" rows="7" autocomplete="off">{{ old('description', $client->description) }}</textarea>
			</div>	
		</div>
		
		<div class="form-group col-md-12">
			<button type="submit" class="btn btn-success btn-lg"><i class="fa fa-save"></i> {{ trans('invoice.save') }}</button>	
		</div>

		</form>

@stop


