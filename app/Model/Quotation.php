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

class Quotation extends Model
{
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function quotations()
    {
        $query = DB::table('quotations')
            ->leftJoin('clients', 'clients.id', '=', 'quotations.client_id')
            ->leftJoin('invoice_statuses', 'invoice_statuses.id', '=', 'quotations.status_id')
            ->leftJoin('currencies', 'currencies.id', '=', 'quotations.currency_id')
            ->select(
                'quotations.amount',
                'quotations.start_date',
                'quotations.due_date',
                'quotations.description as invoiceDescription',
                'clients.name as client',
                'quotations.id',
                'quotations.number',
                'invoice_statuses.name as status',
                'quotations.description',
                'currencies.id as currencyID',
                'currencies.name as currency',
                'currencies.position'
            )
            ->where('quotations.user_id', Auth::id())
            ->orderBy('due_date', 'desc')
            ->groupBy('quotations.id')
            ->get();

        return $query;
    }

    public function single($quotationID, $userID)
    {
        $query = DB::table('quotations')
            ->join('clients', 'clients.id', '=', 'quotations.client_id')
            ->join('invoice_statuses', 'invoice_statuses.id', '=', 'quotations.status_id')
            ->leftJoin('currencies', 'currencies.id', '=', 'quotations.currency_id')
            ->select(
                'quotations.id as invoiceID',
                'quotations.number',
                'quotations.amount',
                'quotations.discount',
                'quotations.revenue_stamp',
                'quotations.type',
                'quotations.start_date',
                'quotations.due_date',
                'invoice_statuses.name as status',
                'quotations.description as invoiceDescription',
                'quotations.client_id as clientID',
                'clients.*',
                'clients.name as client',
                'currencies.id as currencyID',
                'currencies.name as currency',
                'currencies.position'
            )
            ->where('quotations.id', $quotationID)
            ->where(function ($querySplit) use ($userID) {
                if ($userID) {
                    $querySplit->where('quotations.user_id', Auth::id());
                } else {
                    $client = DB::table('clients')
                        ->where('email', Auth::user()->email)
                        ->select('id')
                        ->first();

                    $querySplit->where('quotations.client_id', $client->id);
                }
            })
            ->first();
        if (!$query->invoiceDescription) {
            $invoice = new Invoice();
            $query->invoiceDescription = $invoice->int2str(number_format($query->amount, 3));
        }

        return $query;
    }

    public function lastUnpaidQuotations()
    {
        $today = new \DateTime('today');

        $query = DB::table('quotations')
            ->join('clients', 'clients.id', '=', 'quotations.client_id')
            ->leftJoin('invoice_statuses', 'invoice_statuses.id', '=', 'quotations.status_id')
            ->select(
                'quotations.id',
                'quotations.number',
                'quotations.due_date',
                'clients.name as client',
                'invoice_statuses.name as status'
            )
            ->where('quotations.user_id', Auth::id())
            ->whereIn('quotations.status_id', [2, 3])
            ->get();

        return $query;
    }

    public function overdueQuotations()
    {
        $today = new \DateTime('today');

        $query = DB::table('quotations')
            ->join('clients', 'clients.id', '=', 'quotations.client_id')
            ->select(
                'quotations.id',
                'quotations.number',
                'quotations.due_date',
                'clients.name as client'
            )
            ->where('quotations.user_id', Auth::id())
            ->where('quotations.status_id', '5')
            ->get();

        return $query;
    }

    public function quotationStatus()
    {
        $today = new \DateTime('today');

        DB::table('quotations')
            ->whereIn('status_id', [2, 3])
            ->where('due_date', '<=', $today)
            ->update(['status_id' => 5]);
    }

    public function quotationChart()
    {
        $total = Invoice::where('user_id', Auth::id())->count();

        $query = DB::table('quotations')
            ->leftJoin('invoice_statuses', 'invoice_statuses.id', '=', 'quotations.status_id')
            ->where('quotations.user_id', Auth::id())
            ->select(DB::raw('COUNT(*) as num'), 'invoice_statuses.name')
            ->groupBy('quotations.status_id')
            ->get();

        $count = $query;
        $chart = [
            'paid' => [
                'count' => 0,
                'percent' => 0,
            ],
            'unpaid' => [
                'count' => 0,
                'percent' => 0,
            ],
            'partiallypaid' => [
                'count' => 0,
                'percent' => 0,
            ],
            'cancelled' => [
                'count' => 0,
                'percent' => 0,
            ],
            'overdue' => [
                'count' => 0,
                'percent' => 0,
            ],
        ];

        foreach ($count as $v) {
            $chart[str_replace(' ', '', $v->name)] = [
                'count' => $v->num,
                'percent' => $total > 0 ? ($v->num * 100) / $total : 0,
            ];
        }

        return $chart;
    }

    public function products($quotationID, $userID)
    {
        $query = DB::table('quotation_products')
            ->join('products', 'products.id', '=', 'quotation_products.product_id')
            ->leftJoin('products_images', 'products.id', '=', 'products_images.product_id')
            ->where('quotation_products.quotation_id', $quotationID)
            ->where(function ($querySplit) use ($userID) {
                if ($userID) {
                    $querySplit->where('products.user_id', Auth::id());
                }
            })
            ->select('products.name', 'products.description', 'products_images.name as product_image', 'quotation_products.*')
            ->get();

        return $query;
    }

    public function quotationsReceived()
    {
        $client = DB::table('clients')
            ->where('email', Auth::user()->email)
            ->select('id')
            ->first();

        if (isset($client->id)) {
            $query = DB::table('quotations')
                ->leftJoin('clients', 'clients.id', '=', 'quotations.client_id')
                ->leftJoin('invoice_statuses', 'invoice_statuses.id', '=', 'quotations.status_id')
                ->leftJoin('currencies', 'currencies.id', '=', 'quotations.currency_id')
                ->select(
                    'quotations.amount',
                    'quotations.start_date',
                    'quotations.due_date',
                    'quotations.description as invoiceDescription',
                    'clients.name as client',
                    'quotations.id',
                    'quotations.number',
                    'invoice_statuses.name as status',
                    'quotations.description',
                    'currencies.id as currencyID',
                    'currencies.name as currency',
                    'currencies.position'
                )
                ->where('quotations.client_id', $client->id)
                ->orderBy('due_date', 'desc')
                ->groupBy('quotations.id')
                ->get();

            return $query;
        }

        return false;
    }

    public function totalProduct($option, $productQty, $productPrice, $productTax, $productDiscount, $discountType)
    {
        $value = $productQty * $productPrice;
        $tax = $value * ($productTax / 100);
        $price = $value + $tax;
        $discount = 0;

        if (1 === $discountType) {
            $discount = $productDiscount;
        }

        if (2 === $discountType) {
            $discount = $price * ($productDiscount / 100);
        }

        if (1 === $option) {
            return $discount;
        }

        return $price - $discount;
    }

    public function totalInvoice($productQty, $productPrice, $productTax, $productDiscount, $discountType, $invoiceDiscount, $invoiceDiscountType)
    {
        $total = 0;
        $discount = 0;

        foreach ($productQty as $k => $q) {
            $total += $this->totalProduct(2, $productQty[$k], $productPrice[$k], $productTax[$k], $productDiscount[$k], $discountType[$k]);
        }

        if (1 === $invoiceDiscountType) {
            $discount = $invoiceDiscount;
        }
        if (2 === $invoiceDiscountType) {
            $discount = $total * ($invoiceDiscount / 100);
        }

        return abs($total - $discount);
    }
}
