@extends('layouts.app')

@section('content')

    <div class="col-md-12 col-lg-12">
        <h1><i class="fa fa-plus"></i> {{ trans('invoice.new_quotation') }}</h1>
    </div>

    <form action="{{URL::to('quotation')}}" role="form" method="post" class="solsoForm">
        @csrf
        <div class="col-md-6 col-lg-3">
            <div class="form-group">
                <label for="client">{{ trans('invoice.client') }}</label>
                <select name="client" class="form-control required solsoSelect2">
                    <option value="" selected>choose</option>

                    @foreach ($clients as $v)
                        <option value="{{ $v->id }}"> {{ $v->name }} </option>
                    @endforeach

                </select>

                <?php echo $errors->first('client', '<p class="error">:messages</p>');?>
            </div>
        </div>

        <div class="col-md-3 col-lg-3">
            <div class="form-group">
                <label for="number">{{ trans('invoice.quotation_number') }}</label>
                <div class="input-group">
                    <span class="input-group-addon solso-pre">{{ $invoiceCode }}</span>
                    <input type="text" name="number" class="form-control required no-line" autocomplete="off"
                           value="{{ $invoiceNumber ? $invoiceNumber : old('number') }}">
                </div>

                <?php echo $errors->first('number', '<p class="error">:messages</p>');?>
            </div>
        </div>
        <div class="clearfix"></div>

        <div class="col-md-3 col-lg-3">
            <div class="form-group">
                <label for="currency">{{ trans('invoice.currency') }}</label>
                <select name="currency" class="form-control required solsoCurrencyEvent">
                    <option value="" selected>{{ trans('invoice.choose') }}</option>

                    @foreach ($currencies as $v)
                        <option value="{{ $v->id }}"> {{ $v->name }} </option>
                    @endforeach

                </select>

                <?php echo $errors->first('currency', '<p class="error">:messages</p>');?>
            </div>
        </div>

        <div class="col-md-3 col-lg-3">
            <div class="form-group">
                <label for="date">{{ trans('invoice.date') }}</label>
                <input type="text" name="startDate" class="form-control datepicker required" autocomplete="off"
                       value="{{ old('startDate') }}">

                <?php echo $errors->first('startDate', '<p class="error">:messages</p>');?>
            </div>
        </div>

        <div class="col-md-3 col-lg-3">
            <div class="form-group">
                <label for="end">{{ trans('invoice.due_date') }}</label>
                <input type="text" name="endDate" class="form-control datepicker required" autocomplete="off"
                       value="{{ old('endDate') }}">

                <?php echo $errors->first('endDate', '<p class="error">:messages</p>');?>
            </div>
        </div>
        <div class="clearfix"></div>

        <div class="table-responsive">
            <div class="col-md-12 col-lg-12">
                <table class="table">
                    <thead>
                    <tr>
                        <th>{{ trans('invoice.crt') }}.</th>
                        <th class="col-md-5">{{ trans('invoice.product') }}</th>
                        <th class="col-md-1">{{ trans('invoice.quantity') }}</th>
                        <th class="col-md-1">{{ trans('invoice.price') }}</th>
                        <th class="col-md-1">{{ trans('invoice.tax_rate') }}</th>
                        <th class="col-md-1">{{ trans('invoice.discount') }}</th>
                        <th class="col-md-1">{{ trans('invoice.type') }}</th>
                        <th class="col-md-1">{{ trans('invoice.subtotal') }}</th>
                        <th class="xs-small">{{ trans('invoice.action') }}</th>
                    </tr>
                    </thead>

                    <tbody class="solsoParent">
                    <tr class="solsoChild">
                        <td class="crt">1</td>

                        <td>
                            <select name="products[]" class="form-control required solsoSelect2 solsoCloneSelect2">
                                <option value="" selected>{{ trans('invoice.choose') }}</option>

                                @foreach ($products as $v)
                                    <option value="{{ $v->id }}"> {{ substr($v->name, 0, 100) }} {{ strlen($v->name) > 100 ? '...' : '' }} </option>
                                @endforeach

                            </select>
                        </td>

                        <td>
                            <input type="text" name="qty[]" class="form-control required solsoEvent" autocomplete="off" value="1">
                        </td>

                        <td>
                            <input type="text" name="price[]" class="form-control required solsoEvent"
                                   autocomplete="off">
                        </td>

                        <td>
                            <select name="taxes[]" class="form-control required solsoEvent">
                                <option value="" selected>{{ trans('invoice.choose') }}</option>

                                @foreach ($taxes as $v)
                                    <option value="{{ $v->value }}"> {{ $v->value }} %</option>
                                @endforeach

                            </select>
                        </td>

                        <td>
                            <input type="text" name="discount[]" class="form-control" autocomplete="off">
                        </td>

                        <td>
                            <select name="discountType[]" class="form-control solsoEvent">
                                <option value="" selected>{{ trans('invoice.choose') }}</option>
                                <option value="1">{{ trans('invoice.amount') }}</option>
                                <option value="2">%</option>
                            </select>
                        </td>

                        <td>
                            <h4 class="pull-right">
                                <span class="solsoSubTotal">0.000</span>
                            </h4>
                        </td>

                        <td>
                            <button type="button" class="btn btn-danger disabled removeClone"><i
                                        class="fa fa-minus"></i></button>
                        </td>
                    </tr>
                    </tbody>

                    <tfoot>
                    <tr>
                        <td colspan="5">
                            <div class="col-md-12 col-lg-3 form-inline">
                                <label for="end" class="show">{{ trans('invoice.invoice_discount') }}</label>
                                <input type="text" name="quotationDiscount" class="form-control" autocomplete="off">

                                <select name="quotationDiscountType" class="form-control solsoEvent">
                                    <option value="" selected>{{ trans('invoice.choose') }}</option>
                                    <option value="1">{{ trans('invoice.amount') }}</option>
                                    <option value="2">%</option>
                                </select>
                            </div>
                            <div class="col-md-12 col-lg-6 form-inline">
                                <label for="end" class="show">{{ trans('invoice.revenue_stamp') }}</label>
                                <input type="text" name="revenue_stamp" class="form-control solsoEvent"
                                       autocomplete="off" value="0.500">
                            </div>
                        </td>

                        <td colspan="2">
                            <h3 class="pull-right top10">{{ trans('invoice.total') }}</h3>
                        </td>

                        <td colspan="2">
                            <h3 class="top10">
                                <span class="solsoTotal">0.000</span>
                                <span class="solsoCurrency"></span>
                            </h3>
                        </td>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <div class="form-group col-md-12 top20 text-center">
            <button type="button" class="btn btn-primary btn-lg" id="createClone"><i
                        class="fa fa-plus"></i> {{ trans('invoice.add_new_product') }}</button>
        </div>

        <div class="form-group col-md-12">
            <button type="submit" class="btn btn-success btn-lg"><i
                        class="fa fa-save"></i> {{ trans('invoice.create_quotation') }}</button>
        </div>

    </form>

@stop