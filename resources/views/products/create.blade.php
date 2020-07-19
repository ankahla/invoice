@extends('layouts.app')

@section('content')
<div class="col-md-12 col-lg-12">
  <h1><i class="fa fa-plus"></i> {{ trans('invoice.new_product') }}</h1>
</div>
<form action="{{ URL::to('product') }}" role="form" method="post" enctype="multipart/form-data" class="solsoForm">
  @csrf
<div class="col-md-12 col-lg-6">
  <div class="form-group">
    <label for="image">{{ trans('invoice.product_image') }} => <span class="lowercase">{{ trans('invoice.allowed_file_extensions') }}: 'jpg', 'jpeg', 'gif', 'png', 'bmp'</span></label>
    <input type="file" name="image" class="solsoFileInput" autocomplete="off" value="{{ old('image') }}">
  </div>
</div>
<div class="clearfix"></div>
<div class="col-md-12 col-lg-6">
  <div class="form-group">
    <label for="name">{{ trans('invoice.name') }}</label>
    <input type="text" name="name" class="form-control required" autocomplete="off" value="{{ old('name') }}">
    <?php echo $errors->first('name', '<p class="error">:messages</p>');?> </div>
</div>
<div class="clearfix"></div>
<div class="col-md-6 col-lg-3">
  <div class="form-group">
    <label for="code">{{ trans('invoice.code') }}</label>
    <input type="text" name="code" class="form-control required" autocomplete="off" value="{{ old('code') }}">
    <?php echo $errors->first('code', '<p class="error">:messages</p>');?> </div>
</div>
<div class="col-md-6 col-lg-3">
  <div class="form-group">
    <label for="price">{{ trans('invoice.price') }}</label>
    <input type="text" name="price" class="form-control required" autocomplete="off" value="{{ old('price') }}">
    <?php echo $errors->first('price', '<p class="error">:messages</p>');?> </div>
</div>
<div class="clearfix"></div>
<div class="col-md-12 col-lg-6">
  <div class="form-group">
    <label for="description">{{ trans('invoice.description') }}</label>
    <textarea name="description" class="form-control" rows="7" autocomplete="off">{{ old('description') }}</textarea>
    <?php echo $errors->first('description', '<p class="error">:messages</p>');?> </div>
</div>
<div class="form-group col-md-12">
  <button type="submit" class="btn btn-success btn-lg"><i class="fa fa-save"></i> {{ trans('invoice.save') }}</button>
</div>
</form>
	
@stop