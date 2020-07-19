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
use App\Model\Invoice;
use App\Model\Product;
use App\Model\Report;
use App\Model\UserSetting;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $invoice = new Invoice();
        $receivedInvoices = $invoice->invoicesReceived();

        if (3 !== Auth::user()->role_id) {
            $invoice = new Invoice();
            $reports = new Report();
            $check = new UserSetting();
            $invoice->invoiceStatus();

            $data = [
                'clients' => Client::where('user_id', Auth::id())->count(),
                'products' => Product::where('user_id', Auth::id())->where('status', 1)->count(),
                'invoices' => Invoice::where('user_id', Auth::id())->count(),
                'totalAmount' => Invoice::where('user_id', Auth::id())->where('status_id', 1)->sum('amount'),
                'invoiceChart' => $invoice->invoiceChart(),
                'reports' => $reports->invoices(),
                'lastInvoices' => $invoice->lastUnpaidInvoices(),
                'overdueInvoices' => $invoice->overdueInvoices(),
                'invoicesReceived' => $receivedInvoices,
                'check' => $check->checkSettings(),
            ];

            return view('dashboard.index', $data);
        }
        $client = Client::where('email', Auth::user()->email)->first();

        $data = [
                'invoices' => $receivedInvoices,
                'totalAmount' => isset($client->id) ? Invoice::where('client_id', $client->id)->sum('amount') : 0,
                'invoicesReceived' => $receivedInvoices,
            ];

        return view('dashboard.client', $data);
    }
}
