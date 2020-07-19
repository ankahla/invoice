<?php

/*
 * This file is part of the Invoice project.
 * (c) Kahla Anouar <kahla.anoir@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Model\Currency;
use App\Model\UserSetting;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class CurrencyController extends Controller
{
    public function store(Request $request)
    {
        $store = new Currency();
        $store->user_id = Auth::id();
        $store->name = $request->get('value');
        $store->position = 1;
        $store->save();

        return Redirect::to('setting')->with('message', trans('invoice.data_was_saved'));
    }

    public function update(Request $request, $id)
    {
        $update = Currency::where('id', $id)->where('user_id', Auth::id())->first();
        $update->name = $request->get('value');
        $update->save();

        return Redirect::to('setting')->with('message', trans('invoice.data_was_updated'));
    }

    public function destroy($id)
    {
        $delete = Currency::where('id', $id)->where('user_id', Auth::id());
        $delete->delete();

        return Redirect::to('setting')->with('message', trans('invoice.data_was_deleted'));
    }

    /* === END C.R.U.D. === */

    /* === AJAX === */
    public function currencyPosition(Request $request)
    {
        $update = Currency::where('id', $request->get('itemID'))->where('user_id', Auth::id())->first();
        $update->position = $request->get('itemValue');
        $update->save();

        $data = [
            'company' => UserSetting::where('user_id', Auth::id())->first(),
            'currencies' => Currency::where('user_id', Auth::id())->get(),
        ];

        $request->session()->flash('ajaxMessage', trans('invoice.data_was_updated'));

        return view('settings.currency', $data);
    }

    /* === END AJAX === */
}
