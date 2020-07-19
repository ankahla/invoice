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
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class EmailController extends Controller
{
    protected $layout = 'index';

    public function show($id, PDF $pdf)
    {
        $invoice = new Invoice();
        $single = $invoice->single($id, true);

        $data = [
            'owner' => UserSetting::where('user_id', Auth::id())->first(),
            'logo' => Image::where('user_id', Auth::id())->first(),
            'invoice' => $single,
            'invoiceSettings' => InvoiceSetting::where('user_id', Auth::id())->first(),
            'invoiceProducts' => $invoice->products($id, true),
        ];

        $pdfDir = 'pdf';

        if (!Storage::exists($pdfDir)) {
            Storage::makeDirectory($pdfDir);
        }

        $pathToFile = sprintf('%sinvoice_%s_%s.pdf', $pdfDir, $single->number, date('Y-m-d'));
        $pdf = $pdf->loadView('invoices.themes.theme_01', $data)->setPaper('letter', 'portrait');

        Storage::put($pathToFile, $pdf->output());

        $contactEmail = $single->email;
        $userDetails = UserSetting::where('user_id', Auth::id())->first();
        $userEmail = $userDetails->email;

        $values = [
            'text' => trans('invoice.new_invoice_from').$userDetails->name,
        ];

        try {
            Mail::send('emails.index', $values, function ($message) use ($userEmail, $contactEmail, $pathToFile) {
                $message->from($userEmail, trans('invoice.app_name'));
                $message->to($contactEmail)->subject(trans('invoice.new_invoice'));
                $message->attach($pathToFile);
            });
        } catch (\Swift_TransportException $e) {
            Storage::delete($pathToFile);

            return Redirect::back()->with('message', $e->getMessage());
        }

        Storage::delete($pathToFile);

        return Redirect::back()->with('message', trans('invoice.email_was_sent_to_client'));
    }

    public function showQuotation($id, PDF $pdf, $theme = 'theme_01')
    {
        $quotation = new Quotation();
        $single = $quotation->single($id, true);

        $data = [
            'owner' => UserSetting::where('user_id', Auth::id())->first(),
            'logo' => Image::where('user_id', Auth::id())->first(),
            'item' => $single,
            'invoiceSettings' => InvoiceSetting::where('user_id', Auth::id())->first(),
            'products' => $quotation->products($id, true),
        ];

        $pdfDir = 'pdf';

        if (!Storage::exists($pdfDir)) {
            Storage::makeDirectory($pdfDir);
        }

        $pathToFile = sprintf('%squotation_%s_%s.pdf', $pdfDir, $single->number, date('Y-m-d'));
        $pdf = $pdf->loadView('quotations.themes.'.$theme, $data)->setPaper('letter', 'portrait');
        $pdf->save($pathToFile);

        $contactEmail = $single->email;
        $userDetails = UserSetting::where('user_id', Auth::id())->first();
        $userEmail = $userDetails->email;

        $values = [
            'text' => trans('invoice.new_quotation_from').$userDetails->name,
        ];

        try {
            Mail::send('emails.index', $values, function ($message) use ($userEmail, $contactEmail, $pathToFile) {
                $message->from($userEmail, trans('invoice.app_name'));
                $message->to($contactEmail)->subject(trans('invoice.new_quotation'));
                $message->attach($pathToFile);
            });
        } catch (\Swift_TransportException $e) {
            Storage::delete($pathToFile);

            return Redirect::back()->with('message', $e->getMessage());
        }

        Storage::delete($pathToFile);

        return Redirect::back()->with('message', trans('invoice.email_was_sent_to_client'));
    }
}
