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

class Client extends Model
{
    public function userClients()
    {
        $query = DB::table('clients')
                ->leftJoin('invitations', 'invitations.client_id', '=', 'clients.id')
                ->select(
                    'clients.*',
                    'invitations.status'
                )
                ->where('clients.user_id', Auth::id())
                ->get();

        return $query;
    }

    public function details($clientID)
    {
        $query = DB::table('clients')
                ->leftJoin('invoices', 'invoices.client_id', '=', 'clients.id')
                ->leftJoin('invoice_statuses', 'invoice_statuses.id', '=', 'invoices.status_id')
                ->leftJoin('invoice_payments', 'invoice_payments.invoice_id', '=', 'invoices.id')
                ->select(
                    'clients.name as client',
                    'invoices.id',
                    'invoices.number',
                    'invoices.amount',
                    'invoices.due_date',
                    'invoice_statuses.name as status',
                    DB::raw('SUM(invoice_payments.payment_amount) as paid')
                )
                ->where('clients.id', $clientID)
                ->where('clients.user_id', Auth::id())
                ->groupBy('invoices.id')
                ->get();

        return $query;
    }
}
