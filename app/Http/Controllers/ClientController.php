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
use App\Model\General;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class ClientController extends Controller
{
    public function index()
    {
        $client = new Client();

        $data = [
            'clients' => $client->userClients(),
            'app' => General::find(1)->first(),
        ];

        return view('clients.index', $data);
    }

    public function create()
    {
        return view('clients.create');
    }

    public function show($id)
    {
        $client = new Client();

        $data = [
            'client' => Client::where('id', $id)->where('user_id', Auth::id())->first(),
            'invoices' => $client->details($id),
        ];

        return view('clients.show', $data);
    }

    public function edit($id)
    {
        $data = [
            'client' => Client::where('id', $id)->where('user_id', Auth::id())->first(),
        ];

        return view('clients.edit', $data);
    }

    /* === END VIEW === */

    /* === C.R.U.D. === */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'country' => 'required',
            'city' => 'required',
            'zip' => 'required',
            'address' => 'required',
            'contact' => 'required',
            'email' => 'required|email',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->passes()) {
            $client = new Client();
            $client->user_id = Auth::id();
            $client->name = $request->get('name');
            $client->country = $request->get('country');
            $client->state = $request->get('state');
            $client->city = $request->get('city');
            $client->zip = $request->get('zip');
            $client->address = $request->get('address');
            $client->contact = $request->get('contact');
            $client->phone = $request->get('phone');
            $client->email = $request->get('email');
            $client->website = $request->get('website') ?? '';
            $client->bank = $request->get('bank');
            $client->bank_account = $request->get('bank_account');
            $client->description = $request->get('description');
            $client->save();
        } else {
            return Redirect::to('client/create')->with('message', trans('invoice.validation_error_messages'))->withErrors($validator)->withInput();
        }

        return Redirect::to('client')->with('message', trans('invoice.data_was_saved'));
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'name' => 'required',
            'country' => 'required',
            'city' => 'required',
            'zip' => 'required',
            'address' => 'required',
            'contact' => 'required',
            'email' => 'required|email',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->passes()) {
            $update = Client::where('id', $id)->where('user_id', Auth::id())->first();
            $update->name = $request->get('name');
            $update->country = $request->get('country');
            $update->state = $request->get('state');
            $update->city = $request->get('city');
            $update->zip = $request->get('zip');
            $update->address = $request->get('address');
            $update->contact = $request->get('contact');
            $update->phone = $request->get('phone');
            $update->email = $request->get('email');
            $update->website = $request->get('website') ?? '';
            $update->bank = $request->get('bank');
            $update->bank_account = $request->get('bank_account');
            $update->description = $request->get('description');
            $update->save();
        } else {
            return Redirect::to('client/'.$id.'/edit')->with('message', trans('invoice.validation_error_messages'))->withErrors($validator)->withInput();
        }

        return Redirect::to('client')->with('message', trans('invoice.data_was_updated'));
    }

    public function destroy($id)
    {
        $delete = Client::where('id', $id)->where('user_id', Auth::id());
        $delete->delete();

        return Redirect::to('client')->with('message', trans('invoice.data_was_deleted'));
    }

    /* === END C.R.U.D. === */
}
