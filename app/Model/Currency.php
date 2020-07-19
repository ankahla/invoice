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

class Currency extends Model
{
    public $timestamps = false;

    public function defaultCurrency()
    {
        $query = DB::table('user_settings')
                ->leftJoin('currencies', 'currencies.id', '=', 'user_settings.currency_id')
                ->select('currencies.name', 'currencies.position')
                ->where('user_settings.user_id', Auth::id())
                ->first();

        return $query;
    }
}
