<div class="modal fade" id="solsoChangeDueDate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">{{ trans('invoice.invoice_change_due_date') }}</h4>
            </div>

            <form class="solsoFormID" id="solsoFormID" method="post">
                @csrf
                <div class="modal-body">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="end">{{ trans('invoice.due_date') }}</label>
                            <input type="text" name="endDate" class="form-control datepicker required"
                                   autocomplete="off">
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-warning" data-dismiss="modal"><i
                                class="fa fa-remove"></i> {{ trans('invoice.cancel') }}</button>
                    <button type="submit" class="btn btn-success pull-right"><i
                                class="fa fa-save"></i> {{ trans('invoice.save') }}</button>
                </div>

            </form>

        </div>
    </div>
</div>
