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

class Invoice extends Model
{
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function invoices()
    {
        $query = DB::table('invoices')
            ->leftJoin('clients', 'clients.id', '=', 'invoices.client_id')
            ->leftJoin('invoice_statuses', 'invoice_statuses.id', '=', 'invoices.status_id')
            ->leftJoin('currencies', 'currencies.id', '=', 'invoices.currency_id')
            ->leftJoin('invoice_payments', 'invoice_payments.invoice_id', '=', 'invoices.id')
            ->select(
                'invoices.amount',
                'invoices.start_date',
                'invoices.due_date',
                'invoices.description as invoiceDescription',
                'clients.name as client',
                'invoices.id',
                'invoices.number',
                'invoice_statuses.name as status',
                'invoices.description',
                'currencies.id as currencyID',
                'currencies.name as currency',
                'currencies.position',
                DB::raw('IFNULL(SUM(`invoice_payments`.`payment_amount`), 0) as paid')
            )
            ->where('invoices.user_id', Auth::id())
            ->orderBy('due_date', 'desc')
            ->groupBy('invoices.id')
            ->get();

        return $query;
    }

    public function single($invoiceID, $userID)
    {
        $query = DB::table('invoices')
            ->join('clients', 'clients.id', '=', 'invoices.client_id')
            ->join('invoice_statuses', 'invoice_statuses.id', '=', 'invoices.status_id')
            ->leftJoin('currencies', 'currencies.id', '=', 'invoices.currency_id')
            ->select(
                'invoices.id as invoiceID',
                'invoices.number',
                'invoices.amount',
                'invoices.discount',
                'invoices.revenue_stamp',
                'invoices.type',
                'invoices.start_date',
                'invoices.due_date',
                'invoice_statuses.name as status',
                'invoices.description as invoiceDescription',
                'invoices.client_id as clientID',
                'clients.*',
                'clients.name as client',
                'currencies.id as currencyID',
                'currencies.name as currency',
                'currencies.position'
            )
            ->where('invoices.id', $invoiceID)
            ->where(function ($querySplit) use ($userID) {
                if ($userID) {
                    $querySplit->where('invoices.user_id', Auth::id());
                } else {
                    $client = DB::table('clients')
                        ->where('email', Auth::user()->email)
                        ->select('id')
                        ->first();

                    $querySplit->where('invoices.client_id', $client->id);
                }
            })
            ->first();
        if (!$query->invoiceDescription) {
            $query->invoiceDescription = $this->int2str(number_format($query->amount, 3));
        }

        return $query;
    }

    public function lastUnpaidInvoices()
    {
        $today = new \DateTime('today');

        $query = DB::table('invoices')
            ->join('clients', 'clients.id', '=', 'invoices.client_id')
            ->leftJoin('invoice_statuses', 'invoice_statuses.id', '=', 'invoices.status_id')
            ->select(
                'invoices.id',
                'invoices.number',
                'invoices.due_date',
                'clients.name as client',
                'invoice_statuses.name as status'
            )
            ->where('invoices.user_id', Auth::id())
            ->whereIn('invoices.status_id', [2, 3])
            ->get();

        return $query;
    }

    public function overdueInvoices()
    {
        $today = new \DateTime('today');

        $query = DB::table('invoices')
            ->join('clients', 'clients.id', '=', 'invoices.client_id')
            ->select(
                'invoices.id',
                'invoices.number',
                'invoices.due_date',
                'clients.name as client'
            )
            ->where('invoices.user_id', Auth::id())
            ->where('invoices.status_id', '5')
            ->get();

        return $query;
    }

    public function invoiceStatus()
    {
        $today = new \DateTime('today');

        DB::table('invoices')
            ->whereIn('status_id', [2, 3])
            ->where('due_date', '<=', $today)
            ->update(['status_id' => 5]);
    }

    public function invoiceChart()
    {
        $total = self::where('user_id', Auth::id())->count();

        $query = DB::table('invoices')
            ->leftJoin('invoice_statuses', 'invoice_statuses.id', '=', 'invoices.status_id')
            ->where('invoices.user_id', Auth::id())
            ->select(DB::raw('COUNT(*) as num'), 'invoice_statuses.name')
            ->groupBy('invoices.status_id')
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

    public function products($invoiceID, $userID)
    {
        $query = DB::table('invoice_products')
            ->join('products', 'products.id', '=', 'invoice_products.product_id')
            ->leftJoin('products_images', 'products.id', '=', 'products_images.product_id')
            ->where('invoice_products.invoice_id', $invoiceID)
            ->where(function ($querySplit) use ($userID) {
                if ($userID) {
                    $querySplit->where('products.user_id', Auth::id());
                }
            })
            ->select('products.name', 'products.description', 'products_images.name as product_image', 'invoice_products.*')
            ->get();

        return $query;
    }

    public function invoicesReceived()
    {
        $client = DB::table('clients')
            ->where('email', Auth::user()->email)
            ->select('id')
            ->first();

        if (isset($client->id)) {
            $query = DB::table('invoices')
                ->leftJoin('clients', 'clients.id', '=', 'invoices.client_id')
                ->leftJoin('invoice_statuses', 'invoice_statuses.id', '=', 'invoices.status_id')
                ->leftJoin('currencies', 'currencies.id', '=', 'invoices.currency_id')
                ->leftJoin('invoice_payments', 'invoice_payments.invoice_id', '=', 'invoices.id')
                ->select(
                    'invoices.amount',
                    'invoices.start_date',
                    'invoices.due_date',
                    'invoices.description as invoiceDescription',
                    'clients.name as client',
                    'invoices.id',
                    'invoices.number',
                    'invoice_statuses.name as status',
                    'invoices.description',
                    'currencies.id as currencyID',
                    'currencies.name as currency',
                    'currencies.position',
                    DB::raw('IFNULL(SUM(`invoice_payments`.`payment_amount`), 0) as paid')
                )
                ->where('invoices.client_id', $client->id)
                ->orderBy('due_date', 'desc')
                ->groupBy('invoices.id')
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

    /*	public function save($options = array())
        {
            $this->description = 'Hello';
            parent::save($options);
        }*/
    public function int2str($a)
    {
        $convert = explode('.', $a);
        if (isset($convert[1]) && '' !== $convert[1]) {
            $converta = str_pad($convert[1], 3, 0);

            return $this->int2str($convert[0]).' dinars'.' et '.$this->int2str($converta).' millimes';
        }
        if ($a < 0) {
            return 'moins '.$this->int2str(-$a);
        }
        if ($a < 17) {
            switch ($a) {
                case 0:
                    return '';
                case 1:
                    return 'un';
                case 2:
                    return 'deux';
                case 3:
                    return 'trois';
                case 4:
                    return 'quatre';
                case 5:
                    return 'cinq';
                case 6:
                    return 'six';
                case 7:
                    return 'sept';
                case 8:
                    return 'huit';
                case 9:
                    return 'neuf';
                case 10:
                    return 'dix';
                case 11:
                    return 'onze';
                case 12:
                    return 'douze';
                case 13:
                    return 'treize';
                case 14:
                    return 'quatorze';
                case 15:
                    return 'quinze';
                case 16:
                    return 'seize';
            }
        } elseif ($a < 20) {
            return 'dix-'.$this->int2str($a - 10);
        } elseif ($a < 100) {
            if (0 === $a % 10) {
                switch ($a) {
                    case 20:
                        return 'vingt';
                    case 30:
                        return 'trente';
                    case 40:
                        return 'quarante';
                    case 50:
                        return 'cinquante';
                    case 60:
                        return 'soixante';
                    case 70:
                        return 'soixante-dix';
                    case 80:
                        return 'quatre-vingt';
                    case 90:
                        return 'quatre-vingt-dix';
                }
            } elseif (1 === substr($a, -1)) {
                if (((int) ($a / 10) * 10) < 70) {
                    return $this->int2str((int) ($a / 10) * 10).'-et-un';
                } elseif (71 === $a) {
                    return 'soixante-et-onze';
                } elseif (81 === $a) {
                    return 'quatre-vingt-un';
                } elseif (91 === $a) {
                    return 'quatre-vingt-onze';
                }
            } elseif ($a < 70) {
                return $this->int2str($a - $a % 10).'-'.$this->int2str($a % 10);
            } elseif ($a < 80) {
                return $this->int2str(60).'-'.$this->int2str($a % 20);
            } else {
                return $this->int2str(80).'-'.$this->int2str($a % 20);
            }
        } elseif (100 === $a) {
            return 'cent';
        } elseif ($a < 200) {
            return $this->int2str(100).' '.$this->int2str($a % 100);
        } elseif ($a < 1000) {
            return $this->int2str((int) ($a / 100)).' '.$this->int2str(100).' '.$this->int2str($a % 100);
        } elseif (1000 === $a) {
            return 'mille';
        } elseif ($a < 2000) {
            return $this->int2str(1000).' '.$this->int2str($a % 1000).' ';
        } elseif ($a < 1000000) {
            return $this->int2str((int) ($a / 1000)).' '.$this->int2str(1000).' '.$this->int2str($a % 1000);
        } elseif (1000000 === $a) {
            return 'millions';
        } elseif ($a < 2000000) {
            return $this->int2str(1000000).' '.$this->int2str($a % 1000000).' ';
        } elseif ($a < 1000000000) {
            return $this->int2str((int) ($a / 1000000)).' '.$this->int2str(1000000).' '.$this->int2str($a % 1000000);
        }
    }
}
