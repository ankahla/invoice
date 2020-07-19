<div class="col-md-6 col-lg-6">
    <h3>{{ trans('invoice.application_type') }}</h3>

    <form action="{{ 'user/' . Auth::id() }}" role="form" method="post">
        @method('PUT')
        @csrf


        <div class="btn-group" role="group" aria-label="...">
            <div class="btn-group" data-toggle="buttons">
                <label class="btn btn-default {{ Auth::user()->role_id == 3 ? 'active' : '' }} ">
                    <input type="radio" name="role" autocomplete="off"
                           value="3" {{ Auth::user()->role_id == 3 ? "checked='checked'" : '' }}> {{ trans('invoice.client_mode') }}
                </label>

                <label class="btn btn-default {{ Auth::user()->role_id == 2 ? 'active' : '' }} ">
                    <input type="radio" name="role" autocomplete="off"
                           value="2" {{ Auth::user()->role_id == 2 ? "checked='checked'" : '' }}> {{ trans('invoice.full_mode') }}
                </label>
            </div>

            <input type="hidden" name="action" value="role">
            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> {{ trans('invoice.save') }}
            </button>
        </div>

    </form>

</div>	