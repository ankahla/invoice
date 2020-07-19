<div class="modal fade" id="solsoAddPayment" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">{{ trans('invoice.add_payment') }}</h4>
            </div>

            <form class="solsoForm" id="solsoFormID" method="post">
                @csrf
                <div class="modal-body">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="amount">{{ trans('invoice.amount_paid') }}</label>
                            <input type="text" name="amount" class="form-control required" autocomplete="off"
                                   data-parsley-type="number">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="date">{{ trans('invoice.date') }}</label>
                            <input type="text" name="date" class="form-control datepicker required" autocomplete="off">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="payment">{{ trans('invoice.payment_method') }}</label>
                            <select name="payment" class="form-control required">
                                <option value="" selected>choose</option>

                                @foreach ($payments as $v)
                                    <option value="{{ $v->id }}"> {{ $v->name }} </option>
                                @endforeach

                            </select>
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
