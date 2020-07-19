<div class="col-md-6 col-lg-4">
    <h3>{{ trans('invoice.application_type') }}</h3>

    <form action="admin/application" method="post" role="form" class="solsoForm">
        @csrf
        <div class="btn-group" role="group" aria-label="...">
            <div class="btn-group" data-toggle="buttons">
                <label class="btn btn-default {{ $app->type == 1 ? 'active' : '' }} ">
                    <input type="radio" name="value" autocomplete="off"
                           value="1" {{ $app->type == 1 ? "checked='checked'" : '' }}> {{ trans('invoice.single_user') }}
                </label>

                <label class="btn btn-default {{ $app->type == 2 ? 'active' : '' }} ">
                    <input type="radio" name="value" autocomplete="off"
                           value="2" {{ $app->type == 2 ? "checked='checked'" : '' }}> {{ trans('invoice.multi_user') }}
                </label>
            </div>

            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> {{ trans('invoice.save') }}
            </button>
        </div>

    </form>


    <h3>{{ trans('invoice.default_language') }}</h3>

    <form action="setting/defaultLanguage" method="post" role="form" class="solsoForm">
        @csrf
        <div class="input-group">
            <select name="language" class="form-control required solsoSelect2"
                    data-parsley-errors-container=".chooseLang">

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

            <span class="input-group-btn">
				<button type="submit" class="btn btn-primary"><i
                            class="fa fa-save"></i> {{ trans('invoice.save') }}</button>
			</span>
        </div>

        <div class="chooseLang"></div>

    </form>
</div>	