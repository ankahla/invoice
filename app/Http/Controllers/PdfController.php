<?php

/*
 * This file is part of the Invoice project.
 * (c) Kahla Anouar <kahla.anoir@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Model\Image;
use App\Model\Invoice;
use App\Model\InvoiceSetting;
use App\Model\Quotation;
use App\Model\UserSetting;
use Barryvdh\DomPDF\PDF;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;

class PdfController extends Controller
{
    public function show($id, PDF $pdf)
    {
        $newInvoice = new Invoice();
        $invoice = $newInvoice->single($id, Request::segment(3) ? false : true);

        if ($invoice) {
            $userID = Request::segment(3) ? $invoice->user_id : Auth::id();
            $invoice->start_date = new \DateTime($invoice->start_date);
            $invoice->start_date = $invoice->start_date->format('d/m/Y');
            $data = [
                'owner' => UserSetting::where('user_id', $userID)->first(),
                'logo' => Image::where('user_id', $userID)->first(),
                'invoice' => $invoice,
                'invoiceSettings' => InvoiceSetting::where('user_id', $userID)->first(),
                'invoiceProducts' => $newInvoice->products($id, Request::segment(3) ? false : true),
            ];
        } else {
            return Redirect::to('invoice')->with('message', trans('invoice.access_denied'));
        }

        $pdf = $pdf->loadView('invoices.themes.theme_01', $data)->setPaper('letter', 'portrait');

        $pdfName = strtolower(trans('invoice.invoice')).'_'.$invoice->number.'_'.date('Y-m-d');

        return $pdf->download($pdfName.'.pdf');
    }

    public function showQuotation($id, $theme, PDF $pdf)
    {
        $newQuotation = new Quotation();
        $userID = Auth::id();
        $quotation = $newQuotation->single($id, $userID);

        if ($quotation) {
            $quotation->start_date = new \DateTime($quotation->start_date);
            $quotation->start_date = $quotation->start_date->format('d/m/Y');

            $data = [
                'owner' => UserSetting::where('user_id', $userID)->first(),
                'logo' => Image::where('user_id', $userID)->first(),
                'item' => $quotation,
                'invoiceSettings' => InvoiceSetting::where('user_id', $userID)->first(),
                'products' => $newQuotation->products($id, Request::segment(3) ? false : true),
            ];
        } else {
            return Redirect::to('quotation')->with('message', trans('invoice.access_denied'));
        }

        $pdf = $pdf->loadView('quotations.themes.'.$theme, $data)->setPaper('letter', 'portrait');
        $pdfName = strtolower(trans('invoice.quotation')).'_'.$quotation->number.'_'.date('Y-m-d');

        return $pdf->download($pdfName.'.pdf');
    }
}
