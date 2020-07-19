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
use App\Model\General;
use App\Model\Image;
use App\Model\InvoiceSetting;
use App\Model\InvoiceStatus;
use App\Model\Language;
use App\Model\Newsletter;
use App\Model\Payment;
use App\Model\Tax;
use App\Model\UserSetting;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class SettingController extends Controller
{
    public function index()
    {
        $settings = new UserSetting();

        $data = [
            'company' => UserSetting::where('user_id', Auth::id())->first(),
            'logo' => Image::where('user_id', Auth::id())->first(),
            'taxes' => Tax::where('user_id', Auth::id())->get(),
            'invoiceSettings' => InvoiceSetting::where('user_id', Auth::id())->first(),
            'invoiceStatus' => InvoiceStatus::all(),
            'currencies' => Currency::where('user_id', Auth::id())->get(),
            'payments' => Payment::where('user_id', Auth::id())->get(),
            'app' => General::find(1)->first(),
            'languages' => Language::all(),
            'defaultLanguage' => $settings->defaultLanguage(),
            'newsletter' => Newsletter::where('user_id', Auth::id())->first(),
        ];

        if (1 === Auth::user()->role_id) {
            return view('settings.admin', $data);
        }

        return view('settings.index', $data);
    }

    /* === C.R.U.D. === */
    public function update(Request $request, $id)
    {
        $rules = [
            'name' => 'required',
            'country' => 'required',
            'state' => 'required',
            'city' => 'required',
            'zip' => 'required',
            'address' => 'required',
            'contact' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
            'website' => 'url',
        ];

        $validator = Validator::make($request->all(), $rules);
        $data = $request->validate($rules);

        if ($validator->passes()) {
            $update = UserSetting::where('user_id', Auth::id())->first();
            $update->name = $data['name'];
            $update->country = $data['country'];
            $update->state = $data['state'];
            $update->city = $data['city'];
            $update->zip = $data['zip'];
            $update->address = $data['address'];
            $update->contact = $data['contact'];
            $update->phone = $data['phone'];
            $update->email = $data['email'];
            $update->website = $data['website'];
            $update->bank = $request->get('bank');
            $update->bank_account = $request->get('bank_account');
            $update->description = $request->get('description');
            $update->status = 1;
            $update->save();
        } else {
            return Redirect::to('setting')->with('message', trans('invoice.validation_error_messages'))->withErrors($validator)->withInput();
        }

        return Redirect::to('setting')->with('message', trans('invoice.data_was_updated'));
    }

    /* === END C.R.U.D. === */

    /* === OTHERS === */
    public function defaultLanguage(Request $request)
    {
        $rules = [
            'language' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->passes()) {
            $update = UserSetting::where('user_id', Auth::id())->first();
            $update->language_id = $request->get('language');
            $update->save();
        } else {
            return Redirect::to('setting')->with('message', trans('invoice.validation_error_messages'))->withErrors($validator)->withInput();
        }

        return Redirect::to('setting')->with('message', trans('invoice.data_was_updated'));
    }

    /* === END OTHERS === */

    /* === AJAX === */
    public function defaultCurrency(Request $request)
    {
        $update = UserSetting::where('user_id', Auth::id())->first();
        $update->currency_id = $request->get('itemID');
        $update->save();

        $data = [
            'company' => UserSetting::where('user_id', Auth::id())->first(),
            'currencies' => Currency::all(),
        ];

        $request->session()->flash('ajaxMessage', trans('invoice.data_was_updated'));

        return view('settings.currency', $data);
    }

    /* === END AJAX === */
}
