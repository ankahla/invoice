<div class="col-md-12 col-lg-6">
	<h3>{{ trans('invoice.logo') }}</h3>

	@if ( isset($logo->name) )
		<div class="row">
			<img src="{{ asset('upload/' . $logo->name ) }}" class="img img-responsive thumbnail col-md-3">
		</div>

	<form action="{{ 'upload-logo/' . $logo->id }}" role="form" method="post" class="solsoForm" enctype="multipart/form-data">
		@method('PUT')
	@else	
	
		<div role="alert" class="alert alert-warning fade in top20">
			<strong>{{ trans('invoice.message') }}: </strong> {{ trans('invoice.message_logo') }}
		</div>		
	
		<form action="{{ 'upload-logo' }}" role="form" method="post" class="solsoForm" enctype="multipart/form-data">
	@endif

		<div class="form-group">
			<label for="image">{{ trans('invoice.upload_logo') }} => <span class="lowercase">{{ trans('invoice.allowed_file_extensions') }}: 'jpg', 'jpeg', 'gif', 'png', 'bmp'</span></label>
			<input type="file" name="image" class="solsoFileInput required" autocomplete="off" value="{{ old('image') }}">
		</div>

		<?php echo $errors->first('image', '<p class="error">:messages</p>');?>
		@csrf
		</form>

</div>