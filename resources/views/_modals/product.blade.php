<div class="modal fade" id="solsoInfoProduct" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">{{ trans('invoice.product_information') }}</h4>
        </div>

        <div class="modal-body">
            <h2 class="product-name">{{ trans('invoice.item') }}</h2>
            <p>{{ trans('invoice.price') }}: {{ $currency->position == 1 ? $currency->name : '' }} <span class="product-price"></span> {{ $currency->position == 2 ? $currency->name : '' }} </p>
            <p>{{ trans('invoice.description') }}: <span class="product-description"></span></p>
        </div>

        <div class="modal-footer">
			<button type="button" class="btn btn-primary" data-dismiss="modal">{{ trans('invoice.ok') }}</button>
        </div>
    </div>
</div>
</div>
