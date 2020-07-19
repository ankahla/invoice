<div class="modal fade" id="solsoSendEmail" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">{{ trans('invoice.mail_dialog') }}</h4>
            </div>

            <div class="modal-body">
                <p>{{ trans('invoice.mail_dialog_01') }}</p>
                <p>{{ trans('invoice.mail_dialog_02') }}<p>
            </div>

            <div class="modal-footer">

                <form class="solsoForm" id="solsoFormID" method="post">
                    @csrf
                    <button type="button" class="btn btn-primary"
                            data-dismiss="modal">{{ trans('invoice.no') }}</button>
                    <button type="submit" class="btn btn-danger pull-right">{{ trans('invoice.yes') }}</button>

                </form>

            </div>
        </div>
    </div>
</div>
