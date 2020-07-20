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

class UserSetting extends Model
{
    public $timestamps = false;

    public function checkSettings()
    {
        $email = DB::table('user_settings')
                ->where('user_id', Auth::id())
                ->first();

        $logo = DB::table('images')
                ->where('user_id', Auth::id())
                ->first();

        $tax = DB::table('taxes')
                ->where('user_id', Auth::id())
                ->count();

        $currency = DB::table('currencies')
                ->where('user_id', Auth::id())
                ->count();

        $payment = DB::table('payments')
                ->where('user_id', Auth::id())
                ->count();

        return [
            'email' => $email->email ? 1 : 0,
            'logo' => isset($logo->name) ? 1 : 0,
            'tax' => $tax > 0 ? 1 : 0,
            'currency' => $currency > 0 ? 1 : 0,
            'payment' => $payment > 0 ? 1 : 0,
        ];
    }

    public function defaultLanguage()
    {
        $defaultLanguage = new Language();
        $defaultLanguage->short = 'fr';

        $language = DB::table('user_settings')
                ->join('languages', 'languages.id', '=', 'user_settings.language_id')
                ->select('languages.id', 'languages.name', 'languages.short')
                ->where('user_settings.user_id', Auth::id() ? Auth::id() : 1)
                ->first();

        if (\is_null($language)) {
            $language = Language::all()->last();
        }

        return $language ?? $defaultLanguage;
    }
}
