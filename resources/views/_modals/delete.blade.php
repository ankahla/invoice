<div class="modal fade" id="solsoDeleteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">{{ trans('invoice.delete_dialog') }}</h4>
        </div>

        <div class="modal-body">
            <p>{{ trans('invoice.procedure_is_irreversible') }}</p>
            <p>{{ trans('invoice.want_to_proceed') }}<p>
        </div>

        <div class="modal-footer">
			<form class="solsoFormID" id="solsoFormID" method="post">
                @method('DELETE')
                @csrf

				<button type="button" class="btn btn-primary" data-dismiss="modal">{{ trans('invoice.no') }}</button>
				<button type="submit" class="btn btn-danger pull-right">{{ trans('invoice.yes') }}</button>
					
            </form>

        </div>
    </div>
</div>
</div>
