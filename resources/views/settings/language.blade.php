<div class="col-md-6 col-lg-4">
	<h3>{{ trans('invoice.default_language') }}</h3>
	
	<form action="setting/defaultLanguage" method="post" role="form" class="solsoForm">
		@csrf
		<div class="form-group">
			<select name="language" class="form-control required solsoSelect2">
				
				@if (isset($defaultLanguage->name))
					<option value="{{ $defaultLanguage->id }}" selected> {{ $defaultLanguage->name }} </option>
					<option value="">{{ trans('invoice.choose') }}</option>
				@else
					<option value="" selected>{{ trans('invoice.choose') }}</option>
				@endif	
				
				@foreach ($languages as $v)
					<option value="{{ $v->id }}"> {{ $v->name }} </option>
				@endforeach			
				
			</select>
			
			<?php echo $errors->first('language', '<p class="error">:messages</p>');?>
		</div>

		<button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> {{ trans('invoice.save') }}</button>	
	
	</form>
</div>	