<div class="col-md-6 col-lg-4">
	<h3>{{ trans('invoice.change_password') }}</h3>
	
	<form action="{{ 'user/' . Auth::id() }}" method="post" role="form" class="solsoForm">
		@method('PUT')
		@csrf
	<div class="form-group">
		<label for="old-password">{{ trans('invoice.old_password') }}</label>
		<div class="input-group">
			<span class="input-group-addon"><i class="fa fa-lock"></i></span>
			<input type="password" name="old-password" class="form-control required" id="old-password" placeholder="old password" autocomplete="off" 
			data-parsley-minlength="6" data-parsley-errors-container=".group3">
		</div>

		<div class="group3"></div>
		<?php echo $errors->first('old-password', '<p class="error">:messages</p>');?>
	</div>

	<div class="form-group">
		<label for="new-password">{{ trans('invoice.new_password') }}</label>
		<div class="input-group">
			<span class="input-group-addon"><i class="fa fa-lock"></i></span>
			<input type="password" name="new-password" class="form-control required" name="new-password" placeholder="new password" autocomplete="off" 
			data-parsley-minlength="6" data-parsley-errors-container=".group4">
		</div>

		<div class="group4"></div>
		<?php echo $errors->first('new-password', '<p class="error">:messages</p>');?>
	</div>

	<div class="form-group">
		<input type="hidden" name="action" value="password">
		<button type="submit" class="btn btn-success" type="button"><i class="fa fa-save"></i> {{ trans('invoice.save') }}</button>
	</div>	
	
	</form>
</div>