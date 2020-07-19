<?php

/*
 * This file is part of the Invoice project.
 * (c) Kahla Anouar <kahla.anoir@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Model\General;
use App\Model\Invoice;
use App\Model\Report;
use App\Model\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;

class AdminController extends Controller
{
    public function index()
    {
        $reports = new Report();

        $data = [
            'users' => User::where('role_id', 2)->count(),
            'invoices' => Invoice::all()->count(),
            'usersReport' => $reports->adminUsersReport(),
            'invoicesReport' => $reports->adminInvoicesReport(),
        ];

        $app = General::find(1)->first();

        if (1 === $app->type) {
            return Redirect::to('dashboard');
        }

        return view('admin.index', $data);
    }

    /* === END VIEW === */

    /* === C.R.U.D. === */
    public function update($id)
    {
        $update = User::find($id);
        $update->status = 1;
        $update->save();

        $data = [
            'text' => trans('invoice.your_account_was_approved'),
        ];

        $this->sendEmail($update->email, $data);

        return Redirect::to('user')->with('message', trans('invoice.account_was_approved'));
    }

    public function destroy($id)
    {
        $update = User::find($id);
        $update->status = 2;
        $update->save();

        $data = [
            'text' => trans('invoice.your_account_was_banned'),
        ];

        $this->sendEmail($update->email, $data);

        return Redirect::to('user')->with('message', trans('invoice.account_was_banned'));
    }

    public function application(Request $request)
    {
        $update = General::find(1);
        $update->type = $request->get('value');
        $update->save();

        return Redirect::to('setting')->with('message', trans('invoice.data_was_updated'));
    }

    /* === END C.R.U.D. === */

    /* === OTHERS === */
    private function sendEmail($contactEmail, $values)
    {
        try {
            Mail::send('emails.index', $values, function ($message) use ($contactEmail) {
                $message->from(Auth::user()->email, trans('invoice.app_name'));

                $message->to($contactEmail)->subject(trans('invoice.app_name'));
            });
        } catch (\Swift_TransportException $e) {
        }
    }

    /* === END OTHERS === */
}
