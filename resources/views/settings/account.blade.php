<div class="col-md-6 col-lg-4">
	<h3>Change user</h3>

	<form action="{{ 'user/' . Auth::id() }}" method="post" role="form" class="solsoForm">
		@method('PUT')
		@csrf
	<div class="form-group">
		<label for="email">{{ trans('invoice.email') }}</label>
		
		<div class="input-group">
			<span class="input-group-addon"><i class="fa fa-envelope"></i></span>
			<input type="email" name="email" class="form-control required email" id="email" placeholder="email address" autocomplete="off" 
			data-parsley-errors-container=".group1">
		</div>

		<div class="group1"></div>
		<?php echo $errors->first('email', '<p class="error">:messages</p>');?>
	</div>

	<div class="form-group">
		<label for="repeat-email">{{ trans('invoice.repeat_email') }}</label>
		
		<div class="input-group">
			<span class="input-group-addon"><i class="fa fa-envelope"></i></span>
			<input type="email" name="repeat-email" class="form-control required email" id="repeat-email" placeholder="repeat email address" autocomplete="off" 
			data-parsley-equalto="#email" data-parsley-errors-container=".group2">
		</div>

		<div class="group2"></div>
		<?php echo $errors->first('repeat-email', '<p class="error">:messages</p>');?>
	</div>

	<div class="form-group">
		<input type="hidden" name="action" value="email">
		<button type="submit" class="btn btn-success" type="button"><i class="fa fa-save"></i> {{ trans('invoice.save') }}</button>
	</div>	
	
	</form>
</div>