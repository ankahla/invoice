<?php

/*
 * This file is part of the Invoice project.
 * (c) Kahla Anouar <kahla.anoir@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InvoicePayment extends Model
{
    public $timestamps = false;

    public function balance($invoiceID)
    {
        $invoice = Invoice::where('user_id', Auth::id())->where('id', $invoiceID)->first();
        $payments = self::select(DB::raw('SUM(invoice_payments.payment_amount) as paid'))
            ->where('invoice_id', $invoiceID)
            ->where('user_id', Auth::id())
            ->first();

        $update = Invoice::where('user_id', Auth::id())->where('id', $invoiceID)->first();
        $update->status_id = 1;

        if ($invoice->amount !== $payments['paid']) {
            $update->status_id = 3;
        }

        $update->save();
    }

    public function payments($invoiceID)
    {
        $query = DB::table('invoice_payments')
            ->join('payments', 'payments.id', '=', 'invoice_payments.payment_id')
            ->where('invoice_payments.invoice_id', $invoiceID)
            ->where('invoice_payments.user_id', Auth::id())
            ->get();

        return $query;
    }
}
