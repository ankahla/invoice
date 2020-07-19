<?php

/*
 * This file is part of the Invoice project.
 * (c) Kahla Anouar <kahla.anoir@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Model\Client;
use App\Model\Currency;
use App\Model\Image;
use App\Model\Invoice;
use App\Model\InvoicePayment;
use App\Model\InvoiceProduct;
use App\Model\InvoiceReceived;
use App\Model\InvoiceSetting;
use App\Model\InvoiceStatus;
use App\Model\Payment;
use App\Model\Product;
use App\Model\Quotation;
use App\Model\QuotationProduct;
use App\Model\Tax;
use App\Model\UserSetting;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;

class QuotationController extends Controller
{
    /* === VIEW === */
    public function index()
    {
        $quotations = new Quotation();
        $check = new UserSetting();

        $data = [
            'quotations' => $quotations->quotations(),
            'invoiceSettings' => InvoiceSetting::where('user_id', Auth::id())->first(),
            'clients' => Client::where('user_id', Auth::id())->count(),
            'products' => Product::where('user_id', Auth::id())->where('status', 1)->count(),
            'payments' => Payment::where('user_id', Auth::id())->get(),
            'status' => InvoiceStatus::all(),
            'check' => $check->checkSettings(),
        ];

        return view('quotations.index', $data);
    }

    public function create()
    {
        $invoiceSettings = InvoiceSetting::where('user_id', Auth::id())->first();

        $data = [
            'clients' => Client::where('user_id', Auth::id())->get(),
            'products' => Product::where('user_id', Auth::id())->where('status', 1)->get(),
            'currencies' => Currency::where('user_id', Auth::id())->get(),
            'taxes' => Tax::where('user_id', Auth::id())->get(),
            'payments' => Payment::where('user_id', Auth::id())->get(),
            'invoiceCode' => isset($invoiceSettings->code) ? $invoiceSettings->code : false,
            'invoiceNumber' => isset($invoiceSettings->number) ? $invoiceSettings->number + 1 : false,
        ];

        return view('quotations.create', $data);
    }

    public function show($id)
    {
        $newQuotation = new Quotation();
        $quotation = $newQuotation->single($id, Request::segment(3) ? false : true);

        if ($quotation) {
            $userID = Request::segment(3) ? $quotation->user_id : Auth::id();
            $quotation->start_date = new \DateTime($quotation->start_date);
            $quotation->start_date = $quotation->start_date->format('d/m/Y');
            $data = [
                'owner' => UserSetting::where('user_id', $userID)->first(),
                'logo' => Image::where('user_id', $userID)->first(),
                'quotation' => $quotation,
                'invoiceSettings' => InvoiceSetting::where('user_id', $userID)->first(),
                'invoiceProducts' => $newQuotation->products($id, Request::segment(3) ? false : true),
            ];

            return view('quotations.show', $data);
        }
        Auth::logout();

        return Redirect::to('login')->with('message', trans('quotation.access_denied'));
    }

    public function edit($id)
    {
        $newQuotation = new Quotation();
        $quotation = $newQuotation->single($id, true);
        if ($quotation) {
            $data = [
                'quotation' => $quotation,
                'invoiceCode' => InvoiceSetting::where('user_id', Auth::id())->first(),
                'clients' => Client::where('user_id', Auth::id())->get(),
                'client' => Quotation::find($id)->client,
                'quotationProducts' => $newQuotation->products($id, true),
                'products' => Product::where('user_id', Auth::id())->where('status', 1)->get(),
                'currencies' => Currency::where('user_id', Auth::id())->get(),
                'taxes' => Tax::where('user_id', Auth::id())->get(),
                'payments' => Payment::where('user_id', Auth::id())->get(),
            ];

            return view('quotations.edit', $data);
        }
        //Auth::logout();

        return Redirect::to('login')->with('message', trans('quotation.access_denied'));
    }

    /* === END VIEW === */

    /* === C.R.U.D. === */
    public function store(HttpRequest $request)
    {
        $rules = [
            'client' => 'required',
            'number' => 'required',
            'currency' => 'required',
            'startDate' => 'required',
            'endDate' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->passes()) {
            $invoiceSettings = InvoiceSetting::where('user_id', Auth::id())->first();

            if (isset($invoiceSettings->number)) {
                $invoiceNumber = $invoiceSettings->number + 1;
                $invoiceSettings->number = $invoiceNumber;
                $invoiceSettings->save();
            }
            $invoice = new Invoice();
            $store = new Quotation();
            $store->user_id = Auth::id();
            $store->client_id = $request->get('client');
            $store->status_id = 2;
            $store->currency_id = $request->get('currency');
            $store->number = isset($invoiceSettings->number) ? $invoiceNumber : $request->get('number');
            $store->discount = $request->get('quotationDiscount') ? $request->get('quotationDiscount') : 0;
            $store->type = $request->get('quotationDiscountType') ? $request->get('quotationDiscountType') : 0;
            $store->amount = $store->totalInvoice($request->get('qty'), $request->get('price'), $request->get('taxes'), $request->get('discount'), $request->get('discountType'), $request->get('quotationDiscount'), $request->get('quotationDiscountType'));
            $revenue_stamp = $request->get('revenue_stamp') ? $request->get('revenue_stamp') : 0;
            $store->revenue_stamp = $revenue_stamp;
            $store->amount += $revenue_stamp;
            $store->start_date = $request->get('startDate');
            $store->due_date = $request->get('endDate');
            $store->description = $invoice->int2str(number_format($store->amount, 3));
            //$store->description		= $request->get('description');
            $store->save();

            $products = $request->get('products');

            foreach ($products as $k => $v) {
                $product = new QuotationProduct();
                $product->user_id = Auth::id();
                $product->quotation_id = $store->id;
                $product->product_id = $v;
                $product->quantity = $request->get('qty')[$k];
                $product->price = $request->get('price')[$k];
                $product->tax = $request->get('taxes')[$k];
                $product->discount = $request->get('discount')[$k] ? $request->get('discount')[$k] : 0;
                $product->discount_type = $request->get('discountType')[$k] ? $request->get('discountType')[$k] : 0;
                $product->discount_value = $store->totalProduct(1, $request->get('qty')[$k], $request->get('price')[$k], $request->get('taxes')[$k], $request->get('discount')[$k], $request->get('discountType')[$k]);
                $product->amount = $store->totalProduct(2, $request->get('qty')[$k], $request->get('price')[$k], $request->get('taxes')[$k], $request->get('discount')[$k], $request->get('discountType')[$k]);
                $product->save();
            }

            if ($request->get('paymentAmount') && $request->get('paymentDate') && $request->get('paymentMethod')) {
                $payment = new InvoicePayment();
                $payment->user_id = Auth::id();
                $payment->quotation_id = $store->id;
                $payment->payment_id = $request->get('paymentMethod');
                $payment->payment_date = $request->get('paymentDate');
                $payment->payment_amount = $request->get('paymentAmount');
                $payment->save();

                $payment->balance($store->id);
            }

            $quotation = new Quotation();
            $quotation->quotationStatus();

            $email = Client::where('id', $request->get('client'))->first();
            $user = UserSetting::where('email', $email->email)->first();
        } else {
            return Redirect::to('quotation/create')->with('message', trans('invoice.validation_error_messages'))->withErrors($validator)->withInput();
        }

        return Redirect::to('quotation')->with('message', trans('invoice.data_was_saved'));
    }

    public function update(HttpRequest $request, $id)
    {
        $rules = [
            'client' => 'required',
            'number' => 'required',
            'currency' => 'required',
            'startDate' => 'required',
            'endDate' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->passes()) {
            $delete = QuotationProduct::where('user_id', Auth::id())->where('quotation_id', $id);
            $delete->delete();
            $invoice = new Invoice();
            $update = Quotation::where('id', $id)->where('user_id', Auth::id())->first();
            $update->client_id = $request->get('client');
            $update->currency_id = $request->get('currency');
            $update->number = $request->get('number');
            $update->discount = $request->get('quotationDiscount') ? $request->get('quotationDiscount') : 0;
            $update->type = $request->get('quotationDiscountType') ? $request->get('quotationDiscountType') : 0;
            $update->amount = $update->totalInvoice($request->get('qty'), $request->get('price'), $request->get('taxes'), $request->get('discount'), $request->get('discountType'), $request->get('quotationDiscount'), $request->get('quotationDiscountType'));
            $revenue_stamp = $request->get('revenue_stamp') ? $request->get('revenue_stamp') : 0;
            $update->revenue_stamp = $revenue_stamp;
            $update->amount += $revenue_stamp;
            $update->start_date = $request->get('startDate');
            $update->due_date = $request->get('endDate');
            $update->description = $invoice->int2str(number_format($update->amount, 3));
            //$update->description	= $request->get('description');
            $update->save();

            $products = $request->get('products');

            foreach ($products as $k => $v) {
                $product = new QuotationProduct();
                $product->user_id = Auth::id();
                $product->quotation_id = $update->id;
                $product->product_id = $v;
                $product->quantity = $request->get('qty')[$k];
                $product->price = $request->get('price')[$k];
                $product->tax = $request->get('taxes')[$k];
                $product->discount = $request->get('discount')[$k] ? $request->get('discount')[$k] : 0;
                $product->discount_type = $request->get('discountType')[$k] ? $request->get('discountType')[$k] : 0;
                $product->discount_value = $update->totalProduct(1, $request->get('qty')[$k], $request->get('price')[$k], $request->get('taxes')[$k], $request->get('discount')[$k], $request->get('discountType')[$k]);
                $product->amount = $update->totalProduct(2, $request->get('qty')[$k], $request->get('price')[$k], $request->get('taxes')[$k], $request->get('discount')[$k], $request->get('discountType')[$k]);
                $product->save();
            }

            //$payment	= new InvoicePayment;
            //$payment->balance($update->id);
        } else {
            return Redirect::to('quotation/'.$id.'/edit')->with('message', trans('invoice.validation_error_messages'))->withErrors($validator)->withInput();
        }

        return Redirect::to('quotation/'.$id)->with('message', trans('invoice.data_was_updated'));
    }

    public function promote(HttpRequest $request, $id)
    {
        $newQuotation = new Quotation();
        $quotation = $newQuotation->single($id, Auth::id());

        if ($quotation) {
            $invoice = new Invoice();
            $invoice->user_id = $quotation->user_id;
            $invoice->client_id = $quotation->clientID;
            $invoice->currency_id = $quotation->currencyID;
            $invoice->status_id = 2;
            $invoice->number = $quotation->number;
            $invoice->discount = $quotation->discount;
            $invoice->type = $quotation->type;
            $invoice->amount = $quotation->amount;
            $invoice->start_date = $quotation->start_date;
            $invoice->due_date = $quotation->due_date;
            $invoice->description = $quotation->invoiceDescription;
            $invoice->save();

            $quotationProducts = $newQuotation->products($id, Auth::id());

            foreach ($quotationProducts as $k => $v) {
                $product = new InvoiceProduct();
                $product->user_id = $v->user_id;
                $product->invoice_id = $invoice->id;
                $product->product_id = $v->product_id;
                $product->quantity = $v->quantity;
                $product->price = $v->price;
                $product->tax = $v->tax;
                $product->discount = $v->discount;
                $product->discount_type = $v->discount_type;
                $product->discount_value = $v->discount_value;
                $product->amount = $v->amount;
                $product->save();
            }

            return Redirect::to('invoice/'.$invoice->id)->with('message', trans('invoice.data_was_saved'));
        }
    }

    public function destroy($id)
    {
        $delete = Quotation::where('id', $id)->where('user_id', Auth::id());
        $delete->delete();

        $delete = QuotationProduct::where('quotation_id', $id)->where('user_id', Auth::id());
        $delete->delete();

        return Redirect::to('quotation')->with('message', trans('invoice.data_was_deleted'));
    }

    /* === END C.R.U.D. === */

    /* === OTHERS === */
    public function addPayment(HttpRequest $request, $id)
    {
        $rules = [
            'amount' => 'required',
            'date' => 'required|date',
            'payment' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->passes()) {
            $store = new InvoicePayment();
            $store->user_id = Auth::id();
            $store->quotation_id = Request::segment(3);
            $store->payment_id = $request->get('payment');
            $store->payment_date = $request->get('date');
            $store->payment_amount = $request->get('amount');
            $store->save();

            $store->balance(Request::segment(3));
        } else {
            return Redirect::to('quotation')->with('message', trans('invoice.validation_error_messages'))->withErrors($validator)->withInput();
        }

        return Redirect::to('quotation')->with('message', trans('invoice.data_was_saved'));
    }

    public function storeInvoiceNumber(HttpRequest $request)
    {
        $update = InvoiceSetting::where('user_id', Auth::id())->first();

        if ($update) {
            $update->number = $request->get('value');
            $update->save();

            return Redirect::back()->with('message', trans('invoice.data_was_updated'));
        }
        $store = new InvoiceSetting();
        $store->user_id = Auth::id();
        $store->number = $request->get('value');
        $store->save();

        return Redirect::back()->with('message', trans('invoice.data_was_saved'));
    }

    public function storeInvoiceCode(HttpRequest $request)
    {
        $update = InvoiceSetting::where('user_id', Auth::id())->first();

        if ($update) {
            $update->code = $request->get('value');
            $update->save();

            return Redirect::back()->with('message', trans('invoice.data_was_updated'));
        }
        $store = new InvoiceSetting();
        $store->user_id = Auth::id();
        $store->code = $request->get('value');
        $store->save();

        return Redirect::back()->with('message', trans('invoice.data_was_saved'));
    }

    public function storeInvoiceText(HttpRequest $request)
    {
        $update = InvoiceSetting::where('user_id', Auth::id())->first();

        if ($update) {
            $update->text = $request->get('description');
            $update->save();

            return Redirect::back()->with('message', trans('invoice.data_was_updated'));
        }
        $store = new InvoiceSetting();
        $store->user_id = Auth::id();
        $store->text = $request->get('description');
        $store->save();

        return Redirect::back()->with('message', trans('invoice.data_was_saved'));
    }

    public function updateStatus(Request $request, $id)
    {
        $update = Quotation::where('id', $id)->where('user_id', Auth::id())->first();
        $update->status_id = $request->get('status');
        $update->save();

        return Redirect::to('invoice')->with('message', trans('invoice.data_was_updated'));
    }

    public function updateDueDate(HttpRequest $request, $id)
    {
        $update = Quotation::where('id', $id)->where('user_id', Auth::id())->first();
        $update->status_id = 2;
        $update->due_date = $request->get('endDate');
        $update->save();

        return Redirect::to('invoice')->with('message', trans('invoice.data_was_updated'));
    }

    public function deleteProduct(HttpRequest $request)
    {
        $delete = QuotationProduct::where('id', $request->get('id'))->where('user_id', Auth::id());
        $delete->delete();
    }

    private function markInvoiceReceived($invoiceID)
    {
        $invoice = InvoiceReceived::where('quotation_id', $invoiceID)->where('user_id', Auth::id())->first();

        if ($invoice) {
            $update = $invoice;
            $update->status = 1;
            $update->save();
        } else {
            $store = new InvoiceReceived();
            $store->quotation_id = $invoiceID;
            $store->user_id = Auth::id();
            $store->status = 1;
            $store->save();
        }
    }

    /* === END OTHERS === */
}
