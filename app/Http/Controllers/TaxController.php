<?php

/*
 * This file is part of the Invoice project.
 * (c) Kahla Anouar <kahla.anoir@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Model\Tax;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class TaxController extends Controller
{
    public function store(Request $request)
    {
        $store = new Tax();
        $store->user_id = Auth::id();
        $store->value = $request->get('value');
        $store->save();

        return Redirect::to('setting')->with('message', trans('invoice.data_was_saved'));
    }

    public function update(Request $request, $id)
    {
        $update = Tax::where('id', $id)->where('user_id', Auth::id())->first();
        $update->value = $request->get('value');
        $update->save();

        return Redirect::to('setting')->with('message', trans('invoice.data_was_updated'));
    }

    public function destroy($id)
    {
        $delete = Tax::where('id', $id)->where('user_id', Auth::id());
        $delete->delete();

        return Redirect::to('setting')->with('message', trans('invoice.data_was_deleted'));
    }
}
