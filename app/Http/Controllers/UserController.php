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
use App\Model\User;
use App\Model\UserSetting;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        $data = [
            'users' => User::where('role_id', 1)->orwhere('role_id', 2)->get(),
        ];

        return view('users.index', $data);
    }

    public function create()
    {
        return view('users.create');
    }

    public function show($id)
    {
        $data = [
            'user' => User::find($id),
        ];

        return view('users.show', $data);
    }

    public function edit($id)
    {
        $data = [
            'user' => User::find($id),
        ];

        return view('users.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $update = User::find($id);

        if ('email' === $request->get('action')) {
            $rules = [
                'email' => 'required|email',
                'repeat-email' => 'required|same:email',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->passes()) {
                $update->email = $request->get('email');
            } else {
                return Redirect::to('setting')->with('message', trans('invoice.emails_not_match'))->withErrors($validator);
            }
        }

        if ('password' === $request->get('action')) {
            $rules = [
                'old-password' => 'required|min:6',
                'new-password' => 'required|min:6',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->passes()) {
                if (Hash::check($request->get('old-password'), $update->password)) {
                    $update->password = Hash::make($request->get('new-password'));
                } else {
                    return Redirect::to('setting')->with('message', trans('invoice.old_password_not_match'));
                }
            } else {
                return Redirect::to('setting')->with('message', trans('invoice.validation_error_messages'))->withErrors($validator);
            }
        }

        if ('role' === $request->get('action')) {
            $update->role_id = $request->get('role');
        }

        $update->save();

        return Redirect::to('setting')->with('message', trans('invoice.data_was_updated'));
    }

    public function store(Request $request)
    {
        $rules = [
            'email' => 'required|email',
            'password' => 'required|min:6',
            'password_repeat' => 'required|same:password',
            'role_id' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->passes() && $request->get('password') === $request->get('password_repeat')) {
            $user = new User();
            $user->email = $request->get('email');
            $user->password = Hash::make($request->get('password'));
            $user->role_id = $request->get('role_id');
            $user->status = 0;
            $user->save();

            // create new currency
            $currency = new Currency();
            $currency->user_id = $user->id;
            $currency->name = 'DTN';
            $currency->position = 1;
            $currency->save();

            //settings
            $userSetting = new UserSetting();
            $userSetting->user_id = $user->id;
            $userSetting->currency_id = $currency->id;
            $userSetting->status = 1;
            $userSetting->save();
        } else {
            return Redirect::to('user/create')->with('message', trans('invoice.validation_error_messages'))->withErrors($validator)->withInput();
        }

        return Redirect::to('user')->with('message', trans('invoice.data_was_saved'));
    }

    public function destroy($id)
    {
        $delete = User::find($id);
        $delete->delete();

        return Redirect::to('admin')->with('message', trans('invoice.data_was_deleted'));
    }
}
